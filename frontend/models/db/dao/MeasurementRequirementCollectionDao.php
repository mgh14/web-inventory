<?php
namespace frontend\models\db\dao;

use Yii;

class MeasurementRequirementCollectionDao {

    public static function tableName() {
        return "measurement_requirement_collection";
    }

    /*public static function getAllRequirementTypesBySport($sportId) {
        $command = static::getDb()->createCommand("SELECT * FROM" . " " . static::tableName() .
            " WHERE sport_id = :sportId");
        return $command->bindValue(":sportId", $sportId)->queryAll();
    }

    private static function getDb() {
        return Yii::$app->db;
    }*/

}
