<?php

namespace app\controllers;

use app\components\TestService;
use app\models\User;
use app\models\Task;
use app\models\TaskUser;
use yii\web\Controller;

class UserController extends Controller
{
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
		->limit(4)
		->all();
		
		foreach ($tasks as $task) {
			_log($creator = $task->creator);
		}*/
		
		//г) Прочитать из базы все записи из User 
		//применив жадную подгрузку связанных данных из Task, с запросом содержащим JOIN.
		
		/*$tasks = Task::find()
		->innerJoin('user', '`task`.`creator_id` = `user`.`id`')
		->limit(4)
		->all();
		
		foreach ($tasks as $task) {
			_log($creator = $task->creator);
		}*/
		
		/*Добавить в Task метод релейшена getAccessedUsers, 
		связывающий Task и User через релейшен taskUsers, 
		проверить - добавить с помощью созданного релейшена 
		связь между записями в Task и User (метод link()) 
		и получить из модели задачи список пользователей которым она доступна.*/
		
		$task = Task::findOne(3);
		//$user = User::findOne(1);
		//_log($task->link('accessedUsers',$user));
		
		//$user = User::findOne(2);
		//_log($task->link('accessedUsers',$user));
		
		//_end($task->getAccessedUsers()->all());
		
		return $this->render('test');
    }
}
