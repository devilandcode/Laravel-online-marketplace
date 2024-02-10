<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use Http;

final class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';
    public static function sendMessage(string $token, int $chatId, string $text): bool
    {
        try {
            $response = HTTP::get(self::HOST . $token . '/sendMessage', [
                'chat_id' => $chatId,
                'text' => $text,
            ]);
            return ($response->status() === 200) ? true : false;
        } catch (\Exception $e) {
            logger()->warning('Message to telegram has refused: ' . $e->getMessage());
            return false;
        }
    }
}
