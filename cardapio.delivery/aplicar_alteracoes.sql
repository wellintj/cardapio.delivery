-- Alterando a tabela restaurant_city_list para substituir zip_code por state
ALTER TABLE `restaurant_city_list` 
CHANGE COLUMN `zip_code` `state` varchar(50) DEFAULT NULL;

-- Inserindo tradução para "estado" na tabela de idiomas
INSERT INTO `language_data` (`keyword`, `type`, `details`, `english`) 
VALUES ('state', 'admin', 'Estado', 'State');

-- Inserindo cidades de Rondônia como exemplo
INSERT INTO `restaurant_city_list` (`city_name`, `state`, `created_at`) VALUES
('Guajará-Mirim', 'RO', NOW()),
('Alto Alegre dos Parecis', 'RO', NOW()),
('Porto Velho', 'RO', NOW()),
('Buritis', 'RO', NOW()),
('Ji-Paraná', 'RO', NOW()),
('Chupinguaia', 'RO', NOW()),
('Ariquemes', 'RO', NOW()),
('Cujubim', 'RO', NOW()),
('Cacoal', 'RO', NOW()); 