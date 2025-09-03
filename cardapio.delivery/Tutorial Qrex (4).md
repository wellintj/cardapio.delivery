Modificações frontend footer cardapio.delivery/application/views/frontend/inc/footer.php :

Date-time picker  Procurar no arquivo entre <!-- slick slider js --> e <!-- aos-animation --> por volta da linha 61 e substituir por esse

    <!-- datetimepicker   importação bootstraap date picker in pt-br -->
        <script src="<?= base_url(); ?>assets/admin/bower_components/moment/min/moment.min.js" defer="true"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script> <!-- Arquivo de localização do Moment.js em português -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
        <script type="text/javascript" src="<?= base_url(); ?>assets/frontend/plugins/datetime_picker/datetime.js" defer="true"></script>

        <!-- datetimepicker -->
		
------------------------------------
		Calendário em assets  cardapio.delivery\assets\admin\dist\js\pages\dashboard.js
		
		  // $('.textarea').wysihtml5();

$('.daterange').daterangepicker({
    locale: {
        format: 'DD/MM/YYYY',
        applyLabel: 'Aplicar',
        cancelLabel: 'Cancelar',
        fromLabel: 'De',
        toLabel: 'Até',
        customRangeLabel: 'Personalizado',
        daysOfWeek: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        firstDay: 1
    },
    ranges: {
        'Hoje': [moment(), moment()],
        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
        'Este Mês': [moment().startOf('month'), moment().endOf('month')],
        'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    startDate: moment().subtract(29, 'days'),
    endDate: moment()
}, function(start, end) {
    window.alert('Você escolheu: ' + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
});

-------------------------------------------------
Traduzir placeholder do chat.php em cardapio.delivery\application\views\backend\chat\chat.php

------------------------------------------------------
Atualizar API de conexão whatsapp em após wasendo  cardapio.delivery\application\models\System_model.php

private function wasendo($msg, $order_info, $order_type_name, $orderType, $created_msg)
{
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://api-evo.autobot.cloud/message/sendText/" . $msg->instance_id, // URL da API com a instância
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode([
            "number" => $order_info['phone'],  // Número de telefone completo com o código do país
            "text" => $created_msg,  // Mensagem a ser enviada
            "linkPreview" => false,  // Desabilita a prévia de links
        ]),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "apikey: ymZladJNXWGk51dV6FMfJ0Otkglw2Lj1" // Substitua pela chave API real
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        // Você pode remover ou comentar esta linha se não quiser exibir a resposta
        // echo $response;
    }
}


	///////
	
	----------------------------------------------------------------------------------------
	
	Traduzir tipo de reserva no formulário de reservas de Select para Selecnionar
	
	cardapio.delivery/application/views/layouts/reservation_form.php linha 70        <option value="">Selecionar</option>
	
	-----------------------------------------------------------------------------------------------------------------------
	
	Adicionar dependencia dos calendarios (Calendários do admin/loja como o de Ofertas) para pt-BR em cardapio.delivery/application/views/backend/inc/footer.php nas importações: 
	<!-- daterangepicker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment-with-locales.min.js"></script>

<script src="<?php echo base_url() ?>assets/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>

<script src="<?php echo base_url() ?>assets/admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url() ?>assets/admin/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/datetime/datetimepicker.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/frontend/plugins/datetime_picker/datetime.js"></script>
<script src="<?php echo base_url() ?>assets/admin/bower_components/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<script src="<?php echo base_url() ?>assets/admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>


Após isso na linha 277 trocar o função datetime picker por essa :

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



//////////

---------------------------------------------------------------------------------
Traduzir a palavra Custom Range no painel do lojista calendário duplo para Escolher Intervalo 
assets/admin/bower_components/bootstrap-daterangepicker/bootstrap-daterangepicker/.js e pesquisar por Custom Range e traudir e salvar.
--------------------------------------------------------------------------------------------------------
Traduzir datas do dasboard para linguagem pt-BR com 21 Fev de 2025 ou 25 de Janeiro, 2025 ou 25 Jan 15:52 PM

Criar arquivo chamando custom_date_helper.php e adicionar o código abaixo : <?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_custom_date')) {
    /**
     * Formata uma data em vários formatos, convertendo os meses para PT-BR.
     *
     * @param string $date A data de entrada (ex.: "2025-01-10", "10 January, 2025").
     * @param string $output_format O formato de saída desejado (padrão: 'd M Y H:i').
     * @param string $input_format Opcional: formato da data de entrada para parsing.
     * @return string Data formatada no formato de saída.
     */
    function format_custom_date($date, $output_format = 'd M Y H:i', $input_format = null) {
        // Meses traduzidos
        $months_en_to_pt = [
            'January' => 'Janeiro', 'February' => 'Fevereiro', 'March' => 'Março',
            'April' => 'Abril', 'May' => 'Maio', 'June' => 'Junho',
            'July' => 'Julho', 'August' => 'Agosto', 'September' => 'Setembro',
            'October' => 'Outubro', 'November' => 'Novembro', 'December' => 'Dezembro',
            'Jan' => 'Jan', 'Feb' => 'Fev', 'Mar' => 'Mar', 'Apr' => 'Abr',
            'May' => 'Mai', 'Jun' => 'Jun', 'Jul' => 'Jul', 'Aug' => 'Ago',
            'Sep' => 'Set', 'Oct' => 'Out', 'Nov' => 'Nov', 'Dec' => 'Dez'
        ];

        // Formatar a data
        try {
            if ($input_format) {
                // Parse a data com um formato específico de entrada
                $datetime = DateTime::createFromFormat($input_format, $date);
            } else {
                // Tenta criar o objeto automaticamente
                $datetime = new DateTime($date);
            }

            // Formata a data no formato desejado
            $formatted_date = $datetime->format($output_format);

            // Substitui os meses em inglês pelos em português
            return strtr($formatted_date, $months_en_to_pt);
        } catch (Exception $e) {
            // Retorna a data original em caso de erro
            return $date;
        }
    }
}



