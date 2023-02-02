<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">', 0);
?>

<section id="bo_w">
    <h2 id="container_title"><?php echo $g5['title'] ?></h2>

    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="wr_subject" value=".">
	
	<!-- 스팸방지 추가 form [start] // form 안에 넣어주세요. -->
	<?php
	@include_once($board_skin_path."/spam_chk.lib.php");
	?>
	<input type="hidden" id="real_typing" name="real_typing" value="">

	<script>
	$(document).on('keydown', function (e) {
		var key = e.key + ",";
		var v = $("#real_typing").val();
		$("#real_typing").attr('value', v + key);
	});

	$(document).on('mousedown', function (e) {
		if(e.which == 1) {
			var click_v = "LeftClick" + ",";
		}else if(e.which == 2) {
			var click_v = "CenterClick" + ",";
		}else if(e.which == 3) {
			var click_v = "RightClick" + ",";
		}
		var v3 = $("#real_typing").val();
		$("#real_typing").attr('value', v3 + click_v);
	});
	</script>
	<!-- 스팸방지 추가 form [end] -->

    <?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= PHP_EOL.'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice">공지</label>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= PHP_EOL.'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html">html</label>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= PHP_EOL.'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= PHP_EOL.'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;
    ?>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <colgroup>
            <col width="100px">
            <col width="*">
        </colgroup>
        <caption><?php echo $g5['title'] ?></caption>
        <tbody>
		<tr>
			<td colspan="2" style="padding:0 0 50px;">
				<div class="info" style="padding-bottom:5px;">
				<h4>개인정보 수집 및 이용 동의서</h4>
				<div class="scr">
					_업체이름 -이용자 약관 <br>
 
제 1 장 총칙

제 1조(목적)
본 약관은 _업체이름(이하 '회사')이 제공하는 사이트서비스(이하 '서비스')의 이용조건 및 절차에 관해 규정함을 목적으로 합니다. <br>

제 2조(약관의 효력과 변경)
① 본 약관에 대한 내용은 서비스내의 게시판을 통하여 공지하거나 이메일 등을 통한 방법으로 회원에게 통지함으로써 효력이 발생합니다.
② 회사는 전기통신기본법, 전자서명법, 전자거래기본법, 정보통신망이용촉진에 관한 법률 등 기타 관련법령 등을 위배하지 않는 범위 내에서 본 약관을 개정할 수 있습니다.
③ 회사는 본 약관을 개정할 경우 새 약관의 적용일자와 개정사유를 서비스 자유게시판을 통하여 적용일자 전일까지 1주일간 공지해야 합니다.
④ 회원이 변경된 약관에 동의하지 않을 경우 적법한 절차를 통하여 직접 탈퇴할 수 있으며, 이에 따른 책임은 회사에서 지지 않습니다. 만약 변경된 약관이 적용될 일자 이후에도 서비스를 지속적으로 사용할 경우 회사는 회원이 변경된 약관에 동의한 것으로 간주합니다. <br>

제 3조(약관 외 내용)
 본 약관에서 규정하지 않은 사항에 대해서는 대한민국의 전기통신기본법, 전자서명법, 전자거래기본법, 정보통신망이용촉진에 관한 법률 등 기타 관련법령에서 정한 규정을 따릅니다 <br>

제 4조 (용어의 정의)
① 고객 : 회사가 제공하는 서비스에 회원으로 가입하지 않은 네티즌을 말합니다.
② 회원 : 고객이 회사가 제공하는 서비스에 접속하여 본 약관에 따라 서비스 회원으로 가입함과 동시에 회사가 규정한 서비스를 사용하는 사용자를 말합니다.
③ 아이디 : 회원 개개인의 식별과 회사가 운영하는 서비스를 이용할 수 있는 문자와 숫자의 조합으로 회원이 직접 정한다. 단, 아이디는 유일하며 한 회원당 하나의 ID만을 가질 수 있다.
④ 패스워드 : 회원이 서비스를 이용하기 위해 정한 아이디가 정확함을 확인할 수 있고, 회원 자신의 정보를 보호하기 위하여 회원 자신이 정한 문자와 숫자의 조합을 말합니다. <br>

제 2 장 회원 제 5조 (회원 가입 및 자격)
① 회사의 서비스를 사용하는 고객은 회사가 정한 일정한 회원 가입 절차에 따라 개인정보를 입력하여 회원 자격을 부여 받습니다.  <br>

제 6조 (회원 탈퇴 및 자격 상실)
① 제 5조 1항에 의해 서비스 이용 계약을 맺은 회원이 계약 해지를 원할 경우에는 회원 본인이 직접 실명, 아이디 등을 통해 회원 탈퇴 신청을 하셔야 합니다.
② 회사는 회원의 서비스 이용 계약 해지 신청에 대해 적절한 절차를 통해서 처리합니다. - 서비스 상단의 '로그인' 메뉴를 통한 회원의 자의적인 로그인 - My page 메뉴의 '회원탈퇴' 메뉴 선택 –본인 확인  - 회원 탈퇴 신청 완료 
③ 회사는 회원이 다음 각 호의 경우에 해당하는 행위를 하였을 경우 사전 통지 없이 회원 자격과 서비스 이용을 제한, 정지 또는 해지할 수 있습니다. - 회원 가입 신청 시 허위 내용을 기재한 경우 - 회원이 제 9조 제 2항의 각 호와 제 14조 제 2항의 각 호에 해당하는 행위를 하였을 경우 - 회사의 서비스를 고의로 방해하였을 경우 - 타인의 아이디와 비밀번호 를 도용한 경우  <br>

제 7조 (개인정보 보호정책)
회사는 회원이 가입 시 기재한 개인 등록정보와 유료 결제 시 기재하는 금융서비스 등의 정보를 보호하기 위해서 노력합니다. <br>

