<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevenir acceso directo
}

// Registrar configuración
function wpatai_register_settings() {
    register_setting( 'wpatai_options_group', 'wpatai_settings' );
}
add_action( 'admin_init', 'wpatai_register_settings' );

// Página de configuración del panel de administración
function wpatai_settings_page() {
    $options = get_option( 'wpatai_settings' );
    if ( ! is_array( $options ) ) {
        $options = array();
    }
    ?>
    <style>
        .wpatai_wrap {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .wpatai_wrap h1 {
            font-size: 24px;
            color: #333;
            border-bottom: 2px solid #007cba;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .wpatai_wrap .form-table th {
            width: 200px;
            text-align: left;
            font-weight: 600;
            padding: 10px;
        }
        .wpatai_wrap .form-table td {
            padding: 10px;
        }
        .wpatai_wrap input[type="text"],
        .wpatai_wrap select {
            width: 100%;
            max-width: 400px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .wpatai_wrap input[type="checkbox"],
        .wpatai_wrap input[type="radio"] {
            margin-right: 5px;
        }
        .wpatai_wrap .description {
            font-size: 12px;
            color: #666;
        }
        .wpatai_wrap input[type="submit"] {
            background: #007cba;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .wpatai_wrap input[type="submit"]:hover {
            background: #005a8e;
        }
        /* Mensaje de éxito al guardar */
        #wpatai-save-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            text-align: center;
        }
    </style>
    <div class="wpatai_wrap">
        <h1>Configuración de traducción y lectura de artículos</h1>

        <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']): ?>
            <div id="wpatai-save-success">¡Guardado exitosamente!</div>
            <script>
                setTimeout(() => {
                    let successMsg = document.getElementById('wpatai-save-success');
                    if (successMsg) {
                        successMsg.style.display = 'none';
                    }
                }, 1000);
            </script>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php settings_fields( 'wpatai_options_group' ); ?>
            <table class="form-table">
                <!-- Habilitar servicio de traducción -->
                <tr valign="top">
                    <th scope="row">Habilitar servicio de traducción</th>
                    <td>
                        <input type="checkbox" name="wpatai_settings[enable_translation]" value="1" <?php checked( 1, isset( $options['enable_translation'] ) ? $options['enable_translation'] : 0 ); ?> />
                        <label for="enable_translation">Habilitar función de traducción de contenido de artículos con IA</label>
                    </td>
                </tr>
                <!-- Seleccionar interfaz API -->
                <tr valign="top">
                    <th scope="row">Seleccionar interfaz API</th>
                    <td>
                        <?php $selected_api = isset( $options['selected_api'] ) ? $options['selected_api'] : 'deepseek'; ?>
                        <select name="wpatai_settings[selected_api]">
                            <option value="deepseek" <?php selected( $selected_api, 'deepseek' ); ?>>DeepSeek</option>
                            <option value="tongyi" <?php selected( $selected_api, 'tongyi' ); ?>>通义千问 (Tongyi Qianwen)</option>
                            <option value="doubao" <?php selected( $selected_api, 'doubao' ); ?>>豆包AI (Doubao AI)</option>
                        </select>
                    </td>
                </tr>
                <!-- Configuración de DeepSeek -->
                <tr valign="top">
                    <th scope="row">DeepSeek API Key</th>
                    <td>
                        <input type="text" name="wpatai_settings[deepseek_api_key]" value="<?php echo isset( $options['deepseek_api_key'] ) ? esc_attr( $options['deepseek_api_key'] ) : ''; ?>" size="50" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Parámetros del modelo DeepSeek</th>
                    <td>
                        <input type="text" name="wpatai_settings[deepseek_model]" value="<?php echo isset( $options['deepseek_model'] ) ? esc_attr( $options['deepseek_model'] ) : 'deepseek-chat'; ?>" size="50" />
                    </td>
                </tr>
                <!-- Configuración de Tongyi Qianwen -->
                <tr valign="top">
                    <th scope="row">Tongyi Qianwen API Key</th>
                    <td>
                        <input type="text" name="wpatai_settings[tongyi_api_key]" value="<?php echo isset( $options['tongyi_api_key'] ) ? esc_attr( $options['tongyi_api_key'] ) : ''; ?>" size="50" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Parámetros del modelo Tongyi Qianwen</th>
                    <td>
                        <input type="text" name="wpatai_settings[tongyi_model]" value="<?php echo isset( $options['tongyi_model'] ) ? esc_attr( $options['tongyi_model'] ) : 'qwen-plus'; ?>" size="50" />
                    </td>
                </tr>
                <!-- Configuración de Doubao AI -->
                <tr valign="top">
                    <th scope="row">Doubao AI API Key</th>
                    <td>
                        <input type="text" name="wpatai_settings[doubao_api_key]" value="<?php echo isset( $options['doubao_api_key'] ) ? esc_attr( $options['doubao_api_key'] ) : ''; ?>" size="50" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Parámetros del modelo Doubao AI</th>
                    <td>
                        <input type="text" name="wpatai_settings[doubao_model]" value="<?php echo isset( $options['doubao_model'] ) ? esc_attr( $options['doubao_model'] ) : ''; ?>" size="50" />
                    </td>
                </tr>
                <!-- Configuración de idiomas de traducción -->
                <tr valign="top">
                    <th scope="row">Configuración de idiomas de traducción</th>
                    <td>
                        <input type="text" name="wpatai_settings[translation_languages]" value="<?php echo isset( $options['translation_languages'] ) ? esc_attr( $options['translation_languages'] ) : '中文,英文,韩语,日语'; ?>" size="50" />
                        <p class="description">Ingrese los idiomas de traducción, separe varios idiomas con comas, por ejemplo: Chino,Inglés,Coreano,Japonés</p>
                    </td>
                </tr>
                <!-- Método de traducción de artículos -->
                <tr valign="top">
                    <th scope="row">Método de traducción de artículos</th>
                    <td>
                        <?php $translation_type = isset( $options['translation_type'] ) ? $options['translation_type'] : 'full'; ?>
                        <label>
                            <input type="radio" name="wpatai_settings[translation_type]" value="full" <?php checked( $translation_type, 'full' ); ?> />
                            Traducción de cobertura completa (reemplaza completamente el texto original, solo muestra el contenido traducido)
                        </label><br>
                        <label>
                            <input type="radio" name="wpatai_settings[translation_type]" value="compare" <?php checked( $translation_type, 'compare' ); ?> />
                            Traducción comparativa (cada párrafo muestra: texto original + resultado de la traducción)
                        </label>
                    </td>
                </tr>
                <!-- Configuración de lectura en voz alta -->
                <tr valign="top">
                    <th scope="row">Habilitar lectura en voz alta</th>
                    <td>
                        <input type="checkbox" name="wpatai_settings[enable_tts]" value="1" <?php checked( 1, isset( $options['enable_tts'] ) ? $options['enable_tts'] : 0 ); ?> />
                        <label for="enable_tts">Habilitar función de lectura en voz alta del contenido del artículo</label>
                    </td>
                </tr>
                <!-- Selección de interfaz de síntesis de voz -->
                <tr valign="top">
                    <th scope="row">Interfaz de síntesis de voz</th>
                    <td>
                        <?php $tts_interface = isset( $options['tts_interface'] ) ? $options['tts_interface'] : 'tencent'; ?>
                        <select name="wpatai_settings[tts_interface]">
                            <option value="tencent" <?php selected( $tts_interface, 'tencent' ); ?>>Tencent Cloud</option>
                            <option value="baidu" <?php selected( $tts_interface, 'baidu' ); ?>>Baidu Cloud</option>
                        </select>
                    </td>
                </tr>
                <!-- Configuración de Tencent Cloud -->
                <tr valign="top">
                    <th scope="row">Tencent Cloud SecretId</th>
                    <td>
                        <input type="text" name="wpatai_settings[tencent_secret_id]" value="<?php echo isset( $options['tencent_secret_id'] ) ? esc_attr( $options['tencent_secret_id'] ) : ''; ?>" size="50" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Tencent Cloud SecretKey</th>
                    <td>
                        <input type="text" name="wpatai_settings[tencent_secret_key]" value="<?php echo isset( $options['tencent_secret_key'] ) ? esc_attr( $options['tencent_secret_key'] ) : ''; ?>" size="50" />
                    </td>
                </tr>
                <!-- Valor de la biblioteca de voz de Tencent Cloud -->
                <tr valign="top">
                    <th scope="row">Valor de la biblioteca de voz de Tencent Cloud</th>
                    <td>
                        <input type="text" name="wpatai_settings[tencent_voice_type]" value="<?php echo isset( $options['tencent_voice_type'] ) ? esc_attr( $options['tencent_voice_type'] ) : '0'; ?>" size="10" />
                        <p class="description">Ingrese el valor de la biblioteca de voz (VoiceType) para la síntesis de voz de Tencent Cloud, el valor predeterminado es 0.</p>
                    </td>
                </tr>
                <!-- Configuración de Baidu Cloud -->
                <tr valign="top">
                    <th scope="row">Baidu Cloud API_KEY</th>
                    <td>
                        <input type="text" name="wpatai_settings[baidu_api_key]" value="<?php echo isset( $options['baidu_api_key'] ) ? esc_attr( $options['baidu_api_key'] ) : ''; ?>" size="50" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Baidu Cloud SECRET_KEY</th>
                    <td>
                        <input type="text" name="wpatai_settings[baidu_secret_key]" value="<?php echo isset( $options['baidu_secret_key'] ) ? esc_attr( $options['baidu_secret_key'] ) : ''; ?>" size="50" />
                    </td>
                </tr>
                <!-- Valor de la biblioteca de voz de Baidu Cloud -->
                <tr valign="top">
                    <th scope="row">Valor de la biblioteca de voz de Baidu Cloud</th>
                    <td>
                        <input type="text" name="wpatai_settings[baidu_per]" value="<?php echo isset( $options['baidu_per'] ) ? esc_attr( $options['baidu_per'] ) : '0'; ?>" size="10" />
                        <p class="description">Ingrese el valor de la biblioteca de voz (per) para la síntesis de voz de Baidu Cloud, el valor predeterminado es 0.</p>
                    </td>
                </tr>
                <!-- Excluir IDs de artículos de traducción y voz -->
                <tr valign="top">
                    <th scope="row">IDs de artículos a excluir</th>
                    <td>
                        <input type="text" name="wpatai_settings[exclude_post_ids]" value="<?php echo isset( $options['exclude_post_ids'] ) ? esc_attr( $options['exclude_post_ids'] ) : ''; ?>" size="50" />
                        <p class="description">Ingrese los IDs de los artículos a excluir, separe varios IDs con comas. Los artículos excluidos no cargarán la traducción ni la voz.</p>
                    </td>
                </tr>                
            </table>
            <?php submit_button(); ?>
        </form>
        <p>La función de traducción y lectura de artículos era originalmente un plugin separado, que luego se fusionó con el asistente de IA.<br>
        El modelo debe admitir texto largo para poder traducir, ya que el contenido de los artículos suele ser extenso, y algunos modelos de IA solo pueden recibir contenido muy corto a la vez.<br>
    Las interfaces de síntesis de voz utilizan texto corto, logrando la lectura mediante el envío por segmentos. Si se utilizara texto largo, la tarifa sería más cara.<br>
Si desea una traducción gratuita para todo el sitio, le recomiendo mi otro plugin profesional multilingüe: <a href="https://www.wujiit.com/wptr" target="_blank">小半多语言翻译 (Xiaoban Multi-language Translation)</a></p>
    </div>
    <?php
}

// Panel de control de adición de artículos
function wpatai_append_control_bar( $content ) {
    if ( ! is_singular( 'post' ) ) {
        return $content;
    }
    $options = get_option( 'wpatai_settings' );
    $post_id = get_the_ID();

    // Comprobar si está en la lista de exclusión
    $exclude_post_ids = isset( $options['exclude_post_ids'] ) ? explode( ',', $options['exclude_post_ids'] ) : [];
    $exclude_post_ids = array_map( 'trim', $exclude_post_ids );
    if ( in_array( strval( $post_id ), $exclude_post_ids ) ) {
        return $content;
    }

    // Si la traducción y la lectura no están habilitadas, no agregar
    if ( empty( $options['enable_translation'] ) && empty( $options['enable_tts'] ) ) {
        return $content;
    }
    
    // Construir contenedor del panel de control, con ID de artículo y modo de traducción
    $control_panel  = '<div class="wpatai-control-panel" data-postid="' . $post_id . '" data-translation-type="' . esc_attr( isset( $options['translation_type'] ) ? $options['translation_type'] : 'full' ) . '">';
    
    // Botón de lectura de voz
    if ( ! empty( $options['enable_tts'] ) ) {
        $control_panel .= '<span class="wpatai-tts-btn" title="Leer artículo" style="cursor:pointer; margin-right:15px; font-size:22px;">&#128266;</span>';
    }
    
    // Botón de idioma de traducción
    if ( ! empty( $options['enable_translation'] ) ) {
        $languages = array_filter( array_map( 'trim', explode( ',', $options['translation_languages'] ) ) );
        if ( ! empty( $languages ) ) {
            $control_panel .= '<div class="wpatai-language-switcher" style="display:inline-block;">';
            foreach ( $languages as $lang ) {
                $control_panel .= '<span class="wpatai-translate-btn" data-language="' . esc_attr( $lang ) . '">' . esc_html( $lang ) . '</span> ';
            }
            $control_panel .= '</div>';
        }
    }
    
    $control_panel .= '</div>';
    
    // Envolver el contenido del artículo para futuras actualizaciones de resultados de traducción
    $wrapped_content = '<div id="wpatai-post-content">' . $content . '</div>';
    
    return $control_panel . $wrapped_content;
}
add_filter( 'the_content', 'wpatai_append_control_bar' );


// Carga de la página del artículo
function wpatai_enqueue_assets() {
    if ( ! is_singular( 'post' ) ) {
        return;
    }

    $options = get_option( 'wpatai_settings' );
    // Obtener ID del artículo actual
    $post_id = get_the_ID();
    $exclude_post_ids = isset( $options['exclude_post_ids'] ) ? explode( ',', $options['exclude_post_ids'] ) : [];
    $exclude_post_ids = array_map( 'trim', $exclude_post_ids );
    // Comprobar si el ID del artículo actual está en la lista de exclusión
    if ( in_array( strval( $post_id ), $exclude_post_ids ) ) {
        return;
    }

    if ( empty( $options['enable_translation'] ) && empty( $options['enable_tts'] ) ) {
        return;
    }

    // Salida de CSS en línea
    add_action('wp_head', function() {
        ?>
        <style>
            /* Panel de control general */
            .wpatai-control-panel {
                background: #f9f9f9;
                padding: 8px 12px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 12px;
                display: flex;
                align-items: center;
                flex-wrap: wrap;
            }
            /* Botón de icono de lectura de voz */
            .wpatai-tts-btn {
                font-size: 22px;
                cursor: pointer;
                margin-right: 15px;
            }
            .wpatai-tts-btn:hover {
                opacity: 0.8;
            }
            /* Botón de traducción */
            .wpatai-language-switcher span.wpatai-translate-btn {
                display: inline-block;
                padding: 5px 10px;
                margin-right: 8px;
                background: linear-gradient(135deg, #1E3A8A, #3B82F6);
                color: #fff;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                transition: background-color 0.3s ease;
            }
            .wpatai-language-switcher span.wpatai-translate-btn:hover {
                background-color: #005177;
            }
        </style>
        <?php
    });

    // Cargar script JS
    wp_enqueue_script( 'wpatai-script', plugin_dir_url( __FILE__ ) . 'wpai-script.js', array( 'jquery' ), '2.2', true );
    wp_localize_script( 'wpatai-script', 'wpatai_ajax_obj', array(
        'ajax_url'  => admin_url( 'admin-ajax.php' ),
        'nonce'     => wp_create_nonce( 'wpatai_translate_nonce' ),
        'tts_nonce' => wp_create_nonce( 'wpatai_tts_nonce' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'wpatai_enqueue_assets' );


// Manejar solicitud de traducción AJAX
function wpatai_handle_translation() {
    check_ajax_referer( 'wpatai_translate_nonce', 'nonce' );
    
    $post_id         = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
    $target_language = isset( $_POST['target_language'] ) ? sanitize_text_field( $_POST['target_language'] ) : '';
    
    if ( ! $post_id || empty( $target_language ) ) {
        wp_send_json_error( 'Parámetro inválido' );
    }
    
    $post = get_post( $post_id );
    if ( ! $post ) {
        wp_send_json_error( 'Artículo no encontrado' );
    }
    $original_content = $post->post_content;
    
    $options          = get_option( 'wpatai_settings' );
    $selected_api     = isset( $options['selected_api'] ) ? $options['selected_api'] : 'deepseek';
    $translation_type = isset( $options['translation_type'] ) ? $options['translation_type'] : 'full';
    
    // Procesar HTML del artículo, extraer texto plano, llamar a la API de traducción de IA y generar HTML final.
    $translated_content = wpatai_translate_content( $original_content, $target_language, $translation_type, $selected_api, $options );
    
    wp_send_json_success( array( 'translated_text' => $translated_content ) );
}
add_action( 'wp_ajax_wpatai_translate', 'wpatai_handle_translation' );
add_action( 'wp_ajax_nopriv_wpatai_translate', 'wpatai_handle_translation' );

// Manejar solicitud de lectura en voz alta
function wpatai_handle_tts() {
    set_time_limit(0); // Cancelar límite de tiempo de ejecución de PHP
    check_ajax_referer( 'wpatai_tts_nonce', 'nonce' );
    
    $post_id = isset( $_POST['post_id'] ) ? intval( $_POST['post_id'] ) : 0;
    if ( ! $post_id ) {
        wp_send_json_error( 'Parámetro inválido' );
    }
    
    $post = get_post( $post_id );
    if ( ! $post ) {
        wp_send_json_error( 'Artículo no encontrado' );
    }
    // Extraer solo texto plano (excluir imágenes, videos, código, etc.)
    $text = wp_strip_all_tags( $post->post_content );
    
    $options = get_option( 'wpatai_settings' );
    if ( empty( $options['enable_tts'] ) ) {
        wp_send_json_error( 'Función de lectura en voz alta no habilitada' );
    }
    
    // Seleccionar la interfaz de síntesis de voz según la configuración del panel de administración
    $tts_interface = isset( $options['tts_interface'] ) ? $options['tts_interface'] : 'tencent';
    
    $audio_urls = array();
    $chunk_size = 50;
    $total_length = mb_strlen($text, 'UTF-8');
    
    if ( $tts_interface === 'tencent' ) {
        $secret_id  = isset( $options['tencent_secret_id'] ) ? trim( $options['tencent_secret_id'] ) : '';
        $secret_key = isset( $options['tencent_secret_key'] ) ? trim( $options['tencent_secret_key'] ) : '';
        if ( empty( $secret_id ) || empty( $secret_key ) ) {
            wp_send_json_error( 'Credenciales de Tencent Cloud no configuradas' );
        }
        $tencent_voice_type = isset($options['tencent_voice_type']) ? $options['tencent_voice_type'] : 0;
        for ($i = 0; $i < $total_length; $i += $chunk_size) {
            $chunk = mb_substr($text, $i, $chunk_size, 'UTF-8');
            $result = wpatai_call_tts_api( $chunk, $secret_id, $secret_key, $tencent_voice_type );
            if ( is_wp_error( $result ) ) {
                wp_send_json_error( "Error en síntesis de voz, párrafo $i: " . $result->get_error_message() );
            }
            $audio_urls[] = $result;
        }
    } elseif ( $tts_interface === 'baidu' ) {
        $baidu_api_key    = isset( $options['baidu_api_key'] ) ? trim( $options['baidu_api_key'] ) : '';
        $baidu_secret_key = isset( $options['baidu_secret_key'] ) ? trim( $options['baidu_secret_key'] ) : '';
        if ( empty( $baidu_api_key ) || empty( $baidu_secret_key ) ) {
            wp_send_json_error( 'Credenciales de Baidu Cloud no configuradas' );
        }
        $baidu_per = isset($options['baidu_per']) ? $options['baidu_per'] : 0;
        for ($i = 0; $i < $total_length; $i += $chunk_size) {
            $chunk = mb_substr($text, $i, $chunk_size, 'UTF-8');
            $result = wpatai_call_baidu_tts_api( $chunk, $baidu_api_key, $baidu_secret_key, $baidu_per );
            if ( is_wp_error( $result ) ) {
                wp_send_json_error( "Error en síntesis de voz, párrafo $i: " . $result->get_error_message() );
            }
            $audio_urls[] = $result;
        }
    } else {
        wp_send_json_error( 'Interfaz de síntesis de voz no configurada correctamente' );
    }
    
    wp_send_json_success( array( 'audio_urls' => $audio_urls ) );
}
add_action( 'wp_ajax_wpatai_tts', 'wpatai_handle_tts' );
add_action( 'wp_ajax_nopriv_wpatai_tts', 'wpatai_handle_tts' );

// Función de procesamiento de traducción
function wpatai_translate_content( $html, $target_language, $translation_type, $selected_api, $options ) {
    $delimiter = "%%WPATAI_DELIM%%"; // Delimitador
    $tokens = array();
    $original_texts = array();
    
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="UTF-8"><div id="wpatai_wrapper">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    $xpath = new DOMXPath($doc);
    
    // Consultar todos los nodos de texto no vacíos (excluyendo contenido dentro de etiquetas code, pre, script, style)
    $textNodes = $xpath->query('//text()[normalize-space(.) and not(ancestor::code) and not(ancestor::pre) and not(ancestor::script) and not(ancestor::style)]');
    
    $index = 0;
    foreach ( $textNodes as $node ) {
        $text = $node->nodeValue;
        if ( trim( $text ) === '' ) {
            continue;
        }
        $token = $delimiter . $index . $delimiter;
        $tokens[] = $token;
        $original_texts[] = $text;
        $node->nodeValue = $token;
        $index++;
    }
    
    $wrapper = $doc->getElementById('wpatai_wrapper');
    $modified_html = '';
    foreach ( $wrapper->childNodes as $child ) {
        $modified_html .= $doc->saveHTML( $child );
    }
    
    $joined_text = implode( $delimiter, $original_texts );
    $prompt = "Por favor, traduce el siguiente texto a {$target_language}. El texto está separado por el delimitador \"{$delimiter}\". Por favor, usa el mismo delimitador para separar cada segmento en el resultado de la traducción y mantén el delimitador estrictamente. Por favor, devuelve solo el texto traducido, sin añadir ningún otro contenido.\n\n" . $joined_text;
    
    $api_result = wpatai_call_api( $prompt, $selected_api, $options );
    if ( is_wp_error( $api_result ) ) {
        return "Error al llamar a la API de traducción: " . $api_result->get_error_message();
    }
    
    $translated_segments = explode( $delimiter, $api_result );
    $final_html = $modified_html;
    foreach ( $tokens as $i => $token ) {
        $original = $original_texts[ $i ];
        $translated = isset( $translated_segments[ $i ] ) ? $translated_segments[ $i ] : '';
        if ( $translation_type === 'compare' ) {
            $replacement = htmlspecialchars( $original ) . '<br/>' . htmlspecialchars( $translated );
        } else {
            $replacement = htmlspecialchars( $translated );
        }
        $final_html = str_replace( $token, $replacement, $final_html );
    }
    
    return $final_html;
}

// Llamar a la interfaz de IA especificada para la traducción
function wpatai_call_api( $prompt, $selected_api, $options ) {
    // Inicializar variable de error de retorno
    $last_error = null;

    // Interfaz DeepSeek
    if ( $selected_api === 'deepseek' ) {
        $api_key = isset( $options['deepseek_api_key'] ) ? $options['deepseek_api_key'] : '';
        // Permitir múltiples parámetros de modelo, separados por comas en inglés
        $models = isset( $options['deepseek_model'] ) ? explode( ',', $options['deepseek_model'] ) : array('deepseek-chat');
        $models = array_map('trim', $models);
        $endpoint = 'https://api.deepseek.com/chat/completions';
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $api_key,
        );
        foreach ( $models as $model ) {
            $payload = array(
                'model'    => $model,
                'messages' => array(
                    array( 'role' => 'system', 'content' => 'You are a helpful assistant.' ),
                    array( 'role' => 'user', 'content' => $prompt ),
                ),
                'stream'   => false,
            );
            $args = array(
                'body'    => json_encode( $payload ),
                'headers' => $headers,
                'timeout' => 60,
            );
            $response = wp_remote_post( $endpoint, $args );
            if ( is_wp_error( $response ) ) {
                $last_error = new WP_Error( 'api_request_error', $response->get_error_message() );
                continue;
            }
            $response_body = wp_remote_retrieve_body( $response );
            $result = json_decode( $response_body, true );
            if ( ! $result ) {
                $last_error = new WP_Error( 'api_response_parse_error', 'Fallo al analizar los datos de retorno de la API' );
                continue;
            }
            if ( isset( $result['choices'][0]['message']['content'] ) ) {
                return $result['choices'][0]['message']['content'];
            } else {
                $last_error = new WP_Error( 'api_invalid_format', 'El formato de retorno de la API es incorrecto' );
                continue;
            }
        }
        return $last_error ? $last_error : new WP_Error( 'unknown_error', 'Error desconocido' );
    }
    // Interfaz Tongyi Qianwen
    elseif ( $selected_api === 'tongyi' ) {
        $api_key = isset( $options['tongyi_api_key'] ) ? $options['tongyi_api_key'] : '';
        $models = isset( $options['tongyi_model'] ) ? explode( ',', $options['tongyi_model'] ) : array('qwen-plus');
        $models = array_map('trim', $models);
        $endpoint = 'https://dashscope.aliyuncs.com/compatible-mode/v1/chat/completions';
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $api_key,
        );
        foreach ( $models as $model ) {
            $payload = array(
                'model'    => $model,
                'messages' => array(
                    array( 'role' => 'system', 'content' => 'You are a helpful assistant.' ),
                    array( 'role' => 'user', 'content' => $prompt ),
                ),
            );
            $args = array(
                'body'    => json_encode( $payload ),
                'headers' => $headers,
                'timeout' => 60,
            );
            $response = wp_remote_post( $endpoint, $args );
            if ( is_wp_error( $response ) ) {
                $last_error = new WP_Error( 'api_request_error', $response->get_error_message() );
                continue;
            }
            $response_body = wp_remote_retrieve_body( $response );
            $result = json_decode( $response_body, true );
            if ( ! $result ) {
                $last_error = new WP_Error( 'api_response_parse_error', 'Fallo al analizar los datos de retorno de la API' );
                continue;
            }
            if ( isset( $result['choices'][0]['message']['content'] ) ) {
                return $result['choices'][0]['message']['content'];
            } else {
                $last_error = new WP_Error( 'api_invalid_format', 'El formato de retorno de la API es incorrecto' );
                continue;
            }
        }
        return $last_error ? $last_error : new WP_Error( 'unknown_error', 'Error desconocido' );
    }
    // Interfaz Doubao AI
    elseif ( $selected_api === 'doubao' ) {
        $api_key = isset( $options['doubao_api_key'] ) ? $options['doubao_api_key'] : '';
        $models = isset( $options['doubao_model'] ) ? explode( ',', $options['doubao_model'] ) : array('');
        $models = array_map('trim', $models);
        $endpoint = 'https://ark.cn-beijing.volces.com/api/v3/chat/completions';
        $headers = array(
            'Content-Type'  => 'application/json',
            'Authorization' => 'Bearer ' . $api_key,
        );
        foreach ( $models as $model ) {
            $payload = array(
                'model'    => $model,
                'messages' => array(
                    array( 'role' => 'system', 'content' => 'You are a helpful assistant.' ),
                    array( 'role' => 'user', 'content' => $prompt ),
                ),
            );
            $args = array(
                'body'    => json_encode( $payload ),
                'headers' => $headers,
                'timeout' => 60,
            );
            $response = wp_remote_post( $endpoint, $args );
            if ( is_wp_error( $response ) ) {
                $last_error = new WP_Error( 'api_request_error', $response->get_error_message() );
                continue;
            }
            $response_body = wp_remote_retrieve_body( $response );
            $result = json_decode( $response_body, true );
            if ( ! $result ) {
                $last_error = new WP_Error( 'api_response_parse_error', 'Fallo al analizar los datos de retorno de la API' );
                continue;
            }
            if ( isset( $result['choices'][0]['message']['content'] ) ) {
                return $result['choices'][0]['message']['content'];
            } else {
                $last_error = new WP_Error( 'api_invalid_format', 'El formato de retorno de la API es incorrecto' );
                continue;
            }
        }
        return $last_error ? $last_error : new WP_Error( 'unknown_error', 'Error desconocido' );
    } else {
        return new WP_Error( 'invalid_api', 'Interfaz de API no compatible' );
    }
}


// Tencent Cloud TTS API para síntesis de voz (ejemplo de código de la API Explorer oficial)
function wpatai_call_tts_api( $text, $secret_id, $secret_key, $voice_type = 0 ) {
    // Parámetros básicos de la interfaz TTS de Tencent
    $service    = "tts";
    $host       = "tts.tencentcloudapi.com";
    $req_region = "";
    $version    = "2019-08-23";
    $action     = "TextToVoice";
    $endpoint   = "https://tts.tencentcloudapi.com";
    $algorithm  = "TC3-HMAC-SHA256";
    $timestamp  = time();
    $date       = gmdate("Y-m-d", $timestamp);
    
    // Construir parámetros de solicitud TTS (ejemplo que pasa Text y otros parámetros predeterminados, se puede ajustar según la documentación de Tencent)
    $payload_arr = array(
        "Text" => $text,
        "SessionId" => uniqid(),
        "ModelType" => 1,          // Tipo de modelo, predeterminado 1
        "VoiceType" => (int)$voice_type, // Usar el valor de la biblioteca de voz de Tencent Cloud configurado en el panel de administración
        "PrimaryLanguage" => 1,    // Tipo de idioma (1 chino, 2 inglés)
        "Codec" => "mp3"
    );
    $payload = json_encode($payload_arr, JSON_UNESCAPED_UNICODE);
    
    // ************* Paso 1: Concatenar la cadena de solicitud canónica *************
    $http_request_method   = "POST";
    $canonical_uri         = "/";
    $canonical_querystring = "";
    $ct                    = "application/json; charset=utf-8";
    $canonical_headers     = "content-type:".$ct."\nhost:".$host."\nx-tc-action:".strtolower($action)."\n";
    $signed_headers        = "content-type;host;x-tc-action";
    $hashed_request_payload= hash("sha256", $payload);
    $canonical_request     = "$http_request_method\n$canonical_uri\n$canonical_querystring\n$canonical_headers\n$signed_headers\n$hashed_request_payload";
    
    // ************* Paso 2: Concatenar la cadena a firmar *************
    $credential_scope       = "$date/$service/tc3_request";
    $hashed_canonical_request = hash("sha256", $canonical_request);
    $string_to_sign         = "$algorithm\n$timestamp\n$credential_scope\n$hashed_canonical_request";
    
    // ************* Paso 3: Calcular la firma *************
    $secret_date    = wpatai_sign("TC3".$secret_key, $date);
    $secret_service = wpatai_sign($secret_date, $service);
    $secret_signing = wpatai_sign($secret_service, "tc3_request");
    $signature      = hash_hmac("sha256", $string_to_sign, $secret_signing);
    
    // ************* Paso 4: Concatenar la autorización *************
    $authorization  = "$algorithm Credential=$secret_id/$credential_scope, SignedHeaders=$signed_headers, Signature=$signature";
    
    // ************* Paso 5: Construir encabezados de solicitud y enviar solicitud *************
    $headers = array(
        "Authorization"   => $authorization,
        "Content-Type"    => $ct,
        "Host"            => $host,
        "X-TC-Action"     => $action,
        "X-TC-Timestamp"  => $timestamp,
        "X-TC-Version"    => $version,
    );
    if ( $req_region ) {
        $headers["X-TC-Region"] = $req_region;
    }
    
    $args = array(
        'body'    => $payload,
        'headers' => $headers,
        'timeout' => 60,
    );
    
    $response = wp_remote_post( $endpoint, $args );
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'tts_request_error', $response->get_error_message() );
    }
    $response_body = wp_remote_retrieve_body( $response );
    $result = json_decode( $response_body, true );
    if ( ! $result || ! isset( $result['Response'] ) ) {
        return new WP_Error( 'tts_response_error', 'Fallo al analizar los datos de retorno de la API de síntesis de voz' );
    }
    if ( isset( $result['Response']['Error'] ) ) {
        return new WP_Error( 'tts_api_error', 'Error de la API de síntesis de voz: ' . $result['Response']['Error']['Message'] );
    }
    
    // El campo Audio devuelto por Tencent TTS es datos de audio codificados en base64
    if ( isset( $result['Response']['Audio'] ) ) {
        $audio_base64 = $result['Response']['Audio'];
        // Generar enlace de audio en formato URI de datos (formato mp3)
        $audio_data_uri = 'data:audio/mp3;base64,' . $audio_base64;
        return $audio_data_uri;
    } else {
        return new WP_Error( 'tts_invalid_response', 'El formato de retorno de la API de síntesis de voz es incorrecto' );
    }
}

// Baidu Cloud TTS API para síntesis de voz
function wpatai_call_baidu_tts_api( $text, $api_key, $secret_key, $per = 0 ) {
    // Obtener token de acceso
    $token = wpatai_get_baidu_access_token( $api_key, $secret_key );
    if ( is_wp_error( $token ) ) {
        return $token;
    }
    
    $cuid = wp_generate_password( 16, false ); // Generar una cadena aleatoria, de hasta 60 caracteres
    
    $params = array(
        'tex' => $text,
        'tok' => $token,
        'cuid' => $cuid,
        'ctp' => '1',
        'lan' => 'zh',
        'spd' => '5',
        'pit' => '5',
        'vol' => '5',
        'per' => $per,  // Usar el valor de la biblioteca de voz de Baidu Cloud configurado en el panel de administración
        'aue' => '3'
    );
    
    $url = "https://tsn.baidu.com/text2audio";
    $args = array(
        'body'        => http_build_query($params),
        'timeout'     => 60,
        'sslverify'   => false,
        'headers'     => array(
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept'       => '*/*'
        ),
    );
    
    $response = wp_remote_post( $url, $args );
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'baidu_tts_request_error', $response->get_error_message() );
    }
    
    // Si la interfaz de Baidu tiene éxito, devuelve directamente los datos binarios de audio; de lo contrario, devuelve información de error JSON
    $content_type = wp_remote_retrieve_header( $response, 'content-type' );
    $body = wp_remote_retrieve_body( $response );
    if ( strpos($content_type, 'application/json') !== false ) {
        $result = json_decode($body, true);
        if ( isset($result['err_no']) && $result['err_no'] != 0 ) {
            return new WP_Error( 'baidu_tts_api_error', 'Error de síntesis de voz de Baidu: ' . $result['err_msg'] );
        }
        return new WP_Error( 'baidu_tts_invalid_response', 'El formato de retorno de la síntesis de voz de Baidu es incorrecto' );
    } else {
        // Convertir los datos binarios de audio devueltos a base64 y generar un URI de datos
        $audio_data_uri = 'data:audio/mp3;base64,' . base64_encode($body);
        return $audio_data_uri;
    }
}

// Baidu Cloud API_KEY y SECRET_KEY para obtener Access Token
function wpatai_get_baidu_access_token( $api_key, $secret_key ) {
    $url = 'https://aip.baidubce.com/oauth/2.0/token';
    $post_data = array(
        'grant_type'    => 'client_credentials',
        'client_id'     => $api_key,
        'client_secret' => $secret_key
    );
    
    $args = array(
        'body'      => http_build_query($post_data),
        'timeout'   => 60,
        'sslverify' => false,
    );
    
    $response = wp_remote_post( $url, $args );
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'baidu_token_request_error', $response->get_error_message() );
    }
    
    $body = wp_remote_retrieve_body( $response );
    $result = json_decode( $body, true );
    if ( isset($result['access_token']) ) {
        return $result['access_token'];
    } else {
        return new WP_Error( 'baidu_token_error', 'Fallo al obtener el token de acceso de Baidu' );
    }
}

// Función para calcular la firma
function wpatai_sign($key, $msg) {
    return hash_hmac("sha256", $msg, $key, true);
}

// Función de síntesis de voz pública (otros plugins pueden llamar a la lectura de voz)
function wpatai_generate_tts_audio( $text, $interface = 'tencent' ) {
    $options = get_option( 'wpatai_settings' );

    // Asegurarse de procesar solo texto plano (excluir etiquetas HTML, etc.)
    $text = wp_strip_all_tags( $text );

    if ( $interface === 'baidu' ) {
        $baidu_api_key    = isset( $options['baidu_api_key'] ) ? trim( $options['baidu_api_key'] ) : '';
        $baidu_secret_key = isset( $options['baidu_secret_key'] ) ? trim( $options['baidu_secret_key'] ) : '';
        $baidu_per        = isset( $options['baidu_per'] ) ? $options['baidu_per'] : 0;
        if ( empty( $baidu_api_key ) || empty( $baidu_secret_key ) ) {
            return new WP_Error( 'baidu_credentials_error', 'Credenciales de Baidu Cloud no configuradas' );
        }
        return wpatai_call_baidu_tts_api( $text, $baidu_api_key, $baidu_secret_key, $baidu_per );
    } else {
        // Por defecto, usar la interfaz de Tencent Cloud
        $tencent_secret_id   = isset( $options['tencent_secret_id'] ) ? trim( $options['tencent_secret_id'] ) : '';
        $tencent_secret_key  = isset( $options['tencent_secret_key'] ) ? trim( $options['tencent_secret_key'] ) : '';
        $tencent_voice_type  = isset( $options['tencent_voice_type'] ) ? (int)$options['tencent_voice_type'] : 0;
        if ( empty( $tencent_secret_id ) || empty( $tencent_secret_key ) ) {
            return new WP_Error( 'tencent_credentials_error', 'Credenciales de Tencent Cloud no configuradas' );
        }
        return wpatai_call_tts_api( $text, $tencent_secret_id, $tencent_secret_key, $tencent_voice_type );
    }
}

// Para recibir la URL de audio generada
function wpatai_tts_generate_action( $text, $interface, $callback ) {
    $result = wpatai_generate_tts_audio( $text, $interface );
    if ( is_callable( $callback ) ) {
        call_user_func( $callback, $result );
    }
}
add_action( 'wpatai_tts_generate', 'wpatai_tts_generate_action', 10, 3 );

// Eliminar elementos de configuración al desinstalar el plugin
function wpatai_delete_plugin_settings() {
    delete_option('wpatai_settings');
}
register_uninstall_hook(__FILE__, 'wpatai_delete_plugin_settings');

?>
