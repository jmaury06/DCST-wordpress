<?php
$ip = $_SERVER['REMOTE_ADDR'];
$geoPlugin = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $ip) );
$region = "US";
$country = "US";
if (isset($geoPlugin['geoplugin_countryCode']) && $geoPlugin['geoplugin_countryCode'] != null) {
  $country = $geoPlugin['geoplugin_countryCode'];
  /* United Kingdome */
  if ($geoPlugin['geoplugin_countryCode'] == 'GB') {
    $region = "UK";
  }
  /* In Europe */
  if ($geoPlugin['geoplugin_inEU'] == 1 ){
    $region = "EU";
  }
}
?>
<script>
geoplugin_starter = {US: '$39', UK: '£34', EU: '€39'};
geoplugin_event = {US: '$63', UK: '£53', EU: '€59'};
geoplugin_scale = {US: '$188', UK: '£159', EU: '€169'};
geoplugin_scale_monthly = {US: '$250', UK: '£212', EU: '€225'};
geoplugin_region = '<?php echo $region; ?>';
geoplugin_country = '<?php echo $country; ?>';
</script>

<?php if(flatsome_has_top_bar()['large_or_mobile']){ ?>
<div id="top-bar" class="header-top <?php header_inner_class('top'); ?>">
    <div class="flex-row container">
      <div class="flex-col hide-for-medium flex-left">
          <ul class="nav nav-left medium-nav-center nav-small <?php flatsome_nav_classes('top'); ?>">
              <?php flatsome_header_elements('topbar_elements_left'); ?>
          </ul>
      </div>

      <div class="flex-col hide-for-medium flex-center">
          <ul class="nav nav-center nav-small <?php flatsome_nav_classes('top'); ?>">
              <?php flatsome_header_elements('topbar_elements_center'); ?>
          </ul>
      </div>

      <div class="flex-col hide-for-medium flex-right">
         <ul class="nav top-bar-nav nav-right nav-small <?php flatsome_nav_classes('top'); ?>">
              <?php flatsome_header_elements('topbar_elements_right'); ?>
          </ul>
      </div>

      <?php if(get_theme_mod('header_mobile_elements_top')) { ?>
      <div class="flex-col show-for-medium flex-grow">
          <ul class="nav nav-center nav-small mobile-nav <?php flatsome_nav_classes('top'); ?>">
              <?php flatsome_header_elements('header_mobile_elements_top'); ?>
          </ul>
      </div>
      <?php } ?>

    </div>
</div>
<?php } ?>
