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
                            <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">Category</a></li>
                            <li class="breadcrumb-item active">Create FaQ</li>
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
                                <form method="POST" action="{{ route('faq.store') }}" enctype="multipart/form-data">
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
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
{{--
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Answer<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('answer') is-invalid @enderror"
                                            id="answer" name="answer" placeholder="Enter slug">

                                        @error('answer')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div> --}}





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
            // Attach input event listeners to the input fields
            $('#question').on('input', function() {
                removeErrorMessages($(this));
            });

            $('#answer').on('input', function() {
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


            function updateTopicOptions() {
                var entityType = $('input[name="entity_type"]:checked').val();
                var $topicSelect = $('#entity_id');
                $.ajax({
                    url: '{{ route('get_topics_and_courses') }}',
                    type: 'GET',
                    data: {
                        entityType: entityType
                    },
                    success: function(data) {
                        $topicSelect.html(data);
                    }
                });
            }

            $('input[name="entity_type"]').change(function() {
                updateTopicOptions();
            });
            updateTopicOptions();
        });
    </script>
@endpush
