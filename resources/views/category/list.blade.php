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
                        <h1>Category</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">category</a></li>

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
                                <h3 class="card-title">Category list</h3>

                                <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                                        href="{{ route('category.create') }}"> Create New category</a></div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body ">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <thead>
                                            <tr>

                                                <th scope="col">Category Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Icon</th>
                                                <th scope="col">Logo</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Popular</th>
                                                <th scope="col">Technical</th>
                                                <th scope="col">Created Date</th>
                                                <th scope="col">Created Time</th>
                                                <th scope="col">Created By</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <th scope="row">{{ $category->id }}</th>
                                                    <td>{{ $category->name }}</td>
                                                    <td>
                                                        @if ($category->icon)
                                                            <i class="fas fa-check text-primary"></i>
                                                        @else
                                                            <i class="fas fa-times text-secondary"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($category->logo)
                                                            <i class="fas fa-check text-primary"></i>
                                                        @else
                                                            <i class="fas fa-times text-secondary"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($category->is_active == 1)
                                                            <i class="fas fa-toggle-on text-primary"></i>
                                                        @else
                                                            <i class="fas fa-toggle-on text-secondary"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($category->is_popular == 1)
                                                            <i class="fas fa-check text-primary"></i>
                                                        @else
                                                            <i class="fas fa-times text-secondary"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($category->is_technical == 1)
                                                            <i class="fas fa-check text-primary"></i>
                                                        @else
                                                            <i class="fas fa-times text-secondary"></i>
                                                        @endif
                                                    </td>
                                                    <td>{{ $category->created_at->format('m/d/Y') }}</td>
                                                    <td>{{ $category->created_at->format('H:i:s') }}</td>
                                                    <td>{{ $category->creator->name }}</td>

                                                    <td>
                                                        {{-- <form action="{{ route('category.destroy', $category->id) }}"
                                                            method="POST">

                                                            <a class="btn btn-primary"
                                                                href="{{ route('category.edit', $category->id) }}">Edit</a>

                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn  btn-danger">Delete</button>
                                                        </form> --}}
                                                        <a href="{{ route('category.edit', $category->id) }}"><i
                                                                class="fas fa-edit"></i></a>

                                                        <a href="{{ route('category.destroy', $category->id) }}"
                                                            class="delete-link"
                                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $category->id }}').submit();">
                                                            <i class="fas fa-trash text-danger"></i>
                                                            <!-- Move the closing </i> tag here -->
                                                        </a>
                                                        <form id="delete-form-{{ $category->id }}"
                                                            action="{{ route('category.destroy', $category->id) }}"
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

                                    {!! $categories->links() !!}
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