제 8조 (개인정보 사용에 대한 동의)
① 회사는 보다 나은 서비스를 회원에게 제공하기 위하여 회원 가입 시 회원의 동의하여 제공 받은 개인정보를 이메일 서비스 등에 이용할 수 있으며, 이 경우 제한된 기본적인 개인정보를 이용함을 원칙으로 합니다.
② 회사는 고객이 회원 가입 시 제공한 개인정보에 대하여 서비스 운영에 필요하다고 판단되는 최소한의 용도로 사용하며, 필요할 경우 회원의 사전 동의를 받아야 합니다.
③ 기타 개인정보와 관련된 사항은 관련법령에 의합니다. <br>

제 3장 서비스 이용 계약 제 9조 (서비스 이용 계약)
① 서비스 이용 계약은 고객이 본 약관에 동의한 후, 회사가 정하는 일정 양식을 정확하게 기재하여 신청함으로써 회원이 된 경우 성립됩니다.
② 회사는 고객의 서비스 이용 계약 신청이 다음 각 호에 해당하는 경우 신청에 대한 승낙을 거부 또는 유보할 수 있습니다. - 실명을 사용하지 않았을 경우 - 회원 가입 시 등록한 아이디가 사이트 운영상 또는 사회적으로 공정성 문제를 일으킬 수 있는 경우(예 : webmaster, mananger, ceo 등) - 기타 가입 신청서의 내용이 허위로 작성 되었을 경우 - 타인의 개인정보를 침해하였거나 그에 준하는 문제를 야기했다고 판단되는 경우 - 회사의 업무 또는 기술상 지장이 있다고 판단되는 경우 - 회원 가입 신청자가 본 약관 제 6조 제 3항 각호와 제 14조 제 2항 각호에 의하여 회원자격을 상실한 경우 
③ 회원은 제 9조 제 1항에 의한 회원정보 제공 내용이 변경되었을 경우, 즉시 변경사항을 기재해야 합니다. <br>

제 10조 (서비스 종류 및 변경)
① 회사는 회원에게 다음과 같은 서비스를 제공합니다. - 컨텐츠 - 기타 부가 서비스 
② 회사는 불가피한 사정에 의해 서비스의 내용을 수정 또는 변경할 수 있습니다. <br>

제 11조 (서비스 이용기간 및 이용료)
① 무료의 형태로 제공됩니다.
② 서비스의 이용기간은 회원 가입 후부터 회원이 자의적으로 회원 탈퇴를 하거나 제 6조 제 3항 각호와 제14조 제 2항 각호에 의해 회원 자격을 상실하는 시점까지의 기간을 원칙으로 하며, 회사의 사정에 따라 변경이 가능합니다. 변경에 대한 내용은 서비스 내의 자유게시판을 통해 1주일 동안 공지합니다. <br>

제 12조 (서비스 중단)
① 회사는 다음 각 호에 해당하는 경우 서비스를 중단할 수 있습니다. - 서비스설비의 보수/점검/교체/증설/고장 등의 사유가 발생한 경우 - 회사가 통제할 수 없는 사유가 발생한 경우(해킹, 시스템 다운 등) - 전기통신사업법에 의해 등록된 기간통신사업자가 서비스를 중단했을 경우 - 천재지변, 국가비상사태 등의 불가항력적인 경우 
② 회사는 서비스 중단 사유가 제 12조 제 1항 1호에 의한 경우 1주일 전에 서비스 자유게시판을 통해 공지합니다. 단, 제12조 제1항2, 3, 4호 해당하는 경우 사전 통지할 책임을 지지 않습니다.제 4장 회사와 회원의 의무와 책임  <br>

제 13조 (회사의 의무)
① 회사는 법령 및 본 약관이 금지하는 행위를 하지 않으며, 본 약관이 정하는 바에 따라 지속적이고 안정적으로 서비스를 제공하기 위해서 노력합니다.
② 회사는 회원이 안전하게 서비스를 이용할 수 있도록 회원의 개인정보 및 신용정보 보호를 위한 보안 시스템을 구축합니다.
③ 회사는 회원이 가입 시 기재한 개인 등록정보와 금융서비스 등의 정보를 본 약관에 명시된 경우가 아닌 사항에 대해 본인의 승낙 없이 제 3자에게 유출하지 않습니다. 단, 법률에 의한 국가기관의 요청, 수사사의 목적일 경우에는 해당 기관에 제공할 수 있습니다. <br>

제 14조 (회원의 의무)
① 회원 가입 시 정확한 회원 정보를 입력해야 하며, 변경이 있을 경우에는 즉시 변경사항을 기재해야 합니다.
② 회원은 다음 각 호에 해당하는 행위를 하여서는 안됩니다. - 다른 회원 또는 제 3자를 비방하거나 명예를 손상시키는 행위 - 공공질서 및 미풍양속에 위반되는 행위 - 허위사실의 유포 - 범죄와 관련된 행위 - 타인의 저작권 및 기타 권리를 침해하는 행위 - 회사의 서비스를 고의로 방해하는 행위 - 타인의 아이디와 비밀번호를 도용하는 행위 - 컴퓨터 바이러스 및 바이러스 감염자료를 유포, 등록하는 행위 - 회사의 승인을 받지 않은 스팸메일, 정크메일, 행운의 편지, 광고, 판촉물, 피라미드 조직, 돈 벌기 사이트 가입 권유 등의 내용을 메일, 게시, 게재 또는 다른 방법으로 전송하는 행위 - 폭력, 외설적인 메시지, 동영상, 이미지, 음성 등이 담긴 메시지 전송 또는 게시, 게재하는 행위 - 회사가 저작권 및 지적재산권을 가진 정보를 회사의 서면/사전 동의 없이 복제, 수정, 배포, 출판, 판매 등의 영리적 목적으로 사용하는 행위 - 회사의 직원 또는 서비스 관리자를 사칭하거나 회원의 명의를 도용하는 모든 행위 - 기타 관련 법령이 정한 법률에 위배되는 행위 
③ 회사는 회원이 제 9조 제 2항 각호와 제 14조 제 2항 각호에 해당하는 행위를 하였을 경우 제 6조 제 3항에 의거 해당 회원의 자격과 서비스 이용을 제한, 정지 또는 해지할 수 있습니다.
④ 회원은 회원본인의 아이디와 비밀번호를 관리할 책임이 있으며, 회원의 관리소홀로 인하여 발생하는 결과에 대해서 책임을 집니다.
⑤ 회원은 본 약관 및 관계법령을 준수하여야 합니다.
⑥ 회사는 회원이 본 약관이 정하는 회원의 의무를 위반하였을 경우 회원에게 손해배상을 청구할 수 있습니다. <br>

