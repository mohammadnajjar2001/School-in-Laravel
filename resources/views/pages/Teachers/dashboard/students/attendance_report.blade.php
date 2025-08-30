@extends('layouts.master')
@section('css')

@section('title')
    {{ trans('attendance_trans.AttendanceReport') }}
@stop
@endsection

@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    {{ trans('attendance_trans.AttendanceReports') }}
@stop
<!-- breadcrumb -->

@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('attendance.search') }}" autocomplete="off">
                    @csrf
                    <h6 style="font-family: 'Cairo', sans-serif;color: blue">
                        {{ trans('attendance_trans.SearchInformation') }}
                    </h6>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="student">{{ trans('attendance_trans.Students') }}</label>
                                <select class="custom-select mr-sm-2" name="student_id">
                                    <option value="0">{{ trans('attendance_trans.All') }}</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-body datepicker-form">
                            <div class="input-group" data-date-format="yyyy-mm-dd">
                                <input type="text" class="form-control range-from date-picker-default"
                                       placeholder="{{ trans('attendance_trans.StartDate') }}" required name="from">
                                <span class="input-group-addon">{{ trans('attendance_trans.EndDate') }}</span>
                                <input class="form-control range-to date-picker-default"
                                       placeholder="{{ trans('attendance_trans.EndDate') }}" type="text" required name="to">
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">
                        {{ trans('attendance_trans.Submit') }}
                    </button>
                </form>

                @isset($Students)
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="50"
                           style="text-align: center">
                        <thead>
                        <tr>
                            <th class="alert-success">{{ trans('attendance_trans.Number') }}</th>
                            <th class="alert-success">{{ trans('attendance_trans.Name') }}</th>
                            <th class="alert-success">{{ trans('attendance_trans.Grade') }}</th>
                            <th class="alert-success">{{ trans('attendance_trans.Section') }}</th>
                            <th class="alert-success">{{ trans('attendance_trans.Date') }}</th>
                            <th class="alert-warning">{{ trans('attendance_trans.Status') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($Students as $student)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $student->students->name }}</td>
                                <td>{{ $student->grade->Name }}</td>
                                <td>{{ $student->section->Name_Section }}</td>
                                <td>{{ $student->attendence_date }}</td>
                                <td>
                                    @if($student->attendence_status == 0)
                                        <span class="btn-danger">{{ trans('attendance_trans.Absent') }}</span>
                                    @else
                                        <span class="btn-success">{{ trans('attendance_trans.Present') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @include('pages.Students.Delete')
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endisset

            </div>
        </div>
    </div>
</div>
<!-- row closed -->
@endsection

@section('js')

@endsection
