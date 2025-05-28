<!-- resources/views/components/module-card.blade.php -->
<div class="card" style="border: 0;">
    <div class="card-body">
        <button class="btn btn-primary square-button"
                data-module-slug="{{ $module->slug }}">
        </button>

        @can('update', $module)
            <x-edit-button route="{{ route('modules.edit', ['slug' => $module->slug]) }}" />
        @endcan
        @can('delete', $module)
            <form action="{{ route('modules.destroy', $module->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <x-delete-button />
            </form>
        @endcan
    </div>
</div>

<style>
    .square-button {
        display: inline-block;
        width: 30px;
        height: 30px;
        background-color: transparent !important;
        padding: 0 !important;
        text-decoration: none;
        line-height: normal;
    }

    .square-button.active {
        background-color: #007bff !important;
        border-color: #007bff;
    }

    .square-button:active {
        border-color: #000;
    }
</style>
