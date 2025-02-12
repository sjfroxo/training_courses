<?php
//
//namespace App\Repositories;
//
//use App\Models\Chat;
//use App\Repositories\Interfaces\ChatRepositoryInterface;
//use Illuminate\Pagination\LengthAwarePaginator;
//use Illuminate\Support\Facades\Storage;
//
//class ChatRepository extends CoreRepository implements ChatRepositoryInterface
//{
//	/**
//	 * @param Chat $model
//	 */
//	public function __construct(Chat $model)
//	{
//		parent::__construct($model);
//	}
//
//	/**
//	 * @param Chat $chat
//	 * @param string|null $lastMessId
//	 *
//	 * @return LengthAwarePaginator
//	 */
//	public function getMessages(Chat $chat, ?string $lastMessId = null): LengthAwarePaginator
//	{
//		return $chat->query()->when(
//			$lastMessId != null,
//			fn() => $chat->chatMessages()->where('id', '<', $lastMessId)->orderBy('created_at', 'desc')->paginate(10),
//			fn() => $chat->chatMessages()->orderBy('created_at', 'desc')->paginate(10),
//		);
//	}
//
//	/**
//	 * @param Chat $chat
//	 *
//	 * @return array
//	 */
//	public function getReplies(Chat $chat): array
//	{
//		$replyMessages = [];
//
//		foreach($chat->chatMessages()->get() as $message) {
//			if($message->reply_message_id) {
//				$replyMessages[$message->reply_message_id] = $message->replyMessage();
//			}
//		}
//
//		return $replyMessages;
//	}
//
//	/**
//	 * @param Chat $chat
//	 *
//	 * @return array|array[]
//	 */
//	public function getMedia(Chat $chat): array
//	{
//		$mediaMessages = [
//			'voice' => [],
//			'video' => []
//		];
//
//		foreach($chat->chatMessages()->get() as $message) {
//			if(Storage::exists("public/messages/" . $message->id)) {
//				if($message->type == "voice") {
//					$mediaMessages['voice'][$message->id] = $this->getFilesByExtension($message->id, 'webm');
//				} elseif($message->type == "video") {
//					$mediaMessages['video'][$message->id] = $this->getFilesByExtension($message->id, 'mkv');
//				}
//			}
//		}
//
//		return $mediaMessages;
//	}
//
//	/**
//	 * @param $id
//	 * @param $extension
//	 *
//	 * @return string
//	 */
//	public function getFilesByExtension($id, $extension): string
//	{
//		$allFiles = Storage::files("public/messages/" . $id . "/");
//
//		$filteredFiles = array_filter($allFiles, function($file) use ($extension) {
//			return pathinfo($file, PATHINFO_EXTENSION) === $extension;
//		});
//
//		return Storage::url($filteredFiles[array_key_first($filteredFiles)]);
//	}
//}

namespace App\Repositories;

use App\Models\Chat;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ChatRepository extends CoreRepository implements ChatRepositoryInterface
{
    /**
     * @param Chat $model
     */
    public function __construct(Chat $model)
    {
        parent::__construct($model);
    }

    /**
     * Получаем подробности чата, включая сообщения и медиа.
     *
     * @param Chat $chat
     *
     * @return array
     */
    public function getChatDetails(Chat $chat): array
    {
        $messages = $this->getMessages($chat);

        $replyMessages = $this->getReplies($chat);

        $media = $this->getMedia($chat);

        return [
            'chat' => $chat,
            'messages' => $messages,
            'replyMessages' => $replyMessages,
            'voiceMessages' => $media['voice'],
            'videoMessages' => $media['video'],
        ];
    }

    /**
     * Получаем сообщения чата с пагинацией.
     *
     * @param Chat $chat
     * @param string|null $lastMessId
     *
     * @return LengthAwarePaginator
     */
    public function getMessages(Chat $chat, ?string $lastMessId = null): LengthAwarePaginator
    {
        return $chat->chatMessages()
            ->when($lastMessId, fn($query) => $query->where('id', '<', $lastMessId))
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Получаем ответы на сообщения.
     *
     * @param Chat $chat
     * @return array
     */
    public function getReplies(Chat $chat): array
    {
        return $chat->chatMessages()
            ->whereNotNull('reply_message_id')
            ->get()
            ->groupBy('reply_message_id')
            ->toArray();
    }

    /**
     * Получаем медиафайлы (голосовые и видео) чата.
     *
     * @param Chat $chat
     *
     * @return array
     */
    public function getMedia(Chat $chat): array
    {
        return [
            'voice' => $this->getMediaFiles($chat, 'voice'),
            'video' => $this->getMediaFiles($chat, 'video'),
        ];
    }

    /**
     * Получаем медиафайлы для заданного типа.
     *
     * @param Chat $chat
     * @param string $type
     *
     * @return array
     */
    private function getMediaFiles(Chat $chat, string $type): array
    {
        return $chat->chatMessages()
            ->where('type', $type)
            ->get()
            ->filter(function ($message) {
                return Storage::exists("public/messages/" . $message->id);
            })
            ->map(function ($message) {
                return $this->getFilesByExtension($message->id, $message->type === 'voice' ? 'webm' : 'mkv');
            })
            ->toArray();
    }

    /**
     * Получаем ссылку на файл по его расширению.
     *
     * @param $id
     * @param $extension
     *
     * @return string
     */
    public function getFilesByExtension($id, $extension): string
    {
        $allFiles = Storage::files("public/messages/" . $id . "/");

        $filteredFiles = array_filter($allFiles, fn($file) => pathinfo($file, PATHINFO_EXTENSION) === $extension);

        return Storage::url($filteredFiles[array_key_first($filteredFiles)] ?? '');
    }
}
