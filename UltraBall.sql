SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

CREATE TABLE `pokedex` (
  `id` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` VARCHAR(11) NOT NULL,
  `Region_id` INT(1) DEFAULT NULL,
  `Evolution_Stage` INT(1) NOT NULL,
  `Type_id` INT(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `forms` (
  `id` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Pokemon_id` INT(1) NOT NULL,
  `id_Form` INT(1) NOT NULL,
  `Form_Name` VARCHAR(11) DEFAULT NULL,
  `Type1_id` INT(2) DEFAULT NULL,
  `Type2_id` INT(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

CREATE TABLE `form_get_methods`(
  `id` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Forms_id` INT(3) NOT NULL,
  `Item_id` INT(2) DEFAULT NULL,
  `Method` VARCHAR(130) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

CREATE TABLE `forms_descriptions`(
  `id` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Pokemon_id` INT(3) NOT NULL,
  `Description` VARCHAR(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

CREATE TABLE `evolutions` (
  `id` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `PreEvolution_id` INT(3) NOT NULL,
  `Evolution_id` INT(3) NOT NULL,
  `Item_id` INT(2) DEFAULT NULL,
  `Method` VARCHAR(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

/*CREATE TABLE `pokemon_locations` (
  `Pokemon_id` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Red` VARCHAR(250) DEFAULT NULL,
  `Blue` VARCHAR(250) DEFAULT NULL,
  `Yellow` VARCHAR(250) DEFAULT NULL,
  `Gold` VARCHAR(250) DEFAULT NULL,
  `Silver` VARCHAR(250) DEFAULT NULL,
  `Crystal` VARCHAR(250) DEFAULT NULL,
  `Ruby` VARCHAR(250) DEFAULT NULL,
  `Saphire` VARCHAR(250) DEFAULT NULL,
  `Emerald` VARCHAR(250) DEFAULT NULL,
  `Fire Red` VARCHAR(250) DEFAULT NULL,
  `Leaf Green` VARCHAR(250) DEFAULT NULL,
  `Diamond` VARCHAR(250) DEFAULT NULL,
  `Pearl` VARCHAR(250) DEFAULT NULL,
  `Platinum` VARCHAR(250) DEFAULT NULL,
  `Heart Gold` VARCHAR(250) DEFAULT NULL,
  `Soul Silver` VARCHAR(250) DEFAULT NULL,
  `Black` VARCHAR(250) DEFAULT NULL,
  `White` VARCHAR(250) DEFAULT NULL,
  `Black 2` VARCHAR(250) DEFAULT NULL,
  `White 2` VARCHAR(250) DEFAULT NULL,
  `X` VARCHAR(250) DEFAULT NULL,
  `Y` VARCHAR(250) DEFAULT NULL,
  `Omega Ruby` VARCHAR(250) DEFAULT NULL,
  `Alpha Saphire` VARCHAR(250) DEFAULT NULL,
  `Sun` VARCHAR(250) DEFAULT NULL,
  `Moon` VARCHAR(250) DEFAULT NULL,
  `Ultra Sun` VARCHAR(250) DEFAULT NULL,
  `Ultra Moon` VARCHAR(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pokemon_locations` (`Red`, `Blue`, `Yellow`, `Gold`, `Silver`, `Crystal`, `Ruby`, `Saphire`, `Emerald`, `Fire Red`, `Leaf Green`, `Diamond`, `Pearl`, `Platinum`, `Heart Gold`, `Soul Silver`, `Black`, `White`, `Black 2`, `White 2`, `X`, `Y`, `Omega Ruby`, `Alpha Saphire`, `Sun`, `Moon`, `Ultra Sun`, `Ultra Moon`) VALUES
('Starter', 'Starter', 'Otrzymujesz jako podarunek w Cerulean City', 'Brak', 'Brak', 'Brak', 'Brak', 'Brak', 'Brak', 'Starter', 'Starter', 'Brak', 'Brak', 'Brak', 'Otrzymujesz od profesora Oak', 'Otrzymujesz od profesora Oak', 'Brak', 'Brak', 'Brak', 'Brak', 'Otrzymujesz od profesora Sycamore', 'Otrzymujesz od profesora Sycamore', 'Brak', 'Brak', 'Brak', 'Brak', 'Brak', 'Brak'),
('Ewoluuj', 'Ewoluuj', 'Ewoluuj', 'Brak', 'Brak', 'Brak', 'Brak', 'Brak', 'Brak', 'Ewoluuj', 'Ewoluuj', 'Brak', 'Brak', 'Brak', 'Ewoluuj', 'Ewoluuj', 'Brak', 'Brak', 'Brak', 'Brak', 'Ewoluuj, Friend Safari', 'Ewoluuj, Friend Safari', 'Brak', 'Brak', 'Brak', 'Brak', 'Brak', 'Brak');*/

-- --------------------------------------------------------

CREATE TABLE `regions` (
  `id` INT(1) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` VARCHAR(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `regions` (`Name`) VALUES
('Kanto'),
('Johto'),
('Hoenn'),
('Sinnoh'),
('Unova');

-- --------------------------------------------------------

CREATE TABLE `types` (
  `id` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` VARCHAR(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `types` (`Name`) VALUES
('Robak'),
('Mroczny'),
('Smok'),
('Elektryczny'),
('Walczący'),
('Ognisty'),
('Latający'),
('Duch'),
('Roślinny'),
('Ziemny'),
('Lodowy'),
('Normalny'),
('Trujący'),
('Psychiczny'),
('Kamienny'),
('Stalowy'),
('Wodny'),
('Wróżka');

-- --------------------------------------------------------

CREATE TABLE `pokemon_types` (
  `id` INT(3) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Type` VARCHAR(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `pokemon_types` (`Type`) VALUES
('Normalny'),
('Starter'),
('Dziecko'),
('Skamielina'),
('Legendarny');

-- --------------------------------------------------------

CREATE TABLE `items` (
  `id` INT(2) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` VARCHAR(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

ALTER TABLE `pokedex`
  ADD CONSTRAINT `Pokedex_Pokemon_types` FOREIGN KEY (`Type_id`) REFERENCES `pokemon_types` (`id`),
  ADD CONSTRAINT `Pokedex_Region` FOREIGN KEY (`Region_id`) REFERENCES `regions` (`id`);

ALTER TABLE `forms`
  ADD CONSTRAINT `Forms_Pokemon` FOREIGN KEY (`Pokemon_id`) REFERENCES `pokedex` (`id`),
  ADD CONSTRAINT `Forms_Type1` FOREIGN KEY (`Type1_id`) REFERENCES `types` (`id`),
  ADD CONSTRAINT `Forms_Type2` FOREIGN KEY (`Type2_id`) REFERENCES `types` (`id`);

ALTER TABLE `form_get_methods`
  ADD CONSTRAINT `Form` FOREIGN KEY (`Forms_id`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `Forms_Item` FOREIGN KEY (`Item_id`) REFERENCES `items` (`id`);

ALTER TABLE `forms_descriptions`
  ADD CONSTRAINT `Pokemon_Forms_Description` FOREIGN KEY (`Pokemon_id`) REFERENCES `pokedex` (`id`);

ALTER TABLE `evolutions`
  ADD CONSTRAINT `PreEvolution` FOREIGN KEY (`PreEvolution_id`) REFERENCES `pokedex` (`id`),
  ADD CONSTRAINT `Evolution` FOREIGN KEY (`Evolution_id`) REFERENCES `pokedex` (`id`),
  ADD CONSTRAINT `Item` FOREIGN KEY (`Item_id`) REFERENCES `items` (`id`);
