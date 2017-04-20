<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace utils;

class Encrypter {

    private static function ivSize() {
        return mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    }

    private static function hashKey($key) {
        return hash('sha256', strrev($key), true);
    }

    public static function encrypt($plaintext, $key, $randomIv = false) {
        # --- ENCRYPTION ---
        # the key should be random binary, use scrypt, bcrypt or PBKDF2 to
        # convert a string into a key
        # key is specified using hexadecimal
        # create a random IV to use with CBC encoding
        //hash('sha256', $key)
        $keyHex = self::hashKey($key);

        if (!$randomIv) {
            $iv = substr(base64_encode($keyHex), 0, self::ivSize());
        } else {
            $iv = mcrypt_create_iv(self::ivSize(), MCRYPT_RAND);
        }


        # creates a cipher text compatible with AES (Rijndael block size = 128)
        # to keep the text confidential 
        # only suitable for encoded input that never ends with value 00h
        # (because of default zero padding)
        $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $keyHex, $plaintext, MCRYPT_MODE_CBC, $iv);

        # prepend the IV for it to be available for decryption
        $ciphertext = $iv . $ciphertext;

        # encode the resulting cipher text so it can be represented by a string
        $ciphertext_base64 = base64_encode($ciphertext);
        return $ciphertext_base64;
    }

    public static function decrypt($payloadBase64, $key) {
        # === WARNING ===
        # Resulting cipher text has no integrity or authenticity added
        # and is not protected against padding oracle attacks.
        # --- DECRYPTION ---

        $ciphertext_dec = base64_decode($payloadBase64);

        # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
        $iv_size = self::ivSize();
        $iv_dec = substr($ciphertext_dec, 0, $iv_size);

        # retrieves the cipher text (everything except the $iv_size in the front)
        $ciphertext_dec2 = substr($ciphertext_dec, $iv_size);

        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, self::hashKey($key), $ciphertext_dec2, MCRYPT_MODE_CBC, $iv_dec), chr(0));
    }

}
