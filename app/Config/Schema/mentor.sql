SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `tenants`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `tenants` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `active` TINYINT(1) NULL ,
  `tenant_id` INT NOT NULL ,
  `roletype_id` INT NULL ,
  `parent_id` INT NULL ,
  `email` VARCHAR(255) NULL ,
  `password` VARCHAR(50) NULL ,
  `first_name` VARCHAR(255) NULL ,
  `last_name` VARCHAR(255) NULL ,
  `phone_number` VARCHAR(255) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `roletypes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `roletypes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `importance` INT NOT NULL COMMENT 'Lower number means\nmore important' ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `profiles`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `profiles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `notes` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cake_sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `cake_sessions` (
  `id` VARCHAR(255) NOT NULL DEFAULT '' ,
  `data` TEXT NULL ,
  `expires` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mentee_extra_info`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mentee_extra_info` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `date_joined` DATE NULL ,
  `company_name` VARCHAR(100) NULL ,
  `company_web_site` VARCHAR(100) NULL ,
  `statement_of_purpose_sent` TINYINT(1) NULL ,
  `date_statement_of_purpose_sent` DATE NULL ,
  `waiver_form_signed` TINYINT(1) NULL ,
  `date_waiver_form_signed` DATE NULL ,
  `signed_on_to_chamber` TINYINT(1) NULL ,
  `date_signed_on_to_chamber` DATETIME NULL ,
  `invoiced` TINYINT(1) NULL ,
  `date_invoiced` DATE NULL ,
  `payment_received` TINYINT(1) NULL ,
  `date_payment_received` DATE NULL ,
  `coordinator_invoice_sent` TINYINT(1) NULL ,
  `date_coordinator_invoice_sent` DATE NULL ,
  `balance_paid` TINYINT(1) NULL ,
  `date_balance_paid` DATE NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB
COMMENT = 'Contains additional info about mentees';


-- -----------------------------------------------------
-- Table `mentor_extra_info`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mentor_extra_info` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `date_joined` DATE NULL ,
  `trained` TINYINT(1) NULL ,
  `agreement_signed` TINYINT(1) NULL ,
  `date_agreement_signed` DATE NULL ,
  `date_trained` DATE NULL ,
  `max_mentees` INT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_away_dates`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_away_dates` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `first_day_away` DATE NULL ,
  `last_day_away` DATE NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mentee_surveys`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mentee_surveys` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NULL ,
  `date_sent` DATE NULL ,
  `returned` TINYINT(1) NULL ,
  `date_returned` VARCHAR(45) NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_expense_claims`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_expense_claims` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `description` TEXT NULL ,
  `amount` DECIMAL(6,2) NULL COMMENT 'Allow a maximum of 9999.99' ,
  `date_claimed` DATE NULL ,
  `reimbursed` TINYINT(1) NULL ,
  `date_reimbursed` DATE NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_addresses`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_addresses` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `address_type` TINYINT NULL COMMENT 'e.g. for work or home' ,
  `street` VARCHAR(100) NULL ,
  `suburb` VARCHAR(100) NULL ,
  `state` VARCHAR(30) NULL ,
  `postcode` VARCHAR(10) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_notes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user_notes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `notes` TEXT NULL ,
  `created` DATETIME NULL ,
  `modified` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `tenants`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `tenants` (`id`, `name`, `created`, `modified`) VALUES (1, 'Master', '2012-06-09 13:00:00', '2012-06-09 13:00:00');

COMMIT;

-- -----------------------------------------------------
-- Data for table `roletypes`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `roletypes` (`id`, `name`, `importance`, `created`, `modified`) VALUES (1, 'Superadmin', 10, '2012-06-09 13:00:00', '2012-06-09 13:00:00');
INSERT INTO `roletypes` (`id`, `name`, `importance`, `created`, `modified`) VALUES (2, 'Admin', 20, '2012-06-09 13:00:00', '2012-06-09 13:00:00');
INSERT INTO `roletypes` (`id`, `name`, `importance`, `created`, `modified`) VALUES (3, 'Coordinator', 30, '2012-06-09 13:00:00', '2012-06-09 13:00:00');
INSERT INTO `roletypes` (`id`, `name`, `importance`, `created`, `modified`) VALUES (4, 'Mentor', 40, '2012-06-09 13:00:00', '2012-06-09 13:00:00');
INSERT INTO `roletypes` (`id`, `name`, `importance`, `created`, `modified`) VALUES (5, 'Mentee', 50, '2012-06-09 13:00:00', '2012-06-09 13:00:00');

COMMIT;
