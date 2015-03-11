<?php
use frontend\assets\UserAsset;
use yii\web\View;

/** (no vars)
 */

$this->title = "User Directory";
//$this->params['breadcrumbs'][] = $this->title;

UserAsset::register($this, View::POS_BEGIN);
?>

<div id="the-basics" class="floatLeft">
    <input id="searchBar" class="typeahead" type="text" placeholder="States of USA">
</div>
<div id='loader1' class="floatLeft loader">
    <img src="http://localhost/public_html/mr-test-two/frontend/images/load/ajax-loader.gif"/>
</div>
<button class="floatLeft" id="searchUsersBtn">Search</button>

<div id="users"></div>

<style>
    .loader {
        display: none;
    }
</style>

