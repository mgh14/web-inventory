<?php
namespace frontend\models\db\record;

use frontend\models\db\dao\CollectionItemDao;
use yii\db\ActiveRecord;

class CollectionItem extends ActiveRecord {

    public static function tableName() {
        return CollectionItemDao::tableName();
    }

}