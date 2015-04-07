<?php
namespace frontend\models\db\dao;

use frontend\models\db\record\Collection;
use frontend\models\db\record\CollectionChild;
use frontend\models\db\record\CollectionChildItem;
use frontend\web\custexp\CollectionAlreadyContainsCollectionException;
use frontend\web\custexp\CollectionAlreadyContainsItemException;
use frontend\web\custexp\CollectionDoesntContainItemException;
use Yii;

class CollectionUtil {
    
    /* @var $db \yii\db\Connection */
    private $db;
    
    public function __construct() {
        $this->setDb(Yii::$app->db);
    }
    
    public function setDb($db) {
        $this->db = $db;
    }
    
    
    
    /////////////////////////////////// GET METHODS
    
    public function getAllCollections() {
        $command = $this->db->createCommand("SELECT * FROM" . " " . Collection::tableName());
        $allCollections = $command->queryAll();
        return $allCollections;
    }

    public function getChildCollections($parentId) {
        $command = $this->db->createCommand("SELECT * FROM" . " " . CollectionDao::tableName() .
                                      " WHERE id IN (" .
                                        " SELECT child_id FROM " . CollectionChildDao::tableName() .
                                        " WHERE parent_id = :parentId )");

        return $command->bindValue(":parentId", $parentId)->queryAll();
    }

    public function getChildItems($parentId) {
        $command = $this->db->createCommand("SELECT * FROM" . " " . ItemTypeDao::tableName() .
                                      " WHERE id IN (" .
                                        " SELECT item_id FROM " . CollectionChildItemDao::tableName() .
                                        " WHERE parent_id = :parentId )");

        return $command->bindValue(":parentId", $parentId)->queryAll();
    }

    
    
    /////////////////////// UPDATE METHODS

    public function addChildCollectionToParent($collectionId, $parentId) {
        if (!CollectionChildDao::isCollectionAncestorOfCollection($collectionId, $parentId)) {
            return (CollectionChild::addChildCollection($collectionId, $parentId));
        }
        else {
            throw new CollectionAlreadyContainsCollectionException("Collection " .
                $parentId . " already contains collection " . $collectionId);
        }
    }

    public function addChildItemToParent($itemId, $parentId) {
        if (!$this->isItemChildOfParent($itemId, $parentId)) {
            return (CollectionChildItem::addChildItem($itemId, $parentId) == 1);
        }
        else {
            throw new CollectionAlreadyContainsItemException("Collection " .
                $parentId . " already contains item " . $itemId);
        }
    }

    public function removeChildCollectionFromParent($collectionId, $parentId) {
        if (CollectionChildDao::isCollectionAncestorOfCollection($collectionId, $parentId)) {
            return (CollectionChild::removeChildCollection($collectionId, $parentId));
        }
        else {
            throw new CollectionAlreadyContainsCollectionException("Collection " .
                $parentId . " doesn't contain collection " . $collectionId);
        }
    }

    public function removeChildItemFromParent($itemId, $parentId) {
        if ($this->isItemChildOfParent($itemId, $parentId)) {
            return (CollectionChildItem::removeChildItem($itemId, $parentId) == 1);
        }
        else {
            throw new CollectionDoesntContainItemException("Collection " .
                $parentId . " doesn't contain item " . $itemId);
        }
    }
    
    
    

    private function isItemChildOfParent($itemId, $parentId) {
        $command = $this->db->createCommand("SELECT 1 FROM" . " " .
            CollectionChildItemDao::tableName() .
            " WHERE parent_id = :parentId AND item_id = :itemId");

        $result = $command->bindValues([":parentId" => $parentId,
            ":itemId" => $itemId])->queryOne();
        return ($result != false);
    }

    /*private function isCollectionAncestorOfCollection(
        $collectionId, $potentialAncestorId) {

        return in_array($potentialAncestorId, CollectionChildDao::getParents($collectionId));
    }*/

}