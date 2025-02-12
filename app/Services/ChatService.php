<?php
//
//namespace App\Services;
//
//use App\Repositories\ChatRepository;
//use Illuminate\Pagination\LengthAwarePaginator;
//
//class ChatService extends CoreService
//{
//	/**
//	 * @param ChatRepository $repository
//	 */
//	public function __construct(
//		ChatRepository $repository)
//	{
//		parent::__construct($repository);
//	}
//
//	/**
//	 * @param string $slug
//	 *
//	 * @return array
//	 */
//	public function chatDetails(string $slug): array
//	{
//		$data['chat'] = $this->repository->findBySlug($slug);
//
//		$data['messages'] = $this->repository->getMessages($data['chat']);
//
//		$data['replyMessages'] = $this->repository->getReplies($data['chat']);
//
//		$data['voiceMessages'] = $this->repository->getMedia($data['chat'])['voice'];
//
//		$data['videoMessages'] = $this->repository->getMedia($data['chat'])['video'];
//
//		return $data;
//	}
//
//	/**
//	 * @param string $slug
//	 * @param string $lastMessId
//	 *
//	 * @return LengthAwarePaginator
//	 */
//	public function getPaginatedMessages(string $slug, string $lastMessId): LengthAwarePaginator
//	{
//		$chat = $this->repository->findBySlug($slug);
//
//		return $this->repository->getMessages($chat, $lastMessId);
//	}
//}


namespace App\Services;

use App\Repositories\ChatRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ChatService extends CoreService
{
    /**
     * @param ChatRepository $repository
     */
    public function __construct(ChatRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Получаем детализированную информацию о чате, включая сообщения и медиа.
     *
     * @param string $slug
     *
     * @return array
     */
    public function chatDetails(string $slug): array
    {
        $chat = $this->repository->findBySlug($slug);

        return $this->repository->getChatDetails($chat);
    }

    /**
     * Получаем сообщения с пагинацией.
     *
     * @param string $slug
     * @param string $lastMessId
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedMessages(string $slug, string $lastMessId): LengthAwarePaginator
    {
        $chat = $this->repository->findBySlug($slug);

        return $this->repository->getMessages($chat, $lastMessId);
    }
}
