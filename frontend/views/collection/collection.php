<?php
namespace frontend\views\collection;

use yii\helpers\Html;

$dropdownHtml = "";
?>

<table style="border: 1px solid black;">
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Row</td>
        <td style="border: 1px solid black;">Entry</td>
        <td style="border: 1px solid black;">Move</td>
        <td style="border: 1px solid black;">Delete</td>
    </tr>

    <?php
    // load the lists
    $count = 1;
    if (isset($childCollections)) {
        foreach ($childCollections as $childCollection) {
            //$collectionId = $collection->id;
            //$collectionName = $childCollection[""];
            echo "<tr>";
            echo "<td>" . $count++ . "</td>";
            //echo "<td>" . $collectionName . "</td>";
            echo "<td>" . $childCollection["name"] . "</td>";
            echo "<td>" . $dropdownHtml . "</td>";
            echo "<td>" . "Delete" . "</td>";
            echo "</tr>";
        }
    }

    // load the items
    if (isset($childItems)) {
        foreach ($childItems as $childItem) {
            //$collectionId = $collection->id;
            //$collectionName = $collection->name;
            echo "<tr>";
            echo "<td>" . $count++ . "</td>";
            //echo "<td>" . $collectionName . "</td>";
            echo "<td>" . $childItem["name"] . "</td>";
            echo "<td>" . $dropdownHtml . "</td>";
            echo "<td>" . "Delete" . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>