<?php
namespace Application\CoreBundle\Library\Doctrine;

use Doctrine\ORM\Mapping as ORM;

/**
 * Extend entity to using slug
 */
trait SlugEntityTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=128, nullable=false)
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = "3", max = "128")
     */
    private $slug;

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
