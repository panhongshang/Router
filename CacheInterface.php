<?php
	interface CacheInterface{
		public function cacheCheck();
		
		public function cacheWirte($cacheData);
		
		public function cacheRemove($cacheName);
	}