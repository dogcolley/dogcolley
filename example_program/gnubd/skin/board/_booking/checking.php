<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');

// add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/checking.css">', 0);

?>
<style>
@media (min-width: 1200px){
    .container {
      width: 800px;
      height: 70%;
      /*margin: 100px auto;*/

    }    
}
.span{
    font-size: 17px;
}
@media (max-width:500px){
    .span{
        font-size: 14px;
    }
}
.container {
  /*width: 70%;*/
  height: 70%;
  /*margin: 100px auto;*/

}
.outer {
  display: table;
  width: 100%;
  height: 100%;
  border :1px solid #ddd;
  vertical-align: middle;
  text-align: center;
  margin-bottom: 100px;
}
.subject {
  width: 100%;
  padding-top: 40px;
  font-size: 32px;
  /*padding-bottom: 40px;*/

}
.content{
    height: 100%;
    padding-top: 70px;
    padding-bottom: 40px;
}
.frm_input{
    outline: #333;
    width: 230px;
    height: 36px; 
    padding: 4px; 
    border: 1px solid #e4eaec; 
    border-radius: 4px; 
    font-size: 14px; 
    background: #fdfdfd !important; 
}

.btn_submit{
    height: 100px;
    width: 70px;
    margin-right: 4px;
    padding: 8px;
    border: 0;
    border-radius: 4px;
    background: #454c60;
    color: #fff;
    font-size: 14px;
    letter-spacing: -0.5px;
    cursor: pointer;
}
.tbl_1{
    display: table;

}
.chk_title {
    width: 100%;
    padding-top: 40px;
    font-size: 20px;
}
a.btn_admins {
	display: inline-block;
    width: 130px;
    height: 34px;
    padding: 7px;
    border: 0px solid #454c60;
    border-radius: 4px;
    background: #454c60;
    color: #fff;
    font-size: 14px;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    line-height: 20px;
}
}
</style>

<h2 class="reservAccountTitle1" style="text-align:center;">
	<span class="highlight"><i class="fab fa-envira"></i></span> 
	<span class="highlight1">나의 예약정보 확인</span> 
</h2>
<br />
<br />


<div class="container">
  <div class="outer">
    <!--<div class="subject">나의 예약정보 확인</div>
    <div>예약하신 성명과 휴대폰번호를 작성해주세요.</div>-->
	<div class="chk_title">예약하신 성함과 휴대폰번호를 입력 해 주세요.</div>
    <div class="content" align="center">
        <table class="tbl_1">
            <form onsubmit="return onsmit()" method="get">
                <input type="hidden" name="bo_table" value="<?php echo $board['bo_1']?>">
                <input type="hidden" name="wr_id" value="" id="wr_id">
                <input type="hidden" name="stx" value="" id="stx">
            <tr>
                <td style="padding-right: 20px;"><span class="span">이름</span></td>
                <td style=""><input type="text" id="name" class="frm_input" style="width: 100px;"></td>
                <td rowspan="2" style="padding-left: 20px;">
                    <button class="btn_submit" type="submit" id="submit_srch" >확인</button>
                </td>
            </tr>
            <tr>
                <td style="padding-right: 20px;"><span class="span">휴대폰 번호</span></td>
                <td style="padding-top: 20px;"><input type="text" id="cell" class="frm_input" style="width: 100px;"></td>
            </tr>
            </form>
            <tr>
                <td colspan="2" style="padding-top: 55px;"><a href="javascript:history.back();" class="btn_admins" id="goodsbtn" style="cursor: pointer;float: right;margin-left: 5px;">돌아가기</a></td>
            </tr>
        </table>
    </div>
  </div>
  
</div>
<script type="text/javascript">
    function onsmit(){
        // return false;
        name = $("#name").val();
        cell = $("#cell").val();
        if (name == "" || cell == "") {
            alert("작성란이 비어있습니다.");
            return false;
        }
        $.ajax( {
                url: "<?=$board_skin_url?>/ajax/ajax_checking.php?ver=20201008",
                type: "POST",
                data: {
                    "status" : "search",
                    "bo_1" : "<?=$board['bo_1']?>",
                    "name" : name,
                    "cell" : cell
                }, 
                dataType: "json",
                async: false,
                cache: false,
                success: function( data, textStatus ) {
                   

                    if (data.length == 0) {
                        check = 0;
                        alert("이름이나 휴대폰번호가 잘못됐습니다.");
                        
                    }else{
                        check = 1;
                        
                        if (data.length == 1) {
                            
                            $("#wr_id").val(data[0].wr_id);
                        }else{
                            
                            var $append_wr1 = "<input type='hidden' name='stx' value='"+cell+"'>";
                            
                            $("#wr_id").attr('name','sfl');
                            $("#wr_id").val('wr_1');

                            $("#stx").val(cell);

                            
                        }
                        
                  
                    }
                    
                
                },
                error: function( xhr, textStatus, errorThrown ) {
                    console.error( textStatus );
                }
        } );
        if (check==0) {
            return false;
        }else{
            return true;
        }
    }
</script>