<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LoginWithGoogleController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatMessageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamUserResultController;
use App\Http\Controllers\ModuleCommentController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ModuleExamAnswerController;
use App\Http\Controllers\ModuleExamController;
use App\Http\Controllers\ModuleExamQuestionController;
use App\Http\Controllers\ModuleExamUserResponseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCourseController;
use App\Http\Middleware\GuestMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
	return view('welcome');
});

Route::get('/courses', [CourseController::class, 'index'])
	->name('courses')->middleware('auth');

Route::middleware('auth')->group(function() {
	Route::prefix('courses')->group(function() {
		Route::get('/', [CourseController::class, 'index'])->name('courses');

		Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
		Route::post('/', [CourseController::class, 'store'])->name('courses.store');

		Route::delete('/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
		Route::get('/{slug}/edit', [CourseController::class, 'edit'])->name('courses.edit');
		Route::patch('/{slug}', [CourseController::class, 'update'])->name('courses.update');

		Route::get('/{slug}', [CourseController::class, 'show'])->name('courses.show');

		Route::get('/{slug}/users', [CourseController::class, 'showUsers'])->name('courses.showUsers');
	});

	Route::prefix('modules')->group(function() {
		Route::get('/create', [ModuleController::class, 'create'])->name('modules.create');
		Route::post('/', [ModuleController::class, 'store'])->name('modules.store');
		Route::delete('/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
		Route::get('/{slug}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
		Route::patch('/{slug}', [ModuleController::class, 'update'])->name('modules.update');
		Route::get('/{slug}', [ModuleController::class, 'show'])->name('modules.show');
	});

	Route::prefix('moduleComments')->group(function() {
		Route::post('/', [ModuleCommentController::class, 'store'])->name('moduleComments.store');
		Route::delete('/{moduleComment}', [ModuleCommentController::class, 'destroy'])->name('moduleComments.destroy');
		Route::patch('/{moduleComment}', [ModuleCommentController::class, 'update'])->name('moduleComments.update');
	});

	Route::prefix('users')->group(function() {
		Route::get('/', [AdminUserController::class, 'index'])->name('users');
		Route::get('/create', [AdminUserController::class, 'create'])->name('users.create');
		Route::post('/', [AdminUserController::class, 'store'])->name('users.store');

		Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
		Route::get('/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
		Route::patch('/{user}', [AdminUserController::class, 'update'])->name('users.update');

		Route::get('/{user}', [AdminUserController::class, 'show'])->name('users.show');
	});

	Route::prefix('userCourse')->group(function() {
		Route::post('/', [UserCourseController::class, 'store'])->name('userCourses.store');
		Route::delete('/{userCourse}', [UserCourseController::class, 'destroy'])->name('userCourses.destroy');
	});

	Route::prefix('moduleExams')->group(function() {
		Route::get('/', [ModuleExamController::class, 'index'])->name('moduleExams');
		Route::get('/create', [ModuleExamController::class, 'create'])->name('moduleExams.create');
		Route::post('/', [ModuleExamController::class, 'store'])->name('moduleExams.store');
		Route::delete('/{moduleExam}', [ModuleExamController::class, 'destroy'])->name('moduleExams.destroy');
		Route::get('/{moduleExam}/edit', [ModuleExamController::class, 'edit'])->name('moduleExams.edit');
		Route::patch('/{moduleExam}', [ModuleExamController::class, 'update'])->name('moduleExams.update');

		Route::get('/{moduleExam}', [ModuleExamController::class, 'show'])->name('moduleExams.show');
	});

	Route::prefix('moduleExamUserResponses')->group(function() {
		Route::post('/', [ModuleExamUserResponseController::class, 'store'])->name('moduleExamUserResponses.store');
	});

	Route::prefix('moduleExamQuestions')->group(function() {
		Route::post('/', [ModuleExamQuestionController::class, 'store'])->name('moduleExamQuestion.store');
		Route::delete('/{moduleExamQuestion}', [ModuleExamQuestionController::class, 'destroy'])->name('moduleExamQuestion.destroy');
		Route::patch('/{moduleExamQuestion}', [ModuleExamQuestionController::class, 'update'])->name('moduleExamQuestion.update');
	});

	Route::prefix('moduleExamAnswers')->group(function() {
		Route::post('/', [ModuleExamAnswerController::class, 'store'])->name('moduleExamAnswers.store');
		Route::delete('/{moduleExamAnswer}', [ModuleExamAnswerController::class, 'destroy'])->name('moduleExamAnswers.destroy');
		Route::patch('/{moduleExamAnswer}', [ModuleExamAnswerController::class, 'update'])->name('moduleExamAnswers.update');
	});

	Route::prefix('ExamUserResults')->group(function() {
		Route::get('/', [ExamUserResultController::class, 'index'])->name('examsUsersResults.index');
		Route::post('/', [ExamUserResultController::class, 'store'])->name('examsUsersResults.store');
	});

	Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware([GuestMiddleware::class])->group(function() {
	Route::view('/register', 'auth.register')->name('register');
	Route::post('/register', [RegisterController::class, 'create'])->name('register.create');
	Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

	Route::view('/login', 'auth.login')->name('login');
	Route::post('/login', [LoginController::class, 'authenticate'])->name('login.store');
	Route::get('/login/google', LoginWithGoogleController::class)->name('google.redirect');
	Route::get('/login/google/call-back', [LoginWithGoogleController::class, 'store'])->name('google.callback');
});

Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');

Route::prefix('chat')->group(function() {
	Route::post('/message-send', [ChatMessageController::class, 'store'])->name('message.store');
	Route::get('/messages-load', [ChatController::class, 'loadMessages'])->name('chat.loadMore');
	Route::get('/{slug}', [ChatController::class, 'show'])->name('chat.show');
});

Route::prefix('account-details')->group(function() {
	Route::get('/{id}', [UserController::class, 'show'])->name("account.show");
	Route::get('/{id}/edit', [UserController::class, 'edit'])->name("account.edit");
	Route::patch('/{id}', [UserController::class, 'update'])->name("account.update");
});

Route::prefix('notifications')->group(function() {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications');
});

Route::get('/test', [ChatController::class, 'test']);
