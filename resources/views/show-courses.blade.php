@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h2>Программа курса</h2>
            </div>
            <div class="card-body">
                <h4>{{$course->title}}</h4>
                {{$course->description}}
                <x-progress-bar :progress="$progress"/>
                <h5>Модули:</h5>
                @can('create',\App\Models\Module::class)
                    <x-add-button route="{{ route('modules.create') }}"/>
                @endcan
                <x-module-list :modules="$course->modules"/>
            </div>
        </div>
    </div>
@endsection
