<?php
abstract class statGhent_Utility
{
    /**
     *
     * @param mixed $data
     * @param string $algo.
     * @return string
     */
    public static function hash($data, $algo = 'sha1')
    {
        $key = 'saltiewaltietestimbalti oh snap';

        // Hash-based Message Authentication Code
        return hash_hmac($algo, $data, $key);
    }
    
    public static function randomString($length = 64) {
        
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $str = "";    

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $str;
    }
}

?>
