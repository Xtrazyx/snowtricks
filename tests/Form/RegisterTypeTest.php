<?php
/**
 * Created by PhpStorm.
 * User: Xtrazyx
 * Date: 04/10/2017
 * Time: 12:31
 */

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\Form\Test\TypeTestCase;

class RegisterTypeTest extends TypeTestCase
{
    public function testValidFormData()
    {
        $formData = array(
            'lastName' => 'Jojo',
            'firstName' => 'l\'asticot',
            'email' => 'jojo@asticot.fr',
            'password' => 'robertoJJ666',
            'avatar' => 'myAvatar.jpg',
            'role' => 'ROLE_USER'
        );

        $form = $this->factory->create(RegisterType::class);
        $userTest = User::newFromArray($formData);

        $form->submit($formData);

        // Testing values through data transformers
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($userTest, $form->getData());

        // Testing form elements in view
        $view = $form->createView();
        $children = $view->children;

        foreach(array_keys($formData) as $key)
        {
            $this->assertArrayHasKey($key, $children);
        }

    }
}