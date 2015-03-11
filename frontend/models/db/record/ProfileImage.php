<?php
namespace frontend\models\db\record;

use yii\db\ActiveRecord;

class ProfileImage extends ActiveRecord {

    public static function tableName() {
        return "profile_image";
    }

    public static function getByUserIds($userIds, $useIdAsKey = false) {
        $query = (new \yii\db\Query())->select(['id', 'filename'])->
            from(static::tableName())->where(array('in', 'user_id', $userIds));
        $command = $query->createCommand();
        $data = $command->queryAll();

        $images = array();
        foreach($data as $result) {
            if ($useIdAsKey) {
                $images[$result['id']] = $result['filename'];
            }
            else {
                $images[] = $result['filename'];
            }
        }

        return $images;
    }

}