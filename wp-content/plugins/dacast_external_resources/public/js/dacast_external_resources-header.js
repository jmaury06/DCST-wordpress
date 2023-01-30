/**
 * All of the external code for your public-facing JavaScript source
 * should reside in this file.
 */

/*  Hotjar Tracking Code for https://www.dacast.com */
(function(h,o,t,j,a,r){
    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
    h._hjSettings={hjid:1350928,hjsv:6};
    a=o.getElementsByTagName('head')[0];
    r=o.createElement('script');r.async=1;
    r.src='https://static.hotjar.com/c/hotjar-1350928.js';
    a.appendChild(r);
})(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');


/* Facebook Pixel for https://www.dacast.com */
!function (f, b, e, v, n, t, s) {
    if (f.fbq) return; n = f.fbq = function () {
        n.callMethod ?
            n.callMethod.apply(n, arguments) : n.queue.push(arguments)
    };
    if (!f._fbq) f._fbq = n; n.push = n; n.loaded = !0; n.version = '2.0';
    n.queue = []; t = b.createElement(e); t.async = !0;
    t.src = v; s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s)
}(window, document, 'script',
    'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1567436020218843');
fbq('track', 'PageView');

/* Google Analytics for https://www.dacast.com */
/*
(function(g,o){
    l=o.getElementsByTagName('head')[0];
    e=o.createElement('script');e.async=1;
    e.src='https://www.googletagmanager.com/gtag/js?id=UA-18770221-1';
    l.appendChild(e);
    g.dataLayer = g.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}gtag('js', new Date());
    gtag('config', 'UA-18770221-1');
})(window,document);
*/
window._cloudAmp = window._cloudAmp || {};
_cloudAmp.forms = [];
(function () {
    var scripts = document.getElementsByTagName('script'),
    sLen = scripts.length,
    ca_script = document.createElement('script'),
    head = document.getElementsByTagName('head'),
    protocol = document.location.protocol,
    httpsDomain = '1d5ef9e9369608f625a8-878b10192d4a956595449977ade9187d.ssl.cf2.rackcdn.com',
    httpDomain = 'trk.cloudamp.net',
    filename = 'ctk.js',
    srcDomain = protocol === 'http:' ? httpDomain : httpsDomain;
    ca_script.type = 'text/javascript';
    ca_script.async = true;
    if  ( protocol === "http:" ) {
        ca_script.src = 'http://trk.cloudamp.net/ctk.js';
    } else {
        ca_script.src = 'https://1d5ef9e9369608f625a8-878b10192d4a956595449977ade9187d.ssl.cf2.rackcdn.com/ctk.js';
    }
    head[0].appendChild(ca_script);
})();
