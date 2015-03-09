<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class ItemRequest extends ActiveRecord {

    public static function tableName() {
        return "item_request";
    }

}