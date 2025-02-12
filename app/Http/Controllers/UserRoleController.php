<?php

namespace App\Http\Controllers;

use App\Services\UserRoleService;
use Illuminate\Routing\Controller;

class UserRoleController extends Controller
{
    /**
     * @param UserRoleService $service
     */
    public function __construct(protected UserRoleService $service) {}
}
