<link rel="stylesheet" type="text/css" href="{$URL_CSS}/member.css" />
<div id="container">
    <div class="wrap">
    	<section class="leftPage">
        	{$core->getBlock('left_member')}
        </section>
    	<section class="rightPage">
        	<h1 class="headMod">Change your <span class="refRed">avatar</span></h1>
            <p class="informationMessage">{if $message eq 'success'}Change avatar successful !{else}* Required field{/if}</p>
            <br />
            <h3 class="head-lead">Account Information</h3>
            {if $msg ne ''}
            <p class="message">
                {$msg}
            </p>
            {/if}
            <div class="acount-box">
                <form method="post" name="form" enctype="multipart/form-data">
                     <table class="tblavatar">
                        <tr>
                            <td style="vertical-align:top">
                            	<h3>Submit new avatar</h3>
                                <p class="notice">Screen represent to have the format: jpg, gif, png. Size <2MB</p>
                            	<input type="file" size="50" name="avatar" />
                                <div class="acount-line" style="margin-top:10px;">
                                    <input type="submit" class="sumbitVal" value="Submit" />
                                    <input type="hidden" value="ChangeAvata" name="Update" />
                                 </div>
                            </td>
                            <td width="220px">
                            </td>
                        </tr>
                     </table>
                 </form>
            </div>
        </section>
    </div>
</div>
