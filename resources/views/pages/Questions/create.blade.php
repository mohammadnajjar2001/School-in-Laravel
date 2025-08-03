@extends('layouts.master')

@section('css')
    @toastr_css
@endsection

@section('title')
    {{ trans('Questions.add_question') }}
@stop

@section('page-header')
    @section('PageTitle')
        {{ trans('Questions.add_question') }}
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
                            <form action="{{ route('Questions.store') }}" method="post" autocomplete="off">
                                @csrf
                                <div class="form-row">
                                    <div class="col">
                                        <label for="title">{{ trans('Questions.question_name') }}</label>
                                        <input type="text" name="title" class="form-control form-control-alternative" autofocus>
                                    </div>
                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="answers">{{ trans('Questions.answers') }}</label>
                                        <textarea name="answers" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                                <br>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="right_answer">{{ trans('Questions.correct_answer') }}</label>
                                        <input type="text" name="right_answer" class="form-control form-control-alternative" autofocus>
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
                                                <select class="custom-select mr-sm-2" name="quizze_id">
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
                                            <select class="custom-select mr-sm-2" name="score">
                                                <option selected disabled>{{ trans('Questions.choose_score') }}</option>
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">{{ trans('Questions.save') }}</button>
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
@endsection
