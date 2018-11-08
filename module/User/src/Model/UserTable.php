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
    public function getUser($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveUser(User $user)
    {
        $data = [
            'nom' => mb_strtoupper($user->nom,'UTF8'),
            'prenom'  => $user->prenom,
        ];

        $id = (int) $user->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getUser($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update user with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }

}

?>