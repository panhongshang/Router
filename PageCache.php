<?php
	namespace PageCache;
	require('CacheInterface.php');
	class PageCache implements \CacheInterface{
		// 目前的时间
		protected $now;
		// 缓存存在的时间
		protected $cacheTime;
		// 缓存过期的时间
		protected $overdue;
		// 缓存文件地址
		protected $cacheDir;
		
		protected $url;
		
		public function __construct(){
			$this->cacheDir = '';
			$this->now = time();
			$this->overdue = 0;
			$this->cacheTime = 0;
			$this->$url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HOST_NAME'].'/'.$_SERVER['REQUEST_URI'];
		}
		
		public function cacheCheck(){
			
		}
		/* 
			将页面写入缓存文件中,生成静态的html文件
			cacheData string类型 为缓存页面内容
			$cacheTime int类型 为缓存分钟数 假设$cacheTime 为小等于0,则返回false
			$cacheDir string类型 为缓存目录,假设$cacheDir 为空,则在同级目录中新建名为 cache的目录
		*/
		public function cacheWirte($cacheData = '',$cacheTime = 10,$cacheDir = ''){
			if($cacheTime <= 0){
				return false;
			}
			if(is_string($cacheDir) && $cacheDir != ''){
				$this->cacheDir = $cacheDir;
			}else{
				$this->cacheDir = 'cache';
			}
			if(!file_exists($cacheDir)){
				mkdir($cacheDir,0777);
			}
			$fp = fopen($this->url,0777);
			fwrite($fp,$cacheData);
			fclose($fp);
		}
		
		public function cacheRemove($cacheName){
			
		}
		
		public function cacheLoad(){
			
		}
	}