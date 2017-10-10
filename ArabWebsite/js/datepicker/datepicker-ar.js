/* Arabic Translation for jQuery UI date picker plugin. */
/* Khaled Alhourani -- me@khaledalhourani.com */
/* NOTE: monthNames are the original months names and they are the Arabic names, not the new months name فبراير - يناير and there isn't any Arabic roots for these months */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {

		// AMD. Register as an anonymous module.
		define([ "../jquery.ui.datepicker" ], factory );
	}
	else {
		// Browser globals
		factory( jQuery.datepicker );
	}
}(function( datepicker ) {
	datepicker.regional['ar'] = {
		closeText: 'إغلاق',
		prevText: '&#x3C;السابق',
		nextText: 'التالي&#x3E;',
		currentText: 'اليوم',
		monthNames: ['كانون الثاني', 'شباط', 'آذار', 'نيسان', 'مايو', 'حزيران',
		'تموز', 'آب', 'أيلول',	'تشرين الأول', 'تشرين الثاني', 'كانون الأول'],//january
		monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
		dayNames: ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],//sunday
		dayNamesShort: ['الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],//sunday——》
		dayNamesMin: ['ح', 'ن', 'ث', 'ر', 'خ', 'ج', 'س'],//H n W t x c o
		weekHeader: 'أسبوع',//one week
		dateFormat: 'dd/mm/yy',
		firstDay: 6,//right first day
  		isRTL: true,//control calendar turn right or turn left
		showMonthAfterYear: true,
		yearSuffix: ''};
	datepicker.setDefaults(datepicker.regional['ar']);

	return datepicker.regional['ar'];

}));