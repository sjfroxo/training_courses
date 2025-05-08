<?php

namespace App\Repositories;

use App\DataTransferObjects\ChatMessageDTO;
use App\Models\ChatMessage;
use Illuminate\Database\Eloquent\Model;

class ChatMessageRepository extends CoreRepository
{
    /**
     * ChatMessageRepository constructor.
     *
     * @param ChatMessage $model
     */
    public function __construct(ChatMessage $model)
    {
        parent::__construct($model);
    }

    /**
     * Находит сообщение по его ID.
     *
     * @param  int  $id
     * @return ChatMessage|null
     */
    public function find(int $id): ?ChatMessage
    {
        return $this->model->find($id);
    }

    /**
     * Обновляет переданную модель ChatMessage на основании DTO.
     *
     * @param ChatMessage|Model $entity
     * @param ChatMessageDTO|array $data
     * @return ChatMessage
     */
    public function update(ChatMessage|Model $entity, ChatMessageDTO|array $data): ChatMessage
    {
        $entity->message = $data instanceof ChatMessageDTO ? $data->message : $data['message'];
        $entity->save();

        return $entity;
    }
}
