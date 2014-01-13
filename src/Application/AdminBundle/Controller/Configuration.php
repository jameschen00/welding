<?php
namespace Application\AdminBundle\Controller;

/**
 * Base controller configurator
 */
class Configuration
{
    /**
     * @var string
     */
    private $templateUpdate = 'ApplicationAdminBundle:Abstract:update.html.twig';

    /**
     * @var string
     */
    private $templateCreate = 'ApplicationAdminBundle:Abstract:update.html.twig';

    /**
     * @var string
     */
    private $templateIndex = 'ApplicationAdminBundle:Abstract:index.html.twig';

    /**
     * @var string
     */
    private $pageTitle = 'page.abstract.title';

    /**
     * @var string
     */
    private $manager;

    /**
     * @param string $pageTitle
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;
    }

    /**
     * @return string
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * @param string $templateCreate
     *
     * @return Configuration
     */
    public function setTemplateCreate($templateCreate)
    {
        $this->templateCreate = $templateCreate;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateCreate()
    {
        return $this->templateCreate;
    }

    /**
     * @param string $templateIndex
     *
     * @return Configuration
     */
    public function setTemplateIndex($templateIndex)
    {
        $this->templateIndex = $templateIndex;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateIndex()
    {
        return $this->templateIndex;
    }

    /**
     * @param string $templateUpdate
     *
     * @return Configuration
     */
    public function setTemplateUpdate($templateUpdate)
    {
        $this->templateUpdate = $templateUpdate;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplateUpdate()
    {
        return $this->templateUpdate;
    }

    /**
     * @param string $template
     *
     * @return Configuration
     */
    public function setTemplateUpdateAndCreatePath($template)
    {
        $this->templateUpdate = $this->templateCreate = $template;

        return $this;
    }

    /**
     * @param string $manager
     *
     * @return $this
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return \Application\CoreBundle\Library\Manager\ManagerInterface
     */
    public function getManager()
    {
        return $this->manager;
    }
}