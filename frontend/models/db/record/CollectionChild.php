<?php
namespace frontend\models\db\record;

use frontend\models\db\dao\CollectionChildDao;
use yii\db\ActiveRecord;

class CollectionChild extends ActiveRecord {

    public static function tableName() {
        return CollectionChildDao::getTableName();
    }

    public static function addChildCollection($collectionId, $parentId) {
        $newCollectionChild = new CollectionChild();
        $newCollectionChild->parent_id = $parentId;
        $newCollectionChild->child_id = $collectionId;
        return $newCollectionChild->save();
    }

    public static function removeChildCollection($collectionId, $parentId) {
        $parentCollection = CollectionChild::findOne($parentId, $collectionId);
        return $parentCollection->delete();
    }

}