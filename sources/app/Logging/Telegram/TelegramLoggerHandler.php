<?php
declare(strict_types=1);

namespace App\Logging\Telegram;

use App\Exceptions\TelegramLoggerBotApiException;
use App\Services\Telegram\TelegramBotApi;
use http\Exception\RuntimeException;
use Illuminate\Http\Client\RequestException;
use  Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class TelegramLoggerHandler extends AbstractProcessingHandler
{
    /**
     * @var string
     */
    private string $token;

    /**
     * @var int
     */
    private int $chatId;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct(Logger::toMonologLevel($config['level']));
        $this->token = $config['token'] ?? throw new RuntimeException('Not set token for telegram bot');
        $this->chatId = $config['chat_id']
            ? (int)$config['chat_id']
            : throw new RuntimeException('Not set chat id for telegram bot');
    }

    /**
     * @param array $record
     * @return void
     * @throws TelegramLoggerBotApiException
     */
    protected function write(array $record): void
    {
        try {
            TelegramBotApi::sendMessage($this->token, $this->chatId, $record['formatted']);
        } catch (RequestException $e) {
            throw new TelegramLoggerBotApiException($e->getMessage());
        }
    }
}
