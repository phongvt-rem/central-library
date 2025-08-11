<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interface\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected Category $model;

    /**
     * Constructor.
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Retrieve all categories.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}
