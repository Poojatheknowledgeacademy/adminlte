@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Role</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                            <li class="breadcrumb-item active">Edit Role</li>
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
                                    @foreach ($role->logActivities as $activity)
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Role</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                                    @csrf
                                    @method('PUT') {{-- Use PUT method for updates --}}
                                    <div class="form-group">
                                        <label for="name">Name<span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $role->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description<span class="text-danger">*</span></label>
                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                            rows="4">{{ old('description', $role->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="is_active"
                                                id="customSwitch1" {{ $role->is_active == 1 ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customSwitch1">Active</label>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Assign Permission</h3>
                            </div>
                            <div class="card-header">
                                @foreach ($modulesWithPermissions as $module)
                                    <div class="card-footer">
                                        <b>{{ $module->name }}</b>
                                    </div>


                                    <div class="container">
                                        @foreach ($module->permissions as $permission)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"   {{ $role->permissions->contains('id',$permission->id) ? "checked" : "" }}  name="permissions[]" type="checkbox"
                                                    id="inlineCheckbox1" value="{{ $permission->id }}" />
                                                <label class="form-check-label"
                                                    for="inlineCheckbox1">{{ $permission->name }}</label>

                                            </div>
                                        @endforeach

                                    </div>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-border border-width-2"
                                            id="exampleInputBorderWidth2">
                                    </div>
                                @endforeach
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
        </section>
    </form>
    </div>
@endsection
