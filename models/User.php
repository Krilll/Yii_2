<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $auth_key
 * @property int $creator_id
 * @property int $updater_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Task[] $tasks
 * @property Task[] $tasks0 
 * @property TaskUser[] $taskUsers
 */
 
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
	public $password;
	
	const SCENARIO_CREATE = 'create';
	const SCENARIO_UPDATE = 'update';
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }
	
	public function behaviors()
    {
        return [
			[
				'class' => BlameableBehavior::className(),
				'createdByAttribute' => 'creator_id',
				'updatedByAttribute' => 'updater_id',
			],
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
	
	/**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
	
    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
		return false;
        //return static::findOne(['access_token' => $token]);
    }

	/**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required', 'on' => 'create'],
			[['username'], 'required', 'on' => 'update'],
            [['creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'auth_key' => 'Auth Key',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['creator_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['updater_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskUsers()
    {
        return $this->hasMany(TaskUser::className(), ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\UserQuery(get_called_class());
    }
	
	public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
			if ($this->password) {			
				$this->password_hash = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
			}
			if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
	
	/**
     * Validates password
     *
     * @param string $password password to validate
     * @return true if password provided is valid for current user
	 * @return false if password provided is not valid for current user
     */
	public function validatePassword($password) {
		return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);		
	}
	
	 /**
     * Finds user by username
     *
     * @param string $name
     * @return static|null
     */
	public function findByUsername($name) {
		return static::findOne(['username' => $name]);
	}
}
