<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class ProductRepository extends EntityRepository
{

    /**
     * @param $name
     * @throws \Doctrine\DBAL\DBALException
     * @return Product[]
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

    /**
     * @return Query
     */
    public function prepareQueryForPagination(): Query
    {
        $dql = "SELECT p FROM AppBundle:Product p";

        return $this->getEntityManager()->createQuery($dql);
    }
}