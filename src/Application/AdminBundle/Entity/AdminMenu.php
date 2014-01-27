<?php

namespace Application\AdminBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Application\CoreBundle\Library\Doctrine\BaseEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AdminMenu
 *
 * @ORM\Table(name="admin_menu")
 * @ORM\Entity
 */
class AdminMenu extends BaseEntity
{
//    /**
//     * @var string
//     */
//    protected $repository = 'ApplicationAdminBundle:AdminMenu';
//
//    /**
//     * @var boolean
//     *
//     * @ORM\Column(name="menu_pid", type="integer", nullable=false)
//     *
//     * @Assert\NotBlank()
//     * @Assert\Type(type="numeric")
//     */
//    private $menuPid;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="url", type="string", length=60, nullable=true)
//     *
//     * @Assert\NotBlank()
//     * @Assert\Length(min = "3")
//     */
//    private $url;
//
//    /**
//     * @ORM\Column(name="title", type="string", length=128)
//     *
//     * @Assert\NotBlank()
//     * @Assert\Length(min = "3")
//     */
//    private $title;
//
//    /**
//     * @ORM\Column(name="qtip", type="string", length=128)
//     */
//    private $qtip;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
//     */
//    private $icon;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="params", type="string", length=100, nullable=true)
//     */
//    private $params;
//
//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="sorting", type="integer", nullable=false)
//     *
//     * @Assert\NotBlank()
//     * @Assert\Type(type="numeric")
//     */
//    private $sorting;
//
//    /**
//     * @var boolean
//     *
//     * @ORM\Column(name="active", type="boolean", nullable=false)
//     */
//    private $isActive;
//
//    /**
//     * @var integer
//     *
//     * @ORM\Column(name="menu_id", type="integer")
//     * @ORM\Id
//     * @ORM\GeneratedValue(strategy="IDENTITY")
//     */
//    private $menuId;
//
//    /**
//     * Set menuPid
//     *
//     * @param boolean $menuPid
//     *
//     * @return AdminMenu
//     */
//    public function setMenuPid($menuPid)
//    {
//        $this->menuPid = $menuPid;
//
//        return $this;
//    }
//
//    /**
//     * Get menuPid
//     *
//     * @return integer
//     */
//    public function getMenuPid()
//    {
//        return $this->menuPid;
//    }
//
//    /**
//     * Set url
//     *
//     * @param string $url
//     *
//     * @return AdminMenu
//     */
//    public function setUrl($url)
//    {
//        $this->url = $url;
//
//        return $this;
//    }
//
//    /**
//     * Get url
//     *
//     * @return string
//     */
//    public function getUrl()
//    {
//        return $this->url;
//    }
//
//    /**
//     * @param string $qtip
//     */
//    public function setQtip($qtip)
//    {
//        $this->qtip = $qtip;
//    }
//
//    /**
//     * @return string
//     */
//    public function getQtip()
//    {
//        return $this->qtip;
//    }
//
//    /**
//     * @param string $title
//     */
//    public function setTitle($title)
//    {
//        $this->title = $title;
//    }
//
//    /**
//     * @return string
//     */
//    public function getTitle()
//    {
//        return $this->title;
//    }
//
//    /**
//     * Set icon
//     *
//     * @param string $icon
//     *
//     * @return AdminMenu
//     */
//    public function setIcon($icon)
//    {
//        $this->icon = $icon;
//
//        return $this;
//    }
//
//    /**
//     * Get icon
//     *
//     * @return string
//     */
//    public function getIcon()
//    {
//        return $this->icon;
//    }
//
//    /**
//     * Set params
//     *
//     * @param string $params
//     *
//     * @return AdminMenu
//     */
//    public function setParams($params)
//    {
//        $this->params = $params;
//
//        return $this;
//    }
//
//    /**
//     * Get params
//     *
//     * @return string
//     */
//    public function getParams()
//    {
//        return $this->params;
//    }
//
//    /**
//     * Set sorting
//     *
//     * @param integer $sorting
//     *
//     * @return AdminMenu
//     */
//    public function setSorting($sorting)
//    {
//        $this->sorting = $sorting;
//
//        return $this;
//    }
//
//    /**
//     * Get sorting
//     *
//     * @return integer
//     */
//    public function getSorting()
//    {
//        return $this->sorting;
//    }
//
//    /**
//     * Set isActive
//     *
//     * @param boolean $isActive
//     *
//     * @return AdminMenu
//     */
//    public function setIsActive($isActive)
//    {
//        $this->isActive = $isActive;
//
//        return $this;
//    }
//
//    /**
//     * Get isActive
//     *
//     * @return boolean
//     */
//    public function hasIsActive()
//    {
//        return $this->isActive;
//    }
//
//    /**
//     * Get menuId
//     *
//     * @return integer
//     */
//    public function getMenuId()
//    {
//        return $this->menuId;
//    }
}
