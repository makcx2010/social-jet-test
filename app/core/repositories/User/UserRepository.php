<?php

namespace core\repositories\User;

use core\entities\User\User;
use core\repositories\BaseRepository;
use core\repositories\NotFoundException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use core\entities\User\UserRole as UserStatus;

class UserRepository extends BaseRepository
{
    public function getByTelegramId($telegramId):? User {
        return User::find()->andWhere(['telegram_id' => $telegramId])->one();
    }

    protected function getEntityClass(): string
    {
        return User::class;
    }

    protected function getEntityLabel()
    {
        return \Yii::t('entity', 'user');
    }
}
