<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class ProfileImage extends ActiveRecord {

    public static function tableName() {
        return "profile_image";
    }

}