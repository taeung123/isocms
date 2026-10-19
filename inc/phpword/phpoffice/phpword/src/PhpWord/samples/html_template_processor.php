<?php
/*${htmlblock}
${html}
${/htmlblock}*/
$html = '<ul>
		<li>
			<span style="font-family: arial,helvetica,sans-serif;">
				<span style="font-size: 12px;">list item1</span>
			</span>
		</li>
		<li>
			<span style="font-family: arial,helvetica,sans-serif;">
				<span style="font-size: 12px;">list item2</span>
			</span>
		</li>
	</ul>';
$html = '<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="color:#FF0000; font-size:22px" width="120">With:</td>
		<td style="color:#800000; font-size:14px"><strong>clsCompany->getName(oneQuote[company_id])</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="color:#800000; font-size:11px;text-decoration: underline;text-transform: uppercase"><strong>Trip infomation:</strong></td>
		<td></td>
	</tr>
	<tr>
		<td>TourCode:</td>
		<td>oneQuote[quote_code]</td>
	</tr>
	<tr>
		<td>TourName:</td>
		<td style="color:#800000; font-size:14px"><strong>oneQuote[title]</strong></td>
	</tr>
	<tr>
		<td>Groupsize:</td>
		<td>oneQuote[pax] Adult oneQuote[child] Child</td>
	</tr>
	<tr>
		<td>Room Requested:</td>
		<td>No</td>
	</tr>
	<tr>
		<td>Sales:</td>
		<td><strong>clsUser->getFullName(oneQuote[user_id])</strong></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td>clsUser->getEmail(oneQuote[user_id])</td>
	</tr>
	<tr>
		<td>Skype:</td>
		<td>clsUser->getoneField(skype,oneQuote[user_id])</td>
	</tr>
	<tr>
		<td style="color:#800000;font-weight: bold;">Urgent Contact:</td>
		<td><strong>clsUser->getPhone(oneQuote[user_id])</strong></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>';
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection();

\PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
// get elements in section
$containers = $section->getElements();
// clone the html block in the template
//$templateProcessor->cloneBlock('htmlblock', 0, true, false, $containers);
//$htmlblock = $templateProcessor->cloneBlock('htmlblock', count($containers), true, true);
//$htmlblock = $templateProcessor->cloneBlock('block_name', count($containers), true, true);
$htmlblock = $templateProcessor->cloneBlock('htmlblock', count($containers), true, true);
// replace the variables with the elements
for($i = 0; $i < count($containers); $i++) {

	// be aware of using setComplexBlock
	// and the $i+1 as the cloned elements start with #1
	$templateProcessor->setComplexBlock('html#' . ($i+1), $containers[$i]);
}
?>