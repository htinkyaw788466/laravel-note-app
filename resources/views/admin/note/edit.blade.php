@extends('admin.layouts.admin_main')

@section('content')

<div class="py-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">



                <div class="card">

                    <div class="card-header text-center">
                        Edit Note
                    </div>

                    <div class="card-body">
                        <form action="{{route('note.update',$note->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
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
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $note->title }}">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" rows="3" name="content">
                                  {{ $note->content }}
                                </textarea>
                                @error('content')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{$message}}</strong>
                                        </span>
                                @enderror
                            </div>

                            <br>
                            <a href="{{ route('note') }}" class="btn btn-info">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>

                </div>
            </div>




        </div>
    </div>
</div>


@endsection
