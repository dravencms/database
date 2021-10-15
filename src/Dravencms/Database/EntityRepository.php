<?php
/**
 * Created by PhpStorm.
 * User: sadam
 * Date: 10/15/21
 * Time: 7:10 PM
 */

namespace Dravencms\Database;


class EntityRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param string $value
     * @param string|null $key
     * @param array $criteria
     * @param array $orderBy
     * @return array
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function findPairs(string $value, string $key = null, array $criteria = [], array $orderBy = []): array
    {
        if ($key === null) {
            $key = $this->getClassMetadata()->getSingleIdentifierFieldName();
        }

        $qb = $this->createQueryBuilder('e')
            ->select(['e.' . $value, 'e.' . $key])
            ->resetDQLPart('from')
            ->from($this->getEntityName(), 'e', 'e.' . $key);

        foreach ($criteria as $k => $v) {
            if (is_array($v)) {
                $qb->andWhere(sprintf('e.%s IN(:%s)', $k, $k))->setParameter($k, array_values($v));
            } else {
                $qb->andWhere(sprintf('e.%s = :%s', $k, $k))->setParameter($k, $v);
            }
        }

        foreach ($orderBy as $column => $order) {
            $qb->addOrderBy($column, $order);
        }

        return array_map(function ($row) {
            return reset($row);
        }, $qb->getQuery()->getArrayResult());
    }
}