<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class Measurement extends ActiveRecord {

    public static function tableName() {
        return "measurement";
    }

}