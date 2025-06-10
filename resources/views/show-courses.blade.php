@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
{{--                <h4>{{ $course->title }}</h4>--}}

{{--                @can('create', App\Models\Module::class)--}}
{{--                    <x-add-button route="{{ route('modules.create', ['course' => $course->id]) }}"/>--}}
{{--                @endcan--}}

{{--                <div class="d-flex flex-wrap gap-2 my-3">--}}
{{--                    @foreach($course->modules as $m)--}}
{{--                        <a href="#" style="height: 40px; width: 40px; cursor: pointer;"--}}
{{--                           class="btn btn-elprimary module-btn"--}}
{{--                           data-module-slug="{{ $m->slug }}"></a>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
                <div id="moduleContent">
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
                    container.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Загрузка...</span></div>';
                    fetch(`/modules/${slug}`, {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`Ошибка ${response.status}`);
                            }
                            return response.text();
                        })
                        .then(html => {
                            container.innerHTML = html;
                        })
                        .catch(error => {
                            container.innerHTML = `<div class="alert alert-danger">Ошибка загрузки модуля: ${error.message}</div>`;
                        });
                }

                buttons.forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log('Клик по кнопке:', btn.dataset.moduleSlug);
                        buttons.forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        loadModule(btn.dataset.moduleSlug);
                    });
                });
            });
        </script>
    @endpush
@endsection
