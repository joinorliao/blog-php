<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property int $id
 * @property string $name
 * @property int|null $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'frequency' => 'Frequency',
        ];
    }
    public static function stringToArray($tagName)
    {
        return preg_split('/\s*,\s*/', trim($tagName), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function arrayToString($tags)
    {
        return implode(', ', $tags);
    }

    public static function addTags($tags)
    {
        if(empty($tags)) return ;

        foreach ($tags as $name)
        {
            $aTag = Tag::findOne(['name'=>$name])->one();
            $aTagCount = Tag::find()->where(['name'=>$name])->count();

            if(!$aTagCount){
                $Tag = new Tag;
                $Tag->name = $name;
                $Tag->frequency = 1;
                $Tag->save();
            }else{
                $aTag->frequency += 1;
                $aTag->save();
            }
        }


    }

    public static function removeTags($tags)
    {
        if(empty($tags)) return ;

        foreach ($tags as $name)
        {
            $aTag = Tag::findOne(['name'=>$name])->one();
            $aTagCount = Tag::find()->where(['name'=>$name])->count();

            if($aTagCount){
                if($aTag->frequency > 1 && $aTagCount){
                    $aTag->frequency -= 1;
                    $aTag->save();
                }else{
                    $aTag->delete();
                }
            }
        }

    }
    public static function updateFrequency($oldTags, $newTags)
    {
        if(!empty($oldTags) && !empty($newTags)){
            $oldTagsArray = self::stringToArray($oldTags);
            $newTagsArray = self::stringToArray($newTags);

            self::addTags(array_values(array_diff($newTagsArray, $oldTagsArray)));
            self::removeTags(array_values(array_diff($oldTagsArray, $newTagsArray)));
        }
    }


}
