<?php

namespace app\controllers;

use Yii;
use app\models\TaskUser;
use app\models\Task;
use app\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * TaskUserController implements the CRUD actions for TaskUser model.
 */
class TaskUserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-all' => ['POST'],
                ],
            ],
        ];
    }


    /**
     * Creates a new TaskUser model.
     * @param integer $taskId
     * @return mixed
     * @throws ForbiddenHttpException if the task cannot be found or user_id !== creator_id
     */
    public function actionCreate($taskId)
    {
        $model = Task::findOne($taskId);
        if(!$model || $model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('Доступ закрыт.');
        }
        $model = new TaskUser();
        $model->task_id = $taskId;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Your gift of a task was success');
            return $this->redirect(['task/my']);
           // return $this->redirect(['view', 'id' => $model->id]);
        }

        $users = User::find()
            ->where(['<>', 'id', Yii::$app->user->id])
            ->select('username')
            ->indexBy('id')
            ->column();

        return $this->render('create', [
            'model' => $model,
            'users' => $users,
        ]);
    }

    /**
     * Deletes an existing TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException'Доступ закрыт.' if the task cannot be found or user_id !== creator_id
     */
    public function actionDelete($id)
    {
        $model = TaskUser::getId($id);
        $task = $model->getTask()
         ->select('creator_id')->column();
        $taskId = $model->getTask()
            ->select('id')->column();

        if( $task[0] != Yii::$app->user->id) {
            throw new ForbiddenHttpException('Доступ закрыт.');
        }
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success',
            'Your delete of the relation of the task was success');

        return $this->redirect(['task/view', 'id' => $taskId[0]]);
    }
    /**
     * Deletes all shared of this TaskUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException if the task cannot be found or user_id !== creator_id
     */
    public function actionDeleteAll($id)
    {
        $model = Task::findOne($id);

        if(!$model || $model->creator_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }

        $model->unlinkAll(Task::ACCESSED_USERS, true);

        Yii::$app->session->setFlash('success',
            'Your delete of all relations of the task was success');

        return $this->redirect(['task/shared']);
    }

    /**
     * Finds the TaskUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
