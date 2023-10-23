@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Course</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('course.index') }}">Course</a></li>
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
                                <h3 class="card-title">Course list</h3>
                                <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                                        href="{{ route('course.create') }}"> Create New Course</a></div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Course Name</th>
                                                <th scope="col">Topic Name</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Detail</th>
                                                <th scope="col">FaQ</th>
                                                <th scope="col">Created At</th>
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
                                                ajax: '{{ route('course.index') }}',
                                                columns: [{
                                                        data: 'id',
                                                        name: 'id'
                                                    },
                                                    {
                                                        data: 'name',
                                                        name: 'name'
                                                    },
                                                    {
                                                        data: 'topic.name',
                                                        name: 'topic.name'
                                                    },
                                                    {
                                                        data: 'is_active',
                                                        name: 'is_active',
                                                        render: function(data, type, full, meta) {
                                                            if (data) {
                                                                return '<i class="fas fa-toggle-on text-primary is_active" data-activestatus="' +
                                                                    0 + '" data-val="' + full.id + '"></i>';
                                                            } else {
                                                                return '<i class="fas fa-toggle-on text-secondary is_active" data-activestatus="' +
                                                                    1 + '" data-val="' + full.id + '"></i>';
                                                            }
                                                        }
                                                    },
                                                    {
                                                        data: 'id',
                                                        name: 'detail',
                                                        orderable: false,
                                                        searchable: false,
                                                        render: function(data, type, full, meta) {
                                                            var editUrl = '{{ route('course.coursedetails.index', ':id') }}'.replace(
                                                                ':id',
                                                                data);
                                                            var action = '<a href="' + editUrl +
                                                                '" class="fas fa-list text-primary"></a>';
                                                            return action;
                                                        }
                                                    },
                                                    {
                                                        data: 'id',
                                                        name: 'faq',
                                                        orderable: false,
                                                        searchable: false,
                                                        render: function(data, type, full, meta) {
                                                            var editUrl = '{{ route('course.faqs.index', ':id') }}'.replace(
                                                                ':id',
                                                                data);
                                                            var action = '<a href="' + editUrl +
                                                                '" class="fas fa-question-circle text-primary"></a>';
                                                            return action;
                                                        }
                                                    },
                                                    {
                                                        data: 'created_at',
                                                        name: 'created_at',
                                                        render: function(data, type, full, meta) {
                                                            if (data) {
                                                                return moment(data).format('DD MMM YYYY [at] HH:mm:ss [GMT]');
                                                            }
                                                            return '';
                                                        }
                                                    },
                                                    {
                                                        data: 'creator.name',
                                                        name: 'creator.name'
                                                    }, {
                                                        data: 'id',
                                                        name: 'actions',
                                                        orderable: false,
                                                        searchable: false,
                                                        render: function(data, type, full, meta) {
                                                            var editUrl = '{{ route('course.edit', ':id') }}'.replace(':id',
                                                                data);
                                                            var deleteFormId = 'delete-form-' + data;
                                                            var deleteUrl = '{{ route('course.destroy', ':id') }}'.replace(':id',
                                                                data);
                                                            @php
                                                                $isAdmin = in_array('admin', array_column(Auth::user()->roles->toArray(), 'name'));
                                                            @endphp

                                                            var action = '<a href="' + editUrl + '" class="fas fa-edit"></a>';

                                                            if (@json($isAdmin)) {
                                                                action += '<a href="#" class="delete-link" ' +
                                                                    'onclick="event.preventDefault(); document.getElementById(\'' +
                                                                    deleteFormId + '\').submit();">' +
                                                                    '<i class="fas fa-trash text-danger"></i>' +
                                                                    '</a>' +
                                                                    '<form id="' + deleteFormId + '" ' +
                                                                    'action="' + deleteUrl +
                                                                    '" method="POST" style="display: none;">' +
                                                                    '@csrf' +
                                                                    '@method('DELETE')' +
                                                                    '</form>';
                                                            }
                                                            return action;
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
{{-- <script src="{{ asset('adminlte/dist/js/jquery-3.6.0.min.js') }}"></script> --}}
@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('#table').on('click', '.is_active', function() {
                var activestatus = $(this).data('activestatus');
                var dataVal = $(this).data('val');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/changecourseStatus',
                    data: {
                        'is_active': activestatus,
                        'id': dataVal
                    },
                    success: function(data) {
                        setTimeout(function() {
                            window.location.href = data.redirect;
                        });

                    }
                });
            });
        });
    </script>
@endpush
