<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class Sport extends ActiveRecord {

    public static function tableName() {
        return "sport";
    }

}