<?php 

/*
* Flattr Config
* Created By - Avinash Barik
*/

define(ADMIN_ID, "avinashbarik91");
define(ADMIN_PASSWORD, "avi1@345");
define(PATH_TO_POSTS, $_SERVER['DOCUMENT_ROOT'] . "/posts/");
define(POST_FILENAME, "blog_directory.json");
define(TINY_MCE_API_KEY, "04qe270rku2oi9r0x49bl83hawj7ff4bn49triqjbgh0t9iw");
define(TWITTER_HANDLE, "avinashbarik91");
define(NAVBAR_BRAND, "Blogs");
define(OFFICIAL_EMAIL, "avinashbarik91@gmail.com");
define(APP_VERSION_NO, "1.1");
define(SHOW_COMMENTS_SECTION, true);
define(DISQUS_SITE_NAME, "avinashbarik");
define(FAVICON_PATH, "https://d28qd0hzg413m1.cloudfront.net/images/favicon-96x96.png");
define(APP_HTACCESS, "Options +FollowSymLinks
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /posts/index.php?path=$1 [NC,L,QSA]
RedirectMatch 404 \.json$");
?>