제 5장 서비스 이용 제 15조 (컨텐츠 게재의 제한)
모든 회원은 서비스 내의 게시판에 자신의 의사나 특정 정보를 게재하고 직접 수정/변경할 수 있습니다. 하지만, 다음 각 항목에 해당하는 경우에는 서비스 운영자가 임의로 수정 또는 삭제할 수 있습니다. - 게재물의 내용이 해당 게시판의 성격과 현격하게 다르거나 지나친 상업성, 폭력성, 선정성 또는 타인의 권리를 침해하는 내용 등을 담고 있어 다른 사용자들에게 피해를 줄 우려가 있는 경우. - 사이트의 운영상 장애가 된다고 판단할 만한 내용을 담고 있는 경우 - 기타 사회 통념 및 공고의 윤리에 반하는 내용을 담고 있는 경우.제 16조 (사용자의 의사 개진)서비스의 모든 회원은 회사가 제공하는 서비스의 내용에 문제가 있다고 여겨지거나 기타 의견을 갖고 있는 경우, 자유게시판에 게재하거나 서비스 관리 담당자 앞으로 이메일을 전송함으로써 자신의 의사를 개진할 수 있습니다.제 17조 (컨텐츠 배포)회사가 제공하는 모든 컨텐츠의 저작권은 회사에 귀속되므로, 이에 대한 무단 배포는 금지되어 있습니다. 하지만, 회사가 별도로 마련한 조건에 따라 컨텐츠 제공 계약을 한 경우에는 서비스내의 컨텐츠 배포가 허용됩니다. <br>

제 6장 기타 제 18조 (저작권)
서비스에서 제공되는 모든 컨텐츠는 회사의 소유이며 저작권 역시 회사에 귀속되며, 이 모든 내용들은 지적재산권에 의해 보호를 받습니다. 그 결과, 회사의 사전 승인 없이 특정 컨텐츠의 내용을 무단으로 도용하거나, 수정/변경을 가한 파생물을 제작하여 상업적으로 이용하는 행위는 금지되어 있습니다. 상업적인 목적 없이 이용하는 경우라고 하더라도 단순 링크 연결이 아닌, 컨텐츠 직접 게재 방식을 취하는 경우에는 회사의 사전 동의를 얻은 후 그 표현 방식에 관해서도 협의를 거쳐야 합니다. 저작권 침해 관련 문의 즉, 서비스의 컨텐츠가 타인의 저작권을 침해한다고 여겨지거나 제 3자의 컨텐츠가 서비스의 저작권을 침해한다고 여겨지는 경우에는 담당 관리자로 제보해 주시기 바랍니다. <br>

제 19조 (면책)
① 회사는 회원들이 항상 신뢰할 수 있는 컨텐츠를 제공하기 위해 최선을 다하고 있습니다. 단, 제공되는 컨텐츠에는 오류가 있을 수 있으며, 회원이 그 컨텐츠를 직접 활용함으로써 발생할 수 있는 문제점은 사용자 자신의 부담이라고 할 수 있으므로 서비스 운영진은 이에 대한 책임을 지지 않습니다. 
② 회사는 서비스의 각종 게시판에 회원이 자유롭게 게재한 게시물이 초래할 수 있는 문제점에 대해서도 책임을 지지 않습니다. 이러한 운영 방식은, 회원 자신의 자유로운 의사 개진 및 신속한 정보의 공유라는 측면에서 원활한 서비스 운영을 위해 불가피한 방식입니다.상기 내용은 물론 법적인 책임이 면책된다는 의미이지만, 도의적으로는 문제점 해결을 위해 최선을 노력을 다 할 것입니다. - 회사는 천재지변 또는 이에 준하는 불가항력으로 인하여 서비스를 제공할 수 없는 경우에는 서비스 제공에 관한 책임이 면제됩니다. - 회사는 회원의 귀책사유로 인한 서비스 이용의 장애에 대하여 책임을 지지 않습니다. - 회사는 회원이 서비스를 이용하여 기대하는 수익을 상실한 것이나 서비스를 통하여 얻은 자료로 인한 손해에 관하여 책임을 지지 않습니다. - 회사는 회원이 서비스에 게재한 정보, 자료, 사실의 신뢰도, 정확성 등 내용에 관하여는 책임을 지지 않습니다. - 회사는 서비스 이용과 관련하여 가입자에게 발생한 손해 가운데 가입자의 고의, 과실에 의한 손해에 대하여 책임을 지지 않습니다. <br>

