<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'TG_message';

    /**
     * Run the migrations.
     * @table message
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {

            $table->bigIncrements('chat_id')->comment('Unique chat identifier');
            $table->unsignedBigInteger('id')->nullable()->default(null)->comment('Unique message identifier');
            $table->bigInteger('user_id')->nullable()->default(null)->comment('Unique user identifier');
            $table->timestamp('date')->nullable()->default(null)->comment('Date the message was sent in timestamp format');
            $table->bigInteger('forward_from')->nullable()->default(null)->comment('Unique user identifier, sender of the original message');
            $table->bigInteger('forward_from_chat')->nullable()->default(null)->comment('Unique chat identifier, chat the original message belongs to');
            $table->bigInteger('forward_from_message_id')->nullable()->default(null)->comment('Unique chat identifier of the original message in the channel');
            $table->text('forward_signature')->nullable()->default(null)->comment('For messages forwarded from channels, signature of the post author if present');
            $table->text('forward_sender_name')->nullable()->default(null)->comment('Sender\'\'s name for messages forwarded from users who disallow adding a link to their account in forwarded messages');
            $table->timestamp('forward_date')->nullable()->default(null)->comment('date the original message was sent in timestamp format');
            $table->bigInteger('reply_to_chat')->nullable()->default(null)->comment('Unique chat identifier');
            $table->unsignedBigInteger('reply_to_message')->nullable()->default(null)->comment('Message that this message is reply to');
            $table->bigInteger('via_bot')->nullable()->default(null)->comment('Optional. Bot through which the message was sent');
            $table->unsignedBigInteger('edit_date')->nullable()->default(null)->comment('Date the message was last edited in Unix time');
            $table->text('media_group_id')->nullable()->default(null)->comment('The unique identifier of a media message group this message belongs to');
            $table->text('author_signature')->nullable()->default(null)->comment('Signature of the post author for messages in channels');
            $table->text('text')->nullable()->default(null)->comment('For text messages, the actual UTF-8 text of the message max message length 4096 char utf8mb4');
            $table->text('entities')->nullable()->default(null)->comment('For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text');
            $table->text('caption_entities')->nullable()->default(null)->comment('For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption');
            $table->text('audio')->nullable()->default(null)->comment('Audio object. Message is an audio file, information about the file');
            $table->text('document')->nullable()->default(null)->comment('Document object. Message is a general file, information about the file');
            $table->text('animation')->nullable()->default(null)->comment('Message is an animation, information about the animation');
            $table->text('game')->nullable()->default(null)->comment('Game object. Message is a game, information about the game');
            $table->text('photo')->nullable()->default(null)->comment('Array of PhotoSize objects. Message is a photo, available sizes of the photo');
            $table->text('sticker')->nullable()->default(null)->comment('Sticker object. Message is a sticker, information about the sticker');
            $table->text('video')->nullable()->default(null)->comment('Video object. Message is a video, information about the video');
            $table->text('voice')->nullable()->default(null)->comment('Voice Object. Message is a Voice, information about the Voice');
            $table->text('video_note')->nullable()->default(null)->comment('VoiceNote Object. Message is a Video Note, information about the Video Note');
            $table->text('caption')->nullable()->default(null)->comment('For message with caption, the actual UTF-8 text of the caption');
            $table->text('contact')->nullable()->default(null)->comment('Contact object. Message is a shared contact, information about the contact');
            $table->text('location')->nullable()->default(null)->comment('Location object. Message is a shared location, information about the location');
            $table->text('venue')->nullable()->default(null)->comment('Venue object. Message is a Venue, information about the Venue');
            $table->text('poll')->nullable()->default(null)->comment('Poll object. Message is a native poll, information about the poll');
            $table->text('dice')->nullable()->default(null)->comment('Message is a dice with random value from 1 to 6');
            $table->text('new_chat_members')->nullable()->default(null)->comment('List of unique user identifiers, new member(s) were added to the group, information about them (one of these members may be the bot itself)');
            $table->bigInteger('left_chat_member')->nullable()->default(null)->comment('Unique user identifier, a member was removed from the group, information about them (this member may be the bot itself)');
            $table->char('new_chat_title',
                255)->nullable()->default(null)->comment('A chat title was changed to this value');
            $table->text('new_chat_photo')->nullable()->default(null)->comment('Array of PhotoSize objects. A chat photo was change to this value');
            $table->tinyInteger('delete_chat_photo')->nullable()->default('0')->comment('Informs that the chat photo was deleted');
            $table->tinyInteger('group_chat_created')->nullable()->default('0')->comment('Informs that the group has been created');
            $table->tinyInteger('supergroup_chat_created')->nullable()->default('0')->comment('Informs that the supergroup has been created');
            $table->tinyInteger('channel_chat_created')->nullable()->default('0')->comment('Informs that the channel chat has been created');
            $table->bigInteger('migrate_to_chat_id')->nullable()->default(null)->comment('Migrate to chat identifier. The group has been migrated to a supergroup with the specified identifier');
            $table->bigInteger('migrate_from_chat_id')->nullable()->default(null)->comment('Migrate from chat identifier. The supergroup has been migrated from a group with the specified identifier');
            $table->text('pinned_message')->nullable()->default(null)->comment('Message object. Specified message was pinned');
            $table->text('invoice')->nullable()->default(null)->comment('Message is an invoice for a payment, information about the invoice');
            $table->text('successful_payment')->nullable()->default(null)->comment('Message is a service message about a successful payment, information about the payment');
            $table->text('connected_website')->nullable()->default(null)->comment('The domain name of the website on which the user has logged in.');
            $table->text('passport_data')->nullable()->default(null)->comment('Telegram Passport data');
            $table->text('reply_markup')->nullable()->default(null)->comment('Inline keyboard attached to the message');

            $table->index(["migrate_to_chat_id"], 'migrate_to_chat_id');

            $table->index(["reply_to_chat", "reply_to_message"], '');

            $table->index(["forward_from_chat"], 'forward_from_chat');

            $table->index(["user_id"], 'user_id');

            $table->index(["via_bot"], 'via_bot');

            $table->index(["forward_from"], 'forward_from');

            $table->index(["reply_to_chat"], 'reply_to_chat');

            $table->index(["migrate_from_chat_id"], 'migrate_from_chat_id');

            $table->index(["left_chat_member"], 'left_chat_member');

            $table->index(["reply_to_message"], 'reply_to_message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
