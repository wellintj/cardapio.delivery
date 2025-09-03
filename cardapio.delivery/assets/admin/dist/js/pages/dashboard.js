/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict';

  // Make the dashboard widgets sortable Using jquery UI
  $('.connectedSortable').sortable({
    placeholder         : 'sort-highlight',
    connectWith         : '.connectedSortable',
    handle              : '.box-header, .nav-tabs',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });
  $('.connectedSortable .box-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move');

  // jQuery UI sortable for the todo list
  $('.todo-list').sortable({
    placeholder         : 'sort-highlight',
    handle              : '.handle',
    forcePlaceholderSize: true,
    zIndex              : 999999
  });

  // bootstrap WYSIHTML5 - text editor
  // $('.textarea').wysihtml5();

  // Atualiza o locale do moment para traduzir os nomes dos meses
  moment.updateLocale('pt-br', {
    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
    weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
    weekdaysMin: ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sa']
  });

  // Adiciona estilo CSS para corrigir o fundo transparente
  $('<style>')
    .prop('type', 'text/css')
    .html(`
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
    `)
    .appendTo('head');

  // Sobrescreve a função de formatação para garantir tradução correta
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

  $('.daterange').daterangepicker({
    ranges   : {
      'Hoje'       : [moment(), moment()],
      'Ontem'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Últimos 7 Dias' : [moment().subtract(6, 'days'), moment()],
      'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
      'Este Mês'  : [moment().startOf('month'), moment().endOf('month')],
      'Mês Passado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    },
    locale: {
      applyLabel: 'Aplicar',
      cancelLabel: 'Cancelar',
      fromLabel: 'De',
      toLabel: 'Até',
      customRangeLabel: 'Personalizado',
      daysOfWeek: ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sa'],
      monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      firstDay: 1,
      format: 'D MMM YYYY'
    },
    startDate: moment().subtract(29, 'days'),
    endDate  : moment()
  }, function (start, end) {
    window.alert('Você escolheu: ' + start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
  });

  /* jQueryKnob */
  $('.knob').knob();

  
  // Sparkline charts
 

  // The Calender
  $('#calendar').datepicker();

  // SLIMSCROLL FOR CHAT WIDGET
  $('#chat-box').slimScroll({
    height: '250px'
  });



  // Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    area.redraw();
    donut.redraw();
    line.redraw();
  });

  /* The todo list plugin */
  $('.todo-list').todoList({
    onCheck  : function () {
      window.console.log($(this), 'The element has been checked');
    },
    onUnCheck: function () {
      window.console.log($(this), 'The element has been unchecked');
    }
  });

});
