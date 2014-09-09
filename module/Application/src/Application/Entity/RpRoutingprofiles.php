<?php


namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * RpRoutingprofiles
 *
 * @ORM\Table(name="rp_routingprofiles")
 * @ORM\Entity
 * @ORM\entity(repositoryClass="Application\Repository\RpRoutingprofiles")
 */
class RpRoutingprofiles
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rp_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $rpId;

    /**
     * @var string
     *
     * @ORM\Column(name="rp_name", type="string", length=20, nullable=false)
     */
    private $rpName;

    /**
     * @var string
     *
     * @ORM\Column(name="rp_description", type="string", length=255, nullable=false)
     */
    private $rpDescription;
    
    /**
     * @ORM\ManyToMany( targetEntity="UsUsers", mappedBy="rpRoutingprofiles")
     **/
    private $usUsers;

    public function __construct() {
        $this->usUsers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set usUsers
     *
     * @param arrayCollection $usUsers
     * @return RpRoutingProfiles
     */
    public function setUsUsers($usUsers)
    {
        $this->usUsers = $usUsers;

        return $this; 
    }  

    /**
     * Get usUsers
     *
     * @return ArrayCollection
     */
    public function getUsUsers()
    {  
        return $this->usUsers;
    }


    /**
     * Get rpId
     *
     * @return integer 
     */
    public function getRpId()
    {
        return $this->rpId;
    }
    
    /**
     * Set rpName
     *
     * @param string $rpName
     * @return RpRoutingprofiles
     */
    public function setRpName($rpName)
    {
        $this->rpName = $rpName;

        return $this;
    }

    /**
     * Get rpName
     *
     * @return string 
     */
    public function getRpName()
    {
        return $this->rpName;
    }

    /**
     * Set rpDescription
     *
     * @param string $rpDescription
     * @return RpRoutingprofiles
     */
    public function setRpDescription($rpDescription)
    {
        $this->rpDescription = $rpDescription;

        return $this;
    }

    /**
     * Get rpDescription
     *
     * @return string 
     */
    public function getRpDescription()
    {
        return $this->rpDescription;
    }
}
