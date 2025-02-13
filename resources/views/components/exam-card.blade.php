    <div class="card-body">
        <div>
            <h5>Тест {{ $iteration }}: {{ $exam->name }}</h5>
        </div>
        <div class="d-flex align-items-center">
            @can('view',$exam)
                <x-show-button route="{{ route('moduleExams.show', ['moduleExam' => $exam->id]) }}"
                               class="btn btn-primary"/>
            @else
                <button class="btn btn-danger " disabled type="submit" id="deleteButton">Не доступен</button>
            @endcan

            @can('update',$exam)
                <a type="button" class="btn btn-primary" href="{{  route('moduleExams.edit', ['moduleExam' => $exam->id]) }}">Редактировать</a>
            @endcan

            @can('delete',$exam)
                <form action="{{ route('moduleExams.destroy',$exam->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <x-delete-button/>
                </form>
            @endcan
        </div>
    </div>


