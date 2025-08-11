<?php

namespace App\Services;

use App\Repositories\Interface\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class CategoryService
{
    protected CategoryRepositoryInterface $categoryRepo;

    /**
     * Constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepo
     */
    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Get all categories.
     *
     * @return Collection
     * @throws \Exception
     */
    public function getAllCategories(): Collection
    {
        try {
            return $this->categoryRepo->all();
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
