<?php
namespace frontend\controllers;

use frontend\models\db\record\Sports;
use yii\base\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class SportsCategoriesController extends Controller {


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
        $categoryId  = intval(\Yii::$app->getRequest()->getQueryParam("category"));
        if ($categoryId < 0) {
            throw new NotFoundHttpException("Bad category parameter");
        }
        $category = Sports::find($categoryId);
        if (!$category) {
            throw new NotFoundHttpException("Nonexistent category parameter");
        }

        return $this->render("edit-category", ["category" => $category]);
    }

    public function actionViewCategories() {
        $categories = Sports::find()->asArray()->all();

        $gridView = $this->getCategoriesGridView($categories);
        $listView = $this->getCategoriesListView($categories);
        return $this->render("categories", ["gridView" => $gridView,
            "listView" => $listView]);
    }

    /**
     * @param $categories array[Sport record]
     * @return string (HTML)
     */
    private function getCategoriesGridView($categories) {
        ob_start();
        ?>

        <div id='categories-gridView'>
            <?php

            foreach ($categories as $category) {
                ?>

                <div id="category<?php echo $category['id']?>" class="floatLeft" style="width: 13%; margin-top:3%; margin-right:7%; font-size: .9vw;">
                    <img style="width: 100%; margin-left: auto; margin-right: auto;"
                         src="" />
                    <div style="clear:both;"></div>
                    <p class="centerText" style="margin-top: 15%; margin-bottom: 0;">
                        <a href="?r=sports-categories%2Fedit-category&category=<?php echo $category['id']?>">
                            <b><?php echo $category['name']?></b>
                        </a>
                    </p>
                    <div style="clear:both;"></div>
                </div>

                <?php
            }

            ?>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * @param $categories array[Sport record]
     * @return string (HTML)
     */
    private function getCategoriesListView($categories) {
        ob_start();
        ?>

        <style>
            #categories-list-table td {
                border: 1px solid #DCDCDC;
            }
        </style>
        <div class="" id="categories-list" style="display:inline-block;">
            <table id="categories-list-table" class="table table-hover" style="table-layout:fixed;">
                <tr>
                    <td style="width: 15%;">
                        <p>Row</p>
                    </td>
                    <td>
                        <p>Category Name</p>
                    </td>
                    <td>
                        <p>Action</p>
                    </td>
                </tr>

                <?php
                $rowCounter = 1;
                foreach ($categories as $category) {
                    ?>

                    <tr>
                        <td><?php echo $rowCounter++?></td>
                        <td><?php echo $category['name']?></td>
                        <td>Action</td>
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