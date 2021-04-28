<?php

namespace Lesson5\User\Controller;

use Lesson5\Core\Controller\AbstractController;
use Lesson5\User\View\Message;
use Lesson5\User\Model\User as UserModel;
use Lesson5\User\View\User as UserView;

class User extends AbstractController
{
    public function indexAction()
    {
        echo "Hello!";
    }

    public function showNameAction()
    {
        if (!isset($_GET['id'])) {
            throw new \Exception("No id!");
        }
        $userId = (int) $_GET['id'];
        $view = new Message();
        if (!$userId) {
            $view->setData(['message' => 'Не получили ID'])->show();
            return;
        }
        $user = new UserModel();
        $view->setData(
            [
                'message' =>
                    $user->getUserExists($userId) ?
                    $user->getNameById($userId)
                    : 'Пользователь не найден'
            ]
        )->show();
    }

    public function showUserAction()
    {
        if (!isset($_GET['id'])) {
            throw new \Exception("No id!");
        }
        $userId = (int) $_GET['id'];
        if ($userId) {
            $user = new UserModel();
            echo new UserView(['user' => $user->getById($userId)->getData()]);
        }
    }

    public function addUserAction()
    {
        if (!isset($_GET['name'])) {
            throw new \Exception("No name!");
        }
        $userName = $_GET['name'];
        $view = new Message();
        if (!$userName) {
            $view->setData(['message' => 'Данные неполные'])->show();
            return;
        }
        $user = new UserModel();
        $user->setData('name', $userName)->save();
        $view->setData(['message' => 'Пользователь добавлен'])->show();
    }
}