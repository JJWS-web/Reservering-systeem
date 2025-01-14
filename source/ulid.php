<?php

class UlidGenerator {
    #This line holds the characters used for encoding the ULID
    private static $encoding = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';
    #Returns te result of the generated ulid
    public static function generate() {
        $time = microtime(true) * 1000;
        $timeChars = self::encodeTime($time);
        $randomChars = self::encodeRandom();

        return $timeChars . $randomChars;
    }
    #returns the timestamp to an interger
    private static function encodeTime($time) {
        $chars = '';
        for ($i = 0; $i < 10; $i++) {
            $chars = self::$encoding[$time % 32] . $chars;
            $time = (int)($time / 32);
        } 
        return $chars;
    }
    #Generates a random string and returns it
    private static function encodeRandom() {
        $chars = '';
        for ($i = 0; $i < 16; $i++) {
            $chars .= self::$encoding[random_int(0, 31)];
        }
        return $chars;
    }
}

$ulid = UlidGenerator::generate();

echo "Generated ULID: $ulid\n";