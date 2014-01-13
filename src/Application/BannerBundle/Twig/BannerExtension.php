<?php
namespace Application\BannerBundle\Twig;

use Application\BannerBundle\Entity\Place;
use Application\CoreBundle\Manager\ManagerFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Twig banner extension for show banners by place
 *
 * <code>
 * {{1|place}}
 * {{place(1)}}
 * </code>
 */
class BannerExtension extends \Twig_Extension
{
    /**
     * @var ManagerFactory
     */
    private $managerFactory;

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('banner', array($this, 'getHtml'), array(
                'is_safe' => array('html')
            ))
        );
    }

    /**
     * @param int $place
     *
     * @return string
     */
    public function getHtml($place)
    {
        $html = '';
        if ($this->isRobot()) {
            return $html;
        }

        //get banners
        $manager = $this->managerFactory->get('banner_banner');
        $banners = $manager->setPlace($place)->where()->order()->findAll();
        if (empty($banners)) {
            return $html;
        }

        //get place
        $place = $banners[0]->getPlace();
        /* @var $place \Application\BannerBundle\Entity\Place */
        //range banners
        $banners = $this->rangeBannersByPriority($banners, $place);
        //render html
        $html = array();
        foreach ($banners as $banner) {
            $html[] = $place->getScontainer() . $banner->getCode() . $place->getEcontainer();
        }

        return join($place->getBseparator(), $html);
    }

    /**
     * Check http headers to user-agent
     *
     * @return boolean
     */
    private function isRobot()
    {
        $request = Request::createFromGlobals();
        $pattern = '/google|yandex|rambler|yahoo|bigmir|meta|msn|spider|crawler|bot|stack/i';

        return preg_match($pattern, $request->headers->get('User-Agent'));
    }

    /**
     * Range banners by priority and max count in place
     *
     * @param array $banners
     * @param Place $place
     *
     * @return array
     */
    private function rangeBannersByPriority($banners, Place $place)
    {
        //range banners by priority
        $sum = $prev = $max = 0;
        foreach ($banners as $banner) {
            $sum += $banner->getPriority();
        }

        $priority = array();
        foreach ($banners as $i => $banner) {
            $prev = $priority[$i] = $prev + $banner->getPriority() / $sum;
            if ($max < $banner->getPriority()) {
                $max = $banner->getPriority();
            }
        }

        //define banners to show
        $bannersToShow = array();
        for ($i = 0; $i < ($place->getCount() ? $place->getCount() : 99999); $i++) {
            $random = rand(0, $max) / $max;
            foreach ($priority as $i => $p) {
                if ($random <= $p) {
                    $bannersToShow[] = $banners[$i];
                    unset($priority[$i]);
                    break;
                }
            }
        }

        return $bannersToShow;
    }

    /**
     * @param ManagerFactory $factory
     */
    public function setManagerFactory(ManagerFactory $factory)
    {
        $this->managerFactory = $factory;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'banner';
    }
}