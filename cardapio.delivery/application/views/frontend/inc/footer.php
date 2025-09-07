            </div><!-- mainWrapper -->
            </div>
            </div>
            </div>
            <a href="<?php echo asset_url() ?>" id="base_url"></a>
            <a href="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>
            <?php $country_info = get_country(!empty($settings['country_id']) ? $settings['country_id'] : 15); ?>
            <a href="<?= $country_info['code']; ?>" id="code"></a>
            <a href="<?= $country_info['dial_code']; ?>" id="dial_code"></a>
            <a href="<?= !empty(lang('yes')) ? lang('yes') : "Yes"; ?>" id="yes"></a>
            <a href="<?= !empty(lang('no')) ? lang('no') : "No"; ?>" id="no"></a>
            <a href="<?= !empty(lang('cancel')) ? lang('cancel') : "cancel"; ?>" id="cancel"></a>
            <a href="<?= !empty(lang('are_you_sure')) ? lang('are_you_sure') : "are you sure"; ?>" id="are_you_sure"></a>
            <a href="<?= !empty(lang('success')) ? lang('success') : "Success"; ?>" id="success"></a>
            <a href="<?= !empty(lang('warning')) ? lang('warning') : "Warning"; ?>" id="warning"></a>
            <a href="<?= !empty(lang('error')) ? lang('error') : "error"; ?>" id="error"></a>
            <a href="<?= !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful'; ?>" id="success_msg"></a>
            <a href="<?= !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!'; ?>" id="error_msg"></a>

            <!-- ==========
         Default Js
         =============== -->


            <script src="<?= asset_url(); ?>assets/frontend/js/popper.min.js" defer="true"></script>
            <script src="<?= asset_url(); ?>assets/frontend/js/bootstrap.min.js" defer="true"></script>
            <?php if (direction() == 'rtl') : ?>
                <link rel="stylesheet" href="<?= asset_url() ?>assets/frontend/js/bootstrap-rtl.js" defer="true">
                <a href="javascript:;" data-id="rtl" id="rtl"></a>
            <?php endif ?>
            <?php if (isset($id)) : ?>
                <script>
                    let shop_id = `<?= @restaurant($id)->id; ?>`;
                </script>

                <a href="javascript:;" data-id="<?= is_xs($id); ?>" id="is_xs"></a>
            <?php endif; ?>
            <!-- ==========
        End Default Js
        =============== -->

            <!-- parallax -->
            <script src="<?= asset_url() ?>assets/frontend/plugins/jstars.js" defer="true"></script>
            <script src="<?= asset_url() ?>assets/frontend/plugins/parallax.js" defer="true"></script>
            <!-- parallax -->


            <!--isotope-->
            <script src="<?= asset_url() ?>assets/frontend/plugins/isotope.pkgd.min.js"></script>
            <!-- isotope -->

            <!--venobox-->
            <script src="<?= asset_url() ?>assets/frontend/plugins/venobox/venobox.min.js"></script>
            <!-- venobox -->

            <!-- slick slider js -->
            <script src="<?php echo asset_url() ?>assets/frontend/plugins/sweetalert/sweet-alert.js"></script>
            <script src="<?php echo asset_url() ?>assets/frontend/plugins/slickSlider/slick.min.js"></script>
            <script src="<?php echo asset_url() ?>assets/frontend/plugins/swiper/swiper.js"></script>
            <!-- slick slider js -->

            <!-- datetimepicker -->
            <script src="<?= asset_url(); ?>assets/admin/bower_components/moment/min/moment.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
            <script type="text/javascript" src="<?= asset_url(); ?>assets/frontend/plugins/datetime_picker/datetime.js"></script>
            <!-- datetimepicker -->

            <!-- Proteção contra erro de bibliotecas não definidas -->
            <script>
            // Verifica se as bibliotecas estão definidas e cria stubs se necessário
            document.addEventListener('DOMContentLoaded', function() {
                // Venobox
                if (typeof $.fn.venobox === 'undefined') {
                    $.fn.venobox = function() {
                        console.warn('venobox não está disponível');
                        return this;
                    };
                }
                
                // Flatpickr
                if (typeof flatpickr === 'undefined') {
                    window.flatpickr = function() {
                        console.warn('flatpickr não está disponível');
                        return { set: function() {} };
                    };
                    flatpickr.localize = function() {};
                }
                
                // Slick
                if (typeof $.fn.slick === 'undefined') {
                    $.fn.slick = function() {
                        console.warn('slick não está disponível');
                        return this;
                    };
                }
            });
            </script>

            <!-- Tradução do daterangepicker para PT-BR -->
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Adiciona estilos para corrigir o fundo transparente do calendário
                const style = document.createElement('style');
                style.textContent = `
                    .daterangepicker {
                        background-color: #fff !important;
                        border: 1px solid #ddd !important;
                        box-shadow: 0 6px 12px rgba(0,0,0,.175) !important;
                        z-index: 9999 !important;
                    }
                    .daterangepicker .calendar-table {
                        background-color: #fff !important;
                    }
                    .daterangepicker td.active, .daterangepicker td.active:hover {
                        background-color: #3699ff !important;
                    }
                    .daterangepicker .ranges li.active {
                        background-color: #3699ff !important;
                    }
                `;
                document.head.appendChild(style);

                // Configuração completa para traduzir o moment.js para português brasileiro
                moment.updateLocale('pt-br', {
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
                    weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    weekdaysMin: ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sa']
                });

                // Mapa de tradução de meses de português para inglês (para envio ao backend)
                const ptToEnMonthMap = {
                    'Jan': 'Jan', 'Fev': 'Feb', 'Mar': 'Mar', 'Abr': 'Apr',
                    'Mai': 'May', 'Jun': 'Jun', 'Jul': 'Jul', 'Ago': 'Aug',
                    'Set': 'Sep', 'Out': 'Oct', 'Nov': 'Nov', 'Dez': 'Dec',
                    'Janeiro': 'January', 'Fevereiro': 'February', 'Março': 'March', 'Abril': 'April',
                    'Maio': 'May', 'Junho': 'June', 'Julho': 'July', 'Agosto': 'August',
                    'Setembro': 'September', 'Outubro': 'October', 'Novembro': 'November', 'Dezembro': 'December'
                };

                // Configuração global do daterangepicker para usar PT-BR
                if ($.fn.daterangepicker) {
                    $.fn.daterangepicker.defaultOptions = {
                        locale: {
                            applyLabel: 'Aplicar',
                            cancelLabel: 'Cancelar',
                            fromLabel: 'De',
                            toLabel: 'Até',
                            customRangeLabel: 'Personalizado',
                            daysOfWeek: ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sa'],
                            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                            firstDay: 1,
                            format: 'DD/MM/YYYY'
                        },
                        ranges: {
                            'Hoje': [moment(), moment()],
                            'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                            'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                            'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                            'Este Mês': [moment().startOf('month'), moment().endOf('month')],
                            'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        }
                    };
                }
                
                // Sobrescreve a função de formatação de data do moment para garantir a tradução correta
                const originalMomentFormat = moment.fn.format;
                moment.fn.format = function(format) {
                    let result = originalMomentFormat.call(this, format);
                    
                    // Substituição manual para meses em inglês pelos equivalentes em português
                    const monthMap = {
                        'Jan': 'Jan', 'Feb': 'Fev', 'Mar': 'Mar', 'Apr': 'Abr',
                        'May': 'Mai', 'Jun': 'Jun', 'Jul': 'Jul', 'Aug': 'Ago',
                        'Sep': 'Set', 'Oct': 'Out', 'Nov': 'Nov', 'Dec': 'Dez',
                        'January': 'Janeiro', 'February': 'Fevereiro', 'March': 'Março', 'April': 'Abril',
                        'May': 'Maio', 'June': 'Junho', 'July': 'Julho', 'August': 'Agosto',
                        'September': 'Setembro', 'October': 'Outubro', 'November': 'Novembro', 'December': 'Dezembro'
                    };
                    
                    Object.keys(monthMap).forEach(function(enMonth) {
                        result = result.replace(new RegExp(enMonth, 'g'), monthMap[enMonth]);
                    });
                    
                    return result;
                };
                
                // Inicializa os elementos específicos com a classe dateranges
                $('.dateranges').each(function() {
                    var $this = $(this);
                    if (!$this.data('daterangepicker')) {
                        $this.daterangepicker({
                            startDate: moment().subtract(29, 'days'),
                            endDate: moment(),
                            autoUpdateInput: false
                        });
                        
                        $this.on('apply.daterangepicker', function(ev, picker) {
                            // Formata a data para exibição em PT-BR
                            $(this).val(picker.startDate.format('D MMM YYYY') + ' - ' + picker.endDate.format('D MMM YYYY'));
                            
                            // Cria um campo oculto para enviar no formato Y-m-d para o backend
                            var hiddenInputName = $(this).attr('name') + '_hidden';
                            var hiddenInput = $('input[name="' + hiddenInputName + '"]');
                            
                            if (hiddenInput.length === 0) {
                                hiddenInput = $('<input>').attr({
                                    type: 'hidden',
                                    name: hiddenInputName,
                                    value: picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD')
                                }).insertAfter($(this));
                            } else {
                                hiddenInput.val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                            }
                        });
                    }
                });
                
                // Adiciona um listener para os formulários que têm campos daterange
                $('form:has(input[name="daterange"])').on('submit', function(e) {
                    var daterangeInputs = $(this).find('input[name="daterange"]');
                    
                    daterangeInputs.each(function() {
                        var ptDate = $(this).val();
                        if (ptDate) {
                            // Converte a data de PT-BR para EN para a submissão
                            var parts = ptDate.split(' - ');
                            if (parts.length === 2) {
                                var startParts = parts[0].split(' ');
                                var endParts = parts[1].split(' ');
                                
                                if (startParts.length === 3 && endParts.length === 3) {
                                    var startDay = startParts[0];
                                    var startMonth = startParts[1];
                                    var startYear = startParts[2];
                                    
                                    var endDay = endParts[0];
                                    var endMonth = endParts[1];
                                    var endYear = endParts[2];
                                    
                                    // Traduz os meses de PT para EN
                                    startMonth = ptToEnMonthMap[startMonth] || startMonth;
                                    endMonth = ptToEnMonthMap[endMonth] || endMonth;
                                    
                                    // Define o valor em inglês para envio
                                    var enDate = startDay + ' ' + startMonth + ' ' + startYear + ' - ' + endDay + ' ' + endMonth + ' ' + endYear;
                                    $(this).val(enDate);
                                }
                            }
                        }
                    });
                });
            });
            </script>

            <!-- aos-animation -->
            <script src="<?= asset_url(); ?>assets/frontend/plugins/animation/aos-animation.js"></script>
            <!-- aos-animation -->



            <!-- wow -->
            <script src="<?= asset_url(); ?>assets/frontend/plugins/animate/wow.js"></script>
            <!-- wow -->

            <script src="<?php echo asset_url() ?>assets/admin/plugins/notify/notify.js"></script>

            <?php if (isset($page_title) && $page_title != "Checkout") : ?>
                <!-- intelinput -->
                <script src="<?= asset_url(); ?>assets/frontend/plugins/country/intelinput.js"></script>
                <!-- intelinput -->
            <?php else : ?>
                <!-- select2 -->
                <script src="<?php echo asset_url() ?>assets/admin/bower_components/select2/dist/js/select2.full.min.js">
                </script>
                <script>
                    $('.select2').select2({
                        placeholder: `<?= lang("delivery_area") ?>`,
                    });
                </script>
            <?php endif; ?>

            <!-- appear -->
            <script src="<?= asset_url(); ?>assets/frontend/plugins/jquery.appear.js"></script>
            <script src="<?= asset_url(); ?>assets/frontend/plugins/editableSelect/editableSelect.js"></script>
            <!-- appear -->
            <script src="<?= asset_url(); ?>assets/frontend/plugins/jquery.scrollTo.min.js"></script>
            <script src="<?= asset_url(); ?>assets/frontend/plugins/scroller.js"></script>


            <script>
                function setCookie(name, value, minutes) {
                    var expires = new Date();
                    expires.setTime(expires.getTime() + (minutes * 60 * 1000));
                    document.cookie = name + '=' + value + ';expires=' + expires.toUTCString() + ';path=/';
                }

                function getCookie(name) {
                    var cookieArr = document.cookie.split(';');
                    for (var i = 0; i < cookieArr.length; i++) {
                        var cookiePair = cookieArr[i].split('=');
                        if (name == cookiePair[0].trim()) {
                            return decodeURIComponent(cookiePair[1]);
                        }
                    }
                    return null;
                }
            </script>

            <!-- pwa config -->
            <?php if (check() == 1) : ?>
                <?php include 'pwa_footer_config.php'; ?>
            <?php endif ?>
            <!-- pwa config -->

            <!-- gtranslate -->
            <?php if (isset($settings['language_type']) && $settings['language_type'] == 'google') : ?>
                <?php $glan = !empty($settings['glanguage']) && isJson($settings['glanguage']) ? json_decode($settings['glanguage']) : '' ?>
                <?php $glanguage = !empty($glan->glanguage) ? json_decode($glan->glanguage) : json_encode(["ar", "es", "pt"]); ?>
                <script>
                    window.gtranslateSettings = {
                        "default_language": "<?= isset($glan->dlanguage) ? $glan->dlanguage : "en"; ?>",
                        "languages": <?= json_encode($glanguage); ?>,
                        "wrapper_selector": ".admin_gtranslate_wrapper",
                        "switcher_horizontal_position": "right",
                        "switcher_vertical_position": "top"
                    }
                </script>
                <script src="<?= asset_url("assets/admin/plugins/gtranslate.js"); ?>" defer></script>
            <?php endif; ?>
            <!-- gtranslate -->

            <?php if (isset($id)) : ?>
                <?php $u_info = user_info_by_id($id); ?>
                <?php $shop = restaurant($id); ?>
                <!-- restaurant country -->
                <?php $reg_country_info = get_country(!empty($shop->country_id) ? $shop->country_id : 15); ?>
                <a href="<?= $reg_country_info['code']; ?>" id="reg_code"></a>
                <a href="<?= $reg_country_info['dial_code']; ?>" id="reg_dial_code"></a>

                <!-- available_time_slot -->
                <?php include 'common/available_time_slot.php'; ?>
                <!-- available_time_slot -->
                <?php if (isset($page_title) && $page_title == "Checkout") : ?>
                    <!-- google map settings -->
                    <?php include 'common/google_map_settings.php'; ?>
                    <!-- google map settings -->
                <?php endif ?>

                <?php $user_settings = $this->common_m->get_user_settings($id); ?>
                <?php $apps = @!empty($user_settings['extra_config']) ? json_decode($user_settings['extra_config']) : '' ?>


                <?php if (is_feature($id, 'pwa-push') == 1 && is_active($id, 'pwa-push') && check() == 1) : ?>
                    <?php $oneSignal = !empty($user_settings['onesignal_config']) ? json_decode($user_settings['onesignal_config']) : ''; ?>
                    <?php if (isset($oneSignal->is_active_onsignal) && $oneSignal->is_active_onsignal == 1) : ?>
                        <!-- Onesignal settings -->
                        <?php include APPPATH . 'views/frontend/inc/onsignal_footer.php'; ?>
                        <!-- Onesignal settings -->
                        <!-- Proteção contra erro de OneSignal não definido -->
                        <script>
                        // Verifica se o OneSignal está definido e adiciona uma verificação de segurança
                        window.addEventListener('load', function() {
                            if (typeof OneSignal === 'undefined') {
                                // Cria um objeto vazio para evitar erros
                                window.OneSignal = {
                                    push: function() {
                                        console.log('OneSignal não está disponível, ignorando chamada');
                                    }
                                };
                            }
                        });
                        </script>
                    <?php endif; ?>
                    <!-- theme toggle -->

                <?php endif; ?>
                <!-- is_feature -->

                <!-- apps.elfsight.com -->
                <?php if (isset($is_share) && $is_share == 1) : ?>
                    <?php if (isset($apps->elfsight_status) && $apps->elfsight_status == 1) : ?>
                        <script src="https://apps.elfsight.com/p/platform.js" defer></script>

                        <div class="<?= isset($apps->app_id_cookies) ? $apps->app_id_cookies : ''; ?>"></div>
                        <div class="elf" style="margin-top: -100px!important;">
                            <div class="<?= isset($apps->app_id) ? $apps->app_id : ''; ?>"></div>
                        </div>
                        <!-- apps.elfsight.com -->
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($u_info['is_active'] == 0 || $u_info['is_verify'] == 0 || $u_info['is_expired'] == 1 || $u_info['is_payment'] == 0 || $u_info['is_deactived'] == 1) : ?>
                    <?php include APPPATH . 'views/frontend/inc/popupModal.php'; ?>
                    <script>
                        $(document).ready(function() {
                            $('#popupModal').modal({
                                backdrop: 'static',
                                keyboard: false
                            }, 'show');
                        });
                    </script>
                <?php endif ?>

                <?php if (isset($apps->is_scroll_top) && $apps->is_scroll_top == 1) : ?>
                    <script src="<?= asset_url(); ?>assets/frontend/plugins/jquery.scrollTo.min.js"></script>
                    <div class="scroll-top">
                        <a href="javascript:;" class="bounce"><i class="fa fa-chevron-up"></i></a>
                    </div>
                <?php endif ?>


                <?php $lang = glang($id); ?>
                <?php if (isset($lang['is_glang']) && $lang['is_glang'] == 1) : ?>
                    <?php $glanguage = !empty($lang['language']) ? $lang['language'] : ["ar", "es", "pt"]; ?>
                    <script>
                        window.gtranslateSettings = {
                            "default_language": "<?= isset($lang['dlanguage']) ? $lang['dlanguage'] : "en"; ?>",
                            "languages": <?= json_encode($glanguage); ?>,
                            "wrapper_selector": ".gtranslate_wrapper",
                            "flag_size": 24,
                            "switcher_open_direction": "bottom",
                            "flag_style": "3d"
                        }
                    </script>
                    <script src="<?= asset_url("assets/admin/plugins/gtranslate.js"); ?>" defer></script>
                <?php endif; ?>

                <?php if (isset($u_info['is_theme_toggle']) && $u_info['is_theme_toggle'] == 1): ?>
                    <!-- user theme toggle -->
                    <?php $this->load->view("common_layouts/themeToggle.php", ['role' => 'user']); ?>
                <?php endif; ?>
            <?php else: ?>
                <!-- toggle for admin -->
                <?php include VIEWPATH . "common_layouts/themeToggle.php"; ?>
            <?php endif; ?>
            <!--check shop_id  -->

            <?php include APPPATH . 'views/frontend/inc/alertMsg.php' ?>


            <!-- main js -->
            <script src="<?= asset_url(); ?>assets/frontend/js/plugins.js?v=<?= settings()['version']; ?>&time=<?= time(); ?>">
            </script>
            <script src="<?= asset_url(); ?>public/frontend/js/auth.js?v=<?= settings()['version']; ?>&time=<?= time(); ?>">
            </script>
            <script src="<?= asset_url(); ?>public/frontend/js/main.js?v=<?= settings()['version']; ?>&time=<?= time(); ?>">
            </script>
            <!-- main js -->
            <!--payment Modal -->

            </body>

            </html>


            <script type="text/javascript">
                window.addEventListener('DOMContentLoaded', (event) => {
                    setTimeout(function() {
                        console.log('preloader');
                        jQuery("#preloader").fadeOut('slow');
                    }, 1000);
                });
            </script>


            <script>
                $(document).ready(function() {
                    /* Activate scrollspy menu */
                    $('body').scrollspy({
                        target: '#nav',
                        offset: 100
                    });

                    /* Smooth scrolling */
                    $('a.scrollto').on('click', function(e) {
                        //store hash
                        var target = this.hash;
                        e.preventDefault();
                        $('body').scrollTo(target, 800, {
                            offset: 10,
                            'axis': 'y'
                        });

                    });
                    $(".background").parallaxify();
                })
            </script>

            <script>
                $(window).on('load', function() {
                    setTimeout(function() {
                        amarLeazyLoad();
                        amarbgLoad();
                    }, 500);

                });

                var amarbgLoad = function() {
                    $('.bg_loader').each(function() {

                        var lazy = $(this);
                        var src = lazy.data('src');
                        lazy.css("background-image", "url(" + src + ")");
                        $('.bg_loader').removeClass('bg_loader');
                    });
                }

                var amarLeazyLoad = function() {
                    $('.img_loader').each(function() {
                        var lazy = $(this);
                        var src = lazy.data('src');
                        lazy.attr('src', src);
                        $('.img_loader').removeClass('.bg_loader');

                    });
                }
            </script>


            <?php if (isset($_GET['q']) && $_GET['q'] == 'table') : ?>
                <script>
                    $(document).ready(function() {
                        $('#waiterModal').modal('show');
                    });
                </script>
            <?php endif; ?>

            <div class="modal fade" id="tableModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <?= $this->session->flashdata('msg'); ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('close'); ?></button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

            <!-- Conflict Modal -->
            <div class="modal" id="conflictModal">
                <div class="modal-dialog" id="showModaldata">

                </div>
            </div>

            <?php if (isset($shop->whatsapp_support) && !empty($shop->whatsapp_support)) : ?>
                <?php $wh = isJson($shop->whatsapp_support) ? json_decode($shop->whatsapp_support) : ''; ?>

                <?php if (isset($wh->status) && $wh->status == 1) : ?>
                    <div class="whatsappSupport">
                        <a href="javascript:;" class="whatsappIconBtn"><i class="fa fa-whatsapp"></i></a>
                        <div class="whatsappSupportWindow">
                            <div class="whatsappSupportText">
                                <p><?= $wh->welcome_message; ?></p>
                            </div>
                            <?php $wMsg = urlencode(whatsappMsg($wh->welcome_message)); ?>
                            <?php $wUrl = "https://api.whatsapp.com/send/?phone={$wh->dial_code}{$wh->whatsapp_number}&text={$wMsg}&app_absent=0"; ?>
                            <button class="btn btn-primary btn-block whatsappBtn mb-5" onclick="window.open('<?= $wUrl; ?>', '_blank');" target="_blank"> <i class="fa fa-whatsapp"></i>
                                <?= lang('start_chat'); ?></button>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <script type="text/javascript">
                $(document).on("click", ".whatsappIconBtn", function() {
                    $('.whatsappSupportWindow').toggleClass('active');
                });
            </script>

            <?php if (isset($shop_id) && isset($is_reject) && $is_reject == 1) : ?>
                <?php $this->load->view('common/reasonModal', ['shop_id' => $shop_id, 'type' => 'dboy']); ?>
            <?php endif; ?>


            <?php if (isset($shop_id)) : ?>
                <?php $this->load->view('frontend/inc/common/available_days_modal'); ?>
            <?php endif; ?> <!-- check shop id exits -->




            <?php if (is_demo() == 1) : ?>
                <script>
                    // disable right click
                    document.addEventListener('contextmenu', event => event.preventDefault());

                    document.onkeydown = function(e) {

                        // disable F12 key
                        if (e.keyCode == 123) {
                            return false;
                        }

                        // disable I key
                        if (e.ctrlKey && e.shiftKey && e.keyCode == 73) {
                            return false;
                        }

                        // disable J key
                        if (e.ctrlKey && e.shiftKey && e.keyCode == 74) {
                            return false;
                        }

                        // disable U key
                        if (e.ctrlKey && e.keyCode == 85) {
                            return false;
                        }
                    }
                </script>
            <?php endif; ?>



            <script>
                $.ajaxSetup({
                    beforeSend: function(xhr, settings) {
                        function shouldAddLangParameter() {
                            var languageType = $('meta[name="language_type"]').attr('content');
                            var totalLanguages = parseInt($('meta[name="total_languages"]').attr('content'));
                            return (languageType === 'system' && totalLanguages > 1);
                        }

                        if (shouldAddLangParameter()) {
                            var lang = $('html').attr('lang'); // Get the language from the HTML tag
                            if (settings.url.indexOf('lang=') === -1) { // Only add if lang parameter is missing
                                // Check if the URL contains a query string
                                if (settings.url.indexOf('?') === -1) {
                                    // No query string, add lang with ?
                                    settings.url += '?lang=' + lang;
                                } else {
                                    // Query string exists, add lang with &
                                    settings.url += '&lang=' + lang;
                                }
                            }
                        }
                    }
                });
            </script>