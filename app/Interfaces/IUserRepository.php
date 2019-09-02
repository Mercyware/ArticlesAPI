<?php


namespace App\Interfaces;


interface IUserRepository
{
    public function createUser($attributes);

    public function getUser(string $email, string $password);
}
