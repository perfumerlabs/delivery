<?php

namespace Delivery\Model\Base;

use \Exception;
use \PDO;
use Delivery\Model\NotificationI18n as ChildNotificationI18n;
use Delivery\Model\NotificationI18nQuery as ChildNotificationI18nQuery;
use Delivery\Model\Map\NotificationI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'delivery_notification_i18n' table.
 *
 *
 *
 * @method     ChildNotificationI18nQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildNotificationI18nQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     ChildNotificationI18nQuery orderByEmailSubject($order = Criteria::ASC) Order by the email_subject column
 * @method     ChildNotificationI18nQuery orderByEmailHtml($order = Criteria::ASC) Order by the email_html column
 * @method     ChildNotificationI18nQuery orderBySmsMessage($order = Criteria::ASC) Order by the sms_message column
 * @method     ChildNotificationI18nQuery orderByFeedTitle($order = Criteria::ASC) Order by the feed_title column
 * @method     ChildNotificationI18nQuery orderByFeedText($order = Criteria::ASC) Order by the feed_text column
 * @method     ChildNotificationI18nQuery orderByFeedImage($order = Criteria::ASC) Order by the feed_image column
 *
 * @method     ChildNotificationI18nQuery groupById() Group by the id column
 * @method     ChildNotificationI18nQuery groupByLocale() Group by the locale column
 * @method     ChildNotificationI18nQuery groupByEmailSubject() Group by the email_subject column
 * @method     ChildNotificationI18nQuery groupByEmailHtml() Group by the email_html column
 * @method     ChildNotificationI18nQuery groupBySmsMessage() Group by the sms_message column
 * @method     ChildNotificationI18nQuery groupByFeedTitle() Group by the feed_title column
 * @method     ChildNotificationI18nQuery groupByFeedText() Group by the feed_text column
 * @method     ChildNotificationI18nQuery groupByFeedImage() Group by the feed_image column
 *
 * @method     ChildNotificationI18nQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNotificationI18nQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNotificationI18nQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNotificationI18nQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildNotificationI18nQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildNotificationI18nQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildNotificationI18nQuery leftJoinNotification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notification relation
 * @method     ChildNotificationI18nQuery rightJoinNotification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notification relation
 * @method     ChildNotificationI18nQuery innerJoinNotification($relationAlias = null) Adds a INNER JOIN clause to the query using the Notification relation
 *
 * @method     ChildNotificationI18nQuery joinWithNotification($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Notification relation
 *
 * @method     ChildNotificationI18nQuery leftJoinWithNotification() Adds a LEFT JOIN clause and with to the query using the Notification relation
 * @method     ChildNotificationI18nQuery rightJoinWithNotification() Adds a RIGHT JOIN clause and with to the query using the Notification relation
 * @method     ChildNotificationI18nQuery innerJoinWithNotification() Adds a INNER JOIN clause and with to the query using the Notification relation
 *
 * @method     \Delivery\Model\NotificationQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNotificationI18n|null findOne(ConnectionInterface $con = null) Return the first ChildNotificationI18n matching the query
 * @method     ChildNotificationI18n findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNotificationI18n matching the query, or a new ChildNotificationI18n object populated from the query conditions when no match is found
 *
 * @method     ChildNotificationI18n|null findOneById(int $id) Return the first ChildNotificationI18n filtered by the id column
 * @method     ChildNotificationI18n|null findOneByLocale(string $locale) Return the first ChildNotificationI18n filtered by the locale column
 * @method     ChildNotificationI18n|null findOneByEmailSubject(string $email_subject) Return the first ChildNotificationI18n filtered by the email_subject column
 * @method     ChildNotificationI18n|null findOneByEmailHtml(string $email_html) Return the first ChildNotificationI18n filtered by the email_html column
 * @method     ChildNotificationI18n|null findOneBySmsMessage(string $sms_message) Return the first ChildNotificationI18n filtered by the sms_message column
 * @method     ChildNotificationI18n|null findOneByFeedTitle(string $feed_title) Return the first ChildNotificationI18n filtered by the feed_title column
 * @method     ChildNotificationI18n|null findOneByFeedText(string $feed_text) Return the first ChildNotificationI18n filtered by the feed_text column
 * @method     ChildNotificationI18n|null findOneByFeedImage(string $feed_image) Return the first ChildNotificationI18n filtered by the feed_image column *

 * @method     ChildNotificationI18n requirePk($key, ConnectionInterface $con = null) Return the ChildNotificationI18n by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationI18n requireOne(ConnectionInterface $con = null) Return the first ChildNotificationI18n matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotificationI18n requireOneById(int $id) Return the first ChildNotificationI18n filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationI18n requireOneByLocale(string $locale) Return the first ChildNotificationI18n filtered by the locale column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationI18n requireOneByEmailSubject(string $email_subject) Return the first ChildNotificationI18n filtered by the email_subject column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationI18n requireOneByEmailHtml(string $email_html) Return the first ChildNotificationI18n filtered by the email_html column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationI18n requireOneBySmsMessage(string $sms_message) Return the first ChildNotificationI18n filtered by the sms_message column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationI18n requireOneByFeedTitle(string $feed_title) Return the first ChildNotificationI18n filtered by the feed_title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationI18n requireOneByFeedText(string $feed_text) Return the first ChildNotificationI18n filtered by the feed_text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotificationI18n requireOneByFeedImage(string $feed_image) Return the first ChildNotificationI18n filtered by the feed_image column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotificationI18n[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNotificationI18n objects based on current ModelCriteria
 * @method     ChildNotificationI18n[]|ObjectCollection findById(int $id) Return ChildNotificationI18n objects filtered by the id column
 * @method     ChildNotificationI18n[]|ObjectCollection findByLocale(string $locale) Return ChildNotificationI18n objects filtered by the locale column
 * @method     ChildNotificationI18n[]|ObjectCollection findByEmailSubject(string $email_subject) Return ChildNotificationI18n objects filtered by the email_subject column
 * @method     ChildNotificationI18n[]|ObjectCollection findByEmailHtml(string $email_html) Return ChildNotificationI18n objects filtered by the email_html column
 * @method     ChildNotificationI18n[]|ObjectCollection findBySmsMessage(string $sms_message) Return ChildNotificationI18n objects filtered by the sms_message column
 * @method     ChildNotificationI18n[]|ObjectCollection findByFeedTitle(string $feed_title) Return ChildNotificationI18n objects filtered by the feed_title column
 * @method     ChildNotificationI18n[]|ObjectCollection findByFeedText(string $feed_text) Return ChildNotificationI18n objects filtered by the feed_text column
 * @method     ChildNotificationI18n[]|ObjectCollection findByFeedImage(string $feed_image) Return ChildNotificationI18n objects filtered by the feed_image column
 * @method     ChildNotificationI18n[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NotificationI18nQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Delivery\Model\Base\NotificationI18nQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'delivery', $modelName = '\\Delivery\\Model\\NotificationI18n', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNotificationI18nQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNotificationI18nQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNotificationI18nQuery) {
            return $criteria;
        }
        $query = new ChildNotificationI18nQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $locale] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildNotificationI18n|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotificationI18nTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = NotificationI18nTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildNotificationI18n A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, locale, email_subject, email_html, sms_message, feed_title, feed_text, feed_image FROM delivery_notification_i18n WHERE id = :p0 AND locale = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildNotificationI18n $obj */
            $obj = new ChildNotificationI18n();
            $obj->hydrate($row);
            NotificationI18nTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildNotificationI18n|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(NotificationI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(NotificationI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(NotificationI18nTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(NotificationI18nTableMap::COL_LOCALE, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByNotification()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(NotificationI18nTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(NotificationI18nTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationI18nTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the locale column
     *
     * Example usage:
     * <code>
     * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
     * $query->filterByLocale('%fooValue%', Criteria::LIKE); // WHERE locale LIKE '%fooValue%'
     * </code>
     *
     * @param     string $locale The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByLocale($locale = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($locale)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationI18nTableMap::COL_LOCALE, $locale, $comparison);
    }

    /**
     * Filter the query on the email_subject column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailSubject('fooValue');   // WHERE email_subject = 'fooValue'
     * $query->filterByEmailSubject('%fooValue%', Criteria::LIKE); // WHERE email_subject LIKE '%fooValue%'
     * </code>
     *
     * @param     string $emailSubject The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByEmailSubject($emailSubject = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($emailSubject)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationI18nTableMap::COL_EMAIL_SUBJECT, $emailSubject, $comparison);
    }

    /**
     * Filter the query on the email_html column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailHtml('fooValue');   // WHERE email_html = 'fooValue'
     * $query->filterByEmailHtml('%fooValue%', Criteria::LIKE); // WHERE email_html LIKE '%fooValue%'
     * </code>
     *
     * @param     string $emailHtml The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByEmailHtml($emailHtml = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($emailHtml)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationI18nTableMap::COL_EMAIL_HTML, $emailHtml, $comparison);
    }

    /**
     * Filter the query on the sms_message column
     *
     * Example usage:
     * <code>
     * $query->filterBySmsMessage('fooValue');   // WHERE sms_message = 'fooValue'
     * $query->filterBySmsMessage('%fooValue%', Criteria::LIKE); // WHERE sms_message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $smsMessage The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterBySmsMessage($smsMessage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($smsMessage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationI18nTableMap::COL_SMS_MESSAGE, $smsMessage, $comparison);
    }

    /**
     * Filter the query on the feed_title column
     *
     * Example usage:
     * <code>
     * $query->filterByFeedTitle('fooValue');   // WHERE feed_title = 'fooValue'
     * $query->filterByFeedTitle('%fooValue%', Criteria::LIKE); // WHERE feed_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $feedTitle The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByFeedTitle($feedTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($feedTitle)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationI18nTableMap::COL_FEED_TITLE, $feedTitle, $comparison);
    }

    /**
     * Filter the query on the feed_text column
     *
     * Example usage:
     * <code>
     * $query->filterByFeedText('fooValue');   // WHERE feed_text = 'fooValue'
     * $query->filterByFeedText('%fooValue%', Criteria::LIKE); // WHERE feed_text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $feedText The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByFeedText($feedText = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($feedText)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationI18nTableMap::COL_FEED_TEXT, $feedText, $comparison);
    }

    /**
     * Filter the query on the feed_image column
     *
     * Example usage:
     * <code>
     * $query->filterByFeedImage('fooValue');   // WHERE feed_image = 'fooValue'
     * $query->filterByFeedImage('%fooValue%', Criteria::LIKE); // WHERE feed_image LIKE '%fooValue%'
     * </code>
     *
     * @param     string $feedImage The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByFeedImage($feedImage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($feedImage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationI18nTableMap::COL_FEED_IMAGE, $feedImage, $comparison);
    }

    /**
     * Filter the query by a related \Delivery\Model\Notification object
     *
     * @param \Delivery\Model\Notification|ObjectCollection $notification The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function filterByNotification($notification, $comparison = null)
    {
        if ($notification instanceof \Delivery\Model\Notification) {
            return $this
                ->addUsingAlias(NotificationI18nTableMap::COL_ID, $notification->getId(), $comparison);
        } elseif ($notification instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NotificationI18nTableMap::COL_ID, $notification->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function joinNotification($relationAlias = null, $joinType = 'LEFT JOIN')
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
    public function useNotificationQuery($relationAlias = null, $joinType = 'LEFT JOIN')
    {
        return $this
            ->joinNotification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Notification', '\Delivery\Model\NotificationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNotificationI18n $notificationI18n Object to remove from the list of results
     *
     * @return $this|ChildNotificationI18nQuery The current query, for fluid interface
     */
    public function prune($notificationI18n = null)
    {
        if ($notificationI18n) {
            $this->addCond('pruneCond0', $this->getAliasedColName(NotificationI18nTableMap::COL_ID), $notificationI18n->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(NotificationI18nTableMap::COL_LOCALE), $notificationI18n->getLocale(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the delivery_notification_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationI18nTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NotificationI18nTableMap::clearInstancePool();
            NotificationI18nTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationI18nTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NotificationI18nTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NotificationI18nTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NotificationI18nTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NotificationI18nQuery
