<?php

namespace App\Http\Controllers\Curator;

use App\DataTransferObjects\TaskDTO;
use App\Models\Task;
use App\Models\TaskUser;
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
        if (! $course = auth()->user()->courses()->first()) {
            return redirect()->back();
        }

        $tasks = $this->taskService->where([
            'course_id' => $course->id
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

    /**
     * @param int $taskId
     * @return View|RedirectResponse
     */
    public function show(int $taskId)
    {
        if (! $task = $this->taskService->findById($taskId)) {
            return redirect()->back()
                ->withErrors(['no_task' => 'Задачи с данным ID не существует!']);
        }

        return view('curator.tasks.show', ['task' => $task, 'title' => 'Задание ' . $task->title]);
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

        return redirect()->route('curator.course.task.index')->with('success', 'Задание успешно создано!');
    }

    /**
     * @param int $taskId
     * @return Factory|View|Application|\Illuminate\View\View|object
     */
    public function edit(int $taskId)
    {
        if (! $task = $this->taskService->findById($taskId)) {
            abort(403);
        }

        return view('curator.tasks.edit', [
            'title' => 'Задания',
            'task' => $task,
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
        if (! $task = $this->taskService->findById($taskId)) {
            abort(403);
        }

        $taskDTO = new TaskDTO(
            $request->input('name'),
            $request->input('description'),
            $request->input('deadline'),
            $request->input('course_id')
        );

        $this->taskService->update($task, $taskDTO);

        return redirect()->route('curator.course.task.index')->with('success', 'Задача успешно обновлена!');
    }

    public function delete(int $id): RedirectResponse
    {
        $this->taskService->findById($id)->delete();

        return redirect()->route('curator.course.task.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $task = $this->taskService->findById($id);

        $task->users()->detach();

        TaskUser::query()->where('task_id', $task->id)->delete();

        $task->delete();

        return redirect()->route('curator.course.task.index')->with(['success' => 'Задача успешно удалена вместе с решениями!']);
    }
}
