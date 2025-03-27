@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                Подробнее
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Имя:</strong> {{ $user->name }}
                </div>
                <div class="mb-3">
                    <strong>Фамилия:</strong> {{ $user->surname }}
                </div>
                <div class="mb-3">
                    <strong>Почта:</strong> {{ $user->email }}
                </div>
                <div class="mb-3">
                    <strong>Роль:</strong> {{ $user->role->title }}
                </div>
                <div class="mb-3">
                    <strong>Дата регистрации:</strong> {{ $user->created_at->format('M d, Y') }}
                </div>
                <div class="mb-3">
                    <div class="dropdown mt-2">
                        <button class="btn btn-secondary dropdown-toggle w-25" type="button" id="coursesDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Курсы {{ count($user->courses) }}
                        </button>
                        <ul class="dropdown-menu w-50 p-3" style="max-height: 350px; overflow-y: auto;">
                            @foreach($courses as $course)
                                <li class="container mt-2">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <a class="dropdown-item" href="#">{{ $course->title }}</a>
                                        </div>
                                        <div class="col-md-4">
                                            @if($user->courses->contains($course))
                                                @php
                                                    $pivot = $user->courses->where('id', $course->id)->first()->pivot;
                                                @endphp
                                                <form action="{{ route('userCourses.destroy', ['user' => $user->id, 'userCourse' => $pivot->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Лишить курса</button>
                                                </form>
                                            @else
                                                <form action="{{ route('userCourses.store') }}" method="POST">
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <input type="hidden" name="progress" value="0">
                                                    @csrf
                                                    <button class="btn btn-success" type="submit">Добавить курс</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                @if(Auth::check() && Auth::user()->isAdministrator())
                    <div class="mt-4">
                        <h5 class="mb-3">Активность на курсе</h5>
                        <div class="card p-3" style="border: none; background-color: #fff;">
                            {!! $calendarHtml ?? '<p>Нет данных об активности.</p>' !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">Редактировать</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Удалить</button>
                </form>
            </div>
        </div>
    </div>
@endsection
