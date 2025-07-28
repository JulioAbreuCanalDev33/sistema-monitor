<?php
// Configurações de upload
define('UPLOAD_MAX_SIZE', 5 * 1024 * 1024); // 5MB
define('UPLOAD_ALLOWED_TYPES', [
    'image' => ['jpg', 'jpeg', 'png', 'gif'],
    'document' => ['pdf', 'doc', 'docx', 'txt'],
    'all' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt']
]);

/**
 * Função para upload de arquivo
 */
function upload_file($file, $allowed_extensions = null, $upload_dir = null) {
    if (!$upload_dir) {
        $upload_dir = UPLOAD_PATH;
    }
    
    if (!$allowed_extensions) {
        $allowed_extensions = UPLOAD_ALLOWED_TYPES['all'];
    }
    
    // Verificar se o arquivo foi enviado
    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'Erro no upload do arquivo'];
    }
    
    // Verificar tamanho do arquivo
    if ($file['size'] > UPLOAD_MAX_SIZE) {
        return ['success' => false, 'message' => 'Arquivo muito grande. Máximo: ' . (UPLOAD_MAX_SIZE / 1024 / 1024) . 'MB'];
    }
    
    // Verificar extensão
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'message' => 'Tipo de arquivo não permitido'];
    }
    
    // Gerar nome único para o arquivo
    $filename = uniqid() . '_' . time() . '.' . $file_extension;
    $filepath = $upload_dir . $filename;
    
    // Criar diretório se não existir
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Mover arquivo
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return [
            'success' => true,
            'filename' => $filename,
            'filepath' => $filepath,
            'original_name' => $file['name']
        ];
    } else {
        return ['success' => false, 'message' => 'Erro ao salvar arquivo'];
    }
}

/**
 * Função para deletar arquivo
 */
function delete_file($filename, $upload_dir = null) {
    if (!$upload_dir) {
        $upload_dir = UPLOAD_PATH;
    }
    
    $filepath = $upload_dir . $filename;
    
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    
    return false;
}

/**
 * Função para validar tipo de arquivo
 */
function validate_file_type($filename, $allowed_types) {
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($extension, $allowed_types);
}

/**
 * Função para obter URL do arquivo
 */
function get_file_url($filename) {
    return BASE_URL . 'assets/uploads/' . $filename;
}

/**
 * Função para verificar se arquivo é imagem
 */
function is_image($filename) {
    $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($extension, $image_extensions);
}

/**
 * Função para redimensionar imagem
 */
function resize_image($source_file, $destination_file, $max_width = 800, $max_height = 600) {
    $image_info = getimagesize($source_file);
    if (!$image_info) {
        return false;
    }
    
    $width = $image_info[0];
    $height = $image_info[1];
    $type = $image_info[2];
    
    // Calcular novas dimensões
    $ratio = min($max_width / $width, $max_height / $height);
    $new_width = $width * $ratio;
    $new_height = $height * $ratio;
    
    // Criar imagem de origem
    switch ($type) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($source_file);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($source_file);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($source_file);
            break;
        default:
            return false;
    }
    
    // Criar nova imagem
    $destination = imagecreatetruecolor($new_width, $new_height);
    
    // Preservar transparência para PNG e GIF
    if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
        imagealphablending($destination, false);
        imagesavealpha($destination, true);
        $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
        imagefilledrectangle($destination, 0, 0, $new_width, $new_height, $transparent);
    }
    
    // Redimensionar
    imagecopyresampled($destination, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Salvar imagem
    switch ($type) {
        case IMAGETYPE_JPEG:
            $result = imagejpeg($destination, $destination_file, 90);
            break;
        case IMAGETYPE_PNG:
            $result = imagepng($destination, $destination_file);
            break;
        case IMAGETYPE_GIF:
            $result = imagegif($destination, $destination_file);
            break;
        default:
            $result = false;
    }
    
    // Limpar memória
    imagedestroy($source);
    imagedestroy($destination);
    
    return $result;
}
?>

