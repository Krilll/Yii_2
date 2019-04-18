<?php

namespace app\controllers;

use app\components\TestService;
use app\models\Product;
use yii\web\Controller;



class TestController extends Controller
{
    /**
     * Displays test page.
     *
     * @return string
     */
    public function actionIndex()
    {
		//$db = Yii::createObject($product);
		//return $db;
		//return \Yii::$app->test->show();
		
		//$text = new TestService(['text' => 'Hello, world!']);
		
		//$text->getId();
		
		//$text = 'Hello, world!';
		
		/*$product = new Product();
		$product -> id = 1;
		$product -> name = 'Hello, world!';
		$product -> category = 'T-shirt';
		$product -> price = 200;*/
		
        return $this->render('index',
		['text' => \Yii::$app->test->show(),
		]);
    }
	
	public function actionInsert()
    {
		//insert
		/*\Yii::$app->db->createCommand()->insert('user', [
			'username' => 'user',
			'password_hash' => 'fewsudjslkf3i2r32',
			'auth_key' => 'user',
			'creator_id' => '1',
			'created_at' => time(),
		]
		)->execute();
		
		\Yii::$app->db->createCommand()->insert('user', [
			'username' => 'user3',
			'password_hash' => 'fewsufdfdi2r32',
			'auth_key' => 'user3',
			'creator_id' => '3',
			'created_at' => time(),
		]
		)->execute();*/
		
		$command = 
		\Yii::$app->db->createCommand()->insert('user', [
			'username' => 'user',
			'password_hash' => 'fewsudjslkf3i2r32',
			'auth_key' => 'user',
			'creator_id' => '1',
			'created_at' => time(),
		]);
		_log($command);
		
		
		/*$command2 = \Yii::$app->db->createCommand()->batchinsert('task', 
			['title', 'description', 'creator_id', 'created_at'], [
			['work', 'Lorem ipsum dolor sit amet.', 1, time()],
			['have a rest', 'Consectetur adipiscing elit.', 2, time()],
			['shopping', 'Sed eu fringilla tellus.', 3, time()],
		])->execute();*/
		
		$command2 = 
		\Yii::$app->db->createCommand()->batchinsert('task', 
			['title', 'description', 'creator_id', 'created_at'], [
			['work', 'Lorem ipsum dolor sit amet.', 1, time()],
			['have a rest', 'Consectetur adipiscing elit.', 2, time()],
			['shopping', 'Sed eu fringilla tellus.', 3, time()],
		]);
		_log($command2);
	}
	
	public function actionSelect()
    {
		$one = (new \yii\db\Query())
			->select('*')
			->from('user')
			->where(['id' => 1])
			->one();
		
		echo 'Запись с id=1 => ';		
		echo \yii\helpers\VarDumper::dumpAsString($one, 5, true);
		
		$two = (new \yii\db\Query())
			->select('*')
			->from('user')
			->where('id > 1')
			->orderBy('username DESC')
			->all();
			
		echo 'Все записи с id>1 отсортированные по имени => ';		
		echo \yii\helpers\VarDumper::dumpAsString($two, 5, true);
		
		$three = (new \yii\db\Query())
			->select('*')
			->from('user')
			->count();	
		echo 'Количество записей => ';		
		echo \yii\helpers\VarDumper::dumpAsString($three, 5);
		
		$four= (new \yii\db\Query())
			->select('*')
			->from('task')
			->innerJoin('user', 'task.creator_id = user.id')
			->all();
			
		echo 'Пользователи => ';		
		echo \yii\helpers\VarDumper::dumpAsString($four, 5, true);
	}
}
