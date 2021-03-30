<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1617027030.
 * Generated on 2021-03-29 20:10:30 by root
 */
class PropelMigration_1617027030
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
    "has_email" BOOLEAN DEFAULT \'f\' NOT NULL,
    "has_feed" BOOLEAN DEFAULT \'f\' NOT NULL,
    "has_sms" BOOLEAN DEFAULT \'f\' NOT NULL,
    "status" INT2 DEFAULT 0 NOT NULL,
    "nb_sent_notifications" INTEGER DEFAULT 0,
    "nb_all_notifications" INTEGER DEFAULT 0,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

CREATE TABLE "delivery_notification"
(
    "data_url" VARCHAR(255) NOT NULL,
    "filters" JSON,
    "feed_payload" JSON,
    "payload" JSON,
    "id" INTEGER NOT NULL,
    PRIMARY KEY ("id")
);

CREATE TABLE "delivery_notification_i18n"
(
    "id" INTEGER NOT NULL,
    "locale" VARCHAR(5) DEFAULT \'en_US\' NOT NULL,
    "email_subject" VARCHAR(255),
    "email_html" TEXT,
    "sms_message" TEXT,
    "feed_title" VARCHAR(255),
    "feed_text" TEXT,
    "feed_image" VARCHAR(255),
    PRIMARY KEY ("id","locale")
);

ALTER TABLE "delivery_notification" ADD CONSTRAINT "delivery_notification_fk_cca7da"
    FOREIGN KEY ("id")
    REFERENCES "delivery_delivery" ("id")
    ON DELETE CASCADE;

ALTER TABLE "delivery_notification_i18n" ADD CONSTRAINT "delivery_notification_i18n_fk_f143f9"
    FOREIGN KEY ("id")
    REFERENCES "delivery_notification" ("id")
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