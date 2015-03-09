<?php
namespace frontend\controllers;

use common\models\User;
use DateTime;
use frontend\models\db\record\ItemRequest;
use frontend\models\db\record\ItemRequestComment;
use frontend\models\ItemRequestCommentForm;
use frontend\models\ItemRequestUtil;
use yii\base\Controller;
use yii\base\Response;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class ItemRequestController extends Controller {

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

    public function actionViewItemRequest() {
        $itemRequestId = intval(\Yii::$app->request->getQueryParam('itemRequestId'));
        if (empty($itemRequestId)) {
            ////////////////////////////////////////////////////////////////////
            return $this->renderContent("The item requestid sucks");
        }

        /* @var $itemRequest ItemRequest */
        $itemRequest = ItemRequest::findOne(['id' => $itemRequestId]);
        
        // if this query returns empty, an error should be thrown since every
        // request must be associated with a user
        $requester = User::findOne(['id' => $itemRequest['requester_id']]);
        
        $commentsResults = ItemRequestComment::findAll(['item_request_id' => $itemRequestId]);
        $comments = ($commentsResults) ? $commentsResults : array();

        // get commenters from the user table
        $commenterIds = array();
        foreach ($comments as $comment) {
            if (!in_array($comment['commenter_id'], $commenterIds)) {
                $commenterIds[] = $comment['commenter_id'];
            }
        }
        $users = User::findAll(['id' => $commenterIds]);
        $userIdsToUsers = array();
        foreach ($users as $user) {
            $userIdsToUsers[$user->id] = $user;
        }

        return $this->render('view-item-request', 
            ['model' => $itemRequest, 'requester' => $requester->username, 
                'comments' => $comments, 'userIdsToUsers' => $userIdsToUsers,
                'itemRequestUtil' => new ItemRequestUtil()]);
        
    }

    public function actionChangeRequestStatus() {
        $post = \Yii::$app->request->post();

        /* @var ItemRequestComment $itemRequest */
        $itemRequest = ItemRequest::findOne(['id' => $post['itemRequestId']]);
        $itemRequest->open = (intval($post['openOrClosed'] == 1)) ? 0 : 1;
        $itemRequest->date_updated = null;
        return $itemRequest->save();
    }

    public function actionAddNewComment() {
        ////////// NEEDS DONE IN RBAC!!!!!!!!!!
        $post = \Yii::$app->request->post();

        $newComment = new ItemRequestComment();
        $newComment->item_request_id = $post['itemRequestId'];
        $newComment->commenter_id = \Yii::$app->user->id;
        $newComment->content = HtmlPurifier::process($post['content']);
        $newComment->save(true);

        // if comment was inserted, hand it back
        if ($newComment->id > 0) {
            $user = User::findOne(['id' => $newComment->commenter_id]);
            return Json::encode([$newComment->id,
                $this->itemRequestUtil->generateCommentHtml($newComment, $user)]);
        }

        return "failure";
    }
    
    public function actionSaveEditedComment() {
        $post = \Yii::$app->request->post();

        ////////// NEEDS DONE IN RBAC!!!!!!!!!!
        $x = \Yii::$app->user->id;

        /* @var ItemRequestComment $itemRequest */
        $itemRequest = ItemRequestComment::findOne(['id' => $post['commentId']]);
        if ($x == $itemRequest->commenter_id) {
            $itemRequest->content = HtmlPurifier::process($post['newContent']);
            $itemRequest->date_updated = null;  // database defaults to current timestamp here
            $itemRequest->save(true);

            return "success";
        }

        return "fail::wrong_user";
    }

    public function actionDeleteComment() {
        $post = \Yii::$app->request->post();

        ////////// NEEDS DONE IN RBAC!!!!!!!!!!
        $comment = ItemRequestComment::findOne(['id' => $post['commentId']]);
        if (empty($comment)) {
            throw new NotFoundHttpException();
        }

        if ($comment->delete() == 0) {
            throw new ServerErrorHttpException("Item request comment " .
                $post['commentId'] . " couldn't be deleted.");
        }

        return $this->renderContent('deleted: ' . $post['commentId']);
    }

}