@extends('layouts.app')

@section('main')
    @include('components.curator.course-header', ['active' => 'tasks'])

    @php $required = '<span class="text-danger">*</span>' @endphp

    <section class="mt-5">
        <form action="{{ route('curator.courses.tasks.store') }}" method="POST" class="form-control">
            @csrf
            <div class="w-25">
                <label for="name" class="form-label">Название {!! $required !!}</label>
                <input type="text" name="name" class="input-group">
            </div>

            <div class="w-25">
                <label for="description" class="form-label">Описание</label>
                <textarea name="description" class="input-group"></textarea>
            </div>

            <div class="w-25">
                <label for="users">Для кого {!! $required !!}</label>

                <select name="users" multiple>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} {{ $user->surname }}</option>
                    @endforeach
                </select>
            </div>

            <div class="w-25">
                <label for="deadline" class="form-label">Срок сдачи</label>
                <input type="date" name="deadline" class="input-group">
            </div>

            <div class="d-flex justify-content-between align-items-center w-50 mt-3">
                <a href="{{ redirect()->back() }}">Отмена</a>
{{--                <button type="submit" class="btn">Сохранить как черновик</button>--}}
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </section>
@endsection
