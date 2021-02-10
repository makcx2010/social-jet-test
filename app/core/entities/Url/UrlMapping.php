<?php

namespace core\entities\Url;

use Carbon\Carbon;
use core\entities\BaseEntity;

/**
 * Class Transaction
 *
 * @package core\entities\Url
 * @property integer $id
 * @property string  $token
 * @property string  $long_url
 * @property string  $created_at
 */
class UrlMapping extends BaseEntity
{
    const DEFAULT_TOKEN_LENGTH = 16;

    public static function tableName()
    {
        return 'url_mapping';
    }

    public static function create($token, $longUrl): self
    {
        $urlMapping = new self();
        $urlMapping->token = $token;
        $urlMapping->long_url = $longUrl;
        $urlMapping->created_at = Carbon::now();

        return $urlMapping;
    }
}