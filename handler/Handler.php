<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 7/14/13
 * Time: 3:30 AM
 * To change this template use File | Settings | File Templates.
 */

require_once("./service/Rhyme_Service.php");

class Handler {

    public function serve(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            $rhyme = Rhyme_Service::getRhyme();
            // some check here
            // and
            $word = "";
            if(isset($_GET["word"])){
                $word = $_GET["word"];
            }
            $response = $rhyme->rhyme($word);
            echo $response; exit;
//            var_dump($response);
        }
    }
}