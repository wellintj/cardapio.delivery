<!DOCTYPE html>
<?php
$defaultLang = site_lang() ?? 'en'; // Default language
$defaultDir = direction() ?? 'ltr'; // Default direction

if (!empty($id)) {
    $glang = glang($id);
    $lang = ($glang['is_glang'] ?? 0) == 1 ? ($glang['dlanguage'] ?? $defaultLang) : (isset($lang) && !empty($lang) ? $lang : $defaultLang);
    $dir = isset($lang) && !empty($lang) ? direction($lang) : $defaultDir;
} else {
    $lang = $defaultLang;
    $dir = $defaultDir;
}

// Output the HTML tag
?>
<html lang="<?= htmlspecialchars($lang, ENT_QUOTES, 'UTF-8'); ?>" dir="<?= htmlspecialchars($dir, ENT_QUOTES, 'UTF-8'); ?>">



<head>
    <?php $settings = settings(); ?>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <?php if (isset($seo)): ?>
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?= isset($seo['title']) ? html_escape($seo['title']) : ''; ?>" />
        <meta property="og:description" content="<?= isset($seo['description']) ? html_escape($seo['description']) : ''; ?>" />
        <meta property="og:url" content="<?= $seo['url'] ?? base_url(); ?>" />
        <meta name="keywords" content="">
    <?php else: ?>

        <?php if (isset($slug) && isset($id)) : ?>
            <?php $seo =  seo_settings($id); ?>
            <?php $logo = isset(restaurant($id)->thumb) ? restaurant($id)->thumb : $settings['logo']; ?>
            <meta property="og:type" content="article" />
            <meta property="og:title" content="<?= isset($seo['title']) ? html_escape($seo['title']) : ''; ?>" />
            <meta property="og:description" content="<?= isset($seo['description']) ? html_escape($seo['description']) : ''; ?>" />
            <meta property="og:url" content="<?= url($slug); ?>" />
            <meta name="keywords" content="<?= isset($seo['keywords']) ? html_escape($seo['keywords']) : ''; ?>">
            <meta property="og:image" content="<?= asset_url($logo) ?>" />
        <?php else : ?>
            <?php $seo =  isJson($settings['seo_settings']) ? json_decode($settings['seo_settings'], true) : ''; ?>
            <meta property="og:type" content="article" />
            <meta property="og:title" content="<?= isset($seo['title']) ? html_escape($seo['title']) : ''; ?>" />
            <meta property="og:description" content="<?= isset($seo['description']) ? html_escape($seo['description']) : ''; ?>" />
            <meta property="og:url" content="<?= base_url(); ?>" />
            <meta name="keywords" content="<?= isset($seo['keywords']) ? html_escape($seo['keywords']) : ''; ?>">
            <meta property="og:site_name" content="<?= isset($settings['site_name']) ? html_escape($settings['site_name']) : ''; ?>" />
            <meta property="og:image" content="<?= isset($settings['logo']) ? html_escape($settings['logo']) : ''; ?>" />
        <?php endif; ?>

    <?php endif; ?>

    <meta name="language_type" content="<?php echo $this->config->item('language_type'); ?>">
    <meta name="total_languages" content="<?php echo $this->config->item('total_languages'); ?>">
    <meta name="php_version" content="<?php echo phpversion() ?? ''; ?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= asset_url(); ?>assets/frontend/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= asset_url(); ?>assets/frontend/plugins/jquery-ui/jquery-ui.main.css">

    <?php if ($dir == 'rtl') : ?>
        <link rel="stylesheet" href="<?= asset_url() ?>assets/frontend/css/bootstrap-rtl.css?v=<?= $settings['version']; ?>&time=<?= time(); ?>">
    <?php endif ?>
    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Montserrat|Poppins|Josefin+Sans|Roboto+Condensed&display=swap" rel="stylesheet">


    <?php if (isset($settings['system_fonts']) && !empty($settings['system_fonts'])) : ?>
        <!-- google fonts -->
        <link href="https://fonts.googleapis.com/css?family=<?= $settings['system_fonts']; ?>&display=swap" rel="stylesheet">
        <!-- google fonts -->
    <?php endif; ?>

    <!-- slick slider -->
    <link rel="stylesheet" href="<?= asset_url(); ?>assets/frontend/plugins/slickSlider/slick.css">
    <link rel="stylesheet" href="<?= asset_url(); ?>assets/frontend/plugins/swiper/swiper.css" />
    <!-- slick slider -->


    <!-- animate css 3.7.2 -->
    <link rel="stylesheet" href="<?php echo asset_url(); ?>assets/frontend/plugins/animate/animate.css">
    <!-- animate -->

    <!-- lightbox css lightbox css 2.11.1 -->
    <link rel="stylesheet" href="<?php echo asset_url(); ?>assets/frontend/plugins/venobox/venobox.min.css">
    <link rel="stylesheet" href="<?php echo asset_url(); ?>assets/frontend/plugins/editableSelect/editableSelect.css">
    <!-- lightbox lightbox css 2.11.1-->

    <!--aos-animation -->
    <link rel="stylesheet" href="<?php echo asset_url(); ?>assets/frontend/plugins/animation/aos-animation.css">
    <!-- animate -->

    <!--intlinput -->
    <link rel="stylesheet" href="<?php echo asset_url(); ?>assets/frontend/plugins/country/intelinput.css">
    <!-- intlinput -->

    <!-- select2 style -->
    <link rel="stylesheet" href="<?= asset_url() ?>assets/admin/bower_components/select2/dist/css/select2.min.css">

    <!-- fontawsome 4.7 and 5.8.1 -->

    <link href="<?php echo asset_url(); ?>assets/frontend/icon6/css/all.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>assets/frontend/css/font-awesome-5.8.1.main.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>assets/frontend/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo asset_url(); ?>assets/frontend/css/icofont.css" rel="stylesheet">
    <!-- fontawsome 4.7 and 5.8.1 -->

    <!-- datetimepicker css -->

    <link rel="stylesheet" href="<?= asset_url() ?>assets/frontend/plugins/sweetalert/sweet-alert.css">
    <link rel="stylesheet" href="<?= asset_url(); ?>assets/frontend/plugins/datetime_picker/datetime.css">

    <!-- custom loader css -->
    <link rel="stylesheet" href="<?= asset_url(); ?>assets/frontend/plugins/loader.css?v=<?= $settings['version']; ?>&time=<?= time(); ?>">
    <!-- custom loader css -->



    <!-- custom css -->
    <link rel="stylesheet" href="<?= asset_url(); ?>assets/frontend/plugins/mockup/device-mockups.min.css">

    <link rel="stylesheet" href="<?= asset_url('public/frontend/css/item.css'); ?>?t=<?= time(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>public/frontend/css/frontend.css?v=<?= $settings['version']; ?>&time=<?= time(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>public/frontend/css/style.css?v=<?= $settings['version']; ?>&time=<?= time(); ?>">
    <link rel="stylesheet" href="<?= asset_url(); ?>public/reset.css?v=<?= $settings['version']; ?>&time=<?= time(); ?>">

    <!-- custom css -->





    <?php include 'pwa_header_config.php' ?>


    <!-- custom css -->
    <?php if (isset($settings['custom_css']) && !empty($settings['custom_css'])) : ?>
        <style>
            <?= $settings['custom_css'];
            ?>
        </style>
    <?php endif; ?>
    <!-- custom css -->

    <?php if (isset($id)) : ?>
        <?php $u_info = user_info_by_id($id); ?>


        <?php if (isset($u_info['menu_style']) && $u_info['menu_style'] == 3) : ?>
            <style>
                @media only screen and (max-width: 767px) {
                    .UserMobileMenu {
                        display: block !important;
                    }

                    .userMenu {
                        display: none !important;
                    }
                }
            </style>
        <?php else : ?>
            <style>
                @media only screen and (max-width: 767px) {
                    .userMenu {
                        display: block !important;
                    }

                    .allow-sm {
                        display: block
                    }

                    .UserMobileMenu,
                    .rightMenu {
                        display: none !important;
                    }
                }
            </style>
        <?php endif; ?>

        <style>
            :root {
                --dcolor: #<?= $u_info['colors']; ?>;
            }
        </style>

        <!-- custom css -->
        <link rel="stylesheet" href="<?= asset_url(); ?>public/frontend/css/default.php?themes=<?= $u_info['theme']; ?>&theme_color=<?= $u_info['theme_color']; ?>&color=<?= $u_info['colors']; ?>&t=<?= time(); ?>">
    <?php endif; ?>

    <?php if (isset($settings['system_fonts']) && !empty($settings['system_fonts'])) : ?>
        <link href="https://fonts.googleapis.com/css2?family=<?= $settings['system_fonts']; ?>:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?= asset_url(); ?>public/frontend/css/fonts.php?name=<?= $settings['system_fonts']; ?>">
    <?php endif; ?>

    <!-- responsive css -->
    <link rel="stylesheet" href="<?= asset_url(); ?>public/frontend/css/responsive.css?v=<?= $settings['version']; ?>&time=<?= time(); ?>">
    <!-- mobile order tracking enhancements -->
    <link rel="stylesheet" href="<?= asset_url(); ?>public/frontend/css/mobile-order-tracking.css?v=<?= $settings['version']; ?>&time=<?= time(); ?>">
    <!-- responsive css-->

    <?php if ($dir == 'rtl') : ?>
        <link rel="stylesheet" href="<?= asset_url() ?>public/frontend/css/custom_rtl.css?v=<?= $settings['version']; ?>&time=<?= time(); ?>">
    <?php endif ?>


    <link rel="icon" href="<?= !empty($settings['favicon']) ? asset_url(html_escape($settings['favicon'])) : ''; ?>" type="image/*" sizes="16x16">

    <?php if (isset($id)) : ?>
        <?php $seo =  seo_settings($id); ?>
        <title><?= !empty($seo['title']) ? $seo['title'] : (!empty($settings['site_name']) ? $settings['site_name'] : '') ?> |
            <?= isset($_title) && $_title != '' ? $_title : (isset($page_title) && $page_title != '' ? $page_title : ''); ?></title>
    <?php else : ?>
        <title><?= !empty($settings['site_name']) ? $settings['site_name'] : ''; ?> |
            <?= isset($_title) && $_title != '' ? $_title : (isset($page_title) && $page_title != '' ? $page_title : ''); ?></title>
    <?php endif; ?>

    <?php include 'pixel_analytics.php'; ?>

    <!-- google recaptcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= asset_url(); ?>assets/frontend/js/modernizr-3.5.0.min.js"></script>

    <script src="<?= asset_url(); ?>assets/frontend/js/jquery-3.4.1.min.js"></script>

    <script src="<?= asset_url() ?>assets/frontend/plugins/jquery-ui/jquery-ui.main.js"></script>


    <script src="<?php echo asset_url() ?>public/plugins/utilities.js?t=<?= time(); ?>"></script>



    <!-- admin onSignal Notification -->
    <?php if (isset($page) && $page == "Home") : ?>
        <?php $onesignal = !empty($settings['notifications']) ? json_decode($settings['notifications']) : ''; ?>

        <?php if (isset($onesignal->is_active_onsignal) && $onesignal->is_active_onsignal == 1) : ?>
            <?= $this->load->view('frontend/inc/onesignal_header', ['appID' => $onesignal->onsignal_app_id], true); ?>

        <?php endif; ?>
    <?php endif; ?>
    <!-- admin onSignal Notification -->

    <?php if (isset($id)) : ?>
        <?php $user_settings = $this->common_m->get_user_settings($id); ?>

        <?php if (is_feature($id, 'pwa-push') == 1 && is_active($id, 'pwa-push') && check() == 1) : ?>
            <!-- user onSignal Notification -->
            <?php $oneSignal = !empty($user_settings['onesignal_config']) ? json_decode($user_settings['onesignal_config']) : ''; ?>
            <?php if (isset($oneSignal->is_active_onsignal) && $oneSignal->is_active_onsignal == 1) : ?>

                <?= $this->load->view('frontend/inc/onesignal_header', ['appID' => $oneSignal->onsignal_app_id], true); ?>
                <!-- user onSignal Notification -->
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>


    <?php if (isset($page) && in_array($page, ['Home', 'Login'])) : ?>
        <?php include "custom_color.php"; ?>
    <?php endif; ?>

    <?php if (isset($settings['custom_js']) && !empty($settings['custom_js'])) : ?>
        <!-- custom js -->

        <?= $settings['custom_js']; ?>

        <!-- custom js -->
    <?php endif; ?>


