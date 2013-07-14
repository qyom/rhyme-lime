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

class Rhyme extends Rhymer_Abstract {

    function rhyme($word)
    {

//        $word = "stuck";

        $table = new Word_Table;
        $rhyme = new Get_Rhymebrain();
        $synonym = new Get_Synonyms();


        // check the cache
        $rhymeJson = $table->getWordInfo($word);
        if(!($rhymeJson === null)){
            return $rhymeJson;
        }

        // if absent, get from api
        $info = array();
        $info["word"] = $word;
        $info["rhyme"] = $rhyme->getRhymes($word);

        // while the answer is error , keep requesting
        while(!Helper::startsWith($info["rhyme"])){
            $info["rhyme"] = $rhyme->getRhymes($word);
        }

        $info["synonym"] = $synonym->getSynonyms($word);
        $table->setWordInfo($info);
        return $info;
    }
}