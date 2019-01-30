<?php

namespace App\Contracts;
# 属性翻译器
trait PropertyTranslater
{

	/**
	 * 获取翻译属性:向上合并父类属性
	 * @param $key string|null 需要获取的参数，如果不指定，则返回所有参数
	 * @param $callback sring 回调函数名，格式化属性
	 * @return array
	 * */
	public static function translation ($key=null, $callback=null)
	{
		$dat = [];
		$cls = static::class;
		while ($cls) {
			$dat = array_merge(property_exists($cls, __FUNCTION__)&&is_array($cls::${__FUNCTION__}) ? $cls::${__FUNCTION__} : [], $dat);
			$cls = get_parent_class($cls);
		}

		$dat = $key ? @$dat[$key] : $dat;
		return $callback ? call_user_func_array($callback, [$dat]) : $dat;
	}


	/**
	 * 解析翻译属性的编码
	 * @parem $key string 属性名
	 * @parem $val string 翻译结果
	 * */
	public static function translationBack ($key, $val)
	{
		return array_search($val, self::translation($key) ?: []);
	}



	static function format (array $dat)
	{

		if (count($dat)==count($dat, true)) {
			foreach ($dat as $k=>&$v) {
				$v = [
					'key' => $k,
					'val' => $v,
				];
			}
		} else {
			foreach ($dat as &$group) {
				$group = self::{__FUNCTION__}($group);
			}
		}

		return $dat;
	}



	/**
	 * 翻译属性
	 * @param $key string 需要翻译的参数名
	 * @return string|false
	 * */
	public function translateProperty ($key)
	{
		return is_string($key) ? @self::translation($key)[$this->$key] : false;

	}



	/**
	 * 基于$translation配置，转化翻译指定的或所有的属性
	 * @param $prop mixed string|array|null 指定需要翻译的属性，如果是string，多个属性用','分割；如果为空，则翻译所有属性
	 * @param $prf 返回属性名的前缀
	 * @param $ext 返回属性名的后缀
	 * @return 成功true；如果Model未指定translate属性名，则返回false。
	 * */
	public function translateProperties ($prop=null, $prf='_', $ext=''):bool
	{

		if ( $prop ) {
			$prop = is_array($prop) ? $prop : explode(',', $prop);
			$prop = array_intersect_assoc(array_flip($prop), static::translation());
		} else {
			$prop = array_keys(static::translation());
		}

		foreach ( $prop as $k ) {
			$this->{$prf.$k.$ext} = $this->translateProperty($k);
		}

		return true;

	}


}