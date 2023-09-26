@extends('layouts.app')

 

@section('content')

    @if (session()->has('success'))

        <div class="alert alert-success" role="alert">

            {{ session('success') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

    @endif

 

    @if (session()->has('danger'))

        <div class="alert alert-danger">

            {{ session('danger') }}

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                <span aria-hidden="true">&times;</span>

            </button>

        </div>

    @endif

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

                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">users</a></li>

 

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

                                <h3 class="card-title">User list</h3>

 

                                <div class="float-right"> <a class="btn btn-block btn-sm btn-success"

                                        href="{{ route('users.create') }}"> Create New User</a></div>

                            </div>

                            <!-- /.card-header -->

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered">

                                        <thead>

                                            <tr>

 

                                                <th scope="col">User Id</th>

                                                <th scope="col">Name</th>

                                                <th scope="col">Email</th>

                                                <th scope="col">Created Date</th>

                                                <th scope="col">Created Time</th>

                                                <th scope="col">Created By</th>

                                                <th scope="col">Action</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach ($users as $user)

                                                <tr>

                                                    <th scope="row">{{ $user->id }}</th>

                                                    <td>{{ $user->name }}</td>

                                                    <td>{{ $user->email }}</td>

                                                    <td>{{ $user->created_at->format('m/d/Y') }}</td>

                                                    <td>{{ $user->created_at->format('H:i:s') }}</td>

                                                     <td>{{ $user->creator->name }}</td>

 

                                                    <td>

                                                        <a href="{{ route('users.edit', $user->id) }}"><i

                                                                class="fas fa-edit"></i></a>

 

                                                        <a href="{{ route('users.destroy', $user->id) }}"

                                                            class="delete-link"

                                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">

                                                            <i class="fas fa-trash text-danger"></i>

                                                            <!-- Move the closing </i> tag here -->

                                                        </a>

                                                        <form id="delete-form-{{ $user->id }}"

                                                            action="{{ route('users.destroy', $user->id) }}" method="POST"

                                                            style="display: none;">

                                                            @csrf

                                                            @method('DELETE')

                                                        </form>

 

                                                    </td>

                                                </tr>

                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                            <!-- /.card-body -->

                            <div class="card-footer clearfix">

                                <ul class="pagination pagination-sm m-0 float-right">

                                    {!! $users->links() !!}

                                </ul>

                            </div>

                            <!-- /.card -->

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection