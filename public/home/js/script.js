let
	log = (...vars) => {
		console.log(...vars);
	},
	empty = var_data => {
		return typeof var_data === 'undefined'
		|| var_data === undefined
		|| var_data === ""
		|| var_data === 0
		|| var_data === "0"
		|| var_data === null
		|| var_data === false
		|| (Array.isArray(var_data)
			&& var_data.length === 0)
			? true : false;
	},
	foreach = (iters, func) => {
		if(! empty(iters)) {
			for(let key in iters) {
				func(iters[key], key);
			}
		}
	},
	forIn = foreach,
	ln = (file = true, number_line = false) => {
		let e = new Error();
		if (! e.stack) try {
			// IE requires the Error to actually be throw or else the Error 'stack'
			// property is undefined.
			throw e;
		} catch (e) {
			if (! e.stack) {
				return 0; // IE < 10, likely
			}
		}
		let stack = e.stack.toString().split(/\r\n|\n/);
		// We want our caller frame. It index into |stack| depends on the
		// browser and browser version, so we need to search for the second frame:
		let frameRE = /:(\d+):(?:\d+)[^\d]*$/;
		let frame;

		do {
			frame = stack.shift();
		} while (! frameRE.exec(frame) && stack.length);

		let res = frameRE.exec(stack.shift());

		if (file) {
			return ' ' + res.input + '=>' + (number_line ? number_line : res[1]);
		} else {
			return number_line ? number_line : res[1]
		}
	},
	loading_modal = () => {

	},
	remove_loading_modal = () => {

	},
	log_to_server = () => {

	},
	io_res = data => {
		if(data.message == "Unauthenticated.") {
			location.href = '/admin/login';
			return false;
		}
		if(data.status == 'error') {
			swal({
				type: 'error',
				title: data.message,
				icon: 'error',
				button: {text: "OK", value: true, visible: true, className: "btn btn-primary"}
			})
			return false;
		}
		return true;
	},
	get = url => {
		loading_modal();
		return new Promise((resolve, reject) => {
			$.ajax({
				url,
				type: 'GET',
				dataType: 'JSON',
				cache: false,
				success: data => {
					remove_loading_modal();
					if (! io_res(data)) {
						reject(data);
					} else {

						resolve(data);
					}
				},
				error: (jqXHR, textStatus, errorThrown) => {
					let error_obj = {
						jqXHR,
						textStatus,
						errorThrown,
					};

					remove_loading_modal();

					swal({
						title: jqXHR.status + ': ' + errorThrown,
						type: "error",
						timer: 5000,
						cancelButtonText: 'OK!'
					});

					log_to_server('ajax get ' + ln(), error_obj)
					reject(error_obj);
				}
			});
		})
	},
	post = (url, data = null) => {
		loading_modal();
		return new Promise((resolve, reject) => {
			$.ajax({
				url,
				data: {
					_method: 'post',
					_token: csrf_token,
					...data
				},
				type: 'POST',
				dataType: 'JSON',
				cache: false,
				success: data => {
					remove_loading_modal();
					if (! io_res(data)) {
						reject(data);
					} else {
						resolve(data);
					}
				},
				error: (jqXHR, textStatus, errorThrown) => {
					let error_obj = {
						jqXHR,
						textStatus,
						errorThrown,
					};

					remove_loading_modal();

					swal({
						title: jqXHR.status + ': ' + errorThrown,
						type: "error",
						timer: 5000,
						cancelButtonText: 'OK!'
					});

					log_to_server('ajax post ' + ln(), error_obj)
					reject(jqXHR.status + ': ' + errorThrown);
				}
			});
		})
	},
	dateToString = date => date.getDate() + '.' + (date.getMonth() + 1) + '.' + date.getFullYear()
;

