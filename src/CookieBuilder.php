<?php

namespace letnn;

class CookieBuilder
{

    protected $config = [
        // cookie 保存时间
        'expire'   => 0,
        // cookie 保存路径
        'path'     => '/',
        // cookie 有效域名
        'domain'   => '',
        //  cookie 启用安全传输
        'secure'   => true,
        //  cookie 安全传输密钥
        'secure_key' => 'LangShen',
        //  cookie 前缀
        'prefix' => 'letphp##'
    ];

    protected $cookie = [];
    
    public function config($config)
    {
		$this->cookie = $_COOKIE;
        $this->config  = array_merge($this->config, array_change_key_case($config));
    }

    /**
	 * 设置
	 * @param string $name   名称
	 * @param mixed  $value  值
	 * @param int    $expire 过期时间
	 * @param string $path   有效路径
	 * @param string $domain 有效域名
	 */
    public function set($name, $value, $expire = 0, $path = "", $domain = "")
    {
		$name = $this->config["prefix"] . $name;
		$value = $this->config["secure"] == true ? Crypt::Encode($value, $this->config["secure_key"]) : $value;
		$this->cookie[$name] = $value;
		$expire = $expire ? time() + $expire : $this->config["expire"];
        $path = $path ? $path : $this->config["path"];
        $domain = $domain ? $domain : $this->config["domain"];
		if (PHP_SAPI != "cli") setcookie($name, $value, $expire, $path, $domain);
        return true;
	}

    /**
	 * 检测
	 * @param string $name 名称
	 * @return bool
	 */
    public function has($name)
    {
		return isset($this->cookie[$this->config["prefix"] . $name]);
	}

    /**
	 * 获取
	 * @param string $name 名称
	 * @param string default 默认值
	 * @return mixed
	 */
	public function get($name, $default = "")
    {
		if ($this->has($name)) {
			return $this->config["secure_key"] == true ? Crypt::Decode($this->cookie[$this->config["prefix"] . $name]) : $this->cookie[$this->config["prefix"] . $name];
		}
		return isset($this->cookie[$name])? $this->cookie[$name] : $default;
	}

    /**
	 * 获取所有
	 * @return array
	 */
	public function all()
    {
		$data = [];
		foreach ($this->cookie as $name => $value) {
			$data[$name] = $this->get($name);
		}
		return $data;
	}

    /**
	 * 删除
	 * @param string $name 名称
	 * @return bool
	 */
	public function delete($name)
    {
		if (isset($this->cookie[$this->config["prefix"] . $name])) unset($this->cookie[$this->config["prefix"] . $name]);
		if (PHP_SAPI != "cli") setcookie($this->config["prefix"] . $name, null, 1);
		return true;
	}

    /**
	 * 删除所有
	 * @return bool
	 */
	public function flush()
    {
		if (PHP_SAPI != "cli") {
			foreach ($this->cookie as $key => $value) {
				setcookie($key, null, 1, "/");
			}
		}
        $this->cookie = [];
		return true;
	}

}

?>