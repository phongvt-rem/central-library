<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Models\Book;
use App\Repositories\Interface\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * @param int $pageSize Number of items per page
     * @param array $filterConditions Optional filters: book_title, author_id, category_id
     * @return LengthAwarePaginator
     */
    public function paginateWithSearch(int $pageSize, array $filterConditions = []): LengthAwarePaginator
    {
        $query = $this->model->with(['author', 'category']);

        if (!empty($filterConditions['book_title'])) {
            $query->where('title', 'like', '%' . $filterConditions['book_title'] . '%');
        }

        if (!empty($filterConditions['author_id']) && (int)$filterConditions['author_id'] > 0) {
            $query->where('author_id', (int)$filterConditions['author_id']);
        }

        if (!empty($filterConditions['category_id']) && (int)$filterConditions['category_id'] > 0) {
            $query->where('category_id', (int)$filterConditions['category_id']);
        }

        return $query->paginate($pageSize)->withQueryString();
    }
}
