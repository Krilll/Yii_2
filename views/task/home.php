<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

//use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Home';
$info = 'Welcome to the task manager!';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3><?= Html::encode($info) ?></h3>



</div>
