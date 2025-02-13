<div class="row">
    @foreach($courses as $course)
        @can('view',$course)
            <div class="col-md-6" style="margin-bottom: 15px;">
                @include('components.course-card', [
                    'title' => $course->title,
                    'description' => $course->description,
                    'course' => $course,
                    'deleteForm' => route('courses.destroy', $course->id),
                ])
            </div>
        @endcan
    @endforeach
</div>
