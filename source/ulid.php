<?php

class UlidGenerator {
    private $ulid;

    public function __construct()
    {
        $this->ulid = self::generate();
    }

    # This line holds the characters used for encoding the ULID
    private static $encoding = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';

    # Returns the result of the generated ULID
    public static function generate() {
        $time = microtime(true) * 1000;
        $timeChars = self::encodeTime($time);
        $randomChars = self::encodeRandom();

        return $timeChars . $randomChars;
    }

    # Encodes the timestamp to a string
    private static function encodeTime($time) {
        $chars = '';
        for ($i = 0; $i < 10; $i++) {
            $chars = self::$encoding[$time % 32] . $chars;
            $time = (int)($time / 32);
        }
        return $chars;
    }

    # Generates a random string and returns it
    private static function encodeRandom() {
        $chars = '';
        for ($i = 0; $i < 16; $i++) {
            $chars .= self::$encoding[random_int(0, 31)];
        }
        return $chars;
    }

    # Returns the generated ULID
    public function getUlid() {
        return $this->ulid;
    }
}