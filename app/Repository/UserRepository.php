<?php


namespace App\Repository;


use App\Interfaces\IUserRepository;
use App\User;

class UserRepository implements IUserRepository
{

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUser($attributes)
    {
        return $this->user->create([
            'name' => $attributes->name,
            'email' => $attributes->email,
            'password' => bcrypt($attributes->password)
        ]);

    }

    public function getUser(string $email, string $password)
    {

    }
}
