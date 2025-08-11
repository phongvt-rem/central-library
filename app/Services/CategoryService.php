<?php

namespace App\Services;

use App\Repositories\Interface\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class CategoryService
{
    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * Constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
            return $this->categoryRepository->all();
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
