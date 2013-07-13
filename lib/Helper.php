<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Sargis
 * Date: 7/13/13
 * Time: 10:09 PM
 * To change this template use File | Settings | File Templates.
 */
class Helper
{
    public static function  setOffset($offset){
        file_put_contents("./lib/offset", $offset) . "\r\n";
    }
    public static function  getOffset(){
        return intval(file_get_contents("./lib/offset"));
    }
    public static function startsWith($haystack, $needle = "[")
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }

}
