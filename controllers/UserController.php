<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
			/*'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],*/
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
		$model->creator_id = 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	/**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
		
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			
			$log = [
				'levels' => 'info',
				'categories' => 'info',
				'message' => 'Пользователь авторизован.'
			];
			Yii::info($log, 'info'); 
			
            return $this->goBack();
        }

        $model->password = '';
		
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	/**
     * Displays test page.
     *
     * @return string
     */
    public function actionTest()
    {
		// а) Создать запись в таблице user.
		
		/*$user = new User();
		$user->username = 'Qiang';
		$user->password_hash = 'frefefreferfefrerfefe';
		$user->auth_key = 'Qiangdewdwd';
		$user->creator_id = 4;
		$user->created_at = time();

		_log($user->save());*/
		
		//б) Создать три связаные (с записью в user) запиcи в task, используя метод link().

		/*$user = User::findOne(4);
		$task = new task();
		$task->title = 'Hello';
		$task->description = 'Nam eleifend sit amet dui nec scelerisque.';
		$task->created_at = time();
		_log($task->link('creator', $user));*/
		
		/*$user = User::findOne(4);
		$task = new task();
		$task->title = 'Goodbye';
		$task->description = 'Aliquam erat volutpat.';
		$task->created_at = time();
		_log($task->link('creator', $user));*/
		
		/*$user = User::findOne(4);
		$task = new task();
		$task->title = 'Find';
		$task->description = 'Cras interdum porttitor arcu at facilisis.';
		$task->created_at = time();
		_log($task->link('creator', $user));*/
			
		//в) Прочитать из базы все записи из User 
		//применив жадную подгрузку связанных данных из Task, с запросами без JOIN.
		
		/*$tasks = Task::find()
		->with('creator')
		//->limit(4)
		->all();
		
		foreach ($tasks as $task) {
			_log($creator = $task->creator);
		}*/
		
		//г) Прочитать из базы все записи из User 
		//применив жадную подгрузку связанных данных из Task, с запросом содержащим JOIN.

		/*$tasks = Task::find()
		->innerJoinWith('creator')	
		//->limit(4)
		->all();*/
		
		/*$tasks = Task::find()
		->innerJoin('user', '`task`.`creator_id` = `user`.`id`')
		->limit(4)
		->all();*/
		
		/*foreach ($tasks as $task) {
			_log($creator = $task->creator);
		}*/
		
		/*Добавить в Task метод релейшена getAccessedUsers, 
		связывающий Task и User через релейшен taskUsers, 
		проверить - добавить с помощью созданного релейшена 
		связь между записями в Task и User (метод link()) 
		и получить из модели задачи список пользователей которым она доступна.*/
		
		//$task = Task::findOne(3);
		//$user = User::findOne(1);
		//_log($task->link('accessedUsers',$user));
		
		//$user = User::findOne(2);
		//_log($task->link('accessedUsers',$user));
		
		//_end($task->getAccessedUsers()->all());
		
		$user = new User();
		//_end($user->findByUsername('user'));
		
		return $this->render('test');
	}
}
