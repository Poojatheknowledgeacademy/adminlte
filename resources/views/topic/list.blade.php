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
                            <li class="breadcrumb-item"><a href="#">topic</a></li>

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
                                <h3 class="card-title">Topic List</h3>

                                <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                                        href="{{ route('topic.create') }}"> Create New Topic</a></div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body ">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <thead>
                                            <tr>

                                                <th scope="col">Id</th>
                                                <th scope="col">Name</th>
                                                 <th scope="col">Category Name</th>
                                                <th scope="col">Logo</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Created By</th>
                                                <th scope="col">Created Date</th>
                                                <th scope="col">Created Time</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($topics as $topic)
                                                <tr>
                                                    <th scope="row">{{ $topic->id }}</th>
                                                    <td>{{ $topic->name }}</td>
                                                    <td>{{ $topic->category->name }}</td>
                                                    <td>
                                                        @if ($topic->logo)
                                                            <i class="fas fa-check text-primary"></i>
                                                        @else
                                                            <i class="fas fa-times text-secondary"></i>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($topic->is_active == 1)
                                                            <i class="fas fa-toggle-on text-primary"></i>
                                                        @else
                                                            <i class="fas fa-toggle-on text-secondary"></i>
                                                        @endif
                                                    </td>


                                                    <td>{{ $topic->creator->name }}</td>
                                                    <td>{{ $topic->created_at->format('m/d/Y') }}</td>
                                                    <td>{{ $topic->created_at->format('H:i:s') }}</td>

                                                    <td>
                                                        <a href="{{ route('topic.edit', $topic->id) }}"><i
                                                                class="fas fa-edit"></i></a>

                                                        <a href="{{ route('topic.destroy', $topic->id) }}"
                                                            class="delete-link"
                                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $topic->id }}').submit();">
                                                            <i class="fas fa-trash text-danger"></i>
                                                            <!-- Move the closing </i> tag here -->
                                                        </a>
                                                        <form id="delete-form-{{ $topic->id }}"
                                                            action="{{ route('topic.destroy', $topic->id) }}"
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

                                    {!! $topics->links() !!}
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
