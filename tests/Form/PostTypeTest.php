<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 04/10/2017
 * Time: 12:31
 */

namespace App\Tests\Form;


use App\Form\PostType;
use Symfony\Component\Form\Test\TypeTestCase;

class PostTypeTest extends TypeTestCase
{
    public function testValidFormData()
    {
        $formData = array(
          'content' => 'Bonjour bonsoir, ça va ?'
        );

        $form = $this->factory->create(PostType::class);

        $form->submit($formData);

        // Testing values through data transformers
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData, $form->getData());

        // Testing form elements in view
        $view = $form->createView();
        $children = $view->children;

        foreach(array_keys($formData) as $key)
        {
            $this->assertArrayHasKey($key, $children);
        }

    }
}