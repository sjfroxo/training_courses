<nav class="sidebar top-0 start-0 p-3 bg-light"
     style="height: 100dvh; width: 300px; display: flex; flex-direction: column;">
    <div class="top-section">
        <a class="navbar-brand fs-4 text-dark" href="{{ route('courses') }}">
            <img class="mb-4" src="{{ asset('logo.svg') }}" alt="Logo"></a>
        <ul class="navbar-nav" style="list-style: none;">
            @auth
                @if(auth()->user()->isAdministrator())
                    @if(request()->routeIs('courses.show'))
                        <div class="mb-3 fw-medium">Курс: {{ $course->title }}</div>
                        <a href="{{ route('userStudyMain.show', ['id' => $course->id]) }}" class="btn btn-elprimary">< Вернуться к курсу</a>
                        <div style="display: none">{{ $i = 0 }}</div>
                        @foreach($course->modules as $module)
                            <div style="display: none">{{ $ii = 0 }}</div>
                            <ul class="nav-item" style="list-style: none; padding: 0;">
                                <li>
                                    <a href="#"
                                       class="nav-link module-btn"
                                       data-module-slug="{{ $module->slug }}"
                                       style="padding-left: 0;">
                                        {{ ++$i }}. {{ $module->title }}
                                    </a>
                                    @foreach($module->moduleExams as $moduleExam)
                                        <ul style="list-style: none; padding-left: 20px;">
                                            <li>
                                                <a href="{{ route('moduleExams.show', ['moduleExam' => $moduleExam->id]) }}"
                                                   class="nav-link module-btn"
                                                   data-module-exam-id="{{ $moduleExam->id }}"
                                                   style="font-weight: normal;">
                                                    {{ $i . '.' . ++$ii }}. {{ $moduleExam->name }}
                                                </a>
                                            </li>
                                        </ul>
                                    @endforeach
                                </li>
                            </ul>
                        @endforeach

                    @elseif(request()->routeIs('modules.create'))
                        <p>Текущий маршрут: {{ Route::currentRouteName() }}</p>
                    @elseif(request()->routeIs('modules.edit'))
                        <p>Текущий маршрут: {{ Route::currentRouteName() }}</p>
                    @else
                        <h5>Администрирование</h5>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users') ? 'active' : '' }}"
                               href="{{ route('users') }}">
                                Пользователи
                            </a>
                        </li>

                        <h5>Обучение</h5>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="coursesDropdown"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Курсы
                            </a>
                            <ul class="dropdown-menu w-100 border-0 shadow-none bg-light"
                                style="max-height: 300px; overflow-y: auto;"
                                aria-labelledby="coursesDropdown">
                                @foreach($courses as $course)
                                    <li>
                                        <div class="d-flex align-items-center m-2">
                                            <img src="{{ asset($course->image_url) }}" alt="{{ $course->title }}"
                                                 style="width: 20px; height: 20px; border-radius: 5px;">
                                            <a class="dropdown-item text-truncate {{ request()->is('courses/'.$course->slug) ? 'active' : '' }}"
                                               href="{{ route('courses.show', ['slug' => $course->slug]) }}"
                                               title="{{ $course->title }}">
                                                {{ $course->title }}
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('studentsClass.index') ? 'active' : '' }}"
                               href="{{ route('studentsClass.index') }}">
                                Учебные классы
                            </a>
                        </li>

                        <h5>Общение</h5>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('chats.index') ? 'active' : '' }}"
                               href="{{ route('chats.index') }}">
                                Чат
                            </a>
                        </li>
                    @endif

                @elseif(auth()->user()->isCurator())
                    <h5>Преподавание</h5>
                    <li class="nav-item"><a class="nav-link" href="{{ route('curator.course.index') }}">Курсы</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('curator.course.task.index') }}">Задания</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('notifications') }}">Уведомления</a>
                    </li>

                    <h5>Общение</h5>
                    <li class="nav-item"><a class="nav-link" href="{{ route('chats.index') }}">Чат</a>
                    </li>

                @elseif(auth()->user()->isUser())
                    @if(request()->routeIs('courses.show'))
                        {{ $course->title }}
                        <a href="{{ route('userStudyMain.show', ['id' => $course->id]) }}" class="btn btn-elprimary"><
                            Вернуться к курсу</a>
                        @foreach($course->modules as $module)
                            <li class="nav-item">
                                <a href="#"
                                   class="nav-link module-btn"
                                   data-module-slug="{{ $module->slug }}">
                                    {{ $module->title }}
                                </a>
                            </li>
                        @endforeach
                    @else
                        <h5>Обучение</h5>
                        <li class="nav-item dropdown d-flex">
                            <a class="nav-link d-flex align-items-center" style="margin-right: 5px;"
                               href="{{ route('courses') }}" id="coursesDropdown"
                               role="button">
                                Курсы
                            </a>
                            @if($courses->isNotEmpty())
                                <a class="nav-link dropdown-toggle d-flex align-items-center"
                                   href="{{ route('courses') }}"
                                   id="coursesDropdown"
                                   role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                <ul class="dropdown-menu w-100 border-0 shadow-none"
                                    style="max-height: 300px; overflow-y: auto;"
                                    aria-labelledby="coursesDropdown">
                                    @foreach($courses as $course)
                                        <li>
                                            <a class="dropdown-item text-truncate"
                                               href="{{ route('userStudyMain.show', ['id' => $course->id]) }}"
                                               title="{{ $course->title }}">
                                                {{ $course->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @elseif ($courses->isEmpty())
                                <p></p>
                            @endif
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-truncate" href="{{ route('notifications') }}">Уведомления</a>
                        </li>

                        <h5>Общение</h5>
                        <li class="nav-item">
                            <a class="nav-link text-truncate" href="{{ route('chats.index') }}">Чат</a>
                        </li>
                    @endif
                @endif
            @endauth
        </ul>
    </div>

    <div class="bottom-section mt-4">
        <div style="display: flex; align-items: center;">
            <img src="{{ getUserImage() }}" alt="Admin" class="rounded-circle" width="50" height="50">
            <a class="nav-link dropdown-toggle"
               style="margin-left: 10px;"
               href="#"
               id="profileDropdown"
               role="button"
               data-bs-toggle="dropdown"
               aria-expanded="false"
            >
                Профиль
            </a>
            @guest
                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="{{ route('login') }}">Войти</a></li>
                    <li><a class="dropdown-item" href="{{ route('register') }}">Зарегистрироваться</a></li>
                </ul>
            @endguest
            @auth
                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="{{ route('account.show') }}">Личный
                            кабинет</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Выйти</a></li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
