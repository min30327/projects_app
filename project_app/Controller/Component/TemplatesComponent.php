<?php 
class TemplatesComponent extends Component{
	
	/**
	 * [forgot_password description]
	 * @param  [type] $url
	 * @return [type]
	 */
	public function forgot_password($url){
		$body = '';
		$body = '<div style="width:70%;height:200px;background:#FFF;margin:40px auto;" class="box">';
		$body .= '<h1 style="font-size:24px;margin-bottom:20px">パスワード再設定</h1>';
		$body .= '<p>下記のURLよりアクセスしパスワードの再設定を行ってください。</p>';
		$body .= '<p><a href="'.$url.'" style="text-decoration: none;color: #fff!important;background-color: #348eda;padding: 10px 20px;font-weight: bold;margin: 20px 10px 20px 0;text-align: center;cursor: pointer;display: inline-block;border-radius: 25px;">パスワード再設定はこちら</a></p>';
		$body .=  '</div>';
		return $body;					
	}
	/**
	 * [change_password description]
	 * @param  [type] $url
	 * @return [type]
	 */
	public function change_password($url){
		$body  = '';
		$body  = '<div style="width:70%;height:200px;background:#FFF;margin:40px auto;" class="box">';
		$body .= '<h1 style="font-size:24px;margin-bottom:20px">パスワード再設定</h1>';
		$body .= '<p>パスワードを変更しました。<br>下記のリンクよりログインしてください。</p>';
		$body .= '<p><a href="'.$url.'" style="text-decoration: none;color: #fff!important;background-color: #348eda;padding: 10px 20px;font-weight: bold;margin: 20px 10px 20px 0;text-align: center;cursor: pointer;display: inline-block;border-radius: 25px;">ログイン</a></p>';
		$body .=  '</div>';
		return $body;					
	}
}