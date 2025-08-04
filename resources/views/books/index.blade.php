@extends('layout')

@section('title', 'Central Library | Book List')

@section('content')
<div class="container">
    <h3 class="text-center mt-2">Book List</h3>
    <div class='mb-2'>
        <a href="{{ route('books.add') }}" class="btn btn-primary">Add new book</a>
    </div>
    <div class="d-flex justify-content-between mb-3">
        @foreach($books as $book)
            @include('books.book-card', ['book' => $book])
        @endforeach
    </div>
</div>
@endsection
