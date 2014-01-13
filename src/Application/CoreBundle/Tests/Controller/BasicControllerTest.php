<?php
namespace Application\UserBundle\Tests\Manager;

use Application\CoreBundle\Library\Test\AbstractApplicationTest;

/**
 * Test all pages by list of routers
 */
class BasicControllerTest extends AbstractApplicationTest
{
    /**
     * @param string $path
     *
     * @dataProvider urlProvider
     */
    public function testUrl($path)
    {
        $client = static::createClient();
        $client->request('GET', $path);
        $this->assertFalse($client->getResponse()->isServerError());
    }

    /**
     * @return array
     */
    public function urlProvider()
    {
        static::createClient();
        $container = static::$kernel->getContainer();

        $router = $container->get('router');
        $collection = $router->getRouteCollection(); /** @var $collection \Symfony\Component\Routing\RouteCollection */

        $result = array();

        /* @var $router \Symfony\Component\Routing\Route */
        foreach ($collection as $name => $router) {
            if (preg_match('#^_#', $name)) {
                continue;
            }

            $path = $router->getPath();
            foreach ($router->getRequirements() as $key => $params) {
                $value = '';
                if ($params == '\d+') {
                    $value = rand(1, 1000);
                } else {
                    $value = md5(uniqid());
                }
                $path = str_replace('{'.$key.'}', $value, $path);

                if (preg_match_all('#\{([^\}]+)\}#', $path, $match, PREG_PATTERN_ORDER)) {
                    if (!empty($match[1])) {
                        foreach ($match[1] as $m) {
                            $path = str_replace('{'.$m.'}', md5(uniqid()), $path);
                        }
                    }
                }
            }

            $result[] = array($path);
        }

        return $result;
    }

}
