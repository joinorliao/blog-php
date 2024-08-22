<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Adminuser;

/**
 * Signup form
 */
class SignupForm extends Model
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
            ['username', 'trim'],
            ['username', 'required'],
                ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['password_repeat', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致'],
            ['nickname', 'required'],
            ['nickname', 'string',  'max' => 128],
            ['profile', 'string']

        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Username',
            'nickname' => 'Nickname',
            'password' => 'Password',
            'password_repeat' => 'Password Repeat',
            'email' => 'Email',
            'profile' => 'Profile',
        ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new Adminuser();
        $user->username = $this->username;
        $user->nickname = $this->nickname;
        $user->email = $this->email;
        $user->profile = $this->profile;

        $user->setPassword($this->password);
        $user->generateAuthKey();
        //$user->generateEmailVerificationToken();
        $user->password = '1' ;
        return $user->save() ? true : null;
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
