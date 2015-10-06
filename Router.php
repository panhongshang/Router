<?php
	namespace Router;
	require 'CacheInterface.php';
	use \CacheInterface;
	class Router{
		
		public function simpleRoute(){
			$ServerArray = str_replace($_SERVER['SCRIPT_NAME'].'/','',$_SERVER['PHP_SELF']);
			$ServerArray = explode('/',$ServerArray);
			$ArrayLength = count($ServerArray);
			$controller = $ServerArray[0];
			$action = $ServerArray[1];
			$parmas = [];
			$count = 2;
			for($count = 2;$count < $ArrayLength;$count++){
				$parmas[] = $ServerArray[$count];
			}
			unset($ArrayLength,$count,$ServerArray);
			return ['controller'=>$controller,
					'action'=>$action,
					'parmas'=>$parmas
					];
		}
		
		public function make($MatchString,$link){
			if(is_string($link))return $this->analysisByString($MatchString,$link);
			if(is_object($link))return $this->analysistByFunction($MatchString,$link);
		}
		
		public function cacheCheck($MatchString,CacheInterface $cache){
			if(preg_match("#{$MatchString}#",$_SERVER['PHP_SELF']) === 1 ){
				$cache->cacheCheck();
			}
		}
		
		protected function analysisByString($MatchString,$link){
			if( preg_match("#{$MatchString}#",$_SERVER['PHP_SELF'],$match) === 1){
				$ServerString = explode('@',$link);
				$parmas = str_replace($_SERVER['SCRIPT_NAME'].$match[0].'/','',$_SERVER['PHP_SELF']);
				$parmas = explode('/',$parmas);
				$controller = $ServerString[0];
				$action = $ServerString[1];
				unset($ServerString,$match);
				return ['controller'=>$controller,
						'action'=>$action,
						'parmas'=>$parmas
						];
			}
		}
		
		protected function analysistByFunction($MatchString,$link){
			if( preg_match("#{$MatchString}#",$_SERVER['PHP_SELF'],$match) === 1){
				$link();
				$parmas = str_replace($_SERVER['SCRIPT_NAME'].$match[0].'/','',$_SERVER['PHP_SELF']);
				$parmas = explode('/',$parmas);
				unset($match);
				return $parmas;
			}
		}
	}
	var_dump($_SERVER);
	$route = new Router();
	print_r($route->make('/sg',function(){
		return 'hello';
	}));
	print_r($route->make('/seg/dfw','sdfweg@sgeg'));