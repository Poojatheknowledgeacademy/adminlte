@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Blogdetail</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('blogs.index', $id) }}">Blog</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blogs.blogDetail.index', $id) }}">Blogdetails</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Edit Blogdetails</a></li>
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Activity</h3>
                            </div>
                            <div class="card-body">
                                <!-- The time line -->
                                <div class="timeline">
                                    <!-- timeline time label -->
                                    @foreach ($blogDetail->logActivities as $activity)
                                        <div class="time-label">
                                            <span class="bg-red">{{ $activity->created_at->format('d-M-Y h:i A') }}</span>
                                        </div>

                                        <div>
                                            <i class="fas fa-solid fa-pen bg-blue"></i>
                                            <div class="timeline-item">
                                                <div class="card-header">
                                                    <h3 class="card-title">{{ $activity->creator->name }}</h3>
                                                </div>
                                                <h3 class="timeline-header no-border"> {{ $activity->activity }} </a></h3>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div>
                                        <i class="fas fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Blogdetails</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST"
                                    action="{{ route('blogs.blogDetail.update', [$blogDetail->blog_id, $blogDetail->id]) }}">
                                    @csrf
                                    @method('PUT') <!-- Use the PUT method for updating -->
                                    <div class="form-group">
                                        <label>Blog Name<span class="text-danger">*</span></label>
                                        <select name="blog_id" id="blog_id"
                                            class="form-control select2bs4 @error('blog_id') is-invalid @enderror">
                                            @foreach ($blogs as $blog)
                                                <option value="{{ $blog->id }}" {{ $blog->id == $blogDetail->blog_id ? 'selected' : '' }}>
                                                    {{ $blog->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('blog_id')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_tittle">Meta Title<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="meta_title" name="title"
                                            value="{{ old('title', $blogDetail->meta_title) }}">
                                        @error('title')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="question">Meta keywords<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('keywords') is-invalid @enderror"
                                            id="meta_keyword" name="keywords"
                                            value="{{ old('keywords', $blogDetail->meta_keywords) }}">
                                        @error('keywords')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="question">Meta Description<span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('description') is-invalid @enderror"
                                            id="meta_description" name="description"
                                            value="{{ old('description', $blogDetail->meta_description) }}">
                                        @error('description')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Summary<span class="text-danger">*</span></label>
                                        <textarea id="summery-text" class="form-control @error('summary') is-invalid @enderror" name="summary">{{ old('answer', $blogDetail->summary) }}</textarea>
                                        @error('summary')
                                            <div class="error invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_active"
                                                id="customSwitch1" {{ $blogDetail->is_active == 1 ? 'checked' : '' }}>
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
        </section>
    </div>
@endsection
@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('#meta_title, #meta_keyword, #meta_description,#summery-text,#blog_id').on('input', function() {
                removeErrorMessages($(this));
            });
            function removeErrorMessages(inputField) {
                var parent = inputField.closest('.form-group');
                var errorElement = parent.find('.error');
                errorElement.remove();
                inputField.removeClass('is-invalid');
            }
        });
    </script>
@endpush
