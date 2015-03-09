<?php
use frontend\models\db\record\CollectionChildItem;
use frontend\models\ItemRequestUtil;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $user common\models\User
 * @var $accountType String
 * @var $profileImgHtml String
 */

$this->title = ucfirst($user->username) . "'s Profile";
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">
    <div>
        <?php echo $profileImgHtml?>
        <h1 class="floatLeft"><?= Html::encode($this->title) ?></h1>
    </div>

    <div style="clear: both;"></div>

    <br/><br/><br/><br/>

    <div>
        <p>Email: <?php echo $user->email?></p>
        <p>Member Type: <?php echo $accountType?></p>
        <p>Member since: <?php echo date("F j, Y")?></p>
    </div>
</div>