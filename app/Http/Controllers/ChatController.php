<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Models\Chat;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function __construct(
        protected ChatService $service,
        protected UserService $userService
    ) {}

    public function index(): View
    {
        $user = auth()->user();
        $chats = $this->service->getChats($user->id);
        $users = $this->userService->getUsers();

        return view('chats', [
            'chats' => $chats,
            'users' => $users,
            'user' => $user,
        ]);
    }

    public function show(string $slug): View
    {
        $data = $this->service->chatDetails($slug);

        return view('chat_details', [
            'videoMessages' => $data['videoMessages'],
            'voiceMessages' => $data['voiceMessages'],
            'chat' => $data['chat'],
            'messages' => $data['messages'],
            'slug' => $slug,
        ]);
    }

    public function createChat(Request $request): JsonResponse
    {
        \Log::info('Creating chat with data:', $request->all());
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'nullable|string|max:255',
        ]);

        $currentUser = auth()->user();
        $otherUserId = $validated['user_id'];

        $existingChat = $this->service->getExistingChat($currentUser->id, $otherUserId);

        if ($existingChat) {
            return response()->json([
                'status' => 'exists',
                'message' => 'Чат уже существует.',
                'chat' => $existingChat,
            ], 200);
        }

        $title = $validated['title'] ?? "Chat with user {$otherUserId}";
        $slug = Str::slug($title) . '-' . Str::random(8);

        $chat = Chat::query()->create([
            'title' => $title,
            'slug' => $slug,
        ]);

        $chat->users()->attach([$currentUser->id, $otherUserId]);

        return response()->json([
            'status' => 'success',
            'message' => 'Чат успешно создан!',
            'chat' => $chat,
        ], 201);
    }

    public function loadMessages(Request $request): JsonResponse
    {
        $slug = $request->input('slug');
        $lastMessageId = $request->input('last_message_id');
        $messages = $this->service->getMessages($slug, $lastMessageId);
        return response()->json($messages);
    }
}
