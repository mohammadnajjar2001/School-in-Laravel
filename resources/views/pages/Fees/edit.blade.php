@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    {{ trans('Fees.edit_fee') }}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    {{ trans('Fees.edit_fee') }}
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

                    <form action="{{ route('Fees.update', 'test') }}" method="post" autocomplete="off">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="form-group col">
                                <label>{{ trans('Fees.name_ar') }}</label>
                                <input type="text" value="{{ $fee->getTranslation('title','ar') }}" name="title_ar" class="form-control">
                                <input type="hidden" value="{{ $fee->id }}" name="id" class="form-control">
                            </div>

                            <div class="form-group col">
                                <label>{{ trans('Fees.name_en') }}</label>
                                <input type="text" value="{{ $fee->getTranslation('title','en') }}" name="title_en" class="form-control">
                            </div>

                            <div class="form-group col">
                                <label>{{ trans('Fees.amount') }}</label>
                                <input type="number" value="{{ $fee->amount }}" name="amount" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col">
                                <label>{{ trans('Fees.grade') }}</label>
                                <select class="custom-select mr-sm-2" name="Grade_id">
                                    @foreach($Grades as $Grade)
                                        <option value="{{ $Grade->id }}" {{ $Grade->id == $fee->Grade_id ? 'selected' : '' }}>
                                            {{ $Grade->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col">
                                <label>{{ trans('Fees.classroom') }}</label>
                                <select class="custom-select mr-sm-2" name="Classroom_id">
                                    <option value="{{ $fee->Classroom_id }}">{{ $fee->classroom->Name_Class }}</option>
                                </select>
                            </div>

                            <div class="form-group col">
                                <label>{{ trans('Fees.year') }}</label>
                                <select class="custom-select mr-sm-2" name="year">
                                    @php $current_year = date("Y") @endphp
                                    @for($year = $current_year; $year <= $current_year + 1; $year++)
                                        <option value="{{ $year }}" {{ $year == $fee->year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ trans('Fees.description') }}</label>
                            <textarea class="form-control" name="description" rows="4">{{ $fee->description }}</textarea>
                        </div>
                        <br>

                        <button type="submit" class="btn btn-primary">{{ trans('Fees.submit') }}</button>
                    </form>

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
