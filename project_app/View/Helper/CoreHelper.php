<?php
App::uses('AppHelper','View/Helper');
class CoreHelper extends AppHelper
{
	/**
	 * 文字列から最初のimgタグを取得
	 * @param  [type]  $html [description]
	 * @param  integer $max  [description]
	 * @return [type]        [description]
	 */
	 static public function get_image_url( $html ,$max=1 )
    {	
		$url  = '';
		$pattern ='/<img .*?src="(.*?)".*?>/i';
		preg_match_all($pattern, $html, $matches);
		 if (isset($matches[1])){
			
			 $cnt = 0;
				foreach($matches[1] as $i=>$url) {
				if($cnt < $max){
				
				$url = preg_replace('/<img .*?src ?= ?[\'"]/', '', $url);
				$url = preg_replace('/[\'"]/', '', $url);
				$url = preg_replace('/\/original\//', '/xs/', $url);
				$url = preg_replace('/\/lg\//', '/xs/', $url);
				$url = preg_replace('/\/md\//', '/xs/', $url);
				break;
				}
			}
		}
		if($url=='')
				$url = '/assets/public/img/thumbnail.jpg';

		return $url;	
    }

   static function trim($str,$length=150)
   {
		$str = mb_strimwidth(strip_tags($str), 0,$length, '...');
		return $str;
   }

}