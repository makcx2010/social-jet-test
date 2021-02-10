<?php

namespace core\entities\User;

use Carbon\Carbon;
use core\entities\BaseEntity;
use core\queries\User\UserQuery;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\web\IdentityInterface;
use core\entities\User\UserRole as UserStatus;

/**
 * Class User
 *
 * @package entities\User
 * @property int         $id
 * @property int         $telegram_id
 * @property string      $role
 * @property string      $username
 * @property string      $first_name
 * @property string      $last_name
 * @property string      $created_at
 */
class User extends BaseEntity
{
    public static function tableName(): string
    {
        return 'users';
    }

    public function attributeLabels()
    {
        return [
            'email'      => Yii::t('entity/user', 'Email'),
            'status'     => Yii::t('entity/user', 'Status'),
            'created_at' => Yii::t('entity/user', 'Created at'),
            'updated_at' => Yii::t('entity/user', 'Updated at'),
            'company'    => Yii::t('entity/user', 'Company')
        ];
    }

    public static function create($telegramId, $firstName, $lastName, $username = '', $role = UserRole::USER): self
    {
        $user = new self();
        $user->telegram_id = $telegramId;
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->role = $role;
        $user->username = $username;

        return $user;
    }

    public function isAdmin(): bool {
        return $this->role === UserStatus::ADMIN;
    }

    public function isUser(): bool {
        return $this->role === UserStatus::USER;
    }
}
