<?php
namespace frontend\models\db\dao;

use mysqli;
use Yii;

class DatabaseConnectionUtil {

    public static function getMysqliDbConnection() {
        $db = Yii::$app->db;

        $dbName = substr($db->dsn, strpos($db->dsn, "dbname") + 7);
        $conn = new mysqli("localhost", $db->username, $db->password, $dbName);
        // Check connection
        if ($conn->connect_error) {
            //die("Connection failed: " . $conn->connect_error);
            // ERRRRRRRRRRRRRRRRRRORRRRRRRRRRR!
            // TODO: SHOULD throw an exception
            return null;
        }

        // REMEMBER TO CLOSE THIS CONNECTION!
        return $conn;
    }

}