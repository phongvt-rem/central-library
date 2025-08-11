<?php

namespace App\Repositories\Interface;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Book;

interface BookRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): Book;

    public function create(array $data): Book;

    public function update(int $id, array $data): Book;

    public function delete(int $id): int;

    public function paginateWithSearch(int $size, array $filters = []): LengthAwarePaginator;
}
