<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 04/10/2017
 * Time: 12:31
 */

namespace App\Tests\Form;

use App\Entity\Video;
use App\Form\VideoType;
use Symfony\Component\Form\Test\TypeTestCase;

class VideoTypeTest extends TypeTestCase
{
    public function testValidFormData()
    {
        $formData = array(
          'sourceId' => 'ghwxzp'
        );

        $form = $this->factory->create(VideoType::class);

        $form->submit($formData);
        $videoTest = Video::newFromArray($formData);

        // Testing values through data transformers
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($videoTest, $form->getData());

        // Testing form elements in view
        $view = $form->createView();
        $children = $view->children;

        foreach(array_keys($formData) as $key)
        {
            $this->assertArrayHasKey($key, $children);
        }

    }
}