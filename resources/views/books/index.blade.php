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
        @if (count($books) > 0)
            @foreach($books as $book)
                <div class="col-md-3 g-4">
                    @include('books.book-card', ['book' => $book])
                </div>
            @endforeach
            <nav aria-label="pagination" class="mt-4">
                <ul class="pagination mb-0 d-flex justify-content-center">
                    <li class="page-item {{ $books->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $books->previousPageUrl() }}">Previous</a>
                    </li>
                    @for ($i = 1; $i <= $books->lastPage(); $i++)
                        <li class="page-item {{ $books->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link" href="{{ $books->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ $books->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $books->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>
        @else
            <p class="text-center">No books found!</p>
        @endif
    </div>
</div>
@endsection
