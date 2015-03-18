<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class Sports extends ActiveRecord {

    public static function tableName() {
        return "sports";
    }

}