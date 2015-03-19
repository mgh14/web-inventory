<?php
namespace frontend\views;

class LayoutHelper {

    public static function getViewButtons() {
        ob_start();
        ?>

        <button class="btn floatRight" style="margin-right: 3%;"
                id="listViewBtn" disabled="disabled">List</button>
        <button class="btn floatRight" style="margin-right: .2%;"
                id="gridViewBtn" disabled="disabled">Grid</button>

        <?php
        return ob_get_clean();
    }
}