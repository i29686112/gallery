<?php

namespace Tests\Feature;

use Tests\TestCase;

class TelegramControllerTest extends TestCase
{

    public function testSendSinglePhotoWithValidFilmCaption()
    {
        // test single photo file is enough.
        // because if we send multiple photos, telegram will send multiple webhook callback with additional `media_group_id` field.

        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606448378,        "photo": [            {                "file_id": "AgACAgUAAxkBAANPX8B0-rWYzbPZxV6QZQo0vn6AxVMAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA20AA-AAAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA-AAAQEAAQ",                "file_size": 5111,                "width": 320,                "height": 165            },            {                "file_id": "AgACAgUAAxkBAANPX8B0-rWYzbPZxV6QZQo0vn6AxVMAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA3gAA94AAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA94AAQEAAQ",                "file_size": 12160,                "width": 676,                "height": 349            }        ],        "caption": "Vista 200"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(SAVE_PHOTO_SUCCESS_MESSAGE);
    }

    public function testSendSinglePhotoWithInValidFilmCaption()
    {
        // test single photo file is enough.
        // because if we send multiple photos, telegram will send multiple webhook callback with additional `media_group_id` field.

        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606448378,        "photo": [            {                "file_id": "AgACAgUAAxkBAANPX8B0-rWYzbPZxV6QZQo0vn6AxVMAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA20AA-AAAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA-AAAQEAAQ",                "file_size": 5111,                "width": 320,                "height": 165            },            {                "file_id": "AgACAgUAAxkBAANPX8B0-rWYzbPZxV6QZQo0vn6AxVMAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA3gAA94AAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA94AAQEAAQ",                "file_size": 12160,                "width": 676,                "height": 349            }        ],        "caption": "open200"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);

        // 因為有分行，我們判斷前10個字元就好
        $response->assertSeeText(substr(UNKNOWN_FILM_MESSAGE, 0, 10));
    }


    public function testSendNonPhotoMessage()
    {

        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606445974,        "text": "123456"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(NOT_PHOTO_MESSAGE);
    }

    public function testSendMultiplePhotosAtFirstPhotoCallback()
    {

        // At the first callback in a multiple photos sending, if will have `caption` field, we need to save it for others photo with same `media_group_id` use

        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606448831,        "media_group_id": "12851590655512173",        "photo": [            {                "file_id": "AgACAgUAAxkBAANTX8B2v0tzJWk8Rv_1hx-suCKSmjcAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA20AA-AAAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA-AAAQEAAQ",                "file_size": 5111,                "width": 320,                "height": 165            },            {                "file_id": "AgACAgUAAxkBAANTX8B2v0tzJWk8Rv_1hx-suCKSmjcAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA3gAA94AAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA94AAQEAAQ",                "file_size": 12160,                "width": 676,                "height": 349            }        ],        "caption": "yoman"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
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
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(NOT_SUPPORT_UNCOMPRESSED_PHOTO);
    }

    public function testSendMessageFromNotAdmin()
    {
        // test single photo file is enough.
        // because if we send multiple photos, telegram will send multiple webhook callback with additional `media_group_id` field.

        $updateId = mt_rand(1, 10000);
        $messageId = mt_rand(1, 1000);
        $chatId = 123456789;


        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": ' . $chatId . ',            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": ' . $chatId . ',            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606448378,        "photo": [            {                "file_id": "AgACAgUAAxkBAANPX8B0-rWYzbPZxV6QZQo0vn6AxVMAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA20AA-AAAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA-AAAQEAAQ",                "file_size": 5111,                "width": 320,                "height": 165            },            {                "file_id": "AgACAgUAAxkBAANPX8B0-rWYzbPZxV6QZQo0vn6AxVMAAnSrMRs3KwABVl9n6W5MszNoBEgkbXQAAwEAAwIAA3gAA94AAQEAAR4E",                "file_unique_id": "AQADBEgkbXQAA94AAQEAAQ",                "file_size": 12160,                "width": 676,                "height": 349            }        ],        "caption": "Vista 200"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(NO_ADMIN_USING_MESSAGE);
    }


    public function testSendTextFromGroup()
    {
        // test single photo file is enough.
        // because if we send multiple photos, telegram will send multiple webhook callback with additional `media_group_id` field.

        $updateId = mt_rand(1, 10000);
        $messageId = mt_rand(1, 1000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": -419890217,            "title": "photo test",            "type": "group",            "all_members_are_administrators": true        },        "date": 1606880559,        "text": "aaa"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(NO_ADMIN_USING_MESSAGE);
    }

    public function testSendListCommandWithWrongFilmName()
    {
        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606445974,        "text": "list 111"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        // 因為有分行，我們判斷前10個字元就好
        $response->assertSeeText(substr(UNKNOWN_FILM_MESSAGE, 0, 10));
    }

    public function testSendListCommandWithExistFilmName()
    {
        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606445974,        "text": "list vista 200"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(WE_GOT_YOUR_FILM);
    }

    public function testDeleteByPhotoIdFailed()
    {
        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606445974,        "text": "delete 105"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(WE_DELETE_YOUR_PHOTO_FAILED);
    }

    public function testDeleteByPhotoIdWithInvalidPhotoId()
    {
        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606445974,        "text": "delete $%^&*()_"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(INVALID_PHOTO_ID);
    }


    public function testDeleteByPhotoIdWithoutInputPhotoId()
    {
        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606445974,        "text": "delete"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(INVALID_PHOTO_ID);
    }

    public function testDeleteByPhotoIdWithCSV()
    {
        $messageId = mt_rand(1, 1000);
        $updateId = mt_rand(1, 10000);

        $rawContent = '{    "update_id": ' . $updateId . ',    "message": {        "message_id": ' . $messageId . ',        "from": {            "id": 227278637,            "is_bot": false,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "language_code": "zh-hans"        },        "chat": {            "id": 227278637,            "first_name": "Ian",            "last_name": "Chiang",            "username": "Ianixn",            "type": "private"        },        "date": 1606445974,        "text": "delete 1,2,63"    }}';

        $response = $this->call(
            'POST',
            '/telegram/' . env('TELEGRAM_API_SECRET'),
            [],
            [],
            [],
            $headers = [
                'HTTP_CONTENT_LENGTH' => mb_strlen($rawContent, '8bit'),
                'CONTENT_TYPE'        => 'application/json',
            ],
            $rawContent);

        $response->assertStatus(200);
        $response->assertSeeText(INVALID_PHOTO_ID);
    }


}
