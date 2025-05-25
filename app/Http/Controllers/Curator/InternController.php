<?php

namespace App\Http\Controllers\Curator;

use App\Services\CourseService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class InternController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(Request $request)
    {
        if (! $course = auth()->user()->courses()->first()) {
            return redirect()->back()->with(['error' => 'У вас, как куратора, ещё нет курсов!']);
        }

        $interns = $this->userService->getCourseInterns(
            $course->id,
            filters: ['name', 'like', '%' . $request->input('intern') . '%']
        );

        return view('curator.intern.index', [
            'title' => 'Практиканты',
            'interns' => $interns
        ]);
    }

    public function show(int $id)
    {
        if (! $intern = $this->userService->findById($id)) {
            return redirect()->route('curator.intern.index');
        }

        $tasks = $intern->tasks()->get();

        return view('curator.intern.show', ['intern' => $intern, 'tasks' => $tasks]);
    }
}
