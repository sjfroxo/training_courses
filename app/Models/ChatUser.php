<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'chat_users';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'user_id',
		'chat_id',
		'user_role'
	];
}
