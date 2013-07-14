<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 7/14/13
 * Time: 3:50 AM
 * To change this template use File | Settings | File Templates.
 */

require_once("./abstract/Rhymer_Abstract.php");
require_once ("./lib/Word_Table.php");
require_once("./lib/Get_Rhymebrain.php");

class Rhyme extends Rhymer_Abstract {

    function rhyme()
    {
        $table = new Word_Table;
        $rhyme  = new Get_Rhymebrain();

        // check the cache
        $rhymeJson = $table->getRhyme("fuck");
        if(!($rhymeJson === null)){
            return $rhymeJson["json"];
        }

        // if absent, get from api
        return $rhyme->getRhymes("fuck");
    }
}