<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Repositories\Interface\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * The Category model instance.
     *
     * @var Category
     */
    protected $model;

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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }
}
