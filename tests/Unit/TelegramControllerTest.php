<?php

namespace Tests\Unit;

use Tests\TestCase;

class TelegramControllerTest extends TestCase
{

    public function testParseSingleImageCallback()
    {

        $test =true;
        $this->assertEquals(false,$test);
    }

    private function getImageGroupCallbackWith3Images(){
        $photo1=array (
            'update_id' => 873864500,
            'message' =>
                array (
                    'message_id' => 7,
                    'from' =>
                        array (
                            'id' => 227278637,
                            'is_bot' => false,
                            'first_name' => 'Ian',
                            'last_name' => 'Chiang',
                            'username' => 'Ianixn',
                            'language_code' => 'zh-hans',
                        ),
                    'chat' =>
                        array (
                            'id' => 227278637,
                            'first_name' => 'Ian',
                            'last_name' => 'Chiang',
                            'username' => 'Ianixn',
                            'type' => 'private',
                        ),
                    'date' => 1606287814,
                    'media_group_id' => '12850302519243053',
                    'photo' =>
                        array (
                            0 =>
                                array (
                                    'file_id' => 'AgACAgUAAxkBAAMHX74BxmWpaFwyzGwUMBhOHCqrOrUAAk-rMRuxsfBVO0jPi80wUJrR10VtdAADAQADAgADbQAD3O4AAh4E',
                                    'file_unique_id' => 'AQAD0ddFbXQAA9zuAAI',
                                    'file_size' => 5111,
                                    'width' => 320,
                                    'height' => 165,
                                ),
                            1 =>
                                array (
                                    'file_id' => 'AgACAgUAAxkBAAMHX74BxmWpaFwyzGwUMBhOHCqrOrUAAk-rMRuxsfBVO0jPi80wUJrR10VtdAADAQADAgADeAAD2u4AAh4E',
                                    'file_unique_id' => 'AQAD0ddFbXQAA9ruAAI',
                                    'file_size' => 12160,
                                    'width' => 676,
                                    'height' => 349,
                                ),
                        ),
                    'caption' => '#nikon gold',
                    'caption_entities' =>
                        array (
                            0 =>
                                array (
                                    'offset' => 0,
                                    'length' => 6,
                                    'type' => 'hashtag',
                                ),
                        ),
                ),
        );
        $photo2=array (
            'update_id' => 873864501,
            'message' =>
                array (
                    'message_id' => 8,
                    'from' =>
                        array (
                            'id' => 227278637,
                            'is_bot' => false,
                            'first_name' => 'Ian',
                            'last_name' => 'Chiang',
                            'username' => 'Ianixn',
                            'language_code' => 'zh-hans',
                        ),
                    'chat' =>
                        array (
                            'id' => 227278637,
                            'first_name' => 'Ian',
                            'last_name' => 'Chiang',
                            'username' => 'Ianixn',
                            'type' => 'private',
                        ),
                    'date' => 1606287814,
                    'media_group_id' => '12850302519243053',
                    'photo' =>
                        array (
                            0 =>
                                array (
                                    'file_id' => 'AgACAgUAAxkBAAMIX74Bxk0Pd9nZV4sTjlNW36Rs6YIAAk-rMRuxsfBVO0jPi80wUJrR10VtdAADAQADAgADbQAD3O4AAh4E',
                                    'file_unique_id' => 'AQAD0ddFbXQAA9zuAAI',
                                    'file_size' => 5111,
                                    'width' => 320,
                                    'height' => 165,
                                ),
                            1 =>
                                array (
                                    'file_id' => 'AgACAgUAAxkBAAMIX74Bxk0Pd9nZV4sTjlNW36Rs6YIAAk-rMRuxsfBVO0jPi80wUJrR10VtdAADAQADAgADeAAD2u4AAh4E',
                                    'file_unique_id' => 'AQAD0ddFbXQAA9ruAAI',
                                    'file_size' => 12160,
                                    'width' => 676,
                                    'height' => 349,
                                ),
                        ),
                ),
        );
        $photo3=array (
            'update_id' => 873864502,
            'message' =>
                array (
                    'message_id' => 9,
                    'from' =>
                        array (
                            'id' => 227278637,
                            'is_bot' => false,
                            'first_name' => 'Ian',
                            'last_name' => 'Chiang',
                            'username' => 'Ianixn',
                            'language_code' => 'zh-hans',
                        ),
                    'chat' =>
                        array (
                            'id' => 227278637,
                            'first_name' => 'Ian',
                            'last_name' => 'Chiang',
                            'username' => 'Ianixn',
                            'type' => 'private',
                        ),
                    'date' => 1606287814,
                    'media_group_id' => '12850302519243053',
                    'photo' =>
                        array (
                            0 =>
                                array (
                                    'file_id' => 'AgACAgUAAxkBAAMJX74BxuMjtUhOc73dVzs2kDBdIJMAAk-rMRuxsfBVO0jPi80wUJrR10VtdAADAQADAgADbQAD3O4AAh4E',
                                    'file_unique_id' => 'AQAD0ddFbXQAA9zuAAI',
                                    'file_size' => 5111,
                                    'width' => 320,
                                    'height' => 165,
                                ),
                            1 =>
                                array (
                                    'file_id' => 'AgACAgUAAxkBAAMJX74BxuMjtUhOc73dVzs2kDBdIJMAAk-rMRuxsfBVO0jPi80wUJrR10VtdAADAQADAgADeAAD2u4AAh4E',
                                    'file_unique_id' => 'AQAD0ddFbXQAA9ruAAI',
                                    'file_size' => 12160,
                                    'width' => 676,
                                    'height' => 349,
                                ),
                        ),
                ),
        );
    }

    private function getSingleImageCallback(){
        return array (
            'update_id' => 873864497,
            'message' =>
                array (
                    'message_id' => 4,
                    'from' =>
                        array (
                            'id' => 227278637,
                            'is_bot' => false,
                            'first_name' => 'Ian',
                            'last_name' => 'Chiang',
                            'username' => 'Ianixn',
                            'language_code' => 'zh-hans',
                        ),
                    'chat' =>
                        array (
                            'id' => 227278637,
                            'first_name' => 'Ian',
                            'last_name' => 'Chiang',
                            'username' => 'Ianixn',
                            'type' => 'private',
                        ),
                    'date' => 1606286812,
                    'photo' =>
                        array (
                            0 =>
                                array (
                                    'file_id' => 'AgACAgUAAxkBAAMEX7393GDpay3UFyAr0X5WwxP23psAAk-rMRuxsfBVO0jPi80wUJrR10VtdAADAQADAgADbQAD3O4AAh4E',
                                    'file_unique_id' => 'AQAD0ddFbXQAA9zuAAI',
                                    'file_size' => 5111,
                                    'width' => 320,
                                    'height' => 165,
                                ),
                            1 =>
                                array (
                                    'file_id' => 'AgACAgUAAxkBAAMEX7393GDpay3UFyAr0X5WwxP23psAAk-rMRuxsfBVO0jPi80wUJrR10VtdAADAQADAgADeAAD2u4AAh4E',
                                    'file_unique_id' => 'AQAD0ddFbXQAA9ruAAI',
                                    'file_size' => 12160,
                                    'width' => 676,
                                    'height' => 349,
                                ),
                        ),
                    'caption' => '#abcde',
                    'caption_entities' =>
                        array (
                            0 =>
                                array (
                                    'offset' => 0,
                                    'length' => 6,
                                    'type' => 'hashtag',
                                ),
                        ),
                ),
        );


    }
}
