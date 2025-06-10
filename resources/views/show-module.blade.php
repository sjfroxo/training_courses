<div class="">
    <div class="d-flex align-items-center">
        <h5 class="mb-0">{{ $module->title }}</h5>
        @can('create', $module)
            <a href="{{ route('moduleExams.create', $module) }}" class="btn btn-sm btn-primary">
                Добавить тест
            </a>
        @endcan
    </div>

    @foreach($module->moduleExams as $exam)
        <div class="mt-3">
            <ul class="nav" id="examTab-{{ $exam->id }}" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn btn-elprimary border" id="theory-tab-{{ $exam->id }}"
                            data-bs-toggle="tab"
                            data-bs-target="#theory-{{ $exam->id }}" type="button" role="tab"
                            aria-controls="theory-{{ $exam->id }}" aria-selected="true"
                            style="height: 40px; width: 40px; cursor: pointer; margin-right: 15px;">
                    </button>
                </li>
                @if($exam->examTheory && $exam->examTheory->video_url)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link btn btn-elprimary border" id="video-tab-{{ $exam->id }}"
                                data-bs-toggle="tab"
                                data-bs-target="#video-{{ $exam->id }}" type="button" role="tab"
                                aria-controls="video-{{ $exam->id }}" aria-selected="false"
                                style="height: 40px; width: 40px; cursor: pointer; margin-right: 15px;">
                        </button>
                    </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn btn-elprimary border" id="test-tab-{{ $exam->id }}" data-bs-toggle="tab"
                            data-bs-target="#test-{{ $exam->id }}" type="button" role="tab"
                            aria-controls="test-{{ $exam->id }}" aria-selected="false"
                            style="height: 40px; width: 40px; cursor: pointer; margin-right: 15px;">
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link btn btn-elprimary border" id="results-tab-{{ $exam->id }}" data-bs-toggle="tab"
                            data-bs-target="#results-{{ $exam->id }}" type="button" role="tab"
                            aria-controls="results-{{ $exam->id }}" aria-selected="false"
                            style="height: 40px; width: 40px; cursor: pointer; margin-right: 15px;">
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="examTabContent-{{ $exam->id }}">
                <div class="tab-pane fade show active" id="theory-{{ $exam->id }}" role="tabpanel"
                     aria-labelledby="theory-tab-{{ $exam->id }}">
                    @if($exam->examTheory)
                        <div class="mt-3">
                            {!! $exam->examTheory->content !!}
                        </div>
                    @else
                        <p class="mt-3">Теория отсутствует.</p>
                    @endif
                </div>

                @if($exam->examTheory && $exam->examTheory->video_url)
                    <div class="tab-pane fade" id="video-{{ $exam->id }}" role="tabpanel"
                         aria-labelledby="video-tab-{{ $exam->id }}">
                        <div class="mt-3">
                            <video controls style="max-width: 100%;">
                                <source src="{{ $exam->examTheory->video_url }}" type="video/mp4">
                                Ваш браузер не поддерживает воспроизведение видео.
                            </video>
                        </div>
                    </div>
                @endif

                <div class="tab-pane fade" id="test-{{ $exam->id }}" role="tabpanel"
                     aria-labelledby="test-tab-{{ $exam->id }}">
                    <div class="mt-3">
                        @if($exam->moduleExamQuestions->isNotEmpty())
                            <p>Вопросов: {{ $exam->moduleExamQuestions->count() }}</p>
                            <a href="{{ route('moduleExams.show', ['moduleExam' => $exam->id]) }}"
                               class="btn btn-primary">
                                Пройти тест
                            </a>
                        @else
                            <p>Тест отсутствует.</p>
                        @endif
                    </div>
                </div>

                <div class="tab-pane fade" id="results-{{ $exam->id }}" role="tabpanel"
                     aria-labelledby="results-tab-{{ $exam->id }}">
                    <div class="mt-3">
                        @if($exam->users->isNotEmpty())
                            <p>Ваша оценка: {{ $exam->users->first()->pivot->mark }}</p>
                        @else
                            <p>Вы еще не проходили этот тест.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{--<h6 class="mt-4">Комментарии</h6>--}}
{{--@forelse($module->comments ?? [] as $c)--}}
{{--    <div class="card mb-2">--}}
{{--        <div class="card-body">--}}
{{--            <strong>{{ $c->user->name }}</strong>--}}
{{--            <p>{{ $c->text }}</p>--}}
{{--            <small class="text-muted">{{ $c->created_at->format('d.m.Y H:i') }}</small>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@empty--}}
{{--    <p>Комментариев пока нет.</p>--}}
{{--@endforelse--}}

{{--<form action="{{ route('moduleComments.store') }}" method="POST" id="commentForm">--}}
{{--    @csrf--}}
{{--    <input type="hidden" name="module_id" value="{{ $module->id }}">--}}
{{--    <div class="mb-3">--}}
{{--        <label for="comment-text" class="form-label">Добавить комментарий</label>--}}
{{--        <textarea id="comment-text" name="text" class="form-control" rows="3" required></textarea>--}}
{{--    </div>--}}
{{--    <button type="submit" class="btn btn-primary">Отправить</button>--}}
{{--</form>--}}
