<div class="scrollbar side-menu-bg" style="overflow: scroll">
    <ul class="nav navbar-nav side-menu" id="sidebarnav">
        <!-- menu item Dashboard-->
        <li>
            <a href="{{ url('/teacher/dashboard') }}">
                <div class="pull-left"><i class="ti-home"></i><span
                        class="right-nav-text">{{ trans('main_trans.Dashboard') }}</span>
                </div>
                <div class="clearfix"></div>
            </a>
        </li>

        <!-- الاقسام-->
        <li>
            <a href="{{ route('sections') }}"><i class="fas fa-chalkboard"></i><span
                    class="right-nav-text">{{ trans('main_trans.List_section') }}</span></a>
        </li>

        <!-- الطلاب-->
        <li>
            <a href="{{ route('student.index') }}"><i class="fas fa-user-graduate"></i><span
                    class="right-nav-text">{{ trans('main_trans.Students') }}</span></a>
        </li>

        <!-- الاختبارات-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#sections-menu">
                <div class="pull-left"><i class="fas fa-chalkboard"></i><span
                        class="right-nav-text">{{ trans('main_trans.Quizzes') }}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="sections-menu" class="collapse" data-parent="#sidebarnav">
                <li><a href="{{ route('quizzes.index') }}">{{ trans('main_trans.List_Quizzes') }}</a></li>
{{--                <li><a href="{{route('questions.index')}}">{{ trans('main_trans.List_Questions') }}</a></li>--}}
            </ul>
        </li>

        <!-- Online classes-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#Onlineclasses-icon">
                <div class="pull-left"><i class="fas fa-video"></i><span class="right-nav-text">{{ trans('main_trans.Onlineclasses') }}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="Onlineclasses-icon" class="collapse" data-parent="#sidebarnav">
                <li><a href="{{ route('online_zoom_classes.index') }}">{{ trans('main_trans.Online_Classes_With_Zoom') }}</a></li>
            </ul>
        </li>

        <!-- sections-->
        <li>
            <a href="javascript:void(0);" data-toggle="collapse" data-target="#sections-menu1">
                <div class="pull-left"><i class="fas fa-chalkboard"></i><span
                        class="right-nav-text">{{ trans('main_trans.Reports') }}</span></div>
                <div class="pull-right"><i class="ti-plus"></i></div>
                <div class="clearfix"></div>
            </a>
            <ul id="sections-menu1" class="collapse" data-parent="#sidebarnav">
                <li><a href="{{ route('attendance.report') }}">{{ trans('main_trans.Attendance_Report') }}</a></li>
            </ul>
        </li>

        <!-- الملف الشخصي-->
        <li>
            <a href="{{ route('profile.show') }}"><i class="fas fa-id-card-alt"></i><span
                    class="right-nav-text">{{ trans('main_trans.Profile') }}</span></a>
        </li>

    </ul>
</div>
