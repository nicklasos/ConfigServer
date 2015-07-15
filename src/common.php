<?php
// TODO: move to Memcached
if (!class_exists('Memcache')) {
    define('MEMCACHE_COMPRESSED', 0);
    class Memcache {}
}
