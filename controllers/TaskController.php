<?php

namespace app\controllers;

use Yii;
use app\models\Task;
//use app\models\User;
//use app\models\TaskUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Lists a home page.
     * @return mixed
     */
    public function actionHome()
    {
        return $this->render('home');
    }
    /**
     * Lists all your Task models.
     * @return mixed
     */
    public function actionMy()
    {
        $user = Task::find()->byCreator(Yii::$app->user->id);
        $dataProvider = new ActiveDataProvider([
            'query' => $user,
        ]);

        return $this->render('my', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all your shared Task models.
     * @return mixed
     */
    public function actionShared()
    {
        $user = Task::find()
            ->byCreator(Yii::$app->user->id)
            ->innerJoinWith(Task::TASK_USERS);
        $dataProvider = new ActiveDataProvider([
            'query' => $user,
        ]);


        return $this->render('shared', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all your accessed Task models.
     * @return mixed
     */
    public function actionAccessed()
    {
        $user = Task::find()
            ->innerJoinWith(Task::TASK_USERS)
        ->where(['task_user.user_id' => Yii::$app->user->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $user,
        ]);


        return $this->render('accessed', [
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);


        if( $model->creator_id !==  Yii::$app->user->id &&
            $model->getTaskUsers()->where(['user_id'=>\Yii::$app->user->id])->exists())
        {
                Yii::$app->session->setFlash('error', 'It is a stranger task');
                return $this->redirect(['site/index']);
        }

        if( $model->creator_id === Yii::$app->user->id) {
            $sharedUsers = $model->getTaskUsers();
            $dataProvider = new ActiveDataProvider([
                'query' => $sharedUsers,
            ]);
            $titleTwo = 'Shared the task to ...';



            return $this->render('view', [
                'model' => $model,
                'titleTwo' => $titleTwo,
                'users' => true,
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('view', [
                'model' => $model,
                'titleTwo' => '',
                'users' => false,
                'dataProvider' => false,
        ]);

    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Your creation of a task was success');
            return $this->redirect(['my']);
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->creator_id !==  Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'It is a stranger task');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Your update of a task was success');
            return $this->redirect(['my']);
        }

        return $this->render('update', [
                'model' => $model,
        ]);

    }

    /**
     * Delete an existing Task model.
     * @param integer $id
     * @return mixed
     * @throws
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->creator_id !==  Yii::$app->user->id) {
            Yii::$app->session->setFlash('error', 'It is a stranger task');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if($this->findModel($id)->delete()) {
            Yii::$app->session->setFlash('success', 'Your removal of a task was success');
            return $this->redirect(['my']);
        }
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
