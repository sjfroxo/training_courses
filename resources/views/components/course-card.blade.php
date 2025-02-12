<div class="card" style="width: 70%;">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <p class="card-text">{{ $description }}</p>

        <x-show-button route="{{ route('courses.show', ['slug' => $course->slug]) }}"/>
        @can('update',$course)
            <x-edit-button route="{{ route('courses.edit', ['slug' => $course->slug]) }}"/>
        @endcan

        @can('delete',$course)
            <form action="{{ $deleteForm }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <x-delete-button/>
            </form>
        @endcan

        <a type="button" class="btn btn-second" href="{{route('courses.showUsers', ['slug' => $course->slug])}}">Участники</a>
    </div>
</div>
