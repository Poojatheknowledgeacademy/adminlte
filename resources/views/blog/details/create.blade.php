@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Blogdetails</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item"><a href="{{ route('blogs.index', $id) }}">Blog</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blogs.blogDetail.index', $id) }}">Blogdetails</a></li>
                            <li class="breadcrumb-item"><a href="#">Create Blogdetails</a></li>


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
                                <h3 class="card-title">Create Blogdetails</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <form method="POST" action="{{ route('blogs.blogDetail.store', $id) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Title<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('tittle') is-invalid @enderror"
                                            id="meta_tittle" name="tittle" placeholder="Enter title" value="{{ old('tittle') }}">

                                        @error('tittle')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta keywords<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('keywords') is-invalid @enderror"
                                            id="meta_keywords" name="keywords" placeholder="Enter keywords" value="{{ old('keywords') }}">

                                        @error('keywords')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Meta Description<span class="text-danger">*</label>
                                        <input type="text"
                                            class="form-control @error('description') is-invalid @enderror"
                                            id="meta_description" name="description" placeholder="Enter description" value="{{ old('description') }}">

                                        @error('description')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Summary<span class="text-danger">*</span></label>
                                        <textarea id="summary-text" class="form-control @error('summary') is-invalid @enderror" name="summary" value="{{ old('summary') }}">{{ old('summary') }}</textarea>
                                        @error('summary')
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
            $("#meta_tittle,#meta_keywords,#meta_description,#summary-text").on('input', function() {
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
