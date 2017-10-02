<?php
/**
 * Created by PhpStorm.
 * TrickImage: Xtrazyx
 * Date: 28/09/2017
 * Time: 17:42
 */

namespace Test\Entity;

use App\Entity\Trick;
use App\Entity\TrickImage;
use PHPUnit\Framework\TestCase;

class TickImageTest extends TestCase
{
    public function testGettersSetters()
    {
        $testObject = new TrickImage();
        $testTrick = new Trick();

        $methodTests = array(
            'Url' => '/img/photo.jpg',
            'Alt' => 'une bien belle photo',
            'FileName' => 'c:\\temp\\img266.jpg',
            'Trick' => $testTrick
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