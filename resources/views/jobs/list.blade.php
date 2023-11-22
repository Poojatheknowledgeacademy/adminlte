{{-- resources/views/queues/list.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Jobs</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Jobs</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Jobs List</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Attempts</th>
                                                <th>Payload</th>
                                                <th>Available At</th>
                                                <th>Created At</th>
                                                <th>Action</th>
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
                                                ajax: '{{ route('jobs.index') }}',
                                                columns: [{
                                                        data: 'id',
                                                        name: 'id'
                                                    },
                                                    {
                                                        data: 'queue',
                                                        name: 'queue'
                                                    },
                                                    {
                                                        data: 'attempts',
                                                        name: 'attempts'
                                                    },
                                                    {
                                                        data: 'payload',
                                                        name: 'payload'
                                                    },
                                                    {
                                                        data: 'available_at',
                                                        name: 'available_at'
                                                    },
                                                    {
                                                        data: 'created_at',
                                                        name: 'created_at'
                                                    },
                                                    {
                                                        data: 'id',
                                                        name: 'action',
                                                        render: function(data, type, full, meta) {
                                                            return '<i class="fas fa-trash text-danger delete-job" data-job-id="' +
                                                                full.id + '" style="cursor: pointer;"></i>';

                                                        }
                                                    }
                                                ]
                                            });

                                            $(document).on('click', '.delete-job', function() {
                                                var jobId = $(this).data('job-id');
                                                if (confirm('Are you sure you want to delete this job?')) {
                                                    $.ajax({
                                                        url: '{{ url('jobs') }}/' + jobId,
                                                        type: 'DELETE',
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        success: function(response) {
                                                            console.log(response.message);
                                                            $('#table').DataTable().ajax.reload();
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error('Error deleting job:', error);
                                                        }
                                                    });
                                                }
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
