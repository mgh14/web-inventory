<?php
namespace frontend\controllers;

use common\models\User;
use frontend\models\db\dao\CollectionChildDao;
use frontend\models\db\record\Collection;
use frontend\models\db\dao\CollectionUtil;
use frontend\models\db\record\ProfileImage;
use frontend\models\db\record\UserType;
use frontend\models\ProfileUtil;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Collection controller
 */
class ProfileController extends Controller {

    const DEFAULT_PROFILE_IMAGE_FILENAME = "basket-ball.gif";

    /* @var $profileUtil ProfileUtil */
    private $profileUtil;

    public function init() {
        $this->profileUtil = new ProfileUtil();
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

    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

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

    public function actionViewProfile() {
        $userId = intval(\Yii::$app->request->getQueryParam('userId'));

        $user = User::findOne(['id' => $userId]);
        if (empty($user)) {
            throw new \yii\web\NotFoundHttpException("Nonexisting profile ID");
        }

        $userType = UserType::findOne(['id' => $user['user_type']]);

        $imgFilename = static::DEFAULT_PROFILE_IMAGE_FILENAME;
        $imgRow = ProfileImage::findOne(['user_id' => $userId]);
        if (!empty($imgRow)) {
            $imgFilename = $imgRow->filename;
        }

        return $this->render('profile', ['user' => $user,
            'accountType' => $userType->name,
            'profileImgHtml' => $this->profileUtil->getProfileImageHtml($userId,
                "", "", "14em", "14em")]);
    }

}
