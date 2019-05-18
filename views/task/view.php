<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\models\Task */
/* @var $users boolean */
/* @var $titleTwo string */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $modelTwo \app\models\TaskUser */
/* @var $icon \yii\bootstrap\Html */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['my']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            'creator_id',
            'updater_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]);

    if($users) {

    echo
    "<h2>".$titleTwo."</h2>".
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
                'id',
            [
               'label' => 'User',
                'format' => 'raw',

                'value' => function(\app\models\TaskUser $modelTwo) {

                    return Html::a(join($modelTwo->getUser()->select('username')->column()),
                        ['/user/view/', 'id' => $modelTwo->user_id]);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        $icon = \yii\bootstrap\Html::icon('remove-sign');
                        return Html::a($icon, ['task-user/delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this access?',
                                'method' => 'post',
                            ],
                            'title' => 'Лишить доступа'
                        ]);
                    },
                ],
            ],


        ],
    ]); }


    ?>



</div>
