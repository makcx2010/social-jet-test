<?php

namespace core\entities\User;

use core\utilities\Enum\Enum;

class UserRole extends Enum
{
    const ADMIN = 'admin';
    const USER = 'user';

    public static function getAllAsArray(): array
    {
        return [
            self::ADMIN => \Yii::t('entity/user_role', 'Admin'),
            self::USER  => \Yii::t('entity/user_role', 'User'),
        ];
    }
}
