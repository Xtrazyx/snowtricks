<?php
/**
 * Created by PhpStorm.
 * Video: Xtrazyx
 * Date: 28/09/2017
 * Time: 17:42
 */

namespace Test\Entity;

use App\Entity\Group;
use App\Entity\Post;
use App\Entity\TrickImage;
use App\Entity\Video;
use App\Entity\Trick;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

class TrickTest extends TestCase
{
    public function testGettersSetters()
    {
        $testObject = new Trick();
        $testGroup = $this->createMock(Group::class);
        $testPost = $this->createMock(Post::class);
        $testPosts = $this->createMock(ArrayCollection::class);
        $testVideo =  $this->createMock(Video::class);
        $testVideos = $this->createMock(ArrayCollection::class);
        $testTrickImage = $this->createMock(TrickImage::class);
        $testTrickImages = $this->createMock(ArrayCollection::class);;

        // Methods parameters for testing getters and setters
        $methodTests = array(
            'Name' => 'Triple salto arrière groupé',
            'Description' => 'Une incroyable figure',
            'Group' => $testGroup,
            'Posts' => $testPosts,
            'TrickImages' => $testTrickImages,
            'Videos' => $testVideos
        );

        // Testing getters and setters
        foreach ($methodTests as $key => $value)
        {
            $setMethod = 'set' . $key;
            $getMethod = 'get' . $key;
            $testObject->$setMethod($value);
            $this->assertEquals($value, $testObject->$getMethod());
        }

        // Methods parameters for testing add and remove from ArrayCollection
        $methodTests = array(
            'Post' => $testPost,
            'Video' => $testVideo,
            'TrickImage' => $testTrickImage
        );

        // Testing add and remove
        foreach ($methodTests as $key => $value)
        {
            $addMethod = 'add' . $key;
            $removeMethod = 'remove' . $key;
            $testObject->$addMethod($value);
            $testObject->$removeMethod($value);
        }
    }
}