<?php

namespace Delivery\Model\Map;

use Delivery\Model\Delivery;
use Delivery\Model\DeliveryQuery;
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
 * This class defines the structure of the 'delivery_delivery' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class DeliveryTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DeliveryTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'delivery';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'delivery_delivery';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Delivery\\Model\\Delivery';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Delivery';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'delivery_delivery.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'delivery_delivery.name';

    /**
     * the column name for the has_email field
     */
    const COL_HAS_EMAIL = 'delivery_delivery.has_email';

    /**
     * the column name for the has_feed field
     */
    const COL_HAS_FEED = 'delivery_delivery.has_feed';

    /**
     * the column name for the has_sms field
     */
    const COL_HAS_SMS = 'delivery_delivery.has_sms';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'delivery_delivery.status';

    /**
     * the column name for the nb_sent_notifications field
     */
    const COL_NB_SENT_NOTIFICATIONS = 'delivery_delivery.nb_sent_notifications';

    /**
     * the column name for the nb_all_notifications field
     */
    const COL_NB_ALL_NOTIFICATIONS = 'delivery_delivery.nb_all_notifications';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'delivery_delivery.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'delivery_delivery.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the status field */
    const COL_STATUS_STARTED = 'started';
    const COL_STATUS_CANCELED = 'canceled';
    const COL_STATUS_FINISHED = 'finished';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Name', 'HasEmail', 'HasFeed', 'HasSms', 'Status', 'NbSentNotifications', 'NbAllNotifications', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'hasEmail', 'hasFeed', 'hasSms', 'status', 'nbSentNotifications', 'nbAllNotifications', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(DeliveryTableMap::COL_ID, DeliveryTableMap::COL_NAME, DeliveryTableMap::COL_HAS_EMAIL, DeliveryTableMap::COL_HAS_FEED, DeliveryTableMap::COL_HAS_SMS, DeliveryTableMap::COL_STATUS, DeliveryTableMap::COL_NB_SENT_NOTIFICATIONS, DeliveryTableMap::COL_NB_ALL_NOTIFICATIONS, DeliveryTableMap::COL_CREATED_AT, DeliveryTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'has_email', 'has_feed', 'has_sms', 'status', 'nb_sent_notifications', 'nb_all_notifications', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'HasEmail' => 2, 'HasFeed' => 3, 'HasSms' => 4, 'Status' => 5, 'NbSentNotifications' => 6, 'NbAllNotifications' => 7, 'CreatedAt' => 8, 'UpdatedAt' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'hasEmail' => 2, 'hasFeed' => 3, 'hasSms' => 4, 'status' => 5, 'nbSentNotifications' => 6, 'nbAllNotifications' => 7, 'createdAt' => 8, 'updatedAt' => 9, ),
        self::TYPE_COLNAME       => array(DeliveryTableMap::COL_ID => 0, DeliveryTableMap::COL_NAME => 1, DeliveryTableMap::COL_HAS_EMAIL => 2, DeliveryTableMap::COL_HAS_FEED => 3, DeliveryTableMap::COL_HAS_SMS => 4, DeliveryTableMap::COL_STATUS => 5, DeliveryTableMap::COL_NB_SENT_NOTIFICATIONS => 6, DeliveryTableMap::COL_NB_ALL_NOTIFICATIONS => 7, DeliveryTableMap::COL_CREATED_AT => 8, DeliveryTableMap::COL_UPDATED_AT => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'has_email' => 2, 'has_feed' => 3, 'has_sms' => 4, 'status' => 5, 'nb_sent_notifications' => 6, 'nb_all_notifications' => 7, 'created_at' => 8, 'updated_at' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [

        'Id' => 'ID',
        'Delivery.Id' => 'ID',
        'id' => 'ID',
        'delivery.id' => 'ID',
        'DeliveryTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'id' => 'ID',
        'delivery_delivery.id' => 'ID',
        'Name' => 'NAME',
        'Delivery.Name' => 'NAME',
        'name' => 'NAME',
        'delivery.name' => 'NAME',
        'DeliveryTableMap::COL_NAME' => 'NAME',
        'COL_NAME' => 'NAME',
        'name' => 'NAME',
        'delivery_delivery.name' => 'NAME',
        'HasEmail' => 'HAS_EMAIL',
        'Delivery.HasEmail' => 'HAS_EMAIL',
        'hasEmail' => 'HAS_EMAIL',
        'delivery.hasEmail' => 'HAS_EMAIL',
        'DeliveryTableMap::COL_HAS_EMAIL' => 'HAS_EMAIL',
        'COL_HAS_EMAIL' => 'HAS_EMAIL',
        'has_email' => 'HAS_EMAIL',
        'delivery_delivery.has_email' => 'HAS_EMAIL',
        'HasFeed' => 'HAS_FEED',
        'Delivery.HasFeed' => 'HAS_FEED',
        'hasFeed' => 'HAS_FEED',
        'delivery.hasFeed' => 'HAS_FEED',
        'DeliveryTableMap::COL_HAS_FEED' => 'HAS_FEED',
        'COL_HAS_FEED' => 'HAS_FEED',
        'has_feed' => 'HAS_FEED',
        'delivery_delivery.has_feed' => 'HAS_FEED',
        'HasSms' => 'HAS_SMS',
        'Delivery.HasSms' => 'HAS_SMS',
        'hasSms' => 'HAS_SMS',
        'delivery.hasSms' => 'HAS_SMS',
        'DeliveryTableMap::COL_HAS_SMS' => 'HAS_SMS',
        'COL_HAS_SMS' => 'HAS_SMS',
        'has_sms' => 'HAS_SMS',
        'delivery_delivery.has_sms' => 'HAS_SMS',
        'Status' => 'STATUS',
        'Delivery.Status' => 'STATUS',
        'status' => 'STATUS',
        'delivery.status' => 'STATUS',
        'DeliveryTableMap::COL_STATUS' => 'STATUS',
        'COL_STATUS' => 'STATUS',
        'status' => 'STATUS',
        'delivery_delivery.status' => 'STATUS',
        'NbSentNotifications' => 'NB_SENT_NOTIFICATIONS',
        'Delivery.NbSentNotifications' => 'NB_SENT_NOTIFICATIONS',
        'nbSentNotifications' => 'NB_SENT_NOTIFICATIONS',
        'delivery.nbSentNotifications' => 'NB_SENT_NOTIFICATIONS',
        'DeliveryTableMap::COL_NB_SENT_NOTIFICATIONS' => 'NB_SENT_NOTIFICATIONS',
        'COL_NB_SENT_NOTIFICATIONS' => 'NB_SENT_NOTIFICATIONS',
        'nb_sent_notifications' => 'NB_SENT_NOTIFICATIONS',
        'delivery_delivery.nb_sent_notifications' => 'NB_SENT_NOTIFICATIONS',
        'NbAllNotifications' => 'NB_ALL_NOTIFICATIONS',
        'Delivery.NbAllNotifications' => 'NB_ALL_NOTIFICATIONS',
        'nbAllNotifications' => 'NB_ALL_NOTIFICATIONS',
        'delivery.nbAllNotifications' => 'NB_ALL_NOTIFICATIONS',
        'DeliveryTableMap::COL_NB_ALL_NOTIFICATIONS' => 'NB_ALL_NOTIFICATIONS',
        'COL_NB_ALL_NOTIFICATIONS' => 'NB_ALL_NOTIFICATIONS',
        'nb_all_notifications' => 'NB_ALL_NOTIFICATIONS',
        'delivery_delivery.nb_all_notifications' => 'NB_ALL_NOTIFICATIONS',
        'CreatedAt' => 'CREATED_AT',
        'Delivery.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'delivery.createdAt' => 'CREATED_AT',
        'DeliveryTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'delivery_delivery.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'Delivery.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'delivery.updatedAt' => 'UPDATED_AT',
        'DeliveryTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'delivery_delivery.updated_at' => 'UPDATED_AT',
    ];

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                DeliveryTableMap::COL_STATUS => array(
                            self::COL_STATUS_STARTED,
            self::COL_STATUS_CANCELED,
            self::COL_STATUS_FINISHED,
        ),
    );

    /**
     * Gets the list of values for all ENUM and SET columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM or SET column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

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
        $this->setName('delivery_delivery');
        $this->setPhpName('Delivery');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Delivery\\Model\\Delivery');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('delivery_delivery_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('has_email', 'HasEmail', 'BOOLEAN', true, null, false);
        $this->addColumn('has_feed', 'HasFeed', 'BOOLEAN', true, null, false);
        $this->addColumn('has_sms', 'HasSms', 'BOOLEAN', true, null, false);
        $this->addColumn('status', 'Status', 'ENUM', true, null, 'started');
        $this->getColumn('status')->setValueSet(array (
  0 => 'started',
  1 => 'canceled',
  2 => 'finished',
));
        $this->addColumn('nb_sent_notifications', 'NbSentNotifications', 'INTEGER', false, null, 0);
        $this->addColumn('nb_all_notifications', 'NbAllNotifications', 'INTEGER', false, null, 0);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Notification', '\\Delivery\\Model\\Notification', RelationMap::ONE_TO_ONE, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
            'delegate' => array('to' => 'delivery_notification', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to delivery_delivery     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        NotificationTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? DeliveryTableMap::CLASS_DEFAULT : DeliveryTableMap::OM_CLASS;
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
     * @return array           (Delivery object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DeliveryTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DeliveryTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DeliveryTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DeliveryTableMap::OM_CLASS;
            /** @var Delivery $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DeliveryTableMap::addInstanceToPool($obj, $key);
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
            $key = DeliveryTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DeliveryTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Delivery $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DeliveryTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DeliveryTableMap::COL_ID);
            $criteria->addSelectColumn(DeliveryTableMap::COL_NAME);
            $criteria->addSelectColumn(DeliveryTableMap::COL_HAS_EMAIL);
            $criteria->addSelectColumn(DeliveryTableMap::COL_HAS_FEED);
            $criteria->addSelectColumn(DeliveryTableMap::COL_HAS_SMS);
            $criteria->addSelectColumn(DeliveryTableMap::COL_STATUS);
            $criteria->addSelectColumn(DeliveryTableMap::COL_NB_SENT_NOTIFICATIONS);
            $criteria->addSelectColumn(DeliveryTableMap::COL_NB_ALL_NOTIFICATIONS);
            $criteria->addSelectColumn(DeliveryTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(DeliveryTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.has_email');
            $criteria->addSelectColumn($alias . '.has_feed');
            $criteria->addSelectColumn($alias . '.has_sms');
            $criteria->addSelectColumn($alias . '.status');
            $criteria->addSelectColumn($alias . '.nb_sent_notifications');
            $criteria->addSelectColumn($alias . '.nb_all_notifications');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
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
            $criteria->removeSelectColumn(DeliveryTableMap::COL_ID);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_NAME);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_HAS_EMAIL);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_HAS_FEED);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_HAS_SMS);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_STATUS);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_NB_SENT_NOTIFICATIONS);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_NB_ALL_NOTIFICATIONS);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(DeliveryTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.name');
            $criteria->removeSelectColumn($alias . '.has_email');
            $criteria->removeSelectColumn($alias . '.has_feed');
            $criteria->removeSelectColumn($alias . '.has_sms');
            $criteria->removeSelectColumn($alias . '.status');
            $criteria->removeSelectColumn($alias . '.nb_sent_notifications');
            $criteria->removeSelectColumn($alias . '.nb_all_notifications');
            $criteria->removeSelectColumn($alias . '.created_at');
            $criteria->removeSelectColumn($alias . '.updated_at');
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
        return Propel::getServiceContainer()->getDatabaseMap(DeliveryTableMap::DATABASE_NAME)->getTable(DeliveryTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DeliveryTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DeliveryTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DeliveryTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Delivery or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Delivery object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DeliveryTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Delivery\Model\Delivery) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DeliveryTableMap::DATABASE_NAME);
            $criteria->add(DeliveryTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DeliveryQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DeliveryTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DeliveryTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the delivery_delivery table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DeliveryQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Delivery or Criteria object.
     *
     * @param mixed               $criteria Criteria or Delivery object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DeliveryTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Delivery object
        }

        if ($criteria->containsKey(DeliveryTableMap::COL_ID) && $criteria->keyContainsValue(DeliveryTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DeliveryTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DeliveryQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DeliveryTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DeliveryTableMap::buildTableMap();
