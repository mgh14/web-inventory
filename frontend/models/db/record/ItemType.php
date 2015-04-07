<?php
namespace frontend\models\db\record;

use frontend\models\db\dao\ItemTypeDao;
use yii\db\ActiveRecord;

class ItemType extends ActiveRecord {

    public static function tableName() {
        return ItemTypeDao::tableName();
    }

}