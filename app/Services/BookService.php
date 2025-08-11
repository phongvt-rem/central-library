<?php

namespace App\Services;

use App\Repositories\Interface\BookRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BookService
{
    protected BookRepositoryInterface $bookRepo;

    /**
     * Constructor.
     *
     * @param BookRepositoryInterface $bookRepo
     */
    public function __construct(BookRepositoryInterface $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    /**
     * Get all books with pagination and search filters.
     *
     * @param mixed $request
     * @return mixed
     * @throws \Exception
     */
    public function getAllBooks($request)
    {
        try {
            return $this->bookRepo->paginateWithSearch(8, $request->only(['book_title', 'category_id', 'author_id']));
        } catch (\Exception $e) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Delete a book by ID.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function deleteBook($id)
    {
        try {
            $target_book = $this->bookRepo->find($id);
            Storage::disk('public')->delete($target_book->cover_url);

            return $this->bookRepo->delete($id);
        } catch (\Exception $e) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Store a new book.
     *
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function storeBook(array $data)
    {
        try {
            $file = $data['cover_url'];
            $fileName = 'book' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('cover_img', $fileName, 'public');
            $data['cover_url'] = $path;

            return $this->bookRepo->create($data);
        } catch (\Exception $e) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Find a book by ID.
     *
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function findBookById($id)
    {
        try {
            return $this->bookRepo->find($id);
        } catch (\Exception $e) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Update a book including its cover image.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function updateBook(int $id, array $data)
    {
        try {
            $target_book = $this->bookRepo->find($id);
            Storage::disk('public')->delete($target_book->cover_url);

            $file = $data['cover_url'];
            $fileName = 'book' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('cover_img', $fileName, 'public');
            $data['cover_url'] = $path;

            return $this->bookRepo->update($id, $data);
        } catch (\Exception $e) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Update a book without changing its cover image.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function updateBookWithoutCoverImg(int $id, array $data)
    {
        try {
            return $this->bookRepo->update($id, $data);
        } catch (\Exception $e) {
            Log::error('ERROR: ', [
                'method' => __METHOD__,
                'line' => __LINE__,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
