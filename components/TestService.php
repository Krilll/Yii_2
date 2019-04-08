<?php

namespace app\components;

use yii\base\Component;

class TestService extends Component
{
    public $text = '404';
	
	public function show()
    {
        return $this->text; 
    }
}