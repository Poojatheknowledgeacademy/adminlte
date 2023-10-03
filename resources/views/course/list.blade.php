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
                  <li class="breadcrumb-item"><a href="#">Course</a></li>
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
                     <h3 class="card-title">Course</h3>
                     <div class="float-right"> <a class="btn btn-block btn-sm btn-success"
                        href="{{ route('course.create') }}"> Create Course</a>
                     </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                     <table class="table table-bordered">
                        <thead>
                           <tr>
                              <th scope="col">Id</th>
                              <th scope="col">Topic Name</th>
                              <th scope="col">Course Name</th>
                              <th scope="col">Is_Active</th>
                              <th scope="col">Created_by</th>
                              <th>Created date</th>
                              <th>Created time</th>
                              <th scope="col">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @foreach ($course as $courses)
                           <tr>
                              <td>{{ $courses->id }}</td>

                              <td>{{$courses->Topic->name }}</td>

                              {{-- <td></td> --}}
                              <td>{{ $courses->name }}</td>

                              <td>
                                @if ($courses->is_active == 1)
                                    <i class="fas fa-toggle-on text-primary"></i>
                                @else
                                    <i class="fas fa-toggle-on text-secondary"></i>
                                @endif
                            </td>


                              @if ($courses->createdBy)
                              <td>
                                 {{ $courses->createdBy->name }}
                              </td>
                              @else
                              <td>-</td>
                              @endif
                              <td>{{ $courses->updated_at->format('Y-m-d') }}</td>
                              <td>{{ $courses->updated_at->format('H:i:s') }}</td>

                              <td>
                                <a href="{{ route('course.edit', $courses->id) }}"><i
                                        class="fas fa-edit"></i></a>

                                <a href="{{ route('course.destroy', $courses->id) }}"
                                    class="delete-link"
                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $courses->id }}').submit();">
                                    <i class="fas fa-trash text-danger"></i>
                                    <!-- Move the closing </i> tag here -->
                                </a>
                                <form id="delete-form-{{ $courses->id }}"
                                    action="{{ route('course.destroy', $courses->id) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                           </tr>
                           @endforeach
                        </tbody>
                     </table>
                  </div>
                  <div class="card-footer clearfix">
                     <ul class="pagination pagination-sm m-0 float-right">
                        {{ $course->links('pagination::bootstrap-4') }}
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection
