@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <!-- Заголовок и описание курса -->
            <div class="card-header">
                <h2>Курс {{ $studentsClass->name ?? 'Не указано' }}</h2>
                <h4>
                    @if($studentsClass->course)
                        {{ $studentsClass->course->description }}
                    @else
                        Описание курса отсутствует
                    @endif
                </h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div>
                        <h3>Практиканты:</h3>
                        <button type="button" class="btn btn-elprimary col-md-3 mb-3" data-bs-toggle="modal" data-bs-target="#addPractitionerModal">
                            Добавить практиканта +
                        </button>
                        <ul class="list-group mb-3">
                            @forelse($studentsClass->users()->wherePivot('user_role_id', \App\Enums\UserRoleEnum::USER->value)->get() as $user)
                                <li class="list-group-item">
                                    {{ $user->name }} {{ $user->surname }}
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Практиканты не добавлены</li>
                            @endforelse
                        </ul>
                    </div>

                    <div>
                        <h3>Куратор:</h3>
{{--                        @if()--}}

{{--                        @else--}}

{{--                        @endif--}}
                        <button type="button" class="btn btn-elprimary col-md-3 mb-3" data-bs-toggle="modal" data-bs-target="#addPractitionerModal">
                            Добавить куратора +
                        </button>
                        <ul class="list-group mb-3">
                            @forelse($studentsClass->users()->wherePivot('user_role_id', \App\Enums\UserRoleEnum::CURATOR->value)->get() as $user)
                                <li class="list-group-item">
                                    {{ $user->name }} {{ $user->surname }}
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Куратор не назначен</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPractitionerModal" tabindex="-1" aria-labelledby="addPractitionerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPractitionerModalLabel">Добавление практиканта в учебный класс</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('studentsClass.create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="fullName" class="form-label">ФИО</label>
                            <input type="text" class="form-control" id="fullName" name="full_name" placeholder="ФИО" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Роль</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="studentRole" value="student" checked>
                                <label class="form-check-label" for="studentRole">Студент</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="mentorRole" value="mentor">
                                <label class="form-check-label" for="mentorRole">Ментор</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@endsection
