<?php
namespace Application\BannerBundle\EventListener;

use Application\BannerBundle\Entity\Banner;
use Application\BannerBundle\Generator\GeneratorFactory;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class GeneratorListener
 */
class GeneratorListener
{
    /**
     * @var GeneratorFactory
     */
    private $generatorFactory;

    /**
     * @param GeneratorFactory $generatorFactory
     */
    public function setGeneratorFactory(GeneratorFactory $generatorFactory)
    {
        $this->generatorFactory = $generatorFactory;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity        = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if ($entity instanceof Banner) {

            $code = $this->generatorFactory->create($entity)->generate();

            $entity->setCode($code);
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }
}