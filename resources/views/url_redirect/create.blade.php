@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>UrlRedirect</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('url_redirect.index') }}">URL</a></li>
                            <li class="breadcrumb-item active">Create UrlRedirect</li>
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
                                <h3 class="card-title">Create UrlRedirect</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('url_redirect.store') }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="name">Source URL<span class="text-danger">*</span></label>
                                        <input type="text" name="source_url" id="source_url"
                                            class="form-control @error('source_url') is-invalid @enderror"
                                            value="{{ old('source_url') }}">
                                        @error('source_url')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="redirect_url">Redirect URL<span class="text-danger">*</span></label>
                                        <input type="text" name="redirect_url" id="redirect_url"
                                            class="form-control @error('redirect_url') is-invalid @enderror"
                                            value="{{ old('redirect_url') }}">
                                        @error('redirect_url')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </form>
    </div>
@endsection
@push('child-scripts')
    <script>
        $(document).ready(function() {

            $('#source_url,#redirect_url').on('input', function() {
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