제 20조 (관할법원)
회원과 회사간에 서비스로부터 발생하거나 서비스와 관련하여 발생하는 모든 분쟁은 회사의 본사 소재지를 관할하는 법원을 관할법원으로 합니다.[부칙] (시행일) 이 약관은 2007년 04월 01일부터 시행합니다.

				</div>
				<p align="left">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="chk_agree1"><span class="icon"></span>개인정보 수집/활용에 동의 합니다
						</label>
					</div>
				</p>
			</div>
			<div class="info" style="border-bottom:1px solid #ddd;">
				<h4>개인정보 제 3자 이용 동의서</h4>
				<div class="scr">
					_업체이름 [개인정보 보호정책] <br>
1. 총칙
① 개인정보란 생존하는 개인에 관한 정보로서 당해 정보에 포함되어 있는 성명, 아이디 등의 사항에 의하여 당해 개인을 식별할 수 있는 정보(당해 정보만으로는 특정 개인을 식별할 수 없더라도 다른 정보와 용이하게 결합하여 식별할 수 있는 것을 포함합니다)를 말합니다.
② _업체이름은 귀하의 개인정보보호를 매우 중요시하며, 『정보통신망이용촉진및정보보호에관한법률』상의 개인정보보호규정 및 정보통신부가 제정한 『개인정보보호지침』을 준수하고 있습니다. _업체이름은 개인정보보호정책을 통하여 귀하께서 제공하시는 개인정보가 어떠한 용도와 방식으로 이용되고 있으며 개인정보보호를 위해 어떠한 조치가 취해지고 있는지 알려드립니다.
③ _업체이름은 개인정보보호정책을 홈페이지 첫 화면에 공개함으로써 귀하께서 언제나 용이하게 보실 수 있도록 조치하고 있습니다.
④ _업체이름은 개인정보보호정책의 지속적인 개선을 위하여 개인정보보호정책을 개정하는데 필요한 절차를 정하고 있습니다. 그리고 개인정보보호정책을 개정하는 경우 버전번호 등을 부여하여 개정된 사항을 귀하께서 쉽게 알아볼 수 있도록 하고 있습니다. <br>
2. 개인정보 수집의 범위
① 본 약관에 대한 내용은 서비스내의 게시판을 통하여 공지하거나 이메일 등을 통한 방법으로 회원에게 통지함으로써 효력이 발생합니다.
② 회사는 전기통신기본법, 전자서명법, 전자거래기본법, 정보통신망이용촉진에 관한 법률 등 기타 관련법령 등을 위배하지 않는 범위 내에서 본 약관을 개정할 수 있습니다.
③ 회사는 본 약관을 개정할 경우 새 약관의 적용일자와 개정사유를 서비스 공지사항을 통하여 적용일자 전일까지 1주일간 공지해야 합니다.
④ 회원이 변경된 약관에 동의하지 않을 경우 적법한 절차를 통하여 직접 탈퇴할 수 있으며, 이에 따른 책임은 회사에서 지지 않습니다. 만약 변경된 약관이 적용될 일자 이후에도 서비스를 지속적으로 사용할 경우 회사는 회원이 변경된 약관에 동의한 것으로 간주합니다. <br>
3. 개인정보 수집에 대한 동의
_업체이름은 귀하께서 _업체이름의 개인정보보호방침 또는 이용약관의 내용에 대해 「동의함」버튼 또는 「동의안함」버튼을 클릭할 수 있는 절차를 마련하여, 동의함」버튼을 클릭하면 개인정보 수집에 대해 동의한 것으로 봅니다. <br>

