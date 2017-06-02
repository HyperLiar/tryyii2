<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
	public $phone;
	public $email;
	public $name;
	public $address;
    private $_user;

	public $is_back;

	const ROLE_NORMAL_AUTHOR = 10;
	const ROLE_NORMAL_EDITOR = 20;
	const ROLE_EXPERT = 30;
	const ROLE_CHEIF_EDITOR = 40;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '错误的用户名或密码');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
			if ($this->is_back == 1) {
				$this->_user = User::findByUsernameAndRole($this->username,self::ROLE_NORMAL_AUTHOR);
			} else {
				$this->_user = User::findByUsername($this->username);
			}
        }
		
        return $this->_user;
    }

	/**
	 * set attributes
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
