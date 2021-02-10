<?php

namespace core\entities;

use yii\db\ActiveRecord;

/**
 * Class BaseEntity
 * @package core\entities
 *
 * @property int $id
 */
class BaseEntity extends ActiveRecord
{
    const DATE_FORMAT     = 'Y-m-d';
    const DATETIME_FORMAT = 'Y-m-d H:i:s';

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
        ];
    }
}