<?php

namespace Chemdex;

class Config {

    protected $values;

    public function __construct() {
        $this->values = array();
    }

    public function get($key) {
        $parsed = $this->parseKeys($key);
        return (isset($parsed[1][$parsed[0]])) ? $parsed[1][$parsed[0]] : null;
    }

    public function set($key, $value = null) {
        if (is_null($value)) {
            $this->remove($key);
        }

        $parsed = $this->parseKeys($key);
        $arr =& $parsed[1];
        $arr[$parsed[0]] = $value;

        return $this;
    }

    public function has($key) {
        $parsed = $this->parseKeys($key);
        return isset($parsed[1][$parsed[0]]);
    }

    public function remove($key) {
        $parsed = $this->parseKeys($key);

        $arr =& $parsed[1];
        unset($arr[$parsed[0]]);

        return $this;
    }

    public function replace(array $values, $merge = true) {
        $this->values = $merge ? array_merge_recursive($this->values, $values) : $values;
    }

    public function getRaw() {
        return $this->values;
    }

    protected function parseKeys($key) {
        $keys = explode('.', $key);

        $arr =& $this->values;
        $count = count($keys);

        for($i = 0; $i < $count; $i++) {
            $currentKey = array_shift($keys);

            if (count($keys) == 0) {
                return array($currentKey, &$arr);
            }

            if (!isset($arr[$currentKey])) {
                $arr[$currentKey] = array();
            } else if (!is_array($arr[$currentKey])) {
                throw new \InvalidArgumentException("$currentKey is not an array");
            }

            $arr =& $arr[$currentKey];
        }
    }

    public function loadFile($fileName, $merge = true) {
        $file = preg_match('/^\.php$/', $fileName) ? $fileName : $fileName . '.php';

        if (file_exists($file)) {
            $data = (array) require($file);

            $this->replace($data, $merge);
        }

        return $this;
    }

}
