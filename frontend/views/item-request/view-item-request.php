<?php
use frontend\assets\ItemRequestAsset;
use frontend\models\ItemRequestUtil;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model \frontend\models\db\record\ItemRequest
 * @var $requester string
 * @var $comments array[string]
 * @var $userIdsToUsers array[User]
 * @var $itemRequestUtil ItemRequestUtil
 */

// register JS variables and asset bundle(s)
$jsArr = "[";
foreach ($comments as $comment) {
    $jsArr .= $comment['id'] . ", ";
}
$jsArr = rtrim($jsArr, ", ") . "]";
$this->registerJs("
    var modelId = " . $model['id'] . ";
    var commentIds = " . $jsArr . ";
", View::POS_BEGIN);
ItemRequestAsset::register($this);

$this->title = 'Item Request';
//$this->params['breadcrumbs'][] = $this->title;

$open = ($model['open'] == 1) ? "Open" : "Closed";
$openButtonText = ($model['open'] == 1) ? "Close" : "Open";

?>
<div class="">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <p>Requester: <?php echo $requester?></p>
            <p>Item type: <?php echo $model['item_type_id']?></p>
            <p>Date created: <?php echo $model['date_created']?></p>
            <p>Last updated: <?php echo $model['date_updated']?></p>

            <p>Status: <?php echo (($model['open'] == 1) ? "Open" : "Closed")?>
                <button id="openOrClosedRequest_<?php echo $model['id']?>"><?php echo $openButtonText?></button></p>
            <div id="openOrClosedRequestStatus_<?php echo $model['id']?>" class="hidden"><?php echo (($model['open'] == 1) ? 1 : 0)?></div>
        </div>
    </div>
    
    <div class="comments">
        <div>Comments</div>
        <div style="height:2em;"></div>
        
        <div id="comments-area">
            <?php
            foreach ($comments as $comment) {
                echo $itemRequestUtil->generateCommentHtml($comment, $userIdsToUsers[$comment['commenter_id']]);
            }
            ?>

            <div id="newCommentContainer">
                <textarea class="commentTextarea" id="newCommentEditable"></textarea>
            </div>
            <button class="" id="addComment">Add Comment</button>
        </div>
    </div>
    
</div>