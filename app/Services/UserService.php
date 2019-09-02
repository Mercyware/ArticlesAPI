<?php


namespace App\Services;


use App\Interfaces\IUserRepository;
use App\Interfaces\IUserService;
use Illuminate\Support\Facades\Auth;

class UserService implements IUserService
{
    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser($attributes)
    {
        return $this->userRepository->createUser($attributes);
    }

    public function login($attributes)
    {
        if (!Auth::attempt($attributes)) {
            return false;
        }

    }

}
