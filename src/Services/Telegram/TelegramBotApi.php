<?php

declare(strict_types=1);

namespace Services\Telegram;

use Http;
use Services\Telegram\Exceptions\TelegramBotApiException;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';
    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = HTTP::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text,
            ])->throw();

            return $response->ok() ?? false;
        } catch (\Throwable $e) {
            report(new TelegramBotApiException($e->getMessage()));

            return false;
        }
    }
}
