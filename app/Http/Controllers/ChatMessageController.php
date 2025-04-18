<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ChatMessageDTO;
use App\Events\MessageSent;
use App\Http\Requests\ChatMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Services\ChatMessageService;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ChatMessageController extends Controller
{
    public function __construct(protected ChatMessageService $service) {}

    /**
     * @throws Exception
     */
    public function store(ChatMessageRequest $request): JsonResource
    {
        $validated = $request->validated();
        $dto = new ChatMessageDTO(
            data_get($validated, 'chat_id'),
            data_get($validated, 'user_id'),
            data_get($validated, 'type'),
            data_get($validated, 'reply_message_id'),
            data_get($validated, 'message'),
            $request->file('media_file'),
        );

        $message = $this->service->createMessage($dto);
        Log::info('Создано сообщение, инициируется трансляция', ['message_id' => $message->id]);
        broadcast(new MessageSent($message))->toOthers();
        Log::info('Событие MessageSent отправлено', ['message_id' => $message->id]);

        return ChatMessageResource::make($message);
    }
}
