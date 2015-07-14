<?php
namespace Nicklasos\ConfigServer\Storage;

interface StorageInterface
{
    public function set($key, $value);

    public function get($key);

    public function getAll();

    public function drop($key);
}