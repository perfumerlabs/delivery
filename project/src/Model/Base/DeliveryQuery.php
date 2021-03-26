<?php

namespace Delivery\Model\Base;

use \Exception;
use \PDO;
use Delivery\Model\Delivery as ChildDelivery;
use Delivery\Model\DeliveryQuery as ChildDeliveryQuery;
use Delivery\Model\Map\DeliveryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'delivery_delivery' table.
 *
 *
 *
 * @method     ChildDeliveryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDeliveryQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildDeliveryQuery orderByDataUrl($order = Criteria::ASC) Order by the data_url column
 * @method     ChildDeliveryQuery orderByFilters($order = Criteria::ASC) Order by the filters column
 * @method     ChildDeliveryQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildDeliveryQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildDeliveryQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildDeliveryQuery groupById() Group by the id column
 * @method     ChildDeliveryQuery groupByName() Group by the name column
 * @method     ChildDeliveryQuery groupByDataUrl() Group by the data_url column
 * @method     ChildDeliveryQuery groupByFilters() Group by the filters column
 * @method     ChildDeliveryQuery groupByStatus() Group by the status column
 * @method     ChildDeliveryQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildDeliveryQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildDeliveryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDeliveryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDeliveryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDeliveryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDeliveryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDeliveryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDeliveryQuery leftJoinNotification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notification relation
 * @method     ChildDeliveryQuery rightJoinNotification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notification relation
 * @method     ChildDeliveryQuery innerJoinNotification($relationAlias = null) Adds a INNER JOIN clause to the query using the Notification relation
 *
 * @method     ChildDeliveryQuery joinWithNotification($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Notification relation
 *
 * @method     ChildDeliveryQuery leftJoinWithNotification() Adds a LEFT JOIN clause and with to the query using the Notification relation
 * @method     ChildDeliveryQuery rightJoinWithNotification() Adds a RIGHT JOIN clause and with to the query using the Notification relation
 * @method     ChildDeliveryQuery innerJoinWithNotification() Adds a INNER JOIN clause and with to the query using the Notification relation
 *
 * @method     \Delivery\Model\NotificationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDelivery|null findOne(ConnectionInterface $con = null) Return the first ChildDelivery matching the query
 * @method     ChildDelivery findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDelivery matching the query, or a new ChildDelivery object populated from the query conditions when no match is found
 *
 * @method     ChildDelivery|null findOneById(int $id) Return the first ChildDelivery filtered by the id column
 * @method     ChildDelivery|null findOneByName(string $name) Return the first ChildDelivery filtered by the name column
 * @method     ChildDelivery|null findOneByDataUrl(string $data_url) Return the first ChildDelivery filtered by the data_url column
 * @method     ChildDelivery|null findOneByFilters(string $filters) Return the first ChildDelivery filtered by the filters column
 * @method     ChildDelivery|null findOneByStatus(int $status) Return the first ChildDelivery filtered by the status column
 * @method     ChildDelivery|null findOneByCreatedAt(string $created_at) Return the first ChildDelivery filtered by the created_at column
 * @method     ChildDelivery|null findOneByUpdatedAt(string $updated_at) Return the first ChildDelivery filtered by the updated_at column *

 * @method     ChildDelivery requirePk($key, ConnectionInterface $con = null) Return the ChildDelivery by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDelivery requireOne(ConnectionInterface $con = null) Return the first ChildDelivery matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDelivery requireOneById(int $id) Return the first ChildDelivery filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDelivery requireOneByName(string $name) Return the first ChildDelivery filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDelivery requireOneByDataUrl(string $data_url) Return the first ChildDelivery filtered by the data_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDelivery requireOneByFilters(string $filters) Return the first ChildDelivery filtered by the filters column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDelivery requireOneByStatus(int $status) Return the first ChildDelivery filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDelivery requireOneByCreatedAt(string $created_at) Return the first ChildDelivery filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDelivery requireOneByUpdatedAt(string $updated_at) Return the first ChildDelivery filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDelivery[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDelivery objects based on current ModelCriteria
 * @method     ChildDelivery[]|ObjectCollection findById(int $id) Return ChildDelivery objects filtered by the id column
 * @method     ChildDelivery[]|ObjectCollection findByName(string $name) Return ChildDelivery objects filtered by the name column
 * @method     ChildDelivery[]|ObjectCollection findByDataUrl(string $data_url) Return ChildDelivery objects filtered by the data_url column
 * @method     ChildDelivery[]|ObjectCollection findByFilters(string $filters) Return ChildDelivery objects filtered by the filters column
 * @method     ChildDelivery[]|ObjectCollection findByStatus(int $status) Return ChildDelivery objects filtered by the status column
 * @method     ChildDelivery[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildDelivery objects filtered by the created_at column
 * @method     ChildDelivery[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildDelivery objects filtered by the updated_at column
 * @method     ChildDelivery[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DeliveryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Delivery\Model\Base\DeliveryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'delivery', $modelName = '\\Delivery\\Model\\Delivery', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDeliveryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDeliveryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDeliveryQuery) {
            return $criteria;
        }
        $query = new ChildDeliveryQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDelivery|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DeliveryTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DeliveryTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDelivery A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, data_url, filters, status, created_at, updated_at FROM delivery_delivery WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDelivery $obj */
            $obj = new ChildDelivery();
            $obj->hydrate($row);
            DeliveryTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDelivery|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DeliveryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DeliveryTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DeliveryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DeliveryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the data_url column
     *
     * Example usage:
     * <code>
     * $query->filterByDataUrl('fooValue');   // WHERE data_url = 'fooValue'
     * $query->filterByDataUrl('%fooValue%', Criteria::LIKE); // WHERE data_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $dataUrl The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByDataUrl($dataUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dataUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryTableMap::COL_DATA_URL, $dataUrl, $comparison);
    }

    /**
     * Filter the query on the filters column
     *
     * Example usage:
     * <code>
     * $query->filterByFilters('fooValue');   // WHERE filters = 'fooValue'
     * $query->filterByFilters('%fooValue%', Criteria::LIKE); // WHERE filters LIKE '%fooValue%'
     * </code>
     *
     * @param     string $filters The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByFilters($filters = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($filters)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryTableMap::COL_FILTERS, $filters, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * @param     mixed $status The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        $valueSet = DeliveryTableMap::getValueSet(DeliveryTableMap::COL_STATUS);
        if (is_scalar($status)) {
            if (!in_array($status, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $status));
            }
            $status = array_search($status, $valueSet);
        } elseif (is_array($status)) {
            $convertedValues = array();
            foreach ($status as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $status = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(DeliveryTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(DeliveryTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(DeliveryTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(DeliveryTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DeliveryTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Delivery\Model\Notification object
     *
     * @param \Delivery\Model\Notification|ObjectCollection $notification the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDeliveryQuery The current query, for fluid interface
     */
    public function filterByNotification($notification, $comparison = null)
    {
        if ($notification instanceof \Delivery\Model\Notification) {
            return $this
                ->addUsingAlias(DeliveryTableMap::COL_ID, $notification->getDeliveryId(), $comparison);
        } elseif ($notification instanceof ObjectCollection) {
            return $this
                ->useNotificationQuery()
                ->filterByPrimaryKeys($notification->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNotification() only accepts arguments of type \Delivery\Model\Notification or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Notification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function joinNotification($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Notification');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Notification');
        }

        return $this;
    }

    /**
     * Use the Notification relation Notification object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Delivery\Model\NotificationQuery A secondary query class using the current class as primary query
     */
    public function useNotificationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNotification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Notification', '\Delivery\Model\NotificationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDelivery $delivery Object to remove from the list of results
     *
     * @return $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function prune($delivery = null)
    {
        if ($delivery) {
            $this->addUsingAlias(DeliveryTableMap::COL_ID, $delivery->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the delivery_delivery table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeliveryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DeliveryTableMap::clearInstancePool();
            DeliveryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeliveryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DeliveryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DeliveryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DeliveryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(DeliveryTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(DeliveryTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(DeliveryTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(DeliveryTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(DeliveryTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildDeliveryQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(DeliveryTableMap::COL_CREATED_AT);
    }

} // DeliveryQuery
