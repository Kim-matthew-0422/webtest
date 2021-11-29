<div id="foot">
  <script>
function toggle(layer_id, opt)
{
var layer = document.getElementById(layer_id);

if (opt == "view"){
  layer.style.display = "block";
  document.fhead.mb_id.focus();
}else if(opt == "hide")
  layer.style.display = "none";
}

function fhead_submit(f)
{
  if (!f.mb_id.value) {
      alert("회원아이디를 입력하십시오.");
      f.mb_id.focus();
      return false;
  }

  if (!f.mb_pass.value) {
      alert("패스워드를 입력하십시오.");
      f.mb_pass.focus();
      return false;
  }

  f.action = 'https://isiskorea.com/member/login.php';
  return true;
}
</script>
<!-- 로그인 전 외부로그인 시작 -->
<form name="fhead" method="post" onsubmit="return fhead_submit(this);" style="margin:0;padding:0; z-index:200;">
<input type="hidden" name="URL" value="main">
<input type="hidden" name="mode" value="Login">
<div class="divbox" id="box" style="display:none;">
  <div class="login_center">
    <div id="p_input">
      <ul>
        <li class="mgB5">
          <span class="label">ID</span> <input name="mb_id" value="ID" type="text" maxlength="20" onmouseover="this.focus;" onFocus="this.value='';" tabindex='1' class="text">
        </li>
        <li style="margin-top:4px; ">
          <span class="label">PASSWORD</span> <input type="password" name="mb_pass" value="" maxlength="12" onmouseover="this.focus;" onFocus="this.value='';" class="text"  tabindex='2'>
        </li>
      </ul>
    </div>
  </div>
  <div class="login_foot">
    <input type="submit" class="button btn_red" value="LOGIN" onClick=''>&nbsp;
    <input type="button" class="button btn_black rebod" value="CANCEL" onClick="javascript:toggle('box', 'hide');" />
  </div>
</div>
</form>

<div class="footWrap">
 <div class="inner">
  <ul class="f_util">
    <li><a href="https://isiskorea.com/eng/member/privacy.php" title = "read up on our private privacy">Privacy Policy</a></li>
    <li><a href="bbs/boardca79" title = "get quotes page">Get quotes</a></li>
    <li><a href="aboutus" title = "About us page">About IMtranslation</a></li>
  </ul>
  <address>
    <div class="pct">
      <span>IMtranslation, Inc. By ISiS Korea.</span>
      <span>CEO : Jang Seok-Keun</span>
      <span>Address : 3F, Jiho Bldg., 30, Bangbaejungang-ro, Seocho-gu, South Korea</span>
      <span>TEL : +82-2-3787-0111</span>
      <span>E-mail : Lion@ISiSkorea.com&nbsp; / &nbsp;Lion@imtranslation.com</span>
    </div>
    <div class="mobile">
      <span>ISiS Korea, Inc.</span>
      CEO : Jang Seok-Keun
      <br />
      Address : 3F, Jiho Bldg., 30, Bangbaejungang-ro, Seocho-gu, South Korea
      <br />
      <span>TEL : +82-2-3787-0111</span><br />
      E-mail : Lion@ISiSkorea.com&nbsp; / &nbsp;Lion@imtranslation.com
    </div>
  </address>
  <p class="copy">
    COPYRIGHT(C) ISIS Korea. ALL RIGHTS RESERVED. <!--DESIGN BY <a href="http://way21.co.kr" target="_way21">WAY21</a>-->
    <span class="secret">
              <a href="javascript:toggle('box', 'view');" title = "It's a secret">
              <img src="/images/common/icon/icon_secret_sub.png" alt="Skill to transform words with insight and technology" class="imgC" /></a>
    </span>
  </p>
  </div>
</div>    		</div>
