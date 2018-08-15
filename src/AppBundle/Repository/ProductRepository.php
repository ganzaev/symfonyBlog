<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Parameter;

class ProductRepository extends EntityRepository
{

    /**
     * @param $name
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findProductsByCategoryName($name)
    {
        $connection = $this->getEntityManager()->getConnection();
        $dql = 'SELECT p.* FROM products as p
            INNER JOIN categories as c
            ON c.id = p.category_id
            WHERE c.name = :name';
        $statement = $connection->prepare($dql);
        $statement->bindValue('name', $name);
        $statement->execute();
        return $statement->fetchAll();
    }
}