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
require_once("./lib/Get_Synonyms.php");
require_once("./lib/Helper.php");

class Rhymer extends Rhymer_Abstract {

    function rhyme($word)
    {
        $table = new Word_Table;
        $rhyme = new Get_Rhymebrain();
        $synonym = new Get_Synonyms();


        // check the cache
        $rhymeJson = $table->getWordInfo($word);
        if(!($rhymeJson === null)){
            return json_encode(array_merge(array("success" => true), $rhymeJson));
        }

        // if absent, get from api
        $info = array();
        $info["success"] = true;
        $info["rhyme"] = $rhyme->getRhymes($word);

        // while the answer is error , keep requesting
        while(!Helper::startsWith($info["rhyme"])){
            $info["rhyme"] = $rhyme->getRhymes($word);
        }

        $info["synonym"] = $synonym->getSynonyms($word);
        $table->setWordInfo(array_merge(array("word" => $word), $info));

        return json_encode($info);
    }
}