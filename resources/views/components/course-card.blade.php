<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <p class="card-text text-truncate" style="max-height: 60px; overflow: hidden;">{{ $description }}</p>

        @if(auth()->user()->isAdministrator())
            <x-show-button route="{{ route('courses.show', ['slug' => $course->slug]) }}"/>
        @elseif(auth()->user()->isUser())
            <x-show-button route="{{ route('userStudy', ['slug' => $course->slug]) }}"/>
        @endif

        @can('update', $course)
            <x-edit-button route="{{ route('courses.edit', ['slug' => $course->slug]) }}"/>
        @endcan

        <a type="button" class="btn btn-primary" href="{{ route('courses.showUsers', ['slug' => $course->slug]) }}">Участники</a>

        @can('delete', $course)
            <form action="{{ $deleteForm }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <x-delete-button/>
            </form>
        @endcan
    </div>
</div>
