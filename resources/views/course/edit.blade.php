@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Course</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Course</a></li>
                        <li class="breadcrumb-item active">Edit Course</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Course</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('course.update', $course->id) }}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                @method('PUT')
                                <div class="form-group">
                                    <label>Topic<span class="text-danger">*</label>
                                    <select name="topic_id"
                                        class="form-control select2bs4 @error('topic_id') is-invalid @enderror">
                                        <option value="">Select a topic</option>
                                        @foreach ($topic as $topics)

                                            <option value="{{ $topics->id }}"
                                                {{ $topics->id == $course->topic_id ? 'selected' : '' }}>
                                                {{ $topics->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('topic_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Name<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $course->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Slug<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        name="slug" value="{{ $slug ? $slug->slug : '' }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Logo<span class="text-danger">*</label>
                                    <div class="col-md-6">

                                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                            id="logo" name="logo">
                                        @if ($course->logo)
                                            <div class="col-md-3">
                                                <img src="{{ asset($course->logo) }}" alt="Current fetureimage1"
                                                    class="img-thumbnail" height="50" width="50" id="cIcon">

                                                <i class="fas fa-trash text-danger" id="logoimage"
                                                    onClick="logoimage()"></i>

                                                <input type="hidden"id="removelogotxt" name="removelogotxt" value>

                                                <i class="fas fa-undo text-danger" id="undoremovelogo"
                                                    onClick="undologoimage()" style="display: none";></i>
                                            </div>
                                            @error('logo')
                                                <span class="error invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                            name="is_active" {{ $course->is_active == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customSwitch1">Active</label>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function logoimage() {

    $('#logoimage').val('removed');

    $('#cIcon').attr('src', '{{ asset('Images/featureimage1/no-image.png') }}');

    $('#logoimage').hide();

    $('#undoremovelogo').show();

    }

    function undologoimage() {

    $('#removelogotxt').val(null);

    $('#cIcon').attr('src', '{{ asset($course->logo) }}');

    $('#logoimage').show();

    $('#undoremovelogo').hide();

    }
</script>
