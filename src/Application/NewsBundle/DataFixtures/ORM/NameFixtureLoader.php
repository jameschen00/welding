<?php
namespace Application\NewsBundle\DataFixtures\ORM;

use Application\NewsBundle\Entity\News;
use Application\NewsBundle\Entity\Section;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class NewsFixtureLoader
 */
class NewsFixtureLoader extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //create place
        $section = new Section();
        $section->setName('News');
        $section->setSlug('news');
        $section->setIsActive(true);
        $manager->persist($section);

        //create news
        $news = new News();
        $news->setTitle('Protecting a wombat species that is as fast as Usain Bolt');
        $news->setShortText('In Australia’s Epping Forest National Park, travellers volunteer to keep tabs on the last remaining northern hairy nosed wombats.');
        $news->setFullText(
            '<div class="intro" itemprop="description"><p>It was not the most glamorous way to spend a week’s holiday: examining, feeling and sniffing wombat scat. But in a strange way, it was also very rewarding.</p></div>
            <p>“Look at the way he’s stacked them! Beautiful, really square,” said Alan Horsup, a scientist with Australia’s <a href="http://www.ehp.qld.gov.au/">Department of the Environment and Heritage Protection</a>.</p><p>Horsup works in northern hairy nosed wombat conservation, which at the time involved holding a piece of wombat excrement between his index finger and thumb. According to scientists, the stacking of the animal’s dung could be a sign of status.</p><p>In central Queensland’s <a href="http://www.ehp.qld.gov.au/wildlife/threatened-species/endangered/northern_hairynosed_wombat/epping_forest_national_park.html">Epping Forest National Park</a>, far from the beaches of a typical tropical holiday, I had volunteered to spend my time off helping scientists conduct population monitoring to determine how many northern hairy nosed wombats still exist.</p><ul><li><strong><a href="http://www.bbc.com/travel/feature/20130409-escaping-the-heat-in-far-north-queensland">Related article: Escaping the heat in Far North Queensland</a></strong></li></ul><p>Scientists believe the number left in the world is about 200 – a slight increase from the mid 1980s when there were only 35 – but the northern hairy nosed wombats remain critically endangered, largely because of competition with cattle and sheep for food, as well as drought and dingo and feral dog attacks. Today, approximately 185 northern hairy nosed wombats reside at Epping Forest and another 15 live in the 105-hectare Richard Underwood Nature Refuge nearby, making these the only northern hairy nosed colonies in the world. Northern hairy nosed wombats can only be found in the wild; their shy natures making the nocturnal marsupials ill-prepared to cope with the stress of captivity.</p><p><span>There are two other <a href="http://www.ehp.qld.gov.au/wildlife/threatened-species/endangered/northern_hairynosed_wombat/">species of wombat</a>, the common (or bare-nosed) wombat, which is not endangered and is found on the southeastern coast of Australia (in New South Wales, Victoria and Tasmania) and the southern hairy nosed wombat, which is endangered and is found in arid, sandy pockets in the southern part of Australia (in South Australia and Western Australia).</span> The Northern hairy nosed wombat is the largest of all the three species, weighing up to 40kg and measuring about 1m long (the females are slightly heavier than the males).</p><p>Originally hailing from the coast city of Sydney, I was unused to the dry, tropical landscape of central Queensland. Although it was only about 10 am, it was already hot, hitting about 30C and it would head to 38C by midday.</p><p>Scientists only invite a handful of volunteers throughout the year to participate in the programme &nbsp;and interested parties have to apply for a government permit to enter the reserve . In addition to population monitoring, volunteers check for breakage in the 2m-high, 20km-long, 1m-deep anti-dingo and dog fence that surrounds the park, and fill up water containers placed around the reserve for the wombats each day. In this arid environment, water is key – but the latter job can feel unnecessary when you realise the animals rarely seem to drink, preferring to get their fluid from the grass they eat, and staying cool in their burrows during the day.</p><p>Volunteer caretakers, who need to be familiar with living in the bush, managing a remote reserve and knowing what to do if there is an emergency, are required to live in the park for about a month at a time, reporting on bush fires and recording data taken from cameras at the wombat watering stations.</p><p>On my first day, as Horsup and I headed out from camp in search of wombat evidence, whistling kite birds were circling above, indicating a dead animal nearby – perhaps a kangaroo, possibly a wombat. Puffball fungi grew from the dusty soil and dead cane toad carcasses were turned upside down, the birds having learned to avoid the pest’s toxic chemicals by eating them from underneath. We were careful to watch for black-headed pythons as we walked.</p><p>We came to a hummocky, undulating area of soil about 10sqm beside a gidgee tree. Hairy nosed wombats often choose to dig their burrows, made up of a series of tunnels, below these acacia trees, also known as stinking wattle as they smell like sour cabbage. Scientists think the wombats use the tree’s roots to give their home structural strength in the sandy soil, and they dig them out using their very strong, muscular bodies and sharp claws.</p>'
        );
        $news->setIsActive(true);
        $news->setSection($section);
        $this->uploadFile($news, '1.jpg');
        $manager->persist($news);

        $manager->flush();
    }

    /**
     * Upload file
     *
     * @param Image  $news
     * @param string $fixture
     */
    private function uploadFile(News $news, $fixture)
    {
        $path = dirname(dirname(dirname(__FILE__))) . '/Resources/public/fixture/';
        copy($path . $fixture, $path . '_' . $fixture);
        $uploadedFile = new UploadedFile($path . '_' . $fixture, $fixture, null, null, null, true);

        $news->setFile($uploadedFile);
    }

}
