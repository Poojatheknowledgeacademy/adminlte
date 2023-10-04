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
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">category Name</th>
                                                <th scope="col">Title</th>
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
                                        {{-- <tbody>

                                            @foreach ($blog as $blogs)
                                                <tr>
                                                    <td>{{ $blogs->id }}</td>
                                                    <td>{{ $blogs->category->name }}</td>
                                                    <td>{{ $blogs->title }}</td>

                                                    <td>{{ $blogs->author_name }}</td>

                                                    <td>
                                                        @if ($blogs->is_popular == 1)
                                                            <i class="fas fa-check text-primary"></i>
                                                        @else
                                                            <i class="fas fa-times text-secondary"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($blogs->is_active == 1)
                                                            <i class="fas fa-toggle-on text-primary"></i>
                                                        @else
                                                            <i class="fas fa-toggle-on text-secondary"></i>
                                                        @endif
                                                    </td>

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
                                                        <a href="{{ route('blogs.edit', $blogs->id) }}"><i
                                                                class="fas fa-edit"></i></a>

                                                        <a href="{{ route('blogs.destroy', $blogs->id) }}" class="delete-link"
                                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $blogs->id }}').submit();">
                                                            <i class="fas fa-trash text-danger"></i>
                                                            <!-- Move the closing </i> tag here -->
                                                        </a>
                                                        <form id="delete-form-{{ $blogs->id }}"
                                                            action="{{ route('blogs.destroy', $blogs->id) }}" method="POST"
                                                            style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>

                                            @endforeach
                                        </tbody> --}}
                                    </table>
                                </div>
                                <script>
                                    $(function() {
                                        $('#table').DataTable({
                                            processing: true,
                                            serverSide: true,
                                            ajax: '{{ route('blogs.index') }}',

                                            columns: [{
                                                    data: 'id',
                                                    name: 'id'
                                                },
                                                {
                                                    data: 'category_id',
                                                    name: 'category_id'
                                                },
                                                {
                                                    data: 'title',
                                                    name: 'title'
                                                },
                                                {
                                                    data: 'author_name',
                                                    name: 'author_name'
                                                },
                                                {
                                                    data: 'is_popular',
                                                    name: 'is_popular',
                                                    render: function(data, type, full, meta) {
                                                       // console.log(data);
                                                        if (data) {
                                                            return '<i class="fas fa-toggle-on text-primary"></i>';
                                                        } else {
                                                            return '<i class="fas fa-toggle-on text-secondary"></i>';
                                                        }
                                                    }
                                                },

                                                {
                                                    data: 'is_active',
                                                    name: 'is_active',
                                                    render: function(data, type, full, meta) {
                                                       // console.log(data);
                                                        if (data) {
                                                            return '<i class="fas fa-toggle-on text-primary"></i>';
                                                        } else {
                                                            return '<i class="fas fa-toggle-on text-secondary"></i>';
                                                        }
                                                    }
                                                },
                                                {
                                                    data: 'added_date',
                                                    name: 'added_date'
                                                },
                                                {
                                                    data: 'creator.name',
                                                    name: 'creator.name'
                                                },
                                                {
                                                    data: 'created_at',
                                                    name: 'created_at',
                                                    render: function(data, type, full, meta) {
                                                        if (data) {
                                                            return moment(data).format('YYYY-MM-DD');
                                                        }
                                                        return '';
                                                    }
                                                }, {
                                                    data: 'created_at',
                                                    name: 'created_at',
                                                    render: function(data, type, full, meta) {
                                                        if (data) {
                                                            return moment(data).format('HH:mm:ss');
                                                        }
                                                        return '';
                                                    }
                                                },

                                                 {
                                                    data: 'id',
                                                    name: 'actions',
                                                    orderable: false,
                                                    searchable: false,
                                                    render: function(data, type, full, meta) {
                                                        var editUrl = '{{ route('blogs.edit', ':id') }}'.replace(':id', data);
                                                        var deleteFormId = 'delete-form-' + data;
                                                        var deleteUrl = '{{ route('blogs.destroy', ':id') }}'.replace(':id',
                                                            data);

                                                        return '<a href="' + editUrl + '" class="fas fa-edit"></a>' +
                                                            '<a href="#" class="delete-link" ' +
                                                            '   onclick="event.preventDefault(); document.getElementById(\'' +
                                                            deleteFormId + '\').submit();">' +
                                                            '   <i class="fas fa-trash text-danger"></i>' +
                                                            '</a>' +
                                                            '<form id="' + deleteFormId + '" ' +
                                                            '   action="' + deleteUrl +
                                                            '" method="POST" style="display: none;">' +
                                                            '   @csrf' +
                                                            '   @method('DELETE')' +
                                                            '</form>';
                                                    }
                                                },

                                            ]
                                        });
                                    });
                                </script>
                            </div>

                            {{-- <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    {{ $blog->links('pagination::bootstrap-4') }}

                                </ul>
                            </div> --}}

                        </div>
                    </div>

                </div>
            </div>

        </section>
    </div>
@endsection
<script src="{{ asset('adminlte/dist/js/jquery-3.6.0.min.js') }}"></script>
