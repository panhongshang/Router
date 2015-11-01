<?php
	interface CacheInterface{
		public function cacheCheck();
		
		public function cacheWirte($cacheData,$cacheTime,$cacheDir);
		
		public function cacheRemove($cacheName);
	}