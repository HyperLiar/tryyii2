<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $phone;
    public $name;
    public $address;
    public $type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '已存在相同的笔名！'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '邮箱已经注册过！'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'message' => '手机号已被注册过！'],
            ['phone', 'string', 'max' => 13],

            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'max' => 30],

            ['address', 'trim'],
            ['adddress', 'string', 'max' => 300],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->address = $this->address;
        $user->type = $this->type;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
