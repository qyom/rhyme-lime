<?php
define('OFFSET_UPPER_BOUND', 2);

require_once("./lib/Helper.php");
require_once("./lib/Curl.php");
require_once("./lib/Get_Rhymebrain.php");
require_once ("./lib/Word_Table.php");

$words  = new Word_Table();

$arr_res =  $words->getAll();
handleWords($arr_res);

function handleWords($arr_res){
    global $words;
    foreach($arr_res as $word)
    {
        $words->insertRow($word["word"]);
    }
}

