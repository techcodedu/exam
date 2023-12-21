ALTER TABLE `tblcitymun` ADD COLUMN `id` INT AUTO_INCREMENT PRIMARY KEY;

CREATE TABLE IF NOT EXISTS `tblStatus` (
  `status_id` INT AUTO_INCREMENT PRIMARY KEY,
  `status_name` VARCHAR(50) NOT NULL
);


CREATE TABLE IF NOT EXISTS `tblIndividuals` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `date_of_birth` DATE NOT NULL,
  `sex` VARCHAR(10) NOT NULL,
  `address` VARCHAR(255) NOT NULL,
  `contact` VARCHAR(50),
  `citymun_id` INT NOT NULL, -- This is changed to reference the new primary key of tblcitymun
  `status_id` INT NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  FOREIGN KEY (`citymun_id`) REFERENCES `tblcitymun`(`id`), -- Foreign key constraint is updated
  FOREIGN KEY (`status_id`) REFERENCES `tblStatus`(`status_id`)
);

CREATE TABLE IF NOT EXISTS `tblLGUPopulation` (
  `population_id` INT AUTO_INCREMENT PRIMARY KEY,
  `citymun_id` INT NOT NULL, -- This is changed to reference the new primary key of tblcitymun
  `population` INT NOT NULL,
  `year_recorded` YEAR NOT NULL,
  FOREIGN KEY (`citymun_id`) REFERENCES `tblcitymun`(`id`) -- Foreign key constraint is updated
);

