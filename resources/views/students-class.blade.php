@extends('layouts.app')

@section('main')
    <div class="container d-flex" style="height: 100%; width: 90%; background-color: transparent;">
        <div class="content flex-grow-1">
            <div class="card-header rounded-top-4" style="background-color: transparent; border: none;">
            </div>
            <div class="card-body" style="margin: 0 auto; background-color: transparent;">
                <h2 class="mb-3">Учебные классы</h2>
                @can('create', \App\Models\StudentsClass::class)
                    <div class="mb-3">
                        <x-add-button-invert route="{{ route('studentsClass.create') }}"/>
                    </div>
                @endcan
                <div class="row">
                    @foreach($studentsClasses as $studentsClass)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <a style="text-decoration: none; color: #000;"
                                           href="{{ route('studentsClass.show', $studentsClass->id) }}">
                                            <h5 class="card-title">Класс номер {{ $loop->iteration }}. {{ $studentsClass->name }}</h5>
                                        </a>
                                        <p class="card-text">{{ $studentsClass->course?->title ?? 'Не указан' }}</p>
                                    </div>
                                    <div class="d-flex gap-2">
                                        @can('update', $studentsClass)
                                            <x-edit-button route="{{ route('studentsClass.edit', $studentsClass) }}"/>
                                        @endcan

                                        @can('delete', $studentsClass)
                                            <form action="{{ route('studentsClass.destroy', $studentsClass->id) }}"
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <x-delete-button/>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $studentsClasses->links() }}
            </div>
        </div>

        <div class="d-flex justify-content-center"
             style="position: fixed; bottom: 20px; width: 80%; background-color: transparent;">
        </div>
    </div>
@endsection
