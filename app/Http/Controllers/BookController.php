<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Services\AuthorService;
use App\Services\CategoryService;
use App\Http\Requests\StoreBookRequest;

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
        $title = 'Add New Book';
        $destination_route = 'books.store';
        $author_list = $this->authorService->getAllAuthors();
        $category_list = $this->categoryService->getAllCategories();

        return view('books.book-form', compact('title', 'author_list', 'category_list', 'destination_route'));
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $this->bookService->storeBook($data);

        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    public function edit($id)
    {
        $title = 'Edit Book';
        $author_list = $this->authorService->getAllAuthors();
        $category_list = $this->categoryService->getAllCategories();

        return view('books.book-form', compact('title'));
    }

    public function destroy($id)
    {
        $this->bookService->deleteBook($id);
        return redirect()->route('books.index')->with('success', 'Book deleted successfully!');
    }
}
