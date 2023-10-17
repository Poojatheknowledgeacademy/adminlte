@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Course FAQ</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            @if ($segment === 'topic')
                            <li class="breadcrumb-item"><a href="{{ route('topic.index', $id) }}">Topic</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('topic.faqs.index', $id) }}">FAQ's</a></li>
                            @else
                            <li class="breadcrumb-item"><a href="{{ route('course.index', $id) }}">Course</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('course.faqs.index', $id) }}">FAQ's</a></li>
                            @endif

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
                                <h3 class="card-title">FaQ's list</h3>
                                @if ($segment === 'topic')
                                    <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                                            href="{{ route('topic.faqs.create', $id) }}"> Create New FaQ</a></div>
                                @else
                                    <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                                            href="{{ route('course.faqs.create', $id) }}"> Create New FaQ</a></div>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Question</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Created By</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                @push('child-scripts')
                                    <script>
                                        $(function() {
                                            $('#table').DataTable({
                                                processing: true,
                                                serverSide: true,
                                                ajax: @if ($segment === 'topic')
                                                    '{{ route('topic.faqs.index', $id) }}'
                                                @else
                                                    '{{ route('course.faqs.index', $id) }}'
                                                @endif ,
                                                columns: [{
                                                        data: 'question',
                                                        name: 'question'
                                                    },

                                                    {
                                                        data: 'is_active',
                                                        name: 'is_active',
                                                        render: function(data, type, full, meta) {
                                                            if (data) {
                                                                return '<i class="fas fa-toggle-on text-primary"></i>';
                                                            } else {
                                                                return '<i class="fas fa-toggle-on text-secondary"></i>';
                                                            }
                                                        }
                                                    },
                                                    {
                                                        data: 'creator.name',
                                                        name: 'creator.name'
                                                    },
                                                    {
                                                        data: 'id',
                                                        name: 'actions',
                                                        orderable: false,
                                                        searchable: false,
                                                        render: function(data, type, full, meta) {
                                                            @if ($segment === 'topic')
                                                                var editUrl = '{{ route('topic.faqs.edit', [$id, ':id']) }}'
                                                                    .replace(':id', data);
                                                                var deleteUrl = '{{ route('topic.faqs.destroy', [$id, ':id']) }}'
                                                                    .replace(':id', data);
                                                            @else
                                                                var editUrl = '{{ route('course.faqs.edit', [$id, ':id']) }}'
                                                                    .replace(':id', data);
                                                                var deleteUrl = '{{ route('course.faqs.destroy', [$id, ':id']) }}'
                                                                    .replace(':id', data);
                                                            @endif

                                                            var deleteFormId = 'delete-form-' + data;

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
                                @endpush

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
