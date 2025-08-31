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
@endsection

@section('js')
    @toastr_js
    @toastr_render
@endsection
