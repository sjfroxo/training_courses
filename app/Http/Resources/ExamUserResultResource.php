<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamUserResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'module_exam_question_id' => $this->module_exam_question_id,
            'mark' => $this->mark,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
