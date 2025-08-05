<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\AuthorService;
use App\Services\CategoryService;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;

class BookController extends Controller
{
    protected BookService $bookService;
    protected AuthorService $authorService;
    protected CategoryService $categoryService;

    public function __construct(
        BookService $bookService,
        AuthorService $authorService,
        CategoryService $categoryService
    ) {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $books = $this->bookService->getAllBooks();

        return view('books.index', compact('books'));
    }

    public function add()
    {
        return view('books.book-form', [
            'action' => route('books.store'),
            'method' => 'POST',
            'title' => 'Add New Book',
            'author_list' => $this->authorService->getAllAuthors(),
            'category_list' => $this->categoryService->getAllCategories(),
        ]);
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $this->bookService->storeBook($data);

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    public function edit($id)
    {
        return view('books.book-form', [
            'title' => 'Edit Book',
            'method' => 'PUT',
            'action' => route('books.update', $id),
            'author_list' => $this->authorService->getAllAuthors(),
            'category_list' => $this->categoryService->getAllCategories(),
            'book' => $this->bookService->findBookById($id),
        ]);
    }

    public function update(UpdateBookRequest $request, int $id)
    {
        $data = $request->validated();
        if(isset($data['cover_url'])){
            $this->bookService->updateBook($id, $data);
        } else {
            $this->bookService->updateBookWithoutCoverImg($id, $data);
        }

        return redirect()->route('books.index')->with('success', 'Book edited successfully!');
    }

    public function destroy($id)
    {
        $this->bookService->deleteBook($id);
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
