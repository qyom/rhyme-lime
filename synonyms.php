<?php

define('OFFSET_UPPER_BOUND', 2);

require_once("./lib/Curl.php");
require_once("./lib/Helper.php");
require_once("./lib/Get_Synonyms.php");
require_once ("./lib/Word_Table.php");

$synonym    = new Get_Synonyms();
$words      = new Word_Table();
$offset     = Helper::getOffset();
while($offset < OFFSET_UPPER_BOUND){
    $arr_res =  $words->getWords($offset,2);
    foreach($arr_res as $word){
        $response = $synonym->getSynonyms($word["word"]);
        $words->insertSynonym($word["id"],$response);
        Helper::setOffset($offset++);
        echo $offset . " WORD : " . $word["word"] . substr($response, 0, 20) ."\r\n";
    }
 }
