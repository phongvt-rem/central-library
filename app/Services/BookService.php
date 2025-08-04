<?php

namespace App\Services;

use App\Repositories\Interface\BookRepositoryInterface;

class BookService
{
    protected BookRepositoryInterface $bookRepo;

    public function __construct(BookRepositoryInterface $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    public function getAllBooks()
    {
        return $this->bookRepo->all();
    }
}