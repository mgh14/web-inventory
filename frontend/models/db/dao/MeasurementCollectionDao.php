<?php
namespace frontend\models\db\dao;

use Yii;

class MeasurementCollectionDao {

    public static function tableName() {
        return "measurement_collection";
    }

    public static function insert($sportId, $measurementId) {
        $command = static::getDb()->createCommand("INSERT INTO" . " " . static::tableName() .
            " (sport_id, measurement_id) VALUES " .
            "(:sportId, :measurementRequirementId);");
        return ($command->bindValues([":sportId" => $sportId,
            ":measurementRequirementId" => $measurementId])->execute() == 1);
    }

    private static function getDb() {
        return Yii::$app->db;
    }

}
