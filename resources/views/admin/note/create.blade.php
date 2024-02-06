@extends('admin.layouts.admin_main')

@section('content')

<div class="py-12">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        Add Note
                    </div>
                    <div class="card-body">
                        <form action="{{route('note.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" >
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" >
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" rows="3" name="content">

                                </textarea>
                                @error('content')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                        </span>
                                @enderror
                            </div>

                            <br>
                            <button type="submit" class="btn btn-primary">Add Note</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection
