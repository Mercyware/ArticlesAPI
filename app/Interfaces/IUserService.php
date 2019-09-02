<?php


namespace App\Interfaces;


interface IUserService
{

    public function createUser($attributes);


    public function login($attributes);
}
