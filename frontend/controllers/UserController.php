<?php
namespace frontend\controllers;

use frontend\models\db\dao\DatabaseConnectionUtil;
use frontend\models\db\dao\UserDao;
use frontend\models\db\record\ProfileImage;
use frontend\models\db\record\UserType;
use frontend\models\ItemRequestUtil;
use Yii;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\web\Response;

class UserController extends Controller {

    /* @var ItemRequestUtil $itemRequestUtil */
    private $itemRequestUtil;
    /* @var PaginationHelper $paginationHelper */
    private $paginationHelper;

    public function init() {
        $this->itemRequestUtil = new ItemRequestUtil();
        $this->paginationHelper = new PaginationHelper();
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
        $offsetParam = intval(\Yii::$app->getRequest()->getQueryParam("offset"));
        $limit = 20;

        // get count of total rows
        $db = Yii::$app->db;
        $countCommand = $db->createCommand("SELECT COUNT(*) FROM user WHERE username LIKE '%" .
            $queryParam . "%'");
        $result = $countCommand->queryAll();
        $count = intval($result[0]['COUNT(*)']);

        // get the rows that match the query param
        $command = $db->createCommand("SELECT * FROM user WHERE username LIKE '%" . $queryParam . "%' " .
            " LIMIT " . $limit . " OFFSET " . $offsetParam . ";");
        $users = $command->queryAll();

        // create userIds, profile image filenames, and user type arrays from data
        $userIds = array_map(function($i) {
            return $i['id'];
        }, $users);
        $images = ProfileImage::getByUserIds($userIds, true);
        $userTypes = UserType::getAllTypesWithIdAsKey();

        ob_start();
        ?>

        <div id='users-gridView'>
            <?php echo $this->generateUserSummariesGrid($users, $images, $userTypes)?>
        </div>
        <div id='users-listView'>
            <?php echo $this->generateUserSummariesList($offsetParam + 1, $users, $images, $userTypes)?>
        </div>
        <div id='paginate'>
            <?php echo $this->paginationHelper->getPaginationHtml("?r=user%2Fget-user-profiles&query=" .
                $queryParam . "&offset=::offset::", "::offset::", $offsetParam, $limit, $count)?>
        </div>

        <?php
        return trim(ob_get_clean());
    }

    private function generateUserSummariesList($counter, $users, $images, $userTypesById) {
        ob_start();
        ?>

        <style>
            #users-list-table td {
                border: 1px solid #DCDCDC;
            }
        </style>
        <div class="" id="users-list" style="display:inline-block;">
            <table id="users-list-table" class="table table-hover" style="table-layout:fixed;">
                <tr>
                    <td style="width: 6%;">
                        <p>Row</p>
                    </td>
                    <td>
                        <p>First Name</p>
                        <input style="width:75%"/>
                    </td>
                    <td>
                        <p>Last Name</p>
                        <input style="width:75%"/>
                    </td>
                    <td>
                        <p>Username</p>
                        <input style="width:75%"/>
                    </td>
                    <td style="width: 10%">
                        <p>User Type</p>
                    </td>
                    <td>
                        <p>Email</p>
                        <input style="width:75%"/>
                    </td>
                    <td>
                        <p>Tags</p>
                        <input style="width:75%"/>
                    </td>
                    <td>
                        <p>Action</p>
                    </td>
                </tr>

            <?php
            foreach ($users as $user) {
                $image = "football.png";
                if (isset($images[$user['id']])) {
                    $image = $images[$user['id']];
                }

                echo "<tr>";
                    echo $this->generateUserListSummaryHtml($user, $userTypesById[$user['user_type']], $image, $counter++);
                echo "</tr>";
            }
            ?>

            </table>
        </div>

        <?php
        return ob_get_clean();
    }

    private function generateUserListSummaryHtml($user, $userType, $profileFilename, $counter) {
        ob_start();
        ?>

        <td><?php echo $counter?></td>
        <td><?php echo $user['first_name']?></td>
        <td><?php echo $user['last_name']?></td>
        <td>
            <!--<img src="http://localhost/public_html/mr-test-two/frontend/images/profile/<?php /*echo $profileFilename*/?>"
                style="margin:auto; width:40%;"/>-->
            <b><?php echo $user['username']?></b>
        </td>
        <td>
            <i><?php echo $userType?></i>
        </td>
        <td>
            <?php echo $user['email']?>
        </td>
        <td>Football</td>
        <td>View profile</td>

        <?php
        return ob_get_clean();
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

    private function generateUserGridSummaryHtml($user, $userType, $profileFilename) {
        ob_start();
        ?>

        <div id="user<?php echo $user['id']?>" class="floatLeft" style="width: 13%; margin-top:3%; margin-right:7%; font-size: .9vw;">
            <img style="width: 100%; margin-left: auto; margin-right: auto;"
                 src="http://localhost/public_html/mr-test-two/frontend/images/profile/<?php echo $profileFilename?>" />
            <div style="clear:both;"></div>
            <p class="centerText" style="margin-top: 15%; margin-bottom: 0;">
                <a href="?r=profile%2Fview-profile&userId=<?php echo $user['id']?>">
                    <b><?php echo $user['username']?></b>
                </a>
            </p>
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