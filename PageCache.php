<?php
	namespace PageCache;
	require('CacheInterface.php');
	class PageCache implements \CacheInterface{
		// 目前的时间
		protected $now;
		// 缓存存在的时间
		public $cacheTime;
		// 缓存过期的时间
		protected $overdue;
		// 缓存文件地址
		public $cacheDir;
		
		protected $url;
		
		protected $fileName;
		
		public function __construct(){
			$this->cacheDir = '';
			$this->now = $_SERVER['REQUEST_TIME'];
			$this->overdue = 0;
			$this->cacheTime = 0;
			$this->url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.$_SERVER['REQUEST_URI'];
			$this->fileName = pathinfo($_SERVER['PHP_SELF'],PATHINFO_FILENAME);
		}
		
		public function cacheCheck(){
			if(!file_exists($this->cacheDir.'/'.$this->fileName.'.html')){
				return false;
			}
			$this->overdue = $this->now - filemtime($this->cacheDir.'/'.$this->fileName.'.html');
			if($this->overdue > $this->cacheTime){
				return false;
			}
			return true;
		}
		/* 
			将页面写入缓存文件中,生成静态的html文件
			cacheData string类型 为缓存页面内容
			$cacheDir string类型 为缓存目录,假设$cacheDir 为空,则在同级目录中新建名为 cache的目录
		*/
		public function cacheWirte($cacheData = '',$cacheDir = ''){
			if(is_string($cacheDir) && $cacheDir != ''){
				$this->cacheDir = $cacheDir;
			}else{
				$this->cacheDir = 'cache';
			}
			if(!file_exists($this->cacheDir)){
				mkdir($this->cacheDir,0777);
			}
			$fp = fopen($this->cacheDir.'/'.$this->fileName.'.html','w+');
			fwrite($fp,$cacheData);
			fclose($fp);
			return true;
		}
		
		public function cacheRemove($cacheName = ''){
			return (is_string($cacheName) && $cacheName != '')?unlink($this->cacheDir.'/'.$cacheName.'.html'):unlink($this->cacheDir.'/'.$this->fileName.'.html');
		}
		
		public function cacheLoad($cacheTime = 10){
			if($cacheTime <= 0){
				return false;
			}
			$this->cacheTime = $cacheTime * 60;
			$this->overdue = $this->now - filemtime($this->cacheDir.'/'.$this->fileName.'.html');
			if( $this->overdue > $this->cacheTime ){
				return false;
			}
			return require($this->cacheDir.'/'.$this->fileName.'.html');
		}
	}
	// var_dump($_SERVER);
	$pageCache = new PageCache();
	$pageCache->cacheDir = 'cache';
	$pageCache->cacheWirte('hello');
	$pageCache->cacheLoad();
	var_dump($pageCache->cacheCheck());
	// var_dump($pageCache->cacheRemove());