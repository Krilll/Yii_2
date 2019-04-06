<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Product;

class TestController extends Controller
{
    /**
     * Displays test page.
     *
     * @return string
     */
    public function actionIndex()
    {
		$text = 'Hello, world!';
		
		$product = new Product();
		$product -> id = 1;
		$product -> name = 'Hello, world!';
		$product -> category = 'T-shirt';
		$product -> price = 200;
		
        return $this->render('index',
		['text' => $text,
		'product' => $product,
		]);
    }

   


    
}
