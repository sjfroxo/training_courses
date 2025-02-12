<div class="row">
    <h5>Тесты:</h5>
    @foreach($exams as $index => $exam)
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <x-exam-card :iteration="$index + 1" :exam="$exam"/>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
