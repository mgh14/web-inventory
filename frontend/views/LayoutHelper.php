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

    public static function getLoadingGif() {
        ob_start();
        ?>

        <div id='loader1' class="loader">
            <img src="http://localhost/public_html/mr-test-two/frontend/images/load/ajax-loader.gif"/>
        </div>

        <?php
        return ob_get_clean();
    }
}