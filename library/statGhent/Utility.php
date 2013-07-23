<?php
abstract class statGhent_Utility
{
    /**
     *
     * @param mixed $data
     * @param string $algo.
     * @return string
     */
    public static function hash($data, $algo = 'sha512')
    {
        $key = START_IN_GHENT_SALT;
        $res = hash($algo, $data . $key);
        for ($i = 0; $i <= 30; $i++)
        {
            $res = hash($algo, $res . $key);
        }
        return substr($res, 0, 64);
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
