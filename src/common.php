<?php
// TODO: move to Memcached
if (!class_exists('Memcache')) {
    class Memcache {
        const MEMCACHE_COMPRESSED = 0;
    }
}
