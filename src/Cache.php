<?php

declare(strict_types = 1);
namespace Xutengx\Contracts;

interface Cache {

	/**
	 * 读取缓存
	 * @param string $key 键
	 * @return mixed|null
	 */
	public function get(string $key);

	/**
	 * 设置缓存
	 * @param string $key 键
	 * @param mixed $value 值
	 * @param int $expire 缓存有效时间 , -1表示无过期时间
	 * @return bool
	 */
	public function set(string $key, $value, int $expire): bool;

	/**
	 * 设置缓存
	 * 仅在不存在时设置缓存 set if not exists
	 * 且不会过期
	 * @param string $key 键
	 * @param mixed $value 值
	 * @return bool
	 */
	public function setnx(string $key, $value): bool;

	/**
	 * 删除单一缓存
	 * @param string $key 键
	 * @return bool
	 */
	public function rm(string $key): bool;

	/**
	 * 执行某个方法并缓存, 优先读取缓存 (并非依赖注入)
	 * @param string|object $obj 执行对象
	 * @param string $function 执行方法
	 * @param int $expire 缓存过期时间
	 * @param mixed ...$params 非限定参数
	 * @return mixed
	 */
	public function call($obj, string $function, int $expire = null, ...$params);

	/**
	 * 获取&存储
	 * 如果键不存在时,则依据上下文生成自动键
	 * 如果请求的键不存在时给它存储一个默认值
	 * @param mixed ...$params
	 * @return mixed
	 */
	public function remember(...$params);

	/**
	 * 删除call方法的缓存
	 * @param string|object $obj
	 * @param string $func
	 * @param mixed ...$params
	 * @return bool
	 */
	public function unsetCall($obj, string $func = '', ...$params): bool;

	/**
	 * 清除缓存并不管什么缓存键前缀，而是从缓存系统中移除所有数据，所以在使用这个方法时如果其他应用与本应用有共享缓存时需要格外注意
	 * @param string $key
	 * @return bool
	 */
	public function clear(string $key): bool;

	/**
	 * 得到一个key的剩余有效时间
	 * @param string $key
	 * @return int 0表示过期, -1表示无过期时间, -2表示未找到key
	 */
	public function ttl(string $key): int;

	/**
	 * 自增 (原子性)
	 * @param string $key
	 * @param int $step
	 * @return int 自增后的值
	 */
	public function increment(string $key, int $step = 1): int;

	/**
	 * 自减 (原子性)
	 * @param string $key
	 * @param int $step
	 * @return int 自减后的值
	 */
	public function decrement(string $key, int $step = 1): int;

	/**
	 * 获取当前驱动的类型
	 * @return string
	 */
	public function getDriverName(): string;

	/**
	 * 执行驱动中的一个方法
	 * @param string $fun
	 * @param array $par
	 * @return mixed
	 */
	public function __call(string $fun, array $par = []);
}
