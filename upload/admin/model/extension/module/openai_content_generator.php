<?php
class ModelExtensionModuleOpenAIContentGenerator extends Model {
    public function install() {
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "openai_content_generator` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `product_id` int(11) NOT NULL,
            `generated_content` text NOT NULL,
            `content_type` varchar(32) NOT NULL,
            `date_added` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8");
    }

    public function uninstall() {
        $this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "openai_content_generator`");
    }

    public function generateContent($prompt, $temperature = 0.7) {
        $api_key = $this->config->get('module_openai_content_generator_api_key');
        $base_url = $this->config->get('module_openai_content_generator_base_url') ?: 'https://api.openai.com/v1';
        $model = $this->config->get('module_openai_content_generator_model') ?: 'gpt-3.5-turbo';

        $ch = curl_init($base_url . '/chat/completions');
        
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key
        );

        $data = array(
            'model' => $model,
            'messages' => array(
                array(
                    'role' => 'user',
                    'content' => $prompt
                )
            ),
            'temperature' => (float)$temperature
        );

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            $result = json_decode($response, true);
            return $result['choices'][0]['message']['content'];
        }

        return false;
    }

    public function saveGeneratedContent($product_id, $content, $content_type) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "openai_content_generator SET 
            product_id = '" . (int)$product_id . "',
            generated_content = '" . $this->db->escape($content) . "',
            content_type = '" . $this->db->escape($content_type) . "',
            date_added = NOW()");
    }

    public function getGeneratedContent($product_id, $content_type) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "openai_content_generator 
            WHERE product_id = '" . (int)$product_id . "' 
            AND content_type = '" . $this->db->escape($content_type) . "' 
            ORDER BY date_added DESC LIMIT 1");

        return $query->row;
    }
} 