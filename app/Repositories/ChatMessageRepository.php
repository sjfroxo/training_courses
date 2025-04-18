<?php

namespace App\Repositories;

use App\Models\ChatMessage;
use App\Repositories\Interfaces\ChatMessageRepositoryInterface;

class ChatMessageRepository extends CoreRepository implements ChatMessageRepositoryInterface
{
    /**
     * @param ChatMessage $model
     */
    public function __construct(ChatMessage $model)
    {
        parent::__construct($model);
    }
}
