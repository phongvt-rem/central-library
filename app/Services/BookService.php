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
    protected BookRepositoryInterface $bookRepository;

    /**
     * Constructor.
     *
     * @param BookRepositoryInterface $bookRepository
     */
    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Get all books with pagination and search filters.
     *
     * @param Request $indexBookRequest
     * @return LengthAwarePaginator
     * @throws \Exception
     */
    public function getAll(Request $indexBookRequest): LengthAwarePaginator
    {
        try {
            return $this->bookRepository->paginateWithSearch(8, $indexBookRequest->only(['book_title', 'category_id', 'author_id']));
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
     * @param int $bookId
     * @return int
     * @throws \Exception
     */
    public function delete(int $bookId): int
    {
        try {
            $target_book = $this->bookRepository->find($bookId);
            Storage::disk('public')->delete($target_book->cover_url);

            return $this->bookRepository->delete($bookId);
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
     * @param array $bookData
     * @return Model
     * @throws \Exception
     */
    public function store(array $bookData): Model
    {
        try {
            $coverImg = $bookData['cover_url'];
            $newCoverImgName = 'book' . now()->format('YmdHis') . '.' . $coverImg->getClientOriginalExtension();
            $coverImgPath = $coverImg->storeAs('cover_img', $newCoverImgName, 'public');
            $bookData['cover_url'] = $coverImgPath;

            return $this->bookRepository->create($bookData);
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
     * @param int $bookId
     * @return Model
     * @throws \Exception
     */
    public function findById(int $bookId): Model
    {
        try {
            return $this->bookRepository->find($bookId);
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
     * @param int $bookId
     * @param array $bookData
     * @return Model
     * @throws \Exception
     */
    public function update(int $bookId, array $bookData): Model
    {
        try {
            $target_book = $this->bookRepository->find($bookId);
            Storage::disk('public')->delete($target_book->cover_url);

            $coverImg = $bookData['cover_url'];
            $newCoverImgName = 'book' . now()->format('YmdHis') . '.' . $coverImg->getClientOriginalExtension();
            $coverImgPath = $coverImg->storeAs('cover_img', $newCoverImgName, 'public');
            $bookData['cover_url'] = $coverImgPath;

            return $this->bookRepository->update($bookId, $bookData);
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
     * @param int $bookId
     * @param array $bookData
     * @return Model
     * @throws \Exception
     */
    public function updateWithoutCoverImg(int $bookId, array $bookData): Model
    {
        try {
            return $this->bookRepository->update($bookId, $bookData);
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
