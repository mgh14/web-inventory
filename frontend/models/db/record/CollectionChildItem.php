<?php
namespace frontend\models\db\record;

use frontend\models\db\dao\CollectionChildItemDao;
use yii\db\ActiveRecord;

class CollectionChildItem extends ActiveRecord {

    public static function tableName() {
        return CollectionChildItemDao::getTableName();
    }

    public static function addChildItem($itemId, $parentId) {
        $newChildItem = new CollectionChildItem();
        $newChildItem->parent_id = $parentId;
        $newChildItem->item_id = $itemId;
        return $newChildItem->save();
    }

    public static function removeChildItem($itemId, $parentId) {
        $newChildItem = CollectionChildItem::findOne($itemId, $parentId);
        $newChildItem->parent_id = $parentId;
        $newChildItem->item_id = $itemId;
        return $newChildItem->delete();
    }

}