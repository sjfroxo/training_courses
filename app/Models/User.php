<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserRoleEnum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'user_role_id',
        'google_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Значения по умолчанию для атрибутов модели.
     *
     * @var array
     */
    protected $attributes = [
        'user_role_id' => UserRoleEnum::USER->value,
    ];

    /**
     * Проверить, является ли пользователь администратором.
     *
     * @return bool
     */
    public function isAdministrator(): bool
    {
        return $this->user_role_id === UserRoleEnum::ADMIN->value;
    }

    /**
     * Проверить, является ли пользователь куратором.
     *
     * @return bool
     */
    public function isCurator(): bool
    {
        return $this->user_role_id === UserRoleEnum::CURATOR->value;
    }

    /**
     * Проверить, является ли пользователь обычным пользователем.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->user_role_id === UserRoleEnum::USER->value;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'user_role_id');
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_users', 'user_id', 'chat_id')
            ->withPivot('user_role')
            ->withTimestamps();
    }

    public function chatMessages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'user_id');
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'user_courses', 'user_id', 'course_id')
            ->withPivot('progress')
            ->withPivot('id')
            ->withTimestamps();
    }

    public function moduleExams(): BelongsToMany
    {
        return $this->belongsToMany(ModuleExam::class, 'exam_user_results', 'user_id', 'module_exam_id')
            ->withPivot('mark')
            ->withTimestamps();
    }

    public function moduleExamAnswers(): BelongsToMany
    {
        return $this->belongsToMany(ModuleExamAnswer::class, 'module_exam_user_responses', 'user_id', 'module_exam_answer_id')
            ->withPivot('module_exam_question_id')
            ->withTimestamps();
    }

    public function moduleComments(): HasMany
    {
        return $this->hasMany(ModuleComment::class, 'user_id');
    }

    public function courseVisits(): HasMany
    {
        return $this->hasMany(CourseVisit::class);
    }

    public function studentsClass()
    {

    }
}
