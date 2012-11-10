
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- edf_farmvideo
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `edf_farmvideo`;

CREATE TABLE `edf_farmvideo`
(
    `fv_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `fv_code` VARCHAR(50) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`fv_id`)
) ENGINE=InnoDB CHARACTER SET='utf8' COMMENT='farm live video';

-- ---------------------------------------------------------------------
-- edf_indexpic
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `edf_indexpic`;

CREATE TABLE `edf_indexpic`
(
    `ip_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
    `ip_filename` VARCHAR(100) NOT NULL,
    `ip_description` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`ip_id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- edf_products
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `edf_products`;

CREATE TABLE `edf_products`
(
    `prod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `prod_name` VARCHAR(100) NOT NULL,
    `prod_price` INTEGER(10) NOT NULL,
    `prod_unit` VARCHAR(10) NOT NULL,
    `prod_catgory` int(5) unsigned,
    `prod_pic` VARCHAR(100) NOT NULL,
    `prod_url` VARCHAR(255),
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`prod_id`),
    INDEX `prod_name` (`prod_name`),
    INDEX `edf_products_FI_1` (`prod_catgory`),
    CONSTRAINT `edf_products_FK_1`
        FOREIGN KEY (`prod_catgory`)
        REFERENCES `edf_productType` (`pt_id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- edf_productType
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `edf_productType`;

CREATE TABLE `edf_productType`
(
    `pt_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
    `pt_name` VARCHAR(100) NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- edf_book
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `edf_book`;

CREATE TABLE `edf_book`
(
    `book_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
    `book_name` VARCHAR(100) NOT NULL,
    `book_email` VARCHAR(100),
    `book_content` TEXT NOT NULL,
    `book_answer` TEXT,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`book_id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
