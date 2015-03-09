<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class UserType extends ActiveRecord {

    public static function tableName() {
        return "user_type";
    }
}