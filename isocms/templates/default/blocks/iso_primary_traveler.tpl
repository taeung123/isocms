<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.7.0/build/js/intlTelInput.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.7.0/build/css/intlTelInput.min.css"
      rel="stylesheet">

<div class="iso_information_tour_item">
    <div class="title">
        {$core->get_Lang('Primary traveler')}
    </div>
    <div class="box_radio d-flex flex-column">
        <label for="primary_traveler_1_{$type_block}_{$_key}" class="payment_custom_radio">
            <input type="radio" class="iso_radio_item_primary" name="primary_traveler_{$type_block}_{$_key}" id="primary_traveler_1_{$type_block}_{$_key}" checked="true" value="close">
            {$core->get_Lang('The contact person is the main traveler')}.
            <span class="checkmark"></span>

        </label>
        <label for="primary_traveler_2_{$type_block}_{$_key}" class="payment_custom_radio">
            <input type="radio" class="iso_radio_item_primary" name="primary_traveler_{$type_block}_{$_key}" id="primary_traveler_2_{$type_block}_{$_key}" value="show">
            {$core->get_Lang('Other people')}
            <span class="checkmark"></span>

        </label>
    </div>
    <div class="box_primary_traveler_other iso_box_information">
        <div class="iso_item_body_tour iso_input_box">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="iso_input_box_item iso_box_item_primary_traveler">
                        <label>{$core->get_Lang('First name')} <span>*</span></label>
                        <input name="other_first_name_{$type_block}_{$_key}" placeholder="" type="text" class="form-booking_input"/>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="iso_input_box_item iso_box_item_primary_traveler">
                        <label>{$core->get_Lang('Last Name')} <span>*</span></label>
                        <input name="other_last_name_{$type_block}_{$_key}" placeholder="" type="text" class="form-booking_input"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="iso_input_box_item iso_box_item_primary_traveler">
                        <label>{$core->get_Lang('Date of birth')} <span>*</span></label>
                        <input type="text" name="other_birthday_{$type_block}_{$_key}" class="form-booking_input iso_book_birthday">
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="iso_input_box_item iso_box_item_primary_traveler">
                        <label>{$core->get_Lang('Gender')} <span>*</span></label>
                        <select name="other_gender_{$type_block}_{$_key}" class="form-booking_input iso_select2">
                            <option value="" disabled selected>---- {$core->get_Lang('Gender')} ----</option>
                            <option value="Male">{$core->get_Lang('Male')}</option>
                            <option value="Female">{$core->get_Lang('Female')}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="iso_input_box_item iso_box_item_primary_traveler">
                        <label>{$core->get_Lang('Email')} <span>*</span></label>
                        <input id="email" name="other_email_{$type_block}_{$_key}" placeholder="" type="email" class="form-booking_input" value="{if !empty($email)}{$email}{else}{$oneProfile.email|default:''}{/if}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="iso_input_box_item iso_box_item_primary_traveler">
                        <label>{$core->get_Lang('Country')} <span>*</span></label>
                        <select name="other_country_id_{$type_block}_{$_key}" class="form-booking_input iso_select2">
                            <option value="" disabled selected>---- {$core->get_Lang('Country')} ----</option>
                            {section name=i loop=$lstCountry}
                                <option value="{$lstCountry[i].country_id}">{$lstCountry[i].title}</option>
                            {/section}
                        </select>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="iso_input_box_item iso_box_item_primary_traveler">
                        <label>{$core->get_Lang('Phone number')} <span>*</span></label>
                        <input name="other_phone_{$type_block}_{$_key}" type="tel" id="phone" class="phonenumber form-booking_input">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
{literal}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $(function(){
            $(document).on('click', '.iso_information_booking .iso_radio_item_primary', function(){
                let show = $(this).val();
                let iso_information_tour_item = $(this).parents('.iso_information_tour_item');
                let iso_box_information = iso_information_tour_item.find('.iso_box_information');

                if(show == 'show'){
                    iso_box_information.slideDown();
                }else if(show == 'close'){
                    iso_box_information.slideUp();
                }
            });
        })
    })
   

</script> 
{/literal}
