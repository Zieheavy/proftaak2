-- MySQL Script generated by MySQL Workbench
-- Thu Nov 22 10:05:46 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema proftaak2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema proftaak2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `proftaak2` DEFAULT CHARACTER SET utf8 ;
USE `proftaak2` ;

-- -----------------------------------------------------
-- Table `proftaak2`.`colleges`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proftaak2`.`colleges` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proftaak2`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proftaak2`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(200) NULL,
  `password` VARCHAR(400) NULL,
  `confirm` TINYINT NULL,
  `newcollege` TINYINT NULL,
  `colleges_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_users_colleges1_idx` (`colleges_id` ASC),
  CONSTRAINT `fk_users_colleges1`
    FOREIGN KEY (`colleges_id`)
    REFERENCES `proftaak2`.`colleges` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proftaak2`.`mergedfiles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proftaak2`.`mergedfiles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(200) NULL,
  `version` INT NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mergedfiles_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_mergedfiles_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `proftaak2`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proftaak2`.`sourcefiles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proftaak2`.`sourcefiles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(400) NULL,
  `extension` VARCHAR(10) NULL,
  `version` INT NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_sourcefiles_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_sourcefiles_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `proftaak2`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proftaak2`.`attached-files`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proftaak2`.`attached-files` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `pages` VARCHAR(400) NULL,
  `mergedfiles_id` INT NOT NULL,
  `sourcefiles_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_attached-files_mergedfiles1_idx` (`mergedfiles_id` ASC),
  INDEX `fk_attached-files_sourcefiles1_idx` (`sourcefiles_id` ASC),
  CONSTRAINT `fk_attached-files_mergedfiles1`
    FOREIGN KEY (`mergedfiles_id`)
    REFERENCES `proftaak2`.`mergedfiles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_attached-files_sourcefiles1`
    FOREIGN KEY (`sourcefiles_id`)
    REFERENCES `proftaak2`.`sourcefiles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proftaak2`.`courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proftaak2`.`courses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `colleges_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_courses_colleges_idx` (`colleges_id` ASC),
  CONSTRAINT `fk_courses_colleges`
    FOREIGN KEY (`colleges_id`)
    REFERENCES `proftaak2`.`colleges` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proftaak2`.`permissions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proftaak2`.`permissions` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `read` TINYINT NULL,
  `write` TINYINT NULL,
  `edit` TINYINT NULL,
  `users_id` INT NOT NULL,
  `colleges_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_permissions_users1_idx` (`users_id` ASC),
  INDEX `fk_permissions_colleges1_idx` (`colleges_id` ASC),
  CONSTRAINT `fk_permissions_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `proftaak2`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_permissions_colleges1`
    FOREIGN KEY (`colleges_id`)
    REFERENCES `proftaak2`.`colleges` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
