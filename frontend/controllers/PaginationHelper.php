<?php
namespace frontend\controllers;

class PaginationHelper {

    static public $firstBtnId = "firstSetBtn";
    static public $prevBtnId = "prevSetBtn";
    static public $nextBtnId = "nextSetBtn";
    static public $lastBtnId = "lastSetBtn";

    static public $firstLinkId = "firstLink";
    static public $prevLinkId = "prevLink";
    static public $nextLinkId = "nextLink";
    static public $lastLinkId = "lastLink";

    public function getPaginationHtml($template, $textToReplace, $offsetParam, $resultLimit, $count) {
        $links = $this->generatePaginationLinks($template, $textToReplace, $offsetParam, $resultLimit, $count);
        return $this->generatePaginationPagesHtml($links["beginningLink"], $links["prevLink"],
            $links["pageLinks"], $links["nextLink"], $links["endLink"]);
    }

    private function generatePaginationLinks($paginationTemplate, $textToReplace, $offsetParam, $resultLimit, $count) {
        // create 'beginning' link
        $beginningLink = "";
        if ($offsetParam > 0) {
            $beginningLink = str_replace($textToReplace, 0, $paginationTemplate);
        }

        // create 'prev' link
        $newOffset = $offsetParam + ($resultLimit);
        $prevLink = "";
        if ($offsetParam > 0) {
            $prevLink = str_replace($textToReplace, (($offsetParam == 0) ? 0 : $offsetParam - $resultLimit), $paginationTemplate);
        }

        // create page num links (without a link to the current page)
        $pageUrls = array();
        $offsetCount = 0;   // NOTE: this var used for the next three calculations
        while ($offsetCount <= $count) {
            if ($offsetCount != $offsetParam) {
                $pageUrls[intval($offsetCount / $resultLimit) + 1] = str_replace($textToReplace, $offsetCount, $paginationTemplate);
            }
            $offsetCount += $resultLimit;
        }

        // create 'next' link
        $nextLink = "";
        if ($newOffset <= $count) {
            $nextLink = str_replace($textToReplace, ($offsetParam + $resultLimit), $paginationTemplate);
        }

        // create 'end' link
        $endLink = "";
        if ($nextLink != "") {
            $endLink = str_replace($textToReplace, ($offsetCount - $resultLimit), $paginationTemplate);
        }

        return ["beginningLink" => $beginningLink, "prevLink" => $prevLink, "pageLinks" => $pageUrls,
            "nextLink" => $nextLink, "endLink" => $endLink];
    }

    private function generatePaginationPagesHtml($first, $prev, $pageUrls, $next, $last) {
        ob_start();

        if ($prev != "" && $first != "") {
            ?>
            <button class="btn" id="<?php echo static::$firstBtnId?>">First</button>
            <div class="hidden" id="<?php echo static::$firstLinkId?>"><?php echo $first?></div>
        <?php
        }

        if ($prev != "") {
            ?>
            <button class="btn" id="<?php echo static::$prevBtnId?>">Previous</button>
            <div class="hidden" id="<?php echo static::$prevLinkId?>"><?php echo $prev?></div>
        <?php
        }

        foreach ($pageUrls as $pageNum => $pageUrl) {
            ?>
            <button class="btn" id="page<?php echo $pageNum?>SetBtn"><?php echo $pageNum?></button>
            <div class="hidden" id="pageLink<?php echo $pageNum?>"><?php echo $pageUrl?></div>
        <?php
        }

        if ($next != "") {
            ?>
            <button class="btn" id="<?php echo static::$nextBtnId?>">Next</button>
            <div class="hidden" id="<?php echo static::$nextLinkId?>"><?php echo $next?></div>
        <?php
        }

        if ($next != "" && $last != "") {
            ?>
            <button class="btn" id="<?php echo static::$lastBtnId?>">Last</button>
            <div class="hidden" id="<?php echo static::$lastLinkId?>"><?php echo $last?></div>
        <?php
        }
        return ob_get_clean();
    }

}