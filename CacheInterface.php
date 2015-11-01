<?php
	interface CacheInterface{
		public function cacheCheck();
		
		public function cacheWirte($cacheData,$cacheDir);
		
		public function cacheRemove($cacheName);
	}