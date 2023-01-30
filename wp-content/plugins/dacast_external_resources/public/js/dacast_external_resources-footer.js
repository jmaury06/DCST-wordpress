/**
* All of the external code for your public-facing JavaScript source
* should reside in this file.
*/

/* Adroll Pixel for https://www.dacast.com */
adroll_adv_id = "VTUV44MIRRBWTODM6VF6HO";
adroll_pix_id = "HAEXSL4RYVETDMRFS4FHIG";

(function () {
if (!window.__adroll_loaded){
var scr = document.createElement("script");
var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
scr.setAttribute('async', 'true');
scr.type = "text/javascript";
scr.src = host + "/j/roundtrip.js";
((document.getElementsByTagName('head') || [null])[0] ||
document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
}
}());

/* Zendesk Widget for https://www.dacast.com */
(function(z,e){
    n=e.getElementsByTagName('head')[0];
    d=e.createElement('script');d.async=1;
    d.src='https://static.zdassets.com/ekr/snippet.js?key=3a0de42e-c180-4bd1-b691-86cf01057c99';
    d.id='ze-snippet';
    n.appendChild(d);
})(window,document);

/* Linkedin px for https://www.dacast.com */
_linkedin_partner_id = "2483980";
window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
window._linkedin_data_partner_ids.push(_linkedin_partner_id);
(function(){
    var s = document.getElementsByTagName("script")[0];
    var b = document.createElement("script");
    b.type = "text/javascript";b.async = true;
    b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
    s.parentNode.insertBefore(b, s);
})();
