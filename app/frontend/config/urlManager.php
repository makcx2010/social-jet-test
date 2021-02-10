<?php

/** @var $params array */

return [
    'class'           => 'yii\web\UrlManager',
    'hostInfo'        => $params['frontendHostInfo'],
    'baseUrl'         => '',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        ''                                      => 'site/index',

        '<_m:[\w\-]+>/<_c:[\w\-]+>'              => '<_m>/<_c>/index',
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:[\d]+>'   => '<_m>/<_c>/view',
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',

        '/<token:[0-9a-zA-Z\-\_]{16}>' => 'url/redirect/redirect-to-url',
    ],
];
