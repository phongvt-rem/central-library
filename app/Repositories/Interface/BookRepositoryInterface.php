<?php

namespace App\Repositories\Interface;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface BookRepositoryInterface
{
    public function all(): Collection;

    public function find(int $bookId): Model;

    public function create(array $bookData): Model;

    public function update(int $bookId, array $bookData): Model;

    public function delete(int $bookId): int;

    public function paginateWithSearch(int $pageSize, array $filterConditions = []): LengthAwarePaginator;
}
