@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Topic Details</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('topic.index', $id) }}">Topic</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('topic.topicdetails.index', $id) }}">Details</a>
                            </li>
                            <li class="breadcrumb-item active">Create Detail</li>
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
                                <h3 class="card-title">Create Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('topic.topicdetails.store', $id) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                    <div class="form-group">
                                        <label>Topic Name<span class="text-danger">*</span></label>
                                        <select name="topic_id" id="topic_id"
                                            class="form-control select2bs4 @error('topic_id') is-invalid @enderror"
                                            style="width: 100%;">
                                            @foreach ($topics as $topic)
                                                <option value="{{ $topic->id }}"
                                                    {{ $topic->id == $id ? 'selected' : '' }}>
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
                                        <label for="country">Country<span class="text-danger">*</label>
                                        <select class="form-control select2bs4 @error('country') is-invalid @enderror"
                                            style="width: 100%;" id="country" name="country">
                                            <option value="">Select a Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Heading<span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('heading') is-invalid @enderror" id="heading" rows="5" name="heading"
                                            placeholder="Enter Heading">{{ old('heading') }}</textarea>
                                        @error('heading')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Summary<span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" rows="5" name="summary"
                                            placeholder="Enter summary">{{ old('summary') }}</textarea>
                                        @error('summary')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Details<span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('detail') is-invalid @enderror" id="detail" rows="5" name="detail"
                                            placeholder="Enter Details">{{ old('detail') }}</textarea>
                                        @error('detail')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Overview<span class="text-danger">*</span></label>
                                        <textarea id="summernote" class="summernote @error('overview') is-invalid @enderror" name="overview">
                                            {{ old('overview') }}</textarea>
                                        @error('overview')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>whats's Included<span class="text-danger">*</span></label>
                                        <textarea id="summernote" class="summernote @error('whats_included') is-invalid @enderror" name="whats_included">
                                            {{ old('whats_included') }}</textarea>
                                        @error('whats_included')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Pre requisite<span class="text-danger">*</span></label>
                                        <textarea id="summernote" class="summernote @error('pre_requisite') is-invalid @enderror" name="pre_requisite">
                                            {{ old('pre_requisite') }}</textarea>
                                        @error('pre_requisite')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Who should attend<span class="text-danger">*</span></label>
                                        <textarea id="summernote" class="summernote @error('who_should_attend') is-invalid @enderror" name="who_should_attend">
                                            {{ old('who_should_attend') }}</textarea>
                                        @error('who_should_attend')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title">Meta_title<span class="text-danger">*</label>
                                        <input type="text"
                                            class="form-control @error('meta_title') is-invalid @enderror" id="meta_title"
                                            name="meta_title" placeholder="Enter meta_title"
                                            value="{{ old('meta_title') }}">

                                        @error('meta_title')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywodrs<span class="text-danger">*</label>
                                        <input type="text"
                                            class="form-control @error('meta_keywords') is-invalid @enderror"
                                            id="meta_keywords" name="meta_keywords" placeholder="Enter meta_keywords"
                                            value="{{ old('meta_keywords') }}">

                                        @error('meta_keywords')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description">Meta description<span class="text-danger">*</label>
                                        <input type="text"
                                            class="form-control @error('meta_description') is-invalid @enderror"
                                            id="meta_description" name="meta_description"
                                            placeholder="Enter meta_description" value="{{ old('meta_description') }}">

                                        @error('meta_description')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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


@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('#question,#answer').on('input', function() {
                removeErrorMessages($(this));
            });
            $('#summernote').summernote({
                height: 300,
                focus: true,

            });
            if ($('#summernote').hasClass('is-invalid')) {
                $('#summernote').next('.note-editor').css('border-color', 'red');
            }
            $('#summernote').on('summernote.change', function(we, contents, $editable) {
                resetSummernoteBorder();
            });

            function resetSummernoteBorder() {
                $('#summernote').removeClass('is-invalid');
                $('#summernote').next('.note-editor').css('border-color', '');
            }

            function removeErrorMessages(inputField) {
                var parent = inputField.closest('.form-group');
                var errorElement = parent.find('.error');
                errorElement.remove();
                inputField.removeClass('is-invalid');
            }

            $('.summernote').each(function(i, obj) {
                $(obj).summernote({
                    onblur: function(e) {
                        var id = $(obj).data('id');
                        var sHTML = $(obj).code();
                    },
                    height: 300,
                    focus: true
                });
            });
        });
    </script>
@endpush
