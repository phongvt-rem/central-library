<?php

namespace App\Services;

use App\Repositories\Interface\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    protected UserRepositoryInterface $user_repository;

    /**
     * Constructor.
     *
     * @param UserRepositoryInterface $user_repository
     */
    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * Create a new user.
     *
     * @param array $user_data
     * @return Model
     * @throws \Exception
     */
    public function create(array $user_data): Model
    {
        try {
            return $this->user_repository->create($user_data);
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
