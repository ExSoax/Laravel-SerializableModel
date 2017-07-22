<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Request;
use \ReflectionClass;

trait SerializableModel {
  public function __construct($default = true){
    if($default)
    {
      $model = self::model();
      $reflector = new ReflectionClass(self::class);
      foreach($reflector->getProperties() as $property)
        $this->{$property->name} = $model->{$property->name};
    }
  }

  public static function model(\Illuminate\Http\Request $request = null){
    if(!isset(self::$ToSerialize))
      throw new \Exception("You must implement 'protected static \$ToSerialize' in your SerializableModel.");

    /*Retrieve class data*/
    $class = self::class;
    $reflector = new ReflectionClass($class);
    $properties = $reflector->getProperties();
    $object = new $class(false);

    /*Set properties in new object*/
    foreach(self::$ToSerialize as $field){
        if(any($properties, function($x) use ($field){ return $x->name == $field; }))
          $object->{$field} = isset($request) ? $request->input($field) : Request::input($field);
    }

    return $object;
  }
}
