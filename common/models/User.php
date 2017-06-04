<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;
/*
	public $phone;
	public $email;
	public $address;
	public $status;
	public $status_message;
*/
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user}}';
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['status', 'default', 'value' => self::STATUS_ACTIVE],
			['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
			['username', 'trim'],
			['username', 'required'],
			['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '此用户名已被注册！'],
			['username', 'string', 'min' => 2, 'max' => 255],

			['email', 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'string', 'max' => 255],
			['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '此邮箱已被注册！'],

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
	 * add attribute labels
	 *
	 */
	public function attributeLabels() {
		return [
			'username'  => '用户名',
			'name'      => '姓名',
			'email'     => '电子邮箱',
			'phone'     => '手机号',
			'address'   => '地址',
			'status_message'	=> '状态',
			'role'		=> '用户类型',
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentity($id)
	{
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * @inheritdoc
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return static|null
	 */
	public static function findByUsernameAndRole($username,$role)
	{
		return static::findBySql("SELECT * FROM `user` WHERE `username`='{$username}' AND `status`='{$status}' AND `role`<>'{$role}'")->one();
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
				'password_reset_token' => $token,
				'status' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return boolean
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];
		return $timestamp + $expire >= time();
	}

	/**
	 * @inheritdoc
	 */
	public function getId()
	{
		return $this->getPrimaryKey();
	}

	/**
	 * @inheritdoc
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @inheritdoc
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return boolean if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	/**
	 * Generates password hash from password and sets it to the model
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

	/**
	 * @desc create new user
	 * @date 2017_05_15
	 */
	public function createNewUser($params) {
		if (empty($params['created_at'])) {
			$params['created_at'] = time();
		}
		if (empty($params['updated_at'])) {
			$params['updated_at'] = time();
		}

		$sql = "insert into user (pname,name,pwd,address,email,phone,type,ctime,utime,is_delete)
			values ('{$params['pname']}','{$params['name']}','{$params['pwd']}','{$params['address']}',
					'{$params['email']}','{$params['phone']}','{$params['type']}','{$params['created_at']}',
					'{$params['updated_at']}','{$params['is_delete']}')";
		$re = Yii::$app->db->createCommand($sql)->execute;
		return $re;
	}

	/**
	 * @desc update user
	 * @date 2017_05_15
	 */
	public function updateUser($params) {
		if (empty($params['updated_at'])) {
			$params['updated_at'] = time();
		}

		$sql = "update user set ";

		foreach ($params as $k => $v) {
			if($k != 'id')
				$sql .= $k."='".$v."',";
		}

		$sql = rtrim($sql, ",") . " where id = '{$params['id']}'";
		$re = Yii::$app->db->createCommand($sql)->execute();
		return $re;
	}

	/**
	 * @desc select user by id
	 * @date 2017_05_15
	 */
	public function selectUserById($id) {
		$sql = "select * from user where id = '{$id}'";
		$re = Yii::$app->db->createCommand($sql)->queryOne();
		return $re;
	}

	/**
	  * @desc select user list
	  * @date 2017_05_15
	  */
	public function fetchUserList() {
		$sql = "select * from user order by id asc";
		$re = Yii::$app->db->createCommand($sql)->queryAll();
		return $re;
	}
}
