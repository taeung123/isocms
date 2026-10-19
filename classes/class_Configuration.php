<?php
class Configuration extends DbBasic
{
	function __construct()
	{
		$this->pkey = "setting";
		$this->tbl = DB_PREFIX . "configuration";
	}
	function getValue($key = 0)
	{
		global $dbconn;
		$sql = "select * from " . $this->tbl . " where setting='$key'";
		$lst = $dbconn->GetAll($sql);
		if (isset($lst[0]['setting']))
			if ($lst[0]['setting'] == $key) return $lst[0]['value'];
		return '';
	}
	function getValueAutoInfo($key = 0)
	{
		global $dbconn, $_LANG_ID;
		$sql = "select * from " . $this->tbl . " where setting='$key'";
		$lst = $dbconn->GetAll($sql);

		if (!empty($lst)) {
			$value = $lst[0]['setting'] == $key ? $lst[0]['value'] : '';

			$value = str_replace('[%COMPANY_EMAIL%]', $this->getValue('CompanyEmail'), $value);
			$value = str_replace('[%COMPANY_NAME%]', $this->getValue('CompanyName'), $value);
			$value = str_replace('[%COMPANY_ADDRESS%]', $this->getValue('CompanyAddress_' . $_LANG_ID), $value);
			$value = str_replace('[%COMPANY_PHONE%]', $this->getValue('CompanyPhone'), $value);
			$value = str_replace('[%COMPANY_HOTLINE%]', $this->getValue('CompanyHotline'), $value);
			$value = str_replace('[%COMPANY_FAX%]', $this->getValue('CompanyFax'), $value);
			$value = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $value);
			$value = str_replace('[%info_license%]', $this->getValue('GPKD'), $value);
			$value = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $value);

			return $value;
		}


		return '';
	}
	function getImageValue($key = 0)
	{
		global $dbconn, $clsISO;

		$sql = "select * from " . $this->tbl . " where setting='$key'";
		$lst = $dbconn->GetAll($sql);
		if (isset($lst[0]['setting'])) {
			if ($lst[0]['setting'] == $key) {
				$url_image = $lst[0]['value'];
				return $clsISO->tripslashUrl($url_image);
			} else {
				return '';
			}
		}
	}
	function getImage($key = 0, $w = 0, $h = 0)
	{
		global $dbconn, $_CONFIG, $clsISO;
		$sql = "select * from " . $this->tbl . " where setting='$key'";
		$lst = $dbconn->GetAll($sql);
		$noimage = URL_IMAGES . '/noimage.png';
		if (isset($lst[0]['setting']))
			if ($lst[0]['setting'] == $key)
				$image = $lst[0]['value'];
		return $clsISO->tripslashImage($image, $w, $h);
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function updateValue($key = 0, $val = 0)
	{
		global $dbconn;
		$sql = "select setting from " . $this->tbl . " where setting='$key'";
		$lst = $dbconn->GetAll($sql);
		if ($lst[0]['setting'] == $key) {
			$this->updateByCond("setting='$key'", "value='" . addslashes($val) . "'");
		} else {
			$this->insertOne("setting,value", "'$key','" . addslashes($val) . "'");
		}
		return '';
	}

	function getHTMLSocial()
	{
		global $clsConfiguration, $_LANG_ID;
		$html = '<table class="table-mce" align="left" style="width: auto; border: 0">
          <tbody>
            <tr>';
		if ($clsConfiguration->getValue('Facebook_Link')) {
			$html .= '<td style="padding: 0px 5px; border: 0">
                  <a style="-webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; display: inline-block; background-color: #c5c5c5;height: 30px; width: 30px;" title="Facebook" role="social-icon-link" href="https://www.facebook.com/' . $clsConfiguration->getValue('SiteFacebookLink') . '" target="_blank" rel="noopener" data-nolink="false"> 
                      <img style="height: 30px; width: 30px;" title="Facebook" role="social-icon" src="https://www.vietiso.com/isocms/skin/images/social/facebook.png" alt="Facebook" width="30" height="30"> 
                  </a>
              </td>';
		}
		if ($clsConfiguration->getValue('Twitter_Link')) {
			$html .= '<td style="padding: 0px 5px; border: 0">
                  <a style="-webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; display: inline-block; background-color: #c5c5c5;height: 30px; width: 30px;" title="Twitter" role="social-icon-link" href="https://www.twitter.com/' . $clsConfiguration->getValue('SiteTwitterLink') . '" target="_blank" rel="noopener" data-nolink="false"> 
                      <img style="height: 30px; width: 30px;" title="Twitter" role="social-icon" src="https://www.vietiso.com/isocms/skin/images/social/twitter.png" alt="Twitter" width="30" height="30"> 
                  </a>
              </td>';
		}
		if ($clsConfiguration->getValue('Instagram_Link')) {
			$html .= '<td style="padding: 0px 5px; border: 0">
                  <a style="-webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; display: inline-block; background-color: #c5c5c5;height: 30px; width: 30px;" title="Instagram" role="social-icon-link" href="https://www.instagram.com/' . $clsConfiguration->getValue('SiteInstagramLink') . '" target="_blank" rel="noopener" data-nolink="false"> 
                      <img style="height: 30px; width: 30px;" title="Instagram" role="social-icon" src="https://www.vietiso.com/isocms/skin/images/social/instagram.png" alt="Instagram" width="30" height="30" > 
                  </a>
              </td>';
		}
		if ($clsConfiguration->getValue('Pinterest_Link')) {
			$html .= '<td style="padding: 0px 5px; border: 0">
                  <a style="-webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; display: inline-block; background-color: #c5c5c5;height: 30px; width: 30px;" title="Pinterest " role="social-icon-link" href="https://www.pinterest.com/' . $clsConfiguration->getValue('SitePinterestLink') . '" target="_blank" rel="noopener" data-nolink="false"> 
                      <img style="height: 30px; width: 30px;" title="Pinterest " role="social-icon" src="https://www.vietiso.com/isocms/skin/images/social/pinterest.png" alt="Pinterest" width="30" height="30"> 
                  </a>
              </td>';
		}
		if ($clsConfiguration->getValue('Linkedin_Link')) {
			$html .= '<td style="padding: 0px 5px; border: 0">
                  <a style="-webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px; display: inline-block; background-color: #c5c5c5;height: 30px; width: 30px;" title="LinkedIn " role="social-icon-link" href="https://www.linkedin.com/' . $clsConfiguration->getValue('SiteLinkedinLink') . '" target="_blank" rel="noopener" data-nolink="false"> 
                      <img style="height: 30px; width: 30px;" title="LinkedIn " role="social-icon" src="https://www.vietiso.com/isocms/skin/images/social/linkedin.png" alt="LinkedIn" width="30" height="30"> 
                  </a>
                </td>';
		}
		$html .= '</tr>
          </tbody>
        </table>';
		return $html;
	}
	function getLinkVideo()
	{
		global $dbconn, $_LANG_ID;
		return str_replace("https://www.youtube.com/watch?v=", "", $this->getValue('CompanyVideoYoutube_' . $_LANG_ID));
	}
	function getLinkFaceBookMessager()
	{
		global $dbconn, $_LANG_ID;
		return str_replace("https://www.facebook.com/", "", $this->getValue('SiteFacebookLink'));
	}
	function getCopyRight()
	{
		global $dbconn, $_LANG_ID;
		return str_replace("[%YEAR%]", date('Y'), $this->getValue('Copyright_' . $_LANG_ID));
	}
}
