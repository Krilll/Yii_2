<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shared tasks';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'description:ntext',
            [
                    'label' => 'Users',
                    'value' => function(\app\models\Task $model) {
                        return join(', ', $model->getAccessedUsers()->select('username')->column());
                    }

            ],

            [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {give} {deleteAll}',
                    'buttons' => [
                        'give' => function ($url, $model, $key) {
                            $icon = \yii\bootstrap\Html::icon('paste');
                            return Html::a($icon,['task-user/create','taskId' => $model->id], [
                                'title' => 'Поделиться'
                            ]);
                        },
                        'deleteAll' => function ($url, $model, $key) {
                            $icon = \yii\bootstrap\Html::icon('floppy-remove');
                            return Html::a($icon, ['task-user/delete-all', 'id' => $model->id], [
                                'data' => [
                                    'confirm' => 'Are you sure you want to delete all this items?',
                                    'method' => 'post',
                                ],
                                'title' => 'Закрыть ото всех'
                             ]);
                        },
                    ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
