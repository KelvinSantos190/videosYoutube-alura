<?php

namespace Alura\Mvc\Helper;

trait FlashMessageTrait
{
    private function addErrorMessage( string $erroMessage):void
    {
        $_SESSION['error_message'] =$erroMessage;
    }
}