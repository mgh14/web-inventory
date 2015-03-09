<?php
use frontend\assets\UserAsset;
use yii\web\View;

/**
 */

$this->title = "User Directory";
//$this->params['breadcrumbs'][] = $this->title;

UserAsset::register($this, View::POS_BEGIN);
?>

<div id="the-basics">
    <input class="typeahead" type="text" placeholder="States of USA">
</div>

