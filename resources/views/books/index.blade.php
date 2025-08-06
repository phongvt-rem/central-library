@extends('layout')

@section('title', 'Central Library | Book List')

@section('content')
<div class="container">
    <h3 class="text-center mt-2">Book List</h3>
    @foreach (['success' => 'success', 'error' => 'danger'] as $msg => $type)
        @if (session($msg))
            <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
                {{ session($msg) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    @endforeach
    <div class='mb-2'>
        <a href="{{ route('books.add') }}" class="btn btn-primary">Add new book</a>
    </div>
    <div class="row">
        @foreach($books as $book)
            <div class="col-md-3 g-4">
                @include('books.book-card', ['book' => $book])
            </div>
        @endforeach
    </div>
</div>
@endsection
