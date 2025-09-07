(function ($) {
  "use strict";

  $(function () {
    $('input.icheck').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });


  var base_url = $('#base_url').attr('href');
  var csrf_value = $('#csrf_value').attr('href');
  var yes = $('#yes').attr('href');
  var no = $('#no').attr('href');
  var are_you_sure = $('#are_you_sure').attr('href');
  var cancel = $('#cancel').attr('href');
  var success = $('#success').attr('href');
  var warning = $('#warning').attr('href');
  var success_msg = $('#success_msg').attr('href');
  var error = $('#error').attr('href');
  var error_msg = $('#error_msg').attr('href');
  var item_deactive = $('#item_deactive').attr('href');
  var item_active = $('#item_active').attr('href');
  var want_to_reset_password = $('#want_to_reset_password').attr('href');
  var select = $('#select').attr('href');
  var searchText = $('#search').attr('href');
  var showText = $('#show').attr('href');
  var nextText = $('#next').attr('href');
  var previousText = $('#previous').attr('href');
  var firstText = $('#first').attr('href');
  var lastText = $('#last').attr('href');
  var not_found_Text = $('#not_found').attr('href');
  var showingText = $('#showing').attr('href');
  var entriesText = $('#entries').attr('href');
  var to = $('#to').attr('href');
  var of = $('#of').attr('href');
  var select_items = $('#select_items').attr('href');
  var please_wait_its_working = $('#please_wait_its_working').attr('href');
  var direction = $('#direction').attr('href');

  if(direction == 'rtl'){
    var rtl = true;
  }else{
    var rtl = false;
  }

  jQuery(document).ready(function () {
    //active date picker
    $('.datepicker').datepicker({
      format: 'dd/mm/yyyy', // Define o formato para dd/mm/yyyy (exibição para o usuário)
      language: 'pt-BR', // Define o idioma para português brasileiro
      autoclose: true, // Fecha o calendário após a seleção
      rtl: rtl,
      todayHighlight: true, // Destaca o dia atual
      todayBtn: 'linked', // Mostra o botão "hoje"
      startView: 'month', // Inicia na visualização de mês
      startDate: '01/01/1901', // Define data mínima razoável
      endDate: '31/12/2099', // Define data máxima razoável
      defaultViewDate: { 
        year: new Date().getFullYear(), 
        month: new Date().getMonth(), 
        day: new Date().getDate() 
      } // Define a data inicial como a data atual
    });

    // Converte o formato da data ao submeter o formulário
    $('.validForm').on('submit', function (e) {
      // Itera sobre todos os campos de data
      $('.datepicker').each(function () {
        let userDate = $(this).val(); // Data no formato dd/mm/yyyy
        if (userDate) {
          try {
            // Converte a data para o formato yyyy-mm-dd
            let dateParts = userDate.split('/');
            if (dateParts.length === 3) {
              let formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
              // Salva o formato original em um atributo data para poder restaurar após a submissão
              $(this).attr('data-original-date', userDate);
              // Atualiza o valor do campo para submissão
              $(this).val(formattedDate);
            }
          } catch (error) {
            console.error("Erro ao converter data:", error);
          }
        }
      });
    });

    // Atualiza o placeholder dos campos de data para o formato brasileiro
    $(document).ready(function() {
      $('.datepicker').attr('placeholder', 'dd/mm/aaaa');
      
      // Converte valores existentes do formato yyyy-mm-dd para dd/mm/yyyy
      $('.datepicker').each(function() {
        let dbDate = $(this).val(); // Data no formato yyyy-mm-dd
        if (dbDate && dbDate.match(/^\d{4}-\d{2}-\d{2}$/)) {
          try {
            // Converte a data para o formato dd/mm/yyyy para exibição
            let dateParts = dbDate.split('-');
            if (dateParts.length === 3) {
              let displayDate = `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
              $(this).val(displayDate);
            }
          } catch (error) {
            console.error("Erro ao converter data:", error);
          }
        }
      });
    });

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

  if ($(window).width() <= 991) {
    $(".wow").removeClass("wow");
  }
  //color picker with addon
  $('.my-colorpicker1').colorpicker();
  $('.my-colorpicker2').colorpicker();

  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  $(function () {
    $('.hide_details').hide();
    $(document).on('click', '.details_check', function (event) {
      $('.hide_details').toggle();
    });

  });

  $(function () {
    $(document).on('change', '.defaultToggle', function (event) {
      if ($(this).is(':checked')) {
        $('.hideArea').slideUp();
        $('.hideArea').removeClass('dis_none');
      } else {
        $('.hideArea').slideDown();
        $('.hideArea').removeClass('dis_none');
        console.log('not checked');
      }
    });

  });


  $(function () {
    $(document).on('click', '.check_password', function (event) {
      var val = $(this).val();
      $('.show_password').slideToggle();
    });

  });





  // Registration form
  $(function () {
    $(document).on('submit', '#user_insert_form', function (e) {
      var url = $(this).attr('action');
      $.post(url, $(this).serialize(), function (json) {
        if (json.st == 1) {
          $(".reg_msg").slideDown().html(json.msg);
          $("#user_insert_form")[0].reset();
        } else {
          $(".reg_msg").slideDown().html(json.msg);
        }
        setTimeout(function () { $('.reg_msg').fadeOut(); }, 2000);
      }, 'json');
      return false;
    });
  });



  // change Password form
  $(function () {
    $(document).on('submit', '#change_pass_form', function (e) {
      var url = $(this).attr('action');
      $.post(url, $(this).serialize(), function (json) {
        if (json.st == 1) {
          $(".reg_msg").slideDown().html(json.msg);
          $("#change_pass_form")[0].reset();
        } else {
          $(".reg_msg").slideDown().html(json.msg);
        }
        setTimeout(function () { $('.reg_msg').fadeOut(); }, 2000);
      }, 'json');
      return false;
    });
  });


  // ajax image upload
  $('.upload_img').on('change', (function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var formData = new FormData(this);
    $('.upload_progress').slideDown();
    $.ajax({
      type: 'POST',
      url: url,
      data: formData,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            $('.myprogress').text(percentComplete + '%');
            $('.myprogress').css('width', percentComplete + '%');
          }
        }, false);
        return xhr;
      },

      success: function (data) {
        if (data.st == 1) {
          MSG(1, data.msg);
          $('.uploaded_img').attr('src', base_url + data.img);
          $('.upload_progress').fadeOut();
        } else {
          $('.upload_progress').hide();
          $("html, body").animate({ scrollTop: 0 }, 600);
          $('#successMessage').html(`<div class="alert alert-danger alert-dismissible custom_alert" id="successMessage">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4>
            <i class="icon fa fa-close"></i>
            Error!
            </h4>
            ${data.msg}
            </div>`);
        }

      },
      error: function (e) {
        console.log(e.error);
      }
    });
  }));


  // ajax image upload
  $('.upload_pdf').on('change', (function (e) {
    e.preventDefault();
    var url = $(this).attr('action');
    var formData = new FormData(this);
    $('.pdf_upload_progress').slideDown();
    $.ajax({
      type: 'POST',
      url: url,
      data: formData,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            $('.myprogress').text(percentComplete + '%');
            $('.myprogress').css('width', percentComplete + '%');
          }
        }, false);
        return xhr;
      },

      success: function (data) {
        if (data.st == 1) {
          $('.uploaded_pdf').slideDown();
          $('.pdf_upload_progress').fadeOut();
          $("html, body").animate({ scrollTop: 0 }, 600);
          $('#successMessage').html(`<div class="alert alert-success alert-dismissible custom_alert" id="successMessage">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4>
            <i class="icon fa fa-check"></i>
            Success!
            </h4>
            ${data.msg}
            </div>`);
        } else {
          $('.pdf_upload_progress').hide();
        }

      },
      error: function () {
        console.log("error");
      }
    });
  }));

  //delete gallery image
  $(function () {
    $(document).on('click', '.img_delete', function () {
      var conf = confirm('Are You Want to delete this image');
      var id = $(this).attr('data-id');
      if (conf) {
        var url = base_url + 'admin/auth/delete_portfolio/' + id;
        $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
          if (json.st == 1) {
            $('#hide_image_' + id).slideUp();
            MSG(true, json.msg);
          }
        }, 'json');

        return false;
      }
    });
  });






  // social area
  $(function () {
    $(document).on('click', '.social_label', function (e) {
      var val = $(this).val();
      $(`.site_field_${val}`).toggleClass('hidden');
      var p = $(this).parent().toggleClass('label_active');
    });
  })


  // social area
  $(function () {
    $(document).on('click', '.toggle_btn', function (e) {
      $('.toggle_display').slideToggle();
    });
  })





  $(function () {
    var max_fields = 20; //maximum input boxes allowed
    var wrapper = $(".input_fields_wrap"); //Fields wrapper
    var add_button = $(".add_field_button"); //Add button ID
    var points = $('.total_points').val();
    var x = points; //initlal text box count
    $(add_button).on('click', function (e) {
      e.preventDefault();
      if (x < max_fields) { //max input box allowed
        x++; //text box increment
        $(wrapper).append(`<tr class="hide_${x}">
          <td>${x}</td>
          <td><input type="text" name="name[]" class="form-control"></td>
          <td><input type="text" name="latitude[]" class="form-control"></td>
          <td><input type="text" name="longitude[]" class="form-control"></td>
          <td><input type="text" name="address[]" class="form-control"></td>
          <td><a href="javascript:;" class="remove_field" data-id="${x}"><i class="fa fa-close"></i></a></td>
                </tr>`); //add input box
      } else {
        alert('Sorry Fields Limit exists');
      }
    });

    $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
      e.preventDefault();
      var id = $(this).attr('data-id');
      $('.hide_' + id).remove();
      x--;
    });

  });




  $(function () {
    $(document).on('change', '.layout_action', function () {
      var $this = $(this);
      var type = $(this).data('type');
      var value = $(this).val();
      remove_checked(type);
      var url = `${base_url}admin/auth/change_layouts/${type}/${value}`;
      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          MSG(true, success_msg);
          $this.addClass('active');
          $this.attr('checked', true);

        }
      }, 'json');
      return false;
    });


    function remove_checked(data) {
      $(`.layout_action`).removeClass('active');
      $(`.layout_action`).removeAttr('checked');
      return true;
    }



  });

  /**
    ***  accordion
  **/


  $(function () {
    $(".accordions").on("click", ".page_accordion_header", function () {
      $(this).toggleClass("active").next().slideToggle(300);
      $(this).toggleClass('arrow_up').toggleClass('arrow_down');
    });
  })

  $(function () {
    $(document).on('click', '.package_head', function () {
      var id = $(this).val();
      $(`.show_body_${id}`).slideDown();
    });
  });


  $(function () {
    $(document).on('change', '.email_option', function () {
      var id = $(this).val();
      if (id == 1) {
        $('.MailTrap').slideDown();
        $('.sendGrid, .smtpArea').slideUp();
      } else if (id == 2) {
        $('.smtpArea').slideDown();
        $('.sendGrid, .MailTrap').slideUp();
      } else if (id == 3) {
        $('.sendGrid').slideDown();
        $('.smtpArea, .MailTrap').slideUp();
      } else {
        $('.sendGrid, .smtpArea, .MailTrap').slideUp();
      }
    });
  });



  $(function () {
    $(document).on('change', '.country', function () {
      var id = $(this).val();
      var dial = $(this).find(':selected').data('dial');
      $('.currency').val(id).trigger('change');
      $('.dial_code').val(dial);
      $('.dialCcode').text(dial);
    });
  });

  /**
    ** Settings ==> registration / email verification
  **/

  $(function () {
    $(document).on('change', '.setting_option', function () {
      var type = $(this).data('type');
      var value = $(this).data('value');
      var setData = this;
      var url = `${base_url}admin/dashboard/setting_status/${type}/${value}`;
      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          if (value == 1) {
            MSG(2, item_deactive);
            $(setData).data('value', 0);
          } else {
            MSG(1, item_active);
            $(setData).data('value', 1);
          }

        }
      }, 'json');
      return false;
    });
  });


  $(function () {
    $(document).on('change', '.change_type_status', function () {
      var Id = $(this).data('id');
      var value = $(this).data('value');
      var table = $(this).data('table');
      var setData = this;
      var url = `${base_url}admin/auth/change_setting_status/${Id}/${value}/${table}`;
      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          if (value == 1) {
            MSG(2, item_deactive);
            $(setData).data('value', 0);
          } else {
            MSG(1, item_active);
            $(setData).data('value', 1);
          }

        }
      }, 'json');
      return false;
    });
  });



  /**
    ** change all items status using ajax
  **/

  $(function () {
    $(document).on('click', '.change_status', function (event) {
      var setData = this;
      var id = $(this).data('id');
      var status = $(this).data('status');
      var table = $(this).data('table');
      var url = `${base_url}admin/dashboard/change_content_status/${id}/${status}/${table}`;
      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          if (status == 1) {
            $(setData).data('status', 0);
            $(setData).html(`<i class="fa fa-close"></i>&nbsp; Hide`).removeClass('label-success').addClass('label-danger');
            MSG(false, item_deactive);
          } else {
            $(setData).data('status', 1);
            $(setData).html(`<i class="fa fa-check"></i>&nbsp; Live`).removeClass('label-danger').addClass('label-success');
            MSG(true, item_active);
          }
        }
      }, 'json');
      return false;
    });
  });

  function MSG(valid, msg) {
    if (valid == 0) {
      $.notify({
        icon: 'fa fa-close',
        title: error,
        message: msg
      }, {
        type: 'danger'
      }, {
        animate: {
          enter: 'animated fadeInDown',
          exit: 'animated fadeOutUp'
        }
      });

    } else if (valid == 1) {
      $.notify({
        icon: 'fa fa-check',
        title: success,
        message: msg
      }, {
        type: 'success'
      }, {
        animate: {
          enter: 'animated fadeInDown',
          exit: 'animated fadeOutUp'
        }
      });

    } else if (valid == 2) {
      $.notify({
        icon: 'fa fa-exclamation-triangle',
        title: warning,
        message: msg
      }, {
        type: 'warning'
      }, {
        animate: {
          enter: 'animated fadeInDown',
          exit: 'animated fadeOutUp'
        }
      });
    }
  }

  $(document).ready(function () {

    var data_length = ($('.null_alert').length);

    if (data_length > 0) {
      for (var i = 1; i <= data_length; i++) {
        var msg = $('#data_' + i).data('msg');
        setTimeout(empty_alert(msg), i + '000');
      }

    };

  })

  function empty_alert(msg) {
    $.notify({
      icon: 'fa fa-exclamation-triangle',
      title: 'Warning!',
      message: msg
    }, {
      type: 'warning'
    }, {
      animate: {
        enter: 'animated fadeInDown',
        exit: 'animated fadeOutUp'
      }
    });
  }

  /**
    ** ajax submit form
  **/
  $(function () {
    $(document).on('submit', '.form-submit', function (e) {
      e.preventDefault();

      if ($('.reg_msg').length == 0) {
        $(this).prepend('<span class="reg_msg"></span>');
      }
      $('.submit_btn').prop('disabled', true);

      var formData = new FormData(this); // Create a FormData object from the form

      var url = $(this).attr('action');

      $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (json) {
          if (json.st == 1) {
            $(".reg_msg").html(json.msg).slideDown();
            $(".form-submit")[0].reset();
            $('.customModal').modal('hide');
            $('.submit_btn').prop('disabled', false);
            if (json.url != '' && json.url != undefined) {
              if (json.url === 'reload') {
                window.location.reload();
              } else {
                window.location.href = addLangToUrl(json.url);
              }
            }
          } else {
            $(".reg_msg").html(json.msg).slideDown();
          }
          setTimeout(function () { $('.reg_msg').fadeOut(); }, 2000);
        },
        dataType: 'json'
      });

      return false;
    });

  });


  $(function () {
    $(document).on('submit', '.ajaxForm', function () {
      if ($('.reg_msg').length == 0) {
        $(this).prepend('<span class="reg_msg"></span>');
      }
      $('.ajaxForm  button[type="submit"]').prop('disabled', true);

      var url = $(this).attr('action');
      $.post(url, $(this).serialize(), function (json) {
        if (json.st == 1) {
          $(".reg_msg").html(json.msg).slideDown();
          $(".ajaxForm")[0].reset();
          $('.customModal').modal('hide');
          $('.submit_btn').prop('disabled', false);

          window.location.reload();
        } else {
          $(".reg_msg").html(json.msg).slideDown();
        }

        setTimeout(() => {
          $('.reg_msg').fadeOut();
          $('.ajaxForm  button[type="submit"]').prop('disabled', false);
        }, 2000);
      }, 'json');
      return false;
    });
  });


  $(function () {
    $(document).on('submit', '.addToCart_From', function () {
      console.log('added');
      var url = $(this).attr('action');
      $.post(url, $(this).serialize(), function (json) {
        if (json.st == 1) {
          $(".reg_msg").html(json.msg).slideDown();
          $(".addToCart_From")[0].reset();
        } else {
          $(".reg_msg").html(json.msg).slideDown();
        }
        setTimeout(function () { $('.reg_msg').fadeOut(); }, 2000);
      }, 'json');
      return false;
    });


    $(document).on('click', '.closeModal', function () {
      window.location.reload();
    });
  });



  $(document).on('click', '#pagination .ci-pagination li  a', function () {
    var url = $(this).attr("href");
    $.get(url, { 'csrf_test_name': csrf_value }, function (json) {
      if (json.st == 1) {
        $('#showItems').html(json.result);
      }
    }, 'json');
    return false;
  });



  $(function () {
    $(document).on('click', '#deleteImg', function (e) {
      e.preventDefault();
      var url = $(this).attr('href');
      var msg = $(this).data('msg');
      swal({
        title: "Are you sure?",
        text: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes do it!",
        cancelButtonText: "No",
        closeOnConfirm: false,
      }, function () {
        $.get(url, { 'csrf_test_name': csrf_value }, function (json) {
          if (json.st == 1) {
            swal({
              title: "Success",
              text: json.msg,
              type: "success",
              showCancelButton: false
            }, function () {
              $('.hideImg').slideUp();
            });
          }
        }, 'json');

        return false;
      });
    });
  });



  $(document).on('submit', '.ajaxSearch', function () {
    var url = $(this).attr("action");
    $.post(url, $(this).serialize(), function (json) {
      if (json.st == 1) {
        $('#showItems').html(json.result);
      }
    }, 'json');
    return false;
  });




  $(function () {

    /**
      ** readURL
    **/
    function service_URL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('.service_icon_preview').attr('src', e.target.result);
          $('.serviceImg').slideDown();
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    var _URL = window.URL || window.webkitURL;
    $(".service_img").on('change', function (e) {
      var container = this;
      var max_width = $(this).data('width');
      var max_height = $(this).data('height');
      var file, img;
      if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
          var height = this.height;
          var width = this.width;
          if (max_width != 0 && max_height != 0) {
            if (width <= max_width && height <= max_height) {
              service_URL(container);
              $('.img_error').html('');
            } else {
              $('.img_error').html(`Image Dimention should be less than ${max_width} x ${max_height} px`);
              $('.service_img').val('');
              $('.serviceImg').slideUp();
            }
          } else {
            service_URL(container);
            $('.img_error').html('');
          }

        };
        img.src = _URL.createObjectURL(file);
      }
    });
  });


  // /*=============================================
  // ***********  favicon uploader ********************
  // ================================================== */
  $(function () {

    /**
      ** readURL
    **/
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('.fav_icon_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    var _URL = window.URL || window.webkitURL;
    $(".load_img").on('change', function (e) {
      var container = this;
      var file, img;
      if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
          var height = this.height;
          var width = this.width;
          if (width <= 120 && height <= 120) {
            readURL(container);
            $('.fav_error').html('');
          } else {
            $('.fav_error').html(`Image Dimention should be less than 35 x 35`);
            $('.load_img').val('');
          }

        };
        img.src = _URL.createObjectURL(file);
      }
    });
  });


  /**
    ** toggle schedule option
  **/
  $(function () {
    $(document).on('click', '.schedule_input', function (event) {
      $('.schedule_post_view').slideToggle();
    });
  })


  // feature type changes
  $(function () {
    $(document).on('change', '.account_duration', function (event) {
      var val = $(this).val();
      if (val == 'free' || val == 'trial' || val == 'weekly' || val == 'fifteen') {
        $('.feature_price').slideUp();
      } else {
        $('.feature_price').slideDown();
      }

      if (val == 'trial') {
        $('.trial_text').slideDown();
      } else {
        $('.trial_text').slideUp();
      }
      if (val == "custom") {
        $('.showdurationArea').slideDown();
      } else {
        $('.showdurationArea').slideUp();
      }
    });
  })


  $(document).ready(function () {
    $('.layout-images').on('change', function () {
      var fields = $(this).data('id');
      var fileInput = $(this)[0];

      if (fileInput.files.length > 0) {
        var formData = new FormData();
        $.each(fileInput.files, function (k, file) {
          formData.append('file', file);
        });
        formData.append('csrf_test_name', csrf_value);

        $.ajax({
          method: 'post',
          url: base_url + "admin/profile/upload_banner_img/" + fields,
          data: formData,
          dataType: 'json',
          contentType: false,
          processData: false,
          success: function (data) {
            if (data.st == 1) {
              $(`#${fields}`).attr("src", base_url + data.url);
              $(`.banner_empty_text.${fields} `).slideUp();
              $(`.banner_image.${fields} `).slideDown();
              $(`#${fields} `).show();
              MSG(true, 'Banner image uploaded successfully')
              console.log(response);
            } else {
              $('.reg_msg').html(data.msg).slideDown();
            }
          }
        });
      } else {
        console.log('No Files Selected');
      }
    });

  });


  //delete banner img
  $(function () {
    $(document).on('click', '.banner_img_del', function () {
      var conf = confirm('Are You Want to delete this image');
      var id = $(this).attr('data-id');
      if (conf) {
        var url = base_url + 'admin/profile/delete_layout_banner/' + id;
        $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
          if (json.st == 1) {
            $(`.banner_empty_text.${id} `).slideDown();
            $(`.banner_image.${id} `).slideUp();
            // $('#hide_image_'+id).slideUp();
            MSG(true, json.msg);
          }
        }, 'json');

        return false;
      }
    });
  });



  //default alert for action
  $(function () {
    $(document).on('click', '.action_btn', function () {
      var link = $(this).attr('href');
      var msg = $(this).data('msg');
      swal({
        title: are_you_sure,
        text: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: yes,
        cancelButtonText: no,
        closeOnConfirm: false,
      }, function () {
        window.location.href = addLangToUrl(link);
      });
      return false;
    });
  });

  $(function () {
    $(document).on('click', '.delet_extra_img', function () {
      var url = $(this).attr('href');
      var msg = $(this).data('msg');
      var id = $(this).data('id');
      swal({
        title: "Are you sure?",
        text: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes do it!",
        cancelButtonText: "No",
        closeOnConfirm: false,
      }, function () {
        $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
          if (json.st == 1) {
            swal({
              title: "Success",
              text: json.msg,
              type: "success",
              showCancelButton: false
            }, function () {
              $(`#hide_${id}`).slideUp();
            });
          }
        }, 'json');

        return false;
      });
      return false;
    });
  });


  $(document).on('change', '.toggle_feature', function () {
    var toggle_feature = $(this);
    var id = toggle_feature.data('id');
    var value = toggle_feature.data('value');
    var lang = toggle_feature.data('lang');
    var url = `${base_url}admin/auth/features_toggle/${id}/${value}/${lang}`;
    $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
      if (json.st == 1) {
        toggle_feature.attr('data-value', json.value);
        MSG(true, success_msg);
      }
    }, 'json');
    return false;
  });

  $(document).on('click', '.waiterAccept', function () {
    var id = $(this).data('id');
    var url = $(this).attr('href');
    $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
      if (json.st == 1) {
        $(`#hide_${id}`).slideUp();
        MSG(true, success_msg);
        resetaudio();
      }
      if (json.load_data.length > 0) {
        $('#tableOrders').html(json.load_data);
      } else {
        if ($('#tableOrders').length == 1) {
          window.location.reload();
        }
      }
    }, 'json');
    return false;
  });



  //Reset Password
  $(function () {
    $(document).on('click', '.reset_password', function () {
      var id = $(this).data('id');
      swal({
        title: are_you_sure,
        text: want_to_reset_password,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: yes,
        cancelButtonText: cancel,
        closeOnConfirm: false
      },
        function () {
          var url = `${base_url}admin/dashboard/reset_password/${id}`;
          $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
            if (json.st == 1) {
              swal({
                title: success,
                text: "1234 is your new Password",
                type: "success",
                showCancelButton: false
              }, function () {

              });
            }
          }, 'json');

        });
      return false;
    });
  });


  //Reset Password
  $(function () {
    $(document).on('click', '.customer_password', function () {
      var id = $(this).data('id');
      swal({
        title: are_you_sure,
        text: want_to_reset_password,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: yes,
        cancelButtonText: cancel,
        closeOnConfirm: false
      },
        function () {
          var url = `${base_url}admin/auth/reset_customer_password/${id}`;
          $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
            if (json.st == 1) {
              swal({
                title: success,
                text: "1234 is your new Password",
                type: "success",
                showCancelButton: false
              }, function () {

              });
            }
          }, 'json');

        });
      return false;
    });
  });


  $(function () {
    $(document).on('click', '.staff_reset_password', function () {
      var id = $(this).data('id');
      swal({
        title: are_you_sure,
        text: want_to_reset_password,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: yes,
        cancelButtonText: cancel,
        closeOnConfirm: false
      },
        function () {
          var url = `${base_url}admin/auth/reset_password/${id}`;
          $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
            if (json.st == 1) {
              swal({
                title: success,
                text: "1234 is your new Password",
                type: "success",
                showCancelButton: false
              }, function () {

              });
            }
          }, 'json');

        });
      return false;
    });
  });



  $(function () {

    var _URL = window.URL || window.webkitURL;
    $(".ads_img").on('change', function (e) {
      var container = this;
      var id = $(this).data('id');
      var max_width = 1200;
      var max_height = 250;
      var file, img;
      if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
          var height = this.height;
          var width = this.width;
          if (max_width != 0 && max_height != 0) {
            if (width <= max_width && height <= max_height) {
              $('.img_error_' + id).html('');
              $('#ads_form_' + id).submit();
            } else {
              $('.img_error_' + id).html(`Image Dimention should be less than ${max_width} x ${max_height} px`);
              $('.ads_img').val('');
              $('#ads_details_' + id).slideDown();
            }
          } else {
            service_URL(container);
            $('.img_error_' + id).html('');
          }

        };
        img.src = _URL.createObjectURL(file);
      }
    });
  });



  $(document).on('submit', '.ads_forms', function (e) {
    e.preventDefault();
    var type_id = $(this).data('type');
    var url = `${base_url}admin/dashboard/upload_ads/${type_id}`;

    var formData = new FormData(this);
    $('#single_progress_' + type_id).slideDown();
    $.ajax({
      type: 'POST',
      url: url,
      data: formData,
      dataType: 'json',
      cache: false,
      contentType: false,
      processData: false,
      xhr: function () {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            var percentComplete = evt.loaded / evt.total;
            percentComplete = parseInt(percentComplete * 100);
            $('.myprogress').text(percentComplete + '%');
            $('.myprogress').css('width', percentComplete + '%');
          }
        }, false);
        return xhr;
      },

      success: function (json) {
        if (json.st == 1) {
          $('#single_progress_' + type_id).slideUp();
          $(".ads_preview_" + type_id).attr("src", base_url + json.img).show();
          $("#ads_details_" + type_id).hide();
        } else {
          $('#single_progress_' + type_id).hide();
          $("html, body").animate({ scrollTop: 0 }, 600);
          MSG(false, json.msg);
        }

      },
      error: function () {
        console.log("error");
      }
    });
  });




  $(function () {
    $('.count_text').keyup(updateCount);
    $('.count_text').keydown(updateCount);
    function updateCount(e) {
      var val = $(this).val();
      var max = $(this).data('max');
      var cs = $(this).val().length;
      if (cs > max) {
        $('.count_text').val(val.substring(0, max));
        if (e.keyCode != 46 && e.keyCode != 8) return false;
      } else {
        $('.characters').text(cs + ' / ' + max);
      }
    }
    return false;
  });



  // section banners
  $(function () {
    $(document).on('change', '.section_name', function (event) {
      var val = $(this).val();
      if (val == 'home' || val == 'faq') {
        $('.hide_banner').slideDown();
      } else {
        $('.hide_banner').slideUp();
      }

    });
  })






  $(function () {
    var public_key = $('#payBtn').data('publish-key');
    if (public_key) {
      //set your publishable key
      Stripe.setPublishableKey(public_key);
      //callback to handle the response from stripe
      function stripeResponseHandler(status, response) {
        if (response.error) {
          //enable the submit button
          $('#payBtn').removeAttr("disabled");
          //display the errors on the form
          $(".payment-errors").html(`<div class="single_alert alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <div class="d_flex_alert">
            <h4><i class="icon fas fa-warning"></i> Warning!</h4>
            <div class="double_text">
            <p>${response.error.message}</p>
            </div>
            </div>
            </div>`);
        } else {
          var form$ = $("#paymentFrm");
          //get token id
          var token = response['id'];
          //insert the token into the form
          form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
          //submit form to the server
          form$.get(0).submit();
        }
      }
      $(document).ready(function () {

        //on form submit
        $("#paymentFrm").submit(function (event) {
          //disable the submit button to prevent repeated clicks
          $('#payBtn').attr("disabled", "disabled");

          //create single-use token to charge the user
          Stripe.createToken({
            number: $('#stripe-card-number').val(),
            cvc: $('#stripe-card-cvc').val(),
            exp_month: $('#stripe-card-expiry-month').val(),
            exp_year: $('#stripe-card-expiry-year').val()
          }, stripeResponseHandler);
          //submit from callback
          return false;
        });
      });

    }

  });



  $(function () {
    $('body').on('click', '.buy_now', function (e) {
      var totalAmount = $(this).attr("data-amount");
      var product_id = $(this).attr("data-id");
      var username = $(this).attr("data-name");
      var key = $(this).attr("data-key");
      var options = {
        "key": key,
        "amount": totalAmount * 100, // 2000 paise = INR 20
        "name": username,
        "description": "Payment",
        "image": base_url + "assets/frontend/images/razorpay.png",
        "handler": function (response) {
          $.ajax({
            url: base_url + 'payment/razorpay_payment/',
            type: 'post',
            dataType: 'json',
            data: {
              razorpay_payment_id: response.razorpay_payment_id, totalAmount: totalAmount, product_id: product_id, csrf_test_name: csrf_value, username: username
            },
            success: function (msg) {
              window.location.href = `${base_url}payment/stripe_success/${username}`;
              $('.payment_msg').html(msg)
            }
          });
        },
        "theme": {
          "color": "#528FF0"
        }
      };
      if (key) {
        var rzp1 = new Razorpay(options);
        rzp1.open();
        e.preventDefault();
      }
    });
  });


  $(document).on("keypress keyup blur", ".number", function (event) {
    $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }

    if (event.which === 46 && $(this).val().indexOf('.') != -1) {
      event.preventDefault();
    }
  });

  $(document).on("keypress keyup blur", ".only_number", function (event) {
    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
  });

  $(function () {
    $(document).on('click', '.is_discount', function (event) {
      if ($(this).is(':checked')) {
        $('.discount_field').slideDown();

      } else {
        $('.discount_field').slideUp();
      }


    });

    $(document).on('click', '.is_price', function (event) {
      if ($(this).is(':checked')) {
        $('.price_field').slideDown();

      } else {
        $('.price_field').slideUp();
      }


    });

    $(document).on('click', '.is_upcoming', function (event) {
      if ($(this).is(':checked')) {
        $('.upcoming_field').slideDown();

      } else {
        $('.upcoming_field').slideUp();
      }


    });
  });




  $(function () {
    $(document).on('click', '.quick_view', function () {
      var id = $(this).data('id');
      var url = `${base_url}admin/restaurant/get_item_list_by_ajax_order_id//${id}`;
      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          $('.view_orderList').html(json.load_data);
          $('.orderList_ajax_area').animate({ "left": '0' });
          $('.orderList_ajax_area').addClass('active');
        }
      }, 'json');
      return false;
    });


    $(document).on('click', '.orderStatus', function () {
      var id = $(this).data('id');
      var shop_id = $(this).data('shop');
      var url = $(this).attr('href');
      $(this).prop('disabled', true);
      $('.content').addClass('activeStatus').attr('data-content', please_wait_its_working);

      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          $('.setTimeModal').modal('hide');
          $('.view_orderList').html(json.load_data);
          $('.orderList_ajax_area').addClass('active');
          $('#list_load').load(`${base_url}admin/restaurant/update_order_list`);
          $('.setTimeModal').modal('hide');
          $('.orderStatus').prop('disabled', false);
          $('.content').removeClass('activeStatus').attr('data-content', '');
        }
      }, 'json');
      return false;
    });


    $(document).on('click', '.reservationStatus  a', function () {
      var url = $(this).attr('href');
      $(this).prop('disabled', true);
      $('.content').addClass('activeStatus').attr('data-content', please_wait_its_working);

      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          $('.content').removeClass('activeStatus').attr('data-content', '');
          window.location.reload();
        }
      }, 'json');
      return false;
    });

    $(function () {
      $(document).on('submit', '#ajaxAccept', function (e) {
        var url = $(this).attr('action');
        $(this).prop('disabled', true);
        $.post(url, $(this).serialize(), function (json) {
          if (json.st == 1) {
            $('.setTimeModal').modal('hide');
            $('.customModal').modal('hide');
            $('.view_orderList').html(json.load_data);
            $('.orderList_ajax_area').addClass('active');
            $('#list_load').load(`${base_url}admin/restaurant/update_order_list`);
            $('#your-modal-id').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('.orderList_ajax_area.active').animate({ "left": '-400px' });
            $('#ajaxAccept').prop('disabled', false);
          }
        }, 'json');
        return false;
      });
    });







    $(document).on('click', '.close_view', function () {
      $('.orderList_ajax_area.active').animate({ "left": '-400px' });
    });

  });



  $(document).on('change', '#category', function () {
    alert();
    var type = $(this).children(":selected").data("type");
    var ID = $(this).children(":selected").val();
    console.log(ID);
    $(".is_size").prop("checked", false);
    if (type != 0 && !$.isNumeric(type)) {
      var url = `${base_url}admin/menu/get_cat_info_by_type/${type}`
      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          $('.show_ajax_sizes').html(json.data);
          $('.size_tag, .show_price').removeClass('hidden');
          get_subcategories(ID);
        } else {
          $('.show_size_price, .size_tag').addClass('hidden');
          $('.show_price').removeClass('hidden');
        }
      }, 'json');
      return false;
    } else {
      $(".is_size").prop("checked", false);
      $('.show_size_price, .size_tag').addClass('hidden');
      $('.show_price').removeClass('hidden');
    }
  });


  $(document).on("change", "[name='cat_id']", function () {
    var id = $(this).val();
    var url = `${base_url}admin/menu/get_subcategories/${id}`
    $.get(url, { 'csrf_test_name': csrf_value }, function (json) {
      $('#sub_category').html(json.data);
    }, 'json');
  })

  $(document).on('click', '.is_size', function () {
    if ($(this).is(':checked')) {
      $('.show_price').addClass('hidden');
      $(".show_size_price").removeClass('hidden');  // checked
    } else {
      $('.show_price').removeClass('hidden');
      $(".show_size_price").addClass('hidden'); // unchecked
    }
  });




  $(document).on('click', '.showTimeModal', function () {
    var id = $(this).data('id');
    $('.uid').val(id);
    $('#SetTimeModal').modal('show');
  });





  $(".copyText").on("click", function () {
    // Select the text inside the input element
    $(".copyContent").select();

    try {
      // Copy the selected text to the clipboard using Clipboard API
      document.execCommand('copy');
      MSG(1, 'Done');
    } catch (err) {
      // If copying fails or Clipboard API is not supported, handle the error
      MSG(0, 'Unable to copy text');
    }
  });








  $(function () {

    /**
      ** readURL
    **/
    function default_uploader(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('.imgPreview').attr('src', e.target.result);
          $('.imgPreviewDiv').slideUp();
          $('.imgPreview').slideDown().removeClass('opacity_0');
          $('.defaultImg.cropModalOpen').slideUp();
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    var _URL = window.URL || window.webkitURL;
    $(document).on('change', '.imgFile', function (e) {
      var container = this;
      var max_width = $(this).data('width');
      var max_height = $(this).data('height');
      var file, img;
      if ((file = this.files[0])) {
        img = new Image();
        img.onload = function () {
          var height = this.height;
          var width = this.width;
          if (max_width != 0 && max_height != 0) {
            if (width <= max_width && height <= max_height) {
              default_uploader(container);
              $('.img_error').html('');
            } else {
              $('.img_error').html(`Image Dimention should be less than ${max_width} x ${max_height} px`);
              $('.imgFile').val('');
              $('.imgFile').slideUp();
            }
          } else {
            default_uploader(container);
            $('.img_error').html('');
          }

        };
        img.src = _URL.createObjectURL(file);
      }
    });
  });


  $(function () {
    $(document).on('click', '.deleteImg', function () {
      var url = $(this).attr('href');
      var msg = $(this).data('msg');
      swal({
        title: "Are you sure?",
        text: msg,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes do it!",
        cancelButtonText: "No",
        closeOnConfirm: false,
      }, function () {
        $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
          if (json.st == 1) {
            $('.imgPreview, .deleteImg').slideUp().addClass('opacity_0');
            $('.imgPreviewDiv').slideDown().removeClass('opacity_0');
            $('.cropModalOpen').slideDown().removeClass('opacity_0');
            swal({
              title: "Success",
              text: json.msg,
              type: "success",
              showCancelButton: false
            }, function () {

            });
          }
        }, 'json');

        return false;
      });
      return false;
    });
  });

  $(function () {
    $(document).on('keyup', '#username', function () {
      var val = $(this).val();
      if (val == '') {
        return;
      }
      if (val.match(/\s/g)) {
        $(".alert_msg").html('No space allowed').addClass('error');
        var newName = val.replace(/\s/g, '');
        $(this).val(newName);
      }

    });
  });

  $(function () {
    // Tradução das datas em PT-BR
    moment.updateLocale('pt-br', {
      months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'],
      weekdaysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
      weekdaysMin: ['Do', 'Se', 'Te', 'Qu', 'Qu', 'Se', 'Sa']
    });
    
    // Sobrescreve a função de formatação para garantir tradução correta
    const originalMomentFormat = moment.fn.format;
    moment.fn.format = function(format) {
      let result = originalMomentFormat.call(this, format);
      
      // Substituição manual para meses em inglês pelos equivalentes em português
      const monthMap = {
        'Jan': 'Jan', 'Fev': 'Feb', 'Mar': 'Mar', 'Abr': 'Apr',
        'Mai': 'May', 'Jun': 'Jun', 'Jul': 'Jul', 'Ago': 'Aug',
        'Set': 'Sep', 'Out': 'Oct', 'Nov': 'Nov', 'Dez': 'Dec',
        'Janeiro': 'January', 'Fevereiro': 'February', 'Março': 'March', 'Abril': 'April',
        'Maio': 'May', 'Junho': 'June', 'Julho': 'July', 'Agosto': 'August',
        'Setembro': 'September', 'Outubro': 'October', 'Novembro': 'November', 'Dezembro': 'December'
      };
      
      Object.keys(monthMap).forEach(function(enMonth) {
        result = result.replace(new RegExp(enMonth, 'g'), monthMap[enMonth]);
      });
      
      return result;
    };
    
    // Configuração do daterangepicker
    $('input[name="daterange"]').daterangepicker({
      opens: 'left',
      setDate: '',
      startDate: moment().startOf('hour').subtract(64, 'hour'),
      endDate: moment().startOf('hour'),
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
      autoUpdateInput: false,
      ranges: {
        'Hoje': [moment(), moment()],
        'Ontem': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Últimos 7 Dias': [moment().subtract(6, 'days'), moment()],
        'Últimos 30 Dias': [moment().subtract(29, 'days'), moment()],
        'Este Mês': [moment().startOf('month'), moment().endOf('month')],
        'Mês Passado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
      },
    });

    // Estilo CSS para corrigir o fundo transparente
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

    // Aplicar as datas selecionadas com formato em português
    $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
      // Formata a data em português usando a função format sobrecarregada
      $(this).val(picker.startDate.format('D MMM YYYY') + ' - ' + picker.endDate.format('D MMM YYYY'));
    });
    
    $('input[name="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
      $(this).val('');
    });

    // Inicializa os daterangepickers existentes na página
    $(document).ready(function() {
      // Para campos que já têm valores em inglês, traduzir para PT-BR
      $('input[name="daterange"]').each(function() {
        var value = $(this).val();
        if (value) {
          // Tentar converter o formato já existente para PT-BR
          var parts = value.split(' - ');
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
              
              // Mapa de tradução EN para PT-BR
              var monthMap = {
                'Jan': 'Jan', 'Feb': 'Fev', 'Mar': 'Mar', 'Apr': 'Abr',
                'May': 'Mai', 'Jun': 'Jun', 'Jul': 'Jul', 'Aug': 'Ago',
                'Sep': 'Set', 'Oct': 'Out', 'Nov': 'Nov', 'Dec': 'Dez'
              };
              
              // Traduz os meses de EN para PT-BR
              startMonth = monthMap[startMonth] || startMonth;
              endMonth = monthMap[endMonth] || endMonth;
              
              // Define o valor em português para exibição
              var ptDate = startDay + ' ' + startMonth + ' ' + startYear + ' - ' + endDay + ' ' + endMonth + ' ' + endYear;
              $(this).val(ptDate);
            }
          }
        }
      });
    });
  });


  $(function () {
    $(document).on('click', '.tab_li', function (event) {
      var val = $(this).data('value');
      if (val == 'img') {
        $(`.img_type`).val(1);
      } else if (val == 'link') {
        $(`.img_type`).val(2);
      } else {
        $(`.img_type`).val(1);
      }

    });
  });


  $('.picker').on('change', function (e) {
    var icon = $(this).find('input[type="hidden"]').val();
    var id = $(this).data('id');
    $(`.icon_${id}`).val(`<i class="${icon}"></i>`);
  });

  $(document).on('click', '.timeCheckeds', function (event) {
    if ($(this).is(':checked')) {
      $(this).parent('.time_slot').addClass('active');
    } else {
      $(this).parent('.time_slot').removeClass('active');
    }
  });

  $(".range-slider-single").slider({
    tooltip: 'always',
    formatter: function (value) {
      return value;
    }
  });

  $(".skill_form, .validForm").validate({
    errorPlacement: function (error, element) {
      return false;
    }
  });

  $(function () {
    var ul_sortable = $('.sortable');

    ul_sortable.sortable({
      opacity: 1,
      tolerance: 'pointer',
      cursor: 'move',
      handle: '.handle',
      revert: 100,
      update: function (event, ui) {

        var table = $('#tables').data('id');
        var post = ul_sortable.sortable('toArray').toString();

        $.ajax({
          type: 'POST',
          url: `${base_url}admin/menu/add_order?id=${table}`,
          data: { 'sort': post, 'csrf_test_name': csrf_value },
          dataType: 'json',
          cache: false,
          success: function (data) {
            if (data.st == 1) {
              MSG(1, data.msg);
              $('.makeChanges').slideDown();
            }
          }, // success data
          error: function (jqXHR, exception) {
            $('.makeChanges').slideUp();
          }
        });

      }
    });
    ul_sortable.disableSelection();
  });

  $(document).on('click', '.reload', function () {
    window.location.reload();
  })

  function pwa_url(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('.service_icon_preview').attr('src', e.target.result);
        $('.serviceImg').slideDown();
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  var _URL = window.URL || window.webkitURL;
  $(".pwa_img").on('change', function (e) {
    var container = this;
    var max_width = $(this).data('width');
    var max_height = $(this).data('height');
    var file, img;
    if ((file = this.files[0])) {
      img = new Image();
      img.onload = function () {
        var height = this.height;
        var width = this.width;
        console.log(`${height}x ${width}`);
        if (max_width != 0 && max_height != 0) {
          if (width == height) {
            pwa_url(container);
            $('.img_error').html('');
          } else {
            $('.img_error').html(`Image Dimention should be less than ${max_width} x ${max_height} px and must be square`);
            $('.pwa_img').val('');
            $('.serviceImg').slideUp();
          }
        } else {
          pwa_url(container);
          $('.img_error').html('');
        }

      };
      img.src = _URL.createObjectURL(file);
    }
  });


  //check username with ajax keyup
  $(function () {
    $(document).on('keyup', '#username', function () {
      var val = $(this).val();
      if (val == '') {
        return;
      }
      if (val.match(/\s/g)) {
        $(".alert_msg").html('No space allowed').addClass('error');
        var newName = val.replace(/\s/g, '');
        $(this).val(newName);
      }

      $('.register_loader').slideDown();
      $('.alert_msg').slideUp();
      var value = encodeURIComponent(val);
      var url = `${base_url}login/check_username/${value}`;
      $.get(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          setTimeout(function () {
            $('.register_loader').slideUp();
            $('.alert_msg').html(json.msg).slideDown().removeClass('error').addClass('success');
            $('.reg_btn').prop('disabled', false);
          }, 2000);
        } else {
          setTimeout(function () {
            $('.register_loader').slideUp();
            $('.alert_msg').html(json.msg).slideDown().removeClass('succes').addClass('error');
            $('.reg_btn').prop('disabled', true);
          }, 2000);
        }
      }, 'json');

      return false;
    });
  });


  $(function () {
    $(document).on('keyup', '.remove_space', function () {
      var val = $(this).val();
      if (val == '') {
        return;
      }

      if (val.match(/[^\w]/g)) {
        $(".alert_msg").html('No space allowed').addClass('error');
        var newName = val.replace(/[^\w]/g, "");
        $(this).val(newName);
        return;
      } else {
        $(".alert_msg").html('').removeClass('error');
      }

      return;
    });
  });


  $(function () {
    $(document).on('click', '.checkAll', function () {
      if ($(this).is(':checked')) {
        $('#checkedItem > option').prop("selected", "selected");
        $("#checkedItem").trigger("change");
        alert($(this).data('lang'));
      } else {
        $("#checkedItem option").each(function () {
          $(this).prop('selected', false);
          $("#checkedItem").trigger("change");
        });
      }


    })

    jQuery(document).ready(function () {
      setTimeout(() => {
        $('.custom_notification').slideDown();
      }, 2000);

    });



    $(function () {
      var max_fields = 50; //maximum input boxes allowed
      var wrapper = $(".input_fields_wrap"); //Fields wrapper
      var add_button = $(".add_field_buttons"); //Add button ID
      var x = 1; //initlal text box count
      $(add_button).on('click', function (e) {
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
          x++; //text box increment
          $(wrapper).append(`<div class="row mb-15 hide_${x}" >
            <div class="col-md-2">
            <input type="text" name="room_numbers[]" class="form-control">
            </div>
            <div class="col-md-2">
            <input type="text" name="room_numbers[]" class="form-control">
            </div>
            <div class="col-md-2">
            <input type="text" name="room_numbers[]" class="form-control">
            </div><div class="col-md-2">
            <input type="text" name="room_numbers[]" class="form-control">
            </div><div class="col-md-2">
            <input type="text" name="room_numbers[]" class="form-control">
            </div>
            <div class="col-md-2">
            <a href="javascript:;" class="btn btn-danger btn-flat btn-block h-46 remove_fields" data-id="${x}"><i class="fa fa-trash-o"></i></a>
            </div>
                </div>`); //add input box
        } else {
          alert('Sorry Fields Limit exists');
        }
      });

      $(wrapper).on("click", ".remove_fields", function (e) { //user click on remove text
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('.hide_' + id).remove();
        x--;
      });

    });


    $(document).on('input', '.remove_all', function () {
      var val = $(this).val();
      if (val == '') {
        return;
      }
      var newName = val.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
      $(this).val(newName);

    });

    $(document).on('submit', '.productVariants', function (e) {
      var url = $(this).attr('action');
      $(this).prop('disabled', true);
      $.post(url, $(this).serialize(), function (json) {
        if (json.st == 1) {
          $('.variantsLoad').html(json.load_data);
          $('#variantModal').modal('hide');
        }
      }, 'json');
      return false;
    });

    $(document).on('click', '.tutorialModal', function (e) {
      let uid = $(this).data('id');
      var url = `${base_url}home/get_tutorials/${uid}`;
      $.post(url, { 'csrf_test_name': csrf_value }, function (json) {
        if (json.st == 1) {
          $('#showTutorialData').html(json.load_data);
          $('#tutoralModal').modal({ backdrop: 'static', keyboard: false }, 'show');

        }
      }, 'json');
      return false;
    });


    $(document).on("keypress keyup blur", "input[name*=price] .price", function (event) {
      var inputValue = $(this).val();


      var containsDot = inputValue.indexOf('.') !== -1;

      if (
        (event.which < 48 || event.which > 57) &&
        (event.which !== 46 || containsDot)
      ) {
        event.preventDefault();
      }

      if (event.which === 46 && containsDot) {
        event.preventDefault();
      }
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

    // Adiciona listener para converter datas na submissão do formulário
    $(document).on('submit', 'form:has(input[name="daterange"])', function(e) {
      var daterangeInputs = $(this).find('input[name="daterange"]');
      
      daterangeInputs.each(function() {
        var ptDate = $(this).val();
        if (ptDate) {
          try {
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
          } catch (error) {
            console.error("Erro ao converter data:", error);
          }
        }
      });
    });

  });

  // Código específico para os formulários de filtro de pedidos
  $('.orderFilterForm').on('submit', function(e) {
    var daterangeInputs = $(this).find('input[name="daterange"]');
    
    daterangeInputs.each(function() {
      var ptDate = $(this).val();
      if (ptDate) {
        try {
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
              
              // Mapa de tradução PT-BR para EN
              var ptToEnMonthMap = {
                'Jan': 'Jan', 'Fev': 'Feb', 'Mar': 'Mar', 'Abr': 'Apr',
                'Mai': 'May', 'Jun': 'Jun', 'Jul': 'Jul', 'Ago': 'Aug',
                'Set': 'Sep', 'Out': 'Oct', 'Nov': 'Nov', 'Dez': 'Dec',
                'Janeiro': 'January', 'Fevereiro': 'February', 'Março': 'March', 'Abril': 'April',
                'Maio': 'May', 'Junho': 'June', 'Julho': 'July', 'Agosto': 'August',
                'Setembro': 'September', 'Outubro': 'October', 'Novembro': 'November', 'Dezembro': 'December'
              };
              
              // Traduz os meses de PT para EN
              startMonth = ptToEnMonthMap[startMonth] || startMonth;
              endMonth = ptToEnMonthMap[endMonth] || endMonth;
              
              // Define o valor em inglês para envio
              var enDate = startDay + ' ' + startMonth + ' ' + startYear + ' - ' + endDay + ' ' + endMonth + ' ' + endYear;
              $(this).val(enDate);
            }
          }
        } catch (error) {
          console.error("Erro ao converter data:", error);
        }
      }
    });
  });

}(jQuery));


