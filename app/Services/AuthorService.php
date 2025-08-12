<?php

namespace App\Services;

use App\Repositories\Interface\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class AuthorService
{
    protected AuthorRepositoryInterface $author_repository;

    /**
     * Constructor.
     *
     * @param AuthorRepositoryInterface $author_repository
     */
    public function __construct(AuthorRepositoryInterface $author_repository)
    {
        $this->author_repository = $author_repository;
    }

    /**
     * Get all authors.
     *
     * @return Collection
     * @throws \Exception
     */
    public function getAll(): Collection
    {
        try {
            return $this->author_repository->all();
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
