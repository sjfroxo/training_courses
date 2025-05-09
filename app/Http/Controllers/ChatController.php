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
        $users = $this->userService->getUsers()->where('id', '!=', $user->id); // Исключаем текущего пользователя

        return view('chats.chats', [
            'chats' => $chats,
            'users' => $users,
            'user' => $user,
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
        ]);

        $currentUser = Auth::user();
        $otherUserId = $validated['user_id'];

        // Проверяем, существует ли уже чат между этими пользователями
        $existingChat = $this->service->getExistingChat($currentUser->id, $otherUserId);

        if ($existingChat) {
            return redirect()
                ->route('chats.index')
                ->with('warning', 'Чат уже существует.');
        }

        // Определяем, является ли это чатом с самим собой
        $isSelfChat = $currentUser->id === $otherUserId;
        $title = $isSelfChat ? 'Избранное' : $this->userService->getUserName($otherUserId);
        $slug = Str::slug($title) . '-' . Str::random(8);

        try {
            $chat = Chat::query()->create([
                'title' => $title,
                'slug' => $slug,
            ]);

            // Привязываем пользователей к чату
            $chat->users()->attach([$currentUser->id, $otherUserId]);

            return redirect()
                ->route('chats.index')
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
