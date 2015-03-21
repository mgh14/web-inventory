<?php
namespace frontend\controllers;

use frontend\models\db\record\Sport;
use frontend\views\LayoutHelper;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class SportCategoriesController extends Controller {


    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],   // allow access to all functions if logged in
                    ],
                    /*[
                        'action' => ['AdministerItemRequest'],
                        'allow' => true,
                        'roles' =>
                    ]*/
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionEditCategory() {
        $categoryId = intval(\Yii::$app->request->post('id'));
        if (empty($categoryId) || $categoryId < 1) {
            throw new BadRequestHttpException("Category ID is invalid");
        }
        $newName = urldecode(\Yii::$app->request->post('newName'));
        if (empty($newName)) {
            throw new BadRequestHttpException("New name category is invalid");
        }

        $record = Sport::findOne(['id' => $categoryId]);
        if (!$record) {
            throw new NotFoundHttpException("Category id [" . $categoryId . "] not found.");
        }

        $record->name = HtmlPurifier::process(trim($newName));
        $rowsUpdated = $record->save();
        return ($rowsUpdated == 1) ? "success" : "failure::no-db-update";
    }

    public function actionViewCategories() {
        $categories = Sport::find()->asArray()->all();

        $listView = $this->getCategoriesListView($categories);
        return $this->render("categories", ["listView" => $listView]);
    }

    /**
     * @param $categories array[Sport record]
     * @return string (HTML)
     */
    private function getCategoriesListView($categories) {
        ob_start();
        ?>

        <div class="categories-list">
            <table class="table table-hover categories-list-table">
                <tr>
                    <td style="width: 19%;">
                        <p>Row</p>
                    </td>
                    <td>
                        <p>Category Name</p>
                    </td>
                </tr>

                <?php
                $rowCounter = 1;
                foreach ($categories as $category) {
                    ?>

                    <tr>
                        <td><?php echo $rowCounter++?></td>
                        <td>
                            <div class="hidden categoryId"><?php echo $category['id']?></div>
                            <div class="categoryName link"><?php echo $category['name']?></div>
                            <div class="changeCategoryNameContainer">
                                <div>Category name:</div>
                                <div class="floatLeft categoryNameInputContainer">
                                    <input class="categoryNameInput"
                                           value="<?php echo $category['name']?>"  title=""/>
                                </div>
                                <button class="btn setCategoryNameBtn">Set Name</button>
                                <div class="categorySpacer"></div>
                                <button class="btn cancelNewCategoryNameBtn">Cancel</button>
                                <?php echo LayoutHelper::getLoadingGif()?>
                            </div>
                        </td>
                    </tr>

                    <?php
                }
                ?>

            </table>
        </div>

        <?php
        return ob_get_clean();
    }

}