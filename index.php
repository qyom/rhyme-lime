<?php
defined('PUBLIC_DIR') or define('PUBLIC_DIR', dirname(__FILE__));

require_once(/*PUBLIC_DIR.*/"./lib/Get_Rhymebrain.php");
require_once (/*PUBLIC_DIR.*/"./lib/Word_Table.php");

$rhyme = new Get_Rhymebrain();
$words = new Word_Table();
$arr_res =  $words->getWord(0,500);
$ofset = 0;
$errors = 0;
foreach($arr_res as $word)
{
    $responce = $rhyme->getRhymes($word);
    if(startsWith($responce)){
        $words->insertRhyme($word,$responce);
        $ofset++;
        echo $ofset  . substr($responce, 0, 20) ."\r\n";
    } else {
        echo "error " . ++$errors . substr($responce, 0, 20) . "\r\n";
//        echo $responce; exit;
        sleep(1);
        continue;
    }

}

function startsWith($haystack, $needle = "[")
{
    return !strncmp($haystack, $needle, strlen($needle));
}
?>