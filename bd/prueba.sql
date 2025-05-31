/*
  # Create shopping cart tables
  
  1. New Tables
    - `carritos` - Stores cart header information
      - `id_carrito` (int, primary key)
      - `id_usuario` (int, nullable) - References users table for logged-in users
      - `session_id` (varchar) - For guest users
      - `created_at` (timestamp)
      - `updated_at` (timestamp)
    - `carrito_items` - Stores individual cart items
      - `id_item` (int, primary key)
      - `id_carrito` (int) - References carritos table
      - `id_producto` (int) - References productos table
      - `cantidad` (int) - Quantity of the product
      - `precio_unitario` (decimal) - Price at the time of adding
      - `created_at` (timestamp)
      - `updated_at` (timestamp)
  2. Security
    - Enable RLS on cart tables
*/

CREATE TABLE IF NOT EXISTS `huertas_del_norte`.`carritos` (
  `id_carrito` INT NOT NULL AUTO_INCREMENT,
  `id_usuario` INT NULL DEFAULT NULL,
  `session_id` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_carrito`),
  INDEX `id_usuario` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `carritos_ibfk_1`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `huertas_del_norte`.`usuarios` (`id_usuario`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `huertas_del_norte`.`carrito_items` (
  `id_item` INT NOT NULL AUTO_INCREMENT,
  `id_carrito` INT NOT NULL,
  `id_producto` INT NOT NULL,
  `cantidad` INT NOT NULL DEFAULT 1,
  `precio_unitario` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_item`),
  INDEX `id_carrito` (`id_carrito` ASC) VISIBLE,
  INDEX `id_producto` (`id_producto` ASC) VISIBLE,
  CONSTRAINT `carrito_items_ibfk_1`
    FOREIGN KEY (`id_carrito`)
    REFERENCES `huertas_del_norte`.`carritos` (`id_carrito`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `carrito_items_ibfk_2`
    FOREIGN KEY (`id_producto`)
    REFERENCES `huertas_del_norte`.`productos` (`id_producto`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;