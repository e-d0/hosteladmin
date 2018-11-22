<?php
/*
namespace AppBundle\Form;

use AppBundle\Form\ClientFormType;
use AppBundle\Entity\Client;
use Symfony\Component\Form\Test\TypeTestCase;


class ClientFormTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {

        $clientLastName = $this->generateRandomString(100);
        $testAddress = $this->generateRandomString(100);

        $formData = array(
            'client_form[title]' => 'mr',
            'client_form[name]' => 'TestName',
            'client_form[last_name]' => $clientLastName,
            'client_form[address]' => $testAddress,
            'client_form[zip_code]' => '00000',
            'client_form[city]' => 'TestCity',
            'client_form[state]' => 'TestState',
            'client_form[email]' => 'Test@Email',
        );

        $form = $this->factory->create(ClientFormType::class);



        $object = new Client;
        $object ->  setTitle($formData['client_form[title]']);
        $object ->  setName($formData['client_form[name]']);
        $object ->  setLastName($formData['client_form[last_name]']);
        $object ->  setAddress($formData['client_form[address]']);
        $object ->  setZipCode($formData['client_form[zip_code]']);
        $object ->  setCity($formData['client_form[city]']);
        $object ->  setState($formData['client_form[state]']);
        $object ->  setEmail($formData['client_form[email]']);

        // submit the data to the form directly
        $form->submit($object);
        dump($form->getData());
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object , $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    private function generateRandomString($length)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return mb_substr(str_shuffle(str_repeat($chars, ceil($length / mb_strlen($chars)))), 1, $length);
    }
}*/
