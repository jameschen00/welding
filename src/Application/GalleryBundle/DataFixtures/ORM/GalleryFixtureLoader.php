<?php
namespace Application\GalleryBundle\DataFixtures\ORM;

use Application\GalleryBundle\Entity\Image;
use Application\GalleryBundle\Entity\Section;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ProductFixtureLoader
 */
class GalleryFixtureLoader extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //create place
        $section1 = new Section();
        $section1->setName('Nature');
        $section1->setIsActive(true);
        $manager->persist($section1);

        $section2 = new Section();
        $section2->setName('Waterfall');
        $section2->setIsActive(true);
        $manager->persist($section2);

        //create images
        $image = new Image();
        $image->setName('River in Ukraine');
        $image->setDescription('The Dnieper River is one of the major rivers of Europe (fourth by length), rising near Smolensk and flowing through Russia, Belarus and Ukraine to the Black Sea. The total length is 2,145 kilometres (1,333 mi)[1] with a drainage basin of 504,000 square kilometres (195,000 sq mi). The river is noted for its dams and hydroelectric stations. The Dnieper is an important navigable waterway for the economy of Ukraine and is connected via the Dnieper-Bug Canal to other waterways in Europe.
In antiquity, the river was known to the Greeks as the Borysthenes and was part of the Amber Road. Arheimar, a capital of the Goths, was located on the Dnieper, according to the Hervarar saga.');
        $image->setIsActive(true);
        $image->setSection($section1);
        $this->uploadFile($image, '2.jpg');
        $manager->persist($image);

        //create another image
        $image = new Image();
        $image->setName('Nature in Ukraine');
        $image->setDescription('The Dnieper River is one of the major rivers of Europe (fourth by length), rising near Smolensk and flowing through Russia, Belarus and Ukraine to the Black Sea. The total length is 2,145 kilometres (1,333 mi)[1] with a drainage basin of 504,000 square kilometres (195,000 sq mi). The river is noted for its dams and hydroelectric stations. The Dnieper is an important navigable waterway for the economy of Ukraine and is connected via the Dnieper-Bug Canal to other waterways in Europe.
In antiquity, the river was known to the Greeks as the Borysthenes and was part of the Amber Road. Arheimar, a capital of the Goths, was located on the Dnieper, according to the Hervarar saga.');
        $image->setIsActive(true);
        $image->setSection($section1);
        $this->uploadFile($image, '3.jpg');
        $manager->persist($image);


        //create another image
        $image = new Image();
        $image->setName('Shypit waterfall');
        $image->setDescription('Shypit is a famous waterfall where an annual festival is held with the same name, attracting thousands of tourists each year. The festival has taken place every year since 1993. The waterfall is created by Pylypets River, a tributary of Repynka River.');
        $image->setIsActive(true);
        $image->setSection($section2);
        $this->uploadFile($image, '1.jpg');
        $manager->persist($image);

        $manager->flush();
    }

    /**
     * Upload file
     *
     * @param Image  $image
     * @param string $fixture
     */
    private function uploadFile(Image $image, $fixture)
    {
        $path = dirname(dirname(dirname(__FILE__))) . '/Resources/public/fixture/';
        copy($path . $fixture, $path . '_' . $fixture);
        $uploadedFile = new UploadedFile($path . '_' . $fixture, $fixture, null, null, null, true);

        $image->setFile($uploadedFile);
    }

}
