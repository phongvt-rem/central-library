<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Models\Book;
use App\Repositories\Interface\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    public function paginateWithSearch(int $size, ?string $textSearch = null)
    {
        $query = $this->model->with(['author', 'category']);
        if ($textSearch){
            $query->where('title', 'like', '%' . $textSearch . '%');
        }

        return $query->paginate($size)->withQueryString();
    }
}