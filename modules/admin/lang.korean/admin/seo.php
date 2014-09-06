<div id="seo-setting">

	<div class="page-header">
		<h4>SEO 설정 <small>( Technical Search Engine Optimization )</small></h4>
	</div>

	<div class="tab-content">

		<ul class="nav nav-pills" role="tablist">
			<li<?php if(!$_SESSION['sh_admin_seo']||$_SESSION['sh_admin_seo']=='robots'):?> class="active"<?php endif?>><a href="#robots" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','robots','','');">Robots.txt</a></li>
			<li<?php if($_SESSION['sh_admin_seo']=='rewrite'):?> class="active"<?php endif?>><a href="#rewrite" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','rewrite','','');">URL rewrite</a></li>
			<li<?php if($_SESSION['sh_admin_seo']=='sitemap'):?> class="active"<?php endif?>><a href="#sitemap" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','sitemap','','');">Sitemap.xml</a></li>
			<li<?php if($_SESSION['sh_admin_seo']=='errorpage'):?> class="active"<?php endif?>><a href="#error" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','errorpage','','');">Error Page</a></li>
			<li<?php if($_SESSION['sh_admin_seo']=='redirect'):?> class="active"<?php endif?>><a href="#301" role="tab" data-toggle="tab" onclick="sessionSetting('sh_admin_seo','redirect','','');">Redirect</a></li>
		</ul>
		<br>

		<div class="tab-pane<?php if(!$_SESSION['sh_admin_seo'] || $_SESSION['sh_admin_seo']=='robots'):?> active in<?php endif?>" id="robots">
			<form class="form-horizontal rb-form" role="form" name="sendForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="seo">
			<input type="hidden" name="act" value="robots">
				<div class="well">
					<p>
						robots.txt 파일은 웹 크롤러 소프트웨어(예: Googlebot)가 사이트의 특정 페이지를 크롤링하지 못하도록 하는 텍스트 파일입니다.<br>
						이 파일은 기본적으로 Allow와 Disallow와 같은 명령어 목록으로 구성되어 웹 크롤러가 검색할 수 있는 URL과 검색할 수 없는 URL을 지정합니다.
						<a href="https://support.google.com/webmasters/answer/6062608?hl=ko" target="_blank">더보기</a>
					</p>
				</div>
				<div class="rb-codeview">			
<?php if(is_file($_SERVER['DOCUMENT_ROOT'].'/robots.txt')):?>
<textarea name="robotstxt" class="form-control" rows="15">
<?php readfile($_SERVER['DOCUMENT_ROOT'].'/robots.txt')?>
</textarea>
<?php else:?>
<textarea name="robotstxt" class="form-control" rows="15" onclick="this.value=getId('robotstxt').innerHTML;">
robots.txt 파일은 서버의 홈디렉토리 안에 위치해야 합니다.
여기를 클릭하면 기본값을 불러옵니다.
킴스큐 설치시 기본폴더명인 rb 를 다른이름으로 변경했을 경우 변경된 이름으로 수정해 주세요.
rb 폴더를 사용하지 않고 설치하셨을 경우 경로중 /rb 를 제거해 주세요.
</textarea>
<div id="robotstxt" class="hidden"><?php readfile('./robots.txt')?></div>
<?php endif?>
					<div class="rb-meta">
						<?php if(is_file($_SERVER['DOCUMENT_ROOT'].'/robots.txt')):?>
						파일위치 : /robots.txt
						<code><?php echo getSizeFormat(filesize($_SERVER['DOCUMENT_ROOT'].'/robots.txt'),2)?></code>
						<?php endif?>
						<span class="pull-right">파일을 편집한 후 저장 버튼을 클릭하면 실시간으로 사용자 페이지에 적용됩니다.</span>
					</div>
				</div>

				<div class="rb-submit">
					<?php if(is_file($_SERVER['DOCUMENT_ROOT'].'/robots.txt')):?>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=seo&amp;act=robots_delete" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?     ');" class="btn btn-default">삭제하기</a>
					<?php endif?>
					<button type="submit" class="btn btn-primary">저장하기</button>
				</div>
			</form>
		</div>

		<div class="tab-pane<?php if($_SESSION['sh_admin_seo']=='rewrite'):?> active in<?php endif?>" id="rewrite">

			<div class="well">
				<p>
					<strong>URL Rewrite 설정</strong>
					간편 URL(영어: clean URL, fancy URL)은 질의어 없이, 경로만 가진 간단한 구조의 URL을 말한다. 
					사용자 친화적 URL(영어: user-friendly URLs), 검색엔진 친화적 URL(영어: search engine friendly url) 또는 간단히 친화적 URL이라고도 한다. 깔끔하지 않은 URL에 비해 기억하기 쉽고, 입력하기 쉽다는 장점이 있다.
					<a href="http://ko.wikipedia.org/wiki/%EA%B0%84%ED%8E%B8_URL" target="_blank">더보기</a>
				</p>

				<p>
					파일을 직접 추가하거나 수정하시려면 FTP 클라이언트로 다운로드 받아 백업받은 후 로컬에서 편집 후 업로드 적용할 것을 권장합니다.
				</p>		
			</div>

			<div class="rb-codeview">
