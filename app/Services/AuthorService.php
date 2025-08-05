<?php

namespace App\Services;

use App\Repositories\Interface\AuthorRepositoryInterface;

class AuthorService
{
    protected AuthorRepositoryInterface $authorRepo;

    public function __construct(AuthorRepositoryInterface $authorRepo)
    {
        $this->authorRepo = $authorRepo;
    }

    public function getAllAuthors()
    {
        return $this->authorRepo->all();
    }
}
