<?php

namespace App\Repositories;

use App\Models\ChatMessage;
use App\Repositories\Interfaces\ChatMessageRepositoryInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Log;

class ChatMessageRepository extends CoreRepository implements ChatMessageRepositoryInterface
{
	/**
	 * @param ChatMessage $model
	 */
	public function __construct(ChatMessage $model)
	{
		parent::__construct($model);
	}

    /**
     * @param string $id
     * @param UploadedFile $file
     *
     * @return string
     * @throws Exception
     */
    public function loadMedia(string $id, UploadedFile $file): string
    {
        $path = 'public/messages/' . $id;
        Storage::makeDirectory($path); // Создаем директорию
        $fileName = $file->getClientOriginalName();
        $file->storeAs($path, $fileName);

        if (!Storage::exists($path . '/' . $fileName)) {
            Log::error('Failed to save media file in loadMedia for message ID: ' . $id);
            throw new Exception('Failed to save media file in loadMedia');
        }

        return Storage::url($path . '/' . $fileName);
    }
}
