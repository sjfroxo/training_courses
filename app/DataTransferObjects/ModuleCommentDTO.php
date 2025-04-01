<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\ModuleCommentRequest;

class ModuleCommentDTO implements ModelDTO
{
    /**
     * @param string $user_id
     * @param string $module_id
     * @param string $text
     */
    public function __construct(
        public readonly string $user_id,
        public readonly string $module_id,
        public readonly string $text,
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'module_id' => $this->module_id,
            'text' => $this->text,
        ];
    }
}
