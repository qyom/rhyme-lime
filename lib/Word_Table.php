<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 7/12/13
 * Time: 3:03 PM
 * To change this template use File | Settings | File Templates.
 */


/**
 * TODO
 * this class needs to be refactored
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

    public function getWords($offset , $limit = null){

        $query = "SELECT id,word FROM  `rhymes` LIMIT " . $offset . " , " . (($limit == null) ? self::GET_WORD_LIMIT : $limit);

        $response = mysqli_query(self::$connection ,$query) or die (mysqli_error(self::$connection));

        $result = array();
        while ($row = $response->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }

    public function insertRhyme($word,$str_json){
        $sql = sprintf(
            "INSERT INTO synonyms (word_id,json) VALUES ('%s','%s')",
            mysql_real_escape_string($word),
            mysql_real_escape_string($str_json)
        );
        $response = mysqli_query(self::$connection ,$sql) or die (mysqli_error(self::$connection));
    }

    public function insertSynonym($word_id,$str_json){
        $sql = sprintf(
            "INSERT INTO synonyms (word_id,json) VALUES ('%s','%s')",
            mysql_real_escape_string($word_id),
            mysql_real_escape_string($str_json)
        );
        $response = mysqli_query(self::$connection ,$sql) or die (mysqli_error(self::$connection));
    }

    /**
     * gets the appropriate rhyme to the word
     * @param $word
     * @return array
     */
    public function getRhyme($word){
        $query = sprintf(
            "SELECT json FROM rhymes WHERE word = '%s'",
            mysql_real_escape_string($word)
        );

        $response = mysqli_query(self::$connection ,$query) or die (mysqli_error(self::$connection));
        return $response->fetch_assoc();
    }

    /**
     * gets the appropriate Synonym to the word
     * @param $word
     * @return array
     */
    public function getSynonym($word){
        $query = sprintf(
            "SELECT json FROM rhymes WHERE word = '%s'",
            mysql_real_escape_string($word)
        );

        $response = mysqli_query(self::$connection ,$query) or die (mysqli_error(self::$connection));
        return $response->fetch_assoc();
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

    public function getAll()
    {
        $query = "SELECT word FROM rhymes WHERE 1";

        $response = mysqli_query(self::$connection ,$query) or die (mysqli_error(self::$connection));

        $result = array();
        while ($row = $response->fetch_assoc()) {
            $result[] = $row;
        }
        return $result;
    }

    public function insertRow($word)
    {
        $word = mysql_real_escape_string(trim($word));
        $query = "SELECT R.word, R.json rhyme, S.json synonym FROM `rhymes` R LEFT JOIN `synonyms` S ON R.id = S.word_id WHERE R.word = '" . $word . "'";

        $response = mysqli_query(self::$connection ,$query) or die ("In SELECT : " . mysqli_error(self::$connection));
        $response = $response->fetch_assoc();

        $query = sprintf(
            "INSERT INTO `word`(`word`, `rhyme`, `synonym`) VALUES ('%s', '%s', '%s')",
            mysql_real_escape_string(trim($response['word'])),
            mysql_real_escape_string(trim($response['rhyme'])),
            mysql_real_escape_string(trim($response['synonym'])));
        mysqli_query(self::$connection ,$query) or die ("In Insert : " . mysqli_error(self::$connection));
    }
}