Em autoload.php na linha do helper trocar por essa linha que incluir o helper criado : $autoload['helper'] = array('url', 'file', 'custom', 'security', 'text', 'string', 'language', 'system', 'custom_date');

Após isso ir na View com por exemplo cardapio.delivery/application/views/backend/dashboard/inc/package_information.php na linha da data de expiração trocar  por primeiro para mostrar data sem horas e minutos : <p>Data de expiração: <?= format_custom_date($this->my_info['end_date'], 'd M Y'); ?></p>
<p>Último login: <?= format_custom_date('10 January, 2025 04:05 pm', 'd M Y H:i'); ?></p>

-----------------------------------------------------------------
Traduzir datas que mostra  14, Februrary, 2025 para Portugues 15 Fevereiro, 2025  em cardapio.delivery/application/helpers/custom_helper.php  trocar função if (!function_exists('cl_format')) {
    function cl_format($date, $id = 0)
    {
        $ci = get_instance();
        if ($id == 0) {
            $date = date_create($date);
            return date_format($date, "d F, Y");
        } else {
            $date = get_date_format($date, $id);
            return $date;
        }
    }
} 

por essa abaixo


// função data painel adminsitrativo
if (!function_exists('cl_format')) {
    function cl_format($date, $id = 0)
    {
        if ($date != '') {
            // Cria o objeto de data
            $date_obj = date_create($date);
            
            // Extrai o dia e o ano
            $day = date_format($date_obj, "d");
            $year = date_format($date_obj, "Y");

            // Array de meses em português
            $months = [
                1 => 'janeiro', 2 => 'fevereiro', 3 => 'março', 4 => 'abril',
                5 => 'maio', 6 => 'junho', 7 => 'julho', 8 => 'agosto',
                9 => 'setembro', 10 => 'outubro', 11 => 'novembro', 12 => 'dezembro'
            ];
            
            // Obtém o número do mês e o nome correspondente
            $month_number = date_format($date_obj, "n");
            $month_name = ucfirst($months[$month_number]); // Capitaliza o nome do mês

            // Retorna o formato no estilo "13 Janeiro, 2025"
            return "$day $month_name, $year";
        } else {
            return '';
        }
    }
}


// função data 

------------------------------------------------------------------------------
Traduzir datas completas como  13 Feb 2025 11:22 am para 13 Fev 2025 11:22 am  No arquivo Custom_helper substituit a função full_time : 
if (!function_exists('full_time')) {
    function full_time($date, $id = 0)
    {
        if ($date != '' && $date != '0000-00-00 00:00:00') {
            $fdate = get_date_format($date, $id);
            $ftime = time_format($date, $id);
            $date_new = $fdate . ' ' . $ftime;
            return $date_new;
        } else {
            return '';
        }
    }
} 


 por 





if (!function_exists('full_time')) {
    function full_time($date, $id = 0)
    {
        if ($date != '' && $date != '0000-00-00 00:00:00') {
            // Cria o objeto de data
            $date_obj = date_create($date);

            // Extrai o dia, ano e hora
            $day = date_format($date_obj, "d");
            $year = date_format($date_obj, "Y");
            $time = date_format($date_obj, "h:i a"); // Formato de hora (12 horas com AM/PM)

            // Array de meses abreviados em português
            $months = [
                1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr',
                5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
                9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
            ];

            // Obtém o número do mês e o nome correspondente
            $month_number = date_format($date_obj, "n");
            $month_abbr = $months[$month_number];

            // Retorna o formato "13 Fev 2025 11:22 am"
            return "$day $month_abbr $year $time";
        } else {
            return '';
        }
    }
}

-------------------------

