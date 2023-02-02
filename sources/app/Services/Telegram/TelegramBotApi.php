<?php
declare(strict_types=1);

namespace App\Services\Telegram;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

final class TelegramBotApi
{
    /** @var string */
    private const HOST = 'https://api.telegram.org/bot';

    /**
     * @param string $token
     * @param int $chat_id
     * @param string $message
     * @return bool
     * @throws RequestException
     */
    public static function sendMessage(string $token, int $chat_id, string $message): bool
    {
        $response = Http::get(self::HOST . $token . '/sendMessage', [
            'chat_id' => $chat_id,
            'text' => $message
        ])->throw();
        return $response->json()['ok'];
    }
}
