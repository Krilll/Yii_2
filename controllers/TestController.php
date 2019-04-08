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
    
}
