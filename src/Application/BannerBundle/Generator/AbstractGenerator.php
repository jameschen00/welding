<?php
namespace Application\BannerBundle\Generator;

use Application\BannerBundle\Entity\Banner;

/**
 * Class AbstractGenerator
 */
abstract class AbstractGenerator
{
    /**
     * @var Banner
     */
    protected $banner;

    /**
     * @param Banner $banner
     *
     * @return $this
     */
    public function setBanner(Banner $banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function generate();
}
