<?php

use App\Http\Controllers\Admin\AdminFileController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CampController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\ParticipantsController;
use App\Http\Controllers\Admin\ProgrammeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\UserHomeController;
use App\Http\Controllers\User\UserArticlesController;
use App\Http\Controllers\User\UserCampController;
use App\Http\Controllers\User\UserContactController;
use App\Http\Controllers\User\UserFeedbacksController;
use App\Http\Controllers\User\UserGalleryController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\User\UserRegistrationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/privatumo-politika', function (){
    return view('main.privacy-policy');
})->name('privacy');

Route::get('/', [UserHomeController::class,'index'])->name('home');

Route::get('/kontaktai', [UserContactController::class,'index'])->name('contactForm');
Route::post('/send',[UserContactController::class,'send'])->name('send.email');

Route::get('/renginiai', [UserCampController::class, 'index'])->name('camps.index');
Route::get('/renginiai/{slug}', [UserCampController::class,'show'])->name('camps.show');

Route::get('/straipsniai', [UserArticlesController::class, 'index'])->name('articles.index');
Route::get('/straipsniai/{slug}', [UserArticlesController::class, 'show'])->name('articles.show');

Route::get('/galerija', [UserGalleryController::class,'index'])->name('gallery.index');
Route::get('/galerija/{slug}', [UserGalleryController::class, 'show'])->name('gallery.show');

Route::get('/feedbacks', [UserFeedbacksController::class,'index'])->name('feedback.index');
Route::post('/feedbacks', [UserFeedbacksController::class,'store'])->name('feedback.store');

Route::get('/camp-registration/{camp}', [UserRegistrationController::class, 'index'])->name('camp.show');
Route::post('/camp-registration/{camp}', [UserRegistrationController::class, 'register'])->name('camp.register');

Route::get('/success/{camp}', [UserRegistrationController::class, 'success'])->name('camp.register.success');

Route::middleware('auth')->group(function (){

    Route::prefix('profilis')->name('profile.')->group(function () {
        Route::get('/', [UserProfileController::class,'show'])->name('show');
        Route::post('/update', [UserProfileController::class, 'update'])->name('updateImage');
        Route::post('/update-password', [UserProfileController::class, 'updatePassword'])->name('updatePassword');
        Route::post('/update-name', [UserProfileController::class, 'updateName'])->name('updateName');
        Route::delete('/delete', [UserProfileController::class, 'delete'])->name('deleteImage');
    });

    //admin
    Route::prefix('admin')->name('admin.')->middleware('is_admin')->group(function() {

        Route::get('/', [AdminHomeController::class, 'index'])->name('index');
        Route::resource('gallery', GalleryController::class)->except(['create']);
        Route::get('/gallery/{gallery}/trinti-nuotraukas', [GalleryController::class,'deleteImages'])->name('gallery.deleteImages');

        Route::resource('files', FileController::class)->except(['create']);
        Route::get('/files/{campId}/trinti-failus', [FileController::class,'deleteFiles'])->name('files.deleteFiles');
        Route::put('/files/{campId}/update', [FileController::class, 'update'])->name('files.update');

        Route::resource('articles', ArticleController::class);
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class)->except(['create']);
        Route::resource('feedbacks', FeedbackController::class)->only(['index', 'update', 'destroy']);
        Route::post('/users/{user}/renew-membership', [UserController::class, 'renewMembership'])->name('users.renewMembership');

        Route::prefix('camps')->name('camps.')->group(function () {
            Route::resource('programmes', ProgrammeController::class)->except(['create']);
            Route::get('/', [CampController::class, 'index'])->name('index');
            Route::post('/', [CampController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CampController::class, 'edit'])->name('edit');
            Route::put('{id}', [CampController::class, 'update'])->name('update');
            Route::delete('{id}', [CampController::class, 'destroy'])->name('destroy');

            Route::prefix('participants')->name('participants.')->group(function () {
                Route::get('{id}', [ParticipantsController::class, 'index'])->name('show');
                Route::put('{campId}/{participantId}', [ParticipantsController::class, 'update'])->name('update');
                Route::get('{campId}/trinti-narius', [ParticipantsController::class, 'delete'])->name('delete');
                Route::delete('{campId}', [ParticipantsController::class, 'destroy'])->name('destroy');
            });

            Route::get('{id}/data', [CampController::class, 'getCampData'])->name('campData');
        });
    });
});
