<div class="row d-flex justify-content-center align-items-center">
    @foreach($courses as $course)
        @can('view',$course)
            @include('components.course-card', [
                'title' => $course->title,
                'description' => $course->description,
                'course' => $course,
                'deleteForm' => route('courses.destroy', $course->id),
            ])
        @endcan
    @endforeach
</div>
