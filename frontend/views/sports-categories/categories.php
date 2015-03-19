<?php
use frontend\assets\SportsCategoriesAsset;
use frontend\views\LayoutHelper;
use yii\web\View;

/**
 * @var $gridView String (HTML)
 * @var $listView String (HTML)
 */

$this->title = "Sport Categories";
//$this->params['breadcrumbs'][] = $this->title;

SportsCategoriesAsset::register($this, View::POS_BEGIN);

echo LayoutHelper::getViewButtons();

?>
<div style="clear: both;"></div>
<hr/>

<div class="description"><i>Click on a category's name to edit it</i></div>
<br/>

<div id="sportsCategories" style="display: inline-block;">
    <div id="categories-list" style="display: inline-block;">
        <?php echo $listView?>
    </div>
</div>

