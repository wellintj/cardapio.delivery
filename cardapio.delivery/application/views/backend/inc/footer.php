  </section>
  <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php if (isset($page_title) && $page_title != "Admin Login") { ?>
    <footer class="main-footer">
      <div class="footerLeft">
        <?php if (isset(restaurant()->is_branding) && restaurant()->is_branding == 1) : ?>
          <p class="created_by"><img src="<?= avatar(st()->logo, 'item'); ?>" alt=""> <?= lang('created_by'); ?> <a href="<?= asset_url(""); ?>"><?= $this->settings['site_name']; ?></a></p>
        <?php else : ?>
          <strong><?= !empty(lang('copyright')) ? lang('copyright') : "Copyright"; ?> &copy;
            <?php echo date('Y'); ?></strong>
        <?php endif; ?>
      </div>
      <div class="footerRight flex-center-center">
        <ul class="shortMenu flex-center-between">
          <li><a href="<?= base_url("dashboard"); ?>"><?= lang('home'); ?></a></li>
          <?php if (auth('user_role') == 1) : ?>
            <li><a href="<?= base_url("admin/settings/preferences"); ?>"><?= lang('preferences'); ?></a></li>
            <li><a href="<?= base_url("admin/dashboard/domain_list"); ?>"><?= lang('domain_list'); ?></a></li>
          <?php endif; ?>
          <?php if (auth('user_role') == 0 && is_access('setting-control') == 1) : ?>
            <li><a href="<?= base_url("admin/auth/delivery_settings"); ?>"><?= lang('delivery_settings'); ?></a></li>
            <li><a href="<?= base_url("admin/menu/item"); ?>"><?= lang('items'); ?></a></li>
            <li><a href="<?= base_url("admin/auth/order_config"); ?>"><?= lang('order_configuration'); ?></a></li>
          <?php endif; ?>
        </ul>
        <label class="label bg-light-purple-soft"><?= lang('version'); ?> <?= settings()['version']; ?></label>
      </div>
    </footer>
  <?php } ?>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
   immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->
  <a href="<?php echo asset_url() ?>" id="base_url"></a>
  <a href="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_value"></a>
  <a href="<?php echo $this->security->csrf_token(); ?>" id="csrf_data"></a>

  <a href="<?= !empty(lang('yes')) ? lang('yes') : "Yes"; ?>" id="yes"></a>
  <a href="<?= !empty(lang('no')) ? lang('no') : "No"; ?>" id="no"></a>
  <a href="<?= !empty(lang('cancel')) ? lang('cancel') : "cancel"; ?>" id="cancel"></a>
  <a href="<?= !empty(lang('are_you_sure')) ? lang('are_you_sure') : "are you sure"; ?>" id="are_you_sure"></a>
  <a href="<?= !empty(lang('success')) ? lang('success') : "Success"; ?>" id="success"></a>
  <a href="<?= !empty(lang('warning')) ? lang('warning') : "Warning"; ?>" id="warning"></a>
  <a href="<?= !empty(lang('error')) ? lang('error') : "error"; ?>" id="error"></a>
  <a href="<?= !empty(lang('success_text')) ? lang('success_text') : 'Save Change Successful'; ?>" id="success_msg"></a>
  <a href="<?= !empty(lang('error_text')) ? lang('error_text') : 'Somethings Were Wrong!'; ?>" id="error_msg"></a>
  <a href="<?= !empty(lang('item_deactive_now')) ? lang('item_deactive_now') : 'Item is deactive now'; ?>" id="item_deactive"></a>
  <a href="<?= !empty(lang('item_active_now')) ? lang('item_active_now') : 'Item is active now'; ?>" id="item_active"></a>
  <a href="<?= !empty(lang('want_to_reset_password')) ? lang('want_to_reset_password') : 'Want to reset password?'; ?>" id="want_to_reset_password"></a>
  <a href="<?= lang('select'); ?>" id="select"></a>
  <a href="<?= lang('search'); ?>" id="search"></a>
  <a href="<?= lang('show'); ?>" id="show"></a>
  <a href="<?= lang('next'); ?>" id="next"></a>
  <a href="<?= lang('previous'); ?>" id="previous"></a>
  <a href="<?= lang('first'); ?>" id="first"></a>
  <a href="<?= lang('last'); ?>" id="last"></a>
  <a href="<?= lang('not_found_msg'); ?>" id="not_found"></a>
  <a href="<?= lang('showing'); ?>" id="showing"></a>
  <a href="<?= lang('entries'); ?>" id="entries"></a>
  <a href="<?= lang('to'); ?>" id="to"></a>
  <a href="<?= lang('of'); ?>" id="of"></a>
  <a href="<?= lang('select_items'); ?>" id="select_items"></a>
  <a href="<?= lang('please_wait_its_working'); ?>" id="please_wait_its_working"></a>
  <a href="<?= direction(); ?>" id="direction"></a>

  <?php if (LICENSE != MY_LICENSE) : ?>
    <style>
      .card.stripe_fpx,
      .mercado,
      .flutterwave,
      .paystack,
      .paytm {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
      }
    </style>

  <?php endif; ?>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.7 -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/raphael/raphael.min.js"></script>
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/morris.js/morris.min.js"></script>

  <!-- select2 -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/select2/dist/js/select2.full.min.js"></script>

  <!-- jQuery Knob Chart -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

  <!-- jQuery Knob Chart -->
  <script src="<?php echo asset_url() ?>assets/admin/plugins/chart/jquery.flot.min.js"></script>
  <script src="<?php echo asset_url() ?>assets/admin/plugins/canvas.js"></script>
  <script src="<?php echo asset_url() ?>assets/admin/plugins/chart/jquery.flot.categories.min.js"></script>


  <!-- daterangepicker -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/moment/min/moment.min.js"></script>

  <script src="<?php echo asset_url() ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js">
  </script>

  <!-- bootstrap color picker -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js">
  </script>

  <!-- datetime picker.js -->
  <script src="<?php echo asset_url() ?>assets/admin/datetime/datetimepicker.js"></script>

  <!-- datetimepicker -->
  <script type="text/javascript" src="<?= asset_url(); ?>assets/frontend/plugins/datetime_picker/datetime.js"></script>
  <!-- datetimepicker -->

  <!-- time picker.js -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js">
  </script>

  <!-- datepicker -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
  </script>
  <!-- Datepicker em português -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
  <script type="text/javascript">
    $.fn.datepicker.defaults.language = 'pt-BR';
  </script>
  <!-- DataTables -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js">
  </script>

  <script src="<?php echo asset_url() ?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js">
  </script>

  <!-- Flatpickr Principal -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>

  <!-- Slimscroll -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js">
  </script>

  <!-- iCheck -->
  <script src="<?php echo asset_url() ?>assets/admin/plugins/iCheck/icheck.min.js"></script>
  <script src="<?php echo asset_url() ?>assets/frontend/plugins/sweetalert/sweet-alert.js"></script>

  <?php if (isset($page_title) && $page_title == "Qr Builder" || $page_title == "Table Qr Builder") : ?>
    <script src="<?php echo asset_url() ?>assets/admin/plugins/jqueryqr/pickr.js"></script>
    <script src="<?php echo asset_url() ?>assets/admin/plugins/jqueryqr/jqueryqr.js"></script>
    <script src="<?php echo asset_url() ?>assets/admin/plugins/jqueryqr/active_pickr.js"></script>
    <script src="<?php echo asset_url() ?>assets/admin/plugins/jqueryqr/qrscripts.js"></script>
  <?php endif ?>

  <!-- FastClick -->
  <script src="<?php echo asset_url() ?>assets/admin/bower_components/fastclick/lib/fastclick.js"></script>
  <!-- summernote -->
  <script src="<?php echo asset_url() ?>assets/admin/plugins/summernote/summernote-bs4.js"></script>
  <script src="<?php echo asset_url() ?>assets/admin/plugins/tag_inputs/bootstrap-tagsinput.js"></script>
  <script src="<?php echo asset_url() ?>assets/admin/plugins/iconpicker/bootstrap-iconpicker.bundle.min.js"></script>
  <!-- Image Uploader -->
  <script src="<?php echo asset_url() ?>assets/admin/uploader/uploadify.js"></script>

  <!-- chosen -->
  <script src="<?php echo asset_url() ?>assets/admin/plugins/chosen/chosen.jquery.js"></script>
  <script src="<?= asset_url(); ?>assets/frontend/plugins/animate/wow.js"></script>
  <!-- notify -->
  <script src="<?php echo asset_url() ?>assets/admin/plugins/notify/notify.js"></script>
  <script src="<?php echo asset_url() ?>assets/admin/plugins/formValidation.js"></script>

  <script>
    $.fn.slider = null
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.js"></script>


  <?php if (isset($page_title) && $page_title == 'Stripe Payment') : ?>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <?php endif; ?>
  <?php if (isset($page_title) && $page_title == 'Payment Method') : ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <?php endif; ?>

  <!-- AdminLTE App -->
  <script src="<?php echo asset_url() ?>assets/admin/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="<?php echo asset_url() ?>assets/admin/dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="<?php echo asset_url() ?>assets/admin/bootstrapToggle.js"></script>
  <script src="<?php echo asset_url() ?>assets/admin/dist/js/demo.js?v=<?= settings()['version']; ?>&time=<?= time(); ?>">
  </script>

  <!-- Moment.js para manipulação de datas -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
  <!-- Flatpickr -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
  <!-- Flatpickr Português Brasil -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt-BR.js"></script>

  <script>
    /*----------------------------------------------
        Audio/Notification sound
    ----------------------------------------------*/
    let audioElement = document.createElement('audio');

    function resetaudio() {
      audioElement.pause();
      audioElement.currentTime = 0;
      $("#status").text("Status: Paused");
    }


    function playaudio() {

      audioElement.setAttribute('src', `${base_url}assets/frontend/mp3/ring_2.mp3`);
      var count = 1;
      let playPromise = audioElement.play();


      audioElement.addEventListener('ended', function() {
        if (count <= 2) {
          this.play();
          count++;
        }
      }, false);


      if (playPromise !== undefined) {
        playPromise.then(_ => {
            audioElement.muted = false;
            audioElement.play();
          })
          .catch(error => {
            $(document).on('click', function() {
              audioElement.play();
            })
            console.log(error);
          });
      }


      audioElement.addEventListener("canplay", function() {
        console.log('Playing');
      });

      audioElement.addEventListener("timeupdate", function() {
        $("#currentTime").text("Current second:" + audioElement.currentTime);
      });

    }

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

  <script src="<?= asset_url('public/plugins/utilities.js'); ?>?v=<?= settings()['version']; ?>&time=<?= time(); ?>" type="text/javascript"></script>

  <?php if (file_exists(FCPATH . 'public/admin/pos.js')) : ?>
    <script src="<?= asset_url('public/admin/pos.js'); ?>?v=<?= settings()['version']; ?>&time=<?= time(); ?>" type="text/javascript"></script>
  <?php endif ?>

  <?php if (isset($page) && $page != "KDS") : ?>
    <script src="<?php echo asset_url() ?>public/admin/main.js?v=<?= settings()['version']; ?>&time=<?= time(); ?>"></script>

  <?php endif; ?>

  <?php if (isset($page_title) && $page_title == "Items") : ?>
    <link rel="stylesheet" href="<?= asset_url('public/plugins/cropper.css'); ?>" />
    <script src="<?= asset_url('public/plugins/cropper.js') ?>"></script>
  <?php endif; ?>

  <!-- admin_pusher -->

  <?php if (isset($page) && $page == 'Chat') : ?>
    <?= $this->load->view('frontend/inc/admin_pusher_config.php', [], true); ?>
  <?php endif ?>

  <!-- admin_pusher -->

  <?php if (auth('is_user') == true && !empty(restaurant()->id)) : ?>
    <?php $orderId = isset($order_id) ? $order_id : 0; ?>
    <?= $this->load->view('frontend/inc/pusher_config.php', ['id' => restaurant(auth('id'))->id, 'order_id' => $orderId], true); ?>
  <?php endif; ?>
  <script type="text/javascript">
    $(document).ready(function () {
    // Traduzir e configurar o calendário
    function show_date_details() {
        var day = $('.off_days').data('day');
        var start_time = $('.off_time').data('start');
        var end_time = $('.off_time').data('end');

        if (end_time < start_time) {
            end_time = '23:59';
        }

        $(".datetimepicker").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i:S", // Formato para o backend
            altFormat: "d-m-Y H:i:S", // Formato para exibição ao usuário
            altInput: true,
            minDate: "today",
            time_24hr: true,
            disable: [
                function (date) {
                    var events = false;
                    var d = date.getDay();
                    $.each(day, function (i, v) {
                        if (v == d) {
                            events = true;
                        }
                    });
                    return events;
                }
            ],
            locale: {
                firstDayOfWeek: 0,
                weekdays: {
                    shorthand: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    longhand: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado']
                },
                months: {
                    shorthand: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    longhand: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
                },
                rangeSeparator: ' a ',
                weekAbbreviation: 'Sem',
                scrollTitle: 'Role para aumentar',
                toggleTitle: 'Clique para alternar',
                amPM: ['AM', 'PM'],
                ordinal: function () {
                    return 'º';
                },
                formats: {
                    time: 'H:i',
                    datetime: 'Y-m-d H:i',
                    date: 'Y-m-d',
                    hours: 'Horas',
                    minutes: 'Minutos',
                    seconds: 'Segundos',
                    year: 'Ano',
                    month: 'Mês',
                    day: 'Dia'
                }
            },
            onChange: [
                function (selectedDates, dateStr, instance) {
                    var currentDate = new Date(dateStr);
                    var dayId = currentDate.getDay();
                    var shopID = $('.off_days').data('id');
                    var url = `${base_url}profile/get_time_by_date/${dayId}/${shopID}`;
                    $.get(url, { 'csrf_test_name': csrf_value }, function (json) {
                        var startTime = json.start_time;
                        var endTime = json.end_time;
                        var startDate = new Date("1970-01-01 " + startTime);
                        var endDate = new Date("1970-01-01 " + endTime);
                        if (endDate < startDate) {
                            endTime = '23:59';
                        }
                        instance.set('maxTime', endTime);
                        instance.set('minTime', startTime);
                    }, 'json');
                    return false;
                }
            ]
        });

        // Time picker
        $(".timepicker").flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            minTime: start_time,
            maxTime: end_time
        });
    }

    show_date_details(); // Chamar a função para inicializar o datetime picker

    $(document).on('click', '.pickup_date_checker', function () {
        var val = $(this).val();
        var shopID = $(this).data('id');
        if (val == 1) {
            get_pickup_time(shopID, 1);
            $('.pickupTime').slideUp();
        } else {
            get_pickup_time(shopID, 2);
            $('.pickupTime').slideDown();
        }
    });

    // Manipular o envio do formulário para ajustar o formato da data
    $('form.defaultForm').on('submit', function(e) {
        var dateInput = $('input[name="reservation_date"]');
        if (dateInput.length) {
            var dateValue = dateInput.val();
            if (dateValue) {
                var formattedDate = moment(dateValue, 'DD-MM-YYYY HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
                dateInput.val(formattedDate);
            }
        }
    });
});

    $(function() {
      function load_image(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            $('#preview_load_image').attr('src', e.target.result);
            $('#preview_load_image').removeClass('opacity_0');
            $('.preview_load_image, .view_img').show();
            $('.preview_load_image').hide();
            $('.img_text, .view_img ').hide();
            $('#imageCropper').modal('show');
            $('.croppedImage').attr('src', e.target.result);

          }
          reader.readAsDataURL(input.files[0]);
        }
      }

      $(document).on('change', '#load_image', function($) {
        load_image(this);
      });
    });
  </script>
  <?php if (isset($page_title) && $page_title == "Dashboard") : ?>
    <script>
      /*
       * BAR CHART
       * ---------
       */

      var bar_data = {
        data: [
          <?php foreach (get_month() as $key => $value) : ?>["<?= $value; ?>", <?= income($key, 0); ?>],
          <?php endforeach; ?>
        ],
        color: "#3c8dbc"
      };
      $.plot("#bar-chart", [bar_data], {
        grid: {
          borderWidth: 1,
          borderColor: "#f3f3f3",
          tickColor: "#f3f3f3"
        },
        series: {
          bars: {
            show: true,
            barWidth: 0.5,
            align: "center"
          }
        },
        xaxis: {
          mode: "categories",
          tickLength: 0
        }
      });
    </script>
    <?php if (USER_ROLE == 0) : ?>
      <script>
        window.onload = function() {

          var chart = new CanvasJS.Chart("chartContainers", {
            backgroundColor: "#fff ",
            animationEnabled: true,
            theme: "light2",
            title: {
              text: ""
            },
            data: [{
              type: "line",
              indexLabelFontSize: 16,
              dataPoints: [
                <?php foreach (get_month() as $key => $value) : ?> {
                    y: <?= user_income($key, 0); ?>,
                    label: "<?= $value; ?>"
                  },
                <?php endforeach; ?>
              ]
            }]
          });
          chart.render();

        }
      </script>
    <?php endif; ?>
  <?php endif; ?>


  <?php if ($this->session->flashdata('success')) { ?>
    <span id="alert_title" data-msg="<?= !empty(lang('success')) ? lang('success') : "Success"; ?>!"></span>
    <span id="alert" data-msg="<?php echo $this->session->flashdata('success'); ?>"></span>
    <script>
      $.notify({
        icon: 'fa fa-check',
        title: $('#alert_title').data('msg'),
        message: $('#alert').data('msg')
      }, {
        type: 'success'
      }, {
        animate: {
          enter: 'animated fadeInRight',
          exit: 'animated fadeOutRight'
        }
      });
    </script>
  <?php } ?>
  <?php if ($this->session->flashdata('error')) { ?>
    <span id="alert_title" data-msg="<?= !empty(lang('error')) ? lang('error') : "Error"; ?>!!"></span>
    <span id="alert" data-msg="<?php echo $this->session->flashdata('error'); ?>"></span>
    <script>
      $.notify({
        icon: 'fa fa-close',
        title: $('#alert_title').data('msg'),
        message: $('#alert').data('msg')
      }, {
        type: 'danger'
      }, {
        animate: {
          enter: 'animated fadeInRight',
          exit: 'animated fadeOutRight'
        }
      });
    </script>
  <?php } ?>


  <?php include APPPATH . "views/frontend/inc/onsignal_footer.php"; ?>

  <?php include 'updateModal.php'; ?>
  <!-- reject Reason Modal -->
  <?php if (auth('user_role') == 0 && !empty(restaurant()->id)) : ?>
    <?php $this->load->view('common/reasonModal', ['shop_id' => restaurant()->id, 'type' => 'vendor']); ?>

  <?php endif; ?>
  </body>

  </html>




  <script>
    var text = '<?= lang('remaining'); ?>';
    $(".get_time").each(function(i, e) {
      var id = $(this).data('id');
      var time = $(this).data('time');
      var countDownDate = new Date(time).getTime();

      // Update the count down every 1 second
      var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        if (days > 0) {
          $('#show_time_' + id).html(text + ': ' + days + "d " + hours + "h " + minutes + "m " +
            seconds + "s ");
          $('#preparingTime_' + id).slideDown();

        } else if (hours > 0) {
          $('#show_time_' + id).html(text + ': ' + hours + "h " + minutes + "m " + seconds + "s ");
          $('#preparingTime_' + id).slideDown();

        } else if (minutes > 0) {
          $('#show_time_' + id).html(text + ': ' + minutes + "m " + seconds + "s ");
          $('#preparingTime_' + id).slideDown();

        } else if (seconds > 0) {
          $('#show_time_' + id).html(text + ': ' + seconds + "s ");
          $('#preparingTime_' + id).slideDown();
        } else {
          $('#show_time_' + id).html('');
          $('#preparingTime_' + id).slideUp();
        }


        if (distance < 0) {
          clearInterval(x);
          $('#show_time_' + id).html('');
          $('#preparingTime_' + id).slideUp();
        }
      }, 1000);
    });
  </script>
  <?php if (isset($page_title) && $page_title != 'Edit profile' && isset($page_title) && $page_title != 'Restaurant Configuration' && isset($page_title) && $page_title != 'Profile' && isset($page_title) && $page_title != 'KDS') : ?>
    <?php //include "alertModal.php"; 
    ?>
  <?php endif; ?>


  <?php if (isset($page) && $page == "POS") : ?>
    <!-- available_time_slot -->

    <?= $this->load->view('frontend/inc/common/available_time_slot.php', ['shop' => shop(restaurant()->id)], true); ?>
    <!-- available_time_slot -->
  <?php endif ?>


  <?php if (auth('user_role') == 0) : ?>
    <?php $lang = glang(auth('id')); ?>
    <?php if (isset($lang['is_glang']) && $lang['is_glang'] == 1) : ?>
      <?php $glanguage = !empty($lang['language']) ? $lang['language'] : ["ar", "es", "pt"]; ?>
      <script>
        window.gtranslateSettings = {
          "default_language": "<?= isset($lang['dlanguage']) ? $lang['dlanguage'] : "en"; ?>",
          "languages": <?= json_encode($glanguage); ?>,
          "wrapper_selector": ".gtranslate_wrapper",
          "switcher_horizontal_position": "right",
          "switcher_vertical_position": "top"
        }
      </script>

      <script src="<?= asset_url("assets/admin/plugins/gtranslate.js"); ?>" defer></script>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (auth('user_role') == 1) : ?>
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
    <?php if (isset(st()->is_city_delivery, $page_title) && st()->is_city_delivery == 1 &&  $page_title != 'Cities'): ?>
      <?php $checkCities = $this->admin_m->check_empty_cities(); ?>
      <?php if ($checkCities == 0) : ?>
        <div id="adminCityModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4>Add Cities for your shop</h4>
              </div>
              <div class="modal-body">
                <p class="text-danger">*Please add Cities from Home > cities</p>
                <p>Without cities, restaurant/vendor can't configure it. </p>
                <div class="mt-5">
                  <a href="<?= base_url('admin/home/cities'); ?>" class="btn btn-success ">Click here</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script>
          $('#adminCityModal').modal({
            backdrop: 'static',
            keyboard: false
          });
        </script>
      <?php endif; ?>
    <?php endif; ?>
  <?php endif; ?><!-- user_role 1 -->

  <?php if (auth('user_role') == 0) : ?>
    <?php $tutorialList = $this->admin_m->get_tutorial_data(); ?>
    <?php foreach ($tutorialList as $tutorial) : ?>
      <?php $page_titles = explode(',', trim(strtolower($tutorial->page_title))); ?>
      <?php if (isset($page_title) && in_array(trim(strtolower($page_title)), $page_titles)) : ?>
        <div class="tutorialArea">
          <a href="javascript:;" data-id="<?= $tutorial->uid; ?>" class="tutorialModal"><i class="fa fa-question"></i></a>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>

    <?php if (isset(st()->is_city_delivery) && st()->is_city_delivery == 1): ?>
      <?php if (isset(restaurant()->city_id) && restaurant()->city_id == 0) : ?>
        <?php if (isset($page_title) && $page_title != 'Auth Profile') : ?>
          <?php $cityList = $this->admin_m->select('restaurant_city_list'); ?>
          <div id="cityModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <form action="<?= base_url('admin/auth/add_city') ?>" method="post">
                <?= csrf(); ?>
                <div class="modal-content">
                  <div class="modal-body">
                    <div class="form-group">
                      <label for=""><?= lang('city_name'); ?></label>
                      <select name="city_id" id="city_id" class="form-control select2" required>
                        <option value="0"><?= lang('select'); ?></option>
                        <?php foreach ($cityList as  $key => $city) : ?>
                          <option value="<?= $city['id']; ?>"><?= $city['city_name']; ?> - <?= $city['state']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"><?= lang('submit'); ?></button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <script>
            $(document).ready(function() {

              $("#cityModal").modal({
                backdrop: 'static',
                keyboard: false
              });

            });
          </script>

        <?php endif; ?>
      <?php endif; ?>
    <?php endif ?>
  <?php endif ?>


  <!-- Modal -->
  <div id="tutoralModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" id="showTutorialData">
      </div>
    </div>
  </div>


  <script>
    if ($(window).width() <= 991) {
      // Listen for the page load event
      window.addEventListener('load', scrollToActiveElement('.leftSidebar .active'));
    }
  </script>

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