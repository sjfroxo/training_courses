<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NotificationController
{
    use AuthorizesRequests;

    /**
     * @return Factory|View|Application|\Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        return view('notifications');
    }
}
