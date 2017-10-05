<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 04/10/2017
 * Time: 12:31
 */

namespace App\Tests\Form;

use App\Entity\Trick;
use App\Form\TrickType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\Test\TypeTestCase;

class TrickTypeTest extends TypeTestCase
{
    public function testValidFormData()
    {
        // Mocks
        // TODO Mocking or Using Traversable or ArrayAccess is deprecated since 3.1, use Array instead
        $mockCollection = new ArrayCollection();

        $formData = array(
            'name' => 'triple salto',
            'description' => 'super description détaillée',
            'group' => 'group1',
            'trickImages' => $mockCollection,
            'videos' => $mockCollection
        );

        $form = $this->factory->create(TrickType::class);
        $trickTest = Trick::newFromArray($formData);

        $form->submit($formData);

        // Testing values through data transformers
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($trickTest, $form->getData());

        // Testing form elements in view
        $view = $form->createView();
        $children = $view->children;

        foreach(array_keys($formData) as $key)
        {
            $this->assertArrayHasKey($key, $children);
        }

    }
}