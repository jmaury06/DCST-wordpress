jQuery(function () {

    const countries = [
        { id: 'usd', text: 'USD - $', flag: 'https://pricing-dc-www-wordpress-prod.pantheonsite.io/wp-content/uploads/2021/01/USA.png' },
        { id: 'eur', text: 'EUR - €', flag: 'https://pricing-dc-www-wordpress-prod.pantheonsite.io/wp-content/uploads/2021/01/EURO.png' },
        { id: 'gbp', text: 'GBP - £', flag: 'https://pricing-dc-www-wordpress-prod.pantheonsite.io/wp-content/uploads/2021/01/UK.png' },
    ]

    jQuery('.check-plan-details .link').on('click', (e) => {
        jQuery(e.target).toggleClass('show');
        jQuery('.table-container').toggleClass('show');
    })


    jQuery('#tab2').change(function () {
        if (this.checked) {
            jQuery('.check-plan-details .link p  ').removeClass('show');
            jQuery('.table-container').removeClass('show');
        }
    });

    function formatState(state) {
        if (!state.id) {
            return state.text;
        }
        let country = countries.find(e => e.id === state.id)
        var $state = jQuery(
            '<span style="position: relative;display: flex;align-items: center;justify-content: space-evenly;max-height: 38px;"><img src="' + country.flag + '" class="img-flag"  /> <p style="margin:0 !important;"><strong>' + country.text + '</strong><p></span>'
        );
        return $state;
    };

    jQuery('.currencies-drop').select2({
        width: '150px',
        templateResult: formatState,
        templateSelection: formatState,
        minimumResultsForSearch: Infinity
    });

    function geoplugin_change_price(to) {
        jQuery('.geoplugin_price.geoplugin_starter').html(geoplugin_starter[to]);
        jQuery('.geoplugin_price.geoplugin_event').html(geoplugin_event[to]);
        jQuery('.geoplugin_price.geoplugin_scale').html(geoplugin_scale[to]);
        jQuery('.geoplugin_price.geoplugin_scale_monthlyr').html(geoplugin_scale_monthly[to]);
    }

    jQuery('.currencies-drop').on('change', function(){
        newval = jQuery('.currencies-drop').children("option:selected").val();
        geoplugin_region = 'US';
        if(newval == "usd"){
            geoplugin_region = 'US';
        }
        if(newval == "eur"){
            geoplugin_region = 'EU';
        }
        if(newval == "gbp"){
            geoplugin_region = 'UK';
        }
        geoplugin_change_price(geoplugin_region);
    });

});
