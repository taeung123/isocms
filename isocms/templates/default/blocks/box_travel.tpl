<section class="headerBottom">
    <div class="container">
        <div class="row">
            <ul class="nav-silde center">
                <li class="travelAgent"><a href="/travel-agent.html">{$core->get_Lang('Travel Agent')}</a></li>
                <li class="hotLine"><a href="tel:{$clsConfiguration->getValue('CompanyPhone')}" title="Special Promotion">{$clsConfiguration->getValue('CompanyPhone')}</a></li>
                <li class="mail"><a href="emailto:{$clsConfiguration->getValue('CompanyEmail')}" title="Contact">{$clsConfiguration->getValue('CompanyEmail')}</a></li>
                <li><a href="{$extLang}/about/intro.html" title="{$core->get_Lang('aboutus')}">{$core->get_Lang('About us')}</a></li>
                <li><a href="{$extLang}/booking-conditions" title="{$core->get_Lang('Booking Conditions')}">{$core->get_Lang('Booking Conditions')}</a></li>
                <li><a href="{$clsISO->getLink('testimonial')}" title="{$core->get_Lang('Testimonials')}">{$core->get_Lang('Testimonials')}</a></li>
                <li><a href="{$extLang}/faqs.html" title="{$core->get_Lang('FAQs')}">{$core->get_Lang('FAQs')}</a></li>
                <li><a href="{$clsISO->getLink('feedback')}" title="{$core->get_Lang('contact')}">{$core->get_Lang('Contact')}</a></li>
            </ul>
        </div>
    </div>
</section>
