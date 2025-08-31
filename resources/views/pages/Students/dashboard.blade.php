<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@section('title')
    {{ trans('main_trans.Main_title') }}
@stop

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="{{ trans('student2.keywords') }}" />
    <meta name="description" content="{{ trans('student2.description') }}" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
    @include('layouts.head')
</head>

<body style="font-family: 'Cairo', sans-serif">

    <div class="wrapper" style="font-family: 'Cairo', sans-serif">

        <!--=================================
        preloader -->

        <div id="pre-loader">
            <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="{{ trans('student2.loading') }}">
        </div>

        <!--=================================
        preloader -->

        @include('layouts.main-header')

        @include('layouts.main-sidebar')

        <!--=================================
        Main content -->
        <!-- main-content -->
        <div class="content-wrapper">
            <div class="page-title">
                <div class="row">
                    <div class="col-sm-6">
                        @php
                            $studentId = auth()->user()->id;
                            $balance = \App\Models\StudentAccount::where('student_id', $studentId)
                                ->selectRaw('SUM(Debit) - SUM(Credit) as remaining')
                                ->value('remaining');
                        @endphp
                        @if ($balance > 0)
                            <div class="alert alert-danger" role="alert">
                                <strong>⚠️ انتبه!</strong>
                                يتوجب عليك دفع <strong>{{ $balance }} $</strong> لإتمام سداد القسط.
                            </div>
                        @elseif ($balance < 0)
                            <div class="alert alert-success" role="alert">
                                <strong>✅ تهانينا!</strong>
                                لقد سددت كامل القسط، ويوجد لديك رصيد زائد بقيمة <strong>{{ abs($balance) }} $</strong>.
                            </div>
                        @else
                            <div class="alert alert-info" role="alert">
                                <strong>🟡 تنبيه:</strong>
                                لقد سددت كامل القسط، ولا يوجد أي مبلغ متبقي عليك.
                            </div>
                        @endif



                        <h4 class="mb-0" style="font-family: 'Cairo', sans-serif">
                            {{ trans('student2.welcome') }} : {{ auth()->user()->name }}
                        </h4>
                    </div><br><br>
                    <div class="col-sm-6">
                        <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right">
                            {{-- يمكن إضافة عناصر breadcrumb هنا --}}
                        </ol>
                    </div>
                </div>
            </div>
            <div class="calendar-main mb-30">
                <livewire:calendar-student />
            </div>

            <!--=================================
            wrapper -->

            <!--=================================
            footer -->

            @include('layouts.footer')
        </div><!-- main content wrapper end-->
    </div>
    <!--=================================
    footer -->

    @include('layouts.footer-scripts')
    @livewireScripts
    @stack('scripts')
</body>

</html>
