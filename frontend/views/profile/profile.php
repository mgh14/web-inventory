<?php
use frontend\assets\AppAsset;
use frontend\assets\ProfileAsset;
use frontend\models\db\record\CollectionChildItem;
use frontend\models\ItemRequestUtil;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var String $profileImgHtml
 * @var Object[DB row] $user
 */

$this->title = ucfirst($user["username"]) . "'s Profile";
//$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this, View::POS_BEGIN);
ProfileAsset::register($this, View::POS_BEGIN);

// TODO: temporary array for display
$sports = ["football", "basketball", "volleyball", "golf",
    "Swimming", "baseball", "soccer"];

// TODO: temporary array for display
$measurements = [
    ["name" => "Shoe Size", "value" => "11.5"],
    ["name" => "Helmet Size", "value" => "Large"],
    ["name" => "Glove Size", "value" => "Medium"],
];

?>
<div class="profileContainer">
    <h1><?php echo Html::encode($this->title)?></h1>
    <div class="basicProfileInfo profileGroup">
        <div class="profileImgContainer">
            <?php echo $profileImgHtml?>
        </div>

        <div class="spacer"></div>

        <div class="basicInfoText">
            <p><b>Name:</b> <?php echo ucfirst($user['first_name']) . " " .
                    ucfirst($user['last_name'])?></p>
            <p><b>Email:</b> <?php echo $user["email"]?></p>
            <p><b>Member Type:</b> <?php echo $accountType?></p>
            <p><b>Member since:</b> <?php echo date("F j, Y")?></p>
            <p><b>Locker #:</b> 1455-C</p>
        </div>
    </div>

    <div class="spacer"></div>

    <div class="measurements profileGroup">
        <h3>Measurements by Sport</h3>
        <div class="measurementsAccordion accordion">
            <?php
            foreach($sports as $sport) {
                ?>
                <h3><?php echo ucfirst($sport)?></h3>

                <div>
                    <ul>
                        <?php

                        foreach ($measurements as $measurement) {
                            ?>

                            <li>
                                <?php
                                echo ucfirst($measurement["name"]) . ": " .
                                    ucfirst($measurement["value"]);
                                ?>
                            </li>

                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
            ?>

        </div>
    </div>

    <div class="jerseysBySport profileGroup">
        <h3>Jersey Numbers</h3>
        <table class="table table-hover">
            <tr class="tableHeader">
                <td class="jerseySportColWidth">Sport</td>
                <td class="centerText">Jersey Number</td>
            </tr>

            <?php

            $counter = 1;
            foreach ($sports as $sport) {
                ?>

                <tr>
                    <td><?php echo $sport?></td>
                    <td class="centerText"><?php echo $counter++?></td>
                </tr>

                <?php
            }

            ?>
        </table>
    </div>

    <div class="spacer"></div>

    <div class="dressingForSports profileGroup">
        <h3>Dressing for Next Game</h3>
        <table class="table table-hover">
            <tr class="tableHeader">
                <td class="dressingSportColWidth">Sport</td>
                <td class="centerText">Dressing</td>
            </tr>

            <?php

            $counter = 1;
            foreach ($sports as $sport) {
                ?>

                    <tr>
                        <td><?php echo $sport?></td>
                        <td class="centerText">
                            <?php echo ($counter++ % 2 == 0) ? "<b>YES</b>" : "<i>No</i>"?>
                        </td>
                    </tr>

                <?php
            }

            ?>
        </table>
    </div>

</div>