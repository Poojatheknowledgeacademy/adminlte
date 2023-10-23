@extends('layouts.app')
@section('content')
    <div id="success-message" class="alert alert-success" style="display: none;"></div>
    <div class="container-fluid">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Blog Details</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('blogs.index', $id) }}">Blog</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blogs.blogDetail.index', $id) }}">Blog
                                    Details</a></li>
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
                                <h3 class="card-title">Blog Details list</h3>
                                <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                                        href="{{ route('blogs.blogDetail.create', $id) }}"> Create New Blog Details</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Id</th>
                                                <th scope="col">Blog Name</th>
                                                <th scope="col">Meta tittle</th>
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
                                                ajax: '{{ route('blogs.blogDetail.index', $id) }}',

                                                columns: [{
                                                        data: 'id',
                                                        name: 'id'
                                                    },
                                                    {
                                                        data: 'blog.title',
                                                        name: 'blog.title'
                                                    },
                                                    {
                                                        data: 'meta_title',
                                                        name: 'meta_title'
                                                    },
                                                    {
                                                        data: 'is_active',
                                                        name: 'is_active',
                                                        render: function(data, type, full, meta) {
                                                            if (data) {
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

                                                            var editUrl = '{{ route('blogs.blogDetail.edit', [$id, ':id']) }}'
                                                                .replace(':id', data);
                                                            var deleteUrl = '{{ route('blogs.blogDetail.destroy', [$id, ':id']) }}'
                                                                .replace(':id', data);


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
               url: '/changeblogdetailsStatus',
               data: {
                   'is_active': activestatus,
                   'id': dataVal
               },
               success: function(data) {
                   if (activestatus === 1) {
                       $toggle.removeClass('text-secondary').addClass('text-primary');
                       $toggle.data('activestatus', 0);
                   } else {
                       $toggle.removeClass('text-primary').addClass('text-secondary');
                       $toggle.data('activestatus', 1);
                   }
                   $('#success-message').text(data.success).show();

               },
           });
       });
   });
</script>
@endpush
