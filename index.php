<?php
define('OFFSET_UPPER_BOUND', 2);

require_once("./lib/Helper.php");
require_once("./lib/Curl.php");
require_once("./lib/Get_Rhymebrain.php");
require_once ("./lib/Word_Table.php");

$rhyme  = new Get_Rhymebrain();
$words  = new Word_Table();
$offset = Helper::getOffset();
$errors = 0;

while($offset < OFFSET_UPPER_BOUND){
    $arr_res =  $words->getWord(0,2);
    handleWords($arr_res);
    echo "while($offset < OFFSET_UPPER_BOUND) " . $offset . "\r\n";
}

function handleWords($arr_res){
    global $rhyme;
    global $words;
    global $offset;
    global $errors;

    foreach($arr_res as $word)
    {
        $response = $rhyme->getRhymes($word);

        // while the response is an error, keep sending the request with the same word
        while(!Helper::startsWith($response)){
            echo "error " . "WORD : " . $word . " " . ++$errors . " " . substr($response, 0, 20) . "\r\n";
            sleep(1);
            $response = $rhyme->getRhymes($word);
        }
        $words->insertRhyme($word,$response);
        echo $offset . " WORD : " . $word . substr($response, 0, 20) ."\r\n";
        Helper::setOffset($offset++);
    }
}

