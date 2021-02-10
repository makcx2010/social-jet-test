<?php

namespace core\queries\User;

use core\entities\User\UserRole;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    /**
     * @param string $alias
     *
     * @return ActiveQuery
     */
    public function active($alias = ''): ActiveQuery
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'status' => UserRole::ACTIVE]);
    }
}
