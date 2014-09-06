<!-- bootstrap Validator -->
<?php getImport('bootstrap-validator','dist/css/bootstrapValidator.min',false,'css')?>
<?php getImport('bootstrap-validator','dist/js/bootstrapValidator.min',false,'js')?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

<!-- favicon -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $g['s']?>/_core/images/ico/apple-touch-icon-144-precomposed.png">
<link rel="shortcut icon" href="<?php echo $g['s']?>/_core/images/ico/favicon.ico">


<div class="rb-root">
	<div id="rb-login">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h1 class="panel-title"><a href="<?php echo $g['r']?>/"><i class="kf-bi-01"></i></a> <small>Admin Mode</small></h1>
			</div>
			<div class="panel-body">
				<form class="loginForm" role="form" name="loginform" action="<?php echo $g['s']?>/" method="post" onsubmit="return loginCheck(this);">
					<input type="hidden" name="r" value="<?php echo $r?>" />
					<input type="hidden" name="m" value="site" />
					<input type="hidden" name="a" value="login" />
					<input type="hidden" name="referer" value="<?php echo $referer ? $referer : $_SERVER['HTTP_REFERER']?>" />
					<input type="hidden" name="usertype" value="admin" />

					<div class="form-group">
						<label for="id" class="control-label">Email or UserID </label>
						<input type="text" name="id"  class="form-control input-lg" id="id" placeholder="" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',0)?>" required>
					</div>

					<div class="form-group">
						<label for="pw" class="control-label">Password</label>
						<input type="password" name="pw" class="form-control input-lg" id="pw" placeholder="" value="<?php echo getArrayCookie($_COOKIE['svshop'],'|',1)?>" required>
					</div>

					<button type="submit" class="btn btn-primary">Log in</button>

					<div class="checkbox">
						<label>
							<input class="rb-confirm" type="checkbox" name="idpwsave" value="checked" <?php if($_COOKIE['svshop']):?> checked="checked"<?php endif?>>Remember me
						</label>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>


<!-- bootstrap Validator -->
<script>
$(document).ready(function() {
    $('.loginForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            id: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The Email or Username is required'
                    },
                    stringLength: {
                        min: 4,
                        max: 30,
                        message: 'The username must be more than 4 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            pw: {
                message: '패스워드가 일치하지 않습니다.',
                validators: {
                    notEmpty: {
                        message: 'The password is required and cannot be empty'
                    },
                    stringLength: {
                        min: 4,
                        max: 30,
                        message: 'The password must be more than 4 and less than 30 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'The password can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
        }
    });
});

$(document).ready(function() {
	document.loginform.id.focus();
	$('.rb-confirm').on('click', function() {
		bootbox.confirm("<div class='media'><i class='pull-left fa fa-exclamation-circle fa-4x hidden-xs'></i><div class='media-body'> <h4 class='media-heading'>로그인 정보를 저장하시겠습니까?</h4>로그인 정보를 저장할 경우 다음접속시 정보를 입력하지 않으셔도 됩니다.<br>그러나, 개인PC가 아닐 경우 타인이 로그인할 수 있습니다.<br>PC를 여러사람이 사용하는 공공장소에서는 체크하지 마세요.</div> </div>", function(res){
			document.loginform.idpwsave.checked = res;
		});
	});
});

function loginCheck(f)
{
	getIframeForAction(f);
	return true;
}
</script>

