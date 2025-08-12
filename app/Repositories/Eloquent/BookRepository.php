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
     * @param int $page_size Number of items per page
     * @param array $filter_conditions Optional filters: book_title, author_id, category_id
     * @return LengthAwarePaginator
     */
    public function paginateWithSearch(int $page_size, array $filter_conditions = []): LengthAwarePaginator
    {
        $query = $this->model->with(['author', 'category']);

        if (!empty($filter_conditions['book_title'])) {
            $query->where('title', 'like', '%' . $filter_conditions['book_title'] . '%');
        }

        if (!empty($filter_conditions['author_id']) && (int)$filter_conditions['author_id'] > 0) {
            $query->where('author_id', (int)$filter_conditions['author_id']);
        }

        if (!empty($filter_conditions['category_id']) && (int)$filter_conditions['category_id'] > 0) {
            $query->where('category_id', (int)$filter_conditions['category_id']);
        }

        return $query->paginate($page_size)->withQueryString();
    }
}
