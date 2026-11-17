<?php
/**
 * WordPress 配置（Abasthan 部署用）：数据库信息全部从环境变量读取，
 * 仓库里不落任何凭据。需要在 Abasthan 应用设置里配置的环境变量：
 *   DB_HOST / DB_PORT / DB_NAME / DB_USER / DB_PASSWORD / DB_SSL(可选,=1 时启用 SSL)
 */

// ** 数据库设置 ** //
$_db_host = getenv('DB_HOST') ?: 'localhost';
$_db_port = getenv('DB_PORT') ?: '';
if ($_db_port !== '' && strpos($_db_host, ':') === false) {
    $_db_host .= ':' . $_db_port;
}
define('DB_NAME', getenv('DB_NAME') ?: 'wordpress');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
define('DB_HOST', $_db_host);
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// Aiven 等远程 MySQL 强制 SSL 时启用（环境变量 DB_SSL=1）
if (getenv('DB_SSL')) {
    define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_SSL);
}

/**#@+
 * 身份认证密钥与盐。正式使用前请在环境变量里逐项设置同名变量覆盖，
 * 或到 https://api.wordpress.org/secret-key/1.1/salt/ 生成后替换。
 */
define('AUTH_KEY',         getenv('AUTH_KEY') ?: 'put your unique phrase here');
define('SECURE_AUTH_KEY',  getenv('SECURE_AUTH_KEY') ?: 'put your unique phrase here');
define('LOGGED_IN_KEY',    getenv('LOGGED_IN_KEY') ?: 'put your unique phrase here');
define('NONCE_KEY',        getenv('NONCE_KEY') ?: 'put your unique phrase here');
define('AUTH_SALT',        getenv('AUTH_SALT') ?: 'put your unique phrase here');
define('SECURE_AUTH_SALT', getenv('SECURE_AUTH_SALT') ?: 'put your unique phrase here');
define('LOGGED_IN_SALT',   getenv('LOGGED_IN_SALT') ?: 'put your unique phrase here');
define('NONCE_SALT',       getenv('NONCE_SALT') ?: 'put your unique phrase here');
/**#@-*/

$table_prefix = getenv('TABLE_PREFIX') ?: 'wp_';

define('WP_DEBUG', getenv('WP_DEBUG') ? filter_var(getenv('WP_DEBUG'), FILTER_VALIDATE_BOOLEAN) : false);

// 平台反代 HTTPS 时让 WordPress 正确识别协议
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

/* 好了，请停止编辑。祝你写博客愉快！ */

/** WordPress 目录的绝对路径。 */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** 设置 WordPress 变量和包含的文件。 */
require_once ABSPATH . 'wp-settings.php';
