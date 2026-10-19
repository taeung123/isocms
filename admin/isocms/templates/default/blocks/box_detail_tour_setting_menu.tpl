<div class="box_title_trip_code">
    <h2 class="title_box p-b-30">{$core->get_Lang('Setting Menu')}</h2>
    <div class="form_option_tour">
        <div class="inpt_tour p-b-30">
            <p class="not_text_tour">{$core->get_Lang('setting menu detail')}</p>
            <div class="toolbar_setting_menu">
                <div class="action_tour" style="float: left;">
                    <a href="javascript:void(0);" id="add_more_setting_menu" data-toggle="modal" data-target="#myModal">{$core->get_Lang('Add more')}</a>
                </div>
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <h4 class="modal-title" id="myModalLabel">{$core->get_Lang('Add more menu')}</h4>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>