<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{

    /**
     * @param $name
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findProductsByCategoryName($name)
    {
        // probably not the best solution but works fast
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