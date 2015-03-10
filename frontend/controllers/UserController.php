<?php
namespace frontend\controllers;

use common\models\User;
use DateTime;
use frontend\models\db\dao\UserDao;
use frontend\models\db\record\ItemRequest;
use frontend\models\db\record\ItemRequestComment;
use frontend\models\ItemRequestUtil;
use mysqli;
use Yii;
use yii\base\Controller;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
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

/*    public function actionGetUsers() {
        $db = \Yii::$app->db;
        $queryParam = \Yii::$app->getRequest()->getQueryParam("query");

        $query = $db->createCommand("SELECT username FROM user " .
            " WHERE username LIKE :query;");
        $results = $query->bindValue(":query", "%" . $queryParam . "%")->queryAll();

        \Yii::$app->response->format = 'json';
        return $results;
    }*/

    public function actionGetUsers() {
        $db = Yii::$app->db;
        \Yii::$app->response->format = 'json';
        $queryParam = \Yii::$app->getRequest()->getQueryParam("query");

        // query with mysqli for better performance
        $dbName = substr($db->dsn, strpos($db->dsn, "dbname") + 7);
        $conn = new mysqli("localhost", $db->username, $db->password, $dbName);
        // Check connection
        if ($conn->connect_error) {
            //die("Connection failed: " . $conn->connect_error);
            // ERRRRRRRRRRRRRRRRRRORRRRRRRRRRR!
        }

        $sql = "SELECT username FROM user WHERE username LIKE '%" .
            $conn->real_escape_string($queryParam) .  "%';";
        $result = $conn->query($sql);
        if ($conn->connect_error) {
            // log the error
            //echo $conn->connect_error;
            return array();
        }
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