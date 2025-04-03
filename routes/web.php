<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->to('/chat');
});

Route::get("migrate-fresh-seed", function(){

    Artisan::call("migrate:fresh --seed");

    return "Migrate Fresh and Seed Successfully";

});

Route::get("clear-cache", function(){

    Artisan::call("cache:clear");
    Artisan::call("config:clear");
    Artisan::call("view:clear");
    Artisan::call("route:clear");

    return "Cache cleared successfully";

});

Route::middleware(['auth'])->group(function(){

    // Chat Routes
    Route::get('chat', [ChatController::class, 'chat']);
    Route::post('chat/load-messages', [ChatController::class, 'loadChatMessages']);
    Route::post('chat/load-channel-messages', [ChatController::class, 'loadChannelMessages']);
    Route::post('chat/check-channel-exists', [ChatController::class, 'checkChannelExists']);
    Route::post('chat/create-channel', [ChatController::class, 'createChannel']);
    Route::post('chat/broadcast-message', [ChatController::class, 'broadcastMessage']);
    Route::post('chat/broadcast-images', [ChatController::class, 'broadcastImages']);

    // Profile Management Routes
    Route::get('user/profile', [UserProfileController::class, 'index']);
    Route::post('user/profile/update', [UserProfileController::class, 'update']);

    // User Management Routes
    Route::get('user/contacts/add', [ContactController::class, 'index']);
    Route::post('user/contacts/add', [ContactController::class, 'addContact']);


});

Route::get('/chat-theme', function(){

    return view("chatTheme.index");

});

Route::get('/dashboard', function () {
    return redirect()->to('/chat');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
