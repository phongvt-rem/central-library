<?php

namespace App\Services;

use App\Repositories\Interface\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    protected UserRepositoryInterface $userRepo;

    /**
     * Constructor.
     *
     * @param UserRepositoryInterface $userRepo
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return Model
     * @throws \Exception
     */
    public function createUser(array $data): Model
    {
        try {
            return $this->userRepo->create($data);
        } catch (\Exception $e) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
