<h1>{{ $title }}</h1>

@php
    $active = explode('.', Route::currentRouteName())[2] ?? '';
@endphp

<div class="flex space-x-4 border-b mb-6">
    <a href="{{ route('curator.courses.interns.index') }}"
       class="px-3 py-2 {{ $active === 'interns' ? 'text-bg-primary' : '' }}"
    >
        Практиканты
    </a>
    <a href="{{ route('curator.courses.tasks.index') }}"
       class="px-3 py-2 {{ $active === 'tasks' ? 'text-bg-primary' : '' }}"
    >
        Задания
    </a>
    <a href="{{ route('curator.courses.grades.index') }}"
       class="px-3 py-2 {{ $active === 'grades' ? 'text-bg-primary' : '' }}"
    >
        Оценки
    </a>
</div>
