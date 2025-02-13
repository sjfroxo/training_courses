<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use App\Services\ChatService;
use App\Services\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
	/**
	 * @param ChatService $service
	 * @param UserService $userService
	 */
	public function __construct(
		protected ChatService $service,
		protected UserService $userService
	) {}

	/**
	 * @return View
	 */
	public function index(): View
	{
		$chats = $this->userService->showChats(auth()->user()->id);

		return view('chats', ['chats' => $chats]);
	}

	/**
	 * @param string $slug
	 *
	 * @return View
	 */
	public function show(string $slug): View
	{
		$data = $this->service->chatDetails($slug);

		return view('chat_details', [
			'videoMessages' => $data['videoMessages'],
			'voiceMessages' => $data['voiceMessages'],
			'replyMessages' => $data['replyMessages'],
			'chat' => $data['chat'],
			'messages' => $data['messages'],
			'slug' => $slug
		]);
	}

    /**
     * @param ChatRequest $request
     *
     * @return JsonResponse
     */
	public function loadMessages(ChatRequest $request): JsonResponse
	{
		$messages = $this->service->getPaginatedMessages($request->slug, $request->last_message_id);

		return response()->json($messages);
	}
}
