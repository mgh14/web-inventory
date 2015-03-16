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

<div style="display: inline-block; width: 100%;">
    <div style="display: inline-block;">
        <?php echo $profileImgHtml?>
    </div>

    <div class="spacer" style="width:8%; display: inline-block; height:1px;"></div>

    <div class="" style="display: inline-block; vertical-align: top;">
        <h1 class=""><?= Html::encode($this->title) ?></h1>
        <br/>
        <div class="">
            <p>Name: <?php echo ucfirst($user['first_name']) . " " .
                    ucfirst($user['last_name'])?></p>
            <p>Email: <?php echo $user->email?></p>
            <p>Member Type: <?php echo $accountType?></p>
            <p>Member since: <?php echo date("F j, Y")?></p>
        </div>
    </div>
    <div style="clear: both;"></div>
</div>