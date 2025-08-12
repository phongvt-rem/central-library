<?php

namespace App\Services;

use App\Repositories\Interface\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class CategoryService
{
    protected CategoryRepositoryInterface $category_repository;

    /**
     * Constructor.
     *
     * @param CategoryRepositoryInterface $category_repository
     */
    public function __construct(CategoryRepositoryInterface $category_repository)
    {
        $this->category_repository = $category_repository;
    }

    /**
     * Get all categories.
     *
     * @return Collection
     * @throws \Exception
     */
    public function getAll(): Collection
    {
        try {
            return $this->category_repository->all();
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
