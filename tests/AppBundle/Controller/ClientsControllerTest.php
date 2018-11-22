<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientsControllerTest extends WebTestCase
{

    /**
     * compares all users count at db and rendered users by controller
     */
    public function testIndex()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/guests');
        $userCount = count($client->getContainer()->get('doctrine')->getRepository('AppBundle:Client')->findAll());

        $this->assertCount(
            $userCount,
            $crawler->filter('tr.client'),
            'The guests page displays the right number of guests.'
        );

    }


    /**
     * This test changes the database contents by creating a new client. However,
     * thanks to the DAMADoctrineTestBundle and its PHPUnit listener, all changes
     * to the database are rolled back when this test completes. This means that
     * all the application tests begin with the same database contents.
     */
    public function testAddClient()
    {
        $clientLastName = $this->generateRandomString(100);
        $testAddress = $this->generateRandomString(100);
        $timeStmp = date('Y/m/dH:i:s');
        $testEmail = 'Test@Email'. $timeStmp;

        $client = static::createClient(['environment' => 'test']);


        $crawler = $client->request('GET', '/guests/new');

        $form = $crawler->selectButton('client_form[save]')->form(
            array(
                'client_form[title]' => 'mr',
                'client_form[name]' => 'TestName',
                'client_form[last_name]' => $clientLastName,
                'client_form[address]' => $testAddress,
                'client_form[zip_code]' => '00000',
                'client_form[city]' => 'TestCity',
                'client_form[state]' => 'TestState',
                'client_form[email]' => $testEmail,
            )
        );

        // submit the data to the form directly
        $client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $clientFromDB = $client->getContainer()->get('doctrine')->getRepository(Client::class)->findOneBy([
            'email' => $testEmail,
        ]);
        $this->assertNotNull($clientFromDB);
        $this->assertSame('TestName', $clientFromDB->getName());

    }

    private function generateRandomString($length)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return mb_substr(str_shuffle(str_repeat($chars, ceil($length / mb_strlen($chars)))), 1, $length);
    }

}
