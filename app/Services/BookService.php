<?php

namespace App\Services;

use App\Repositories\Interface\BookRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class BookService
{
    protected BookRepositoryInterface $bookRepo;

    public function __construct(BookRepositoryInterface $bookRepo)
    {
        $this->bookRepo = $bookRepo;
    }

    public function getAllBooks()
    {
        return $this->bookRepo->all();
    }

    public function deleteBook($id)
    {
        $target_book = $this->bookRepo->find($id);
        Storage::disk('public')->delete($target_book->cover_url);

        return $this->bookRepo->delete($id);
    }

    public function storeBook(array $data)
    {
        $file = $data['cover_url'];
        $fileName = 'book' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('cover_img', $fileName, 'public');
        $data['cover_url'] = $path;

        return $this->bookRepo->create($data);
    }

    public function findBookById($id)
    {
        return $this->bookRepo->find($id);
    }

    public function updateBook(int $id, array $data)
    {
        $target_book = $this->bookRepo->find($id);
        Storage::disk('public')->delete($target_book->cover_url);

        $file = $data['cover_url'];
        $fileName = 'book' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('cover_img', $fileName, 'public');
        $data['cover_url'] = $path;

        return $this->bookRepo->update($id, $data);
    }

    public function updateBookWithoutCoverImg(int $id, array $data)
    {
        return $this->bookRepo->update($id, $data);
    }
}