<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 04/10/2017
 * Time: 12:31
 */

namespace App\Tests\Form;

use App\Entity\TrickImage;
use App\Form\TrickImageType;
use Symfony\Component\Form\Test\TypeTestCase;

class TrickImageTypeTest extends TypeTestCase
{
    public function testValidFormData()
    {
        $formData = array(
          'fileName' => 'myfile.jpg'
        );

        $form = $this->factory->create(TrickImageType::class);

        $form->submit($formData);
        $trickImageTest = TrickImage::newFromArray($formData);

        // Testing values through data transformers
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($trickImageTest, $form->getData());

        // Testing form elements in view
        $view = $form->createView();
        $children = $view->children;

        foreach(array_keys($formData) as $key)
        {
            $this->assertArrayHasKey($key, $children);
        }

    }
}