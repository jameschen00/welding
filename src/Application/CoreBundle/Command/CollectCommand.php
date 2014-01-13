<?php
namespace Application\CoreBundle\Command;

use Application\ShopBundle\Entity\ProductPropertyArray;
use Application\ShopBundle\Entity\ProductPropertyText;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Collect all metrics for all projects or selected project
 */
class CollectCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('metrix:collect')
            ->setDescription('Collect metrics')
            ->addArgument(
                'project',
                InputArgument::OPTIONAL,
                'What project do you want to collect?'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        set_time_limit(0);

        $doctrine = $this->getContainer()->get('doctrine');
        $manager = $doctrine->getManager();

        $products  = $doctrine->getRepository('ApplicationShopBundle:Product')->findBy(array(), array(), 5000, 0);

        $i=0;
        while (count($products)) {
            $product = array_shift($products);

            $values = $doctrine->getRepository('ApplicationShopBundle:Values')->findBy(array('id' => $product->getId()));

            foreach ($values as $value) {
                $product  = $doctrine->getRepository('ApplicationShopBundle:Product')->find($value->getId());
                $property = $doctrine->getRepository('ApplicationShopBundle:Property')->find($value->getPropId());
                if ($product && $property) {
                    $propertyValue = new ProductPropertyArray();
                    $propertyValue->setValue($value->getValue());
                    $propertyValue->setProperty($property);

                    //add to product
                    $product->addProperty($propertyValue);
                    $manager->persist($product);
                }
            }

            echo ($i++)."\n";
            flush();
        }
        $manager->flush();


        exit('111111');
    }
}
