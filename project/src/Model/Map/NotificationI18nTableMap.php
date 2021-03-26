<?php

namespace Delivery\Model\Map;

use Delivery\Model\NotificationI18n;
use Delivery\Model\NotificationI18nQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'delivery_notification_i18n' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class NotificationI18nTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.NotificationI18nTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'delivery';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'delivery_notification_i18n';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Delivery\\Model\\NotificationI18n';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'NotificationI18n';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the delivery_id field
     */
    const COL_DELIVERY_ID = 'delivery_notification_i18n.delivery_id';

    /**
     * the column name for the locale field
     */
    const COL_LOCALE = 'delivery_notification_i18n.locale';

    /**
     * the column name for the email_title field
     */
    const COL_EMAIL_TITLE = 'delivery_notification_i18n.email_title';

    /**
     * the column name for the email_content field
     */
    const COL_EMAIL_CONTENT = 'delivery_notification_i18n.email_content';

    /**
     * the column name for the feed_title field
     */
    const COL_FEED_TITLE = 'delivery_notification_i18n.feed_title';

    /**
     * the column name for the feed_content field
     */
    const COL_FEED_CONTENT = 'delivery_notification_i18n.feed_content';

    /**
     * the column name for the sms_content field
     */
    const COL_SMS_CONTENT = 'delivery_notification_i18n.sms_content';

    /**
     * the column name for the link_text field
     */
    const COL_LINK_TEXT = 'delivery_notification_i18n.link_text';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('DeliveryId', 'Locale', 'EmailTitle', 'EmailContent', 'FeedTitle', 'FeedContent', 'SmsContent', 'LinkText', ),
        self::TYPE_CAMELNAME     => array('deliveryId', 'locale', 'emailTitle', 'emailContent', 'feedTitle', 'feedContent', 'smsContent', 'linkText', ),
        self::TYPE_COLNAME       => array(NotificationI18nTableMap::COL_DELIVERY_ID, NotificationI18nTableMap::COL_LOCALE, NotificationI18nTableMap::COL_EMAIL_TITLE, NotificationI18nTableMap::COL_EMAIL_CONTENT, NotificationI18nTableMap::COL_FEED_TITLE, NotificationI18nTableMap::COL_FEED_CONTENT, NotificationI18nTableMap::COL_SMS_CONTENT, NotificationI18nTableMap::COL_LINK_TEXT, ),
        self::TYPE_FIELDNAME     => array('delivery_id', 'locale', 'email_title', 'email_content', 'feed_title', 'feed_content', 'sms_content', 'link_text', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('DeliveryId' => 0, 'Locale' => 1, 'EmailTitle' => 2, 'EmailContent' => 3, 'FeedTitle' => 4, 'FeedContent' => 5, 'SmsContent' => 6, 'LinkText' => 7, ),
        self::TYPE_CAMELNAME     => array('deliveryId' => 0, 'locale' => 1, 'emailTitle' => 2, 'emailContent' => 3, 'feedTitle' => 4, 'feedContent' => 5, 'smsContent' => 6, 'linkText' => 7, ),
        self::TYPE_COLNAME       => array(NotificationI18nTableMap::COL_DELIVERY_ID => 0, NotificationI18nTableMap::COL_LOCALE => 1, NotificationI18nTableMap::COL_EMAIL_TITLE => 2, NotificationI18nTableMap::COL_EMAIL_CONTENT => 3, NotificationI18nTableMap::COL_FEED_TITLE => 4, NotificationI18nTableMap::COL_FEED_CONTENT => 5, NotificationI18nTableMap::COL_SMS_CONTENT => 6, NotificationI18nTableMap::COL_LINK_TEXT => 7, ),
        self::TYPE_FIELDNAME     => array('delivery_id' => 0, 'locale' => 1, 'email_title' => 2, 'email_content' => 3, 'feed_title' => 4, 'feed_content' => 5, 'sms_content' => 6, 'link_text' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [

        'DeliveryId' => 'DELIVERY_ID',
        'NotificationI18n.DeliveryId' => 'DELIVERY_ID',
        'deliveryId' => 'DELIVERY_ID',
        'notificationI18n.deliveryId' => 'DELIVERY_ID',
        'NotificationI18nTableMap::COL_DELIVERY_ID' => 'DELIVERY_ID',
        'COL_DELIVERY_ID' => 'DELIVERY_ID',
        'delivery_id' => 'DELIVERY_ID',
        'delivery_notification_i18n.delivery_id' => 'DELIVERY_ID',
        'Locale' => 'LOCALE',
        'NotificationI18n.Locale' => 'LOCALE',
        'locale' => 'LOCALE',
        'notificationI18n.locale' => 'LOCALE',
        'NotificationI18nTableMap::COL_LOCALE' => 'LOCALE',
        'COL_LOCALE' => 'LOCALE',
        'locale' => 'LOCALE',
        'delivery_notification_i18n.locale' => 'LOCALE',
        'EmailTitle' => 'EMAIL_TITLE',
        'NotificationI18n.EmailTitle' => 'EMAIL_TITLE',
        'emailTitle' => 'EMAIL_TITLE',
        'notificationI18n.emailTitle' => 'EMAIL_TITLE',
        'NotificationI18nTableMap::COL_EMAIL_TITLE' => 'EMAIL_TITLE',
        'COL_EMAIL_TITLE' => 'EMAIL_TITLE',
        'email_title' => 'EMAIL_TITLE',
        'delivery_notification_i18n.email_title' => 'EMAIL_TITLE',
        'EmailContent' => 'EMAIL_CONTENT',
        'NotificationI18n.EmailContent' => 'EMAIL_CONTENT',
        'emailContent' => 'EMAIL_CONTENT',
        'notificationI18n.emailContent' => 'EMAIL_CONTENT',
        'NotificationI18nTableMap::COL_EMAIL_CONTENT' => 'EMAIL_CONTENT',
        'COL_EMAIL_CONTENT' => 'EMAIL_CONTENT',
        'email_content' => 'EMAIL_CONTENT',
        'delivery_notification_i18n.email_content' => 'EMAIL_CONTENT',
        'FeedTitle' => 'FEED_TITLE',
        'NotificationI18n.FeedTitle' => 'FEED_TITLE',
        'feedTitle' => 'FEED_TITLE',
        'notificationI18n.feedTitle' => 'FEED_TITLE',
        'NotificationI18nTableMap::COL_FEED_TITLE' => 'FEED_TITLE',
        'COL_FEED_TITLE' => 'FEED_TITLE',
        'feed_title' => 'FEED_TITLE',
        'delivery_notification_i18n.feed_title' => 'FEED_TITLE',
        'FeedContent' => 'FEED_CONTENT',
        'NotificationI18n.FeedContent' => 'FEED_CONTENT',
        'feedContent' => 'FEED_CONTENT',
        'notificationI18n.feedContent' => 'FEED_CONTENT',
        'NotificationI18nTableMap::COL_FEED_CONTENT' => 'FEED_CONTENT',
        'COL_FEED_CONTENT' => 'FEED_CONTENT',
        'feed_content' => 'FEED_CONTENT',
        'delivery_notification_i18n.feed_content' => 'FEED_CONTENT',
        'SmsContent' => 'SMS_CONTENT',
        'NotificationI18n.SmsContent' => 'SMS_CONTENT',
        'smsContent' => 'SMS_CONTENT',
        'notificationI18n.smsContent' => 'SMS_CONTENT',
        'NotificationI18nTableMap::COL_SMS_CONTENT' => 'SMS_CONTENT',
        'COL_SMS_CONTENT' => 'SMS_CONTENT',
        'sms_content' => 'SMS_CONTENT',
        'delivery_notification_i18n.sms_content' => 'SMS_CONTENT',
        'LinkText' => 'LINK_TEXT',
        'NotificationI18n.LinkText' => 'LINK_TEXT',
        'linkText' => 'LINK_TEXT',
        'notificationI18n.linkText' => 'LINK_TEXT',
        'NotificationI18nTableMap::COL_LINK_TEXT' => 'LINK_TEXT',
        'COL_LINK_TEXT' => 'LINK_TEXT',
        'link_text' => 'LINK_TEXT',
        'delivery_notification_i18n.link_text' => 'LINK_TEXT',
    ];

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('delivery_notification_i18n');
        $this->setPhpName('NotificationI18n');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Delivery\\Model\\NotificationI18n');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('delivery_id', 'DeliveryId', 'INTEGER' , 'delivery_notification', 'delivery_id', true, null, null);
        $this->addPrimaryKey('locale', 'Locale', 'VARCHAR', true, 5, 'en_US');
        $this->addColumn('email_title', 'EmailTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('email_content', 'EmailContent', 'LONGVARCHAR', false, null, null);
        $this->addColumn('feed_title', 'FeedTitle', 'VARCHAR', false, 255, null);
        $this->addColumn('feed_content', 'FeedContent', 'LONGVARCHAR', false, null, null);
        $this->addColumn('sms_content', 'SmsContent', 'LONGVARCHAR', false, null, null);
        $this->addColumn('link_text', 'LinkText', 'VARCHAR', false, 255, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Notification', '\\Delivery\\Model\\Notification', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':delivery_id',
    1 => ':delivery_id',
  ),
), 'CASCADE', null, null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Delivery\Model\NotificationI18n $obj A \Delivery\Model\NotificationI18n object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getDeliveryId() || is_scalar($obj->getDeliveryId()) || is_callable([$obj->getDeliveryId(), '__toString']) ? (string) $obj->getDeliveryId() : $obj->getDeliveryId()), (null === $obj->getLocale() || is_scalar($obj->getLocale()) || is_callable([$obj->getLocale(), '__toString']) ? (string) $obj->getLocale() : $obj->getLocale())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Delivery\Model\NotificationI18n object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Delivery\Model\NotificationI18n) {
                $key = serialize([(null === $value->getDeliveryId() || is_scalar($value->getDeliveryId()) || is_callable([$value->getDeliveryId(), '__toString']) ? (string) $value->getDeliveryId() : $value->getDeliveryId()), (null === $value->getLocale() || is_scalar($value->getLocale()) || is_callable([$value->getLocale(), '__toString']) ? (string) $value->getLocale() : $value->getLocale())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Delivery\Model\NotificationI18n object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DeliveryId', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DeliveryId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DeliveryId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DeliveryId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DeliveryId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('DeliveryId', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)])]);
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('DeliveryId', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? NotificationI18nTableMap::CLASS_DEFAULT : NotificationI18nTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (NotificationI18n object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = NotificationI18nTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = NotificationI18nTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + NotificationI18nTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = NotificationI18nTableMap::OM_CLASS;
            /** @var NotificationI18n $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            NotificationI18nTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = NotificationI18nTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = NotificationI18nTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var NotificationI18n $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                NotificationI18nTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(NotificationI18nTableMap::COL_DELIVERY_ID);
            $criteria->addSelectColumn(NotificationI18nTableMap::COL_LOCALE);
            $criteria->addSelectColumn(NotificationI18nTableMap::COL_EMAIL_TITLE);
            $criteria->addSelectColumn(NotificationI18nTableMap::COL_EMAIL_CONTENT);
            $criteria->addSelectColumn(NotificationI18nTableMap::COL_FEED_TITLE);
            $criteria->addSelectColumn(NotificationI18nTableMap::COL_FEED_CONTENT);
            $criteria->addSelectColumn(NotificationI18nTableMap::COL_SMS_CONTENT);
            $criteria->addSelectColumn(NotificationI18nTableMap::COL_LINK_TEXT);
        } else {
            $criteria->addSelectColumn($alias . '.delivery_id');
            $criteria->addSelectColumn($alias . '.locale');
            $criteria->addSelectColumn($alias . '.email_title');
            $criteria->addSelectColumn($alias . '.email_content');
            $criteria->addSelectColumn($alias . '.feed_title');
            $criteria->addSelectColumn($alias . '.feed_content');
            $criteria->addSelectColumn($alias . '.sms_content');
            $criteria->addSelectColumn($alias . '.link_text');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria object containing the columns to remove.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function removeSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(NotificationI18nTableMap::COL_DELIVERY_ID);
            $criteria->removeSelectColumn(NotificationI18nTableMap::COL_LOCALE);
            $criteria->removeSelectColumn(NotificationI18nTableMap::COL_EMAIL_TITLE);
            $criteria->removeSelectColumn(NotificationI18nTableMap::COL_EMAIL_CONTENT);
            $criteria->removeSelectColumn(NotificationI18nTableMap::COL_FEED_TITLE);
            $criteria->removeSelectColumn(NotificationI18nTableMap::COL_FEED_CONTENT);
            $criteria->removeSelectColumn(NotificationI18nTableMap::COL_SMS_CONTENT);
            $criteria->removeSelectColumn(NotificationI18nTableMap::COL_LINK_TEXT);
        } else {
            $criteria->removeSelectColumn($alias . '.delivery_id');
            $criteria->removeSelectColumn($alias . '.locale');
            $criteria->removeSelectColumn($alias . '.email_title');
            $criteria->removeSelectColumn($alias . '.email_content');
            $criteria->removeSelectColumn($alias . '.feed_title');
            $criteria->removeSelectColumn($alias . '.feed_content');
            $criteria->removeSelectColumn($alias . '.sms_content');
            $criteria->removeSelectColumn($alias . '.link_text');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(NotificationI18nTableMap::DATABASE_NAME)->getTable(NotificationI18nTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(NotificationI18nTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(NotificationI18nTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new NotificationI18nTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a NotificationI18n or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or NotificationI18n object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationI18nTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Delivery\Model\NotificationI18n) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(NotificationI18nTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(NotificationI18nTableMap::COL_DELIVERY_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(NotificationI18nTableMap::COL_LOCALE, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = NotificationI18nQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            NotificationI18nTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                NotificationI18nTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the delivery_notification_i18n table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return NotificationI18nQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a NotificationI18n or Criteria object.
     *
     * @param mixed               $criteria Criteria or NotificationI18n object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationI18nTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from NotificationI18n object
        }


        // Set the correct dbName
        $query = NotificationI18nQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // NotificationI18nTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
NotificationI18nTableMap::buildTableMap();
