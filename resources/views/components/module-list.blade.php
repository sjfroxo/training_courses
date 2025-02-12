<div class="row">
    @foreach($modules as $module)
            <div class="col-md-3">
               <x-module-card :module="$module"/>
            </div>
    @endforeach
</div>
