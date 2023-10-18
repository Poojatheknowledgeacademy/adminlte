@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>FaQ</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            @if ($segment === 'topic')
                                <li class="breadcrumb-item"><a href="{{ route('topic.index', $id) }}">Topic</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('topic.faqs.index', $id) }}">FAQ's</a></li>
                                <li class="breadcrumb-item"><a href="#">Create FAQ's</a></li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('course.index', $id) }}">Course</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('course.faqs.index', $id) }}">FAQ's</a></li>
                                <li class="breadcrumb-item"><a href="#">Create FAQ's</a></li>
                            @endif
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
                                <h3 class="card-title">Create FaQ</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if ($segment === 'topic')
                                    <form method="POST" action="{{ route('topic.faqs.store', $id) }}">
                                    @else
                                        <form method="POST" action="{{ route('course.faqs.store', $id) }}">
                                @endif

                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Question<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('question') is-invalid @enderror"
                                        id="question" name="question" placeholder="Enter Question">

                                    @error('question')
                                        <span class="error invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Answer<span class="text-danger">*</span></label>
                                    <textarea id="summernote" class="summernote @error('answer') is-invalid @enderror" name="answer">{{ old('summary') }}</textarea>
                                    @error('answer')
                                        <span class="error invalid-feedback" role="alert">
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
                height: 100,
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
            var t = $('#summernote').summernote({
                height: 100,
                focus: true
            });
        });
    </script>
@endpush
