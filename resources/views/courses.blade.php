@extends('layouts.app')

@section('main')
    <div class="container mt-4 d-flex">
        @include('layouts.navigation')

        <div class="content flex-grow-1">
            <div class="card border-0 rounded-4">
                <div class="card-header rounded-top-4">
                    <h2 class="mb-0">Курсы</h2>
                </div>
                <div class="card-body">
                    @can('create', \App\Models\Course::class)
                        <div class="mb-3 text-end">
                            <x-add-button route="{{ route('courses.create') }}"/>
                        </div>
                    @endcan

                    @include('components.course-list', ['courses' => $courses])
                </div>
                <div class="card-footer bg-light rounded-bottom-4">
                    <div class="d-flex justify-content-center">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
