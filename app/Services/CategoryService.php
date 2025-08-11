<?php

namespace App\Services;

use App\Repositories\Interface\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Log;

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
     * @return mixed
     * @throws \Exception
     */
    public function getAllCategories()
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
