<div class="section-faq">
  <h2>Frequently Asked Questions</h2>
  <div class="accordion-faq">
    <div class="accordion-item-faq">
      <button id="accordion-button-1" aria-expanded="false"><span class="accordion-title-faq">What is the advanced video hosting platform?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>Our advanced video hosting platform is a perfect solution for businesses with large video library. Access a more powerful CMS and other nice video features such as video delivery in China and AES security. This platform is available if you have a Dacast Premium or Enterprise active plan. If you are not a Dacast user yet, you can purchase both at the same time. More details HERE.</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-2" aria-expanded="false"><span class="accordion-title-faq">What is the difference between the Dacast platform and the advanced video hosting platform?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>The Dacast online video platform provides all the features you need for live streaming and video hosting but it is more specialized in live streaming. The advanced video hosting platform is more specialized for video hosting. You can purchase access to this platform when you are on a Dacast Premium or Enterprise plan. More details HERE.</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-3" aria-expanded="false"><span class="accordion-title-faq">Does bandwidth roll over on monthly plans?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>Yes. All extra bandwidth not used to stream video or audio will roll over to the next month. This bandwidth will continue to roll over until used or until the monthly plan is canceled.</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-4" aria-expanded="false"><span class="accordion-title-faq">Are there any startup fees?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>No. There are no startup fees when using any of the pricing plans at Dacast.</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-5" aria-expanded="false"><span class="accordion-title-faq">How do storage fees work?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>Dacast offers a generous amount of storage for all accounts. If you go over the amount for the Starter and Pro options then you will be charged $0.15 per GB every month.</p>
        <p>Event plans are a little different. This is charged $0.15 per GB over the limit, but needs to be pre-purchased rather than billed afterward.</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-5" aria-expanded="false"><span class="accordion-title-faq">How are viewer hours calculated?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>Viewer hours assuming streaming at 750kbps as the overall video-audio quality.</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-5" aria-expanded="false"><span class="accordion-title-faq">If I sign up for a monthly fee, how long am I locked into that plan?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>All monthly plans require a three month minimum if paid month-to-month.</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-5" aria-expanded="false"><span class="accordion-title-faq">Does my bandwidth expire?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>Yes, all bandwidth expires 12 months after you first got it. So event pricing bandwidth expires a year after its original purchase. This also works for monthly plans. For example, if you signed up for a monthly plan in January, the first month of bandwidth would expire in 12 months, while your second month of bandwidth would expire in 12 months after you got it (so February of the next year).</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-5" aria-expanded="false"><span class="accordion-title-faq">After the first three months, how am I charged?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>After the initial prepaid three months, you are charged on a month-to-month basis. This charge will be reflected on the source used for purchase. For example, if you paid by credit card for a Starter plan on January 5th then it will be charged for $25 on the fourth month on the 5th of that month.</p>
        <p>Recurring charges are automatic, but accounts can be canceled at any time by submitting a ticket from your Dacast account, including prior to the prepaid months expiring to stop the recurring charges. If you cancel during your prepaid period, service will continue up until the business day before you would be charged.</p>
      </div>
    </div>
    <div class="accordion-item-faq">
      <button id="accordion-button-5" aria-expanded="false"><span class="accordion-title-faq">What if I go over my total bandwidth on my account?</span><span class="icon-faq" aria-hidden="true"></span></button>
      <div class="accordion-content-faq">
        <p>Either your streams will shut off, or you can enable overage protection which will charge at $0.25 a GB for each that you go over.</p>
        <p>Overage protection is an optional feature, and when enabled will activate when you go over your monthly allotment of bandwidth and don’t have any rollover bandwidth remaining. In this instance, your overage protection will kick in and the selected payment method, such as a credit card, will be drawn from for the specific amount automatically.</p>
        <p>If you don’t have overage protection set up and would like to, click PURCHASE in the upper right and enable it.</p>
      </div>
    </div>
  </div>

    <p class="faq-contact">Have more questions? <a href="https://www.dacast.com/contact">Contact Us</a></p>

</div>

<script>
    const items = document.querySelectorAll(".accordion-faq button");

    function toggleAccordion() {
    const itemToggle = this.getAttribute('aria-expanded');
    
    for (i = 0; i < items.length; i++) {
        items[i].setAttribute('aria-expanded', 'false');
    }
    
    if (itemToggle == 'false') {
        this.setAttribute('aria-expanded', 'true');
    }
    }

    items.forEach(item => item.addEventListener('click', toggleAccordion));
</script>