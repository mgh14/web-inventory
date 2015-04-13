<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => "<img src=''/>",
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'About', 'url' => ['/site/about']],
                ['label' => 'Contact', 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>
        <div class="subnavbar" style="position: fixed; height: 30px; width: 100%; background-color: #383838; margin-top:50px;">
            <div class="sublinksContainer">
                <div class="category">
                    <div class="categoryText">
                        Measurements
                        <ul class="menu">
                            <li>Manage Measurements</li>
                            <li>Measurements by Sport</li>
                        </ul>
                    </div>
                </div>
                <div class="category">
                    <div class="categoryText">
                        Users
                        <ul class="menu">
                            <!--<li class="ui-state-disabled">Aberdeen</li>-->
                            <li>Directory</li>
                            <li>Teams</li>
                            <li>New Players</li>
                        </ul>
                    </div>
                </div>
                <div class="category">
                    <div class="categoryText">
                        Equipment
                        <ul class="menu">
                            <li>New Item</li>
                            <li>View and Print</li>
                            <li>Manage Tags</li>
                            <li>Scan Items</li>
                        </ul>
                    </div>
                </div>
                <div class="category" style="border-right: 1px solid #585858;">
                    <div class="categoryText">Help Topics</div>
                </div>
            </div>
        </div>

        <div class="container">
            <?php $this->beginBody()?>
            <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
