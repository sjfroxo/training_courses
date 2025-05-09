<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ChatMessageDTO;
use App\Events\MessageDeleted;
use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Http\Requests\ChatMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Models\ChatMessage;
use App\Services\ChatMessageService;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ChatMessageController extends Controller
{
    public function __construct(protected ChatMessageService $service) {}

    use AuthorizesRequests;

    /**
     * @throws Exception
     */
    public function store(ChatMessageRequest $request)
    {
        Log::info('Request Data:', $request->all());

        $validated = $request->validated();

        Log::info('Validated Data:', $validated);

        try {
            $dto = new ChatMessageDTO(
                data_get($validated, 'chat_id'),
                data_get($validated, 'user_id'),
                data_get($validated, 'type'),
                data_get($validated, 'message'),
                data_get($validated, 'reply_message_id'),
                $request->file('media_file'),
            );

            $message = $this->service->createMessage($dto);

            Log::info('Broadcasting MessageSent for chat ' . $message->chat_id);

            broadcast(new MessageSent($message))->toOthers();

            return ChatMessageResource::make($message);
        } catch (Exception $e) {
            Log::error('Error creating message: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при создании сообщения'], 500);
        }
    }

    public function delete(ChatMessage $message)
    {
        $messageId = $message->id;
        $chatId    = $message->chat_id;

        $message->delete();

        broadcast(new MessageDeleted($messageId, $chatId))->toOthers();

        return response()->json(['success' => true]);
    }

    /**
     * @throws Exception
     */
    public function update(ChatMessageRequest $request, ChatMessage $message)
    {
        $validated = $request->validated();

        $dto = new ChatMessageDTO(
            $message->chat_id,
            $message->user_id,
            $message->type,
            $validated['message'],
            $message->reply_message_id,
            $request->file('media_file')
        );

        $updated = $this->service->updateMessage($message->id, $dto);

        broadcast(new MessageUpdated($updated))->toOthers();

        return response()->json(['status' => 'updated', 'data' => $updated]);
    }
}
