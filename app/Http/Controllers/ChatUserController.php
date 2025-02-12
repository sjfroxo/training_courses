<?php

namespace App\Http\Controllers;

use App\Services\ChatUserService;
use Illuminate\Routing\Controller;

class ChatUserController extends Controller
{
	/**
	 * @param ChatUserService $service
	 */
	public function __construct(ChatUserService $service) {}
}
