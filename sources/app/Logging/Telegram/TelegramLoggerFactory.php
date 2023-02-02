<?php
declare(strict_types=1);


namespace App\Logging\Telegram;

use Monolog\Logger;

class TelegramLoggerFactory
{
    /**
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config): Logger
    {
        $logger = new Logger('telegram');
        $logger->pushHandler(new TelegramLoggerHandler($config));
        return $logger;
    }
}
