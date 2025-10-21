-- Script para agregar columna talla_id a la tabla carrito
-- Ejecutar este script para corregir el error del carrito

ALTER TABLE `carrito` 
ADD COLUMN `talla_id` int(11) DEFAULT NULL AFTER `producto_id`,
ADD KEY `idx_talla` (`talla_id`);

-- Agregar foreign key constraint si es necesario
-- ALTER TABLE `carrito` 
-- ADD CONSTRAINT `fk_carrito_talla` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`id`) ON DELETE SET NULL;
