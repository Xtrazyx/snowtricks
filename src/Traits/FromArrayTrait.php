<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 04/10/2017
 * Time: 14:04
 */

namespace App\Traits;

trait FromArrayTrait
{
    /**
     * Return an instance of the called class with property values passed through an array
     *
     * @param $array array
     * @throws \Exception
     * @return object
     */
    static public function newFromArray($array)
    {
        if(class_exists($className = get_called_class()))
        {
            $newClass = new $className();

            foreach($array as $key => $value)
            {
                if(property_exists($className, $key))
                {
                    $setKey = 'set' . ucfirst($key);
                    if(method_exists($newClass, $setKey))
                    {
                        $newClass->$setKey($value);
                    }else{
                        throw new \Exception(
                            'La méthode: '. $setKey .'n\'existe pas.'
                        );
                    }

                }else{
                    throw new \Exception('La propriété ' . $key . ' n\'existe pas !');
                }
            }
            return $newClass;
        }else{
            throw new \Exception('La classe ' . $className . ' n\'existe pas !');
        }
    }
}
