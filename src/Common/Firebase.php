<?php

/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */

namespace Saidqb\Lib\Common;


trait Firebase
{
    static function fcm_multi_send($registration_ids = array(), $title = '', $body = '', $data_extra = array())
    {
        $firebase_key = env('SQ_FIREBASE_MESSAGE_KEY', '');
        $firebase_url = 'https://fcm.googleapis.com/fcm/send';
        if (strlen($body) > 35) {
            $body = substr($body, 0, 35);
            $body = explode(' ', $body);
            array_pop($body);  // remove last word from array
            $body = implode(' ', $body);
            $body = $body . '.....';
        }

        $notification = array(
            "title" => $title,
            "body" => $body,
            "sound" => 'default',
            "ongoing" => true,
            "vibrate" => true,
            "vibration" => 3000,
            "visibility" => "public",
            "priority" => "high",
            "importance" => "high",
            "largeIcon" => "ic_launcher",
            "playSound" => true,
            "soundName" => "default",
            "alert" => true
        );

        $arrayToSend = array('registration_ids' => $registration_ids, 'notification' => $notification, 'data' => $data_extra);


        $json = json_encode($arrayToSend);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $firebase_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $firebase_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Send the request
        $response = curl_exec($ch);
        curl_close($ch);
    }
}
