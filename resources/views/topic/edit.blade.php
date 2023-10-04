@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Topic</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Topic</a></li>
                            <li class="breadcrumb-item active">Edit Topic</li>
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
                                <h3 class="card-title">Edit Topic</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('topic.update', $topic->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') <!-- Use the PUT method for updating -->
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $topic->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInput2">Slug<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="exampleInput2" name="slug" value="{{ $slug ? $slug->slug : '' }}">
                                        @error('slug')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Category<span class="text-danger">*</label>
                                        <select class="form-control select2bs4 " style="width: 100%;"name="category_id">

                                            @foreach ($categories as $category)
                                                <option
                                                    value="{{ $category->id }}"{{ $topic->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="error invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="icon">Logo<span class="text-danger">*</label>
                                        <div class="input-group">
                                            <div class="col-md-6">
                                                <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                                id="logo" name="logo"value="{{ $topic->logo }}">
                                            </div>
                                            @if ($topic->logo)
                                                <div class="col-md-3">
                                                    <img src="{{ asset($topic->logo) }}" alt="Current Icon"
                                                        class="img-thumbnail" height="50" width="50" id="cLogo">
                                                    <i class="fas fa-trash text-danger" id="removelogo"
                                                        onClick="removeLogo()"></i>
                                                    <input type="hidden"id="removelogotxt" name="removelogotxt" value>
                                                    <i class="fas fa-undo text-danger" id="undoremocelogo"
                                                        onClick="undoLogo()" style="display: none";></i>
                                                </div>
                                            @endif
                                            @error('logo')
                                                <span class="error invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>


                                    {{-- <div class="form-group">
                                        <label for="icon">Logo<span class="text-danger">*</label>
                                        <div class="input-group">
                                            <div class="col-md-6">
                                                <input type="file"
                                                    class="form-control @error('logo') is-invalid @enderror" id="logo"
                                                    name="logo">
                                            </div>
                                            @if ($topic->logo)
                                                <div class="col-md-3">
                                                    <img src="{{ asset($topic->logo) }}" alt="Current Icon"
                                                        class="img-thumbnail" height="50" width="50" id="cLogo">
                                                    <i class="fas fa-trash text-danger" id="removelogo"
                                                        onClick="removeLogo()"></i>
                                                    <input type="hidden"id="removelogotxt" name="removelogotxt" value>
                                                    <i class="fas fa-undo text-danger" id="undoremocelogo"
                                                        onClick="undoLogo()" style="display: none";></i>
                                                </div>
                                            @endif
                                            @error('logo')
                                                <span class="error invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_active"
                                                id="customSwitch1" {{ $topic->is_active == 1 ? 'checked' : '' }}>
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

<!--Jquery -->
<script src="{{ asset('adminlte/dist/js/jquery-3.6.0.min.js') }}"></script>

<script>
    function removeLogo() {
        $('#removelogotxt').val('removed');
        $('#cLogo').attr('src', '{{ asset('Images/icon/no-image.png') }}');
        $('#removelogo').hide();
        $('#undoremocelogo').show();
    }

    function undoLogo() {
        $('#removelogotxt').val(null);
        $('#cLogo').attr('src', '{{ asset($topic->logo) }}');
        $('#removelogo').show();
        $('#undoremocelogo').hide();
    }
</script>
