@extends('layouts.app')

@section('content')
    {{-- <div id="success-message" class="alert alert-success" style="display: none;"></div> --}}
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        @if ($segment === 'topic')
                            <h1>Topic FAQ's</h1>
                        @else
                            <h1>Course FAQ's</h1>
                        @endif
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            @if ($segment === 'topic')
                                <li class="breadcrumb-item"><a href="{{ route('topic.index', $id) }}">Topic</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('topic.faqs.index', $id) }}">FAQ's</a></li>
                                <input type="hidden" value="{{ $segment }}" class="segment">
                            @else
                                <li class="breadcrumb-item"><a href="{{ route('course.index', $id) }}">Course</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('course.faqs.index', $id) }}">FAQ's</a></li>
                                <input type="hidden" value="{{ $segment }}" class="segment">
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
                                                            if (data === 1) {
                                                                return '<i class="fas fa-toggle-on text-primary is_active" data-activestatus="0" data-val="' +
                                                                    full.id + '"></i>';
                                                            } else {
                                                                return '<i class="fas fa-toggle-on text-secondary is_active" data-activestatus="1" data-val="' +
                                                                    full.id + '"></i>';
                                                            }
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

@push('child-scripts')
    <script>
        $(document).ready(function() {
            $('#table').on('click', '.is_active', function() {
                var activestatus = $(this).data('activestatus');
                var dataVal = $(this).data('val');
                var $toggle = $(this);
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '/changefaqStatus',
                    data: {
                        'is_active': activestatus,
                        'id': dataVal
                    },
                    success: function(data) {
                        if (activestatus === 1) {
                            $toggle.removeClass('text-secondary').addClass('text-primary');
                            $toggle.data('activestatus', 0);
                            $('#success-message').text(data.success).show();
                        } else {
                            $toggle.removeClass('text-primary').addClass('text-secondary');
                            $toggle.data('activestatus', 1);
                            $('#danger-message').text(data.success).show();

                        }
                    },
                });
            });
        });
    </script>
@endpush
