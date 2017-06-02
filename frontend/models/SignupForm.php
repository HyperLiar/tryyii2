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


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '此用户名已被注册！'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '此邮箱已被注册！'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

			['phone', 'trim'],
			['phone', 'required'],
			['phone', 'string', 'min' => 8, 'max' => 16],

			['name', 'trim'],
			['name', 'required'],
			['name', 'string', 'min' => 1, 'max' => 20],

			['address', 'string', 'min' => 0, 'max' => '50'],
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
        $user->setPassword($this->password);
        $user->generateAuthKey();
		$user->phone = $this->phone;
		$user->name = $this->name;
		$user->address = $this->address;
		$user->created_at = time();
		$user->updated_at = time();
        
        return $user->save() ? $user : null;
    }

	/**
	  * add attribute labels
	  *
	  */
	public function attributeLabels() {
		return [
			'username'	=> '用户名',
			'password'	=> '密码',
			'name'		=> '姓名',
			'email'		=> '电子邮箱',
			'phone'		=> '手机号',
			'address'	=> '地址',
		];
	}
}
