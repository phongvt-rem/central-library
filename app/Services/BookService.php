<?php

namespace App\Services;

use App\Repositories\Interface\BookRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class BookService
{
    protected BookRepositoryInterface $book_repository;

    /**
     * Constructor.
     *
     * @param BookRepositoryInterface $book_repository
     */
    public function __construct(BookRepositoryInterface $book_repository)
    {
        $this->book_repository = $book_repository;
    }

    /**
     * Get all books with pagination and search filters.
     *
     * @param Request $index_book_request
     * @return LengthAwarePaginator
     * @throws \Exception
     */
    public function getAll(Request $index_book_request): LengthAwarePaginator
    {
        try {
            return $this->book_repository->paginateWithSearch(8, $index_book_request->only(['book_title', 'category_id', 'author_id']));
        } catch (\Exception $exception) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * Delete a book by ID.
     *
     * @param int $book_id
     * @return int
     * @throws \Exception
     */
    public function delete(int $book_id): int
    {
        try {
            $target_book = $this->book_repository->find($book_id);
            Storage::disk('public')->delete($target_book->cover_url);

            return $this->book_repository->delete($book_id);
        } catch (\Exception $exception) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * Store a new book.
     *
     * @param array $book_data
     * @return Model
     * @throws \Exception
     */
    public function store(array $book_data): Model
    {
        try {
            $cover_img = $book_data['cover_url'];
            $new_cover_img_name = 'book' . now()->format('YmdHis') . '.' . $cover_img->getClientOriginalExtension();
            $cover_img_path = $cover_img->storeAs('cover_img', $new_cover_img_name, 'public');
            $book_data['cover_url'] = $cover_img_path;

            return $this->book_repository->create($book_data);
        } catch (\Exception $exception) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * Find a book by ID.
     *
     * @param int $book_id
     * @return Model
     * @throws \Exception
     */
    public function findById(int $book_id): Model
    {
        try {
            return $this->book_repository->find($book_id);
        } catch (\Exception $exception) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * Update a book including its cover image.
     *
     * @param int $book_id
     * @param array $book_data
     * @return Model
     * @throws \Exception
     */
    public function update(int $book_id, array $book_data): Model
    {
        try {
            $target_book = $this->book_repository->find($book_id);
            Storage::disk('public')->delete($target_book->cover_url);

            $cover_img = $book_data['cover_url'];
            $new_cover_img_name = 'book' . now()->format('YmdHis') . '.' . $cover_img->getClientOriginalExtension();
            $cover_img_path = $cover_img->storeAs('cover_img', $new_cover_img_name, 'public');
            $book_data['cover_url'] = $cover_img_path;

            return $this->book_repository->update($book_id, $book_data);
        } catch (\Exception $exception) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }

    /**
     * Update a book without changing its cover image.
     *
     * @param int $book_id
     * @param array $book_data
     * @return Model
     * @throws \Exception
     */
    public function updateWithoutCoverImg(int $book_id, array $book_data): Model
    {
        try {
            return $this->book_repository->update($book_id, $book_data);
        } catch (\Exception $exception) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $exception->getMessage(),
            ]);

            throw $exception;
        }
    }
}
