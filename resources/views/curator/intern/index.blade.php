@extends('layouts.app')

@section('main')
    @include('components.curator.course-header', ['active' => 'interns'])

    <section>
        <form action="{{ route('curator.courses.interns.index') }}">
            <input class="form-control w-25 mt-5" name="intern" type="text" placeholder="Поиск практикантов">
        </form>

        <ul class="list-group mt-3 w-25">
            @forelse($interns as $intern)
                <li class="list-group-item d-flex gap-2 justify-content-center">
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
                </li>
            @empty
                <h1 class="alert-heading">У курса ещё нет практикантов!</h1>
            @endforelse
        </ul>
    </section>
@endsection
