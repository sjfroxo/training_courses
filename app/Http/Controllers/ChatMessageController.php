<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ChatMessageDTO;
use App\Events\MessageSent;
use App\Http\Requests\ChatMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Services\ChatMessageService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

class ChatMessageController extends Controller
{
    /**
     * @param ChatMessageService $service
     */
	public function __construct(
        protected ChatMessageService $service,
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
