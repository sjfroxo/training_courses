<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Models\Chat;
use App\Models\User;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Log;


class ChatController extends Controller
{
    public function __construct(
        protected ChatService $service,
        protected UserService $userService
    ) {}

    public function index(): View
    {

        $user = auth()->user();

        $chats = $this->userService->getChats(auth()->user()->id);

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
            'slug' => $slug
        ]);
    }

    public function createChat(Request $request): JsonResponse
    {
        Log::info($request->all());
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'title' => 'required|string|max:255',
        ]);

        $user = auth()->user();

        $slug = Str::slug($validated['title']) . '-' . Str::random(8);

        $chat = Chat::query()->create([
            'title' => $validated['title'],
            'slug' => $slug,
        ]);

        $user_ids = array_merge($validated['user_ids'], [$user->id]);

        foreach ($user_ids as $user_id) {
            $chat->users()->attach($user_id);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Чат успешно создан!',
            'chat' => $chat,
        ], 201);
    }




    public function loadMessages(ChatRequest $request): JsonResponse
    {
        $messages = $this->service->getMessages($request->slug, $request->last_message_id);

        return response()->json($messages);
    }
}
