<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Services\ChatService;
use App\Services\UserService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function __construct(
        protected ChatService $service,
        protected UserService $userService
    ) {}

    use AuthorizesRequests;

    public function index(): View
    {
        $user = Auth::user();
        $chats = $this->service->getChats($user->id);
        $users = $this->userService->getUsers()->where('id', '!=', $user->id);

        $selectedChat = null;
        $messages = collect();
        if ($slug = request()->query('chat')) {
            $selectedChat = $this->service->findBySlug($slug);
            if ($selectedChat && $selectedChat->users()->where('users.id', $user->id)->exists()) {
                $messages = $selectedChat->chatMessages()
                    ->with('user')
                    ->orderBy('created_at', 'asc')
                    ->take(25)
                    ->get();
            } else {
                $selectedChat = null; // Сбрасываем, если чат не принадлежит пользователю
            }
        }

        return view('chats.chats', [
            'chats' => $chats,
            'users' => $users,
            'user' => $user,
            'chat' => $selectedChat,
            'messages' => $messages,
        ]);
    }

    public function show(string $slug): View
    {
        $data = $this->service->chatDetails($slug);

        return view('chats.chat_details', [
            'videoMessages' => $data['videoMessages'],
            'voiceMessages' => $data['voiceMessages'],
            'chat' => $data['chat'],
            'messages' => $data['messages'],
            'slug' => $slug,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'course_id' => 'nullable|exists:courses,id', // Добавляем course_id для чатов, связанных с курсом
        ]);

        $currentUser = Auth::user();
        $otherUserId = $validated['user_id'];
        $courseId = $validated['course_id'] ?? null;

        // Проверяем, существует ли уже чат между этими пользователями
        $existingChat = $this->service->getExistingChat($currentUser->id, $otherUserId, $courseId);

        if ($existingChat) {
            return redirect()
                ->route('chats.index', ['chat' => $existingChat->slug])
                ->with('warning', 'Чат уже существует.');
        }

        // Определяем заголовок чата
        $isSelfChat = $currentUser->id === $otherUserId;
        $title = $isSelfChat ? 'Избранное' : $this->userService->getUserName($otherUserId);
        if ($courseId) {
            $course = \App\Models\Course::find($courseId);
            $title = 'Чат для курса ' . ($course->title ?? 'Курс ' . $courseId) . ' с ' . $this->userService->getUserName($otherUserId);
        }
        $slug = Str::slug($title) . '-' . Str::random(8);

        try {
            $chat = Chat::query()->create([
                'title' => $title,
                'slug' => $slug,
                'course_id' => $courseId, // Сохраняем course_id, если есть
            ]);

            // Привязываем пользователей к чату
            $chat->users()->attach([$currentUser->id, $otherUserId]);

            return redirect()
                ->route('chats.index', ['chat' => $chat->slug])
                ->with('success', 'Чат успешно создан!');
        } catch (Exception $e) {
            return redirect()
                ->route('chats.index')
                ->with('error', 'Ошибка при создании чата: ' . $e->getMessage());
        }
    }

    public function loadMessages(Request $request): JsonResponse
    {
        $slug = $request->query('slug');
        $page = (int) $request->query('page', 1);

        $chat = $this->service->findBySlug($slug);

        $paginator = $chat->chatMessages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(30, ['*'], 'page', $page);

        return response()->json($paginator);
    }
}
