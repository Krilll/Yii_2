<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskUser */
/* @var $users array*/

$this->title = 'Give a task to user';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['task/my']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
    ]) ?>

</div>
