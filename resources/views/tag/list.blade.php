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
                        <h1>Tag</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Tag</a></li>

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
                                <h3 class="card-title">Tag List</h3>

                                <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                                        href="{{ route('tag.create') }}"> Create New Tag</a></div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body ">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <thead>
                                            <tr>

                                                <th scope="col">Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Created By</th>
                                                <th scope="col">Created Date</th>
                                                <th scope="col">Created Time</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tags as $tag)
                                                <tr>
                                                    <th scope="row">{{ $tag->id }}</th>
                                                    <td>{{ $tag->name }}</td>
                                                    <td>
                                                        @if ($tag->is_active == 1)
                                                            <i class="fas fa-toggle-on text-primary"></i>
                                                        @else
                                                            <i class="fas fa-toggle-on text-secondary"></i>
                                                        @endif
                                                    </td>


                                                    <td>{{ $tag->creator->name }}</td>
                                                    <td>{{ $tag->created_at->format('m/d/Y') }}</td>
                                                    <td>{{ $tag->created_at->format('H:i:s') }}</td>

                                                    <td>
                                                        <a href="{{ route('tag.edit', $tag->id) }}"><i
                                                                class="fas fa-edit"></i></a>

                                                        <a href="{{ route('tag.destroy', $tag->id) }}"
                                                            class="delete-link"
                                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $tag->id }}').submit();">
                                                            <i class="fas fa-trash text-danger"></i>
                                                            <!-- Move the closing </i> tag here -->
                                                        </a>
                                                        <form id="delete-form-{{ $tag->id }}"
                                                            action="{{ route('tag.destroy', $tag->id) }}"
                                                            method="POST" style="display: none;">
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

                                    {!! $tags->links() !!}
                                </ul>
                            </div>

                            <!-- /.card -->

                        </div>


                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
