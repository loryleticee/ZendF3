<?php 

namespace User\Model;

use Zend\Db\TableGateway\TableGatewayInterface;


class UserTable 
{
   protected $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
            $this->tableGateway = $tableGateway ;
    } 

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }

}

?>