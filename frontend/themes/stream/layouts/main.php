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

    <meta property='og:site_name' content='<?php echo Html::encode($this->title); ?>' />
    <meta property='og:title' content='<?php echo Html::encode($this->title); ?>' />
    <meta property='og:description' content='<?php echo Html::encode($this->title); ?>' />

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel='stylesheet' type='text/css' href='<?php echo $this->theme->baseUrl; ?>/files/main_style.css' title='wsite-theme-css' />

    <?php $this->head() ?>
</head>

<body style="margin: 0;">
<?php $this->beginBody(); ?>
<div class="container">
    <div class="header">
        <div class="logo" style="">
            <i>Stream EqM</i>
        </div>

        <div class="siteLinkContainer loginLinkContainer siteBtn">
            <div class="siteLinkText loginLink">
                <a href="">Logout</a>
            </div>
        </div>
        <div class="siteLinkContainer reportLinkContainer siteBtn">
            <div class="siteLinkText reportLink">
                <a href="">Report Issue</a>
            </div>
        </div>
    </div>
    <div style="width: 100%; margin: 0px; position: relative; height: 100%;">
        <div class="leftColumn">
            <div class="usernameContainer">
                <div class="username">Username</div>
            </div>

            <div class="category siteBtn">
                <div class="categoryIcon"></div>
                <div class="categoryNameContainer">
                    <div class="categoryRelativeContainer">
                        <div class="categoryNameText">Dashboards</div>
                    </div>
                </div>
            </div>

            <div class="category siteBtn">
                <div class="categoryIcon"></div>
                <div class="categoryNameContainer">
                    <div class="categoryRelativeContainer">
                        <div class="categoryNameText">Dashboards</div>
                    </div>
                </div>
            </div>

            <div class="category siteBtn">
                <div class="categoryIcon"></div>
                <div class="categoryNameContainer">
                    <div class="categoryRelativeContainer">
                        <div class="categoryNameText">Dashboards</div>
                    </div>
                </div>
            </div>

            <div class="category siteBtn">
                <div class="categoryIcon"></div>
                <div class="categoryNameContainer">
                    <div class="categoryRelativeContainer">
                        <div class="categoryNameText">Dashboards</div>
                    </div>
                </div>
            </div>

            <div class="category siteBtn">
                <div class="categoryIcon"></div>
                <div class="categoryNameContainer">
                    <div class="categoryRelativeContainer">
                        <div class="categoryNameText">Dashboards</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content" style="background-color: #234565;">
            <?php echo $content; ?>
        </div>
    </div>
</div>

<?php $this->endBody(); ?>
</body>

</html>
<?php $this->endPage() ?>
