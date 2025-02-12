<?php

namespace App\Broadcasting;

class ChatChannel
{
	/**
	 * Authenticate the user's access to the channel.
	 *
	 * @return bool
	 */
	public function join(): bool
	{
		return auth()->check();
	}
}
