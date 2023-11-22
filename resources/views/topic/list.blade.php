@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Topics</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('topic.index') }}">Topics</a></li>
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
                                <h3 class="card-title">Topic List</h3>
                                <div class="float-right">
                                    <a class="btn btn-block btn-sm btn-success" href="{{ route('topic.create') }}"> Create
                                        New Topic</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="success" class="alert alert-success" style="display: none;"></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Category Name</th>
                                                <th scope="col">Logo</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Country Active</th>
                                                <th scope="col">Country Popular</th>
                                                <th scope="col">Details</th>
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
                                                ajax: '{{ route('topic.index') }}',
                                                columns: [{
                                                        data: 'id',
                                                        name: 'id'
                                                    },
                                                    {
                                                        data: 'name',
                                                        name: 'name'
                                                    },
                                                    {
                                                        data: 'category.name',
                                                        name: 'category.name'
                                                    },
                                                    {
                                                        data: 'logo',
                                                        name: 'logo',
                                                        render: function(data, type, full, meta) {
                                                            return data ?
                                                                '<i class="fas fa-check text-primary"></i>' :
                                                                '<i class="fas fa-times text-secondary"></i>';
                                                        }
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
                                                        data: 'country',
                                                        name: 'country',
                                                        render: function(data, type, full, meta) {
                                                            var isChecked = full.countries.some(function(country) {
                                                                if (country.pivot.deleted_at == null) {
                                                                    return true;
                                                                } else {
                                                                    return false;
                                                                }
                                                            });

                                                            return '<input type="checkbox" class="topic-checkbox" data-topic-id="' +
                                                                full.id + '" ' +
                                                                (isChecked ? 'checked' : '') + '>';
                                                        }
                                                    },
                                                    {
                                                        data: 'popular',
                                                        name: 'popular',
                                                        render: function(data, type, full, meta) {
                                                            var ispopular = full.countries.some(function(country) {
                                                                return country.pivot.is_popular;
                                                            });
                                                            if (ispopular == 1) {
                                                                return '<i class="fas fa-toggle-on text-primary is_popular" data-popularstatus="' +
                                                                    0 + '" data-val="' + full.id + '"></i>';
                                                            } else {
                                                                return '<i class="fas fa-toggle-on text-secondary is_popular" data-popularstatus="' +
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
                                                            var editUrl = '{{ route('topic.topicdetails.index', ':id') }}'.replace(
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
                                                            var editUrl = '{{ route('topic.faqs.index', ':id') }}'.replace(
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
                                                                return moment(data).format(
                                                                    'DD MMM YYYY [at] HH:mm:ss [GMT]');
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
                                                            var editUrl = '{{ route('topic.edit', ':id') }}'
                                                                .replace(
                                                                    ':id',
                                                                    data);
                                                            var deleteFormId = 'delete-form-' + data;
                                                            var deleteUrl = '{{ route('topic.destroy', ':id') }}'
                                                                .replace(
                                                                    ':id',
                                                                    data);
                                                            @php
                                                                $isAdmin = in_array('Admin', array_column(Auth::user()->roles->toArray(), 'name'));
                                                            @endphp

                                                            var action = '<a href="' + editUrl +
                                                                '" class="fas fa-edit"></a>';

                                                            if (@json($isAdmin)) {
                                                                action += '<a href="#" class="delete-link" ' +
                                                                    'onclick="event.preventDefault(); document.getElementById(\'' +
                                                                    deleteFormId + '\').submit();">' +
                                                                    '<i class="fas fa-trash text-danger"></i>' +
                                                                    '</a>' +
                                                                    '<form id="' + deleteFormId + '" ' +
                                                                    ' action="' + deleteUrl +
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
@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('#table').on('click', '.is_active', function() {
                var activestatus = $(this).data('activestatus');
                var dataVal = $(this).data('val');
                var $toggle = $(this);
                var url = '/changetopicStatus';
                handleStatusToggle($toggle, activestatus, dataVal, url);
            });
            $('#table').on('click', '.is_popular', function() {
                var popularstatus = $(this).data('popularstatus');
                var dataVal = $(this).data('val');
                var $toggle = $(this);
                var url = '/topicsetpopular';
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    data: {
                        'is_popular': popularstatus,
                        'id': dataVal
                    },
                    success: function(data) {
                        if (popularstatus === 1) {
                            $toggle.removeClass('text-secondary').addClass('text-primary');
                            $toggle.data('popularstatus', 0);
                            $('#success-message').text(data.success).show();
                            $('#danger-message').text(data.success).hide();
                        } else {
                            $toggle.removeClass('text-primary').addClass('text-secondary');
                            $toggle.data('popularstatus', 1);
                            $('#danger-message').text(data.success).show();
                            $('#success-message').text(data.success).hide();
                        }
                    }
                });
            });
        });
        $(document).on('click', '.topic-checkbox', function() {
            var topic_id = $(this).data('topic-id');
            var checked = $(this).prop('checked');
            var url = '/country-topics';
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                data: {
                    'topic_id': topic_id,
                     'checked': checked
                },
                success: function(data) {
                    $(this).prop('checked', data.deleted_at === null);
                }
            });
        });
    </script>
@endpush

{{-- //         $(document).on('click', '.topic-checkbox', function() {
//             var topic_id = $(this).data('topic-id');
//             var checked = $(this).prop('checked');
//             var url = '/country-topics';
//             $.ajax({
//                 type: "GET",
//                 dataType: "json",
//                 url: url,
//                 data: {
//                     'topic_id': topic_id,
//                     'checked': checked
//                 },
//                 success: function(data) {
//                     $(this).prop('checked', data.deleted_at === null);
//                 }
//             });
//         }); --}}

