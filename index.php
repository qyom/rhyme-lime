<?php
defined('PUBLIC_DIR') or define('PUBLIC_DIR', dirname(__FILE__));

require_once(PUBLIC_DIR."/lib/Get_Rhymebrain.php");
require_once (PUBLIC_DIR."/lib/Word_Table.php");

$rhyme = new Get_Rhymebrain();
$words = new Word_Table();
$arr_res =  $words->getWord(0,500);
$ofset = 0;
foreach($arr_res as $word)
{
    $words->insertRhyme($word,$rhyme->getRhymes($word));
    $ofset++;
    echo $ofset."<br>";
}
?>