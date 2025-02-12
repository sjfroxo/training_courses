<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleComment extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'module_comments';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'user_id',
		'module_id',
		'text'
	];

	/**
	 * @return BelongsTo
	 */
	public function module(): BelongsTo
	{
		return $this->belongsTo(Module::class);
	}

	/**
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
