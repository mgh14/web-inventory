<?php
namespace frontend\models\db\record;

use frontend\models\db\dao\CollectionDao;
use frontend\models\db\record\MyBehavior;
use yii\db\ActiveRecord;

/**
 * User model
 *
 * @property integer $id
 */
class Collection extends ActiveRecord {

    public static function tableName() {
        return CollectionDao::tableName();
    }

}

?>