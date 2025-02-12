<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\UploadedFile;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface ChatMessageRepositoryInterface extends AbstractRepositoryInterface
{
	/**
	 * @param string $id
	 * @param UploadedFile $file
	 *
	 * @return string
	 */
	public function loadMedia(string $id, UploadedFile $file): string;
}
