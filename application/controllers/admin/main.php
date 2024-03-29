<?php

class Main extends Controller {

	function Main()
	{


		parent::Controller();
		//$this->load->library('pagination');

		$this->load->helper('html');
		$this->load->helper('text');
		$this->load->helper('date');

		$this->output->enable_profiler(true);

		$this->load->model('admin_m');

		if ($this->session->userdata('userid')) {
			if ($this->session->userdata('auth_code') < '15') {
				echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
				echo "<script>";
				echo "	alert('운영자 페이지입니다.');";
				echo "	location=\"" . SV1_DIR . "\"";
				echo "</script>";
			}
		} else {
			/*
			* 로그인 후 페이지 리다이렉트 관련 수정
			* modified by kwangmyung, choi at 2009.06.30
			*/
			//로그인후 리턴페이지
			//$rpath = "http://".$this->input->server('HTTP_HOST').$this->input->server('PHP_SELF');
			$rpath = str_replace("index.php/", "", $this->input->server('PHP_SELF'));
			$rpath_encode = base64_encode($rpath);
			//echo $rpath;
			echo "<script>";
			echo "	location=\"" . SV1_DIR . "/auth/login/" . $rpath_encode . "\"";
			echo "</script>";

		}

	}
	function index1()
	{
		$this->load->view('admin/header_v');

		$this->load->view('admin/footer_v');
	}

	function master()  //운영자 관리
	{
		$this->load->library('pagination');
		$config['page_query_string']=FALSE;
		$this->load->library('validation');

		$rules['search_word'] = "required";
		$this->validation->set_rules($rules);
		$fields['search_word']	= '검색어';
		$this->validation->set_fields($fields);

		$config['uri_segment'] = 4;
		$data['perPage']=$config['per_page']='15'; //페이지당 리스트 노출갯수
		$config['base_url']=site_url('admin/members/master/'); //페이징처리 링크주소
		$page=$offset = $this->uri->segment(4, 0);
		if( $this->input->post('search_word') ){
			$data['mlist'] = $this->admin_m->master_list('master', $this->input->post('search_word'), $offset, $config['per_page']); //운영자 리스트
			$data['getTotalData']=$config['total_rows']=$this->admin_m->getTotalData('master', $this->input->post('search_word'), $offset, $config['per_page']);
		} else {
			$data['mlist'] = $this->admin_m->master_list('master', '', $offset, $config['per_page']); //운영자 리스트
			$data['getTotalData']=$config['total_rows']=$this->admin_m->getTotalData('master', 'all_keyword', '', '');
		}

		$this->pagination->initialize($config);
		$data['pagenav'] = $this->pagination->create_links();

		$this->load->view('admin/header_v');
		$this->load->view('admin/member/master_v', $data);
		$this->load->view('admin/footer_v');
	}

	function index()  //회원 관리
	{
		$this->load->library('pagination');
		$config['page_query_string']=FALSE;
		$this->load->library('validation');

		$rules['search_word'] = "required";
		$this->validation->set_rules($rules);
		$fields['search_word']	= '검색어';
		$this->validation->set_fields($fields);

		$config['uri_segment'] = 4;
		$data['perPage']=$config['per_page']='15'; //페이지당 리스트 노출갯수
		$config['base_url']=site_url('admin/main/index/'); //페이징처리 링크주소
		$page=$offset = $this->uri->segment(4, 0);
		if( $this->input->post('search_word') ){
			$data['mlist'] = $this->admin_m->master_list('all', $this->input->post('search_word'), $offset, $config['per_page']); //운영자 리스트
			$data['getTotalData']=$config['total_rows']=$this->admin_m->getTotalData('all', $this->input->post('search_word'), $offset, $config['per_page']);
		} else {
			$data['mlist'] = $this->admin_m->master_list('all', '', $offset, $config['per_page']); //운영자 리스트
			$data['getTotalData']=$config['total_rows']=$this->admin_m->getTotalData('all', 'all_keyword', '', '');
		}

		$this->pagination->initialize($config);
		$data['pagenav'] = $this->pagination->create_links();

		$this->load->view('top_v');
		$this->load->view('admin/topnav_v');
		$this->load->view('admin/member/member_v', $data);
		$this->load->view('bottom_v');
	}

