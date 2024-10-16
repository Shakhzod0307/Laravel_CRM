<?php


use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;



Route::get('set-webhook',function (){
  $response = Telegram::setWebhook(['url' => 'https://b253-95-214-211-231.ngrok-free.app/api/telegram/webhook']);
});