O formulário de adicionar cupons precisa ajustar o formato com são salvos as data no BD

  /// calendário da parte de adicioanr cupom de desconto // 
  /// calendário da parte de adicioanr cupom de desconto // 
 jQuery(document).ready(function () {
    // Ativação do Datepicker do Cupom de Desconto Logista
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy', // Define o formato para dd/mm/yyyy
        language: 'pt-BR' // Define o idioma para português brasileiro
    });

    // current time for clock
    // current time for clock
    $(function () {
      var datetime = null;
      var update = function () {
        datetime.html(moment().format('h:mm:ss a'));
      };

      $(document).ready(function () {
        datetime = $('#time');
        update();
        setInterval(update, 1000);
      });

    });

    // active imageuploadify
    $(document).ready(function () {
      $('.image_upload').imageuploadify();
    });

    // data table 1
    $('#examples1').DataTable({
      'lengthChange': true,
    });

    $('.data_tables, dataTable').DataTable({
      'lengthChange': true,
      "language": {
        "lengthMenu": showText + "_MENU_",
        "zeroRecords": not_found_Text,
        "search": searchText,
        "info": `${showingText} _START_ ${to} _END_ ${of} _TOTAL_ ${entriesText}`,
        "infoEmpty": `${showingText} 0 ${to} 0 ${of} 0 ${entriesText}`,
        "paginate": {
          "first": firstText,
          "last": lastText,
          "next": nextText,
          "previous": previousText
        },
      }

    });



    // data table 2
    $('#example2').DataTable({
      'lengthChange': true,
    });

    // select2
    $('.select2').select2({
      placeholder: select,
    });

    $('.knob').knob();

    // full calendar 
    $('#calendar').datepicker("setDate", new Date());

    $('.textarea').summernote({
      fontSizes: ['8', '9', '10', '11', '12', '14', '18', '20', '30', '50'],
      height: 100,
      codemirror: { // codemirror options
        theme: 'monokai',
        mode: 'text/html',
        lineNumbers: true,
        htmlMode: true,
      },
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video', 'hr']],
        ['view', ['fullscreen', 'codeview']],
        ['fontsize', ['fontsize']],
        ['help', ['help']]
      ],

    });

    $('.data_textarea').summernote({
      height: 100,
      codemirror: { // codemirror options
        theme: 'monokai',
        mode: 'text/html',
        lineNumbers: true,
        htmlMode: true,
      },
      toolbar: [
        ['font', ['bold', 'italic', 'underline', 'clear']],
      ],


    });



    /**
      ** tag selector
    **/
    $('.chosen-select').chosen({
      width: "100%",
      max_selected_options: 4,
      placeholder_text_multiple: "Select Tags",

    });

    $('.multiselct').chosen({
      width: "100%",
      max_selected_options: 20,
      placeholder_text_multiple: select_items,

    });


    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
      defaultTime: '10:00',
      format: 'hh:mm',
      use24hours: true,
      showMeridian: false,
      minuteStepping: 10,
      rtl: rtl,
    });

    

  });
	
	para o código abaixo. Dessa forma as datas são convertidas no formato ingles mas são exibidas em formato pt-BR 
	
	
 /// calendário da parte de adicionar cupom de desconto ///
jQuery(document).ready(function () {
    // Ativação do Datepicker do Cupom de Desconto Logista
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy', // Define o formato para dd/mm/yyyy
        language: 'pt-BR', // Define o idioma para português brasileiro
        autoclose: true, // Fecha o calendário após seleção
    });

    // Converte o formato da data ao submeter o formulário
    $('.validForm').on('submit', function (e) {
        // Itera sobre todos os campos de data
        $('.datepicker').each(function () {
            let userDate = $(this).val(); // Data no formato dd/mm/yyyy
            if (userDate) {
                // Converte a data para o formato yyyy-mm-dd
                let dateParts = userDate.split('/');
                let formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                $(this).val(formattedDate); // Atualiza o valor do campo
            }
        });
    });

    // Relógio dinâmico
    $(function () {
        var datetime = null;
        var update = function () {
            datetime.html(moment().format('h:mm:ss a'));
        };

        $(document).ready(function () {
            datetime = $('#time');
            update();
            setInterval(update, 1000);
        });
    });

    // Ativação do Imageuploadify
    $('.image_upload').imageuploadify();

    // DataTable configurações
    $('#examples1').DataTable({
        'lengthChange': true,
    });

    $('.data_tables, .dataTable').DataTable({
        'lengthChange': true,
        "language": {
            "lengthMenu": showText + "_MENU_",
            "zeroRecords": not_found_Text,
            "search": searchText,
            "info": `${showingText} _START_ ${to} _END_ ${of} _TOTAL_ ${entriesText}`,
            "infoEmpty": `${showingText} 0 ${to} 0 ${of} 0 ${entriesText}`,
            "paginate": {
                "first": firstText,
                "last": lastText,
                "next": nextText,
                "previous": previousText
            },
        }
    });

    $('#example2').DataTable({
        'lengthChange': true,
    });

    // Select2 configuração
    $('.select2').select2({
        placeholder: select,
    });

    $('.knob').knob();

    // Full calendar configuração
    $('#calendar').datepicker("setDate", new Date());

    $('.textarea').summernote({
        fontSizes: ['8', '9', '10', '11', '12', '14', '18', '20', '30', '50'],
        height: 100,
        codemirror: { 
            theme: 'monokai',
            mode: 'text/html',
            lineNumbers: true,
            htmlMode: true,
        },
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview']],
            ['fontsize', ['fontsize']],
            ['help', ['help']]
        ],
    });

    $('.data_textarea').summernote({
        height: 100,
        codemirror: { 
            theme: 'monokai',
            mode: 'text/html',
            lineNumbers: true,
            htmlMode: true,
        },
        toolbar: [
            ['font', ['bold', 'italic', 'underline', 'clear']],
        ],
    });

    // Tag selector configuração
    $('.chosen-select').chosen({
        width: "100%",
        max_selected_options: 4,
        placeholder_text_multiple: "Select Tags",
    });

    $('.multiselct').chosen({
        width: "100%",
        max_selected_options: 20,
        placeholder_text_multiple: select_items,
    });

    // Timepicker configuração
    $('.timepicker').timepicker({
        showInputs: false,
        defaultTime: '10:00',
        format: 'hh:mm',
        use24hours: true,
        showMeridian: false,
        minuteStepping: 10,
        rtl: rtl,
    });
});
 // fim datepicker cupom 
 
 
 --------------------------------------------------------------------------
 Para traduzir os meses no gráfico de vendas,   traduzir as abreviações dos meses em cardapio.delivery/application/helpers/custom_helper.php

