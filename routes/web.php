<?php

use App\Events\MyPublicMessage;
use App\Models\Message;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $messages = Message::get();
    return view('welcome', compact('messages'));
});

Route::get('/message/{message}', function (string $message) {
    $model = new Message();
    $model->message = $message;
    $model->save();
    event(new MyPublicMessage($message));
    return 'You just broadcasted a public message "' . $message . '"';
});
