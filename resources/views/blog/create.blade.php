@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Blog</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blog</a></li>
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
                                    <label>Category<span class="text-danger">*</span></label>
                                    <select id="blog_category" name="category_id"
                                        class="form-control select2bs4 @error('category_id') is-invalid @enderror">
                                        <option value="">Select a category</option>
                                        @foreach ($category as $categories)
                                            <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Slug<span class="text-danger">*</span></label>
                                    <input type="text" id="blog_slug"
                                        class="form-control @error('slug') is-invalid @enderror" name="slug"
                                        value="{{ old('slug') }}">
                                    @error('slug')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Title<span class="text-danger">*</span></label>
                                    <input id="blog_tittle" type="text"
                                        class="form-control @error('title') is-invalid @enderror" name="title"
                                        value="{{ old('title') }}">
                                    @error('title')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Short description<span class="text-danger">*</span></label>
                                    <input id="blog_description" type="text"
                                        class="form-control @error('short_description') is-invalid @enderror"
                                        name="short_description" value="{{ old('short_description') }}">
                                    @error('short_description')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Summary<span class="text-danger">*</span></label>
                                    <textarea id="summernote" class="summernote @error('summary') is-invalid @enderror" name="summary">{{ old('summary') }}</textarea>
                                    @error('summary')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Featured image1<span class="text-danger">*</span></label>
                                    <input id="blog_image1" type="file"
                                        class="form-control @error('featured_img1') is-invalid @enderror"
                                        name="featured_img1" value="{{ old('featured_img1') }}">
                                    @error('featured_img1')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Featured image2<span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input id="blog_image2" type="file"
                                            class="form-control @error('featured_img2') is-invalid @enderror"
                                            name="featured_img2" value="{{ old('featured_img2') }}">
                                    </div>
                                    @error('featured_img2')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Author Name<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input id="blog_authorname" type="text"
                                            class="form-control @error('author_name') is-invalid @enderror"
                                            name="author_name" value="{{ old('author_name') }}">
                                        @error('author_name')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Date<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input id="blog_date" type="date"
                                            class="form-control @error('added_date') is-invalid @enderror"
                                            name="added_date" value="{{ old('added_date') }}">
                                        @error('added_date')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Tags<span class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('tags') is-invalid @enderror"
                                        name="tags[]" multiple="multiple" style="width: 100%;" id="pieces">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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
@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('#pieces').select2({
                tags: true
            });
            $(document).ready(function() {
                if ($('#pieces').hasClass('is-invalid')) {
                    $('#pieces').next('.select2-container').find('.select2-selection').css('border-color',
                        'red');
                }
            });

            function resetBorderColor() {
                $('#pieces').removeClass('is-invalid');
                $('#pieces').next('.select2-container').find('.select2-selection').css('border-color', '');
            }
            // $('#show').on('click', function(e) {
            //     alert($('#pieces').val());
            // });
            $('#pieces').on('change', function() {
                resetBorderColor();
            });
            $('#summernote').summernote({
                height: 300,
                focus: true,

            });
            if ($('#summernote').hasClass('is-invalid')) {
                $('#summernote').next('.note-editor').css('border-color', 'red');
            }
            $('#blog_category,#blog_slug,#blog_tittle,#blog_description,#blog_image1,#blog_image2,#blog_authorname,#blog_date')
                .on('input', function() {
                    removeErrorMessages($(this));
                });

            $('#summernote').on('summernote.change', function(we, contents, $editable) {
                resetSummernoteBorder();
            });

            function removeErrorMessages(inputField) {
                var parent = inputField.closest('.form-group');
                var errorElement = parent.find('.error');
                errorElement.remove();

                inputField.removeClass('is-invalid');
            }

            function resetSummernoteBorder() {
                $('#summernote').removeClass('is-invalid');
                $('#summernote').next('.note-editor').css('border-color', '');
            }

});
    </script>
@endpush