if (!function_exists('get_month')) {
    function get_month()
    {
        $days = array(
            '01' => 'Jan',
            '02' => 'Fev',
            '03' => 'Mar',
            '04' => 'Abr',
            '05' => 'Mai',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ago',
            '09' => 'Set',
            '10' => 'Out',
            '11' => 'Nov',
            '12' => 'Dez',
        );
        return $days;
    }
}
 Se desejar pode traduzir também os dias da semana




if (!function_exists('get_days')) {
    function get_days()
    {
        $days = array(
            '0' => 'Domingo',
            '1' => 'Segunda',
            '2' => 'Terça',
            '3' => 'Quarta',
            '4' => 'Quinta',
            '5' => 'Sexta',
            '6' => 'Sábado',
        );
        return $days;
    }
}

if (!function_exists('get_off_days')) {
    function get_off_days($type = 'days')
    {
        $days = array(
            '0' => lang('Domingo'),
            '1' => lang('Segunda'),
            '2' => lang('Terça'),
            '3' => lang('Quarta'),
            '4' => lang('Quinta'),
            '5' => lang('Sexta'),
            '6' => lang('Sábado'),
        );
        if ($type == 'days') :
            return $days;
        else :
            return $days[$type];
        endif;
    }
}





O código que chama a função do gráfico fica no cardapio.delivery/application/views/backend/inc/footer.php, mas não precisa alter desde que traduza em custom_helper.

------------------------------------------------------------------------------------------------------------------------------------------------------

Para traduzir o relatório de ganhos é necessário modificar dois arquivos :

cardapio.delivery/application/views/backend/reports/earnings.php   para : <?php
// Função para traduzir a data usando DateTime e IntlDateFormatter
if (!function_exists('translateDate')) {
    function translateDate($date, $format = 'EEEE, d de MMMM de yyyy') {
        $dateObj = new DateTime($date);
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo', // Defina o fuso horário correto, se necessário
            IntlDateFormatter::GREGORIAN
        );
        $formatter->setPattern($format);
        return $formatter->format($dateObj);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"></script>
</head>
<body>
<div class="row no-print">
    <div class="col-md-10">
        <?php include APPPATH.'views/backend/reports/incomeBadge.php'; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header no-print">
                <h4 class="m-0 mr-5"> <?= lang('earnings');?> </h4>
            </div>
            <div class="card-body pt-0">
                <div class="action-buttons exportPrintBtn mt-10">
                    <a href="javascript:;" onclick="printDiv('printArea')" class="btn btn-success-light"
                       data-title="Print">
                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                        <?= !empty(lang('print'))?lang('print'):"Print" ;?>
                    </a>
                    <?php if(check()==1): ?>
                        <a id="exportBtn" href="javascript:;" class="btn btn-gray-light" data-title="PDF">
                            <i class="mr-1 fa fa-file-pdf-o text-danger-m1 text-120 w-2"></i>
                            <?= !empty(lang('export'))?lang('export'):"Export" ;?>
                        </a>
                    <?php endif;?>
                </div>
                <div id="printArea">
                    <div class="salesDropdownArea mb-5 mt-5">
                        <ul>
                            <li><a href="<?= base_url("admin/reports/earnings");?>"><span class="btn btn-gray-light"><?= lang('all_time');?></span></a></li>
                            <li><a href="<?= base_url("admin/reports/earnings/".(!empty($year) ? $year : 0)); ?>">
                                <?= !empty($year) ? '<span>/</span>' . $year : ""; ?>
                            </a></li>
                            <li><a href="<?= base_url("admin/reports/earnings/".(!empty($year) ? $year : 0).'/'.(!empty($month) ? $month : 0)); ?>">
                                <?= !empty($month) ? '<span>/</span>' . translateDate("$year-$month-01", 'MMMM') : ""; ?>
                            </a></li>
                            <?php if(isset($_GET['d']) && !empty($_GET['d'])): ?>
                                <li><a href="javascript:;">
                                    <?= !empty($month) ? '<span>/</span>' . translateDate("$year-$month-".$_GET['d'], 'EEEE, d') : ""; ?>
                                </a></li>
                            <?php endif ?>
                        </ul>
                    </div>
                    <div class="card-content">
                        <div class="earningTables">
                            <?php include 'inc/all_time_earnings.php'; ?>
                        </div>
                    </div><!-- card-content -->
                </div><!-- printArea -->

            </div><!-- card-body -->

        </div><!-- card -->
    </div>
</div>

<!-- printThis -->
<script type="text/javascript" src="<?= base_url();?>assets/frontend/html2pdf/html2pdf.bundle.js"></script>

<script>
var order = "<?= random_string('numeric', 4);?>";
// $('#printBtn').on("click", function () {
//     window.print();   
// });

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}

$('#exportBtn').on("click", function() {
    var element = document.getElementById('print_area');
    var opt = {
        // margin:    1,
        filename: 'order_' + order + '.pdf',
        image: {
            type: 'jpeg',
            quality: 0.98
        },
        html2canvas: {
            scale: 2
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
        }
    };

    html2pdf().set(opt).from(element).save();
});

