<div class="page_container">
	<form class="AppForm"  method="post" action="" id="frmRegisterAgent">
		<div class="login_box">
			<div class="next-logo">
				<div class="title-w-logo fl inline-block">Sign up</div>
				<div class="svg-logo-container fr inline-block">
					<img src="{$clsConfiguration->getValue('HeaderLogo')}"/>
				</div>
			</div>
			<div class="cleafix mb10"></div>
			<div class="admin-page form-horizontal">
				<h2 class="form-signin-heading"><i class="fa fa-user" aria-hidden="true"></i> </span>Profile Details </h2>
				<div class="row-fluid" style="margin-bottom: 20px;">All fields are mandatory </div>
				<div class="control-group">
					<label class="control-label">Title:</label>
					<div class="controls">
						<select name="iso-title" size="1">
							<option value="Mr">Mr</option>
							<option value="Mrs">Mrs</option>
							<option value="Ms">Ms</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Full Name:</label>
					<div class="controls">
						<input id="firstName" name="iso-full_name" type="text" class="ui-inputfield ui-inputtext ui-widget ui-state-default ui-corner-all" role="textbox" aria-disabled="false" aria-readonly="false" aria-multiline="false" value="{$oneProfile.full_name}" placeholder="click/tap to enter">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Phone Number:</label>
					<div class="controls">
						<input id="phone" name="iso-phone" type="text" class="ui-inputfield ui-inputtext ui-widget ui-state-default ui-corner-all" role="textbox" aria-disabled="false" aria-readonly="false" aria-multiline="false" value="{$oneProfile.phone}" placeholder="click/tap to enter">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Company Name:</label>
					<div class="controls">
						<input id="companyName" name="iso-organisation" type="text" class="ui-inputfield ui-inputtext ui-widget ui-state-default ui-corner-all" role="textbox" aria-disabled="false" aria-readonly="false" aria-multiline="false" value="{$oneProfile.organisation}" placeholder="click/tap to enter">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Address:</label>
					<div class="controls">
						<textarea id="address" name="iso-address" cols="20" rows="3" class="ui-inputfield ui-inputtextarea ui-widget ui-state-default ui-corner-all ui-inputtextarea-resizable" role="textbox" aria-disabled="false" aria-readonly="false" aria-multiline="true" placeholder="click/tap to enter">{$oneProfile.address}</textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">City:</label>
					<div class="controls">
						<input id="city" name="iso-city" type="text" class="ui-inputfield ui-inputtext ui-widget ui-state-default ui-corner-all" role="textbox" aria-disabled="false" aria-readonly="false" aria-multiline="false" placeholder="click/tap to enter">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Postal Code:</label>
					<div class="controls">
						<input id="postCode" name="iso-zipcode" type="text" class="ui-inputfield ui-inputtext ui-widget ui-state-default ui-corner-all" role="textbox" aria-disabled="false" aria-readonly="false" aria-multiline="false" placeholder="click/tap to enter">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Country:</label>
					<div class="controls">
						<select name="iso-country_id" class="slb slbfull form-control">
							<option value="">-- Select country --</option>								
								{section name=i loop=$lstCountry}									
							<option {if $oneProfile.country_id eq $lstCountry[i].country_id}selected="selected"{/if} value="{$lstCountry[i].country_id}">{$clsCountry->getTitle($lstCountry[i].country_id)}</option>								
								{/section}								
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">E-mail:</label>
					<div class="controls">
						<input id="email" name="iso-email" type="text" class="ui-inputfield ui-inputtext ui-widget ui-state-default ui-corner-all" role="textbox" aria-disabled="false" aria-readonly="false" aria-multiline="false" value="{$oneProfile.email}" placeholder="click/tap to enter">
					</div>
				</div>
				<p>
					<label style="width: 100%;">By signing up you agree to the <a href="/lp/terms-conditions-next-za" target="_blank">Terms and Conditions</a> </label>
				</p>
				<br>
				<div class="text-center">
					<input type="submit" name="j_idt71" value="Create a new account" class="btn login btn-success"/>
					<input type="hidden" name="submitAgent" value="submitAgent"/>
				</div>
			</div>
		</div>
	</form>
