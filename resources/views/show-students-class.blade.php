@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h2>Класс: {{ $studentsClass->name ?? 'Не указано' }}</h2>
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
                    <div class="col-md-6">
                        <h3>Практиканты</h3>
                        <button type="button" class="btn btn-elprimary mb-3" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            Добавить практиканта +
                        </button>
                        <ul class="list-group mb-3">
                            @forelse($studentsClass->users()
                                ->select('users.*')
                                ->wherePivot('user_role_id', \App\Enums\UserRoleEnum::USER->value)
                                ->get() as $student)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $student->name }} {{ $student->surname }}</span>
                                    <form action="{{ route('studentsClass.deleteUser', ['studentsClass' => $studentsClass->id, 'userId' => $student->id]) }}" method="POST" onsubmit="return confirm('Удалить этого практиканта?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6zm3-.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-2h3.1a1 1 0 0 1.9-.6h2a1 1 0 0 1.9.6h3.1a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H3v-1h-.5a.5.5 0 0 0-.5.5z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Практиканты не добавлены</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="col-md-6">
                        <h3>Куратор</h3>
                        @php
                            $curator = $studentsClass->users()
                                ->select('users.*')
                                ->wherePivot('user_role_id', \App\Enums\UserRoleEnum::CURATOR->value)
                                ->first();
                        @endphp
                        <button type="button" class="btn btn-elprimary mb-3" data-bs-toggle="modal" data-bs-target="#addCuratorModal" @if($curator) disabled @endif>
                            Добавить куратора +
                        </button>
                        <ul class="list-group mb-3">
                            @if($curator)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $curator->name }} {{ $curator->surname }}</span>
                                    <form action="{{ route('studentsClass.deleteUser', ['studentsClass' => $studentsClass->id, 'userId' => $curator->id]) }}" method="POST" onsubmit="return confirm('Удалить куратора?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5.5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6zm3-.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-2h3.1a1 1 0 0 1.9-.6h2a1 1 0 0 1.9.6h3.1a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3a.5.5 0 0 0 0 1H3v-1h-.5a.5.5 0 0 0-.5.5z"/>
                                            </svg>
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li class="list-group-item text-muted">Куратор не назначен</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $existingStudentIds = $studentsClass->users()
            ->select('users.id')
            ->wherePivot('user_role_id', \App\Enums\UserRoleEnum::USER->value)
            ->pluck('id')
            ->toArray();
        $availableStudents = \App\Models\User::query()
            ->where('user_role_id', \App\Enums\UserRoleEnum::USER->value)
            ->whereNotIn('id', $existingStudentIds)
            ->get();
    @endphp
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Добавить практикантов</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('studentsClass.addStudents', $studentsClass) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="student_ids" class="form-label">Выберите практикантов</label>
                            <select class="form-control" id="student_ids" name="student_ids[]" multiple required>
                                @foreach($availableStudents as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }} {{ $student->surname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(!$curator)
        <div class="modal fade" id="addCuratorModal" tabindex="-1" aria-labelledby="addCuratorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCuratorModalLabel">Добавить куратора</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('studentsClass.addCurator', $studentsClass) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="curator_id" class="form-label">Выберите куратора</label>
                                <select class="form-control" id="curator_id" name="curator_id" required>
                                    @foreach(\App\Models\User::query()->where('user_role_id', \App\Enums\UserRoleEnum::CURATOR->value)->get() as $candidate)
                                        <option value="{{ $candidate->id }}">{{ $candidate->name }} {{ $candidate->surname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endsection
