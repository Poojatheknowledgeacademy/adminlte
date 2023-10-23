@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Topic Detail</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('topic.index') }}">topic</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('topic.topicdetails.index', $id) }}">topic Detail</a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Edit topic Detail</a></li>
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
                            <h3 class="card-title">Edit topic</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST"
                                action="{{ route('topic.topicdetails.update', [$topicdetail->topic_id, $topicdetail->id]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Topic Name<span class="text-danger">*</span></label>
                                    <select name="topic_id" id="topic_name"
                                        class="form-control select2bs4 @error('topic_id') is-invalid @enderror">
                                        @foreach ($topics as $topic)
                                            <option value="{{ $topic->id }}"
                                                {{ $topic->id == $topicdetail->topic_id ? 'selected' : '' }}>
                                                {{ $topic->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('topic_id')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Country<span class="text-danger">*</span></label>
                                    <select name="country_id" id="country_id"
                                        class="form-control select2bs4 @error('country_id') is-invalid @enderror">
                                        <option value="">Select a country</option>
                                        @foreach ($countries as $country)
                                            <option
                                                value="{{ $country->id }}"{{ $country->id == $topicdetail->country_id ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="heading">Heading<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('heading') is-invalid @enderror"
                                        id="heading" name="heading" placeholder="Enter Heading"
                                        value="{{ old('heading', $topicdetail->heading) }}">

                                    @error('heading')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="summary">Summary<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('summary') is-invalid @enderror"
                                        id="summary" name="summary" placeholder="Enter Summary"
                                        value="{{ old('summary', $topicdetail->summary) }}">

                                    @error('summary')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="detail">Details<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('detail') is-invalid @enderror"
                                        id="detail" name="detail" placeholder="Enter Detail"
                                        value="{{ old('detail', $topicdetail->detail) }}">


                                    @error('detail')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label>Overview<span class="text-danger">*</span></label>
                                    <textarea id="summernote" class="summernote @error('overview') is-invalid @enderror" name="overview">{{ old('overview', $topicdetail->overview) }}</textarea>
                                    @error('overview')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>What's included<span class="text-danger">*</span></label>
                                    <textarea id="summernote" class="summernote @error('whats_included') is-invalid @enderror" name="whats_included">{{ old('whats_included', $topicdetail->whats_included) }}</textarea>
                                    @error('whats_included')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Pre-requisite<span class="text-danger">*</span></label>
                                    <textarea id="summernote" class="summernote @error('pre_requisite') is-invalid @enderror" name="pre_requisite">{{ old('pre_requisite', $topicdetail->pre_requisite) }}</textarea>
                                    @error('pre_requisite')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Who should Attend<span class="text-danger">*</span></label>
                                    <textarea id="summernote" class="summernote @error('who_should_attend') is-invalid @enderror"
                                        name="who_should_attend">{{ old('who_should_attend', $topicdetail->who_should_attend) }}</textarea>
                                    @error('who_should_attend')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Meta Title<span class="text-danger">*</span></label>
                                    <input type="text" id="meta_title"
                                        class="form-control @error('meta_title') is-invalid @enderror" name="meta_title"
                                        value="{{ old('meta_title', $topicdetail->meta_title) }}">
                                    @error('meta_title')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Meta Keywords<span class="text-danger">*</span></label>
                                    <input type="text" id="meta_keywords"
                                        class="form-control @error('meta_keywords') is-invalid @enderror"
                                        name="meta_keywords"
                                        value="{{ old('meta_keywords', $topicdetail->meta_keywords) }}">
                                    @error('meta_keywords')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Meta Description<span class="text-danger">*</span></label>
                                    <input type="text" id="meta_description"
                                        class="form-control @error('meta_description') is-invalid @enderror"
                                        name="meta_description"
                                        value="{{ old('meta_description', $topicdetail->meta_description) }}">
                                    @error('meta_description')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
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


@push('child-scripts')
    <script>
       $(document).ready(function() {
        $('#summernote').summernote({
                height: 300,
                focus: true,

            });

        });
    </script>
@endpush
