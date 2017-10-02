<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 28/09/2017
 * Time: 17:42
 */

namespace Test\Entity;

use App\Entity\Group;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    public function testGetSetName()
    {
        $group = new Group();
        $group->setName('Test Name');

        $this->assertEquals('Test Name', $group->getName());
    }
}