<?php
/**
 * KBoard 템플릿 페이지 설정
 * @link www.cosmosfarm.com
 * @copyright Copyright 2013 Cosmosfarm. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html
 */
class KBTemplate {
	
	/**
	 * 템플릿 페이지를 요청한다.
	 */
	public function templateSwitch(){
		$kboard_id = isset($_GET['kboard_id'])?intval($_GET['kboard_id']):'';
		if($kboard_id) $this->board($kboard_id);
	}
	
	/**
	 * 게시판 화면을 출력한다.
	 * @param int $board_id
	 */
	public function board($board_id){
		global $wpdb;
		$meta = new KBoardMeta($board_id);
		if($meta->use_direct_url || isset($_SESSION['kboard_board_id'])){
			include_once KBOARD_DIR_PATH . '/template/board.php';
			exit;
		}
	}
	
	/**
	 * 코스모스팜 소셜댓글 출력한다.
	 * @param KBoardMeta $meta
	 * @return string
	 */
	public function comments_plugin($meta){
		ob_start();
		$url = new KBUrl();
		$template = $this;
		include KBOARD_DIR_PATH . '/template/comments_plugin.php';
		return ob_get_clean();
	}
	
	/**
	 * 코스모스팜 소셜댓글의 회원연동 API 토큰을 반환한다.
	 * @return string
	 */
	public function get_comments_access_token(){
		if(defined('COSMOSFARM_COMMENTS_VERSION')){
			$comments = new Cosmosfarm_Comments_Core();
			return $comments->get_access_token();
		}
		else{
			return '';
		}
	}
}
?>