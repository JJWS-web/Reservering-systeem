<?php

class UlidGenerator {
    private $ulid;

    
    private static $encoding = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';

    public function __construct()
    {
        $this->ulid = self::generate();
    }

   
    public static function generate() {
        $time = (int) (microtime(true) * 1000); 
        $timeChars = self::encodeTime($time);
        $randomChars = self::encodeRandom();

        return $timeChars . $randomChars;
    }

   
    private static function encodeTime($time) {
        $chars = '';
        for ($i = 0; $i < 10; $i++) {
            $chars = self::$encoding[$time % 32] . $chars;
            $time = (int) ($time / 32);
        }
        return $chars;
    }

    
    private static function encodeRandom() {
        $chars = '';
        for ($i = 0; $i < 16; $i++) {
            $chars .= self::$encoding[random_int(0, 31)];
        }
        return $chars;
    }

    
    public function getUlid() {
        return $this->ulid;
    }
}
