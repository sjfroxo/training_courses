<div class="card">
    <div class="card-body d-flex">
        <img src="{{ $course->image_url ? asset('storage/' . $course->image_url) : asset('images/default_course.jpg') }}"
             alt="{{ $course->title }}"
             style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px; border-radius: 10px;">
        <h5 class="card-title">{{ $title }}</h5>
        {{--        <p class="card-text text-truncate" style="max-height: 60px; overflow: hidden;">{{ $description }}</p>--}}

        {{--        @if(auth()->user()->isAdministrator())--}}
        {{--            <x-show-button route="{{ route('courses.show', ['slug' => $course->slug]) }}"/>--}}
        {{--            <a type="button"--}}
        {{--               class="btn btn-primary"--}}
        {{--               href="{{ route('courses.showUsers', ['slug' => $course->slug]) }}">--}}
        {{--                Участники--}}
        {{--            </a>--}}
        {{--        @elseif(auth()->user()->isUser())--}}
        {{--            <x-show-button route="{{ route('userStudyMain.show', ['id' => $course->id]) }}"/>--}}
        {{--        @endif--}}
        <div>
            @can('update', $course)
                <a style="text-decoration: none; color: #4e4e4e; margin-right: 10px;"
                   href="{{ route('courses.edit', ['slug' => $course->slug]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                         class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd"
                              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                    </svg>
                </a>
            @endcan

            @can('delete', $course)
                <form action="{{ $deleteForm }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <x-delete-button/>
                </form>
            @endcan
        </div>
    </div>
</div>
