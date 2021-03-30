<?php

namespace Delivery\Model\Base;

use \Exception;
use \PDO;
use Delivery\Model\Notification as ChildNotification;
use Delivery\Model\NotificationI18nQuery as ChildNotificationI18nQuery;
use Delivery\Model\NotificationQuery as ChildNotificationQuery;
use Delivery\Model\Map\NotificationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'delivery_notification' table.
 *
 *
 *
 * @method     ChildNotificationQuery orderByDataUrl($order = Criteria::ASC) Order by the data_url column
 * @method     ChildNotificationQuery orderByFilters($order = Criteria::ASC) Order by the filters column
 * @method     ChildNotificationQuery orderByFeedPayload($order = Criteria::ASC) Order by the feed_payload column
 * @method     ChildNotificationQuery orderByPayload($order = Criteria::ASC) Order by the payload column
 * @method     ChildNotificationQuery orderById($order = Criteria::ASC) Order by the id column
 *
 * @method     ChildNotificationQuery groupByDataUrl() Group by the data_url column
 * @method     ChildNotificationQuery groupByFilters() Group by the filters column
 * @method     ChildNotificationQuery groupByFeedPayload() Group by the feed_payload column
 * @method     ChildNotificationQuery groupByPayload() Group by the payload column
 * @method     ChildNotificationQuery groupById() Group by the id column
 *
 * @method     ChildNotificationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNotificationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNotificationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNotificationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildNotificationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildNotificationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildNotificationQuery leftJoinDelivery($relationAlias = null) Adds a LEFT JOIN clause to the query using the Delivery relation
 * @method     ChildNotificationQuery rightJoinDelivery($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Delivery relation
 * @method     ChildNotificationQuery innerJoinDelivery($relationAlias = null) Adds a INNER JOIN clause to the query using the Delivery relation
 *
 * @method     ChildNotificationQuery joinWithDelivery($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Delivery relation
 *
 * @method     ChildNotificationQuery leftJoinWithDelivery() Adds a LEFT JOIN clause and with to the query using the Delivery relation
 * @method     ChildNotificationQuery rightJoinWithDelivery() Adds a RIGHT JOIN clause and with to the query using the Delivery relation
 * @method     ChildNotificationQuery innerJoinWithDelivery() Adds a INNER JOIN clause and with to the query using the Delivery relation
 *
 * @method     ChildNotificationQuery leftJoinNotificationI18n($relationAlias = null) Adds a LEFT JOIN clause to the query using the NotificationI18n relation
 * @method     ChildNotificationQuery rightJoinNotificationI18n($relationAlias = null) Adds a RIGHT JOIN clause to the query using the NotificationI18n relation
 * @method     ChildNotificationQuery innerJoinNotificationI18n($relationAlias = null) Adds a INNER JOIN clause to the query using the NotificationI18n relation
 *
 * @method     ChildNotificationQuery joinWithNotificationI18n($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the NotificationI18n relation
 *
 * @method     ChildNotificationQuery leftJoinWithNotificationI18n() Adds a LEFT JOIN clause and with to the query using the NotificationI18n relation
 * @method     ChildNotificationQuery rightJoinWithNotificationI18n() Adds a RIGHT JOIN clause and with to the query using the NotificationI18n relation
 * @method     ChildNotificationQuery innerJoinWithNotificationI18n() Adds a INNER JOIN clause and with to the query using the NotificationI18n relation
 *
 * @method     \Delivery\Model\DeliveryQuery|\Delivery\Model\NotificationI18nQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNotification|null findOne(ConnectionInterface $con = null) Return the first ChildNotification matching the query
 * @method     ChildNotification findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNotification matching the query, or a new ChildNotification object populated from the query conditions when no match is found
 *
 * @method     ChildNotification|null findOneByDataUrl(string $data_url) Return the first ChildNotification filtered by the data_url column
 * @method     ChildNotification|null findOneByFilters(string $filters) Return the first ChildNotification filtered by the filters column
 * @method     ChildNotification|null findOneByFeedPayload(string $feed_payload) Return the first ChildNotification filtered by the feed_payload column
 * @method     ChildNotification|null findOneByPayload(string $payload) Return the first ChildNotification filtered by the payload column
 * @method     ChildNotification|null findOneById(int $id) Return the first ChildNotification filtered by the id column *

 * @method     ChildNotification requirePk($key, ConnectionInterface $con = null) Return the ChildNotification by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOne(ConnectionInterface $con = null) Return the first ChildNotification matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotification requireOneByDataUrl(string $data_url) Return the first ChildNotification filtered by the data_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByFilters(string $filters) Return the first ChildNotification filtered by the filters column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByFeedPayload(string $feed_payload) Return the first ChildNotification filtered by the feed_payload column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByPayload(string $payload) Return the first ChildNotification filtered by the payload column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneById(int $id) Return the first ChildNotification filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotification[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNotification objects based on current ModelCriteria
 * @method     ChildNotification[]|ObjectCollection findByDataUrl(string $data_url) Return ChildNotification objects filtered by the data_url column
 * @method     ChildNotification[]|ObjectCollection findByFilters(string $filters) Return ChildNotification objects filtered by the filters column
 * @method     ChildNotification[]|ObjectCollection findByFeedPayload(string $feed_payload) Return ChildNotification objects filtered by the feed_payload column
 * @method     ChildNotification[]|ObjectCollection findByPayload(string $payload) Return ChildNotification objects filtered by the payload column
 * @method     ChildNotification[]|ObjectCollection findById(int $id) Return ChildNotification objects filtered by the id column
 * @method     ChildNotification[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NotificationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Delivery\Model\Base\NotificationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'delivery', $modelName = '\\Delivery\\Model\\Notification', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNotificationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNotificationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNotificationQuery) {
            return $criteria;
        }
        $query = new ChildNotificationQuery();
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
     * @return ChildNotification|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotificationTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = NotificationTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildNotification A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT data_url, filters, feed_payload, payload, id FROM delivery_notification WHERE id = :p0';
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
            /** @var ChildNotification $obj */
            $obj = new ChildNotification();
            $obj->hydrate($row);
            NotificationTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildNotification|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NotificationTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NotificationTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByDataUrl($dataUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($dataUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_DATA_URL, $dataUrl, $comparison);
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
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByFilters($filters = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($filters)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_FILTERS, $filters, $comparison);
    }

    /**
     * Filter the query on the feed_payload column
     *
     * Example usage:
     * <code>
     * $query->filterByFeedPayload('fooValue');   // WHERE feed_payload = 'fooValue'
     * $query->filterByFeedPayload('%fooValue%', Criteria::LIKE); // WHERE feed_payload LIKE '%fooValue%'
     * </code>
     *
     * @param     string $feedPayload The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByFeedPayload($feedPayload = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($feedPayload)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_FEED_PAYLOAD, $feedPayload, $comparison);
    }

    /**
     * Filter the query on the payload column
     *
     * Example usage:
     * <code>
     * $query->filterByPayload('fooValue');   // WHERE payload = 'fooValue'
     * $query->filterByPayload('%fooValue%', Criteria::LIKE); // WHERE payload LIKE '%fooValue%'
     * </code>
     *
     * @param     string $payload The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByPayload($payload = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($payload)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_PAYLOAD, $payload, $comparison);
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
     * @see       filterByDelivery()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query by a related \Delivery\Model\Delivery object
     *
     * @param \Delivery\Model\Delivery|ObjectCollection $delivery The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByDelivery($delivery, $comparison = null)
    {
        if ($delivery instanceof \Delivery\Model\Delivery) {
            return $this
                ->addUsingAlias(NotificationTableMap::COL_ID, $delivery->getId(), $comparison);
        } elseif ($delivery instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NotificationTableMap::COL_ID, $delivery->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDelivery() only accepts arguments of type \Delivery\Model\Delivery or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Delivery relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function joinDelivery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Delivery');

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
            $this->addJoinObject($join, 'Delivery');
        }

        return $this;
    }

    /**
     * Use the Delivery relation Delivery object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Delivery\Model\DeliveryQuery A secondary query class using the current class as primary query
     */
    public function useDeliveryQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinDelivery($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Delivery', '\Delivery\Model\DeliveryQuery');
    }

    /**
     * Filter the query by a related \Delivery\Model\NotificationI18n object
     *
     * @param \Delivery\Model\NotificationI18n|ObjectCollection $notificationI18n the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByNotificationI18n($notificationI18n, $comparison = null)
    {
        if ($notificationI18n instanceof \Delivery\Model\NotificationI18n) {
            return $this
                ->addUsingAlias(NotificationTableMap::COL_ID, $notificationI18n->getId(), $comparison);
        } elseif ($notificationI18n instanceof ObjectCollection) {
            return $this
                ->useNotificationI18nQuery()
                ->filterByPrimaryKeys($notificationI18n->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNotificationI18n() only accepts arguments of type \Delivery\Model\NotificationI18n or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the NotificationI18n relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function joinNotificationI18n($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('NotificationI18n');

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
            $this->addJoinObject($join, 'NotificationI18n');
        }

        return $this;
    }

    /**
     * Use the NotificationI18n relation NotificationI18n object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Delivery\Model\NotificationI18nQuery A secondary query class using the current class as primary query
     */
    public function useNotificationI18nQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinNotificationI18n($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'NotificationI18n', '\Delivery\Model\NotificationI18nQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNotification $notification Object to remove from the list of results
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function prune($notification = null)
    {
        if ($notification) {
            $this->addUsingAlias(NotificationTableMap::COL_ID, $notification->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the delivery_notification table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NotificationTableMap::clearInstancePool();
            NotificationTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NotificationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NotificationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NotificationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // i18n behavior

    /**
     * Adds a JOIN clause to the query using the i18n relation
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildNotificationQuery The current query, for fluid interface
     */
    public function joinI18n($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $relationName = $relationAlias ? $relationAlias : 'NotificationI18n';

        return $this
            ->joinNotificationI18n($relationAlias, $joinType)
            ->addJoinCondition($relationName, $relationName . '.Locale = ?', $locale);
    }

    /**
     * Adds a JOIN clause to the query and hydrates the related I18n object.
     * Shortcut for $c->joinI18n($locale)->with()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    $this The current query, for fluid interface
     */
    public function joinWithI18n($locale = 'en_US', $joinType = Criteria::LEFT_JOIN)
    {
        $this
            ->joinI18n($locale, null, $joinType)
            ->with('NotificationI18n');
        $this->with['NotificationI18n']->setIsWithOneToMany(false);

        return $this;
    }

    /**
     * Use the I18n relation query object
     *
     * @see       useQuery()
     *
     * @param     string $locale Locale to use for the join condition, e.g. 'fr_FR'
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'. Defaults to left join.
     *
     * @return    ChildNotificationI18nQuery A secondary query class using the current class as primary query
     */
    public function useI18nQuery($locale = 'en_US', $relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinI18n($locale, $relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'NotificationI18n', '\Delivery\Model\NotificationI18nQuery');
    }

} // NotificationQuery
