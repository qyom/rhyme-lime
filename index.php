<?php
//defined('PUBLIC_DIR') or define('PUBLIC_DIR', dirname(__FILE__));
define('OFFSET_UPPER_BOUND', 30);

require_once(/*PUBLIC_DIR.*/"./lib/Get_Rhymebrain.php");
require_once (/*PUBLIC_DIR.*/"./lib/Word_Table.php");

$rhyme = new Get_Rhymebrain();
$words = new Word_Table();
$offset = file_get_contents("./lib/offset");
$errors = 0;

while($offset < OFFSET_UPPER_BOUND){
    $arr_res =  $words->getWord($offset,10);
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
        while(!startsWith($response)){
            echo "error " . "WORD : " . $word . " " . ++$errors . " " . substr($response, 0, 20) . "\r\n";
//        echo $response; exit;
            sleep(1);
            $response = $rhyme->getRhymes($word);
        }
        $words->insertRhyme($word,$response);
        echo $offset . " WORD : " . $word . substr($response, 0, 20) ."\r\n";
        incrementOffset();
    }
}


function incrementOffset(){
    global $offset;
    $offset = intval(file_get_contents("./lib/offset"));
//    echo "offset : before " . $offset . "\r\n";
    $offset = $offset + 1;
//    echo "offset : after " . $offset . "\r\n";
    file_put_contents("./lib/offset", $offset) . "\r\n";
    echo "offset written : " . file_get_contents("./lib/offset") . "\r\n";
}

function startsWith($haystack, $needle = "[")
{
    return !strncmp($haystack, $needle, strlen($needle));
}