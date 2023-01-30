<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

if (file_exists('/home/deploy/secret/.env')) {
    $lines = file('/home/deploy/secret/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {

        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
         }
      }
  }

define('DB_NAME',          $_ENV['DB_NAME']);
define('DB_USER',          $_ENV['DB_USER']);
define('DB_PASSWORD',      $_ENV['DB_PASSWORD']);
define('DB_HOST',          $_ENV['DB_HOST']);
define( 'DB_CHARSET', 'utf8mb4' );


define( 'DB_COLLATE', '' );
define( 'AUTH_KEY',         'U,/1>($i1qVv1Y)vas7 42sTh?0u]@>zVc[QOvFfVQpbRtz|ul0?y{Xo^o:%Y^.Y' );
define( 'SECURE_AUTH_KEY',  'K|v(3oHfg<G#]t`@r9bBA; V?<(J!^3A_#0x9D|~Ovi{Cp*aM_^_N$6KiWaP8b#(' );
define( 'LOGGED_IN_KEY',    '.O1kOd3q{.,>i8nuCW @pxQDGQ;T8#m.i5-qz%orRWpr& G_uU*hfml>k9>Z0k]m' );
define( 'NONCE_KEY',        '1eqD!y#l*)~Dna)gH}&m9h!Ip7M1edCzBb3g[le53UL4rhQtysM_6uAa9j,:&NDl' );
define( 'AUTH_SALT',        '4!wTU/[VMvk*^jFjAFCHkvTM68=#{k$Cw}@xnwoJSHF-68+2+TcVT^yw)ayyajr2' );
define( 'SECURE_AUTH_SALT', 'X&xzgYI^D)rs}/s:-Y1Qd5x4pvPqdK)#eJ_FnU/ImZ@PP2G$G90Bb+[PkQ.<]W_C' );
define( 'LOGGED_IN_SALT',   'oa*zH3iF#HI.68yS*#$<Pjsed#+` 7d[[7d~/dZ</VmE8oOAv{M%xS^@Zu=e0l3^' );
define( 'NONCE_SALT',       'cG;;2bm`BZB90pPJ75()m#ZY)CG5T<|_p=pq_GvWq,rvf[c#Pp,F:l+@P=B)Eddn' );

define( 'WP_DEBUG', false );
define('WP_DEBUG_LOG', true);
define('SCRIPT_DEBUG', true);
define('SAVEQUERIES', true);
define('ALLOW_UNFILTERED_UPLOADS', true);

$table_prefix = 'wp_';

define('FS_METHOD', 'direct');
define('WP_TEMP_DIR', ABSPATH . 'wp-content/');

define( 'WP_MEMORY_LIMIT', '712M' );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Detect if SSL is used. This is required since we are terminating SSL either on CloudFront or on ELB */
if (($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] == 'https') OR ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'))
    {$_SERVER['HTTPS']='on';}

require_once(ABSPATH . 'wp-settings.php');

