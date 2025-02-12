@extends('layouts.app')

@section('main')
    <div class="container">
        <h1>Добавить новый тест</h1>
        <form action="{{ route('moduleExams.store') }}" method="POST" id="createForm">
            @csrf
            <div class="mb-3">
                <label for="module_id" class="form-label">К какому модулю относится тест:</label><br/>
                <select class="form-select @error('module_id') is-invalid @enderror" id="module_id" name="module_id" required>
                    <option value="">Выберите модуль</option>
                    @foreach($modules as $module)
                        <option name="module_id" value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                    @endforeach
                </select>
                @error('module_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            <div class="mb-3 form-check">
                <input type="hidden" name="is_autochecked" value="0">
                <input type="checkbox" class="form-check-input" id="is_autochecked" name="is_autochecked" value="1" {{ old('auto_check') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_autochecked">Проверять автоматически</label>
            </div>
            <button type="submit" id="createButton" class="btn btn-primary">Добавить</button>
        </form>

        <p class="text-secondary">Для добавления вопросов к тесту перейдите в редактирование теста (Перейдите в модуль,в который вы добавили тест)</p>
    </div>
@endsection
