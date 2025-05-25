@extends('layouts.app')

@section('main')
    <section class="w-100">

        @include('components.curator.course-header', ['active' => 'interns'])

        <section>
            <form action="{{ route('curator.course.intern.index') }}" class="w-25 mb-5">
                <input class="form-control mt-5" name="intern" type="text" placeholder="Поиск практикантов">
                <a class="btn float-end" href="{{ route('curator.course.intern.index') }}">Сбросить фильтры</a>
            </form>

            <ul class="list-group mt-3 w-25">
                @forelse($interns as $intern)
                    <li class="list-group-item d-flex gap-2 justify-content-center">
                        <a href="{{ route('curator.course.intern.show', $intern->id) }}">
                            <div style="
                                width: 36px;
                                height: 36px;
                                background-color: #513DEB;
                                color: white;
                                display:flex;
                                justify-content: center;
                                align-items: center;
                                border-radius: 10px;
                            ">
                                {{ mb_strtoupper($intern->name[0]) }}
                            </div>
                            <p>{{ $intern->name }} {{ $intern->surname }}</p>
                        </a>
                    </li>
                @empty
                    <h1 class="alert-heading">Практиканты отсутствуют!</h1>
                @endforelse
            </ul>
        </section>
    </section>
@endsection
