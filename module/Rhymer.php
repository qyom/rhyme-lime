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
            $rhymeJson["rhyme"] = $this->handleRhymes($rhymeJson["rhyme"]);
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

        $rhymeJson["rhyme"] = $this->handleRhymes($rhymeJson["rhyme"]);
        return json_encode($info);
    }

    function handleRhymes($rhymes){
        $rhymes = json_decode($rhymes);
        $result = array("green" =>array(), "blue" =>array(), "orange" =>array(), "red" =>array(), "gray" =>array());
        foreach($rhymes as $rhyme){
            if ($rhyme->score < 150){
                $result["gray"][] = $rhyme->word;
            } else if($rhyme->score < 200){
                $result["red"][] = $rhyme->word;
            } else if($rhyme->score < 250){
                $result["orange"][] = $rhyme->word;
            } else if($rhyme->score < 300){
                $result["blue"][] = $rhyme->word;
            } else {
                $result["green"][] = $rhyme->word;
            }
        }
        return $result;
    }
}