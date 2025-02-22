<?php

class UlidGenerator {
      /**
     * declares a private property to store the ulid
     * and a static property to store the encoding characters
     */
    private $ulid;
    private static $encoding = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';
  /**
     * when an instance of the class is made it calls the generate method
     */
    public function __construct()
    {
        $this->ulid = self::generate();
    }

     /**
     * generates a ulid by calling the encodeTime and encodeRandom methods
     * and returns the result
     */
    public static function generate() {
        $time = (int) (microtime(true) * 1000); 
        $timeChars = self::encodeTime($time);
        $randomChars = self::encodeRandom();

        return $timeChars . $randomChars;
    }

     /**
     *  encodes the time by converting the time to base 32 and then converting the base 32 number to a string
     */
    private static function encodeTime($time) {
        $chars = '';
        for ($i = 0; $i < 10; $i++) {
            $chars = self::$encoding[$time % 32] . $chars;
            $time = (int) ($time / 32);
        }
        return $chars;
    }

      /**
     * generates random characters by selecting 16 random characters from the encoding string
     */
    private static function encodeRandom() {
        $chars = '';
        for ($i = 0; $i < 16; $i++) {
            $chars .= self::$encoding[random_int(0, 31)];
        }
        return $chars;
    }

      /**
     * returns the ulid
     */

    public function getUlid() {
        return $this->ulid;
    }
}
