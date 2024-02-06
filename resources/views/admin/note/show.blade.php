@extends('admin.layouts.admin_main')

@section('content')

<div class="py-12">
    <div class="container">
        <div class="row">
            <div class="col-md-12">


                    <div class="form-group">
                        <img src="{{ Storage::disk('public')->url('note/'.$note->image) }}">
                    </div>
                    <div class="form-group">
                        <h1>{{ $note->title }}</h1>
                    </div>

                    <div class="form-group">
                       <p>{{ $note->content }}</p>
                    </div>
            </div>
        </div>
    </div>
</div>


@endsection
