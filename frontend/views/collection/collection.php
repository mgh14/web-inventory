<?php
namespace frontend\views\collection;

use frontend\assets\CollectionsAsset;
use frontend\assets\InputDriverTemplateAsset;
use frontend\views\LayoutHelper;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var Array $childItems
 * @var Array $childCollections
 */

$this->title = "Collection View";

CollectionsAsset::register($this, View::POS_BEGIN);
InputDriverTemplateAsset::register($this, View::POS_BEGIN);

ob_start();
?>

<input id="searchBar" class="typeahead form-control" type="text" placeholder="Enter a collection name">

<?php
$inputHtml = ob_get_clean();

echo LayoutHelper::buildFromInputDriverTemplate("collectionSearchFormGroup", "Collection Search", $inputHtml, "", "Get Collections");

$dropdownHtml = "";

?>
<div class="collectionSubcontainer" style="">
    <div class="addItemContainer">
        <h4>Add Items to Collection</h4>
        <div class="form-group">
            <input type="text" class="form-control addItem" style="display: inline-block;"
                   placeholder="Enter an item name" />
            <button class="btn formBtn addItemBtn">Add Item</button>
        </div>
    </div>

    <div class="addedItemsContainer">
        <h4 style="margin-top: 15px;">Items in Collection</h4>
        <div class="">
            <table class="table table-hover">
                <tr>
                    <td style="width: 65%;"><b>Item Name</b></td>
                    <td style="width: 35%;"><b>Actions</b></td>
                </tr>

                <?php

                foreach($childItems as $item) {
                    ?>

                        <tr class="">
                            <td><?php echo $item["name"]?></td>
                            <td>
                                <button class="btn">Remove</button>
                                <button class="btn">Edit Item</button>
                            </td>
                        </tr>

                    <?php
                }

                ?>
            </table>
        </div>
    </div>
</div>

<div style="width: 3%; display: inline-block;"></div>

<div class="collectionSubcontainer">
    <div class="collectionNameContainer">
        <h4>Collection Name</h4>
        <div class="form-group">
            <input type="text" class="form-control collectionName" style="display: inline-block;"
                   value="<?php echo ucfirst("list1")?>" />
            <button class="btn formBtn collectionName">Save Name</button>
        </div>
    </div>

    <div class="addCollectionContainer">
        <h4>Add Collections</h4>
        <div class="form-group">
            <input type="text" class="form-control" style="display: inline-block;"
                   placeholder="Enter existing collection name" />
            <button class="btn formBtn addCollectionBtn">Add Collection</button>
        </div>
    </div>

    <div class="removeCollectionContainer">
        <h4>Collections within this collection</h4>
        <p><i>Click on a collection name to remove it from this collection</i></p>

        <?php

        foreach($childCollections as $childCollection) {
            ?>

            <button class="btn"><?php echo $childCollection["name"]?></button>

            <?php
        }

        ?>
    </div>
</div>