@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active">Edit user</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
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
                                    @foreach ($user->logActivities as $activity)
                                        <div class="time-label">
                                            <span class="bg-red">{{ $activity->created_at }}</span>
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
                                <h3 class="card-title">Edit user</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="POST" action="{{ route('users.update', $user->id) }}">
                                    @csrf
                                    @method('PUT') <!-- Use the PUT method for updating -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name<span class="text-danger">*</label>
                                        <input type="name" class="form-control @error('name') is-invalid @enderror"
                                            id="exampleInputEmail1" value="{{ $user->name }}" placeholder="Enter Name"
                                            name="name">
                                        @error('name')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email <span class="text-danger">*</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            id="exampleInputEmail1" value="{{ $user->email }}" placeholder="Enter email"
                                            name="email">
                                        @error('email')
                                            <span class="error invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Roles<span class="text-danger">*</span></label>
                                        <select class="form-control select2 @error('roles') is-invalid @enderror" name="roles[]"
                                            multiple="multiple" style="width: 100%;" >
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" {{ $user->roles->contains('id', $role->id) ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
        </section>
    </div>
@endsection
