<?php
namespace Application\BannerBundle\Generator;

use Application\BannerBundle\Entity\Banner;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class HtmlGenerator
 */
class GeneratorFactory implements ContainerAwareInterface
{
    /**
     * @var string
     */
    const DEFAULT_GENERATOR_TYPE = 'text';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Generator type file extension mapper
     *
     * @var array
     */
    private $map = array(
        'html' => array('jpg', 'jpeg', 'png', 'gif', 'bmp'),
        'swf'  => array('swf')
    );

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Banner $banner
     *
     * @return AbstractGenerator
     */
    public function create(Banner $banner)
    {
        $type = $this->getGeneratorType($this->getExtension($banner->getImg()));
        $id   = 'banner_generator_' . $type;

        return $this->container->get($id)->setBanner($banner);
    }

    /**
     * @param string $file
     *
     * @return string
     */
    private function getExtension($file)
    {
        $parts = explode('.', $file);

        return strtolower(array_pop($parts));
    }

    /**
     * @param string $extension
     *
     * @return string
     */
    private function getGeneratorType($extension)
    {
        $generatorType = self::DEFAULT_GENERATOR_TYPE;
        foreach ($this->map as $type => $extensions) {
            if (array_search($extension, $extensions) !== false) {
                $generatorType = $type;
                break;
            }
        }

        return $generatorType;
    }
}
