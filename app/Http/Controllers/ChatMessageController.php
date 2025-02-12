<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ChatMessageDTO;
use App\Events\MessageSent;
use App\Http\Requests\ChatMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Services\ChatMessageService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class ChatMessageController extends Controller
{
    /**
     * @param ChatMessageService $service
     * @param Request $request
     */
	public function __construct(
        protected ChatMessageService $service,
        protected Request $request,
    )
    {}

    /**
     * @param ChatMessageRequest $request
     *
     * @return JsonResource
     */
	public function store(ChatMessageRequest $request): JsonResource
	{
		$request = app(ChatMessageRequest::class, $request->all());

		$dto = ChatMessageDTO::appRequest($request);

		$message = $this->service->create($dto);

		broadcast(new MessageSent($message))->toOthers();

		return ChatMessageResource::make($message);
	}
}
