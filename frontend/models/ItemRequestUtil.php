<?php
namespace frontend\models;

use yii\helpers\Html;

class ItemRequestUtil {

    public function generateCommentHtml($comment, $commenter) {
        $commentId = $comment['id'];
        ob_start();
        ?>
        <div id="commentContainer_<?php echo $commentId?>" datafld="<?php echo $commentId?>">
            <div>
                <p>Comment made by <?php echo $commenter->username?>
                    at <?php echo $comment->date_updated?></p>
            </div>

            <div class="hidden" id="commentActive_<?php echo $commentId?>">0</div>
            <div class="hidden" id="originalTextComment_<?php echo $commentId?>"><?php echo $comment['content']?></div>
            <div id="comment_<?php echo $commentId?>">
                <?php echo $comment['content']?>
            </div>
            <button id="commentEditBtn_<?php echo $commentId?>">Edit Comment</button>
            <button id="commentDeleteBtn_<?php echo $commentId?>">Delete Comment</button>

            <?php echo Html::textarea('commentEditable_' . $commentId,
                trim($comment['content']), [
                    'id' => 'commentEditable_' . $commentId,
                    'class' => 'commentTextarea displayNone'])?>
            <button class="displayNone" id="commentSaveBtn_<?php echo $commentId?>">Save</button>
            <button class="displayNone" id="commentCancelBtn_<?php echo $commentId?>">Cancel</button>
            <div style="height:1.5em; width:100%;"></div>
        </div>
        <?php
        return ob_get_clean();
    }

}