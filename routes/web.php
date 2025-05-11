<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginWithGoogleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Curator\GradeController;
use App\Http\Controllers\Curator\InternController;
use App\Http\Controllers\Curator\TaskController;
use App\Http\Controllers\ExamUserResponseResultController;
use App\Http\Controllers\ModuleCommentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuleExamAnswerController;
use App\Http\Controllers\ModuleExamController;
use App\Http\Controllers\ModuleExamQuestionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentsClassController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\UserStudyMainController;
use App\Http\Controllers\UserStudyProgressController;
use App\Http\Controllers\UserStudyTasksController;
use App\Http\Controllers\Curator\CourseController as CourseCuratorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('courses', [CourseController::class, 'index'])->name('courses');
    Route::prefix('courses')->group(function () {

        Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/', [CourseController::class, 'store'])->name('courses.store');

        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
        Route::get('/{slug}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::patch('/{slug}', [CourseController::class, 'update'])->name('courses.update');

        Route::get('/{slug}', [CourseController::class, 'show'])->name('courses.show');
        Route::get('/{slug}/users', [CourseController::class, 'showUsers'])->name('courses.showUsers');
    });

    Route::prefix('modules')->group(function () {
        Route::get('/create', [ModuleController::class, 'create'])->name('modules.create');
        Route::post('/', [ModuleController::class, 'store'])->name('modules.store');
        Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
        Route::get('/{slug}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
        Route::patch('/{slug}', [ModuleController::class, 'update'])->name('modules.update');
        Route::get('/{slug}', [ModuleController::class, 'show'])->name('modules.show');
    });

    Route::prefix('moduleComments')->group(function () {
        Route::post('/', [ModuleCommentController::class, 'store'])->name('moduleComments.store');
        Route::delete('/{moduleComment}', [ModuleCommentController::class, 'destroy'])->name('moduleComments.destroy');
        Route::patch('/{moduleComment}', [ModuleCommentController::class, 'update'])->name('moduleComments.update');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('users');
        Route::get('/create', [AdminUserController::class, 'create'])->name('users.create');
        Route::post('/', [AdminUserController::class, 'store'])->name('users.store');

        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::patch('/{user}', [AdminUserController::class, 'update'])->name('users.update');

        Route::get('/{user}', [AdminUserController::class, 'show'])->name('users.show');
    });

    Route::prefix('userCourses')->group(function () {
        Route::post('/', [UserCourseController::class, 'store'])->name('userCourses.store');
        Route::delete('/users/{user}/courses/{userCourse}', [UserCourseController::class, 'destroy'])->name('userCourses.destroy');
    });

    Route::prefix('moduleExams')->group(function () {
        Route::get('/', [ModuleExamController::class, 'index'])->name('moduleExams');
        Route::get('/create', [ModuleExamController::class, 'create'])->name('moduleExams.create');
        Route::post('/', [ModuleExamController::class, 'store'])->name('moduleExams.store');
        Route::delete('/{moduleExam}', [ModuleExamController::class, 'destroy'])->name('moduleExams.destroy');
        Route::get('/{moduleExam}/edit', [ModuleExamController::class, 'edit'])->name('moduleExams.edit');
        Route::patch('/{moduleExam}', [ModuleExamController::class, 'update'])->name('moduleExams.update');

        Route::get('/{moduleExam}', [ModuleExamController::class, 'show'])->name('moduleExams.show');
    });

    Route::prefix('moduleExamQuestions')->group(function () {
        Route::post('/', [ModuleExamQuestionController::class, 'store'])->name('moduleExamQuestion.store');
        Route::delete('/{moduleExamQuestion}', [ModuleExamQuestionController::class, 'destroy'])->name('moduleExamQuestion.destroy');
        Route::patch('/{moduleExamQuestion}', [ModuleExamQuestionController::class, 'update'])->name('moduleExamQuestion.update');
    });

    Route::prefix('moduleExamAnswers')->group(function () {
        Route::post('/', [ModuleExamAnswerController::class, 'store'])->name('moduleExamAnswers.store');
        Route::delete('/{moduleExamAnswer}', [ModuleExamAnswerController::class, 'destroy'])->name('moduleExamAnswers.destroy');
        Route::patch('/{moduleExamAnswer}', [ModuleExamAnswerController::class, 'update'])->name('moduleExamAnswers.update');
    });

    Route::prefix('ExamUserResponseResult')->group(function () {
        Route::post('/', [ExamUserResponseResultController::class, 'store'])->name('examUserResponseResult.store');
    });

    Route::prefix('studentsClass')->group(function () {
        Route::get('/', [StudentsClassController::class, 'index'])->name('studentsClass.index');

        Route::get('/create', [StudentsClassController::class, 'create'])->name('studentsClass.create');
        Route::post('/', [StudentsClassController::class, 'store'])->name('studentsClass.store');

        Route::delete('/{studentsClass}', [StudentsClassController::class, 'destroy'])->name('studentsClass.destroy');
        Route::get('/{studentsClass}/edit', [StudentsClassController::class, 'edit'])->name('studentsClass.edit');
        Route::put('/{studentsClass}', [StudentsClassController::class, 'update'])->name('studentsClass.update');

        Route::get('/{studentsClass}', [StudentsClassController::class, 'show'])->name('studentsClass.show');

        Route::post('/{studentsClass}/add-students', [StudentsClassController::class, 'addStudents'])->name('studentsClass.addStudents');
        Route::post('/{studentsClass}/add-curator', [StudentsClassController::class, 'addCurator'])->name('studentsClass.addCurator');
        Route::delete('/{studentsClass}/delete-user/{userId}', [StudentsClassController::class, 'deleteUser'])->name('studentsClass.deleteUser');
    });

    Route::get('/userStudyMain/{id}', [UserStudyMainController::class, 'show'])->name('userStudyMain.show');
    Route::get('/userStudyProgress/{id}', [UserStudyProgressController::class, 'show'])->name('userStudyProgress.show');
    Route::get('/userStudyTasks/{id}', [UserStudyTasksController::class, 'show'])->name('userStudyTasks.show');

    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');

    Route::prefix('chat')->group(function () {
        Route::get('/messages-load', [ChatController::class, 'loadMessages'])->name('chat.loadMessages');
        Route::post('/create', [ChatController::class, 'store'])->name('chat.store');
        Route::get('/{slug}', [ChatController::class, 'show'])->name('chat.show');

        Route::post('/message-send', [ChatMessageController::class, 'store'])->name('message.store');
        Route::put('/message/{message}', [ChatMessageController::class, 'update'])->name('message.update');
        Route::delete('/message/{message}', [ChatMessageController::class, 'delete'])->name('message.delete');
    });

    Route::prefix('account-details')->group(function () {
        Route::get('/{id}', [UserController::class, 'show'])->name("account.show");
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name("account.edit");
        Route::patch('/{id}', [UserController::class, 'update'])->name("account.update");
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications');
    });

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::prefix('curator')->group(function () {
        Route::prefix('course')->name('curator.course.')->group(function () {
            Route::get('/', [CourseCuratorController::class, 'index'])->name('index');
            Route::post('/', [CourseCuratorController::class, 'store']);

            Route::resource('intern', InternController::class)->names('intern');
            Route::resource('task', TaskController::class)->names('task');
//            Route::get('tasks', [TaskController::class, 'index'])->name('curator.courses.tasks.index');
//            Route::get('tasks/edit', [TaskController::class, 'edit'])->name('curator.courses.tasks.edit');
//            Route::patch('tasks', [TaskController::class, 'update'])->name('curator.courses.tasks.update');
            Route::get('grade', [GradeController::class, 'index'])->name('grade.index');
        });
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/auth/{provider}', [LoginWithGoogleController::class, 'redirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [LoginWithGoogleController::class, 'callback'])->name('social.callback');

    Route::get('/forgot-password', [ResetPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});

Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.store');

Route::get('/verify-email', [RegisterController::class, 'verifyNotice'])->name('verification.notice');
Route::get('/verify-email/{id}/{hash}', [RegisterController::class, 'verifyEmail'])->middleware('signed')->name('verification.verify');
Route::post('/email/verification-notification', [RegisterController::class, 'verifyHandler'])->middleware('throttle:6,1')->name('verification.send');
