<?php

namespace App\Http\Controllers;

use App\Services\BookService;

class BookController extends Controller
{
    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        $books = $this->bookService->getAllBooks();
        return view('books.index', compact('books'));
    }

    public function add()
    {
        $title = 'Add New Book';
        return view('books.book-form', compact('title'));
    }

    public function edit($id)
    {
        $title = 'Edit Book';
        return view('books.book-form', compact('title'));
    }

    public function destroy($id)
    {
        $this->bookService->deleteBook($id);
        return redirect()->route('books.index');
    }
}
