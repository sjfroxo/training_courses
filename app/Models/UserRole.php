<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
	use HasFactory;

	/**
	 * @var string
	 */
	protected $table = 'user_roles';
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'title'
	];

	/**
	 * @return HasMany
	 */
	public function users(): HasMany
	{
		return $this->hasMany(User::class);
	}
}