$(document).ready(function() {
    const translate = {
        "January": "Janeiro", "February": "Fevereiro", "March": "Março", "April": "Abril", "May": "Maio", "June": "Junho",
        "July": "Julho", "August": "Agosto", "September": "Setembro", "October": "Outubro", "November": "Novembro", "December": "Dezembro",
        "Sunday": "Domingo", "Monday": "Segunda-feira", "Tuesday": "Terça-feira", "Wednesday": "Quarta-feira", "Thursday": "Quinta-feira", "Friday": "Sexta-feira", "Saturday": "Sábado"
    };

    function translateTable() {
        $('table td, table th').each(function() {
            let text = $(this).text();
            let newText = text;

            Object.keys(translate).forEach(key => {
                const regex = new RegExp(key, "g");
                newText = newText.replace(regex, translate[key]);
            });

            if (newText !== text) {
                $(this).text(newText);
            }
        });
    }

    translateTable();
    setInterval(translateTable, 1000); // Atualiza a tradução periodicamente
});
</script>
</body>
</html>







e /www/wwwroot/cardapio.delivery/application/views/backend/reports/inc/all_time_earnings.php por



<?php
// Função para traduzir a data usando DateTime e IntlDateFormatter
if (!function_exists('translateDate')) {
    function translateDate($date, $format = 'EEEE, d de MMMM de yyyy') {
        $dateObj = new DateTime($date);
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo', // Defina o fuso horário correto, se necessário
            IntlDateFormatter::GREGORIAN
        );
        $formatter->setPattern($format);
        return $formatter->format($dateObj);
    }
}

if (!function_exists('translateMonth')) {
    function translateMonth($date) {
        return translateDate($date, 'MMMM');
    }
}

if (!function_exists('translateDay')) {
    function translateDay($date) {
        return translateDate($date, 'EEEE, d');
    }
}
?>

<div class="table-responsive" id="print_area">
    <table class="table table-striped table-hover" id="myTable">
        <thead>
            <tr class="tableHeader">
                <?php if(!empty($year) && !empty($month) && isset($_REQUEST['d']) && !empty($_REQUEST['d'])): ?>
                    <th><?= lang('order_id');?></th>
                <?php else: ?>
                    <th><?= lang('date');?></th>
                <?php endif ?>
                <th><?= lang('total_order');?></th>
                <th><?= lang('item_sales_count');?></th>
                <th><?= lang('earnings');?></th>
            </tr>
        </thead>
        <tbody>
            <?php $total_order = $total_item = $total_price = 0; ?>
            <?php foreach ($earning_list as $row): ?>
                <?php if(isset($row['completed_time']) && !empty($row['completed_time'])): ?>
                    <?php
                        if(!empty($year) && !empty($month) && isset($_REQUEST['d']) && !empty($_REQUEST['d'])):
                            $url = base_url("admin/restaurant/get_item_list_by_order_id/{$row['uid']}");
                            $title = '#'.$row['uid'];
                        else:
                            if(empty($year) && empty($month)):
                                $url = base_url("admin/reports/earnings/".year($row['completed_time']).'/0');
                                $title = year($row['completed_time']);
                            elseif(!empty($year) && empty($month)):
                                $url = base_url("admin/reports/earnings/".year($row['completed_time'])."/".month($row['completed_time']));
                                $title = translateMonth($row['completed_time']);
                            elseif(!empty($year) && !empty($month)):
                                $url = base_url("admin/reports/earnings/".year($row['completed_time'])."/".month($row['completed_time']).'?d='.day($row['completed_time']));
                                $title = translateDay($row['completed_time']);
                            endif;
                        endif;
                     ?>
                    <tr>
                        <td><a href="<?= $url;?>"><?= $title;?></a></td>
                        <td><?= $row['total_order'];?></td>
                        <td><?= $row['total_item'];?></td>
                        <td><?= currency_position($row['total_price'],restaurant()->id);?></td>
                    </tr>
                    <?php
                        $total_order += $row['total_order'];
                        $total_item +=$row['total_item'];
                        $total_price += $row['total_price'];
                     ?>
                <?php endif;?>    
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="tableTotal">
                <td><?= lang('total');?></td>
                <td><?= $total_order;?></td>
                <td><?= $total_item;?></td>
                <td><?= currency_position($total_price,restaurant()->id);?></td>
            </tr>
        </tfoot>
    </table>
</div>

---------------------------------------------------------------------------------

Mudar formato da data nas notificações do painel do logista :

Em cardapio.delivery/application/views/backend/notify/my_notifications.php na linha 17 usar a função full_time : 	<p><?= full_time($row['send_at']); ?></p>

------------------------------------------------------------------------------------------------------
---------------------------------------------------------------
 para traduzir o calendário de retirar o pedido na loja e salvar corretamente as datas no formato BR, é necessário no arquivo cardapio.delivery/public/frontend/js/auth.js por volta da linha 460
 alterar a função datepicker-1 por esta
 
 $(".datepicker-1").flatpickr({
    enableTime: false, // Apenas seleção de datas
    dateFormat: "Y-m-d", // Formato americano para o banco de dados
    altInput: true, // Habilita o campo alternativo
    altFormat: "d/m/Y", // Formato exibido para o usuário
    locale: "pt", // Tradução para português
    onChange: function (selectedDates, dateStr, instance) {
        // Atualiza o valor do campo principal com o formato americano
        const formattedDate = instance.formatDate(selectedDates[0], "Y-m-d");
        instance.input.value = formattedDate; // Garante que o valor principal esteja no formato correto
    }
});

// Ajustar o envio do formulário para garantir o formato americano
$('form').on('submit', function () {
    $(".datepicker-1").each(function () {
        const pickerInstance = $(this).data("flatpickr"); // Obtém a instância do Flatpickr
        if (pickerInstance) {
            const selectedDate = pickerInstance.selectedDates[0];
            if (selectedDate) {
                // Atualiza o valor principal com o formato americano
                const formattedDate = pickerInstance.formatDate(selectedDate, "Y-m-d");
                $(this).val(formattedDate);
            }
        }
    });
});

