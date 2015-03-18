<?php
use frontend\assets\SportsCategoriesAsset;
use yii\web\View;

/**
 * @var $gridView String (HTML)
 * @var $listView String (HTML)
 */

$this->title = "Sport Categories";
//$this->params['breadcrumbs'][] = $this->title;

SportsCategoriesAsset::register($this, View::POS_BEGIN);

?>
<button class="floatRight" style="margin-right: 3%;" id="listViewBtn">List</button>
<button class="floatRight" style="margin-right: .2%;" id="gridViewBtn">Grid</button>

<div style="clear: both;"></div>
<hr/>

<div id="sportsCategories" style="display: inline-block;">
    <div id="categories-grid" style="display: inline-block;">
        <?php echo $gridView?>
    </div>
    <div id="categories-list" style="display: none;">
        <?php echo $listView?>
    </div>
</div>

