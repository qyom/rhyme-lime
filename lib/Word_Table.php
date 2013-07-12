<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 7/12/13
 * Time: 3:03 PM
 * To change this template use File | Settings | File Templates.
 */

class Word_Table {

    const GET_WORD_LIMIT = "20";
    static $connection = null;

    function __construct()
    {
        $this->init();
    }

    /**
     * gets the word upon request
     * @param $offset
     * @param null $limit
     * @return array
     */
    public function getWord($offset , $limit = null){

        $query = "SELECT word FROM  `word_list` LIMIT " . $offset . " , " . (($limit == null) ? self::GET_WORD_LIMIT : $limit);

        $response = mysqli_query(self::$connection ,$query) or die (mysqli_error(self::$connection));

        $result = array();
        while ($row = $response->fetch_assoc()) {
            $result[] = $row['word'];
        }
        return $result;
    }
    public function insertRhyme($word,$str_json){
        $sql = sprintf(
            "INSERT INTO rhymes (word,json) VALUES ('%s','%s')",
            mysql_real_escape_string($word),
            mysql_real_escape_string($str_json)
        );
        $response = mysqli_query(self::$connection ,$sql) or die (mysqli_error(self::$connection));
    }

    /**
     * init the connection
     */
    private function init(){
        $config = $this->getConfigFile(/*PUBLIC_DIR.*/'./lib/database.json');

        // Create connection
        $connection = mysqli_connect($config["host"],$config["username"],$config["password"],$config["dbname"]);
        self::$connection = $connection;
    }

    public static function getConfigFile($file)
    {
        $data = str_replace("\\", "\\\\", file_get_contents($file));
        $json = json_decode($data, TRUE);

        return $json;
    }

}