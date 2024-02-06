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

                  @if (session('alert'))
                       <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>{{ session('alert') }}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                       </div>
                  @endif

                <div class="card">

                    <div class="card-header text-center">
                        All Notes <h3 style="color: blue">{{ count($notes) }}</h3>
                    </div>
                    <br>

                    @unless (count($notes)==0)

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Image</th>
                                <th scope="col">Title</th>
                                <th scope="col">Content</th>
                                <th scope="col">created_at</th>
                                <th scope="col">View</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                            @php
                                $i=1;
                            @endphp



                            @foreach ($notes as $note)
                                <tr>
                                    <th scope="row">{{$i++; }}</th>
                                    <th><img src="{{ Storage::disk('public')->url('note/'.$note->image) }}" alt="" width="200" height="200"></th>
                                    <th>{{ Str::limit($note->title,'10') }}</th>
                                    <th>{{ Str::limit($note->content,'30') }}</th>
                                    <th>{{ $note->created_at->diffForHumans() }}</th>
                                    <th><a href="{{ route('note.show',$note->id) }}" class="btn btn-success"><i class="fa-solid fa-eye"></i></a></th>
                                    <th>
                                        <a href="{{ route('note.edit',$note->id) }}" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>

                                    </th>
                                    <th><a href="{{ route('note.destroy',$note->id) }}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a></th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $notes->links() }}

                    @else

                      <p>No note Found</p>

                    @endunless
                </div>
            </div>



            {{-- <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        Add Note
                    </div>
                    <div class="card-body">
                        <form action="{{route('store.brand')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="brand_name">Brand Name</label>
                                <input type="text" name="brand_name" class="form-control @error('brand_name') is-invalid @enderror" >
                                @error('brand_name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="brand_image">Brand Image</label>
                                <input type="file" name="brand_image" class="form-control @error('brand_image') is-invalid @enderror" >
                                @error('brand_image')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Add Brand</button>
                        </form>
                    </div>
                </div>
            </div> --}}


        </div>
    </div>
</div>


@endsection
