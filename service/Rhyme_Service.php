<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 7/14/13
 * Time: 3:46 AM
 * To change this template use File | Settings | File Templates.
 */

require_once("./module/Rhyme.php");

class Rhyme_Service {

    public static function getRhyme(){
        return new Rhyme;
    }
}