4. 개인정보의 수집목적 및 이용목적
① _업체이름은 다음과 같은 목적을 위하여 개인정보를 수집하고 있습니다.
- 성명, 아이디, 비밀번호 : 회원제 서비스 이용에 따른 본인 식별 절차에 이용
- 이메일주소, 전화번호 : 공지사항 전달, 본인 의사 확인, 불만 처리 등 원활한 의사소통 경로의 확보, 새로운 서비스/신상품이나 이벤트 정보의 안내
- 은행계좌정보, 신용카드정보 : 유료서비스 이용에 대한 요금 결제
- 주소 : 인구통계학적 분석 자료(이용자의 연령별, 성별, 지역별 통계분석) 그 외 선택항목 : 개인맞춤 서비스를 제공하기 위한 자료
② 단, 이용자의 기본적 인권 침해의 우려가 있는 민감한 개인정보(인종 및 민족, 사상 및 신조, 출신지 및 본적지, 정치적 성향 및 범죄기록, 건강상태 및 성생활 등)는 수집하지 않습니다. <br>
5. 쿠키에 의한 개인정보 수집
① 쿠키(cookie)란?
_업체이름은 귀하에 대한 정보를 저장하고 수시로 찾아내는 '쿠키(cookie)'를 사용합니다. 쿠키는 웹사이트가 귀하의 컴퓨터 브라우저(넷스케이프, 인터넷 익스플로러 등)로 전송하는 소량의 정보입니다. 귀하께서 웹사이트에 접속을 하면 ○○의 컴퓨터는 귀하의 브라우저에 있는 쿠키의 내용을 읽고, 귀하의 추가정보를 귀하의 컴퓨터에서 찾아 접속에 따른 성명 등의 추가 입력 없이 서비스를 제공할 수 있습니다. 쿠키는 귀하의 컴퓨터는 식별하지만 귀하를 개인적으로 식별하지는 않습니다. 
또한 귀하는 쿠키에 대한 선택권이 있습니다. 웹브라우저 상단의 도구 >인터넷옵션 탭(option tab)에서 모든 쿠키를 다 받아들이거나, 쿠키가 설치될 때 통지를 보내도록 하거나, 아니면 모든 쿠키를 거부할 수 있는 선택권을 가질 수 있습니다.
② _업체이름의 쿠키(cookie) 운용 
_업체이름  은 이용자의 편의를 위하여 쿠키를 운영합니다. _업체이름이 쿠키를 통해 수집하는 정보는 ‘_업체이름'의 온라인 회원 ID에 한하며, 그 외의 다른 정보는 수집하지 않습니다. _업체이름은 쿠키(cookie)를 통해 수집한 회원 ID는 다음의 목적을 위해 사용됩니다.
- 개인의 관심 분야에 따라 차별화된 정보를 제공
- 회원과 비회원의 접속빈도 또는 머문 시간 등을 분석하여 이용자의 취향과 관심분야를 파악하여 타깃(target) 마케팅에 활용
- 유료서비스 이용 시 이용기간 안내
- 회원들의 습관을 분석하여 서비스 개편 등의 척도
- 회원전용메뉴(블로그, 게시판 등)의 사용 시 쿠키는 브라우저의 종료시나 로그아웃 시 만료됩니다. <br>
6. 목적 외 사용 및 제 3자에 대한 제공 및 공유
① _업체이름은 귀하의 개인정보를 「개인정보의 수집목적 및 이용목적」에서 고지한 범위 내에서 사용하며, 동 범위를 초과하여 이용하거나 타인 또는 타기업·기관에 제공하지 않습니다. 특히 다음의 경우는 주의를 기울여 개인정보를 이용 및 제공할 것입니다.
- 제휴관계 : 보다 나은 서비스 제공을 위하여 귀하의 개인정보를 제휴사에게 제공하거나 또는 제휴사와 공유할 수 있습니다. 개인정보를 제공하거나 공유할 경우에는 사전에 귀하께 제휴사가 누구인지, 제공 또는 공유되는 개인정보항목이 무엇인지, 왜 그러한 개인정보가 제공되거나 공유되어야 하는지, 그리고 언제까지 어떻게 보호·관리되는지에 대해 개별적으로 전자우편 및 서면을 통해 고지하여 동의를 구하는 절차를 거치게 되며, 귀하께서 동의하지 않는 경우에는 제휴사에게 제공하거나 제휴사와 공유하지 않습니다. 제휴관계에 변화가 있거나 제휴관계가 종결될 때도 같은 절차에 의하여 고지하거나 동의를 구합니다.
- 이메일주소, 전화번호 : 고지사항 전달, 본인 의사 확인, 불만 처리 등 원활한 의사소통 경로의 확보, 새로운 서비스/신상품이나 이벤트 정보의 안내
- 위탁 처리 : 원활한 업무 처리를 위해 이용자의 개인정보를 위탁 처리할 경우 반드시 사전에 위탁처리 _업체이름과 위탁 처리되는 개인정보의 범위, 업무위탁 목적, 위탁 처리되는 과정, 위탁관계 유지기간 등에 대해 상세하게 고지합니다.
- 매각·인수합병 등 : 서비스 제공자의 권리와 의무가 완전 승계·이전되는 경우 반드시 사전에 정당한 사유와 절차에 대해 상세하게 고지할 것이며 이용자의 개인정보에 대한 동의 철회의 선택권을 부여합니다.
② 고지 및 동의방법은 온라인 홈페이지 초기화면의 공지사항을 통해 최소 10일 이전부터 고지함과 동시에 이메일 등을 이용하여 1회 이상 개별적으로 고지하고 매각·인수합병에 대해서는 반드시 적극적인 동의 방법(개인정보의 제 3자 제공 및 공유에 대한 의사를 직접 밝힘)에 의해서만 절차를 진행합니다.
③ 다음은 예외로 합니다.
- 관계법령에 의하여 수사상의 목적으로 관계기관으로부터의 요구가 있을 경우입니다. 제휴관계에 변화가 있거나 제휴관계가 종결될 때도 같은 절차에 의하여 고지하거나 동의를 구합니다.
- 통계작성·학술연구나 시장조사를 위하여 특정 개인을 식별할 수 없는 형태로 광고주·협력사나 연구단체 등에 제공하는 경우
- 위탁 처리 : 원활한 업무 처리를 위해 이용자의 개인정보를 위탁 처리할 경우 반드시 사전에 위탁처리 _업체이름과 위탁 처리되는 개인정보의 범위, 업무위탁 목적, 위탁 처리되는 과정, 위탁관계 유지기간 등에 대해 상세하게 고지합니다.
-그러나 예외 사항에서도 관계법령에 의하거나 수사기관의 요청에 의해 정보를 제공한 경우에는 이를 당사자에게 고지하는 것을 원칙으로 운영하고 있습니다. 법률상의 근거에 의해 부득이하게 고지를 하지 못할 수도 있습니다. 본래의 수집목적 및 이용목적에 반하여 무분별하게 정보가 제공되지 않도록 최대한 노력하겠습니다. <br>
7. 개인정보의 열람 및 정정
① 귀하는 언제든지 등록되어 있는 귀하의 개인정보를 열람하거나 정정하실 수 있습니다. 개인정보 열람 및 정정을 하고자 할 경우에는 『개인정보변경』을 클릭하여 직접 열람 또는 정정하거나, 개인정보관리책임자 및 담당자에게 서면, 전화 또는 E-mail로 연락하시면 지체 없이 조치하겠습니다.
② 귀하가 개인정보의 오류에 대한 정정을 요청한 경우, 정정을 완료하기 전까지 당해 개인 정보를 이용 또는 제공하지 않습니다.
③ 잘못된 개인정보를 제3자에게 이미 제공한 경우에는 정정 처리결과를 제3자에게 지체 없이 통지하여 정정하도록 조치하겠습니다. <br>
8. 개인정보의 보유기간 및 이용기간
① 귀하의 개인정보는 다음과 같이 개인정보의 수집목적 또는 제공받은 목적이 달성되면 파기됩니다. 단, 상법 등 관련법령의 규정에 의하여 다음과 같이 거래 관련 권리 의무 관계의 확인 등을 이유로 일정기간 보유하여야 할 필요가 있을 경우에는 일정기간 보유합니다.
- 회원가입정보의 경우, 회원가입을 탈퇴하거나 회원에서 제명된 경우 등 일정한 사전에 보유목적, 기간 및 보유하는 개인정보 항목을 명시하여 동의를 구합니다.
- 대금결제 관한 기록 : 5년
- 소비자의 불만 또는 분쟁처리에 관한 기록 : 3년
② 귀하의 동의를 받아 보유하고 있는 거래정보 등을 귀하께서 열람을 요구하는 경우 _업체이름은 지체 없이 열람·확인 할 수 있도록 조치합니다. <br>
9. 개인정보 보호를 위한 기술 및 관리적 대책
① 기술적 대책
② _업체이름은 귀하의 개인정보를 취급함에 있어 개인정보가 분실, 도난, 누출, 변조 또는 훼손되지 않도록 안전성 확보를 위하여 다음과 같은 기술적 대책을 강구하고 있습니다.
- 귀하의 개인정보는 비밀번호에 의해 보호되며 파일 및 전송데이터를 암호화하거나 파일 잠금기능(Lock)을 사용하여 중요한 데이터는 별도의 보안기능을 통해 보호되고 있습니다.
- _업체이름은 백신프로그램을 이용하여 컴퓨터바이러스에 의한 피해를 방지하기 위한 조치를 취하고 있습니다. 백신프로그램은 주기적으로 업데이트되며 갑작스런 바이러스가 출현할 경우 백신이 나오는 즉시 이를 제공함으로써 개인정보가 침해되는 것을 방지하고 있습니다.
- _업체이름은 암호알고리즘을 이용하여 네트워크 상의 개인정보를 안전하게 전송할 수 있는 보안장치(SSL 또는 SET)를 채택하고 있습니다.
- 해킹 등 외부침입에 대비하여 각 서버마다 침입차단시스템 및 취약점 분석시스템 등을 이용하여 보안에 만전을 기하고 있습니다.
③ 관리적 대책
- _업체이름은 귀하의 개인정보에 대한 접근권한을 최소한의 인원으로 제한하고 있습니다. 그 최소한의 인원에 해당하는 자는 다음과 같습니다.
· 이용자를 직접 상대로 하여 마케팅 업무를 수행하는 자
· 개인정보관리책임자 및 담당자 등 개인정보관리업무를 수행하는 자
· 기타 업무상 개인정보의 취급이 불가피한 자
- 개인정보를 취급하는 직원을 대상으로 새로운 보안 기술 습득 및 개인정보 보호 의무 등에 관해 정기적인 사내 교육 및 외부 위탁교육을 실시하고 있습니다.
-	개인정보 관련 취급자의 업무 인수인계는 보안이 유지된 상태에서 철저하게 이뤄지고 있으며 입사 및 퇴사 후 개인정보 사고에 대한 책임을 명확화하고 있습니다.
- _업체이름은 이용자 개인의 실수나 기본적인 인터넷의 위험성 때문에 일어나는 일들에 대해 책임을 지지 않습니다. 회원 개개인이 본인의 개인정보를 보호하기 위해서 자신의 ID 와 비밀번호를 적절하게 관리하고 여기에 대한 책임을 져야 합니다.
- 그 외 내부 관리자의 실수나 기술관리 상의 사고로 인해 개인정보의 상실, 유출, 변조, 훼손이 유발될 경우 _업체이름은 즉각 귀하께 사실을 알리고 적절한 대책과 보상을 강구할 것입니다. <br>
10. 링크사이트
_업체이름은 귀하께 다른 회사의 웹사이트 또는 자료에 대한 링크를 제공할 수 있습니다. 이 경우 _업체이름 은 외부사이트 및 자료에 대한 아무런 통제권이 없으므로 그로부터 제공받는 서비스나 자료의 유용성에 대해 책임질 수 없으며 보증할 수 없습니다. _업체이름이 포함하고 있는 링크를 클릭(click)하여 타 사이트(site)의 페이지로 옮겨갈 경우 해당 사이트의 개인정보보호정책은 _업체이름 과 무관하므로 새로 방문한 사이트의 정책을 검토해 보시기 바랍니다. <br>
11. 게시물
① _업체이름은 귀하의 게시물을 소중하게 생각하며 변조, 훼손, 삭제되지 않도록 최선을 다하여 보호합니다. 그러나 다음의 경우는 그렇지 아니합니다.
- 스팸(spam)성 게시물 (예 : 행운의 편지, 8억 메일, 특정사이트 광고 등)
-	타인을 비방할 목적으로 허위 사실을 유포하여 타인의 명예를 훼손하는 글 
- 동의 없는 타인의 신상공개 _업체이름의 저작권, 제 3자의 저작권 등 권리를 침해하는 내용, 기타 게시판 주제와 다른 내용의 게시물
- _업체이름은 바람직한 게시판 문화를 활성화하기 위하여 동의 없는 타인의 신상 공개 시 특정부분을 삭제하거나 기호 등으로 수정하여 게시할 수 있습니다.
- 다른 주제의 게시판으로 이동 가능한 내용일 경우 해당 게시물에 이동 경로를 밝혀 오해가 없도록 하고 있습니다.
- 그 외의 경우 명시적 또는 개별적인 경고 후 삭제 조치할 수 있습니다.
② 근본적으로 게시물에 관련된 제반 권리와 책임은 작성자 개인에게 있습니다. 또 게시물을 통해 자발적으로 공개된 정보는 보호받기 어려우므로 정보 공개 전에 심사숙고 하시기 바랍니다. <br>
12. 이용자의 권리와 의무
① 귀하의 개인정보를 최신의 상태로 정확하게 입력하여 불의의 사고를 예방해 주시기 바랍니다. 이용자가 입력한 부정확한 정보로 인해 발생하는 사고의 책임은 이용자 자신에게 있으며 타인 정보의 도용 등 허위정보를 입력할 경우 회원자격이 상실될 수 있습니다.
② 귀하는 개인정보를 보호받을 권리와 함께 스스로를 보호하고 타인의 정보를 침해하지 않을 의무도 가지고 있습니다. 비밀번호를 포함한 귀하의 개인정보가 유출되지 않도록 조심하시고 게시물을 포함한 타인의 개인정보를 훼손하지 않도록 유의해 주십시오. 만약 이 같은 책임을 다하지 못하고 타인의 정보 및 존엄성을 훼손할 시에는 『정보통신망이용촉진 및 정보보호 등에 관한 법률』등에 의해 처벌 받을 수 있습니다.
13. 의견수렴 및 불만처리
① 당사는 귀하의 의견을 소중하게 생각하며, 귀하는 의문사항으로부터 언제나 성실한 답변을 받을 권리가 있습니다.
② 당사는 귀하와의 원활환 의사소통을 위해 민원처리센터를 운영하고 있습니다. 민원처리센터의 연락처는 다음과 같습니다.
[민원처리센터]
- 전화번호 : _전화번호 
③ 전자우편이나 팩스 및 우편을 이용한 상담은 접수 후 12시간 내에 성실하게 답변 드리겠습니다. 다만, 근무시간 이후 또는 주말 및 공휴일에는 익일 처리하는 것을 원칙으로 합니다.
⑤ 기타 개인정보에 관한 상담이 필요한 경우에는 개인정보침해신고센터, 대검찰청 인터넷범죄수사센터, 경찰청 사이버테러대응센터 등으로 문의하실 수 있습니다.
[개인정보침해신고센터]
- 전화 : 1336
- URL : http://www.cyberprivacy.or.kr
[대검찰청 인터넷범죄수사센터]
- 전화 : 02-3480-3600
- URL :  http://www.spo.go.kr
[경찰청 사이버테러대응센터]
- 전화 : 02-392-0330
- URL :  http://www.ctrc.go.kr


				</div>
				<p align="left">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="chk_agree2"><span class="icon"></span>개인정보 제 3자 활용에 동의합니다
						</label>
					</div>
				</p>
				</div>			
			</td>
        </tr>

        <?php if ($is_category) { ?>
        <tr>
            <th scope="row"><label for="ca_name">분류<strong class="sound_only">필수</strong></label></th>
            <td>
                <select class="required" id="ca_name" name="ca_name" required>
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </td>
        </tr>
        <?php } ?>

        <tr>
            <th scope="row"><label for="wr_name">주문자명<strong class="sound_only">필수</strong></label></th>
            <td><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required" maxlength="20"></td>
        </tr>
		
		<tr>
            <th scope="row"><label for="wr_4">연락처</label></th>
            <td>
				<input placeholder="ex) 01012345678" type="text" name="wr_4" value="<?php echo $wr_4 ?>" id="wr_4" required class="frm_input required" size="25" maxlength="11"> - 없이 입력해 주세요.
			</td>
        </tr>
		
		<?php if ($is_email) { ?>
        <tr>
            <th scope="row"><label for="wr_email">이메일</label></th>
            <td>
				<input placeholder="email@example.com" type="email" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email" size="55" maxlength="100">
			</td>
        </tr>
        <?php } ?>

		<!--주소 시작-->
        <tr>
            <th scope="row"><label for="wr_1">주소</label></th>
            <td>
				<input type="text" name="wr_1" id="wr_1" value="<?php echo $wr_1 ?>" maxlength="3" class="frm_input input01" readonly="readonly">
				<input type="button" onclick="openDaumPostcode()" value="우편번호 찾기" class="frm_input postbtn"><br>
				<input type="text" name="wr_2" id="wr_2" value="<?php echo $wr_2 ?>" title="행정기본주소" placeholder="행정기본주소" class="frm_input input04" size="55">
				<input type="text" name="wr_3" id="wr_3" value="<?php echo $wr_3 ?>" title="상세주소" placeholder="상세주소" class="frm_input input04" size="55">
			</td>
        </tr>
		<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
		<script> 
			function openDaumPostcode() { 
				new daum.Postcode({ 
					oncomplete: function(data) { 
						document.getElementById('wr_1').value = data.zonecode;
						document.getElementById('wr_2').value = data.address+" ("+data.jibunAddress+") ";
						document.getElementById('wr_3').focus(); 
					} 
				}).open(); 
			} 
		</script>
		<!--주소 종료-->
		
		<tr>
            <th scope="row"><label for="">주문상품<strong class="sound_only">필수</strong></label></th>
            <td>
                <div class="goods_list_box">
                </div>
				<div class="goods_list">
					<table>
					<thead>
						<tr>
							<th>품명</th>
							<th>가격</th>
							<th>단위</th>
							<th>수량</th>
						</tr>
						
						<?php
							$sql = "select * from g5_write_{$board['bo_1']} order by wr_id desc";
							$rs = sql_query( $sql );
							for ( $i = 0; $row = sql_fetch_array( $rs ); $i++ ) {
						?>
						
						<tr>
							<td><input type="hidden" name="goods_name" value="<?=$row['wr_subject']?>"><?=$row['wr_subject']?></td>
							<td><input type="hidden" name="goods_price" value="<?=$row['wr_2']?>"><?=$row['wr_2']?></td>
							<td><input type="hidden" name="goods_measure" value="<?=$row['wr_1']?>"><?=$row['wr_1']?></td>
							<td>
								<input data-id="<?=$row['wr_id']?>" data-price="<?=$row['wr_2']?>" readonly class="spinner" id="sw<?=$row['wr_id']?>" name="goods_count" value="" style="width: 35px;">
								<input type="hidden" name="goods_id" value="<?=$row['wr_id']?>">
							</td>
						</tr>
						<?php } ?>
					</thead>
					</table>
				</div>
			</td>
        </tr>
		
		<tr>
            <th scope="row"><label for="">주문금액<strong class="sound_only">필수</strong></label></th>
            <td><input type="hidden" id="wr_total_price" name="wr_total_price" value=""><span id="total_price"><?=$write['wr_total_price'] ? $write['wr_total_price'] : '0원'?></span></td>
        </tr>
		

        <tr>
            <th scope="row"><label for="wr_content">특이사항<strong class="sound_only">필수</strong></label></th>
            <td class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </td>
        </tr>
		
		<?php if ($is_guest) { //자동등록방지 ?>

        <tr>
            <th scope="row"><label for="wr_password">비밀번호<strong class="sound_only">필수</strong></label></th>
            <td><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?>" maxlength="20"></td>
        </tr>

        <tr>
            <th scope="row">자동등록방지</th>
            <td>
                <?php echo $captcha_html ?>
            </td>
        </tr>
        <?php } ?>

        <?php for ($i=0; $is_file && $i<$file_count; $i++) {/* ?>
        <tr>
            <th scope="row">파일 #<?php echo $i+1 ?></th>
            <td>
                <div class="file_box">
                    <input type="text" class="file_name frm_input">
                    <a href="javascript:" class="file_btn">파일첨부</a>
                    <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> :  용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input">
                </div>
                <?php if ($is_file_content) { ?>
                <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input">
                <?php } ?>
                <?php if($w == 'u' && $file[$i]['file']) { ?>
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i; ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')'; ?> 파일 삭제</label>
                <?php } ?>
            </td>
        </tr>
        <script>
            $('input[type=file]').change(function(){
                $(this).siblings('.file_name').val($(this).val());
            });
        </script>
        <?php */} ?>
		
        </tbody>
        </table>
    </div>

    <div class="btn_confirm">
        <input type="submit" value="작성완료" id="btn_submit" class="btn_submit" accesskey="s">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel">취소</a>
    </div>
    </form>
