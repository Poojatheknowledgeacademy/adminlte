@extends('layouts.app')

@section('content')
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
                            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Category</a></li>
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
                                <div class="float-right">
                                    <a class="btn btn-block btn-sm btn-success mb-2"
                                        href="{{ route('category.create') }}">Create New Category</a>
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                            <label class="custom-control-label" for="customSwitch1"></label>
                                        </div>
                                        <div class="text-center mt-1">Active</div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Category Id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Icon</th>
                                                <th scope="col">Logo</th>
                                                <th scope="col">Active</th>
                                                <th scope="col">Popular</th>
                                                <th scope="col">Technical</th>
                                                <th scope="col">Country Active</th>
                                                <th scope="col">Created At</th>
                                                <th scope="col">Created By</th>
                                                <th scope="col">Action</th>

                                            </tr>
                                        </thead>
                                    </table>
                                </div>

                                @push('child-scripts')
                                    <script>
                                        var columnStructure = [{
                                                data: 'id',
                                                name: 'id'
                                            },
                                            {
                                                data: 'name',
                                                name: 'name'
                                            },
                                            {
                                                data: 'icon',
                                                name: 'icon',
                                                render: function(data, type, full, meta) {
                                                    if (data) {
                                                        return '<i class="fas fa-check text-primary"></i>';
                                                    } else {
                                                        return '<i class="fas fa-times text-secondary"></i>';
                                                    }
                                                }
                                            }, {
                                                data: 'logo',
                                                name: 'logo',
                                                render: function(data, type, full, meta) {
                                                    console.log(data);
                                                    if (data) {
                                                        return '<i class="fas fa-check text-primary"></i>';
                                                    } else {
                                                        return '<i class="fas fa-times text-secondary"></i>';
                                                    }
                                                }
                                            }, {
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
                                                data: 'is_popular',
                                                name: 'is_popular',
                                                render: function(data, type, full, meta) {
                                                    if (data) {
                                                        return '<i class="fas fa-toggle-on text-primary"></i>';
                                                    } else {
                                                        return '<i class="fas fa-toggle-on text-secondary"></i>';
                                                    }
                                                }
                                            }, {
                                                data: 'is_technical',
                                                name: 'is_technical',
                                                render: function(data, type, full, meta) {
                                                    if (data) {
                                                        return '<i class="fas fa-toggle-on text-primary"></i>';
                                                    } else {
                                                        return '<i class="fas fa-toggle-on text-secondary"></i>';
                                                    }
                                                }
                                            },
                                            {
                                                data: 'country',
                                                name: 'country',
                                                orderable: false,
                                                render: function(data, type, full, meta) {
                                                    var isChecked = full.countries.some(function(country) {
                                                        // alert(country.pivot.deleted_at);
                                                        return country.pivot.deleted_at == null;
                                                    });

                                                    return '<input type="checkbox" class="category-checkbox" data-category-id="' +
                                                        full.id + '" ' +
                                                        (isChecked ? 'checked' : '') + '>';
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
                                            }, {
                                                data: 'creator.name',
                                                name: 'creator.name'
                                            }, {
                                                data: 'id',
                                                name: 'actions',
                                                orderable: false,
                                                searchable: false,
                                                render: function(data, type, full, meta) {
                                                    var editUrl = '{{ route('category.edit', ':id') }}'.replace(':id',
                                                        data);
                                                    var deleteFormId = 'delete-form-' + data;
                                                    var deleteUrl = '{{ route('category.destroy', ':id') }}'.replace(':id',
                                                        data);
                                                    @php
                                                        $isAdmin = in_array('Admin', array_column(Auth::user()->roles->toArray(), 'name'));
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
                                        loadAllData();
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
        function loadAllData() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('category.index') }}',
                columns: columnStructure
            });
        }

        function loadActiveData() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('getActiveCategories') }}',
                columns: columnStructure
            });
        }
        $(document).ready(function() {
            $('#table').on('click', '.is_active', function() {
                var activestatus = $(this).data('activestatus');
                var dataVal = $(this).data('val');
                var $toggle = $(this);
                var url = '/changecategoryStatus';
                handleStatusToggle($toggle, activestatus, dataVal, url);
            });
            $('#customSwitch1').on('change', function() {
                var isChecked = $(this).prop('checked');
                $('#table').DataTable().destroy();
                if (isChecked) {
                    loadActiveData();
                } else {
                    loadAllData();
                }
            });
            loadAllData();
        });


        $(document).on('click', '.category-checkbox', function() {

            var categoryId = $(this).data('category-id');
            // var countryId = $(this).data('codeselect');
            var checked = $(this).prop('checked');
            //alert(categoryId);
            var url = '/country-category';

            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                data: {
                    'id': categoryId,
                    // 'country_id': countryId,
                    'checked': checked,
                },
                success: function(data) {
                    $checkbox.prop('checked', data.deleted_at === null);
                }
            });

        });
    </script>
    {{-- <script>
        var countryId = {{ session('country')->id ?? null }};
    </script> --}}
@endpush
