<?php 
echo '<pre>';

class person{
    var $title;

    public function sayhi(){
        echo 'hi person';
    }

    protected function eat(){
        echo 'eating';
    }

    private function paymoney(){
        echo 'pay money';
    }
}


$person=new person();
$person->sayhi();
echo '<hr>';

$ReflectionClass = new ReflectionClass('person');
$instance  = $ReflectionClass->newInstanceArgs();
$instance->sayhi();
echo '<hr>';


class human extends ReflectionClass{
    public function __construct(){
        $ReflectionClass = new ReflectionClass('person');
        $instance  = $ReflectionClass->newInstanceArgs();
        $methods=$ReflectionClass->getMethods(ReflectionMethod::IS_STATIC | ReflectionMethod::IS_PUBLIC);
        if($methods){
            foreach($methods as $method){
                $ReflectionClass->getmethod($method->name)->invoke($instance);
            }
        }
        return $instance;
    }
}

$human=new human();
// print_r($human);
exit;

