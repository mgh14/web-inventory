<?php
namespace frontend\controllers;

use frontend\models\db\dao\DatabaseConnectionUtil;
use frontend\models\db\dao\UserDao;
use frontend\models\db\record\ProfileImage;
use frontend\models\db\record\UserType;
use frontend\models\ItemRequestUtil;
use mysqli;
use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class UserController extends Controller {

    /* @var ItemRequestUtil $itemRequestUtil*/
    private $itemRequestUtil;

    public function init() {
        $this->itemRequestUtil = new ItemRequestUtil();
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],   // allow access to all functions if logged in
                    ],
                    /*[
                        'action' => ['AdministerItemRequest'],
                        'allow' => true,
                        'roles' =>
                    ]*/
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionGetUsernames() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $queryParam = \Yii::$app->getRequest()->getQueryParam("query");
        $limitParam = intval(\Yii::$app->getRequest()->getQueryParam("limit"));

        $conn = DatabaseConnectionUtil::getMysqliDbConnection();
        $usernames = UserDao::getUsernamesByUsername($conn, $queryParam, $limitParam);
        $conn->close();

        return $usernames;
    }

    public function actionDirectory() {
        return $this->render('user-directory');
    }

    public function actionGetRandomUserProfiles() {
        //$users = UserDao::getUsers
    }

    public function actionGetUserProfiles() {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $queryParam = \Yii::$app->getRequest()->getQueryParam("query");
        $users = UserDao::getUsersByUsername($queryParam, 0);

        $userIds = array_map(function($i) {
            return $i['id'];
        }, $users);
        $images = ProfileImage::getByUserIds($userIds, true);
        $userTypes = UserType::getAllTypesWithIdAsKey();

        return "<div id='users-gridView'>" .
                $this->generateUserSummariesGrid($users, $images, $userTypes) . "</div>" .
            "<div id='users-listView'>" .
                $this->generateUserSummariesList($users, $images, $userTypes) . "</div>";
    }

    private function generateUserSummariesList($users, $images, $userTypesById) {
        ob_start();
        ?>

        <div id="users-list">
            <?php
            foreach ($users as $user) {
                $image = "football.png";
                if (isset($images[$user['id']])) {
                    $image = $images[$user['id']];
                }

                echo $this->generateUserListSummaryHtml($user, $userTypesById[$user['user_type']], $image);
            }
            ?>
        </div>

        <?php
        return ob_get_clean();
    }

    private function generateUserListSummaryHtml($user, $userType, $profileFilename) {
        return "username: " . $user['username'];
    }

    private function generateUserSummariesGrid($users, $images, $userTypesById) {
        ob_start();
        ?>

        <div id="users-grid">
            <?php
            foreach ($users as $user) {
                $image = "football.png";
                if (isset($images[$user['id']])) {
                    $image = $images[$user['id']];
                }

                echo $this->generateUserGridSummaryHtml($user, $userTypesById[$user['user_type']], $image);
            }
            ?>
        </div>

        <?php
        return ob_get_clean();
    }

    /*private function generateUserSummaryHtml($user, $userType, $profileFilename) {
        return "User: Id:" . $user['id'] . "; Username: " . $user['username'] . "; Type: " .
        $userType['name'] . "; image: " . $profileFilename . ";";
    }*/

    private function generateUserGridSummaryHtml($user, $userType, $profileFilename) {
        ob_start();
        ?>

        <div id="user<?php echo $user['id']?>" class="floatLeft" style="width: 13%; margin-top:3%; margin-right:7%; font-size: .9vw;">
            <img style="width: 100%; margin-left: auto; margin-right: auto;"
                 src="http://localhost/public_html/mr-test-two/frontend/images/profile/<?php echo $profileFilename?>" />
            <div style="clear:both;"></div>
            <p class="centerText" style="margin-top: 15%; margin-bottom: 0;"><b><?php echo $user['username']?></b></p>
            <div style="clear:both;"></div>
            <p class="centerText"  style="margin-top: 0; margin-bottom: 0;"><i><?php echo $userType?></i></p>
            <div style="clear:both;"></div>
            <p class="centerText"  style="margin-top: 0; margin-bottom: 0;"><?php echo $user['email']?></p>
            <div style="clear:both;"></div>
        </div>

        <?php
        return ob_get_clean();
    }

}