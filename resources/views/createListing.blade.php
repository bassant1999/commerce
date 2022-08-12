@extends('master.layout')
@section('content')
    @auth
        <div>
            <h2>Create Listing</h2>
            <form action="{{ route('listCreation') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Title:</label>
                    <input type="text" name="title" class="form-control">
                </div>
                <div class="form-floating">
                    <label class="form-label">Description:</label>
                    <textarea class="form-control" name="desc"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Price:</label>
                    <input type="text" name="price" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Category (optional)</label>
                    <select class="form-select" name="category" aria-label="Default select example">
                        <option selected value="">choose a category</option>
                        <option value="vehicle">vehicle</option>
                        <option value="animal">animal</option>
                        <option value="cleaning tool">cleaning tool</option>
                        <option value="food">food</option>
                        <option value="drinks">drinks</option>
                        <option value="cloths">cloths</option>
                        <option value="Fashion">Fashion</option>
                        <option value="Toys">Toys</option>
                        <option value="Electronics">Electronics</option>
                        <option value="Home">Home</option>
                    </select>
                    <!-- <input type="text" name="category" class="form-control"> -->
                </div>
                <div class="mb-3">
                    <label class="form-label">image (optional):</label>
                    <br>
                    <input type="file" name="image">
                </div>
                <button type="submit">Upload</button>
            </form>
        </div>
    @else
        Not signed in.
    @endauth 
    
@endsection