</section>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
	var total_price = 0;
	var temp_price = 0;
	
	$( ".spinner" ).spinner( {
		min: 0,
		spin: function ( event, ui ) {

            var value = $(this).attr( 'data-price' );
            var price = value.replace(/[^0-9]/g,'');


			if ( $( this ).val() != ui.value ) {
				if ( ui.value < $( this ).val() ) {
					total_price -= parseInt( price );
				} else {
					temp_price = parseInt( $(this).val() ) * parseInt( price );
					total_price += parseInt( price );
				}
			}
			$( "#wr_total_price" ).val( total_price );
			$( "#total_price" ).html( comma(total_price)+'원' );
		}
	} );	

} );


function comma(num){
    var len, point, str; 
       
    num = num + ""; 
    point = num.length % 3 ;
    len = num.length; 
   
    str = num.substring(0, point); 
    while (point < len) { 
        if (str != "") str += ","; 
        str += num.substring(point, point + 3); 
        point += 3; 
    } 
     
    return str;
 
}

</script>
<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
    $("#wr_content").on("keyup", function() {
        check_byte("wr_content", "char_count");
    });
});

<?php } ?>
function html_auto_br(obj)
{
    if (obj.checked) {
        result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
        if (result)
            obj.value = "html2";
        else
            obj.value = "html1";
    }
    else
        obj.value = "";
}

