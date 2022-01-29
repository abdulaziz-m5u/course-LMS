<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt">

                    </i>
                    Dashboard
                </a>
            </li>
            @can('course_access')
            <li class="nav-item">
                <a href="{{ route('admin.courses.index') }}" class="nav-link {{ request()->is('admin/courses') || request()->is('admin/courses/*') ? 'active' : '' }}">
                    <i class="fas fa-gift nav-icon"></i>
                    Courses
                </a>
            </li>
            @endcan
            @can('lesson_access')
            <li class="nav-item">
                <a href="{{ route('admin.lessons.index') }}" class="nav-link {{ request()->is('admin/lessons') || request()->is('admin/lessons/*') ? 'active' : '' }}">
                    <i class="fas fa-gift nav-icon"></i>
                    Lesson
                </a>
            </li>
            @endcan
            @can('test_access')
            <li class="nav-item">
                <a href="{{ route('admin.tests.index') }}" class="nav-link {{ request()->is('admin/tests') || request()->is('admin/tests/*') ? 'active' : '' }}">
                    <i class="fas fa-gift nav-icon"></i>
                    Test
                </a>
            </li>
            @endcan
            @can('question_access')
            <li class="nav-item">
                <a href="{{ route('admin.questions.index') }}" class="nav-link {{ request()->is('admin/questions') || request()->is('admin/questions/*') ? 'active' : '' }}">
                    <i class="fas fa-gift nav-icon"></i>
                    Question
                </a>
            </li>
            @endcan
            @can('questions_option_access')
            <li class="nav-item">
                <a href="{{ route('admin.question_options.index') }}" class="nav-link {{ request()->is('admin/question_options') || request()->is('admin/question_options/*') ? 'active' : '' }}">
                    <i class="fas fa-gift nav-icon"></i>
                    Question Option
                </a>
            </li>
            @endcan
            @can('user_access')
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                    <i class="fas fa-gift nav-icon"></i>
                    User
                </a>
            </li>
            @endcan
            <li class="nav-item">
                <a href="#" onclick="getElementById('logout-form').submit()" class="nav-link">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt">

                    </i>
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="post">
                    @csrf 
                </form>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>