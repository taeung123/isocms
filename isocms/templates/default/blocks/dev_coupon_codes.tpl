<section class="code_coupon py-5">
    <div class="container">
        <h2 class="txt_coupon mb-4">{$core->get_Lang('Collect coupon codes')}</h2>
        <div class="row">
            <div class="owl-carousel owl-theme owl_couponcode">
                {section name =c loop = 5}
                    <div class="border_coupon">
                        <div class="coupon_content">
                            <div class="coupon_text">
                                <p class="coupon_text h5">Special Discount</p>
                                <p class="coupon_txt2">100% discount up to 100,000 VND, minimum transaction 1m...</p>
                            </div>
                            <div class="coupon_code_container">
                                <div class="code_couponcopy d-flex align-items-center">
                                    <p class="coupon_code mb-0 me-2">Code:</p>
                                    <p class="code_cpo mb-0">KHACHMOIISOCMS</p>
                                    <button class="copy_btn btn btn-outline-secondary ms-2"
                                            onclick="copyCode('KHACHMOIISOCMS', this)">
                                        <i class="fa-regular fa-copy"></i>
                                    </button>
                                    <span id="copiedText1" class="copied ms-2" style="display: none;">Copied</span>
                                </div>
                            </div>
                        </div>
                    </div>
                {/section}
            </div>
        </div>
    </div>
</section>