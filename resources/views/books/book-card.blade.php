<div class="card" style="width: 18rem;">
  <img src={{  asset('storage/' . $book->cover_url) }} class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title text-center">{{ $book->title }}</h5>
    <div class="d-flex justify-content-around">
        <a href="#" class="btn btn-warning">Edit</a>
        <a href="#" class="btn btn-danger">Delete</a>
    </div>
  </div>
</div>