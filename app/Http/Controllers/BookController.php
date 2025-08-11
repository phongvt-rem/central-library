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
    protected BookService $bookService;
    protected AuthorService $authorService;
    protected CategoryService $categoryService;

    /**
     * Constructor.
     *
     * @param BookService $bookService
     * @param AuthorService $authorService
     * @param CategoryService $categoryService
     */
    public function __construct(
        BookService $bookService,
        AuthorService $authorService,
        CategoryService $categoryService
    ) {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a list of books.
     *
     * @param Request $indexBookRequest
     * @return View|RedirectResponse
     */
    public function index(Request $indexBookRequest): View|RedirectResponse
    {
        try {
            $books = $this->bookService->getAllBooks($indexBookRequest);

            return view('books.index', [
                'books' => $books,
                'author_list' => $this->authorService->getAllAuthors(),
                'category_list' => $this->categoryService->getAllCategories(),
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
                'author_list' => $this->authorService->getAllAuthors(),
                'category_list' => $this->categoryService->getAllCategories(),
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Cannot add new book right now. Please try again later.');
        }
    }

    /**
     * Store a newly created book.
     *
     * @param StoreBookRequest $storeBookrequest
     * @return RedirectResponse
     */
    public function store(StoreBookRequest $storeBookrequest): RedirectResponse
    {
        try {
            $bookData = $storeBookrequest->validated();
            $this->bookService->storeBook($bookData);

            return redirect()->route('books.index')->with('success', 'Book created successfully!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Failed to create the book. Please try again.');
        }
    }

    /**
     * Show the form to edit an existing book.
     *
     * @param int $bookId
     * @return View|RedirectResponse
     */
    public function edit(int $bookId): View|RedirectResponse
    {
        try {
            return view('books.book-form', [
                'title' => 'Edit Book',
                'method' => 'PUT',
                'action' => route('books.update', $bookId),
                'author_list' => $this->authorService->getAllAuthors(),
                'category_list' => $this->categoryService->getAllCategories(),
                'book' => $this->bookService->findBookById($bookId),
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Cannot edit book right now. Please try again later.');
        }
    }

    /**
     * Update an existing book.
     *
     * @param UpdateBookRequest $updateBookRequest
     * @param int $bookId
     * @return RedirectResponse
     */
    public function update(UpdateBookRequest $updateBookRequest, int $bookId): RedirectResponse
    {
        try {
            $bookData = $updateBookRequest->validated();

            if (isset($bookData['cover_url'])) {
                $this->bookService->updateBook($bookId, $bookData);
            } else {
                $this->bookService->updateBookWithoutCoverImg($bookId, $bookData);
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
     * @param int $bookId
     * @return RedirectResponse
     */
    public function destroy(int $bookId): RedirectResponse
    {
        try {
            $this->bookService->deleteBook($bookId);

            return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('books.index')->with('error', 'Failed to delete the book. Please try again.');
        }
    }
}
