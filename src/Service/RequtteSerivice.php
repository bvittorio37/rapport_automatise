<?php
namespace App\Service;

use Doctrine\DBAL\Connection;

class RequetteService
{
    private $connection;
  
    public function __construct(Connection $connection)
    {
        $this->connection= $connection;
    }
    public function getEtatStockParSite( String $requette)
    {
        return $this->connection->fetchAllAssociative( $requette);
    }

}

?>