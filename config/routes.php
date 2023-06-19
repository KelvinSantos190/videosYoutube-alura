<?php
return[
    'GET|/' => \Alura\Mvc\Controller\VideoListController::class,
    'GET|/novo-video' => \Alura\Mvc\Controller\VideoFormController::class,
    'POST|/novo-video' => \Alura\Mvc\Controller\NewVideoController::class,
    'GET|/edit-video' => \Alura\Mvc\Controller\VideoFormController::class,
    'POST|/edit-video' => \Alura\Mvc\Controller\EditVideoController::class,
    'GET|/delete-video' => \Alura\Mvc\Controller\DeleteVideoController::class,
    'GET|/login' => \Alura\Mvc\Controller\LoginFormController::class,
    'POST|/login' => \Alura\Mvc\Controller\LoginController::class,
    'GET|/logout' => \Alura\Mvc\Controller\LogoutController::class,
    'GET|/delete-capa' => \Alura\Mvc\Controller\DeleteCapaController::class,
    'GET|/videos-json' => \Alura\Mvc\Controller\JsonVideoListController::class,
    'POST|/videos' => \Alura\Mvc\Controller\NewJsonVideoController::class

];