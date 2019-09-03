<?php


namespace App\Services;


use App\Interfaces\IUserRepository;
use App\Interfaces\IUserService;
use Carbon\Carbon;
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
            return null;
        }

        $user = $this->userRepository->getUserByEmail($attributes['email']);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
        return $tokenResult;
    }

}