Após isso adicionar no css personalizado para ajustar o tamanho do campo do calendário no dispositivo movel : 

.flatpickr-alt-input {
    width: 100%; /* Garante que o campo tenha largura suficiente */
    max-width: 300px; /* Limita a largura máxima */
    font-size: 16px; /* Ajusta o tamanho da fonte */
    padding: 5px; /* Define o espaçamento interno */
    box-sizing: border-box; /* Garante que padding e borda não afetem o tamanho */
}
.datepicker-1 {
    width: 100%; /* Garante que o campo ocupe toda a largura disponível */
    max-width: 300px; /* Define um limite máximo de largura */
    padding: 5px; /* Ajusta o espaçamento interno */
    font-size: 16px; /* Certifique-se de que a fonte não é muito grande */
    box-sizing: border-box; /* Inclui padding e borda no cálculo da largura */
}

Após isso no arquivo cardapio.delivery/application/views/frontend/inc/footer.php adicionar os scripts a ser importados para tradução do calendário flatpickr : 
             <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
             <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
			 
			 
			 ---------------------------------------------------------------------------------------
			 
			 
Para traduzir o calendário retirar o pedido na loja para modul  PDV 

Atenção, no footer.php do backend, inserir antes do slim :    <!-- Flatpickr Principal -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/pt.js"></script>
  
  
  tem que ficar entre : <script src="<?php echo base_url() ?>assets/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> e  <script src="<?php echo base_url() ?>assets/admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js">
  </script>
Após isso no header.php do backend inserir o css do flatpickr:  <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">  antes de <link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/plugins/datetime_picker/datetime.css">

No arquivo picker.php alter onde tiver datepicker-1 para datepicker-3 ou altere o script abaixo. 

No arquivo public\admin\pos.js  altere  o código abaixo : 
	/*----------------------------------------------
						PICKUP ORDER
	----------------------------------------------*/



	/*----------------------------------------------
						SET PICKUP DETAILS Temp_data
	----------------------------------------------*/
	function setPickupDetails() {
		var pickupArea = $('.singleSlots.active').data('title');
		var pickupTime = $('input[name="pickup_time"]:checked').val();
		var pickupDate = $('input[name="pickup_date"]').val();
		var pickupId = $('input[name="pickup_point_id"]:checked').val();
		var today = $('input[name="today"]:checked').val();
		const arr = { 'pickupArea': pickupArea, 'pickupTime': pickupTime, 'pickupDate': pickupDate, 'pickup_point_id': pickupId, 'today': today };
		const jsonData = JSON.stringify(arr);


		var url = `${base_url}admin/pos/pickup_details/`;
		$.post(url, { 'data': jsonData, 'shop_id': shopId, 'csrf_test_name': csrf_value }, function (json) {
			if (json.st == 1) {
				updateOrderType(json.result);
				orderDetails(true, json.shopId);
			}

		}, 'json');
		return false;
	}






	function pickupTime() {

		var day = $('.off_days').data('day');

		$(".datepicker-1").flatpickr({
			enableTime: false,
			dateFormat: "Y-m-d",
			minDate: new Date().fp_incr(1),
			defaultDate: new Date().fp_incr(1),
			"disable": [
				function (date) {
					var events = ''; //{}
					var d = date.getDay();
					$.each(day, function (i, v) {
						if (v == d) {
							events = true;
						}
					})
					return events;
				},
			],

		});

	};


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



	function get_pickup_time(shopID, type) {
		$('.pickupTimeSlots').addClass('null').html(loader_gray);
		var url = `${base_url}profile/get_pickup_available_time/${shopID}/${type}`;
		$.post(url, { 'csrf_test_name': csrf_value }, function (json) {
			if (json.st == 1) {
				setTimeout(() => {
					$('.pickupTimeSlots').removeClass('null');
					$('.pickupTimeSlots').html(json.load_data);
				}, 1000)

			}
		}, 'json');
	}


	// click the time slot for show order details
	$(document).on('change', '.timeChecked', function (event) {
		$('.single_slots').removeClass('active');
		if ($(this).is(':checked')) {
			$(this).parent('.single_slots').addClass('active');
			setPickupDetails();
		}
	});


por este aqui ajustado para traduzir o calendário e salvar corretamente no banco sem erro e ainda não tem erros no console : 

/*----------------------------------------------
    INICIALIZAR CALENDÁRIO PICKUP TIME
----------------------------------------------*/
function pickupTime() {
    var day = $('.off_days').data('day');
    $(".datepicker-3").flatpickr({
        enableTime: false,
        dateFormat: "Y-m-d", // Salva no formato americano
        altInput: true,
        altFormat: "d/m/Y", // Mostra no formato brasileiro
        locale: flatpickr.l10ns.pt, // Tradução para português
        minDate: new Date().fp_incr(1), // Data mínima: amanhã
        defaultDate: new Date().fp_incr(1), // Data padrão: amanhã
        disable: [
            function(date) {
                var isDisabled = false;
                var dayOfWeek = date.getDay();
                $.each(day, function(i, v) {
                    if (v == dayOfWeek) {
                        isDisabled = true;
                    }
                });
                return isDisabled;
            }
        ],
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                const formattedDate = instance.formatDate(selectedDates[0], "Y-m-d");
                instance.input.value = formattedDate;
            }
        }
    });
}

