<?php

namespace App\Console\Commands;

use App\Models\Course;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class UpdateSlug extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:update-slug';

    /**
     * @var string
     */
    protected $description = 'Updating the slug of all existing entities that contain it';

    /**
     * @var array<Model>
     */
    protected array $arrayOfSluggableModels;

    public function __construct()
    {
        parent::__construct();
        $this->arrayOfSluggableModels = [
            new Course(),
        ];
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        foreach ($this->arrayOfSluggableModels as $model) {
            $entities = $model->all();
            foreach ($entities as $entity) {
                $entity['slug'] = SlugService::createSlug($model::class, 'slug', $entity['title']);
                $this->info($entity['slug']);
                $entity->save();
            }
        }
    }
}
