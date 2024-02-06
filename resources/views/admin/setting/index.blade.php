@extends('admin.layouts.admin_main')

@section('content')

<div class="py-12">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                @if (session('success'))
                       <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          <strong>{{ session('success') }}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                       </div>
                  @endif
                <div class="card">
                    <div class="card-header text-center">
                        Profile Settings
                    </div>
                    <div class="card-body">
                        <form action="{{ route('setting.update') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control" >
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}">
                            </div>

                            <div class="form-group">
                                <label for="name">username</label>
                                <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">

                            </div>

                            <br>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
