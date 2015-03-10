<?php
namespace frontend\models;

use common\models\User;
use frontend\models\db\record\ProfileImage;

class ProfileUtil {

    public function getUserAndProfileImg($userId) {
        $userAndProfile = array('user' => null, 'profileImg' => null);

        $user = User::findOne(['id' => $userId]);
        if (!empty($user)) {
            $userAndProfile['user'] = $user;
        }

        $profile = ProfileImage::findOne(['user_id' => $userId]);
        if (!empty($profile)) {
            $userAndProfile['profileImg'] = $profile['filename'];
        }

        return $userAndProfile;
    }

    public function getProfileImageHtml($userId, $classes, $id, $sizeX, $sizeY) {
        $userAndProfile = $this->getUserAndProfileImg($userId);
        /* @var User $user */
        $user = $userAndProfile['user'];
        /* @var $profileImgFilename String */
        $profileImgFilename = $userAndProfile['profileImg'];

        ob_start();
        ?>
        <img class="profileImg <?php echo $classes?> " id="<?php echo $id?>"
             src="http://localhost/public_html/mr-test-two/frontend/images/profile/<?php echo $profileImgFilename?>"
             alt="<?php echo ucfirst($user->username)?>ProfileImg?>"
             style=" width:<?php echo $sizeX?>; height:<?php echo $sizeY?>; "/>
        <?php
        return ob_get_clean();
    }

}