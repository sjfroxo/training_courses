@php use App\Models\ModuleExam; @endphp
@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                {{--                @can('create',ModuleExam::class)--}}
                {{--                    <x-add-button route="{{ route('moduleExams.create') }}"/>--}}
                {{--                @endcan--}}
            </div>
            <div class="card-body">
                @foreach($moduleExams as $moduleExam)

                @endforeach
            </div>
        </div>
    </div>
@endsection
