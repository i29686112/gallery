<?php

namespace Tests\Feature;

use Tests\TestCase;

class TelegramControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSendSinglePhoto()
    {
        // test single photo file is enough.
        // because if we send multiple photos, telegram will send multiple webhook callback with additional `media_group_id` field.

        $randomId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $randomId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606379982,        "photo": [            {                "file_id": "AgACAgUAAxkBAAMeX79pzqco8f8zpaqVEF9GSpFGeiYAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA20AA-AAAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA-AAAQEAAQ",                "file_size": 5111,                "width": 320,                "height": 165            },            {                "file_id": "AgACAgUAAxkBAAMeX79pzqco8f8zpaqVEF9GSpFGeiYAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA3gAA94AAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA94AAQEAAQ",                "file_size": 12160,                "width": 676,                "height": 349            }        ]    }}';

        $response = $this->call(
            'POST',
            '/telegram',
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE' => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
    }


}
