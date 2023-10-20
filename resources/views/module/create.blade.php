@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Module</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('module.index') }}">Module</a></li>
                            <li class="breadcrumb-item active">Create Module</li>
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
                                <h3 class="card-title">Create Module</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('module.store') }}" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" placeholder="Enter name">

                                        @error('name')
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

            $('#name,#slug,#icon,#logo').on('input', function() {
                removeErrorMessages($(this));
            });

            function removeErrorMessages(inputField) {

                var parent = inputField.closest('.form-group');
                var errorElement = parent.find('.error');
                errorElement.remove();
                inputField.removeClass('is-invalid');
            }

            $('#name').on('input', function() {
                removeErrorMessages($(this));
                convertToSlug();
            });

            function removeErrorMessages(inputField) {
                var parent = inputField.closest('.form-group');
                var errorElement = parent.find('.error');
                errorElement.remove();
                inputField.removeClass('is-invalid');
            }

            function convertToSlug() {
                var category_name = $('#name').val();
                var str = category_name;

                // Replace spaces with hyphens
                str = str.toLowerCase().replace(/\s+/g, '-');

                // Remove any other special characters
                str = str.replace(/[^a-z0-9-]/g, '');

                $('#slug').val(str);
            }
        });
    </script>
@endpush
