<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stat
 *
 * @ORM\Table(name="stats")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatRepository")
 */
class Stat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="hostname", type="string", length=255)
     */
    private $hostname;

    /**
     * @var float
     *
     * @ORM\Column(name="cpuFreq", type="float")
     */
    private $cpuFreq;

    /**
     * @var int
     *
     * @ORM\Column(name="freeMemory", type="integer")
     */
    private $freeMemory;

    /**
     * @var string
     *
     * @ORM\Column(name="upTime", type="string", length=255)
     */
    private $upTime;

    /**
     * @var string
     *
     * @ORM\Column(name="freeDiskSpace", type="string")
     */
    private $freeDiskSpace;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * Stat constructor.
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set hostname
     *
     * @param string $hostname
     * @return Stat
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Get hostname
     *
     * @return string 
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set cpuFreq
     *
     * @param float $cpuFreq
     * @return Stat
     */
    public function setCpuFreq($cpuFreq)
    {
        $this->cpuFreq = $cpuFreq;

        return $this;
    }

    /**
     * Get cpuFreq
     *
     * @return float
     */
    public function getCpuFreq()
    {
        return $this->cpuFreq;
    }

    /**
     * Set freeMemory
     *
     * @param integer $freeMemory
     * @return Stat
     */
    public function setFreeMemory($freeMemory)
    {
        $this->freeMemory = $freeMemory;

        return $this;
    }

    /**
     * Get freeMemory
     *
     * @return integer 
     */
    public function getFreeMemory()
    {
        return $this->freeMemory;
    }

    /**
     * Set upTime
     *
     * @param string $upTime
     * @return Stat
     */
    public function setUpTime($upTime)
    {
        $this->upTime = $upTime;

        return $this;
    }

    /**
     * Get upTime
     *
     * @return string 
     */
    public function getUpTime()
    {
        return $this->upTime;
    }

    /**
     * Set freeDiskSpace
     *
     * @param string $freeDiskSpace
     * @return Stat
     */
    public function setFreeDiskSpace($freeDiskSpace)
    {
        $this->freeDiskSpace = $freeDiskSpace;

        return $this;
    }

    /**
     * Get freeDiskSpace
     *
     * @return string
     */
    public function getFreeDiskSpace()
    {
        return $this->freeDiskSpace;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
