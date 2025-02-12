{{--<nav class="navbar navbar-expand-lg navbar-light bg-light">--}}
{{--    <div class="container-fluid">--}}
{{--        <a class="navbar-brand pl-20" href="{{route('courses')}}">Главная</a>--}}
{{--        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"--}}
{{--                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--            <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}
{{--        <div class=" navbar-collapse" id="navbarNavDropdown">--}}
{{--            <ul class="navbar-nav d-flex justify-content-end">--}}
{{--                @auth--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('courses')}}">Курсы</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('users')}}">Пользователи</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="{{route('chats.index')}}">Чаты</a>--}}
{{--                    </li>--}}
{{--                @endauth--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--        <div class=" dropdown  pr-20">--}}
{{--            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"--}}
{{--               data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                Профиль--}}
{{--            </a>--}}
{{--            @guest--}}
{{--                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                    <li><a class="dropdown-item" href="{{route('login')}}">Войти</a></li>--}}
{{--                    <li><a class="dropdown-item" href="{{route('register')}}">Зарегистрироваться</a></li>--}}


{{--                </ul>--}}
{{--            @endguest--}}
{{--            @auth--}}
{{--                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                    <li><a class="dropdown-item" href="{{route('account.show',['id' => auth()->id()])}}">Личный кабинет</a></li>--}}
{{--                    <li><a class="dropdown-item" href="{{route('logout')}}">Выйти</a></li>--}}
{{--                </ul>--}}
{{--            @endauth--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</nav>--}}

{{--<link rel="stylesheet" href="/resources/css/style.css">--}}
<nav class="sidebar"
     style="height: 100vh; width: 13%; display: flex; flex-direction: column; justify-content: space-between;">
    <div class="top-section">
        <a class="navbar-brand" href="{{route('courses')}}"><.Jarovit></a>
        <ul class="navbar-nav" style="list-style: none;">
            @auth
                @if(auth()->user()->isAdministrator())
                    <h4>Администрирование</h4>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('users')}}">Пользователи</a>
                    </li>
                    <h4>Обучение</h4>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('courses') }}">Курсы</a>
                        <ul style="height: 400px; overflow-y: scroll; list-style: none;">
                            @foreach($courses as $course)
                                <li>
                                    <a class="nav-link" href="{{ route('courses.show', ['slug' => $course->slug]) }}">+ {{ $course->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('courses')}}">Учебные классы</a>
                    </li>
                @elseif (auth()->user()->isCurator())
                    <h4>Преподавания</h4>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('courses')}}">Курсы</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('courses.create')}}">Создать задание</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('notifications')}}">Уведомления</a>
                    </li>
                    <h4>Общение</h4>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('chats.index')}}">Чат</a>
                    </li>
                @elseif(auth()->user()->isUser())
                    <h4>Обучение</h4>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('courses')}}">Курсы</a>
                        @foreach($courses as $course)
                            <a
                                class="nav-link"
                                href="{{ route('courses.show', ['slug' => $course->slug]) }}">Курс: {{ $course->title }}
                            </a>
                        @endforeach
                    </li>
                    <li class="nav-item">
                        {{--                    <a class="nav-link" href="{{route('')}}">Задания</a>--}}
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('notifications')}}">Уведомления</a>
                    </li>
                    <h4>Общение</h4>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('chats.index')}}">Чат</a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
    <div class="bottom-section" style="margin-bottom: 50px;">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
           data-bs-toggle="dropdown" aria-expanded="false">
            Профиль
        </a>
        @guest
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="{{route('login')}}">Войти</a></li>
                <li><a class="dropdown-item" href="{{route('register')}}">Зарегистрироваться</a></li>
            </ul>
        @endguest
        @auth
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="{{route('account.show',['id' => auth()->id()])}}">Личный кабинет</a>
                </li>
                <li><a class="dropdown-item" href="{{route('logout')}}">Выйти</a></li>
            </ul>
        @endauth
    </div>
</nav>

<div class="content">
    <!-- Ваш основной контент здесь -->
</div>
