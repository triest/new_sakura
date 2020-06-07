let selected = {
	// site: 0,
	// type_service: 0,
	// select_date: false


	site: 0, // выбранная площадка
	services_date: { // выбранная услуга и дата
		date: 0,
		type_service: 0
	},
	tariffs: { // тариф количество детей и приоритет
		count_children: 0,
		tariff: 0,
		type_next: 0
	},
	grid_rooms_4: 0, // выбранная ячейка комнат по сетки комнат
	grid_room_12: 0,
	select_order_services: {},

	type_animation: 0, // выбранный тип анимации
	grid_animation:0, // выбранный костюм аниматора
	type_show_program:0, // тип шоу программы
	grid_show_program:0, // шоу программа в сетке
	add_products: { // дополнительная продукция

	},
	add_services: { // дополнительные услуги

	},
	cafe: { // кафе

	},
	registration: { // данные оформления заказа

	}
};
// sites, services_date, tariffs, grid_rooms_4, grid_room_12
// select_order_services
// type_animation, grid_animation,
// type_show_program, grid_show_program
// add_products, add_services, cafe
// registration
let block_loaded = ['sites'];

var dateToday = new Date();


$.fn.datepicker.dates['ru'] = {
	today: "Today",
	format: "dd-mm-yyyy",
	titleFormat: "MM yyyy", /* Leverages same syntax as 'format' */
	weekStart: 0,

	clear: 'Закрыть',
	// 	prevText: 'Пред',
	// 	nextText: 'След',
	// 	currentText: 'Сегодня',
	months: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
	monthsShort: ['Январь','Февраль','Март','Апрель','Май','Июнь',
		'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
	days: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
	daysShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
	daysMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	// 	weekHeader: 'Нед',
	// 	dateFormat: 'dd.mm.yy',
	// 	firstDay: 1,
	// 	isRTL: false,
	// 	showMonthAfterYear: false,
	// 	yearSuffix: ''
};


var js_vue_order_create = new Vue({
	el: '#js-vue-order-create',
	data: {
		views: {
			type_services: false, // блок услуг и календарь
			constructors: false,
			stage_constructor: false,
			// select_tariffs: false, // выьор тарифа посежения и указание количества детей
			// grid_rooms: false,
			// services_order: false
		},
		selected,
		block_loaded,
		sites: data_vars.sites,
		type_services: data_vars.type_services
	},
	methods: {
		selected_site(site) {
			// log('sites ->', site);
			this.selected.site = site; // выьрали площадку
			this.views.type_services = true;

			// грузи данные по команам и инийиализируем календарь
			get('/admin/orders/ajax_load_dates_room/' + site.id)
			.then(data => {
				let max_date = new Date();
				let date_start = new Date();

				date_start.setDate(date_start.getDate() + parseInt(data.offset_day));
				max_date.setDate(date_start.getDate() + parseInt(data.limit_day));

				$('#inline-datepicker').datepicker({
					language: 'ru',
					changeMonth: false,
					changeYear: false,
					todayHighlight: false,
					startDate:date_start,
					endDate: max_date,
					weekStart: 1,
					format: {
						toDisplay: function (date, format, language) {
							var d = new Date(date);
							d.setDate(d.getDate() - 7);
							return d.toISOString();
						},
						toValue: function (date, format, language) {
							var d = new Date(date);
							d.setDate(d.getDate() + 7);
							return new Date(d);
						}
					}
				}).on('changeDate', e => {
					// выбрали дату
					this.selected.services_date.select_date = e.date;
					this.load_next();
				});
				$(".datepicker-switch").click(function(e) { // отменяем переход выбора месяца в календаре
					e.stopPropagation();
					e.preventDefault();
				})

			})
			.catch(error => {
				console.log(error);
			})

			scroll_to('.js-scroll-types_services');
		},
		selected_type_service(type_service) {
			// выбрали приоритет

			this.selected.services_date.type_service = type_service;

			this.load_next();
		},

		load_next() {

			log(this.selected.services_date);

			if(this.selected.services_date.type_service && this.selected.services_date.select_date) {


				post(data_vars.url.load_blocks + this.selected.services_date.type_service.type, {
					site_id: this.selected.site.id,
					date: dateToString(this.selected.services_date.select_date)
				})
				.then(data => {

					this.block_loaded.push(this.selected.services_date.type_service.type);
					$("#constructor_b2").append(data.html);

					this.views.stage_constructor = true;// переключаем отображение дальше

					data.scroll_to && scroll_to(data.scroll_to);
					$$.init();
				})
				.catch(error => {
					console.error(error);
				})

			}


		}
	}
});

function scroll_to(href) { // прокрутка страницы до нового блока
	$(href).length && setTimeout(() => {
		$('html, body').animate({
			scrollTop: $(href).offset().top
		}, 500);
	}, 20)
}


