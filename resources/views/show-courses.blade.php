@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h4>{{ $course->title }}</h4>

                @can('create', App\Models\Module::class)
                    <x-add-button route="{{ route('modules.create', ['course' => $course->id]) }}" />
                @endcan

                <div class="d-flex flex-wrap gap-2 my-3">
                    @foreach($course->modules as $m)
                        <button
                            class="btn btn-outline-primary module-btn"
                            data-module-slug="{{ $m->slug }}">
                            {{ $m->title }}
                        </button>
                    @endforeach
                </div>

                <div id="moduleContent" class="mt-4">
                    @if($course->modules->isNotEmpty())
                        @include('show-module', ['module' => $course->modules->first()])
                    @else
                        <p>Нет доступных модулей.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const buttons = document.querySelectorAll('.module-btn');
                const container = document.getElementById('moduleContent');

                function loadModule(slug) {
                    fetch(`/modules/${slug}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(r => r.ok ? r.text() : Promise.reject(r.status))
                        .then(html => container.innerHTML = html)
                        .catch(e => container.innerHTML = `<div class="alert alert-danger">Ошибка ${e}</div>`);
                }

                buttons.forEach(btn => {
                    btn.addEventListener('click', () => {
                        buttons.forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        loadModule(btn.dataset.moduleSlug);
                    });
                });

                // активируем первый
                if (buttons.length) {
                    buttons[0].classList.add('active');
                    loadModule(buttons[0].dataset.moduleSlug);
                }
            });
        </script>
    @endpush
@endsection
