<?php

define( 'DB_NAME', 'fibromyrelief' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', 'localhost' );

define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define('AUTH_KEY',         'a NFju:|J+VYOD6,C`C-`>b51v`CrUjZRd:f0VW|`m G:$(b)p=|4<IDFp.&EIJ!');
define('SECURE_AUTH_KEY',  ')-C{.8xz.L{PQnQg}#_lE6H4-j_|ddE|,CiQN{[ {[  ?YOZqQ0,7-5d4_1,x/LH');
define('LOGGED_IN_KEY',    'e:#r)?APqH60|Z+b^e08HPW].3*|QY^VelPP)73:Y31N^l/,8#u#1`qs[{ v/>jp');
define('NONCE_KEY',        'pf.qy)O+uwCG&$TxuDK;&+TR)k2M-~7qW`-P$|oBx[@ ]IW2}4a=>X0p0~_s[Si~');
define('AUTH_SALT',        'wa[0OC(KmID,^2j0EFK^|;Lz#GE%+F46@wce3TaocG*F7YdI(4Yt4bInG#!kjp{n');
define('SECURE_AUTH_SALT', ']-VMBS ;wVwV`@|{{Ru:#Lo}7UTHv0U]-^BB}@e?lHlgp(7e-v,X6i@/e0#`rcH!');
define('LOGGED_IN_SALT',   'jeDHq&HPTuGk97Nrfi<q(!@|En_g$L<#gMOYOjw|-Amx!xdhn!{>AkBZ%`8}O6{=');
define('NONCE_SALT',       '`u0d|s e?wPUZ:S3f9Fg-G]xj/Uu;< 6d@D1cT)3W5V|A-rAJc+jD5K~By2&u.|b');

$table_prefix = 'wp_';

define( 'WP_DEBUG', false );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
