<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 28/09/2017
 * Time: 17:42
 */

namespace Test\Entity;

use App\Entity\User;
use App\Entity\Avatar;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGettersSetters()
    {
        $testObject = new User();
        $testAvatar = new Avatar();

        $methodTests = array(
            'FirstName' => 'Julien',
            'LastName' => 'Habert',
            'Email' => 'julien@habert.fr',
            'Password' => 'jojo22_2',
            'Role' => 'ROLE',
            'Avatar' => $testAvatar
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