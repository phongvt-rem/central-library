<?php

namespace App\Repositories\Interface;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface BookRepositoryInterface
{
    public function all(): Collection;

    public function find(int $book_id): Model;

    public function create(array $book_data): Model;

    public function update(int $book_id, array $book_data): Model;

    public function delete(int $book_id): int;

    public function paginateWithSearch(int $page_size, array $filter_conditions = []): LengthAwarePaginator;
}
