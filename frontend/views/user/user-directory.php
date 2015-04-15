<?php
use frontend\assets\InputDriverTemplateAsset;
use frontend\assets\UserAsset;
use frontend\views\LayoutHelper;
use yii\web\View;

/** (no vars)
 */

$this->title = "User Directory";
//$this->params['breadcrumbs'][] = $this->title;

UserAsset::register($this, View::POS_BEGIN);
InputDriverTemplateAsset::register($this, View::POS_BEGIN);
\frontend\assets\TypeaheadAsset::register($this, View::POS_BEGIN);

ob_start();
?>

    <input id="searchBar" class="typeahead form-control" type="text"
           placeholder="Enter a username" />

<?php
$inputHtml = ob_get_clean();

echo LayoutHelper::buildFromInputDriverTemplate("userSearchFormGroup", "User Search",
    $inputHtml, "searchUsersBtn", "Get Users");

?>
<div id="users" style="display: inline-block;">
    <div id="users-grid" style="display: inline-block;"></div>
    <div id="users-list" style="display: none;"></div>
    <div id="paginationContainer"></div>
</div>