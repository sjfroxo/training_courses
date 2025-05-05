<nav class="sidebar top-0 start-0 p-3 bg-light"
     style="height: 100dvh; width: 300px; display: flex; flex-direction: column; justify-content: space-between;">
    <div class="top-section">
        <a class="navbar-brand fs-4 text-dark" href="{{ route('courses') }}"><img class="mb-4"
                                                                                  src="{{ asset('logo.svg') }}"
                                                                                  alt="Logo"></a>
        <ul class="navbar-nav" style="list-style: none;">
            @auth
                @if(auth()->user()->isAdministrator())
                    <h5>Администрирование</h5>
                    <li class="nav-item"><a class="nav-link" href="{{ route('users') }}">Пользователи</a></li>

                    <h5>Обучение</h5>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="coursesDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Курсы
                        </a>
                        <ul class="dropdown-menu w-100 border-0 shadow-none"
                            style="max-height: 300px; overflow-y: auto;"
                            aria-labelledby="coursesDropdown">
                            @if($courses->count() > 0)
                                @foreach($courses as $course)
                                    <li>
                                        <a class="dropdown-item text-truncate"
                                           href="{{ route('courses.show', ['slug' => $course->slug]) }}"
                                           title="{{ $course->title }}">
                                            {{ $course->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li><span class="dropdown-item text-muted">Нет курсов</span></li>
                            @endif
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="{{ route('studentsClass.index') }}">Учебные классы</a>
                    </li>
                    <h5>Общение</h5>
                    <li class="nav-item"><a class="nav-link" href="{{ route('chats.index') }}">Чат</a></li>
                @elseif(auth()->user()->isCurator())
                    <h5>Преподавание</h5>
                    <li class="nav-item"><a class="nav-link" href="{{ route('curator.courses.interns.index') }}">Курсы</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Создать задание</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('notifications') }}">Уведомления</a></li>

                    <h5>Общение</h5>
                    <li class="nav-item"><a class="nav-link" href="{{ route('chats.index') }}">Чат</a></li>

                @elseif(auth()->user()->isUser())
                    <h5>Обучение</h5>
                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link d-flex align-items-center" style="margin-right: 5px;"
                           href="{{ route('courses') }}" id="coursesDropdown"
                           role="button">
                            Курсы
                        </a>
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="{{ route('courses') }}"
                           id="coursesDropdown"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                        @if($courses->count() > 0)
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
                        @elseif ($courses->count() <= 0)
                            <div>huy</div>
                        @endif
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-truncate"
                           href="{{ route('userStudyTasks.show', ['id' => $course->id]) }}">Задания</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="{{ route('notifications') }}">Уведомления</a>
                    </li>

                    <h5>Общение</h5>
                    <li class="nav-item">
                        <a class="nav-link text-truncate" href="{{ route('chats.index') }}">Чат</a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>

    <div class="bottom-section mt-auto">
        <div style="display: flex; align-items: center;">
            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="50">
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
                    <li><a class="dropdown-item" href="{{ route('account.show', ['id' => auth()->id()]) }}">Личный
                            кабинет</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Выйти</a></li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
