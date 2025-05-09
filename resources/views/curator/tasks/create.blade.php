@extends('layouts.app')

@section('main')
    <section>
        @include('components.curator.course-header', ['active' => 'tasks'])

        @php $required = '<span class="text-danger">*</span>' @endphp

        <section class="mt-5">
            <form action="{{ route('curator.courses.tasks.store') }}" method="POST">
                @csrf
                <div>
                    <label for="name" class="form-label">Название {!! $required !!}</label>
                    <input type="text" name="name" class="form-control">
                </div>

                <div>
                    <label for="description" class="form-label">Описание</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div>
                    <label for="users">Для кого {!! $required !!}</label>
                    <select name="users" multiple class="form-select">
                        @forelse($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }}</option>
                        @empty
                            <h1>На курсе ещё нет пользователей!</h1>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label for="deadline" class="form-label">Срок сдачи</label>
                    <input type="date" name="deadline" class="form-control">
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ redirect()->back() }}">Отмена</a>
                    {{--                <button type="submit" class="btn">Сохранить как черновик</button>--}}
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </section>
    </section>
@endsection
