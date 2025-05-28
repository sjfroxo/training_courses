<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">{{ $module->title }}</h5>
        @can('create', $module)
            <a href="{{ route('moduleExams.create', $module) }}" class="btn btn-sm btn-primary">
                Добавить тест
            </a>
        @endcan
    </div>
    <div class="card-body">
        {!! $module->content !!}
        @if($module->moduleExams->count())
            <x-exam-list :exams="$module->moduleExams"/>
        @endif
    </div>
</div>

<h6 class="mt-4">Комментарии</h6>
@forelse($module->comments as $c)
    <div class="card mb-2">
        <div class="card-body">
            <strong>{{ $c->user->name }}</strong>
            <p>{{ $c->text }}</p>
            <small class="text-muted">{{ $c->created_at->format('d.m.Y H:i') }}</small>
        </div>
    </div>
@empty
    <p>Комментариев пока нет.</p>
@endforelse

<form action="{{ route('moduleComments.store') }}" method="POST">
    @csrf
    <input type="hidden" name="module_id" value="{{ $module->id }}">
    <div class="mb-3">
        <label for="comment-text" class="form-label">Добавить комментарий</label>
        <textarea id="comment-text" name="text" class="form-control" rows="3" required></textarea>
    </div>
    <button class="btn btn-primary">Отправить</button>
</form>
