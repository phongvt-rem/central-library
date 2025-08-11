<?php

namespace App\Services;

use App\Repositories\Interface\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    protected UserRepositoryInterface $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Create a new user.
     *
     * @param array $userData
     * @return Model
     * @throws \Exception
     */
    public function create(array $userData): Model
    {
        try {
            return $this->userRepository->create($userData);
        } catch (\Exception $exception) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}
