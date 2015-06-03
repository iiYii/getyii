<?php
namespace common\components;

use Yii;
use yii\base\Object;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;

class Config extends Object
{
    protected $data;

    /**
     * model class 名,如果未指定初始数据, 会根据此值从model类中取数据
     * @var string
     */
    public $loadModel;
    /**
     * 如果指定了loadModel, 缓存的键值,必须注意cache键值, 缓存的键值会经过md5加密, 未指定会使用loadModel代替
     * @var string
     */
    private $_cacheKey;
    /**
     * 缓存时间, 如果为0表示永久缓存, false 表示不缓存
     * @var int|bool
     */
    public $cacheTime = 3600;

    public $autoSave = true;

    /**
     * 数据保存
     * @var array
     */
    private $_data = [];

    /**
     * 被修改的设置键值(当需要触发保存设置时.可以从该设置中查询修改了的值然后保存)
     * @var array
     */
    private $_changedDataKeys = [];

    /**
     * 从model类指定的存储介质中(数据库, 缓存数据库, nosql数据库等...)取数据
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->loadModel !== null) {
            $loadModel = $this->loadModel;

            if (!method_exists($loadModel, 'getData')) {
                throw new InvalidConfigException("Class {$loadModel}::getData() is undefined.");
            } elseif ($this->cacheTime !== false) {
                $cache = Yii::$app->getCache();
                $cacheKey = $this->getCacheKey();
                if (($data = $cache->get($cacheKey, false)) === false) {
                    $data = $loadModel::getData();
                    $cache->set($cacheKey, $data, $this->cacheTime);
                }
            } else {
                $data = $loadModel::getData();
            }
            $this->setData($data);

            // 自动保存修改后的数据
            $this->autoSave && register_shutdown_function(function () {
                $this->saveData();
            });
        }
    }

    /**
     * 获取设置数据
     * @return array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * 设置设置数据
     * @param $data
     */
    public function setData($data)
    {
        $this->_data = $data;
    }

    /**
     * 设置指定键值的设置数据
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->_data[$name] = $value;
        $this->_changedDataKeys[] = $name;
    }

    /**
     * 获取指定键值的设置数据
     * @param $name
     * @param null $defaultValue
     * @return null
     */
    public function get($name, $defaultValue = null)
    {
        return array_key_exists($name, $this->_data) ? $this->_data[$name] : $defaultValue;
    }

    public function setCacheKey($cacheKey)
    {
        $this->_cacheKey = $cacheKey;
    }

    public function getCacheKey()
    {
        if ($this->_cacheKey === null) {
            if ($this->loadModel === null) {
                throw new InvalidCallException('The cacheKey property of Config class must be set.');
            }
            $this->setCacheKey('menu_' . md5($this->loadModel));
        }
        return $this->_cacheKey;
    }

    /**
     * 保存数据(智慧保存修改后的数据)
     * @return mixed
     * @throws \yii\base\InvalidCallException
     */
    public function saveData()
    {
        if ($this->loadModel === null) {
            throw new InvalidCallException("The data of class Config can't save. becase loadModel is not set.");
        }
        $loadModel = $this->loadModel;
        $data = [];
        foreach (array_unique($this->_changedDataKeys) as $name) { // 去重取出修改后的数据
            $data[$name] = $this->get($name);
        }
        if (empty($data)) {
            return true;
        } elseif ($loadModel::saveData($data)) {
            $this->_changedDataKeys; //保存后可以清空了
            Yii::$app->getCache()->delete($this->getCacheKey()); // 更新数据后清除旧缓存
            return true;
        }
        return false;
    }
}

