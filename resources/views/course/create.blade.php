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
                        <li class="breadcrumb-item"><a href="{{ route('course.index') }}">Course</a></li>
                        <li class="breadcrumb-item active">Create Course</li>
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
                            <h3 class="card-title">Create Course</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('course.store') }}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                <div class="form-group">
                                    <label>Name<span class="text-danger">*</label>
                                    <input type="text" id="course_name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}">
                                    @error('name')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Slug<span class="text-danger">*</label>
                                    <input type="text" id="course_slug"
                                        class="form-control @error('slug') is-invalid @enderror" name="slug"
                                        value="{{ old('slug') }}">
                                    @error('slug')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Topic<span class="text-danger">*</label>
                                    <select name="topic_id" id="topic_name"
                                        class="form-control select2bs4 @error('topic_id') is-invalid @enderror">
                                        <option value="">Select a Topic</option>
                                        @foreach ($topic as $topics)
                                            <option value="{{ $topics->id }}">{{ $topics->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('topic_id')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Logo<span class="text-danger">*</label>
                                    <input type="file" id="course_logo"
                                        class="form-control @error('logo') is-invalid @enderror" name="logo"
                                        value="{{ old('logo') }}">
                                    @error('logo')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2"
                                            name="is_active" checked>
                                        <label class="custom-control-label" for="customSwitch2">Active</label>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('child-scripts')
    <script>
        $(document).ready(function() {

            $('#topic_name,#course_name,#course_slug,#course_logo').on('input', function() {
                removeErrorMessages($(this));
            });
            var courseNameField = $('#course_name');
            var courseSlugField = $('#course_slug');

            function removeErrorMessages(inputField) {
                var parent = inputField.closest('.form-group');
                var errorElement = parent.find('.error');
                errorElement.remove();
                inputField.removeClass('is-invalid');
            }

            courseNameField.on('input', function() {
                var courseName = courseNameField.val();
                var slug = courseName.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                courseSlugField.val(slug);
                removeErrorMessages(courseSlugField);
            });

            courseSlugField.on('input', function() {
                removeErrorMessages(courseSlugField);
            });
        });
    </script>
@endpush
