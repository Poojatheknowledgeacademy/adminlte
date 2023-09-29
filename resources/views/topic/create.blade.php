@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Category</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
                            <li class="breadcrumb-item active">Create category</li>
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
                                <h3 class="card-title">Create category</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <input type="text" id="topic_name"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            placeholder="Enter name">
                                        @error('name')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Slug</label>
                                        <input type="text" id="topic_slug"
                                            class="form-control @error('slug') is-invalid @enderror" name="slug"
                                            placeholder="Enter slug">
                                        @error('slug')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Icon</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file"
                                                    class="form-control @error('icon') is-invalid @enderror" id="icon"
                                                    name="icon">
                                            </div>
                                        </div>
                                        @error('icon')
                                            <span class="error invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">logo</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                                id="logo" name="logo">
                                        </div>
                                        @error('logo')
                                            <span class="error invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_active"
                                                id="customSwitch1" checked>
                                            <label class="custom-control-label" for="customSwitch1">Active</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_popular"
                                                id="customSwitch2" checked>
                                            <label class="custom-control-label" for="customSwitch2">Popular</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_technical"
                                                id="customSwitch3" checked>
                                            <label class="custom-control-label" for="customSwitch3">Technical</label>
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
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        /// Attach input event listeners to the input fields
        $('#topic_name').on('input', function() {
            removeErrorMessages($(this));
        });

        $('#topic_slug').on('input', function() {
            removeErrorMessages($(this));
        });
        $('#icon').on('input', function() {
            removeErrorMessages($(this));
        });
        $('#logo').on('input', function() {
            removeErrorMessages($(this));
        });
        // Function to remove error messages and reset input field's border
        function removeErrorMessages(inputField) {
            // Find the parent element and then find the error message element
            var parent = inputField.closest('.form-group');
            var errorElement = parent.find('.error');

            // Remove the error message if it exists
            errorElement.remove();

            // Remove the is-invalid class to reset the input field's border
            inputField.removeClass('is-invalid');
        }
    });
</script>