function fwrite_submit(f)
{
	var html  = '';
    var total = 0;

    for ( var i = 0; i <= f.goods_count.length; i++ ) {
        if(typeof f.goods_count[i] == 'object'){
           var set_id = '#'+f.goods_count[i].id;
           var num = $(set_id).attr('aria-valuenow') ? $(set_id).attr('aria-valuenow') : 0;
           if(num > 0){
                html += '<input type="hidden" name="wr_goods_name_'+total+'" value="'+f.goods_name[i].value+'">';
                html += '<input type="hidden" name="wr_goods_price_'+total+'" value="'+f.goods_price[i].value+'">';
                html += '<input type="hidden" name="wr_goods_measure_'+total+'" value="'+f.goods_measure[i].value+'">';
                html += '<input type="hidden" name="wr_goods_count_'+total+'" value="'+f.goods_count[i].value+'">';
                html += '<input type="hidden" name="wr_goods_id_'+total+'" value="'+f.goods_id[i].value+'">';
                total++;
           }
        }
    }
    html += '<input type="hidden" name="wr_goods" value="'+total+'">';
    $( '.goods_list_box' ).html( html );		
    	           
    if (total < 1){
        alert('하나의 상품이상 선택해주세요.');
		return false;
    }

	if (!f.chk_agree1.checked || !f.chk_agree2.checked){
		alert("개인정보 사항에 체크하셔야 합니다.");
		f.chk_agree1.focus();
		return false;
	}

    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": f.wr_subject.value,
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (subject) {
        alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
        f.wr_subject.focus();
        return false;
    }

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        if (typeof(ed_wr_content) != "undefined")
            ed_wr_content.returnFalse();
        else
            f.wr_content.focus();
        return false;
    }

    if (document.getElementById("char_count")) {
        if (char_min > 0 || char_max > 0) {
            var cnt = parseInt(check_byte("wr_content", "char_count"));
            if (char_min > 0 && char_min > cnt) {
                alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                return false;
            }
            else if (char_max > 0 && char_max < cnt) {
                alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                return false;
            }
        }
    }

    <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}
</script>