</div>

{literal}
<style type="text/css">
body.memberBody {
    background-color: #eee
}
.memberBody .page_container{background:rgba(0,0,0,0.5); padding:40px 0}
body.memberBody .login-form {
    background-image: url(img/next-bg.png);
    background-position: 25% 40%;
    background-repeat: no-repeat;
    min-height: 700px
}
body.memberBody .login_box {
    max-width: 500px;
    width: 100%;
    margin: 0 auto
}
.login_box .title-w-logo{font-size:36px; line-height:60px; color:#fff}
body.memberBody .reset-pass label {
    color: #636363
}
.form-horizontal {
    border: 1px solid #ccc;
    background-color: #fff;
    padding: 10px 10px 20px;
    vertical-align: bottom;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px
}
.form-horizontal .form-signin-heading {
    font-weight: 200;
    padding-left: 0;
    color: #666;
    margin: 10px 0 20px
}
.form-horizontal .control-label,
.form-horizontal label {
    text-align: left;
    font-size: 14px;
    margin-left: 20px;
    color: #666;
    font-weight: 200;
    width: 38%
}
.form-horizontal .control-group {
    border-bottom: 1px solid #ebebeb;
    margin-bottom: 10px
}
.form-horizontal .resetcontrols,
.form-horizontal .resetcontrols:focus,
.form-horizontal .resetcontrols:active {
    border: 1px solid #ccc;
    padding: 5px;
    color: #666;
    margin-bottom: 20px;
}
.form-horizontal .controls {
    border-left: 1px solid #ebebeb;
    padding-left: 10px;
    margin-bottom: 10px;
    margin-left: 40%
}
.form-horizontal input,
.form-horizontal input:focus {
    border-color: transparent;
    -moz-box-shadow: none;
    box-shadow: none;
    -webkit-box-shadow: none;
    -webkit-appearance: none;
    font-size: 16px;
    font-weight: 200
}

label {
    display: block;
    margin-bottom: 5px;
}
.form-horizontal .control-label {
    float: left;
    width: 160px;
    padding-top: 5px;
    text-align: right;
}
.form-horizontal select {
    width: 96%
}
.form-horizontal textarea {
    font-size: 16px;
    font-weight: 200;
    width: 90%
}
.form-horizontal a {
    color: #01b3e0
}
.form-horizontal .batch {
    color: #01b3e0;
    margin-right: 5px
}
.form-horizontal .btn.login {
    padding: 14px 12px;
    width: 80%;
    font-weight: 700;
    margin: 0 auto;
	line-height:16px; 
}
.form-horizontal button {
    font-size: 16px;
    font-weight: 700;
    text-transform: uppercase;
    text-shadow: none
}
.more-options {
    margin-top: 10px
}
.container-fluid {
    padding: 0
}

select, textarea, input[type=text], input[type=password], input[type=datetime], input[type=datetime-local], input[type=date], input[type=month], input[type=time], input[type=week], input[type=number], input[type=email], input[type=url], input[type=search], input[type=tel], input[type=color], .uneditable-input {
    display: inline-block;
    height: 20px;
    padding: 4px 6px;
    margin-bottom: 10px;
    font-size: 12px;
    line-height: 20px;
    color: #636363;
    vertical-align: middle;
}
.form-search input, .form-inline input, .form-horizontal input, .form-search textarea, .form-inline textarea, .form-horizontal textarea, .form-search select, .form-inline select, .form-horizontal select, .form-search .help-inline, .form-inline .help-inline, .form-horizontal .help-inline, .form-search .uneditable-input, .form-inline .uneditable-input, .form-horizontal .uneditable-input, .form-search .input-prepend, .form-inline .input-prepend, .form-horizontal .input-prepend, .form-search .input-append, .form-inline .input-append, .form-horizontal .input-append {
    display: inline-block;
    margin-bottom: 0;
    vertical-align: middle;
}
select, input[type=file] {
    height: 30px;
    line-height: 30px;
}
select {
    width: 220px;
    border: 1px solid #ccc;
    background-color: #fff;
}
textarea {
    height: auto;
}
</style>
{/literal}