/*----------------------------------------------
    OBTÉM HORÁRIOS DE COLETA DISPONÍVEIS
----------------------------------------------*/
window.get_pickup_time = function(shopID, type) {
    $('.pickupTimeSlots').addClass('null').html(loader_gray);
    var url = `${base_url}profile/get_pickup_available_time/${shopID}/${type}`;

    $.post(url, { 
        'csrf_test_name': csrf_value 
    }, function(json) {
        if (json.st == 1) {
            setTimeout(() => {
                $('.pickupTimeSlots').removeClass('null');
                $('.pickupTimeSlots').html(json.load_data);
            }, 1000);
        } else {
            console.error("Erro ao obter horários de coleta:", json.msg);
        }
    }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Erro na requisição AJAX:", textStatus, errorThrown);
    });
};

/*----------------------------------------------
    EVENTOS DE CLICK E ALTERAÇÃO
----------------------------------------------*/
$(document).on('click', '.pickup_date_checker', function() {
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

$(document).on('change', '.timeChecked', function() {
    $('.single_slots').removeClass('active');
    if ($(this).is(':checked')) {
        $(this).parent('.single_slots').addClass('active');
        setPickupDetails();
    }
});
------------------------------------------------
para traduzir demais calendários do Restaurante / Backend (datepicker) vá em  public\admin\main.js e alterar a função na linha 51 

 //active date picker
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd',
      rtl: rtl,
    });

por esta : essa já alterar  os placeholder para dd/mm/aaaa e traduz o calendário  


$(document).ready(function () {
    // Configuração do datepicker
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy', // Formato de exibição para o usuário
        language: 'pt-BR', // Traduz para Português
        autoclose: true, // Fecha automaticamente ao selecionar uma data
        todayHighlight: true, // Destaca o dia atual
        startDate: new Date(), // Define a data mínima como hoje
        orientation: "bottom auto", // Ajusta a orientação automática
    });

    // Define o placeholder em todos os campos com a classe datepicker
    $('.datepicker').attr('placeholder', 'dd/mm/aaaa');

    // Converte a data carregada (formulário de edição) para dd/mm/yyyy
    $('.datepicker').each(function () {
        var currentVal = $(this).val();
        if (currentVal && currentVal.includes('-')) {
            // Converte de yyyy-mm-dd para dd/mm/yyyy
            var parts = currentVal.split('-');
            var formattedDate = parts[2] + '/' + parts[1] + '/' + parts[0];
            $(this).val(formattedDate);
        }
    });

    // Ao enviar o formulário, converte para formato americano yyyy-mm-dd
    $('form').on('submit', function () {
        $('.datepicker').each(function () {
            var dateVal = $(this).val();
            if (dateVal && dateVal.includes('/')) {
                // Converte de dd/mm/yyyy para yyyy-mm-dd
                var parts = dateVal.split('/');
                var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                $(this).val(formattedDate);
            }
        });
    });
});
	
	----------------------------------------------
	Corrigir Painel de pedidos tradução de Order Time e o title ao posicionar o mouse sobre os itens do painel 
	
	cardapio.delivery/application/views/backend/order/inc/
	
	backend/order/inc/orderList_thumb.php:                                   
    backend/order/inc/orderList_grid.php:
	backend/order/order_ajax_view.php
	backend/order/order_item_list.php
	backend/order/inc/order_details_thumb.php:
	/backend/restaurant/reservation_list.php
	
	exemplo :  <label class="label bg-primary-soft" data-toggle="tooltip" title="Horário">
	
	--------------------------------------------------------------------------------------------------
	
	Corrigir status do botão Aceitar/Aceito quando clica em alterar pedido : 
	
	em cardapio.delivery/application/views/backend/order/inc/orderList_thumb.php  subistituir :  <?php elseif ($row['status'] == 1) : ?>
    <label class="label info-light" data-toggle="tooltip" title="Aceito pelo Restaurante"><i class="fa fa-check"></i>
        <?= lang('accept'); ?></label>

por 

<?php elseif ($row['status'] == 1) : ?>
    <label class="label info-light" data-toggle="tooltip" title="Aceito pelo Restaurante"><i class="fa fa-check"></i>
        <?= $row['status'] == 1 ? lang('accepted') : lang('accept'); ?></label>
 
 --------------------------------------------------------------------------------------------------------------
 cardapio.delivery/application/views/backend/order/order_ajax_view.php
 
 
 Agora para arrumar o status do pedido já aceito na janela lateral que abre ao clicar no olho  (Ajax View) : substituir : 
 <?php if ($order['status'] == 0) : ?>
    <a href="<?= base_url('admin/restaurant/order_status_by_ajax/' . $order['uid']) . '/1'; ?>" data-shop="<?= $order['shop_id']; ?>" class="orderStatus btn btn-info" title="Marcar como Aceito"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a>
<?php elseif ($order['status'] == 1) : ?>
    <a href="javascript:;" class="btn info-light-active" data-shop="<?= $order['shop_id']; ?>" data-toggle="tooltip" title="Marcar como Aceito"><i class="fa fa-check"></i> &nbsp;
        <?= lang('accept'); ?> </a>

por 

<?php if ($order['status'] == 0) : ?>
    <a href="<?= base_url('admin/restaurant/order_status_by_ajax/' . $order['uid']) . '/1'; ?>" data-shop="<?= $order['shop_id']; ?>" class="orderStatus btn btn-info" title="Marcar como Aceitar"><i class="icofont-hand-drag1"></i> &nbsp; <?= lang('accept'); ?> </a>
