@extends('layouts.master')
@section('css')
    @toastr_css
@endsection

@section('title')
    {{ trans('Quizzes.title_page') }}
@stop

@section('page-header')
    @section('PageTitle')
        {{ trans('Quizzes.title_page') }}
    @stop
@endsection

@section('content')
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

                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <br>
                            <form action="{{ route('Quizzes.store') }}" method="post" autocomplete="off">
                                @csrf

                                <div class="form-row">
                                    <div class="col">
                                        <label for="title">{{ trans('Quizzes.quiz_name_ar') }}</label>
                                        <input type="text" name="Name_ar" class="form-control">
                                    </div>

                                    <div class="col">
                                        <label for="title">{{ trans('Quizzes.quiz_name_en') }}</label>
                                        <input type="text" name="Name_en" class="form-control">
                                    </div>
                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="Grade_id">{{ trans('Quizzes.subject') }} : <span class="text-danger">*</span></label>
                                            <select class="custom-select mr-sm-2" name="subject_id">
                                                <option selected disabled>{{ trans('Quizzes.select_subject') }}</option>
                                                @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="Grade_id">{{ trans('Quizzes.teacher') }} : <span class="text-danger">*</span></label>
                                            <select class="custom-select mr-sm-2" name="teacher_id">
                                                <option selected disabled>{{ trans('Quizzes.select_teacher') }}</option>
                                                @foreach($teachers as $teacher)
                                                    <option value="{{ $teacher->id }}">{{ $teacher->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="Grade_id">{{ trans('Students_trans.Grade') }} : <span class="text-danger">*</span></label>
                                            <select class="custom-select mr-sm-2" name="Grade_id">
                                                <option selected disabled>{{ trans('Parent_trans.Choose') }}...</option>
                                                @foreach($grades as $grade)
                                                    <option value="{{ $grade->id }}">{{ $grade->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="Classroom_id">{{ trans('Students_trans.classrooms') }} : <span class="text-danger">*</span></label>
                                            <select class="custom-select mr-sm-2" name="Classroom_id"></select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="section_id">{{ trans('Students_trans.section') }} : </label>
                                            <select class="custom-select mr-sm-2" name="section_id"></select>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">
                                    {{ trans('Quizzes.save') }}
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function () {
            $('select[name="Grade_id"]').on('change', function () {
                var Grade_id = $(this).val();
                if (Grade_id) {
                    $.ajax({
                        url: "{{ URL::to('classes') }}/" + Grade_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="Class_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="Class_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>
@endsection
