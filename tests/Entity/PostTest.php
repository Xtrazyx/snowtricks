<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 28/09/2017
 * Time: 17:42
 */

namespace Test\Entity;

use App\Entity\Post;
use App\Entity\Trick;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function testGettersSetters()
    {
        $testObject = new Post();
        $testUser = new User();
        $testTrick = new Trick();
        $testDate = new \DateTime();

        $methodTests = array(
            'DateCreation' => $testDate,
            'Content' => '/img/photo.jpg',
            'User' => $testUser,
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