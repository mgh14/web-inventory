<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class UserType extends ActiveRecord {

    public static function tableName() {
        return "user_type";
    }

    public static function getAllTypesWithIdAsKey() {
        $all = static::find()->all();
        $idKeyedTypes = array();
        foreach ($all as $type) {
            $idKeyedTypes[$type['id']] = $type['display_name'];
        }

        return $idKeyedTypes;
    }

}