<?php

namespace core\repositories\Url;

use core\entities\Url\UrlMapping;
use core\repositories\BaseRepository;

class UrlMappingRepository extends BaseRepository
{
    public function getByToken($token): UrlMapping
    {
        return $this->getBy(['token' => $token]);
    }

    protected function getEntityClass(): string
    {
        return UrlMapping::class;
    }

    protected function getEntityLabel()
    {
        return 'Url mapping';
    }
}