	function master_add()  //운영자 추가
	{
		$this->load->library('form_validation');
		//폼검증 규칙 설정
		$config = array(
		   array(
				 'field'   => 'user_id',
				 'label'   => '아이디',
				 'rules'   => 'callback_userid_check'
			  ),
		   array(
				 'field'   => 'site_domain',
				 'label'   => '도메인',
				 'rules'   => 'required'
			  ),
		   array(
				 'field'   => 'user_nm',
				 'label'   => '이름',
				 'rules'   => 'required'
			  ),
		   array(
				 'field'   => 'user_pw',
				 'label'   => '패스워드',
				 'rules'   => 'required|min_length[4]'
			  ),
		   array(
				 'field'   => 'user_nickname',
				 'label'   => '닉네임',
				 'rules'   => 'callback_nick_check'
			  )
		);

		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() == FALSE)	{
			$this->load->view('admin/member/master_add_v');
		} else {
			if( $this->input->post('status_mode') == 'insert' ){
				$this->admin_m->master_add($_POST); //운영자 추가 함수
				//입력이 끝나면 히든으로 받은 리퍼러 주소로 리다이렉팅
				?>
				<script type="text/javascript"  src="<?=JS_DIR?>/jquery-1.3.2.min.js"></script>
				<script type="text/javascript"  src="<?=JS_DIR?>/jquery.framedialog.js"></script>
				<script>
					//FrameDialog 닫기
					$(document).ready(function() { jQuery.FrameDialog.closeDialog(); });
					alert('입력되었습니다.')
					document.parent.reload();
				</script>
				<?
			} elseif( $this->input->post('status_mode') == 'delete' ) {
				//삭제후 리퍼러 주소로..
			}
		}

	}

	function userid_check($id)  //아이디 체크 콜백함수
	{
		if (!$id) {
			$this->form_validation->set_message('userid_check', '아이디를 입력하세요.');
			return FALSE;
			exit;
		}
		//영어인지 체크
		if (strlen($id) < 4 or strlen($id) > 12) {
			$this->form_validation->set_message('userid_check', '아이디는 4자 이상, 12자 이하로 입력하세요.');
			return FALSE;
			exit;
		}
		$str = $this->admin_m->id_check($id);
		$noids = array('abroad','action','admin','administrator','africa','agency','agent','america','angel','ani','arkadio','art','asia','asiana','auction','auto','baby','backup','bank','baseball','bell','biz','blog','book','bookmark','brand','business','cafe','card','chat','city','collaboration','comic','community','consulting','contents','continent','codeigniter','cook','ceo','cto','cfo','corea','corp','creation','customer','cyber','cyworld','daewoo','daum','diary','directory','drama','dreamwiz','east','economy','emigrant','english','entertainment','europe','exchange','file','finance','flash','food','franchise','free','fuck','gallary','game','gay','global','gmarket','golf','google','group','gseshop','guest','hanatour','hangul','hanja','happy','health','help','hibori','home','homepage','homework','hotel','hyundai','imtel','inbound','index','info','intel','iriver','item','job','keyword','khan','kiamoters','king','koderi','koglian','koglo','korean','koreanair','kralliance','krgame','krnews','krtv','land','lesbian','life','living','local','login','logout','lorita','lotte','lotto','love','mail','main','mall','manager','maps','market','marketing','master','mbc','media','message','microsoft','middleeast','miz','model','modetour','movie','music','myhome','mypage','nate','nateon','nation','naver','netpia','network','news','newsnp','newspaper','north','nude','okmedia','oktour','on','oninfo','onket','open','opencafe','openmarket','outbound','paran','people','phone','photo','plan','planning','play','policy','poll','porno','pornosex','portal','prince','princess','privacy','process','qeen','radio','real','rent','resume','root','samsung','samsungcard','search','sex','sexporno','shinsegae','shop','shopping','south','southpacific','sports','star','stock','study','sysop','time','toolbar','toon','tour','trade','traffic','travel','vod','weather','webmaster','website','west','world','xxx','xxxx','xxxxxx');
		if ($str > 0)
		{
			$this->form_validation->set_message('userid_check', '중복된 아이디입니다.');
			return FALSE;
		} else if (in_array($id, $noids) )
		{
			$this->form_validation->set_message('userid_check', '사용할 수 없는 아이디입니다.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function nick_check($ju) //닉네임 사용 체크 콜백
	{
		if (!$ju) {
			$this->form_validation->set_message('nick_check', '닉네임을 입력하세요.');
			return FALSE;
			exit;
		}
		//echo strlen($ju);
		if (strlen($ju) < 6 or strlen($ju) > 30) {
			$this->form_validation->set_message('nick_check', '닉네임은 2자이상 10자이하로 입력하세요.');
			return FALSE;
			exit;
		}
		$str = $this->admin_m->nick_check($ju);

		if ($str > 0)
		{
			$this->form_validation->set_message('nick_check', '중복된 닉네임입니다.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	function detail_view()  //사용자 상세정보 보기
	{
		$data['user_details'] = $this->admin_m->detail_view($this->uri->segment('4'));
		var_dump($data['user_details']);
		$this->load->view('admin/member/view_v', $data);
	}

}

/* End of file member.php */
/* Location:  /application/controllers/admin/member.php */
?>