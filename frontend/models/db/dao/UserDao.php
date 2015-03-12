<?php
namespace frontend\models\db\dao;

use mysqli;
use Yii;

class UserDao {

    public static function getTableName() {
        return "user";
    }

    public static function getUsersByIds($userIds, $useIdAsKey = false) {
        $query = (new \yii\db\Query())->select(array())->
            from(static::getTableName())->where(array('in', 'id', $userIds));
        $command = $query->createCommand();
        $results = $command->queryAll();

        if ((!$results) || ($results->num_rows < 1)) {
            return array();
        }

        $users = array();
        while ($row = $results->fetch_assoc()) {
            if (!in_array($row, $users)) {
                if ($useIdAsKey) {
                    $users[$row['id']] = $row;
                }
                else {
                    $users[] = $row;
                }
            }
        }
    }

    /* @var mysqli $conn */
    public static function getUsernamesByUsername($conn, $username, $limit = 0) {
        if (!is_int($limit)) {
            $limit = 0;
        }

        // query with mysqli for better performance
        $sql = "SELECT username FROM" . " " . static::getTableName() .
            " WHERE username LIKE ?";
        if ($limit > 0) {
            $sql .= " LIMIT ?";
        }

        // prepare statement
        $sqlStatement = $conn->prepare($sql);
        $queryParamWithPercents = $username . "%";
        if ($limit > 0) {
            $sqlStatement->bind_param('si', $queryParamWithPercents, $limit);
        }
        else {
            $sqlStatement->bind_param('s', $queryParamWithPercents);
        }
        $sqlStatement->execute();

        // process results
        $result = $sqlStatement->get_result();
        if ((!$result) || ($result->num_rows < 1)) {
            return array();
        }

        // store usernames in an array
        $usernames = array();
        while ($row = $result->fetch_assoc()) {
            $username = $row["username"];
            if (!in_array($username, $usernames)) {
                $usernames[] = ["username" => $username];
            }
        }

        // free the result set
        $result->free();

        return $usernames;
    }

    public static function getUsersByUsername($username, $limit = 0) {
        if (!is_int($limit)) {
            $limit = 0;
        }

        $conn = DatabaseConnectionUtil::getMysqliDbConnection();
        $sql = "SELECT * FROM" . " " . static::getTableName() .
            " WHERE username LIKE ?";
        if ($limit > 0) {
            $sql .= " LIMIT ?";
        }

        $sqlStatement = $conn->prepare($sql);
        $likeUsernameParam = $username . "%";
        if ($limit > 0) {
            $sqlStatement->bind_param("si", $likeUsernameParam, $limit);
        }
        else {
            $sqlStatement->bind_param("s", $likeUsernameParam);
        }
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

        $conn->close();

        return $users;
    }

}