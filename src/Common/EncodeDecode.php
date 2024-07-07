<?php

namespace Saidqb\Lib\Common;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

trait EncodeDecode
{

    static function jwtEncode($payload, $hash = 'HS256')
    {
        $jwt = JWT::encode($payload, env('SQ_JWT_KEY'), $hash);
        return $jwt;
    }

    static function jwtDecode($jwt, $hash = 'HS256')
    {
        $isErr = false;
        try {
            $decoded = JWT::decode($jwt, new Key(env('SQ_JWT_KEY'), $hash));
        } catch (\Exception $e) {
            $isErr = true;
        }
        if ($isErr) {
            return '';
        }
        return $decoded;
    }

}