</head>
<?php if (isset($id)) : ?>

    <?php $u_info = user_info_by_id($id); ?>
    <?php $user_settings = $this->common_m->get_user_settings($id); ?>

    <?php $shop_info = restaurant($id); ?>



    <script>
        let numberFormat = `<?= isset($shop_info->number_formats) ? $shop_info->number_formats : 0; ?>`;
        let currencyPosition = '<?= isset($shop_info->currency_position) ? $shop_info->currency_position : 1; ?>';
        let currencyIcon = '<?= $shop_info->icon; ?>';
        let shopId = '<?= $shop_info->id; ?>';
        let lang = '<?= $lang ?? shop_default_language($id); ?>';
        let returnPrice = 0;
        let _token = '<?= $this->security->get_csrf_hash(); ?>';
        let _baseUrl = '<?= asset_url(); ?>';

        function showPrice(price) {
            if (currencyPosition == 1) {
                returnPrice = currencyFormat(price) + ' ' + currencyIcon
            } else {
                returnPrice = currencyIcon + ' ' + currencyFormat(price);
            }
            return returnPrice;
        }

        function currencyFormat(price) {
            if (numberFormat == 0) {
                return parseFloat(price).toFixed(0)
            } else {
                return parseFloat(price).toFixed(2)
            }
        }
    </script>

    <body class="<?= isset($user_settings['site_theme']) && $user_settings['site_theme'] == 1 ? "theme-light" : "theme-dark" ?>">

        <?php if (isset($user_settings['preloader']) && $user_settings['preloader'] != 0) : ?>
            <div id="preloader">
                <div class="preloader_<?= $user_settings['preloader']; ?> loader_position"><span></span>
                    <span></span>
                </div>
            </div>
        <?php endif ?>
    <?php else : ?>

        <body class="<?= isset($settings['site_theme']) && $settings['site_theme'] == 2 ? "theme-dark" : "theme-light" ?>">
            <div id="preloader">
                <div class="preloader_1 loader_position"><span></span>
                    <span></span>
                </div>
            </div>
        <?php endif; ?>

        <div class="mainWrapper">