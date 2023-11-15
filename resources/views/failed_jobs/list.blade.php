{{-- resources/views/failed_jobs/list.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Failed Jobs</h1>
                    </div>
                    <div class="col-sm-12">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('failed_jobs.index') }}">Failed Jobs</a></li>
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
                                <h3 class="card-title">Failed Jobs List</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>UUID</th>
                                                <th>Connection</th>
                                                <th>Name</th>
                                                <th>Payload</th>
                                                <th>Exception</th>
                                                <th>Failed At</th>
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
                                                ajax: '{{ route('failed_jobs.index') }}',
                                                columns: [{
                                                        data: 'id',
                                                        name: 'id'
                                                    },
                                                    {
                                                        data: 'uuid',
                                                        name: 'uuid'
                                                    },
                                                    {
                                                        data: 'connection',
                                                        name: 'connection'
                                                    },
                                                    {
                                                        data: 'queue',
                                                        name: 'queue'
                                                    },
                                                    {
                                                        data: 'payload',
                                                        name: 'payload'
                                                    },
                                                    {
                                                        data: 'exception',
                                                        name: 'exception'
                                                    },
                                                    {
                                                        data: 'failed_at',
                                                        name: 'failed_at'
                                                    },
                                                    {
                                                        data: 'id',
                                                        name: 'action',
                                                        render: function(data, type, full, meta) {
                                                            return '<button class="btn btn-danger btn-sm delete-failed-job" data-failed-job-id="' +
                                                                full.id + '">Delete</button>';
                                                        }
                                                    }
                                                ]
                                            });

                                            $(document).on('click', '.delete-failed-job', function() {
                                                var failedJobId = $(this).data('failed-job-id');
                                                if (confirm('Are you sure you want to delete this failed job?')) {
                                                    $.ajax({
                                                        url: '{{ url('failed_jobs') }}/' + failedJobId,
                                                        type: 'DELETE',
                                                        headers: {
                                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                        },
                                                        success: function(response) {
                                                            console.log(response.message);

                                                            // Remove the deleted row from the DataTable
                                                            var table = $('#table').DataTable();
                                                            table.row('#row-id-' + failedJobId).remove().draw(false);
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error('Error deleting failed job:', error);
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

@push('child-scripts')
    {{-- Additional scripts if needed for failed_jobs --}}
@endpush
