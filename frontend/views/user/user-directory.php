<?php
use frontend\assets\UserAsset;
use yii\web\View;

/** (no vars)
 */

$this->title = "User Directory";
//$this->params['breadcrumbs'][] = $this->title;

UserAsset::register($this, View::POS_BEGIN);
?>

<div id="userSearchContainer" class="floatLeft">
    <input id="searchBar" class="typeahead" type="text" placeholder="Enter a search value">
</div>
<div id='loader1' class="floatLeft loader">
    <img src="http://localhost/public_html/mr-test-two/frontend/images/load/ajax-loader.gif"/>
</div>
<button class="btn floatLeft" id="searchUsersBtn">Search</button>

<button class="btn floatRight" style="margin-right: 3%;" id="listViewBtn" disabled="disabled">List</button>
<button class="btn floatRight" style="margin-right: .2%;" id="gridViewBtn" disabled="disabled">Grid</button>

<div style="clear: both;"></div>
<hr/>

<div id="users" style="display: inline-block;">
    <div id="users-grid" style="display: inline-block;"></div>
    <div id="users-list" style="display: none;"></div>
    <div id="paginationContainer"></div>
</div>

<style>
    .loader {
        display: none;
    }
</style>