//class Config extends Object implements \Countable, \Iterator, \ArrayAccess
//{
//    /**
//     * model class 名,如果未指定初始数据, 会根据此值从model类中取数据
//     * @var string
//     */
//    protected $loadModel;
//    /**
//     * 如果指定了loadModel, 缓存的键值,必须注意cache键值, 缓存的键值会经过md5加密, 未指定会使用loadModel代替
//     * @var string
//     */
//    protected $cacheKey;
//    /**
//     * 缓存时间, 如果为0表示永久缓存, false 表示不缓存
//     * @var int|bool
//     */
//    protected $cacheTime = 3600;
//
//    /**
//     * Config 根据数据深度来循环, 该属性会用来标记最终父级分支
//     * @var array
//     */
//    protected $topClass;
//
//    /**
//     * Whether modifications to configuration data are allowed.
//     *
//     * @var bool
//     */
//    protected $allowModifications = true;
//
//    /**
//     * Number of elements in configuration data.
//     *
//     * @var int
//     */
//    protected $count;
//
//    /**
//     * Data within the configuration.
//     *
//     * @var array
//     */
//    protected $data = array();
//
//    /**
//     * Used when unsetting values during iteration to ensure we do not skip
//     * the next element.
//     *
//     * @var bool
//     */
//    protected $skipNextIteration;
//
//    public function __construct(array $data = null, array $properties = [])
//    {
//        foreach ($properties as $name => $value) {
//            $this->$name = $value;
//        }
//
//        if ($data !== null) {
//            $this->setData($data);
//        } else {
//            $this->init();
//        }
//    }
//
//    protected function setData(array $array)
//    {
//        foreach ($array as $key => $value) {
//            if (is_array($value)) {
//                $this->data[$key] = new static($value, [
//                    'allowModifications' => $this->allowModifications,
//                    'topClass' => $this->topClass
//                ]);
//            } else {
//                $this->data[$key] = $value;
//            }
//
//            $this->count++;
//        }
//    }
//
//    public function init()
//    {
//        if ($this->loadModel !== null) {
//            $loadModel = $this->loadModel;
//            if (!method_exists($loadModel, 'getData')) {
//                throw new InvalidConfigException("Class {$loadModel}::getData() is undefined.");
//            } elseif ($this->cacheTime === false) {
//                $data = $loadModel::getData();
//            } else {
//                $cache = Yii::$app->get('cache');
//                $cacheKey = md5($this->cacheKey ? $this->cacheKey : $this->loadModel);
//                if (($data = $cache->get($cacheKey, false)) === false) {
//                    $data = $loadModel::getData();
//                    $cache->set($cacheKey, $data, $this->cacheTime);
//                }
//            }
//            $this->setData($data);
//        }
//    }
//
//    /**
//     * Retrieve a value and return $default if there is no element set.
//     *
//     * @param  string $name
//     * @param  mixed  $default
//     * @return mixed
//     */
//    public function get($name, $default = null)
//    {
//        if (array_key_exists($name, $this->data)) {
//            return $this->data[$name];
//        }
//
//        return $default;
//    }
//
//    /**
//     * Magic function so that $obj->value will work.
//     *
//     * @param  string $name
//     * @return mixed
//     */
//    public function __get($name)
//    {
//        return $this->get($name);
//    }
//
//    /**
//     * Set a value in the config.
//     *
//     * Only allow setting of a property if $allowModifications  was set to true
//     * on construction. Otherwise, throw an exception.
//     *
//     * @param  string $name
//     * @param  mixed  $value
//     * @return void
//     * @throws Exception\RuntimeException
//     */
//    public function __set($name, $value)
//    {
//        if ($this->allowModifications) {
//
//            if (is_array($value)) {
//                $value = new static($value, true);
//            }
//
//            if (null === $name) {
//                $this->data[] = $value;
//            } else {
//                $this->data[$name] = $value;
//            }
//
//            $this->count++;
//        } else {
//            throw new Exception\RuntimeException('Config is read only');
//        }
//    }
//
//    /**
//     * Deep clone of this instance to ensure that nested Zend\Configs are also
//     * cloned.
//     *
//     * @return void
//     */
//    public function __clone()
//    {
//        $array = array();
//
//        foreach ($this->data as $key => $value) {
//            if ($value instanceof self) {
//                $array[$key] = clone $value;
//            } else {
//                $array[$key] = $value;
//            }
//        }
//
//        $this->data = $array;
//    }
//
//    /**
//     * Return an associative array of the stored data.
//     *
//     * @return array
//     */
//    public function toArray()
//    {
//        $array = array();
//        $data  = $this->data;
//
//        /** @var self $value */
//        foreach ($data as $key => $value) {
//            if ($value instanceof self) {
//                $array[$key] = $value->toArray();
//            } else {
//                $array[$key] = $value;
//            }
//        }
//
//        return $array;
//    }
//
//    /**
//     * isset() overloading
//     *
//     * @param  string $name
//     * @return bool
//     */
//    public function __isset($name)
//    {
//        return isset($this->data[$name]);
//    }
//
//    /**
//     * unset() overloading
//     *
//     * @param  string $name
//     * @return void
//     * @throws Exception\InvalidArgumentException
//     */
//    public function __unset($name)
//    {
//        if (!$this->allowModifications) {
//            throw new Exception\InvalidArgumentException('Config is read only');
//        } elseif (isset($this->data[$name])) {
//            unset($this->data[$name]);
//            $this->count--;
//            $this->skipNextIteration = true;
//        }
//    }
//
//    /**
//     * count(): defined by Countable interface.
//     *
//     * @see    Countable::count()
//     * @return int
//     */
//    public function count()
//    {
//        return $this->count;
//    }
//
//    /**
//     * current(): defined by Iterator interface.
//     *
//     * @see    Iterator::current()
//     * @return mixed
//     */
//    public function current()
//    {
//        $this->skipNextIteration = false;
//        return current($this->data);
//    }
//
//    /**
//     * key(): defined by Iterator interface.
//     *
//     * @see    Iterator::key()
//     * @return mixed
//     */
//    public function key()
//    {
//        return key($this->data);
//    }
//
//    /**
//     * next(): defined by Iterator interface.
//     *
//     * @see    Iterator::next()
//     * @return void
//     */
//    public function next()
//    {
//        if ($this->skipNextIteration) {
//            $this->skipNextIteration = false;
//            return;
//        }
//
//        next($this->data);
//    }
//
//    /**
//     * rewind(): defined by Iterator interface.
//     *
//     * @see    Iterator::rewind()
//     * @return void
//     */
//    public function rewind()
//    {
//        $this->skipNextIteration = false;
//        reset($this->data);
//    }
//
//    /**
//     * valid(): defined by Iterator interface.
//     *
//     * @see    Iterator::valid()
//     * @return bool
//     */
//    public function valid()
//    {
//        return ($this->key() !== null);
//    }
//
//    /**
//     * offsetExists(): defined by ArrayAccess interface.
//     *
//     * @see    ArrayAccess::offsetExists()
//     * @param  mixed $offset
//     * @return bool
//     */
//    public function offsetExists($offset)
//    {
//        return $this->__isset($offset);
//    }
//
//    /**
//     * offsetGet(): defined by ArrayAccess interface.
//     *
//     * @see    ArrayAccess::offsetGet()
//     * @param  mixed $offset
//     * @return mixed
//     */
//    public function offsetGet($offset)
//    {
//        return $this->__get($offset);
//    }
//
//    /**
//     * offsetSet(): defined by ArrayAccess interface.
//     *
//     * @see    ArrayAccess::offsetSet()
//     * @param  mixed $offset
//     * @param  mixed $value
//     * @return void
//     */
//    public function offsetSet($offset, $value)
//    {
//        $this->__set($offset, $value);
//    }
//
//    /**
//     * offsetUnset(): defined by ArrayAccess interface.
//     *
//     * @see    ArrayAccess::offsetUnset()
//     * @param  mixed $offset
//     * @return void
//     */
//    public function offsetUnset($offset)
//    {
//        $this->__unset($offset);
//    }
//
//    /**
//     * Merge another Config with this one.
//     *
//     * For duplicate keys, the following will be performed:
//     * - Nested Configs will be recursively merged.
//     * - Items in $merge with INTEGER keys will be appended.
//     * - Items in $merge with STRING keys will overwrite current values.
//     *
//     * @param  Config $merge
//     * @return Config
//     */
//    public function merge(Config $merge)
//    {
//        /** @var Config $value */
//        foreach ($merge as $key => $value) {
//            if (array_key_exists($key, $this->data)) {
//                if (is_int($key)) {
//                    $this->data[] = $value;
//                } elseif ($value instanceof self && $this->data[$key] instanceof self) {
//                    $this->data[$key]->merge($value);
//                } else {
//                    if ($value instanceof self) {
//                        $this->data[$key] = new static($value->toArray(), $this->allowModifications);
//                    } else {
//                        $this->data[$key] = $value;
//                    }
//                }
//            } else {
//                if ($value instanceof self) {
//                    $this->data[$key] = new static($value->toArray(), $this->allowModifications);
//                } else {
//                    $this->data[$key] = $value;
//                }
//
//                $this->count++;
//            }
//        }
//
//        return $this;
//    }
//
//    /**
//     * Prevent any more modifications being made to this instance.
//     *
//     * Useful after merge() has been used to merge multiple Config objects
//     * into one object which should then not be modified again.
//     *
//     * @return void
//     */
//    public function setReadOnly()
//    {
//        $this->allowModifications = false;
//
//        /** @var Config $value */
//        foreach ($this->data as $value) {
//            if ($value instanceof self) {
//                $value->setReadOnly();
//            }
//        }
//    }
//
//    /**
//     * Returns whether this Config object is read only or not.
//     *
//     * @return bool
//     */
//    public function isReadOnly()
//    {
//        return !$this->allowModifications;
//    }
//}