<?php
namespace frontend\models\db\dao;

use mysqli;
use Yii;

class CollectionChildDao {

    public static function tableName() {
        return "list_child";
    }
    
    public static function getDb() {
        return Yii::$app->db;
    }

    public static function isCollectionAncestorOfCollection($collectionId, $potentialAncestorId) {
        // query with mysqli for better performance
        /* @var mysqli $conn */
        $conn = DatabaseConnectionUtil::getMysqliDbConnection();

        $allAncestorsOfCollection = 
            CollectionChildDao::getAllParentsOfCollection($collectionId, $conn);

        $conn->close();
        return in_array($potentialAncestorId, $allAncestorsOfCollection);
    }

    /*    public static function isCollectionAParentOfByName($parentName, $childName) {
        if (empty($parentName) || empty($childName)) {
            // throw error?
        }

        $allParentIdsForCollection = CollectionChildDao::getParents(7);
        //return in_array(5, $finalParentIdsForList8);
        if (in_array(5, $allParentIdsForCollection)) {
            //echo "can't add L1 to L8";
        }
        else {
            //echo "CAN add L1 to L8";
        }
    }*/

    /* @param mysqli $conn
     * @param int $collectionId
     * @return array
     *
     * Note: this function queries with mysqli instead of Yii's build-int
     * database functionality for better performance
     */
    private static function getAllParentsOfCollection($collectionId, $conn) {
        $sql = "SELECT * FROM" . " " . CollectionChildDao::tableName() .
            " WHERE child_id = " . $conn->real_escape_string($collectionId) . ";";
        $result = $conn->query($sql);
        if ($conn->connect_error) {
            // log the error
            //echo $conn->connect_error; 
            return array();
        }
        if ((!$result) || ($result->num_rows < 1)) {
            return array();
        }

        // store parentId's in an array
        $parentIds = array();
        while ($row = $result->fetch_assoc()) {
            $parentId = $row["parent_id"];
            if (!in_array($parentId, $parentIds)) {
                $parentIds[] = $parentId;
            }
        }

        // free the result set
        $result->free();

        // merge arrays with results of other searches
        foreach ($parentIds as $parentId) {
            $parentIds = array_unique(array_merge($parentIds, 
                CollectionChildDao::getAllParentsOfCollection($parentId, $conn)));
        }

        return $parentIds;
    }

}
