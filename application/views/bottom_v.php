

		</div>

		<div class="navigation">

			<h2>CodeIgniter정보</h2>
			<ul>
				<li><a href="/news/lists/page/1">CI 뉴스</a></li>
				<li><a href="/user_guide/" target="_blank">CI 한글매뉴얼</a></li>
				<li><a href="#">CI Wiki</a></li>
			</ul>

			<h2>포럼</h2>
			<ul>
				<li><a href="/notice/lists/page/1">공지사항</a></li>
				<li><a href="/free/lists/page/1">자유게시판</a></li>
				<li><a href="/tip/lists/page/1">TIP게시판</a></li>
				<li><a href="/lecture/lists/page/1">강좌게시판</a></li>
				<li><a href="/qna/lists/page/1">CI 묻고답하기</a></li>
			</ul>

			<h2>자료실</h2>
			<ul>
				<li><a href="/source/lists/page/1">CI 코드</a></li>
				<li><a href="/file/lists/page/1">일반 자료</a></li>
			</ul>

			<? if($this->session->userdata('auth_code') >= '7') {?>
			<h2>개발자 전용</h2>
			<ul>
				<li><a href="/ci/lists/page/1">포럼개발자</a></li>
				<li><a href="http://codeigniter-kr.org/trac" target="_blank">TRAC바로가기</a></li>
				<? if($this->session->userdata('auth_code') >= '15') {?>
				<li><a href="/su/lists/page/1">운영자게시판</a></li>
				<? } ?>
			</ul>
			<? } ?>
			<div id="ad">
				<p>ICMS Banner</p>
			</div>

		</div>

		<div class="clearer">&nbsp;</div>

	</div>

	<div class="footer">

		<span class="left">
			&copy; 2009 <a href="/">CodeIgniter 한글사용자포럼</a>
		</span>

		<span class="right">Sponsor by <a href="http://www.icms.kr/" target="_new">ICMS Inc.<a> &nbsp;&nbsp;<a href="http://templates.arcsin.se/" target="_new">Website template</a> by <a href="http://arcsin.se/" target="_new">Arcsin</a></span>

		<div class="clearer"></div>

	</div>

</div>

</div>

<!--구글 analytics-->
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-2977920-4");
pageTracker._trackPageview();
} catch(err) {}</script>
<!--구글 analytics-->
</body>

</html>