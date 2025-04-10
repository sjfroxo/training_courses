<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
    public function __construct(
        protected ChatService $service,
        protected UserService $userService
    ) {}

    public function index(): View
    {
        $chats = $this->userService->showChats(auth()->user()->id);
        return view('chats', ['chats' => $chats]);
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

    public function loadMessages(ChatRequest $request): JsonResponse
    {
        $messages = $this->service->getMessages($request->slug, $request->last_message_id);
        return response()->json($messages);
    }
}
