<?php
namespace Application\BannerBundle\DataFixtures\ORM;

use Application\BannerBundle\Entity\Banner;
use Application\BannerBundle\Entity\Brand;
use Application\BannerBundle\Entity\Category;
use Application\BannerBundle\Entity\Place;
use Application\BannerBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ProductFixtureLoader
 */
class BannerFixtureLoader extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //create place
        $place = new Place();
        $place->setName('Banner on main');
        $place->setCount(10);
        $place->setIsActive(true);
        $place->setBseparator('</li><li>');
        $place->setScontainer('<ul>');
        $place->setEcontainer('</ul>');
        $place->setWidth(998);
        $place->setHeight(300);
        $manager->persist($place);

        //create banner
        $path         = dirname(dirname(dirname(__FILE__))).'/Resources/public/fixture/';
        copy($path . 'fixture2.jpg', $path.'_fixture2.jpg');
        $uploadedFile = new UploadedFile($path . '_fixture2.jpg', 'fixture.jpg', null, null, null, true);

        $banner = new Banner();
        $banner->setUrl('http://google.com');
        $banner->setStartDate(new \DateTime());
        $banner->setStopDate(new \DateTime('2020-12-12'));
        $banner->setIsActive(true);
        $banner->setFile($uploadedFile);
        $banner->setPlace($place);
        $manager->persist($banner);

        //create another banner
        copy($path . 'fixture1.png', $path.'_fixture1.png');
        $uploadedFile = new UploadedFile($path . '_fixture1.png', 'fixture.png', null, null, null, true);

        $banner = new Banner();
        $banner->setUrl('http://images.google.com');
        $banner->setStartDate(new \DateTime());
        $banner->setStopDate(new \DateTime('2020-12-12'));
        $banner->setIsActive(true);
        $banner->setFile($uploadedFile);
        $banner->setPlace($place);
        $manager->persist($banner);

        $manager->flush();
    }
}
