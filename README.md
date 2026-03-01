<img src="https://github.com/suqicloud/wp-ai-chat/blob/main/ic_logo.png" width="60">

# Xiaoban WordPress Asistente AI

[![License](https://img.shields.io/badge/license-GPL-blue.svg)](LICENSE)
[![Version](https://img.shields.io/badge/version-4.0.5-green.svg)](https://github.com/suqicloud/wp-ai-chat/releases/tag/4.0.5)
[![WordPress](https://img.shields.io/badge/WordPress-6.7-blue.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.0-orange.svg)](https://www.php.net/)
[![Nginx](https://img.shields.io/badge/Nginx-1.2-green.svg)](https://nginx.org/)



## 📌 Introducción del Proyecto

Totalmente de código abierto y gratuito - Plugin de asistente AI para WordPress, puede implementar: chat de conversación AI (texto, generación de imágenes, generación de videos), reproducción de voz de conversación AI, generación de artículos AI, análisis SEO de artículos AI, resumen de artículos AI, traducción de artículos AI, generación de PPT por AI, análisis de documentos AI, aplicaciones de agentes inteligentes AI, reproducción de voz del contenido de artículos.
Si no sabe cómo usarlo, primero lea la documentación, es solo cuestión de una configuración básica y la conexión con apikey, este tipo de plugin no tiene requisitos de alta dificultad.


Este proyecto temporalmente no actualizará nuevas funciones, actualmente no afecta el uso.
En el futuro, las actualizaciones se centrarán en el código fuente comercial relacionado con herramientas AI Wuji: https://www.wujiit.com


## 🚀 Características Funcionales

1. Interfaz de texto DeepSeek integrada
1. Interfaz de texto Alibaba Tongyi Qianwen integrada
1. Interfaz de texto Baidu Qianfan (Wenxin Yiyan) integrada
1. Interfaz de texto Doubao AI integrada
1. Interfaz de texto Kimi integrada
1. Interfaz de texto OpenAI integrada
1. Interfaz de texto Tencent Hunyuan integrada
1. Interfaz de texto Grok integrada
1. Interfaz de texto Gemini integrada
1. Interfaz de texto Claude integrada
1. Interfaz de texto iFlytek Xinghuo integrada
1. Interfaz de modelo de texto AI personalizado integrada
1. Soporte para conexión de aplicaciones de agentes inteligentes Alibaba
1. Soporte para conexión de aplicaciones de agentes inteligentes Volcengine
1. Soporte para conexión de aplicaciones de agentes inteligentes Tencent Yuanqi
1. Soporte para conexión de aplicaciones de agentes inteligentes ByteDance Coze
1. Soporte para interfaz Wenduoduo AIPPT para generar archivos PPT
1. Soporte para modelo de texto a imagen de pollinations ai
1. Soporte para modelo de generación de imágenes de Tongyi Qianwen
1. Soporte para modelo de generación de videos de Tongyi Qianwen (texto a video, imagen a video)
1. Soporte para búsqueda en línea de algunos modelos de Tongyi Qianwen e iFlytek Xinghuo
1. Los parámetros del modelo se configuran manualmente
1. El sistema usa una tabla de datos separada para guardar la primera frase del registro de conversación
1. Los usuarios pueden eliminar sus propios registros de conversación histórica
1. El backend puede eliminar los registros de conversación de los usuarios
1. El backend puede eliminar las conversaciones de aplicaciones de agentes inteligentes de los usuarios
1. Se pueden generar artículos a través de palabras clave
1. Se puede resumir artículos a través de la interfaz AI
1. El frontend muestra la entrada del asistente AI
1. Solo permite el uso a usuarios registrados
1. Soporte para formato Markdown
1. Información de saldo de DeepSeek
1. Traducción de artículos a través de la interfaz AI
1. Soporte para conectar servicios TTS de Tencent Cloud y Baidu Cloud para reproducir voz del contenido de artículos
1. Puede reproducir por voz el contenido de texto de las respuestas AI
1. Se pueden personalizar los prompts
1. Enlace al tutorial de personalización de prompts
1. Carga automática del botón de copiar en el panel de contenido Markdown
1. Soporte para detección de palabras clave prohibidas
1. La generación de PPT por AI puede verificar permisos de membresía (puede no funcionar en algunos sitios)
1. Preguntas de apertura de aplicaciones de agentes inteligentes
1. Personalización del nombre del asistente AI en el frontend, etc.
1. Personalización del texto de aviso para usuarios no registrados
1. Soporte para que usuarios del frontend seleccionen la interfaz
1. Soporte para que Kimi y Tongyi Qianwen qwen-long carguen archivos y analicen contenido de documentos
1. Soporte para que usuarios del frontend seleccionen parámetros del modelo
1. Soporte para análisis SEO del contenido de artículos, con detección simultánea de errores tipográficos


## 📥 Instalación

1. Descargue el archivo de la última versión.
2. Ingrese al backend de plugins de WordPress
3. Suba el paquete de archivos local para instalar

O puede subir directamente al directorio de plugins del sitio web en el servidor /wp-content/plugins, recuerde configurar los permisos.

Base de desarrollo: WordPress 6.7.1
Versión de PHP: PHP 8.0

## 🛠️ Método de Uso

La activación del plugin creará automáticamente una página de conversación en el frontend. Si no se crea automáticamente, puede agregar manualmente el shortcode: [deepseek_chat]

1 - La interfaz de traducción de artículos debe configurarse por separado, porque originalmente era otro plugin mío, lo combiné y no quería complicarme, así que lo usé directamente.
2 - La generación de PPT por AI también es una combinación de un plugin independiente, y esta función fue ajustada originalmente según el tema que yo usaba, puede que la compatibilidad no sea buena.


Si deja de usar el plugin por completo, elimine manualmente estas tablas de datos en la base de datos: deepseek_chat_logs, deepseek_agent_chat_logs, estas 2 tablas de datos.

Tutorial: https://www.wujiit.com/wpaidocs

La página del tema necesita soportar modo de ancho completo o pantalla completa, de lo contrario será muy estrecho. Si no es compatible, verifique los estilos de su tema y logre que la página del asistente deepseek se muestre en pantalla completa a través del código.

Este plugin fue creado originalmente para probar la capacidad de deepseek de escribir código por sí mismo, parte del código fue escrito por deepseek (la conexión de conversación AI con deepseek y la versión original de generación de artículos), luego se combinaron otros plugins, por lo que los nombres de funciones en el código pueden parecer desordenados, pero todos tienen comentarios.


## Descripción de Archivos

Archivo principal: wp-ai-chat.php
Archivo de traducción de voz: wpaitranslate.php
Archivo de generación de PPT por AI: wpaippt.php
Archivo de aplicaciones de agentes inteligentes: wpaidashscope.php
Archivo JS principal: wpai-chat.js
Archivo CSS: wpai-style.css
Archivo JS de traducción de voz: wpai-script.js
Archivo JS de llamada PPT: docmee-ui-sdk-iframe.min.js
Archivo de análisis Markdown: marked.min.js


![2fa114d7cc7d22ae16005bb39925a2df.jpeg](https://i.miji.bid/2025/03/02/2fa114d7cc7d22ae16005bb39925a2df.jpeg)
![be8d09585a3c7da555d8edd2997d46bf.jpeg](https://i.miji.bid/2025/02/24/be8d09585a3c7da555d8edd2997d46bf.jpeg)
![a979fdb418172e3cbb8241d211e5fff5.jpeg](https://i.miji.bid/2025/02/17/a979fdb418172e3cbb8241d211e5fff5.jpeg)
