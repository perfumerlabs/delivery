<?php

namespace Delivery\Model\Base;

use \Exception;
use \PDO;
use Delivery\Model\Notification as ChildNotification;
use Delivery\Model\NotificationI18nQuery as ChildNotificationI18nQuery;
use Delivery\Model\NotificationQuery as ChildNotificationQuery;
use Delivery\Model\Map\NotificationI18nTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'delivery_notification_i18n' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class NotificationI18n implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Delivery\\Model\\Map\\NotificationI18nTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the delivery_id field.
     *
     * @var        int
     */
    protected $delivery_id;

    /**
     * The value for the locale field.
     *
     * Note: this column has a database default value of: 'en_US'
     * @var        string
     */
    protected $locale;

    /**
     * The value for the email_title field.
     *
     * @var        string|null
     */
    protected $email_title;

    /**
     * The value for the email_content field.
     *
     * @var        string|null
     */
    protected $email_content;

    /**
     * The value for the feed_title field.
     *
     * @var        string|null
     */
    protected $feed_title;

    /**
     * The value for the feed_content field.
     *
     * @var        string|null
     */
    protected $feed_content;

    /**
     * The value for the sms_content field.
     *
     * @var        string|null
     */
    protected $sms_content;

    /**
     * The value for the link_text field.
     *
     * @var        string|null
     */
    protected $link_text;

    /**
     * @var        ChildNotification
     */
    protected $aNotification;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->locale = 'en_US';
    }

    /**
     * Initializes internal state of Delivery\Model\Base\NotificationI18n object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>NotificationI18n</code> instance.  If
     * <code>obj</code> is an instance of <code>NotificationI18n</code>, delegates to
     * <code>equals(NotificationI18n)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [delivery_id] column value.
     *
     * @return int
     */
    public function getDeliveryId()
    {
        return $this->delivery_id;
    }

    /**
     * Get the [locale] column value.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Get the [email_title] column value.
     *
     * @return string|null
     */
    public function getEmailTitle()
    {
        return $this->email_title;
    }

    /**
     * Get the [email_content] column value.
     *
     * @return string|null
     */
    public function getEmailContent()
    {
        return $this->email_content;
    }

    /**
     * Get the [feed_title] column value.
     *
     * @return string|null
     */
    public function getFeedTitle()
    {
        return $this->feed_title;
    }

    /**
     * Get the [feed_content] column value.
     *
     * @return string|null
     */
    public function getFeedContent()
    {
        return $this->feed_content;
    }

    /**
     * Get the [sms_content] column value.
     *
     * @return string|null
     */
    public function getSmsContent()
    {
        return $this->sms_content;
    }

    /**
     * Get the [link_text] column value.
     *
     * @return string|null
     */
    public function getLinkText()
    {
        return $this->link_text;
    }

    /**
     * Set the value of [delivery_id] column.
     *
     * @param int $v New value
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     */
    public function setDeliveryId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->delivery_id !== $v) {
            $this->delivery_id = $v;
            $this->modifiedColumns[NotificationI18nTableMap::COL_DELIVERY_ID] = true;
        }

        if ($this->aNotification !== null && $this->aNotification->getDeliveryId() !== $v) {
            $this->aNotification = null;
        }

        return $this;
    } // setDeliveryId()

    /**
     * Set the value of [locale] column.
     *
     * @param string $v New value
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     */
    public function setLocale($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->locale !== $v) {
            $this->locale = $v;
            $this->modifiedColumns[NotificationI18nTableMap::COL_LOCALE] = true;
        }

        return $this;
    } // setLocale()

    /**
     * Set the value of [email_title] column.
     *
     * @param string|null $v New value
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     */
    public function setEmailTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email_title !== $v) {
            $this->email_title = $v;
            $this->modifiedColumns[NotificationI18nTableMap::COL_EMAIL_TITLE] = true;
        }

        return $this;
    } // setEmailTitle()

    /**
     * Set the value of [email_content] column.
     *
     * @param string|null $v New value
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     */
    public function setEmailContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email_content !== $v) {
            $this->email_content = $v;
            $this->modifiedColumns[NotificationI18nTableMap::COL_EMAIL_CONTENT] = true;
        }

        return $this;
    } // setEmailContent()

    /**
     * Set the value of [feed_title] column.
     *
     * @param string|null $v New value
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     */
    public function setFeedTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->feed_title !== $v) {
            $this->feed_title = $v;
            $this->modifiedColumns[NotificationI18nTableMap::COL_FEED_TITLE] = true;
        }

        return $this;
    } // setFeedTitle()

    /**
     * Set the value of [feed_content] column.
     *
     * @param string|null $v New value
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     */
    public function setFeedContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->feed_content !== $v) {
            $this->feed_content = $v;
            $this->modifiedColumns[NotificationI18nTableMap::COL_FEED_CONTENT] = true;
        }

        return $this;
    } // setFeedContent()

    /**
     * Set the value of [sms_content] column.
     *
     * @param string|null $v New value
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     */
    public function setSmsContent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->sms_content !== $v) {
            $this->sms_content = $v;
            $this->modifiedColumns[NotificationI18nTableMap::COL_SMS_CONTENT] = true;
        }

        return $this;
    } // setSmsContent()

    /**
     * Set the value of [link_text] column.
     *
     * @param string|null $v New value
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     */
    public function setLinkText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link_text !== $v) {
            $this->link_text = $v;
            $this->modifiedColumns[NotificationI18nTableMap::COL_LINK_TEXT] = true;
        }

        return $this;
    } // setLinkText()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->locale !== 'en_US') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : NotificationI18nTableMap::translateFieldName('DeliveryId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delivery_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : NotificationI18nTableMap::translateFieldName('Locale', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locale = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : NotificationI18nTableMap::translateFieldName('EmailTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : NotificationI18nTableMap::translateFieldName('EmailContent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email_content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : NotificationI18nTableMap::translateFieldName('FeedTitle', TableMap::TYPE_PHPNAME, $indexType)];
            $this->feed_title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : NotificationI18nTableMap::translateFieldName('FeedContent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->feed_content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : NotificationI18nTableMap::translateFieldName('SmsContent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sms_content = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : NotificationI18nTableMap::translateFieldName('LinkText', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link_text = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = NotificationI18nTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Delivery\\Model\\NotificationI18n'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aNotification !== null && $this->delivery_id !== $this->aNotification->getDeliveryId()) {
            $this->aNotification = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotificationI18nTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildNotificationI18nQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aNotification = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see NotificationI18n::setDeleted()
     * @see NotificationI18n::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationI18nTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildNotificationI18nQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationI18nTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                NotificationI18nTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aNotification !== null) {
                if ($this->aNotification->isModified() || $this->aNotification->isNew()) {
                    $affectedRows += $this->aNotification->save($con);
                }
                $this->setNotification($this->aNotification);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(NotificationI18nTableMap::COL_DELIVERY_ID)) {
            $modifiedColumns[':p' . $index++]  = 'delivery_id';
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_LOCALE)) {
            $modifiedColumns[':p' . $index++]  = 'locale';
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_EMAIL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'email_title';
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_EMAIL_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = 'email_content';
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_FEED_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'feed_title';
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_FEED_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = 'feed_content';
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_SMS_CONTENT)) {
            $modifiedColumns[':p' . $index++]  = 'sms_content';
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_LINK_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'link_text';
        }

        $sql = sprintf(
            'INSERT INTO delivery_notification_i18n (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'delivery_id':
                        $stmt->bindValue($identifier, $this->delivery_id, PDO::PARAM_INT);
                        break;
                    case 'locale':
                        $stmt->bindValue($identifier, $this->locale, PDO::PARAM_STR);
                        break;
                    case 'email_title':
                        $stmt->bindValue($identifier, $this->email_title, PDO::PARAM_STR);
                        break;
                    case 'email_content':
                        $stmt->bindValue($identifier, $this->email_content, PDO::PARAM_STR);
                        break;
                    case 'feed_title':
                        $stmt->bindValue($identifier, $this->feed_title, PDO::PARAM_STR);
                        break;
                    case 'feed_content':
                        $stmt->bindValue($identifier, $this->feed_content, PDO::PARAM_STR);
                        break;
                    case 'sms_content':
                        $stmt->bindValue($identifier, $this->sms_content, PDO::PARAM_STR);
                        break;
                    case 'link_text':
                        $stmt->bindValue($identifier, $this->link_text, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = NotificationI18nTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getDeliveryId();
                break;
            case 1:
                return $this->getLocale();
                break;
            case 2:
                return $this->getEmailTitle();
                break;
            case 3:
                return $this->getEmailContent();
                break;
            case 4:
                return $this->getFeedTitle();
                break;
            case 5:
                return $this->getFeedContent();
                break;
            case 6:
                return $this->getSmsContent();
                break;
            case 7:
                return $this->getLinkText();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['NotificationI18n'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['NotificationI18n'][$this->hashCode()] = true;
        $keys = NotificationI18nTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getDeliveryId(),
            $keys[1] => $this->getLocale(),
            $keys[2] => $this->getEmailTitle(),
            $keys[3] => $this->getEmailContent(),
            $keys[4] => $this->getFeedTitle(),
            $keys[5] => $this->getFeedContent(),
            $keys[6] => $this->getSmsContent(),
            $keys[7] => $this->getLinkText(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aNotification) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'notification';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'delivery_notification';
                        break;
                    default:
                        $key = 'Notification';
                }

                $result[$key] = $this->aNotification->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Delivery\Model\NotificationI18n
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = NotificationI18nTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Delivery\Model\NotificationI18n
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setDeliveryId($value);
                break;
            case 1:
                $this->setLocale($value);
                break;
            case 2:
                $this->setEmailTitle($value);
                break;
            case 3:
                $this->setEmailContent($value);
                break;
            case 4:
                $this->setFeedTitle($value);
                break;
            case 5:
                $this->setFeedContent($value);
                break;
            case 6:
                $this->setSmsContent($value);
                break;
            case 7:
                $this->setLinkText($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = NotificationI18nTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setDeliveryId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setLocale($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setEmailTitle($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setEmailContent($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFeedTitle($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setFeedContent($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setSmsContent($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLinkText($arr[$keys[7]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Delivery\Model\NotificationI18n The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(NotificationI18nTableMap::DATABASE_NAME);

        if ($this->isColumnModified(NotificationI18nTableMap::COL_DELIVERY_ID)) {
            $criteria->add(NotificationI18nTableMap::COL_DELIVERY_ID, $this->delivery_id);
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_LOCALE)) {
            $criteria->add(NotificationI18nTableMap::COL_LOCALE, $this->locale);
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_EMAIL_TITLE)) {
            $criteria->add(NotificationI18nTableMap::COL_EMAIL_TITLE, $this->email_title);
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_EMAIL_CONTENT)) {
            $criteria->add(NotificationI18nTableMap::COL_EMAIL_CONTENT, $this->email_content);
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_FEED_TITLE)) {
            $criteria->add(NotificationI18nTableMap::COL_FEED_TITLE, $this->feed_title);
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_FEED_CONTENT)) {
            $criteria->add(NotificationI18nTableMap::COL_FEED_CONTENT, $this->feed_content);
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_SMS_CONTENT)) {
            $criteria->add(NotificationI18nTableMap::COL_SMS_CONTENT, $this->sms_content);
        }
        if ($this->isColumnModified(NotificationI18nTableMap::COL_LINK_TEXT)) {
            $criteria->add(NotificationI18nTableMap::COL_LINK_TEXT, $this->link_text);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildNotificationI18nQuery::create();
        $criteria->add(NotificationI18nTableMap::COL_DELIVERY_ID, $this->delivery_id);
        $criteria->add(NotificationI18nTableMap::COL_LOCALE, $this->locale);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getDeliveryId() &&
            null !== $this->getLocale();

        $validPrimaryKeyFKs = 1;
        $primaryKeyFKs = [];

        //relation delivery_notification_i18n_fk_2bb2d5 to table delivery_notification
        if ($this->aNotification && $hash = spl_object_hash($this->aNotification)) {
            $primaryKeyFKs[] = $hash;
        } else {
            $validPrimaryKeyFKs = false;
        }

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the composite primary key for this object.
     * The array elements will be in same order as specified in XML.
     * @return array
     */
    public function getPrimaryKey()
    {
        $pks = array();
        $pks[0] = $this->getDeliveryId();
        $pks[1] = $this->getLocale();

        return $pks;
    }

    /**
     * Set the [composite] primary key.
     *
     * @param      array $keys The elements of the composite key (order must match the order in XML file).
     * @return void
     */
    public function setPrimaryKey($keys)
    {
        $this->setDeliveryId($keys[0]);
        $this->setLocale($keys[1]);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return (null === $this->getDeliveryId()) && (null === $this->getLocale());
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Delivery\Model\NotificationI18n (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDeliveryId($this->getDeliveryId());
        $copyObj->setLocale($this->getLocale());
        $copyObj->setEmailTitle($this->getEmailTitle());
        $copyObj->setEmailContent($this->getEmailContent());
        $copyObj->setFeedTitle($this->getFeedTitle());
        $copyObj->setFeedContent($this->getFeedContent());
        $copyObj->setSmsContent($this->getSmsContent());
        $copyObj->setLinkText($this->getLinkText());
        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Delivery\Model\NotificationI18n Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildNotification object.
     *
     * @param  ChildNotification $v
     * @return $this|\Delivery\Model\NotificationI18n The current object (for fluent API support)
     * @throws PropelException
     */
    public function setNotification(ChildNotification $v = null)
    {
        if ($v === null) {
            $this->setDeliveryId(NULL);
        } else {
            $this->setDeliveryId($v->getDeliveryId());
        }

        $this->aNotification = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildNotification object, it will not be re-added.
        if ($v !== null) {
            $v->addNotificationI18n($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildNotification object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildNotification The associated ChildNotification object.
     * @throws PropelException
     */
    public function getNotification(ConnectionInterface $con = null)
    {
        if ($this->aNotification === null && ($this->delivery_id != 0)) {
            $this->aNotification = ChildNotificationQuery::create()->findPk($this->delivery_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aNotification->addNotificationI18ns($this);
             */
        }

        return $this->aNotification;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aNotification) {
            $this->aNotification->removeNotificationI18n($this);
        }
        $this->delivery_id = null;
        $this->locale = null;
        $this->email_title = null;
        $this->email_content = null;
        $this->feed_title = null;
        $this->feed_content = null;
        $this->sms_content = null;
        $this->link_text = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aNotification = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(NotificationI18nTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
