<?php

namespace console\controllers;

use core\entities\User\User;
use core\entities\User\UserRole;
use core\repositories\User\UserRepository;
use yii\console\Controller;

class AdminController extends Controller
{
    private $userRepository;

    public function __construct($id, $module, UserRepository $userRepository, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->userRepository = $userRepository;
    }

    public function actionCreateAdmin()
    {
        $telegramId       = $this->prompt('Enter telegram id:', ['required' => true]);
        $username       = $this->prompt('Enter username:', ['required' => true]);
        $firstName       = $this->prompt('Enter first name:');
        $lastName    = $this->prompt('Enter last name:');

        $admin = User::create($telegramId, $firstName, $lastName, $username, UserRole::ADMIN);
        $this->userRepository->save($admin);

        $this->stdout("Success!\r\n");
    }
}
