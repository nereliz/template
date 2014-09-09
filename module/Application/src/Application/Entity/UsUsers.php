<?php

namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * UsUsers
 *
 * @ORM\Table(name="us_users")
 * @ORM\Entity
 */
class UsUsers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="us_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $usId;

    /**
     * @var string
     *
     * @ORM\Column(name="us_username", type="string", length=255, nullable=false)
     */
    private $usUsername;

    /**
     * @var string
     *
     * @ORM\Column(name="us_password", type="string", length=255, nullable=false)
     */
    private $usPassword;

    /**
     * @var integer
     *
     * @ORM\Column(name="us_up_id", type="integer", nullable=false)
     */
    private $usUpId;
    
    /**
     * @ORM\ManyToOne(targetEntity="UpUserprofiles")
     * @ORM\JoinColumn(name="us_up_id", referencedColumnName="up_id")
     */
    private $upUserprofile;
    
    /**
     * @ORM\ManyToMany(targetEntity="TeTenants", inversedBy="usUsers")
     * @ORM\JoinTable(name="ut_usertenants",
     *      joinColumns={@ORM\JoinColumn(name="ut_us_id", referencedColumnName="us_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ut_te_id", referencedColumnName="te_id")}
     *      )
     **/
    private $teTenants;
    
    /**
     * @ORM\ManyToMany(targetEntity="RpRoutingprofiles", inversedBy="usUsers")
     * @ORM\JoinTable(name="ur_userroutingprofiles",
     *      joinColumns={@ORM\JoinColumn(name="ur_us_id", referencedColumnName="us_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="ur_rp_id", referencedColumnName="rp_id")}
     *      )
     **/
    private $rpRoutingprofiles;
    
    public function __construct() {
        $this->teTenants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rpRoutingprofiles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set teTenants
     *
     * @param arrayCollection $teTenants
     * @return UsUsers
     */
    public function setTeTenants($teTenants)
    {
        $this->teTenants = $teTenants;

        return $this;
    }
    
    /**
     * Get teTeanants
     *
     * @return ArrayCollection
     */
    public function getTeTenants()
    {
        return $this->teTenants;
    }
    
    /**
     * Get names of user tenants. Array structure $id => $name;
     *
     * @return Array
     */
    public function getTeTenantNames()
    {
        $names = array();
        foreach( $this->teTenants as $tenant )
            $names[ $tenant->getTeId() ] = $tenant->getTeName();
            
        return $names;
    }
    
    /**
     * Set rpRoutingprofiles
     *
     * @param arrayCollection $rpRoutingprofiles
     * @return UsUsers
     */
    public function setRpRoutingprofiles($rpRoutingprofiles)
    {
        $this->rpRoutingprofiles = $rpRoutingprofiles;

        return $this;
    }
    
    /**
     * Get rpRoutingprofiles
     *
     * @return ArrayCollection
     */
    public function getRpRoutingprofiles()
    {
        return $this->rpRoutingprofiles;
    }
    
    /**
     * Get names of user tenants. Array structure $id => $name;
     *
     * @return Array
     */
    public function getRpRoutingprofilesNames()
    {
        $names = array();
        foreach( $this->rpRoutingprofiles as $rprofile )
            $names[ $rprofile->getRpId() ] = $rprofile->getRpName();
            
        return $names;
    }

    /**
     * Get usId
     *
     * @return integer 
     */
    public function getUsId()
    {
        return $this->usId;
    }

    /**
     * Set usUsername
     *
     * @param string $usUsername
     * @return UsUsers
     */
    public function setUsUsername($usUsername)
    {
        $this->usUsername = $usUsername;

        return $this;
    }

    /**
     * Get usUsername
     *
     * @return string 
     */
    public function getUsUsername()
    {
        return $this->usUsername;
    }

    /**
     * Set usPassword
     *
     * @param string $usPassword
     * @return UsUsers
     */
    public function setUsPassword($usPassword)
    {
        $this->usPassword = $usPassword;

        return $this;
    }

    /**
     * Get usPassword
     *
     * @return string 
     */
    public function getUsPassword()
    {
        return $this->usPassword;
    }

    /**
     * Set usUpId
     *
     * @param integer $usUpId
     * @return UsUsers
     */
    public function setUsUpId($usUpId)
    {
        $this->usUpId = $usUpId;

        return $this;
    }

    /**
     * Get usUpId
     *
     * @return integer 
     */
    public function getUsUpId()
    {
        return $this->usUpId;
    }
    
    /**
     * Set upUserprofile
     *
     * @param UpUserprofiles $upUserprofile
     * @return UsUsers
     */
    public function setUpUserprofile($upUserprofile)
    {
        $this->upUserprofile = $upUserprofile;

        return $this;
    }

    /**
     * Get upUserprofile
     *
     * @return UpUserprofiles
     */
    public function getUpUserprofile()
    {
        return $this->upUserprofile;
    }
    
    public function hashPassword( $password, $hash = "md5" )
    {
        if( strtolower( $hash ) == "md5" )
            $password = md5( $password );
        else if( strtolower( $hash ) == "plain" )
            $password = $password;
        else
            throw new \Exception( "'$hash' HASH METHOD IS UNKNOWN" );
       
       return $password;     
    }
}
