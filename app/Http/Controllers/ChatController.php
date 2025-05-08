<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Services\ChatService;
use App\Services\UserService;
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
        $users = $this->userService->getUsers();

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
            'title' => 'required|string|max:255',
        ]);

        $currentUser = Auth::user();
        $otherUserId = $validated['user_id'];

        $existingChat = $this->service->getExistingChat($currentUser->id, $otherUserId);

        if ($existingChat) {
            return redirect()
                ->route('chats.index')
                ->with('warning', 'Чат уже существует.');
        }

        $slug = Str::slug($validated['title']) . '-' . Str::random(8);

        try {
            $chat = Chat::query()->create([
                'title' => $validated['title'],
                'slug' => $slug,
            ]);

            $chat->users()->attach([$currentUser->id, $otherUserId]);

            return redirect()
                ->route('chats.index')
                ->with('success', 'Чат успешно создан!');
        } catch (\Exception $e) {
            return redirect()
                ->route('chats.index')
                ->with('error', 'Ошибка при создании чата: ' . $e->getMessage());
        }
    }
    public function loadMessages(Request $request): JsonResponse
    {
        // получаем slug и номер страницы из query-параметров
        $slug = $request->query('slug');
        $page = (int) $request->query('page', 1);

        // находим чат по slug
        $chat = $this->service->findBySlug($slug);

        // пагинируем сообщения: 30 штук на страницу, от новых к старым
        $paginator = $chat->chatMessages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(30, ['*'], 'page', $page);

        // возвращаем весь объект пагинатора
        return response()->json($paginator);
    }
}

