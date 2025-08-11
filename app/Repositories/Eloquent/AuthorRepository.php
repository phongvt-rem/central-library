<?php

namespace App\Repositories\Eloquent;

use App\Models\Author;
use App\Repositories\Interface\AuthorRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{
    protected Author $model;

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
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }
}
