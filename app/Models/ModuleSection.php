<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModuleSection extends Model
{
    /**
     * @var string
     */
    protected $table = 'module_sections';

    /**
     * @var string[]
     */
    protected $fillable = [
        'model_id',
        'title',
        'count_finished_steps',
    ];

    /**
     * @return BelongsTo
     */
    public function modules(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'module_section_user', 'module_section_id', 'user_id');
    }
}
