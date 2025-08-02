@extends('layouts.master')

@section('css')
    @toastr_css
@endsection

@section('title')
    {{ trans('Questions.page_title') }}
@stop

@section('page-header')
    @section('PageTitle')
        {{ trans('Questions.page_title') }}
    @stop
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <a href="{{ route('Questions.create') }}" class="btn btn-success btn-sm" role="button" aria-pressed="true">
                                    {{ trans('Questions.add_question') }}
                                </a>
                                <br><br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table table-hover table-sm table-bordered p-0" data-page-length="50" style="text-align: center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>{{ trans('Questions.question') }}</th>
                                                <th>{{ trans('Questions.answers') }}</th>
                                                <th>{{ trans('Questions.correct_answer') }}</th>
                                                <th>{{ trans('Questions.score') }}</th>
                                                <th>{{ trans('Questions.quiz_name') }}</th>
                                                <th>{{ trans('Questions.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($questions as $question)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $question->title }}</td>
                                                    <td>{{ $question->answers }}</td>
                                                    <td>{{ $question->right_answer }}</td>
                                                    <td>{{ $question->score }}</td>
                                                    <td>{{ $question->quizze->name }}</td>
                                                    <td>
                                                        <a href="{{ route('Questions.edit', $question->id) }}" class="btn btn-info btn-sm" role="button" aria-pressed="true" title="{{ trans('Questions.edit') }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                                data-target="#delete_exam{{ $question->id }}" title="{{ trans('Questions.delete') }}">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @include('pages.Questions.destroy')
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
