{section name=i loop=$listTopTour}
	{assign var=tour_id value=$listTopTour[i].tour_id}
	{$clsISO->getBlock('box_item_tourprofessional',["tour_id"=>$tour_id])}
{/section}