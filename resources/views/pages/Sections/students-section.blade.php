@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{ trans('main_trans.StudentsAttendanceList') }}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    {{ trans('main_trans.StudentsAttendanceList') }}
@stop

<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-danger">
            <ul>
                <li>{{ session('status') }}</li>
            </ul>
        </div>
    @endif



    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
    style="text-align: center">
 <thead>
 <tr>
     <th class="alert-success">#</th>
     <th class="alert-success">{{ trans('Students_trans.name') }}</th>
     <th class="alert-success">{{ trans('Students_trans.email') }}</th>
     <th class="alert-success">{{ trans('Students_trans.gender') }}</th>
     <th class="alert-success">{{ trans('Students_trans.Grade') }}</th>
     <th class="alert-success">{{ trans('Students_trans.classrooms') }}</th>
     <th class="alert-success">{{ trans('Students_trans.section') }}</th>
     {{-- <th class="alert-success">{{ trans('Students_trans.Processes') }}</th> --}}
 </tr>
 </thead>
 <tbody>
 @foreach ($students as $student)
     <tr>
         <td>{{ $loop->index + 1 }}</td>
         <td>{{ $student->name }}</td>
         <td>{{ $student->email }}</td>
         <td>{{ $student->gender->Name }}</td>
         <td>{{ $student->grade->Name }}</td>
         <td>{{ $student->classroom->Name_Class }}</td>
         <td>{{ $student->section->Name_Section }}</td>

     </tr>
 @endforeach
 </tbody>
</table>


@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
