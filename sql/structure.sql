-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema diet
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `diet` ;

-- -----------------------------------------------------
-- Schema diet
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `diet` DEFAULT CHARACTER SET utf8 ;
USE `diet` ;

-- -----------------------------------------------------
-- Table `diet`.`uzytkownicy`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `diet`.`uzytkownicy` ;

CREATE TABLE IF NOT EXISTS `diet`.`uzytkownicy` (
  `id_uzytkownika` INT NOT NULL AUTO_INCREMENT,
  `imie` VARCHAR(45) NOT NULL,
  `nazwisko` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `miasto` VARCHAR(45) NOT NULL,
  `ulica` VARCHAR(45) NOT NULL,
  `nr_domu` VARCHAR(45) NOT NULL,
  `nr_mieszkania` VARCHAR(45) NULL,
  `data_urodzenia` DATE NOT NULL,
  `plec` ENUM('M', "K") NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `pracownik` INT(1) NOT NULL,
  `data_zarejestrowania` DATE NOT NULL,
  PRIMARY KEY (`id_uzytkownika`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diet`.`diety`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `diet`.`diety` ;

CREATE TABLE IF NOT EXISTS `diet`.`diety` (
  `id_diety` INT NOT NULL AUTO_INCREMENT,
  `nazwa` VARCHAR(45) NOT NULL,
  `cena` INT NOT NULL,
  `opis` VARCHAR(512) NOT NULL,
  `kalorycznosc` INT NOT NULL,
  PRIMARY KEY (`id_diety`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diet`.`opinie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `diet`.`opinie` ;

CREATE TABLE IF NOT EXISTS `diet`.`opinie` (
  `id_opinii` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_diety` INT NOT NULL,
  `tekst` VARCHAR(255) NOT NULL,
  `data_wstawienia` DATE NOT NULL,
  PRIMARY KEY (`id_opinii`),
  CONSTRAINT `fk_Opinia_uzytkownicy1`
    FOREIGN KEY (`id_user`)
    REFERENCES `diet`.`uzytkownicy` (`id_uzytkownika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Opinia_dieta1`
    FOREIGN KEY (`id_diety`)
    REFERENCES `diet`.`diety` (`id_diety`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diet`.`dania`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `diet`.`dania` ;

CREATE TABLE IF NOT EXISTS `diet`.`dania` (
  `id_dania` INT NOT NULL AUTO_INCREMENT,
  `nazwa` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_dania`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diet`.`produkty`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `diet`.`produkty` ;

CREATE TABLE IF NOT EXISTS `diet`.`produkty` (
  `id_produktu` INT NOT NULL AUTO_INCREMENT,
  `nazwa` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_produktu`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diet`.`zamowienia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `diet`.`zamowienia` ;

CREATE TABLE IF NOT EXISTS `diet`.`zamowienia` (
  `id_zamowienia` INT NOT NULL AUTO_INCREMENT,
  `id_user` INT NOT NULL,
  `id_diety` INT NOT NULL,
  `czas_kupna` DATE NOT NULL,
  `czas_zakonczenia` DATE NOT NULL,
  `czas_ostatniej_wysylki` DATE NOT NULL,
  PRIMARY KEY (`id_zamowienia`),
  CONSTRAINT `fk_zamowienia_uzytkownicy1`
    FOREIGN KEY (`id_user`)
    REFERENCES `diet`.`uzytkownicy` (`id_uzytkownika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_zamowienia_dieta1`
    FOREIGN KEY (`id_diety`)
    REFERENCES `diet`.`diety` (`id_diety`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diet`.`dieta_danie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `diet`.`dieta_danie` ;

CREATE TABLE IF NOT EXISTS `diet`.`dieta_danie` (
  `id_diety` INT NOT NULL,
  `id_dania` INT NOT NULL,
  CONSTRAINT `fk_dieta_danie_dania1`
    FOREIGN KEY (`id_dania`)
    REFERENCES `diet`.`dania` (`id_dania`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_dieta_danie_dieta1`
    FOREIGN KEY (`id_diety`)
    REFERENCES `diet`.`diety` (`id_diety`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `diet`.`danie_produkt`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `diet`.`danie_produkt` ;

CREATE TABLE IF NOT EXISTS `diet`.`danie_produkt` (
  `id_dania` INT NOT NULL,
  `id_produktu` INT NOT NULL,
  CONSTRAINT `fk_danie_produkt_produkt1`
    FOREIGN KEY (`id_produktu`)
    REFERENCES `diet`.`produkty` (`id_produktu`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_danie_produkt_dania1`
    FOREIGN KEY (`id_dania`)
    REFERENCES `diet`.`dania` (`id_dania`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
