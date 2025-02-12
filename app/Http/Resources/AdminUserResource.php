<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminUserResource extends JsonResource
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
			'name' => $this->name,
			'surname' => $this->surname,
			'email' => $this->email,
			'password' => $this->password,
			'user_role_id' => $this->user_role_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}
