<?php

namespace Scaliter;

class Authentication
{
    public static function generateKey(int $length = 16)
    {
        $indicum = '';
        $characters = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        for ($i = 0; $i < $length; $i++)
            $indicum .= $characters[random_int(0, 61)];
        return substr($indicum, 0, $length);
    }
    public static function generateCode(string $secret, int $delay = 60)
    {
        $time = ceil(time() / $delay);
        return self::getCode($time, $secret);
    }
    public static function verifyCode(string $secret, string $code, int $delay = 60)
    {
        $code = trim($code);
        $time = ceil(time() / $delay) - 1;
        for ($i = 0; $i < 3; $i++) {
            if ($code == self::getCode($time + $i, $secret)) return true;
        }
        return false;
    }
    private static function getCode(int $time, string $secret)
    {
        return substr(preg_replace('/[^0-9]+/', '', hash("sha256", $time . $secret) . "987123"), 0, 6);
    }
}