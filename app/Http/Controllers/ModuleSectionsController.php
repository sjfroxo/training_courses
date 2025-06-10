<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\ModuleSection;
use App\Services\ModuleService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ModuleSectionsController extends Controller
{
    use AuthorizesRequests;

    protected ModuleService $moduleService;

    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    public function create()
    {
        $module = Module::all()->pluck('id')->first();

//        $this->authorize('create', ModuleSection::class);

        return view('module_sections.module-section-create', ['module' => $module]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', ModuleSection::class);

        $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'steps' => 'required|array',
        ]);

        $moduleSection = new ModuleSection();
        $moduleSection->module_id = $request->input('module_id');
        $moduleSection->title = $request->input('title');
        $moduleSection->content = $request->input('steps');
        $moduleSection->save();

        return redirect()->route('module-sections.index')->with('success', 'Раздел модуля успешно создан');
    }
}
