<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class UserTag extends ActiveRecord {

    public static function tableName() {
        return "user_tag_child";
    }

}