@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Category</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Course</a></li>
                        <li class="breadcrumb-item active">Edit Category</li>
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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Activity</h3>
                    </div>
                    <div class="card-body">
                        <!-- The time line -->
                        <div class="timeline">
                            <!-- timeline time label -->
                            @foreach ($category->logActivities as $activity)
                                <div class="time-label">
                                    <span class="bg-red">{{ $activity->created_at->format('d-M-Y h:i A') }}</span>
                                </div>

                                <div>
                                    <i class="fas fa-solid fa-pen bg-blue"></i>
                                    <div class="timeline-item">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                @if($activity->created_by)
                                                    {{ $activity->creator->name }}
                                                @else
                                                    System
                                                @endif
                                            </h3>
                                        </div>
                                        <h3 class="timeline-header no-border"> {{ $activity->activity }} </a></h3>
                                    </div>
                                </div>
                            @endforeach
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        <!-- Main content -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Category</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                                <form method="POST" action="{{ route('category.update', $category->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') <!-- Use the PUT method for updating -->
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $category->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="name">Slug<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ $slug ? $slug->slug : '' }}">
                                        @error('slug')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="icon">Icon<span class="text-danger">*</label>
                                        <div class="input-group">
                                            <div class="col-md-6">
                                                <input type="file"
                                                    class="form-control @error('icon') is-invalid @enderror" id="icon"
                                                    name="icon">
                                            </div>
                                            @if ($category->icon)
                                                <div class="col-md-3">
                                                    <img src="{{ asset($category->icon) }}" alt="Current Icon"
                                                        class="img-thumbnail" height="50" width="50" id="cIcon">
                                                    <i class="fas fa-trash text-danger" id="removeicon"
                                                        onClick="removeIcon()"></i>
                                                    <input type="hidden"id="removeicontxt" name="removeicontxt" value>
                                                    <i class="fas fa-undo text-danger" id="undoremoceicon"
                                                        onClick="undoIcon()" style="display: none";></i>
                                                </div>
                                            @endif
                                            @error('icon')
                                                <span class="error invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="icon">Logo<span class="text-danger">*</label>
                                        <div class="input-group">
                                            <div class="col-md-6">
                                                <input type="file"
                                                    class="form-control @error('logo') is-invalid @enderror" id="logo"
                                                    name="logo"value="{{ $category->logo }}">
                                            </div>
                                            @if ($category->logo)
                                                <div class="col-md-3">
                                                    <img src="{{ asset($category->logo) }}" alt="Current Icon"
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

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_active"
                                                id="customSwitch1" {{ $category->is_active == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch1">Active</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_popular"
                                                id="customSwitch2" {{ $category->is_popular == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch2">Popular</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_technical"
                                                id="customSwitch3" {{ $category->is_technical == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch3">Technical</label>
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
        function removeIcon() {
            $('#removeicontxt').val('removed');
            $('#cIcon').attr('src', '{{ asset('Images/icon/no-image.png') }}');
            $('#removeicon').hide();
            $('#undoremoceicon').show();
        }

        function undoIcon() {
            $('#removeicontxt').val(null);
            $('#cIcon').attr('src', '{{ asset($category->icon) }}');
            $('#removeicon').show();
            $('#undoremoceicon').hide();
        }

        function removeLogo() {
            $('#removelogotxt').val('removed');
            $('#cLogo').attr('src', '{{ asset('Images/icon/no-image.png') }}');
            $('#removelogo').hide();
            $('#undoremocelogo').show();
        }

        function undoLogo() {
            $('#removelogotxt').val(null);
            $('#cLogo').attr('src', '{{ asset($category->logo) }}');
            $('#removelogo').show();
            $('#undoremocelogo').hide();
        }
    </script>
@endpush
