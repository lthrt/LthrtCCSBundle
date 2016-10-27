<?php

namespace Lthrt\CCSBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiControllerTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertTrue($client->getResponse()->isOk());
        $this->assertTrue($client->getResponse() instanceof JsonResponse);
    }

    public function urlProvider()
    {
        return [
            ['/county/city/Portland'],
            ['/county/state/OR'],
            ['/county/city/Portland/state/OR'],
            ['/county/state/OR/city/Portland'],
            ['/county/zip/97220'],
            ['/county/city/Portland/zip/97220'],
            ['/county/zip/97220/city/Portland'],
            ['/county/state/OR/zip/97220'],
            ['/county/zip/97220/state/OR'],
            ['/county/city/Portland/state/OR/zip/97220'],
            ['/county/state/OR/city/Portland/zip/97220'],
            ['/county/city/Portland/zip/97220/state/OR'],
            ['/county/zip/97220/city/Portland/state/OR'],
            ['/county/state/OR/zip/97220/city/Portland'],
            ['/county/zip/97220/state/OR/city/Portland'],
            ['/city/county/Multnomah'],
            ['/city/state/OR'],
            ['/city/county/Multnomah/state/OR'],
            ['/city/state/OR/county/Multnomah'],
            ['/city/zip/97220'],
            ['/city/county/Multnomah/zip/97220'],
            ['/city/zip/97220/county/Multnomah'],
            ['/city/state/OR/zip/97220'],
            ['/city/zip/97220/state/OR'],
            ['/city/county/Multnomah/state/OR/zip/97220'],
            ['/city/state/OR/county/Multnomah/zip/97220'],
            ['/city/county/Multnomah/zip/97220/state/OR'],
            ['/city/zip/97220/county/Multnomah/state/OR'],
            ['/city/state/OR/zip/97220/county/Multnomah'],
            ['/city/zip/97220/state/OR/county/Multnomah'],
            ['/state/county/Multnomah'],
            ['/state/city/Portland'],
            ['/state/city/Portland/county/Multnomah'],
            ['/state/county/Multnomah/city/Portland'],
            ['/state/zip/97220'],
            ['/state/county/Multnomah/zip/97220'],
            ['/state/zip/97220/county/Multnomah'],
            ['/state/city/Portland/zip/97220'],
            ['/state/zip/97220/city/Portland'],
            ['/state/city/Portland/county/Multnomah/zip/97220'],
            ['/state/county/Multnomah/city/Portland/zip/97220'],
            ['/state/city/Portland/zip/97220/county/Multnomah'],
            ['/state/zip/97220/city/Portland/county/Multnomah'],
            ['/state/county/Multnomah/zip/97220/city/Portland'],
            ['/state/zip/97220/county/Multnomah/city/Portland'],
            ['/zip/county/Multnomah'],
            ['/zip/city/Portland'],
            ['/zip/city/Portland/county/Multnomah'],
            ['/zip/county/Multnomah/city/Portland'],
            ['/zip/state/OR'],
            ['/zip/county/Multnomah/state/OR'],
            ['/zip/state/OR/county/Multnomah'],
            ['/zip/city/Portland/state/OR'],
            ['/zip/state/OR/city/Portland'],
            ['/zip/city/Portland/county/Multnomah/state/OR'],
            ['/zip/county/Multnomah/city/Portland/state/OR'],
            ['/zip/city/Portland/state/OR/county/Multnomah'],
            ['/zip/state/OR/city/Portland/county/Multnomah'],
            ['/zip/county/Multnomah/state/OR/city/Portland'],
            ['/zip/state/OR/county/Multnomah/city/Portland'],
        ];
    }
}