<?php elseif ($order['status'] == 1) : ?>
    <a href="javascript:;" class="btn info-light-active" data-shop="<?= $order['shop_id']; ?>" data-toggle="tooltip" title="Marcar como Aceito"><i class="fa fa-check"></i> &nbsp;
        <?= lang('accepted'); ?> </a>


--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
 
 Para traduzir o texto alt (title) de Especialidades da Casa no home page do restaurante :
 
 root@vmid2321:/www/wwwroot/cardapio.delivery/application/views# grep -R "Quick View"
Traduzir o title em : /application/views/layouts/special_thumb.php:                          <a href="javascript:;" class="quick_view" data-type='specialties'  data-id="<?=  html_escape($row['id']);?>" data-placement="top" data-toggle=""  title="Quick View"><i class="icofont-eye-open"></i> <?= lang('details'); ?></a>

----------------------------------------------------------------------------------------------
Traduzir Mensagem de upload de fotos dos pratos 


assets/admin/uploader/uploadify.js:                            <span class='imageuploadify-message'>Drag&Drop Your File(s)Here To Upload</span>

 
--------------------------------------------------------------------------------------------------------------------------------------------------------------
Traduzir Backend do Restaurante : Mostrar na página inicial 

root@vmid2321:/www/wwwroot/cardapio.delivery# grep -R "show in home page"
application/views/backend/menu/dine_in.php:                                                                                             &nbsp; <label class="label label-success" title="show in home page"><i class="fa fa-home"></i></label>
application/views/backend/menu/specialties.php:                                                                                         &nbsp; <label class="label label-success" title="show in home page"><i class="fa fa-home"></i></label>
application/views/backend/menu/item_list.php:                                                                                                   <label class="label bg-success-soft" data-toggle="tooltip" title="show in home page"><i class="fa fa-home"></i></label>
application/views/backend/menu/item_list.php:                                           <p>1 = show in home page / landing page.</p>
application/views/backend/menu/packages.php:                                                                                            &nbsp; <label class="label label-success" title="show in home page"><i class="fa fa-home"></i></label>

--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------TraTraduzir texto alt (title) Add to Card e Add Cart :

Segue a lista dos arquivos e seus respectivos diretórios onde a palavra "Add to Cart" foi encontrada:

theme3/single_packages.php
theme3/home.php --
theme1/include/item_thumbs.php --
theme1/single_packages.php ---
theme1/home.php ---
theme2/include/item_thumbs.php ---
theme2/single_packages.php ---
theme2/home.php ---
layouts/special_thumb.php ----
Esses arquivos estão localizados no diretório /www/wwwroot/cardapio.delivery/application/views/. 

Agora para Add Cart :

Segue a lista dos arquivos e seus respectivos diretórios onde a palavra "Add Cart" foi encontrada:

backend/pos/inc/ajax_item_details_modal.php
layouts/ajax_package_special_details_modal.php
layouts/inc/item_details_thumb.php
layouts/inc/item_details_thumb_2.php
layouts/ajax_item_modal_1.php
Esses arquivos estão localizados no diretório /www/wwwroot/cardapio.delivery/application/views/.

---------------------------------------------------------------------------------------

Traduzir Mensagem de Carregamento e Busca 

public/frontend/css/style.css:    content: 'Submiting...';
public/frontend/css/style.css:        content: 'Submiting'
public/frontend/css/style.css:        content: 'Submiting.'
public/frontend/css/style.css:        content: 'Submiting..'
public/frontend/css/style.css:        content: 'Submiting...'
public/frontend/css/style.css:        content: 'Submiting...'	

@keyframes animation7submiting {
    0% {
        content: 'Carregando'
    }

    25% {
        content: 'Carregando.'
    }

    50% {
        content: 'Carregando..'
    }

    75% {
        content: 'Carregando...'
    }

    100% {
        content: 'Carregando...'
    }
}

e  

@keyframes animation7searching {
    0% {
        content: 'Por favor aguarde, '
    }

    15% {
        content: 'Por favor aguarde, Pes.'
    }

    30% {
        content: 'Por favor aguarde, Pesq..'
    }

    45% {
        content: 'Por favor aguarde, Pesqui..'
    }

    55% {
        content: 'Por favor aguarde, Pesquis..'
    }

    75% {
        content: 'Por favor aguarde, Pesquisa...'
    }

    85% {
        content: 'Por favor aguarde, Pesquisan...'
    }

    95% {
        content: 'Por favor aguarde, Pesquisand...'
    }

    100% {
        content: 'Por favor aguarde, Pesquisando...'
    }
}

---------------------------------------------------------------------

Traduzir Qty e sub_total no checkout :  traduzir linhas 86 a 89
cardapio.delivery/application/views/layouts/inc/checkout_total_area.php


-------------------------------------------------------
Para traduzir ordem da Palavra Ilimitado Itesn nos planos (preços)

No arquivo cardapio.delivery/application/views/frontend/inc/pricing_2.php ou pricing_1.php a linha :  <?= html_escape($feature['slug']) == 'menu' ? ' <b>(' . limit_text($package['item_limit']) . ' ' . lang('items') . ') </b>' : ''; ?>


 por  
 
 <?= html_escape($feature['slug']) == 'menu' ? ' <b>(' . lang('items') . ' ' . limit_text($package['item_limit']) . ') </b>' : ''; ?>