@extends('layouts.app')

@section('main')
    <div class="container d-flex flex-column" style="height: 100%; width: 90%; background-color: transparent;">
        @include('layouts.navigation')

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
                    <div class="d-flex justify-content-around align-items-center">
                        @foreach($studentsClasses as $studentsClass)
                            <div class="card col-md-4 m-3">
                                <div class="card-body">
                                    <div>
                                        <h5 class="card-title">Класс номер 1</h5>
                                        <p class="card-text">Курс по языку программированию C#</p>
                                    </div>
                                    <div>
                                        <span>2</span> <i class="bi bi-person-circle"></i>
                                        <div>
                                            <button class="btn btn-primary btn">Редактировать</button>
                                            <button class="btn btn-danger btn">Удалить</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center"
             style="position: fixed; bottom: 20px; width: 80%; background-color: transparent;">
            {{--            {{ $courses->links() }}--}}
        </div>
    </div>
@endsection

