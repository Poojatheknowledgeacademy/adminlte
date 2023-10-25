@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Permissions</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('permission.index') }}">Permissions</a></li>
                            <li class="breadcrumb-item active">Create Permission</li>
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
                                <h3 class="card-title">Create Permission</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('permission.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="category_id">Module Name<span class="text-danger">*</label>
                                        <select class="form-control select2bs4 @error('module_id') is-invalid @enderror"
                                            id="module_id" name="module_id">
                                            <option value="">Select a Module</option> <!-- Default empty option -->
                                            @foreach ($modules as $module)
                                                <option value="{{ $module->id }}">{{ $module->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('module_id')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="category_id">Access<span class="text-danger">*</label>
                                        <select class="form-control select2bs4 @error('access') is-invalid @enderror"
                                            id="access" name="access">
                                            <option value ="">select Access</option>
                                            <option value ="insert">insert</option>
                                            <option value ="update">update</option>
                                            <option value ="delete">delete</option>
                                            <option value ="list">view</option>
                                        </select>
                                        @error('access')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description<span class="text-danger">* </label>
                                        <input type="text"
                                            class="form-control @error('description') is-invalid @enderror" id="description"
                                            placeholder="Enter description" name="description">
                                        @error('description')
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

            $('#module_id, #access,#description').on('input', function() {
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
