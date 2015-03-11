<?php
namespace frontend\models\db\dao;

use Yii;

class UserDao {

    public static function getTableName() {
        return "user";
    }

    public static function getUsersByUsername($username) {
        $conn = DatabaseConnectionUtil::getMysqliDbConnection();

        $sqlStatement = $conn->prepare("SELECT * FROM" . " " .
            static::getTableName() . " WHERE username LIKE ?;");
        $likeUsernameParam = "%" . $username . "%";
        $sqlStatement->bind_param("s", $likeUsernameParam);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        if ((!$result) || ($result->num_rows < 1)) {
            return array();
        }

        $users = array();
        while ($row = $result->fetch_assoc()) {
            if (!in_array($row, $users)) {
                $users[] = $row;
            }
        }

        return $users;
    }

}