<pre class="prettyprint linenums">
<?php readfile('./.htaccess')?>
</pre>
				<div class="rb-meta">
					파일위치 : <?php echo $g['s']?>/.htaccess
					<code><?php echo getSizeFormat(filesize('./.htaccess'),2)?></code>
					<span class="pull-right">웹을 통한 편집은 제공하지 않습니다.</span>	
				</div>
			</div>
		</div>

		<div class="tab-pane<?php if($_SESSION['sh_admin_seo']=='sitemap'):?> active in<?php endif?>" id="sitemap">
			<form class="form-horizontal rb-form" role="form" name="sendForm" action="<?php echo $g['s']?>/" method="post" onsubmit="return saveCheck(this);">
			<input type="hidden" name="r" value="<?php echo $r?>">
			<input type="hidden" name="m" value="<?php echo $module?>">
			<input type="hidden" name="a" value="seo">
			<input type="hidden" name="act" value="sitemap_save">
			<div class="well">
				<p>
					Sitemap을 사용하면 검색엔진(Google)이 발견하지 못했을 수도 있는 사이트의 페이지 정보를 검색엔진에 알릴 수 있습니다.
					간단히 말해서 XML Sitemap은 웹사이트에 있는 페이지의 목록입니다.
					Sitemap을 만들어 제출하면 검색엔진의 일반적인 크롤링 과정에서 발견되지 않는 URL을 비롯하여 사이트의 모든 페이지 정보를 검색엔진에 알릴 수 있습니다.
				</p>
				<p>본 파일은 <a href="http://www.sitemaps.org/ko/" target="_blank">sitemaps.org</a> 사이트에 명시된 바와 같이 Sitemap Protocol 0.9를 따릅니다.<br>
				따라서 Sitemap Protocol 0.9를 사용하여 만든 Google용 Sitemap은 sitemaps.org의 기준을 채택한 다른 검색엔진과 호환됩니다.<br>
				</p>
				<p>
				사이트맵을 직접 추가하거나 수정하시려면 <a href="https://support.google.com/webmasters/bin/answer.py?hl=ko&amp;answer=183668" target="_blank">사이트맵을 만드는 방법</a>에 맞게 편집해 주세요.<br>
				파일용량이 클 경우 다운로드 받아 PC에서 편집할 것을 권장합니다.
				</p>
			</div>
			<div class="rb-codeview">
