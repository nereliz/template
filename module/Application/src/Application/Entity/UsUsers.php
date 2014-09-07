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
     * @ORM\OneToMany(targetEntity="UtUsertenants", mappedBy="usUser")
     */
    private $utUserTenants;
    
    
    public function __construct() {
        $this->teTenants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->utUserTenants = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get utUserTeanants
     *
     * @return Array Collection
     */
    public function getUtUserTenants()
    {
        return $this->utUserTenants;
    }
    
    /**
     * Get utUserTeanants
     *
     * @return Array Collection
     */
    public function getTeTenants()
    {
        return $this->teTenants;
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
    public function setUpUserprofile($upUserporfile)
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
            $password = md5( $password );
        else
            throw new \Exception( "'$hash' HASH METHOD IS UNKNOWN" );
       
       return $password;     
    }
}
