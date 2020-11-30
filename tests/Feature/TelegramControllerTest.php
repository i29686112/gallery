<?php

namespace Tests\Feature;

use Tests\TestCase;

class TelegramControllerTest extends TestCase
{

    public function testSendSinglePhoto()
    {
        // test single photo file is enough.
        // because if we send multiple photos, telegram will send multiple webhook callback with additional `media_group_id` field.

        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606448378,        "photo": [            {                "file_id": "AgACAgUAAxkBAANPX8B0-rWYzbPZxV6QZQo0vn6AxVMAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA20AA-AAAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA-AAAQEAAQ",                "file_size": 5111,                "width": 320,                "height": 165            },            {                "file_id": "AgACAgUAAxkBAANPX8B0-rWYzbPZxV6QZQo0vn6AxVMAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA3gAA94AAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA94AAQEAAQ",                "file_size": 12160,                "width": 676,                "height": 349            }        ],        "caption": "asdfas"    }}';

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

    public function testSendNonPhotoMessage()
    {
        // test single photo file is enough.
        // because if we send multiple photos, telegram will send multiple webhook callback with additional `media_group_id` field.

        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606445974,        "text": "123456"    }}';

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

    public function testSendMultiplePhotosAtFirstPhotoCallback()
    {

        // At the first callback in a multiple photos sending, if will have `caption` field, we need to save it for others photo with same `media_group_id` use

        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606448831,        "media_group_id": "12851590655512173",        "photo": [            {                "file_id": "AgACAgUAAxkBAANTX8B2v0tzJWk8Rv_1hx-suCKSmjcAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA20AA-AAAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA-AAAQEAAQ",                "file_size": 5111,                "width": 320,                "height": 165            },            {                "file_id": "AgACAgUAAxkBAANTX8B2v0tzJWk8Rv_1hx-suCKSmjcAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA3gAA94AAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA94AAQEAAQ",                "file_size": 12160,                "width": 676,                "height": 349            }        ],        "caption": "yoman"    }}';

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

    public function testSendOneUnCompressPhoto()
    {
        // un compress photo will be a document type data, not photo

        $updateId = mt_rand(1, 10000);
        $messageId = mt_rand(1, 1000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606707118,        "document": {            "file_name": "未命名.png",            "mime_type": "image/png",            "thumb": {                "file_id": "AAMCBQADGQEAA5tfxGeu5r9i6cgqTbta3Xb4-OvOcAACZwEAAm8UIFYPsJ9YrYSf5gZ6G250AAMBAAdtAAMKjAACHgQ",                "file_unique_id": "AQADBnobbnQAAwqMAAI",                "file_size": 4750,                "width": 320,                "height": 165            },            "file_id": "BQACAgUAAxkBAAObX8Rnrua_YunIKk27Wt12-PjrznAAAmcBAAJvFCBWD7CfWK2En-YeBA",            "file_unique_id": "AgADZwEAAm8UIFY",            "file_size": 156939        },        "caption": "abvdc"    }}';

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
