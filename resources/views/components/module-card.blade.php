<div class="card">
        <div class="card-body">
            <h5>{{$module->title}}</h5>
            <x-show-button route="{{ route('modules.show', ['slug' => $module->slug]) }}"/>

            @can('update',$module)
                <x-edit-button route="{{ route('modules.edit', ['slug' => $module->slug]) }}"/>
            @endcan
            @can('delete',$module)
                <form action="{{ route('modules.destroy',$module->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <x-delete-button/>
                </form>
            @endcan
        </div>
</div>


