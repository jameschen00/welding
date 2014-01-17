<?php
namespace Application\BannerBundle\Generator;

/**
 * Class TextGenerator
 */
class TextGenerator extends AbstractGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        return '<a href="' . $this->banner->getUrl() . '">'.$this->banner->getName().'</a>';
    }
}
