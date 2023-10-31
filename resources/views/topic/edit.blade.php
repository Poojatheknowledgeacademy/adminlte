@extends('layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Topic</h1>
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('topic.index') }}">Topic</a></li>
                        <li class="breadcrumb-item active">Edit Topic</li>
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
                                @foreach ($topic->logActivities as $activity)
                                    <div class="time-label">
                                        <span class="bg-red">{{ $activity->created_at->format('d-M-Y h:i A') }}</span>
                                    </div>

                                    <div>
                                        <i class="fas fa-solid fa-pen bg-blue"></i>
                                        <div class="timeline-item">
                                            <div class="card-header">
                                                <h3 class="card-title">{{ $activity->creator->name }}</h3>
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

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Topic</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form method="POST" action="{{ route('topic.update', $topic->id) }}"
                                enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                @method('PUT')

                                <div class="form-group">
                                    <label>Name<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $topic->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Slug<span class="text-danger">*</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        name="slug" value="{{ $topic->slugs->slug ? $topic->slugs->slug : '' }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Category<span class="text-danger">*</label>
                                    <select name="category_id"
                                        class="form-control select2bs4 @error('category_id') is-invalid @enderror">
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $topic->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="logo">Logo<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="col-md-6">
                                            <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                                id="logo" name="logo">
                                        </div>
                                        @if ($topic->logo)
                                            <div class="col-md-3">
                                                <img src="{{ asset($topic->logo) }}" alt="Current Logo"
                                                    class="img-thumbnail" height="50" width="50" id="cLogo">
                                                <i class="fas fa-trash text-danger" id="removelogo"
                                                    onClick="removeLogo()"></i>
                                                <input type="hidden" id="removelogotxt" name="removelogotxt" value>
                                                <i class="fas fa-undo text-danger" id="undoremovelogo" onClick="undoLogo()"
                                                    style="display: none";></i>
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
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1"
                                            name="is_active" {{ $topic->is_active == 1 ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customSwitch1">Active</label>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('child-scripts')
    <script>
        function removeLogo() {
            $('#removelogotxt').val('removed');
            $('#cLogo').attr('src', '{{ asset('Images/featureimage1/no-image.png') }}');
            $('#removelogo').hide();
            $('#undoremovelogo').show();
        }

        function undoLogo() {
            $('#removelogotxt').val(null);
            $('#cLogo').attr('src', '{{ asset($topic->logo) }}');
            $('#removelogo').show();
            $('#undoremovelogo').hide();
        }
    </script>
@endpush
