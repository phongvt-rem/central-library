<?php

namespace App\Repositories\Interface;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Book;

interface BookRepositoryInterface
{
    public function all(): Collection;

    public function find(int $bookId): Book;

    public function create(array $bookData): Book;

    public function update(int $bookId, array $bookData): Book;

    public function delete(int $bookId): int;

    public function paginateWithSearch(int $pageSize, array $filterConditions = []): LengthAwarePaginator;
}
