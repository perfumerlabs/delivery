<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1616677278.
 * Generated on 2021-03-25 19:01:18 by root
 */
class PropelMigration_1616677278
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'delivery' => '
BEGIN;

CREATE TABLE "delivery_delivery"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "data_url" VARCHAR(255) NOT NULL,
    "filters" TEXT,
    "status" INT2 DEFAULT 0 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

CREATE TABLE "delivery_notification"
(
    "delivery_id" INTEGER NOT NULL,
    "has_email" BOOLEAN DEFAULT \'f\' NOT NULL,
    "has_feed" BOOLEAN DEFAULT \'f\' NOT NULL,
    "has_sms" BOOLEAN DEFAULT \'f\' NOT NULL,
    "link_url" VARCHAR(255),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("delivery_id"),
    CONSTRAINT "delivery_notification_u_d4811b" UNIQUE ("delivery_id")
);

CREATE TABLE "delivery_notification_i18n"
(
    "delivery_id" INTEGER NOT NULL,
    "locale" VARCHAR(5) DEFAULT \'en_US\' NOT NULL,
    "email_title" VARCHAR(255),
    "email_content" TEXT,
    "feed_title" VARCHAR(255),
    "feed_content" TEXT,
    "sms_content" TEXT,
    "link_text" VARCHAR(255),
    PRIMARY KEY ("delivery_id","locale")
);

ALTER TABLE "delivery_notification" ADD CONSTRAINT "delivery_notification_fk_dabe67"
    FOREIGN KEY ("delivery_id")
    REFERENCES "delivery_delivery" ("id")
    ON DELETE CASCADE;

ALTER TABLE "delivery_notification_i18n" ADD CONSTRAINT "delivery_notification_i18n_fk_2bb2d5"
    FOREIGN KEY ("delivery_id")
    REFERENCES "delivery_notification" ("delivery_id")
    ON DELETE CASCADE;

COMMIT;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'delivery' => '
BEGIN;

DROP TABLE IF EXISTS "delivery_delivery" CASCADE;

DROP TABLE IF EXISTS "delivery_notification" CASCADE;

DROP TABLE IF EXISTS "delivery_notification_i18n" CASCADE;

COMMIT;
',
);
    }

}