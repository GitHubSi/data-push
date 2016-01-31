<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 2016/1/24
 * Time: 21:14
 */
class RedisFactory {
    static $redis_list = array();

    /**
     *
     * @param string $name
     * @param array $arguments
     * @return RedisFactory
     * @throws Exception
     */
    public static function __callStatic($name, $arguments) {
        switch ($name) {
            case 'get':
                list($redis_name, ) = $arguments ? $arguments : array('normal');
                if (!isset(self::$redis_list[$redis_name])) {
                    $redis_list = Application::$configs['redis'];
                    if (isset($redis_list[$redis_name])) {
                        try {
                            $redis_handle = new Redis();
                            $connected = $redis_handle->pconnect(
                                $redis_list[$redis_name]['host'],
                                $redis_list[$redis_name]['port'],
                                30,
                                sprintf('%s_%s_%s', $redis_list[$redis_name]['host'], $redis_list[$redis_name]['port'], $redis_list[$redis_name]['db'])   //屏蔽此句导致问题
                            );
                            if (false == $connected) {
                                throw new Exception(sprintf('can\'t connect %s redis %s', $redis_name, json_encode($redis_list[$redis_name])));
                            }
                            $selected = $redis_handle->select((int)$redis_list[$redis_name]['db']);
                            if (false == $selected) {
                                throw new Exception(sprintf('connect %s redis %s select db failed', $redis_name, json_encode($redis_list[$redis_name])));
                            }
                            self::$redis_list[$redis_name] = new self($redis_handle);
                        } catch (RedisException $e) {
                            throw new Exception($e->getMessage());
                        }
                    } else {
                        throw new Exception('no config data key `' . $redis_name . '`');
                    }
                }

                return self::$redis_list[$redis_name];
                break;
            //其他case 省略
            default :
                throw new Exception('RedisFactory unknown static method `' . $name . '`');
        }
    }

    /**
     *
     */
    public static function clear() {
        foreach (self::$redis_list as $redis_factory_handle) {
            $redis_factory_handle->close();
        }
    }

    private $_redis_handle;

    /**
     *
     * @param Redis $redis_handle
     */
    public function __construct($redis_handle) {
        $this->_redis_handle = $redis_handle;
    }

    /**
     *
     * @return Redis
     */
    public function get_origin_redis_handle() {
        return $this->_redis_handle;
    }

    /**
     *
     * @param string $name
     * @param mixed $arguments
     */
    public function __call($name, $arguments) {
        return call_user_func_array(array($this->_redis_handle, $name), $arguments);
    }
}