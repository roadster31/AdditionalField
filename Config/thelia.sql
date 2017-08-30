
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- product_additional_information
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_additional_information`;

CREATE TABLE `product_additional_information`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `object_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `FI_product_additional_information_product_id` (`object_id`),
    CONSTRAINT `fk_product_additional_information_product_id`
        FOREIGN KEY (`object_id`)
        REFERENCES `product` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- folder_additional_information
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `folder_additional_information`;

CREATE TABLE `folder_additional_information`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `object_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `FI_folder_additional_information_folder_id` (`object_id`),
    CONSTRAINT `fk_folder_additional_information_folder_id`
        FOREIGN KEY (`object_id`)
        REFERENCES `folder` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- category_additional_information
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category_additional_information`;

CREATE TABLE `category_additional_information`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `object_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `FI_category_additional_information_category_id` (`object_id`),
    CONSTRAINT `fk_category_additional_information_category_id`
        FOREIGN KEY (`object_id`)
        REFERENCES `category` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- content_additional_information
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `content_additional_information`;

CREATE TABLE `content_additional_information`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `object_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `FI_content_additional_information_content_id` (`object_id`),
    CONSTRAINT `fk_content_additional_information_content_id`
        FOREIGN KEY (`object_id`)
        REFERENCES `content` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- product_additional_information_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_additional_information_i18n`;

CREATE TABLE `product_additional_information_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `information` LONGTEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `product_additional_information_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `product_additional_information` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- folder_additional_information_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `folder_additional_information_i18n`;

CREATE TABLE `folder_additional_information_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `information` LONGTEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `folder_additional_information_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `folder_additional_information` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- category_additional_information_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `category_additional_information_i18n`;

CREATE TABLE `category_additional_information_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `information` LONGTEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `category_additional_information_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `category_additional_information` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- content_additional_information_i18n
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `content_additional_information_i18n`;

CREATE TABLE `content_additional_information_i18n`
(
    `id` INTEGER NOT NULL,
    `locale` VARCHAR(5) DEFAULT 'en_US' NOT NULL,
    `information` LONGTEXT,
    PRIMARY KEY (`id`,`locale`),
    CONSTRAINT `content_additional_information_i18n_FK_1`
        FOREIGN KEY (`id`)
        REFERENCES `content_additional_information` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
