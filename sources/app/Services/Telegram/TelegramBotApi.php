<?php
declare(strict_types=1);

namespace App\Services\Telegram;

use App\Exceptions\TelegramBotApiException;
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
     */
    public static function sendMessage(string $token, int $chat_id, string $message): bool
    {
        try {
            $response = Http::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chat_id,
                'text' => $message
            ])->throw();
            return $response->json()['ok'] ?? false;
        } catch (\Throwable $e) {
            report(new TelegramBotApiException($e->getMessage()));
        }
        return false;
    }
}
