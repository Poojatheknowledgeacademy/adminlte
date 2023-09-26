@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Blogs</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Blog</a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Blog</h3>
                                <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                                        href="{{ route('blogs.create') }}"> Create
                                        New Blog</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">category Name</th>
                                            <th scope="col">Title</th>
                                            {{-- <th scope="col">Short Description</th>
                                            <th scope="col">Summary</th> --}}
                                            {{-- <th scope="col">Featured Image1</th>
                                            <th scope="col">Featured Image2</th> --}}
                                            <th scope="col">Author Name</th>
                                            <th scope="col">Is_Popular</th>
                                            <th scope="col">Is_Active</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Created_by</th>
                                            <th>Created date</th>
                                            <th>Created time</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @php
                                            $id = 1;
                                        @endphp --}}
                                        @foreach ($blog as $blogs)
                                            <tr>
                                                <td>{{ $blogs->id }}</td>
                                                <td>{{$blogs->category->name }}</td>
                                                <td>{{ $blogs->title }}</td>
                                                {{-- <td>{{ $blogs->short_description }}</td>
                                                <td>{{ $blogs->summary }}</td> --}}
                                                {{-- <td><img src="{{ asset($blogs->featured_img1) }}" alt=""
                                                        width="100" height="100"></td>
                                                <td><img src="{{ asset($blogs->featured_img2) }}" alt=""
                                                        width="100" height="100"></td> --}}
                                                <td>{{ $blogs->author_name }}</td>

                                                @if ($blogs->is_popular == '1')
                                                    <td>
                                                        <i class="fas fa-check" style="font-size: 24px; color: green;"></i>
                                                    </td>
                                                @else
                                                    <td>
                                                        <i class="fas fa-times" style="font-size: 24px; color: red;"></i>
                                                    </td>
                                                @endif

                                                @if ($blogs->is_active == '1')
                                                    <td>
                                                        <i class="fas fa-check" style="font-size: 24px; color: green;"></i>
                                                    </td>
                                                @else
                                                    <td>
                                                        <i class="fas fa-times" style="font-size: 24px; color: red;"></i>
                                                    </td>
                                                @endif
                                                <td>{{ $blogs->added_date }}</td>



                                                @if ($blogs->createdBy)
                                                    <td>
                                                        {{ $blogs->createdBy->name }}
                                                    </td>
                                                @else
                                                    <td>-</td>
                                                @endif
                                                <td>{{ $blogs->updated_at->format('Y-m-d') }}</td>
                                                <td>{{ $blogs->updated_at->format('H:i:s') }}</td>
                                                <td>
                                                    <form action="{{ route('blogs.destroy', $blogs->id) }}" method="POST">
                                                        <a class="btn btn-primary"
                                                            href="{{ route('blogs.edit', $blogs->id) }}"><i class="fa fa-edit"></i></a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            {{-- @php $id ++;  @endphp --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $blog->links('pagination::bootstrap-4') }}

                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </section>
    </div>
@endsection
