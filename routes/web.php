<?php

use App\Events\MyPresenceMessage;
use App\Events\MyPrivateMessage;
use App\Events\MyPublicMessage;
use App\Http\Controllers\ProfileController;
use App\Models\Message;
use Illuminate\Support\Facades\Route;

Route::get('/listen-public', function () {
    $messages = Message::whereNull('group')->where('private', false)->get();
    return view('public', compact('messages'));
});

Route::get('/emit-public/{message}', function (string $message) {
    $model = new Message();
    $model->message = $message;
    $model->private = false;
    $model->save();
    event(new MyPublicMessage($message));
    return 'You just broadcasted a public message "' . $message . '"';
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/listen-presence/{group}', function ($group) {
        $messages = Message::where('group', $group)->where('private', true)->get();
        return view('presence', compact('messages', 'group'));
    });

    Route::get('/emit-presence/{group}/{message}', function ($group, $message) {
        $model = new Message();
        $model->private = true;
        $model->group = $group;
        $model->message = $message;
        $model->save();

        event(new MyPresenceMessage(Auth::user(), $model));

        return 'You just broadcasted a presence message "' . $message . '"';
    });

    Route::get('/listen-private/{group}', function ($group) {
        $messages = Message::where('group', $group)->where('private', true)->get();
        return view('private', compact('messages', 'group'));
    });

    Route::get('/emit-private/{group}/{message}', function ($group, $message) {
        $model = new Message();
        $model->private = true;
        $model->group = $group;
        $model->message = $message;
        $model->save();

        event(new MyPrivateMessage(Auth::user(), $model));

        return 'You just broadcasted a private message "' . $message . '"';
    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
