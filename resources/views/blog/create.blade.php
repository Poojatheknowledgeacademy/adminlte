@extends('layouts.app')
@section('content')
    {{-- @if ($errors->any())
<div class="alert alert-danger">
   <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
   </ul>
</div>
@endif --}}
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Blog</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Blog</a></li>
                        <li class="breadcrumb-item active">Create Blog</li>
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
                            <h3 class="card-title">Create Blog</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('blogs.store') }}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="form-group">
                                    <label>Category<span class="text-danger">*</label>
                                    <select name="category_id"
                                        class="form-control select2bs4 @error('category_id') is-invalid @enderror">
                                        <option value="">Select a category</option>
                                        @foreach ($category as $categories)
                                            <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Slug<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        name="slug" value="{{ old('slug') }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Title<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        name="title" value="{{ old('title') }}">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Short description<span class="text-danger">*</label>
                                    <input type="text"
                                        class="form-control @error('short_description') is-invalid @enderror"
                                        name="short_description" value="{{ old('short_description') }}">
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Summary<span class="text-danger">*<span class="text-danger">*</label>
                                    <textarea id="summernote" class="summernote @error('summary') is-invalid @enderror" name="summary">{{ old('summary') }}</textarea>
                                    @error('summary')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Featured image1<span class="text-danger">*</label>
                                    <input type="file" class="form-control @error('featured_img1') is-invalid @enderror"
                                        name="featured_img1" value="{{ old('featured_img1') }}">
                                    @error('featured_img1')
                                        <div class="error invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Featured image2<span class="text-danger">*</label>
                                    <div class="custom-file">
                                        <input type="file"
                                            class="form-control @error('featured_img2') is-invalid @enderror"
                                            name="featured_img2" value="{{ old('featured_img2') }}">
                                    </div>
                                    @error('featured_img2')
                                        <div class="error invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Author Name<span class="text-danger">*</label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control @error('author_name') is-invalid @enderror"
                                            name="author_name" value="{{ old('author_name') }}">
                                        @error('author_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Date<span class="text-danger">*</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control @error('added_date') is-invalid @enderror"
                                            name="added_date" value="{{ old('added_date') }}">
                                        @error('added_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tags<span class="text-danger">*</label>
                                    <select class="select2" name="tags[]" multiple="multiple" style="width: 100%;"
                                        id="pieces">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                            name="is_popular">
                                        <label class="custom-control-label" for="customSwitch1">Popular</label>
                                    </div>
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
<script>
    $(document).ready(function() {
        $('#pieces').select2({
            tags: true
        });
        $('#show').on('click', function(e) {
            alert($('#pieces').val());
        });
    });
</script>
<script>

    $(document).ready(function() {

        // Attach input event listeners to the input fields

        $('#blog_category').on('input', function() {

            removeErrorMessages($(this));

        });



        $('#blog_slug').on('input', function() {

            removeErrorMessages($(this));

        });

        $('#blog_tittle').on('input', function() {

            removeErrorMessages($(this));

        });

        $('#blog_description').on('input', function() {

            removeErrorMessages($(this));

        });

        $('#summernote').on('input', function() {

            removeErrorMessages($(this));

        });

        $('#blog_image1').on('input', function() {

            removeErrorMessages($(this));

        });

        $('#blog_image2').on('input', function() {

            removeErrorMessages($(this));

        });

        $('#blog_authorname').on('input', function() {

            removeErrorMessages($(this));

        });

        $('#blog_date').on('input', function() {

            removeErrorMessages($(this));

        });

        $('#blog_tag').on('input', function() {

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



