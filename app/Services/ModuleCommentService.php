<?php

namespace App\Services;

use App\Repositories\ModuleCommentRepository;

class ModuleCommentService extends CoreService
{
	/**
	 * @param ModuleCommentRepository $repository
	 */
	public function __construct(ModuleCommentRepository $repository)
	{
		parent::__construct($repository);
	}
}
