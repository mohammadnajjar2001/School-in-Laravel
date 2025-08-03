@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{ __('library.add_new_book') }}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    {{ __('library.add_new_book') }}
@stop
<!-- breadcrumb -->
@endsection
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

                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <br>
                            <form action="{{ route('library.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">

                                    <div class="col">
                                        <label for="title">{{ __('library.book_name') }}</label>
                                        <input type="text" name="title" class="form-control" required>
                                    </div>

                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="Grade_id">{{ trans('Students_trans.Grade') }} : <span class="text-danger">*</span></label>
                                            <select class="custom-select mr-sm-2" name="Grade_id" required>
                                                <option selected disabled>{{ __('library.choose') }}...</option>
                                                @foreach($grades as $grade)
                                                    <option value="{{ $grade->id }}">{{ $grade->Name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="Classroom_id">{{ trans('Students_trans.classrooms') }} : <span class="text-danger">*</span></label>
                                            <select class="custom-select mr-sm-2" name="Classroom_id" required>
                                                <!-- سيتم ملؤه عبر AJAX -->
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="form-group">
                                            <label for="section_id">{{ trans('Students_trans.section') }} : </label>
                                            <select class="custom-select mr-sm-2" name="section_id">
                                                <!-- سيتم ملؤه عبر AJAX -->
                                            </select>
                                        </div>
                                    </div>

                                </div><br>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="academic_year">{{ __('library.attachments') }} : <span class="text-danger">*</span></label>
                                            <input type="file" accept="application/pdf" name="file_name" required>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">{{ __('library.save_data') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
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
                            $('select[name="Classroom_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="Classroom_id"]').append('<option value="' + key + '">' + value + '</option>');
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
