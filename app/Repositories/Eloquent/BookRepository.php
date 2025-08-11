<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Models\Book;
use App\Repositories\Interface\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    /**
     * Constructor.
     *
     * @param Book $model
     */
    public function __construct(Book $model)
    {
        parent::__construct($model);
    }

    /**
     * Get paginated list of books with optional search and filters.
     *
     * @param int $size Number of items per page
     * @param array $filters Optional filters: book_title, author_id, category_id
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginateWithSearch(int $size, array $filters = [])
    {
        $query = $this->model->with(['author', 'category']);

        if (!empty($filters['book_title'])) {
            $query->where('title', 'like', '%' . $filters['book_title'] . '%');
        }

        if (!empty($filters['author_id']) && (int)$filters['author_id'] > 0) {
            $query->where('author_id', (int)$filters['author_id']);
        }

        if (!empty($filters['category_id']) && (int)$filters['category_id'] > 0) {
            $query->where('category_id', (int)$filters['category_id']);
        }

        return $query->paginate($size)->withQueryString();
    }
}
