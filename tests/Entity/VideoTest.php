<?php
/**
 * Created by PhpStorm.
 * Video: Xtrazyx
 * Date: 28/09/2017
 * Time: 17:42
 */

namespace Test\Entity;

use App\Entity\Video;
use App\Entity\Trick;
use PHPUnit\Framework\TestCase;

class VideoTest extends TestCase
{
    public function testGettersSetters()
    {
        $testObject = new Video();
        $testTrick = new Trick();

        $methodTests = array(
            'SourceId' => 'Julien',
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