@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-header">
                <h2>Курсы</h2>
            </div>
            <div>
                @can('create',\App\Models\Course::class)
                    <x-add-button route="{{ route('courses.create') }}"/>
                @endcan
            </div>
            <div class="card-body" style="display: flex;">
                @include('components.course-list', ['courses' => $courses])
            </div>
            {{ $courses->links() }}
        </div>
    </div>
@endsection
