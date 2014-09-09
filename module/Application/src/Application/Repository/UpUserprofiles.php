<?php
namespace Application\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityRepository;

class UpUserprofiles extends EntityRepository 
{
    public function getNamesIdsList()
    {
        $data = $this->_em->createQuery('SELECT up.upId, up.upName FROM Application\\Entity\\UpUserprofiles up')
            ->getResult();
            
        $result = array();
        foreach( $data as $row )
            $result[ $row['upId'] ] = rtrim( ltrim( $row['upName'], "<t>" ), "</t>" );
            
        return $result;
    }
}
