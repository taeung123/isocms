{if $profile_id ne ''}
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{$clsProfile->getEmail($profile_id)}
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a role="menuitem"href="{$PCMS_URL}profile/my-profile.html" rel="nofollow">My Profile</a> </li>	
    <li><a role="menuitem"href="{$PCMS_URL}profile/my-profile.html" rel="nofollow">My Profile</a> </li>	
    <li><a role="menuitem"href="{$PCMS_URL}profile/my-profile.html" rel="nofollow">My Profile</a> </li>
	<li><a role="menuitem"href="{$PCMS_URL}profile/logout.html" rel="nofollow"> Logout</a> </li>	
  </ul>
</div>

{else}
<ul class="quick-nav navbar-right">	
 	<li><a class="signin_head" href="{$PCMS_URL}profile/sign-in.html" rel="nofollow"><i class="fa fa-user" aria-hidden="true"></i> Sign In</a></li>
	<li><a class="signin_head" href="{$PCMS_URL}profile/register.html" rel="nofollow"> <i class="fa fa-user" aria-hidden="true"></i> Sign Up</a></li>
</ul>
{/if}