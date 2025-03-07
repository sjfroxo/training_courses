<div>
    <h5>Прогресс:</h5>
    @if(is_numeric($progress) && $progress >= 0 && $progress <= 100)
        <div
            class="progress"
            role="progressbar"
            aria-label="Example with label"
            aria-valuenow="{{ $progress }}"
            aria-valuemin="0"
            aria-valuemax="100"
        >
            <div class="progress-bar" style="width: {{ $progress }}%">{{ $progress }}%</div>
        </div>
    @else
        <p>Прогресс не доступен</p>
    @endif
</div>
