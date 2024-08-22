<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Adminuser;

/**
 * Signup form
 */
class ResetpwdForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $nickname;
    public $profile;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['password_repeat', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致'],

        ];
    }

    public function attributeLabels()
    {
        return [

            'password' => 'Password',
            'password_repeat' => 'Password Repeat',

        ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function resetPassword($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $admuser = Adminuser::findOne($id);
        $admuser->setPassword($this->password);
        $admuser->removePasswordResetToken();

        return $admuser->save() ? true : null;
    }

    /**
     * Sends confirmation email to user
     * @param Adminuser $user Adminuser model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
