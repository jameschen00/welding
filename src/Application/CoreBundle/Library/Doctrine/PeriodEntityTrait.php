<?php
namespace Application\CoreBundle\Library\Doctrine;

use Doctrine\ORM\Mapping as ORM;

/**
 * Extend entity to start and stop date field
 */
trait PeriodEntityTrait
{
    /**
     * @var \Datetime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $startDate;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="stop_date", type="datetime", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $stopDate;

    /**
     * @param \Datetime $startDate
     *
     * @return $this
     */
    public function setStartDate(\Datetime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $stopDate
     *
     * @return $this
     */
    public function setStopDate(\DateTime $stopDate)
    {
        $this->stopDate = $stopDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStopDate()
    {
        return $this->stopDate;
    }

}
