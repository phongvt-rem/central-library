<?php

namespace App\Services;

use App\Repositories\Interface\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class AuthorService
{
    protected AuthorRepositoryInterface $authorRepo;

    /**
     * Constructor.
     *
     * @param AuthorRepositoryInterface $authorRepo
     */
    public function __construct(AuthorRepositoryInterface $authorRepo)
    {
        $this->authorRepo = $authorRepo;
    }

    /**
     * Get all authors.
     *
     * @return Collection
     * @throws \Exception
     */
    public function getAllAuthors(): Collection
    {
        try {
            return $this->authorRepo->all();
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
