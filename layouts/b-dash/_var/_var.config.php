<?php
/* 여기에 이 레이아웃에서 사용할 변수들을 정의합니다. 
   변수 작성법은 매뉴얼을 참고하세요.
*/
$d['layout']['show'] = true;

$d['layout']['dom'] = array(
	/* 테마패널 */
	'theme' => array(
		'Theme', /* 패널 타이틀 */
		'현재 사이트에 적용중인 레이아웃의 테마를 설정합니다.', /* 패널설명 */
		array(
			array('title_hidden','hidden','숨김필드','숨김값'), /* 설정값 (필드네임,필드속성,필드타이틀,필드기본값) */
			array('title_input','input','텍스트',''),
			array('title_select','select','셀렉트','default,kimsq,simple'),
		),
	),


	/* 프론트패널 */
	'front' => array(
		'Front',
		'프론트에 출력할 콘텐츠를 설정합니다.',
		array(
			array('title_radio','radio','라디오','동해물과,백두산이,마르고'),
			array('title_checkbox','checkbox','체크박스','동해물과,백두산이,마르고'),
		),
	),


	'header' => array(
		'Header',
		'가나다라 마바사',
		array(
			array('title_textarea','textarea','텍스트에어리어','4'),
		),
	),


	'title' => array(
		'Site Title',
		'',
		array(
			array('title_select','select','타이틀 형식','텍스트,이미지'),
			array('title_input','input','텍스트 타이틀',''),
			array('title_file','file','이미지 타이틀',''),
		),
	),


	'widget' => array(
		'Widget',
		'',
		array(

		),
	),


	'design' => array(
		'Custom Design',
		'',
		array(

		),
	),


	'help' => array(
		'도움말',
		'Your blog name and description are very important. The title is used to name the browser window, and search engines display them on their search <b>"re &quot; sults</b>.',
		array(

		),
	),
);
?>