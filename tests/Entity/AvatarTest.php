<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 28/09/2017
 * Time: 17:42
 */

namespace Test\Entity;

use App\Entity\Avatar;
use PHPUnit\Framework\TestCase;

class AvatarTest extends TestCase
{
    public function testGettersSetters()
    {
        $testObject = new Avatar();

        $methodTests = array(
            'Url' => '/img/photo.jpg',
            'Alt' => 'une bien belle photo',
            'FileName' => 'c:\\temp\\img266.jpg'
        );

        // Testing getters and setters
        foreach ($methodTests as $key => $value)
        {
            $setMethod = 'set' . $key;
            $getMethod = 'get' . $key;
            $testObject->$setMethod($value);
            $this->assertEquals($value, $testObject->$getMethod());
        }
    }
}