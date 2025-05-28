@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة الحضور والغياب للطلاب
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    قائمة الحضور والغياب للطلاب
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




    <form method="post" action="{{ route('Attendance.store') }}">
        @csrf

        <div class="mb-3 ">
            <label for="attendence_date" style="font-family: 'Cairo', sans-serif; font-weight: bold;">اختر التاريخ:</label>
            <input type="date" name="attendence_date" id="attendence_date" class="form-control bg-success"
                   value="{{ request('attendence_date', date('Y-m-d')) }}" required>
        </div>

        {{-- الحقول العامة مرة واحدة فقط --}}
        <input type="hidden" name="grade_id" value="{{ $students[0]->Grade_id ?? '' }}">
        <input type="hidden" name="classroom_id" value="{{ $students[0]->Classroom_id ?? '' }}">
        <input type="hidden" name="section_id" value="{{ $students[0]->section_id ?? '' }}">

        <table class="table table-hover table-sm table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('Students_trans.name') }}</th>
                    <th>{{ trans('Students_trans.email') }}</th>
                    <th>{{ trans('Students_trans.gender') }}</th>
                    <th>{{ trans('Students_trans.Grade') }}</th>
                    <th>{{ trans('Students_trans.classrooms') }}</th>
                    <th>{{ trans('Students_trans.section') }}</th>
                    <th>{{ trans('Students_trans.Processes') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    @php
                        $selectedDate = request('attendence_date', date('Y-m-d'));
                        $attendance = $student->attendance()->where('attendence_date', $selectedDate)->first();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->gender->Name }}</td>
                        <td>{{ $student->grade->Name }}</td>
                        <td>{{ $student->classroom->Name_Class }}</td>
                        <td>{{ $student->section->Name_Section }}</td>
                        <td>
                            {{-- @if($attendance)
                                <label>
                                    <input type="radio" disabled {{ $attendance->attendence_status ? 'checked' : '' }}>
                                    <span class="text-success">حضور</span>
                                </label>
                                <label>
                                    <input type="radio" disabled {{ !$attendance->attendence_status ? 'checked' : '' }}>
                                    <span class="text-danger">غياب</span>
                                </label>
                            @else --}}
                                <label>
                                    <input type="radio" name="attendences[{{ $student->id }}]" value="presence" required>
                                    <span class="text-success">حضور</span>
                                </label>
                                <label>
                                    <input type="radio" name="attendences[{{ $student->id }}]" value="absent">
                                    <span class="text-danger">غياب</span>
                                </label>
                            {{-- @endif --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">حفظ الحضور</button>
    </form>

    <br>
    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
