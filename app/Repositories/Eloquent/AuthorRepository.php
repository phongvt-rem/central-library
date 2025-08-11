<?php

namespace App\Repositories\Eloquent;

use App\Models\Author;
use App\Repositories\Interface\AuthorRepositoryInterface;

class AuthorRepository implements AuthorRepositoryInterface
{
    protected $model;

    /**
     * Constructor.
     *
     * @param Author $model
     */
    public function __construct(Author $model)
    {
        $this->model = $model;
    }

    /**
     * Get all authors.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }
}
