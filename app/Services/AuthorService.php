<?php

namespace App\Services;

use App\Repositories\Interface\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class AuthorService
{
    protected AuthorRepositoryInterface $authorRepository;

    /**
     * Constructor.
     *
     * @param AuthorRepositoryInterface $authorRepository
     */
    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
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
            return $this->authorRepository->all();
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
