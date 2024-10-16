<?php

namespace App\Http\Controllers\TelegramBot;

use App\Http\Controllers\Controller;
use App\Models\telegrambotuser;
use App\Telegram\Commands\BotHaqidaCommand;
use App\Telegram\Commands\DuoCommand;
use App\Telegram\Commands\MenyuCommand;
use App\Telegram\Commands\NamozVaqtlariCommand;
use App\Telegram\Commands\StartCommand;
use App\Telegram\Commands\TaqvimCommand;
use App\Telegram\Commands\ZikrlarCommand;
use Telegram\Bot\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
  public function handle(Request $request)
  {
    $viloyatlar = [
      'andijon'=>'Andijon viloyati',
      'buxoro'=>'Buxoro viloyati',
      'fargona'=>"Farg'ona viloyati",
      'jizzax'=>'Jizzax viloyati',
      'namangan'=>'Namangan viloyati',
      'navoiy'=>'Navoiy viloyati',
      'surxondaryo'=>'Surxondaryo viloyati',
      'samarqand'=>'Samarkand viloyati',
      'sirdaryo'=>'Sirdaryo viloyati',
      'xorazm'=>'Xorazm viloyati',
      'qashqadaryo'=>'Qashqadaryo viloyati',
      'toshkent'=>'Toshkent viloyati',
      'qoraqalpogiston'=>"Qoraqalpog'iston Respublikasi",
    ];
    $cities = [
      'andijon', 'xonobod', 'xojaobod', 'asaka', 'marhamat', 'paytug', 'boston', 'buxoro', 'jondor', 'qorakol', 'gijduvon', 'gazli', 'fargona', 'qoqon', 'margilon', 'quva', 'rishton', 'bogdod', 'oltiariq', 'jizzax', 'zomin', 'forish', 'gallaorol', 'termiz', 'boysun', 'denov', 'sherobod',
      'shorchi', 'namangan', 'chortoq', 'chust', 'pop1', 'uchqorgon', 'mingbuloq', 'navoiy', 'zarafshon', 'konimex', 'nurota', 'uchquduq', 'qarshi', 'dehqonobod', 'muborak', 'shahrisabz', 'guzor', 'sirdaryo',
      'guliston', 'sardoba', 'boyovut', 'paxtaobod', 'samarqand', 'ishtixon', 'mirbozor', 'kattaqorgon', 'urgut', 'nukus', 'moynoq', 'taxtakopir', 'tortkol', 'qongirot', 'urganch', 'hazorasp', 'xonqa', 'yangibozor', 'shovot', 'toshkent', 'angren', 'piskent',
      'bekobod', 'parkent', 'gazalkent', 'olmaliq', 'boka', 'yangiyol', 'nurafshon',
    ];

    try {
      $telegramMessage = Telegram::getWebhookUpdates();
      if (isset($telegramMessage['message']['text'])) {
        $chatId = $telegramMessage['message']['chat']['id'];
        $messageText = $telegramMessage['message']['text'];
        if ($messageText === '/start') {
          (new StartCommand())->execute($chatId);
          $user = new telegrambotuser();
          $user->user_id=$chatId;
          $user->first_name=$telegramMessage['message']['chat']['first_name'] ?? null;
          $user->last_name=$telegramMessage['message']['chat']['last_name'] ?? null;
          $user->username=$telegramMessage['message']['chat']['username'] ?? null;
          $user->photoUrl=null;
          $user->save();
        };
        if ($messageText === '⬅️Bosh Menyu'){
          (new MenyuCommand())->execute($chatId);
        };
        if ($messageText === '⬅️Orqaga'){
          (new TaqvimCommand())->execute($chatId);
        };if ($messageText === '⬅️ Orqaga'){
          (new NamozVaqtlariCommand())->execute($chatId);
        };
        if ($messageText === '📆Ramazon taqvimi'){
          (new TaqvimCommand())->execute($chatId);
        };
        if ($messageText === '🕍Namoz vaqtlari'){
          (new NamozVaqtlariCommand())->execute($chatId);
        };
        if ($messageText === "🤲Ro'za tutish duosi"){
          (new DuoCommand())->execute($chatId);
        };
        if ($messageText === '🤲Namozdan keyingi zikrlar'){
          (new ZikrlarCommand())->execute($chatId);
        };
        if ($messageText === 'Namozdan keyingi zikrlar'){
          (new ZikrlarCommand())->zikrlar($chatId);
        };
        if ($messageText === 'Oyatal Kursi'){
          (new ZikrlarCommand())->oyatalKursi($chatId);
        };
        if ($messageText === 'Tasbeh'){
          (new ZikrlarCommand())->tasbeh($chatId);
        };
        if ($messageText === 'Kalimai Tavhid'){
          (new ZikrlarCommand())->tavhid($chatId);
        };
        if ($messageText === '📚Bot haqida'){
          (new BotHaqidaCommand())->execute($chatId);
        };
        foreach ($viloyatlar as $key => $value) {
          if ($messageText === $value) {
            (new NamozVaqtlariCommand())->viloyat($key,$chatId);
            break;
          }
        }
        foreach ($cities as $shahar) {
          if ($messageText === $shahar) {
            (new NamozVaqtlariCommand())->shaharlar($shahar,$chatId);
            break;
          }
        }

        Log::info('Incoming Telegram webhook', ['data' => $request->all()]);
      }
    } catch (\Exception $exception) {
      report($exception);
      Log::error('exp', ['message' => $exception->getMessage()]);
      return response('error', 200);
    }
    return 'ok';
  }


  public function getUserProfilePhotos($userId)
  {
    // Create a new instance of the Telegram API
    $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

    // Fetch the user's profile photos
    $response = $telegram->getUserProfilePhotos([
      'user_id' => $userId,
      'limit'   => 1,  // Set the number of photos to retrieve, default is 1
    ]);

    // Check if the user has profile photos
    if ($response['total_count'] > 0) {
      $photo = $response['photos'][0][0]; // The first profile photo, size [0][0] is usually the smallest version
      $fileId = $photo['file_id'];

      // Now get the file path for the photo using getFile
      $file = $telegram->getFile(['file_id' => $fileId]);

      // Build the URL to download the photo
      $fileUrl = 'https://api.telegram.org/file/bot' . env('TELEGRAM_BOT_TOKEN') . '/' . $file['file_path'];

      return response()->json([
        'photo_url' => $fileUrl
      ]);
    } else {
      return response()->json(['message' => 'No profile photos found for this user']);
    }
  }

}
