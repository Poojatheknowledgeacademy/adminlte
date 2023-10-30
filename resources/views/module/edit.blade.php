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
                            <li class="breadcrumb-item active">Edit Module</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- timeline module -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Activity</h3>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <!-- timeline time label -->
                                    @foreach ($module->logActivities as $activity)
                                        <div class="time-label">
                                            <span class="bg-red">{{ $activity->created_at }}</span>
                                        </div>

                                        <div>
                                            <i class="fas fa-pen bg-blue"></i>
                                            <div class="timeline-item">
                                                <div class="card-header">
                                                    <h3 class="card-title">{{ $activity->creator->name }}</h3>
                                                </div>
                                                <h3 class="timeline-header no-border"> {{ $activity->activity }} </h3>
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
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Module</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('module.update', $module->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT') <!-- Use the PUT method for updating -->
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ $module->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_active"
                                                id="customSwitch1" {{ $module->is_active == 1 ? 'checked' : '' }}>
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
