<?php

namespace App\Http\Controllers\Curator;

use App\DataTransferObjects\TaskDTO;
use App\Models\Task;
use App\Services\TaskService;
use App\Services\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    /**
     * @param TaskService $taskService
     * @param UserService $userService
     */
    public function __construct(
        protected TaskService $taskService,
        protected UserService $userService
    ) {}

    /**
     * @return Factory|View|Application|\Illuminate\View\View|object
     */
    public function index()
    {
        $tasks = $this->taskService->where([
            'course_id' => auth()->user()->courses()->first()->id
        ]);

        return view('curator.tasks.index', [
            'tasks' => $tasks,
            'title' => 'Задания'
        ]);
    }

    /**
     * @return View
     */
    public function create()
    {
        return view('curator.tasks.create', [
            'title' => 'Создание задания',
            'users' => $this->userService->getCourseInterns(auth()->user()->courses()->first()->id)
        ]);
    }

    public function store(Request $request)
    {
        $taskDTO = new TaskDTO(
            $request->input('name'),
            $request->input('description'),
            $request->input('deadline'),
            auth()->user()->courses()->first()->id
        );

        $task = $this->taskService->create($taskDTO);

        if ($request->has('users')) {
            $task->users()->attach($request->input('users'));
        }

        return redirect()->route('curator.courses.tasks.index')->with('success', 'Задание успешно создано!');
    }

    /**
     * @param int $taskId
     * @return Factory|View|Application|\Illuminate\View\View|object
     */
    public function edit(int $taskId)
    {
        if (auth()->user()->courses()->first()->tasks()->where('id', $taskId)->first()->doesntExist()) {
            abort(403);
        }

        return view('curator.tasks.edit', [
            'title' => 'Задания',
            'task' => $this->taskService->findById($taskId),
            'users' => $this->userService->getCourseInterns(auth()->user()->courses()->first()->id)
        ]);
    }

    /**
     * @param Request $request
     * @param int $taskId
     * @return RedirectResponse
     */
    public function update(Request $request, int $taskId)
    {
        if (auth()->user()->courses()->first()->tasks()->where('id', $taskId)->dontExist()) {
            abort(403);
        }

        $taskDTO = new TaskDTO(
            $request->input('name'),
            $request->input('description'),
            $request->input('deadline'),
            $request->input('course_id')
        );

        $task = $this->taskService->findById($taskId);
        $this->taskService->update($task, $taskDTO);

        return redirect()->back()->with('success', 'Задача успешно обновлена!');
    }
}
