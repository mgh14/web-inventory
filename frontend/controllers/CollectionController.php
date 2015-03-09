<?php
namespace frontend\controllers;

use frontend\models\db\dao\CollectionChildDao;
use frontend\models\db\record\Collection;
use frontend\models\db\dao\CollectionUtil;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

/**
 * Collection controller
 */
class CollectionController extends Controller {

    const ERROR_STRING = "<p>Result set from database is empty!</p>";

    /* @var $aPerson CollectionUtil */
    private $collectionUtil = null;

    public function init() {
        parent::init();
        $this->collectionUtil = new CollectionUtil();
    }

    public function setCollectionUtil($newCollectionUtil) {
        $this->collectionUtil = $newCollectionUtil;
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
    
    public function actionAbc() {
        $f = CollectionChildDao::isCollectionAncestorOfCollection(8, 1);
        return $this->renderContent("IsCollectionAncestorOfCollection: " . $f . ";");
    }

    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    //////////////////// GETTER METHODS

    public function actionListAllCollections() {
        $query = Collection::find();

        $pagination = new Pagination([
            'defaultPageSize' => 30,
            'totalCount' => $query->count(),
        ]);

        $collections = $query->orderBy('name')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('all-collections', [
            'collections' => $collections,
            'pagination' => $pagination,
        ]);
    }

    public function actionGetById($collectionId) {
        $collection = Collection::findOne(['id' => $collectionId]);
        if (empty($collection)) {
            return CollectionController::ERROR_STRING;
        }

        return $this->renderCollection($collection->id);
    }

    public function actionGetByName($collectionName) {
        $collection = Collection::findOne(['name' => $collectionName]);
        if (empty($collection)) {
            return CollectionController::ERROR_STRING;
        }

        return $this->renderCollection($collection->id);
    }



    ////////////////// UPDATE METHODS

    public function actionAddChildCollectionToParent($collectionId, $parentId) {
        if ($this->collectionUtil->addChildCollectionToParent($collectionId, $parentId)) {
            return $this->renderContent("child add successful: item " .
                $collectionId . " added to collection " . $parentId);
        }
        else {
            // throw exception
            Yii::$app->response->statusCode = 500;
            return $this->renderContent("what's the error?");
        }
    }

    public function actionRemoveChildCollectionFromParent($collectionId, $parentId) {
        if ($this->collectionUtil->removeChildCollectionFromParent($collectionId, $parentId)) {
            return $this->renderContent("child remove successful: collection " .
                $collectionId . " removed from collection " . $parentId);
        }
        else {
            // throw exception
            Yii::$app->response->statusCode = 500;
        }
    }

    public function actionAddChildItemToParent($itemId, $parentId) {
        if ($this->collectionUtil->addChildItemToParent($itemId, $parentId)) {
            return $this->renderContent("child add successful: item " .
                $itemId . " added to collection " . $parentId);
        }
        else {
            // throw exception
            Yii::$app->response->statusCode = 500;
        }
    }

    public function actionRemoveChildItemFromParent($itemId, $parentId) {
        if ($this->collectionUtil->removeChildItemFromParent($itemId, $parentId)) {
            return $this->renderContent("child remove successful: item " .
                $itemId . " removed from collection " . $parentId);
        }
        else {
            // throw exception
            Yii::$app->response->statusCode = 500;
        }
    }



    //////////////////////// RENDER METHODS

    private function renderCollection($collectionId) {
        // load child lists
        $childCollections = $this->collectionUtil->getChildCollections($collectionId);

        // load child items
        $childItems = $this->collectionUtil->getChildItems($collectionId);

        return $this->render('collection', [
            'childCollections' => $childCollections,
            'childItems' => $childItems]);
    }

    private function getCollectionHtmlDropdown($collections) {
        if (empty($collections)) {
            return "Dropdown parse error";
        }

        ob_start();
        ?>
        <select>
            <?php
            foreach ($collections as $collection) {
                $collectionId = $collection->id;
                $name = $collection->name;

                //echo "<option value=\"" . $collectionId . "\">" . $name . "</option>";
            }
            ?>
        </select>
        <?php
        return ob_get_clean();
    }

}
