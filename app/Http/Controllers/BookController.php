<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\AuthorService;
use App\Services\CategoryService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookController extends Controller
{
    protected BookService $book_service;
    protected AuthorService $author_service;
    protected CategoryService $category_service;

    /**
     * Constructor.
     *
     * @param BookService $book_service
     * @param AuthorService $author_service
     * @param CategoryService $category_service
     */
    public function __construct(
        BookService $book_service,
        AuthorService $author_service,
        CategoryService $category_service
    ) {
        $this->book_service = $book_service;
        $this->author_service = $author_service;
        $this->category_service = $category_service;
    }

    /**
     * Display a list of books.
     *
     * @param Request $index_book_request
     * @return View|RedirectResponse
     */
    public function index(Request $index_book_request): View|RedirectResponse
    {
        try {
            $books = $this->book_service->getAll($index_book_request);

            return view('books.index', [
                'books' => $books,
                'author_list' => $this->author_service->getAll(),
                'category_list' => $this->category_service->getAll(),
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect('/')->withErrors('Cannot get the book list right now. Please try again later.');
        }
    }

    /**
     * Show the form to add a new book.
     *
     * @return View|RedirectResponse
     */
    public function add(): View|RedirectResponse
    {
        try {
            return view('books.book-form', [
                'action' => route('books.store'),
                'method' => 'POST',
                'title' => 'Add New Book',
                'author_list' => $this->author_service->getAll(),
                'category_list' => $this->category_service->getAll(),
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Cannot add new book right now. Please try again later.');
        }
    }

    /**
     * Store a newly created book.
     *
     * @param StoreBookRequest $store_book_request
     * @return RedirectResponse
     */
    public function store(StoreBookRequest $store_book_request): RedirectResponse
    {
        try {
            $book_data = $store_book_request->validated();
            $this->book_service->store($book_data);

            return redirect()->route('books.index')->with('success', 'Book created successfully!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Failed to create the book. Please try again.');
        }
    }

    /**
     * Show the form to edit an existing book.
     *
     * @param int $book_id
     * @return View|RedirectResponse
     */
    public function edit(int $book_id): View|RedirectResponse
    {
        try {
            return view('books.book-form', [
                'title' => 'Edit Book',
                'method' => 'PUT',
                'action' => route('books.update', $book_id),
                'author_list' => $this->author_service->getAll(),
                'category_list' => $this->category_service->getAll(),
                'book' => $this->book_service->findById($book_id),
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Cannot edit book right now. Please try again later.');
        }
    }

    /**
     * Update an existing book.
     *
     * @param UpdateBookRequest $update_book_request
     * @param int $book_id
     * @return RedirectResponse
     */
    public function update(UpdateBookRequest $update_book_request, int $book_id): RedirectResponse
    {
        try {
            $book_data = $update_book_request->validated();

            if (isset($book_data['cover_url'])) {
                $this->book_service->update($book_id, $book_data);
            } else {
                $this->book_service->updateWithoutCoverImg($book_id, $book_data);
            }

            return redirect()->route('books.index')->with('success', 'Book edited successfully!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Failed to edit the book. Please try again.');
        }
    }

    /**
     * Delete a book.
     *
     * @param int $book_id
     * @return RedirectResponse
     */
    public function destroy(int $book_id): RedirectResponse
    {
        try {
            $this->book_service->delete($book_id);

            return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Failed to delete the book. Please try again.');
        }
    }
}
