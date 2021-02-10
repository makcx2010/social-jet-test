<?php

namespace frontend\modules\url\controllers;

use core\entities\Url\UrlMapping;
use core\repositories\Url\UrlMappingRepository;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class RedirectController extends Controller
{
    private $urlMappingRepository;

    public function __construct($id, $module, UrlMappingRepository $urlMappingRepository, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->urlMappingRepository = $urlMappingRepository;
    }

    public function actionRedirectToUrl($token): Response
    {
        try {
            $url = $this->urlMappingRepository->getByToken($token);
        } catch (\DomainException $e) {
            throw new NotFoundHttpException($e->getMessage());
        }

        return $this->redirect($url->long_url);
    }
}