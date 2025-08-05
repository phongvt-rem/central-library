<div class="card" style="width: 18rem;">
  <img src={{  asset('storage/' . $book->cover_url) }} class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title text-center">{{ $book->title }}</h5>
    <div class="d-flex justify-content-around">
        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('books.destroy', $book->id) }}" method="POST" onsubmit="return confirmDelete()">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    </div>
  </div>
</div>

<script>
  function confirmDelete() {
    return confirm('Do you really want to delete this book?');
  }
</script>
