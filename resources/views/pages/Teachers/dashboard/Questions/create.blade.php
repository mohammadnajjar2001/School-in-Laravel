@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافة سؤال جديد
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    اضافة سؤال جديد
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">

                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="col-xs-12">
                        <div class="col-md-12">
                            <br>
                            {{-- <form action="{{ route('questions.store') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="form-row">

                                    <div class="col">
                                        <label for="title">اسم السؤال</label>
                                        <input type="text" name="title" id="input-name"
                                               class="form-control form-control-alternative" autofocus>
                                        <input type="hidden" value="{{$quizze_id}}" name="quizz_id">
                                    </div>
                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="title"> الاجابات <span style="color: red; font-size: smaller"> يجب فصل بعلامه - بين الاسئلة</span> </label>
                                        <textarea name="answers" class="form-control" id="exampleFormControlTextarea1"
                                                  rows="4"></textarea>
                                    </div>
                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="title">الاجابة الصحيحة</label>
                                        <input type="text" name="right_answer" id="input-name"
                                               class="form-control form-control-alternative" autofocus>
                                    </div>
                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="Grade_id">الدرجة : <span class="text-danger">*</span></label>
                                            <select class="custom-select mr-sm-2" name="score">
                                                <option selected disabled> حدد الدرجة...</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">حفظ البيانات</button>
                            </form> --}}
                              <form action="{{ route('questions.store') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="form-row">
                                    <div class="col">
                                        <label for="title">{{ trans('Questions.question_name') }}</label>
                                        <input type="text" name="title" class="form-control" autofocus>
                                    </div>
                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        <label>{{ trans('Questions.answers') }}</label>
                                        @for ($i = 1; $i <= 4; $i++)
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <input type="radio" name="right_answer" value="{{ $i }}" required>
                                                    </div>
                                                </div>
                                                <input type="text" name="answers[]" class="form-control" placeholder="Answer {{ $i }}">
                                            </div>
                                        @endfor
                                        <small class="text-muted">اختر الصحيح عبر الراديو</small>
                                    </div>
                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="quizze_id">{{ trans('Questions.quiz_name') }} <span class="text-danger">*</span></label>
                                            @if(isset($quizze_id))
                                                <input type="hidden" name="quizze_id" value="{{ $quizze_id }}">
                                                <input type="text" class="form-control" value="{{ \App\Models\Quizze::find($quizze_id)?->name }}" disabled>
                                            @else
                                                <select class="custom-select mr-sm-2" name="quizze_id" required>
                                                    <option selected disabled>{{ trans('Questions.choose_quiz') }}</option>
                                                    @foreach($quizzes as $quizze)
                                                        <option value="{{ $quizze->id }}">{{ $quizze->name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="score">{{ trans('Questions.score') }} <span class="text-danger">*</span></label>
                                            <input type="number" name="score" class="form-control" min="1" required>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">
                                    {{ trans('Questions.save') }}
                                </button>
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
@endsection
