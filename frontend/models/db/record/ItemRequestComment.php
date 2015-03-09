<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class ItemRequestComment extends ActiveRecord {

    public static function tableName() {
        return "item_request_comment";
    }
    
    public static function getAllByRequestId($requestId) {
        $db = \Yii::$app->db;
        $command = $db->createCommand("SELECT * FROM" . " " . 
            ItemRequestComment::tableName() . " WHERE item_request_id = :id");
        return $command->bindValue(':id', $requestId)->queryAll();
    }

}