<?php if(is_file('./sitemap.xml')):?>
<textarea name="configdata">
<?php readfile('./sitemap.xml')?>
</textarea>
<?php else:?>
<textarea name="configdata">
사이트맵이 존재하지 않습니다.
새로 만들기 버튼을 클릭하여 사이트맵을 만들어 주세요.
메뉴를 새로 생성한 경우에 새로 만들기 버튼을 클릭하면 가장 최신의 사이트맵 상태를 유지할 수 있습니다.
</textarea>
<?php endif?>
					<div class="rb-meta">
						<?php if(is_file('./sitemap.xml')):?>
						파일위치 : <?php echo $g['s']?>/sitemap.xml
						<code><?php echo getSizeFormat(filesize('./sitemap.xml'),2)?></code>
						<?php endif?>
						<span class="pull-right">파일을 편집한 후 저장 버튼을 클릭하면 실시간으로 사용자 페이지에 적용됩니다</span>	
					</div>
				</div>
				<div class="rb-submit">
					<button type="button" class="btn btn-default" onclick="sitemap_make(this);">새로 만들기</button>
					<?php if(is_file('./sitemap.xml')):?>
					<a href="<?php echo $g['s']?>/?r=<?php echo $r?>&amp;m=<?php echo $module?>&amp;a=seo&amp;act=sitemap_delete" onclick="return hrefCheck(this,true,'정말로 삭제하시겠습니까?     ');" class="btn btn-default">삭제하기</a>
					<?php endif?>
					<button type="submit" class="btn btn-primary">저장하기</button>
				</div>
				<div class="well">
					<ul>
						<li><a href="http://www.sitemaps.org/ko/" target="_blank">Sitemap 프로토콜</a>을 기반으로 하여 Sitemap을 만들거나 텍스트 파일 또는 RSS/Atom 피드를 Sitemap으로 제출할 수 있습니다. </li>
						<li><a href="https://support.google.com/webmasters/bin/answer.py?answer=183668" target="_blank">Sitemap을 만드는 방법</a> </li>
						<li><a href="https://www.google.co.kr/webmasters/" target="_blank">Google 웹마스터 도구</a></li>
					</ul>
				</div>
			</form>
		</div>

		<div class="tab-pane<?php if($_SESSION['sh_admin_seo']=='errorpage'):?> active in<?php endif?>" id="error">
			<div class="well">
				<ul>
					<li>
						<a href="http://www.htaccessbasics.com/404-custom-error-page/" target="_blank">
						How to Redirect your 404 error to a Custom Page
						</a>
					</li>
					<li>
						<a href="http://stackoverflow.com/questions/19962787/rewrite-url-after-redirecting-404-error-htaccess" target="_blank">
							Rewrite URL after redirecting 404 error htaccess
						</a>
					</li>
					<li><a href="http://www.etnews.com/201312200346" target="_blank">네이버 검색에 잘 걸리는 웹페이지 만들기 비법은?</a></li>
					<li><a href="http://search-marketing.co.kr/50043928552" target="_blank">검색엔진최적화 - 404 에러페이지 처리</a></li>
					<li><a href="http://moz.com/blog/are-404-pages-always-bad-for-seo" target="_blank">Are 404 Pages Always Bad for SEO?</a></li>
				</ul>
			</div>
			<hr>
			<ol>
				<li>기본 페이지 목록에 404 Error 페이지 추가 필요 </li>
				<li>.htaccess에 <code>ErrorDocument 404 /errormessages/404.php</code> 형식으로 404페이지 지정 필요.</li>
			</ol>
		</div>

		<div class="tab-pane<?php if($_SESSION['sh_admin_seo']=='redirect'):?> active in<?php endif?>" id="301">
			<div class="well">
				<ul>
					<li>
						<a href="http://blog.iolate.kr/162" target="_blank">
						Permanently Redirect (301)
						</a>
					</li>
					<li><a href="http://www.etnews.com/201312200346" target="_blank">사이트나 페이지 변경 시 301 redirect를 사용할 것</a></li>
					<li><a href="http://www.htaccessbasics.com/how-to-setup-a-301-redirect/" target="_blank">How to setup a 301 Redirect</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>



<script src="http://google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>
<script>
(function(jQuery){
  jQuery( document ).ready( function() {
    prettyPrint();
  } );
}(jQuery))
function sitemap_make(obj)
{
	if (confirm('정말로 사이트맵을 새로 만드시겠습니까?    '))
	{
		getIframeForAction(obj.form);
		obj.form.act.value = 'sitemap_make';
		obj.form.submit();
	}
}
function saveCheck(f)
{
	getIframeForAction(f);
	return confirm('정말로 실행하시겠습니까?    ');
}
</script>
