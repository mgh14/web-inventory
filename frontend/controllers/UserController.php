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
        $conn = DatabaseConnectionUtil::getMysqliDbConnection();
        $usernames = $this->getUsernames($conn, $queryParam);
        $conn->close();

        return $usernames;
    }

    /* @var mysqli $conn */
    private function getUsernames($conn, $queryParam) {
        // query with mysqli for better performance
        /* @var mysqli $conn */
        $sqlStatement = $conn->prepare("SELECT username FROM user WHERE username LIKE ?;");
        $queryParamWithPercents = "%" . $queryParam . "%";
        $sqlStatement->bind_param('s', $queryParamWithPercents);
        $sqlStatement->execute();
        $result = $sqlStatement->get_result();
        if ((!$result) || ($result->num_rows < 1)) {
            return array();
        }

        // store parentId's in an array
        $usernames = array();
        while ($row = $result->fetch_assoc()) {
            $username = $row["username"];
            if (!in_array($username, $usernames)) {
                $usernames[] = ["username" => $username];
            }
        }

        // free the result set
        $result->free();

        return $usernames;
    }

    public function actionDirectory() {
        return $this->render('user-directory');
    }

}