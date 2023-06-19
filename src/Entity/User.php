<?php

namespace Alura\Mvc\Entity;

class User
{
    public function __construct(private string $email,private string $password)
    {

    }

    public function getEmail():string
    {
        return $this->email;
    }
}