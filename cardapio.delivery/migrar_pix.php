<?php
// Requisita o arquivo principal do sistema para ter acesso às configurações do banco de dados
require_once 'application/config/database.php';

// Definir as configurações do banco de dados (ajuste conforme necessário)
$hostname = 'localhost';
$username = 'cardapio.delivery-db-usr';
$password = 'haEY5cLdhMEzrm2D';
$database = 'cardapio.delivery-db';

// Conecta ao banco de dados
$conn = new mysqli($hostname, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

echo "Conexão com o banco de dados estabelecida com sucesso.<br>";

// Verificar se já existe o método PIX na tabela payment_method_list
$sql_check_pix = "SELECT * FROM payment_method_list WHERE slug = 'pix'";
$result_check_pix = $conn->query($sql_check_pix);

if ($result_check_pix->num_rows == 0) {
    // Adicionar o PIX como método de pagamento independente na tabela payment_method_list
    $sql_add_pix = "INSERT INTO payment_method_list (name, slug, active_slug, status_slug, status) 
                    VALUES ('PIX', 'pix', 'is_pix', 'pix_status', 1)";
                    
    if ($conn->query($sql_add_pix) === TRUE) {
        echo "Método de pagamento PIX adicionado com sucesso à tabela payment_method_list<br>";
    } else {
        echo "Erro ao adicionar método PIX: " . $conn->error . "<br>";
    }
} else {
    echo "Método PIX já existe na tabela payment_method_list<br>";
}

// Adicionar colunas na tabela restaurant_list se não existirem
$sql_add_columns = "ALTER TABLE restaurant_list 
                    ADD COLUMN IF NOT EXISTS pix_status INT NOT NULL DEFAULT 1 AFTER offline_status,
                    ADD COLUMN IF NOT EXISTS is_pix INT NOT NULL DEFAULT 0 AFTER is_offline,
                    ADD COLUMN IF NOT EXISTS pix_config JSON NULL AFTER offline_config";

if ($conn->query($sql_add_columns) === TRUE) {
    echo "Colunas adicionadas com sucesso à tabela restaurant_list<br>";
} else {
    echo "Erro ao adicionar colunas: " . $conn->error . "<br>";
}

// Verificar se a tabela pix_config existe, se não, criar
$sql_create_table = "CREATE TABLE IF NOT EXISTS pix_config (
                      id INT AUTO_INCREMENT PRIMARY KEY,
                      restaurant_id INT NOT NULL,
                      pix_key VARCHAR(255) NOT NULL,
                      city VARCHAR(255) DEFAULT 'BRASIL',
                      pix_description VARCHAR(255) DEFAULT NULL,
                      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      UNIQUE KEY unique_restaurant (restaurant_id)
                    )";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Tabela pix_config criada/verificada com sucesso<br>";
} else {
    echo "Erro ao criar tabela pix_config: " . $conn->error . "<br>";
}

// Migrar dados do formato offline para o formato PIX independente
$sql_get_restaurants = "SELECT id, offline_config, is_offline FROM restaurant_list WHERE is_offline = 1";
$result_restaurants = $conn->query($sql_get_restaurants);

if ($result_restaurants->num_rows > 0) {
    echo "Iniciando migração de dados do formato offline para o formato PIX...<br>";
    
    while($row = $result_restaurants->fetch_assoc()) {
        $restaurant_id = $row['id'];
        $offline_config = json_decode($row['offline_config'], true);
        
        // Verificar se existe configuração de PIX no campo offline_config
        if (isset($offline_config['pix_key']) && !empty($offline_config['pix_key'])) {
            // Extrair dados do PIX
            $pix_key = $offline_config['pix_key'];
            $city = isset($offline_config['city']) ? $offline_config['city'] : 'BRASIL';
            $pix_description = isset($offline_config['pix_description']) ? $offline_config['pix_description'] : '';
            
            // Criar configuração PIX
            $pix_config = [
                'pix_key' => $pix_key,
                'city' => $city,
                'pix_description' => $pix_description
            ];
            
            // Atualizar restaurant_list
            $sql_update_restaurant = "UPDATE restaurant_list SET 
                                      is_pix = 1, 
                                      pix_config = '" . json_encode($pix_config) . "' 
                                      WHERE id = $restaurant_id";
                                      
            if ($conn->query($sql_update_restaurant) === TRUE) {
                echo "Configuração PIX atualizada no restaurante ID $restaurant_id<br>";
            } else {
                echo "Erro ao atualizar configuração PIX no restaurante ID $restaurant_id: " . $conn->error . "<br>";
            }
            
            // Verificar se já existe registro na tabela pix_config
            $sql_check_pix_config = "SELECT id FROM pix_config WHERE restaurant_id = $restaurant_id";
            $result_check_pix_config = $conn->query($sql_check_pix_config);
            
            if ($result_check_pix_config->num_rows == 0) {
                // Inserir na tabela pix_config
                $sql_insert_pix_config = "INSERT INTO pix_config (restaurant_id, pix_key, city, pix_description) 
                                         VALUES ($restaurant_id, '$pix_key', '$city', '$pix_description')";
                                         
                if ($conn->query($sql_insert_pix_config) === TRUE) {
                    echo "Registro inserido na tabela pix_config para o restaurante ID $restaurant_id<br>";
                } else {
                    echo "Erro ao inserir registro na tabela pix_config para o restaurante ID $restaurant_id: " . $conn->error . "<br>";
                }
            } else {
                // Atualizar na tabela pix_config
                $sql_update_pix_config = "UPDATE pix_config SET 
                                         pix_key = '$pix_key',
                                         city = '$city',
                                         pix_description = '$pix_description'
                                         WHERE restaurant_id = $restaurant_id";
                                         
                if ($conn->query($sql_update_pix_config) === TRUE) {
                    echo "Registro atualizado na tabela pix_config para o restaurante ID $restaurant_id<br>";
                } else {
                    echo "Erro ao atualizar registro na tabela pix_config para o restaurante ID $restaurant_id: " . $conn->error . "<br>";
                }
            }
        }
    }
    
    echo "Migração concluída.<br>";
} else {
    echo "Nenhum restaurante com configuração offline encontrado.<br>";
}

// Fechar a conexão
$conn->close();

echo "Script finalizado!";
?> 