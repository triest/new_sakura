(function($) {
  'use strict';
  if ($("#timepicker-example").length) {
    log('--->', ln())
    $('#timepicker-example').datetimepicker({
      lang: 'RU',
      // format: 'LT',
      i18n:{de:{
          months:['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сертябрь','Октябрь','Ноябрь','Декабрь'],
          dayOfWeek:["Вс", "Пн", "Вт", "Ср", "Чт", "Пт", "Сб"]
        }},
      timepicker:false,
      format:'d.m.Y'
    });
  }
  if ($(".color-picker").length) {
    log('--->', ln())
    $('.color-picker').asColorPicker();
  }
  if ($("#datepicker-popup").length) {
    log('--->', ln())
    $('#datepicker-popup').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
    });
  }
  if ($("#inline-datepicker").length) {
    log('--->', ln())
    $('#inline-datepicker').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
    });
  }
  if ($(".datepicker-autoclose").length) {
    log('--->', ln())
    $('.datepicker-autoclose').datepicker({
      autoclose: true
    });
  }
  if($('.input-daterange').length) {
    log('--->', ln())
    $('.input-daterange input').each(function() {
      $(this).datepicker('clearDates');
    });
    $('.input-daterange').datepicker({});
  }

})(jQuery);