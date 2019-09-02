<?php


namespace App\Interfaces;


interface IUserRepository
{
    public function createUser($attributes);

    public function getUserByEmail(string $email);
}
