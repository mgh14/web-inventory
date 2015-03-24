<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class MeasurementRequirement extends ActiveRecord {

    public static function tableName() {
        return "measurement_requirement";
    }

}