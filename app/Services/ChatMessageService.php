<?php

namespace App\Services;

use App\Contracts\ModelDTO;
use App\DataTransferObjects\ChatMessageDTO;
use App\Models\ChatMessage;
use App\Repositories\ChatMessageRepository;
use App\Repositories\ChatRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatMessageService extends CoreService
{
    /**
     * @param ChatMessageRepository $repository
     * @param ChatRepository $chatRepository
     */
	public function __construct(
        ChatMessageRepository $repository,
        protected ChatRepository $chatRepository,
    )
	{
		parent::__construct($repository);
	}

    /**
     * @param ChatMessageDTO $dto
     *
     * @return ChatMessage
     * @throws Exception
     */
    public function createMessage(ModelDTO $dto): Model
    {
        $message = parent::create($dto);

        if ($dto->media_file != null) {
            if ($dto->media_file->getSize() === 0) {
                Log::error('Media file is empty for message ID: ' . $message->id);
                throw new Exception('Media file is empty');
            }

            $path = 'public/messages/' . $message->id;

            Storage::makeDirectory($path);

            $fileName = $dto->media_file->getClientOriginalName();
            $dto->media_file->storeAs($path, $fileName);

            if (!Storage::exists($path . '/' . $fileName)) {
                Log::error('Failed to save media file for message ID: ' . $message->id);
                throw new Exception('Failed to save media file');
            }

            $message->media_url = Storage::url($path . '/' . $fileName);
            $message->save();

            Log::info('Media file saved for message ID: ' . $message->id, ['path' => $message->media_url]);
        }

        return $message;
    }

    public function updateMessage(int $id, ChatMessageDTO $dto): ChatMessage
    {
        $message = $this->repository->find($id);

        $message->message = $dto->message;

        if ($dto->media_file !== null) {
            if ($dto->media_file->getSize() === 0) {
                Log::error('Media file is empty for message ID: ' . $message->id);
                throw new Exception('Media file is empty');
            }

            $path = 'public/messages/' . $message->id;
            Storage::makeDirectory($path);

            $fileName = $dto->media_file->getClientOriginalName();
            $dto->media_file->storeAs($path, $fileName);

            if (! Storage::exists($path . '/' . $fileName)) {
                Log::error('Failed to save media file for message ID: ' . $message->id);
                throw new Exception('Failed to save media file');
            }

            if ($message->media_url) {
                $oldPath = str_replace('/storage/', 'public/', $message->media_url);
                Storage::delete($oldPath);
            }

            $message->media_url = Storage::url($path . '/' . $fileName);
            Log::info('Media file updated for message ID: ' . $message->id, ['path' => $message->media_url]);
        }

        $message->save();

        return $message;
    }
}
