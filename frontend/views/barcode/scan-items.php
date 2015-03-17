<?php
use frontend\assets\BarcodeAsset;
use frontend\assets\ItemRequestAsset;
use frontend\models\ItemRequestUtil;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Menu;

/* @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model \frontend\models\db\record\ItemRequest
 * @var $requester string
 * @var $comments array[string]
 * @var $userIdsToUsers array[User]
 * @var $itemRequestUtil ItemRequestUtil
 */

BarcodeAsset::register($this);
// register JS variables and asset bundle(s)
/*$jsArr = "[";
foreach ($comments as $comment) {
    $jsArr .= $comment['id'] . ", ";
}
$jsArr = rtrim($jsArr, ", ") . "]";
$this->registerJs("
    var modelId = " . $model['id'] . ";
    var commentIds = " . $jsArr . ";
", View::POS_BEGIN);
ItemRequestAsset::register($this);*/

$this->title = 'Item Scan';
//$this->params['breadcrumbs'][] = $this->title;

/*$open = ($model['open'] == 1) ? "Open" : "Closed";
$openButtonText = ($model['open'] == 1) ? "Close" : "Open";*/

?>
<div class="">
    <h1><?= Html::encode($this->title) ?></h1>

    Barcode: <br/>
    <label for="barcodeValue">
        <input id="barcodeValue"/>
        <div class="hidden" id="lastBarcodeValue"></div>
    </label>
    <br/>

    <label>
        <input type="radio" name="scanType" value="check-in">
    </label> Check-In
    <br>
    <label>
        <input type="radio" name="scanType" value="check-out">
    </label> Check-Out
    <br/>

    <label for="autoAction"></label><input type="checkbox" name="autoAction" id="autoAction" /> Auto-scan (Submit value automatically)
    <br/>
    <button class="btn" id="submitScan">Submit Scan</button>
</div>

<?php

/*echo Menu::widget([
    'items' => [
        // Important: you need to specify url as 'controller/action',
        // not just as 'controller' even if default action is used.
        ['label' => 'Home', 'url' => ['site/index']],
        // 'Products' menu item will be selected as long as the route is 'product/index'
        ['label' => 'Products', 'url' => ['product/index'], 'items' => [
            ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
            ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
        ]],
        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
    ],
]);*/

/*NavBar::begin([
    'brandLabel' => 'Yii 2 Build <i class="fa fa-plug"></i>',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);*/

/*echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => [

        ['label' => 'Top Label', 'items' => [
            ['label' => 'Action', 'url' => '#'],
            ['label' => 'Another action', 'url' => '#'],
            ['label' => 'Something else here', 'url' => '#'],
        ]],

    ],

]);*/

//NavBar::end();

?>