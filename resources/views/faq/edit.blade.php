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
                            <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">Topic</a></li>
                            <li class="breadcrumb-item active">Edit FaQ</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit FaQ</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('faq.update', $faq->id) }}">
                                    @csrf
                                    @method('PUT') <!-- Use the PUT method for updating -->
                                    <div class="form-group">
                                        <label for="question">Question<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('question') is-invalid @enderror"
                                            id="question" name="question" value="{{ old('question', $faq->question) }}">
                                        @error('question')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="answer">Answer<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('answer') is-invalid @enderror"
                                            id="answer" name="answer" value="{{ old('answer', $faq->answer) }}">
                                        @error('answer')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Entity Type<span class="text-danger">*</span></label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="entity_type" id="topic" value="Topic"
                                                {{ old('entity_type', $faq->entity_type) === 'Topic' ? 'checked' : '' }}>
                                            <label class="form-check-label">Topic</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="entity_type" id="course" value="Course"
                                                {{ old('entity_type', $faq->entity_type) === 'Course' ? 'checked' : '' }}>
                                            <label class="form-check-label">Course</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Select Entity<span class="text-danger">*</span></label>
                                        <select name="entity_id" id="entity_id" class="form-control select2bs4 @error('entity_id') is-invalid @enderror">
                                            <option value="">Select</option>
                                            {{-- Check the entity type and populate options accordingly --}}
                                            @if ($faq->entity_type == "Course")
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}"
                                                        {{ old('entity_id', $faq->entity_id) == $course->id ? 'selected' : '' }}>
                                                        {{ $course->name }}
                                                    </option>
                                                @endforeach
                                            @elseif ($faq->entity_type == "Topic")
                                                @foreach ($topics as $topic)
                                                    <option value="{{ $topic->id }}"
                                                        {{ old('entity_id', $faq->entity_id) == $topic->id ? 'selected' : '' }}>
                                                        {{ $topic->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('entity_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_active"
                                                id="customSwitch1" {{ $faq->is_active == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch1">Active</label>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
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
            $('#question').on('input', function() {
                removeErrorMessages($(this));
            });

            $('#answer').on('input', function() {
                removeErrorMessages($(this));
            });

            $('#entity_id').on('input', function() {
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
            $('input[name="entity_type"]').change(function() {
                $("#entity_id").select2("val", "");
                var entityType = $('input[name="entity_type"]:checked').val();
                var $entitySelect = $('#entity_id');
                $.ajax({
                    url: '{{ route('get_topics_and_courses') }}', // Replace with your actual route
                    type: 'GET',
                    data: { entityType: entityType },
                    success: function(data) {
                        $entitySelect.html(data);
                    }
                });
            });
        });
    </script>
@endpush

