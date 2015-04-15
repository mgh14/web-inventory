<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class TypeaheadAsset extends AssetBundle {
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/typeahead.css',
    ];
    public $js = [
        'js/typeahead.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}