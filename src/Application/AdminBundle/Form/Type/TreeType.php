<?php
namespace Application\AdminBundle\Form\Type;

use Application\CoreBundle\Helper\OptionsHelper;
use Application\CoreBundle\Helper\TreeHelper;
use Application\CoreBundle\Library\Manager\ManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Tree field for forms
 */
class TreeType extends AbstractType
{
    /**
     * @var \Application\CoreBundle\Library\Manager\ManagerAbstract
     */
    private $manager = null;

    /**
     * @var null|string
     */
    private $pid = 'pid';

    /**
     * @param ManagerInterface $manager
     * @param int              $pid
     */
    public function __construct(ManagerInterface $manager, $pid = null)
    {
        $this->manager = $manager;
        $pid && $this->pid = $pid;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $entities = $this->manager->findAll();

        $helperTree = new TreeHelper(array(
            'id' => $this->manager->getIdField(),
            'pid' => $this->pid,
            'data' => $entities
        ));
        $tree = $helperTree->tree();

        $list = array(0 => '-- select --');
        $this->getTreeList($list, $tree->data, $this->manager->getIdField(), $this->manager->getTitleField());
        $resolver->setDefaults(array(
            'choices' => $list,
            'empty_data' => null
        ));
    }

    /**
     * @param array  &$list
     * @param array  $childs
     * @param string $idField
     * @param string $titleField
     * @param int    $level
     */
    public function getTreeList(&$list, $childs, $idField, $titleField, $level = 0)
    {
        if (!empty($childs)) {
            foreach ($childs as $child) {
                $menu = $child['data'];
                $title = (str_repeat('&nbsp;', $level * 5) . OptionsHelper::getParam($menu, $titleField));
                $id = OptionsHelper::getParam($menu, $idField);

                $list[$id] = $title;
                if (!empty($child['child'])) {
                    $this->getTreeList($list, $child['child'], $idField, $titleField, $level + 1);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tree';
    }
}
