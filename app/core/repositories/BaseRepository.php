<?php

namespace core\repositories;


use core\entities\BaseEntity;

abstract class BaseRepository
{
    public function get($id): BaseEntity
    {
        return $this->getBy(['id' => $id]);
    }

    /**
     * @param BaseEntity $entity
     */
    public function save(BaseEntity $entity): void
    {
        if (!$entity->save()) {
            throw new \RuntimeException('Saving errors: ' . json_encode($entity->getErrors()));
        }
    }

    /**
     * @param BaseEntity $entity
     * @throws \Throwable
     */
    public function remove(BaseEntity $entity): void
    {
        try {
            $entity->delete();
        } catch (\Exception $e) {
            throw new \RuntimeException('Removing errors: ' . $e->getMessage(), 0, $e);
        }
    }

    abstract protected function getEntityClass(): string;

    protected function getBy(array $conditions): BaseEntity
    {
        if (!$entity = ($this->getEntityClass())::find()->andWhere($conditions)->limit(1)->one()) {
            throw new NotFoundException($conditions, \Yii::t('domain', '{entity} is not found', ['entity' => $this->getEntityLabel()]));
        }

        return $entity;
    }

    abstract protected function getEntityLabel();
}
