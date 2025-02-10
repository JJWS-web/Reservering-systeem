<?php

class UlidGenerator {
    private $ulid;

    // Crockford Base32 encoding characters (excluding I, L, O, U)
    private static $encoding = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';

    public function __construct()
    {
        $this->ulid = self::generate();
    }

    // Generates a valid ULID by combining time and random components
    public static function generate() {
        $time = (int) (microtime(true) * 1000); // Current timestamp in milliseconds
        $timeChars = self::encodeTime($time);
        $randomChars = self::encodeRandom();

        return $timeChars . $randomChars;
    }

    // Encodes the timestamp into 10 Base32 characters (48 bits)
    private static function encodeTime($time) {
        $chars = '';
        for ($i = 0; $i < 10; $i++) {
            $chars = self::$encoding[$time % 32] . $chars;
            $time = (int) ($time / 32);
        }
        return $chars;
    }

    // Generates 16 Base32 characters (80 bits) of randomness
    private static function encodeRandom() {
        $chars = '';
        for ($i = 0; $i < 16; $i++) {
            $chars .= self::$encoding[random_int(0, 31)];
        }
        return $chars;
    }

    // Returns the generated ULID
    public function getUlid() {
        return $this->ulid;
    }
}
