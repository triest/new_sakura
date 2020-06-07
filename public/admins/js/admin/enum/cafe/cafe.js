$$(() => {

	// загрузка списка блюд в категории
	function load_list_dishes(id) {
		get('/admin/enum/cafe/ajax_get_group/' + id)
		.then(data => {
			if (! io_res(data)) {
				return false;
			}

			history.pushState(null, null, '/admin/enum/cafe/index/' + data.group_id);

			// $(".js-load_cafe_group").removeClass('active');
			// $(this).addClass('active');

			$(".js-top_block_cafe").html(data.top_block);

			$(".js-cafe-right-block").html(data.html);

			$('[data-edit-group]').attr('data-edit-group', data.group_id)

		})
		.catch(error => {
			swal({
				type: 'error',
				title: error,
				icon: 'error',
				button: {text: "OK", value: true, visible: true, className: "btn btn-primary"}
			})
		})
	}

	$(document).on("click", '.js-load-list-dishes', function() {
		load_list_dishes($(this).attr('data-id-group'));
	});

	function data_edit_group(id) {
		get('/admin/enum/cafe/ajax_group_edit/' + id)
		.then(data => {
			$(".js-cafe-right-block").html(data.html);
		})
		.catch(error => {
			console.log(error);
		})
	}

	function data_del_group(id) {
		get('/admin/enum/cafe/ajax_group_delete/' + id)
		.then(data => {
			console.log('data =>', data);
			app_tree.refresh(data.groups);
		})
		.catch(error => {
			console.log(error);
		})
	}

	(data_vars.access_edit || data_vars.access_del) && (function ($, undefined) {
		"use strict";

		let tag_span_ = document.createElement('span');

		if(data_vars.access_edit) {
			let a_tag_edit = document.createElement('a');
			a_tag_edit.setAttribute('type', 'button');
			a_tag_edit.setAttribute('title', 'редактировать категорию блюд');
			let i_tag_edit = document.createElement('i');
			i_tag_edit.setAttribute('class', 'mdi mdi-grease-pencil');
			a_tag_edit.appendChild(i_tag_edit);
			a_tag_edit.className = "jstree-edit_node_btn edit right jstree-selectListBtn";

			tag_span_.appendChild(a_tag_edit);
		}

		if(data_vars.access_del) {
			let a_tag_del = document.createElement('a');
			a_tag_del.setAttribute('type', 'button');
			a_tag_del.setAttribute('title', 'Удалить категорию блюд');
			let i_tag_del = document.createElement('i');
			i_tag_del.setAttribute('class', 'mdi mdi-delete');
			a_tag_del.appendChild(i_tag_del);
			a_tag_del.className = "jstree-edit_node_btn del right jstree-selectListBtn";

			tag_span_.appendChild(a_tag_del);
		}

		$.jstree.plugins.selectListBtn = function (options, parent) {
			this.bind = function () {
				parent.bind.call(this);
				this.element
				.on("click.jstree", ".jstree-selectListBtn.edit", $.proxy(function (e) {
					e.stopImmediatePropagation();
					let id = $(e.currentTarget).closest('.jstree-node').attr('id');
					data_edit_group(id); // Button on click function
				}, this))
				.on("click.jstree", ".jstree-selectListBtn.del", $.proxy(function (e) {
					e.stopImmediatePropagation();
					let id = $(e.currentTarget).closest('.jstree-node').attr('id');
					data_del_group(id); // Button on click function
				}, this));
			};
			this.teardown = function () {
				this.element.find(".jstree-selectListBtn").remove();
				parent.teardown.call(this);
			};
			this.redraw_node = function (obj, deep, callback, force_draw) {
				obj = parent.redraw_node.call(this, obj, deep, callback, force_draw);
				if (obj) {
					let node = $('#checkTree').jstree(true).get_node(obj.id);
					if (node) {
						let tmp = tag_span_.cloneNode(true);
						obj.insertBefore(tmp, obj.childNodes[2]);
					}
				}
				return obj;
			};
		};
	})(jQuery);
	// Модуль приложения
	app_tree = new class App {
		constructor() {
			// Инициализируем нужные переменные
			this.tree = false;
			this._loadData();
		}

		refresh(data) {
			this.tree.jstree(true).settings.core.data = data;
			this.tree.jstree(true).refresh();
		}

		_initTree(data){ // Инициализация дерева категорий с помощью jstree
			this.tree = $('#checkTree').jstree({
				core: {
					check_callback: true,
					multiple: false,
					data: data
				},
				types: {
					default: {
						valid_children : ["default", "file"]
					},
					other_element: {
						icon: "fa fa-folder-o"
					},
					"#" : {
						max_depth: 2
					}
				},
				plugins: (pl => {
					if(data_vars.access_edit || data_vars.access_del) {
						pl.push('selectListBtn');
					}
					return pl
				})(["dnd", 'types'])
			})
			.on('loaded.jstree', function(e, data) {
				if(! empty(auto_select_node_jstree)) {
					$(this).jstree(true).select_node('#' + auto_select_node_jstree);
				}
			})
			.on('changed.jstree', function (e, data) {
				if(! empty(data.node)) {
					load_list_dishes(data.node.id);
				}
			})
			.on('move_node.jstree',  (e, data) => {
				let params = {
					id: data.node.id,
					old_parent: data.old_parent,
					new_parent: data.parent,
					old_position: ++ data.old_position,
					new_position: ++ data.position
				};

				this._moveCategory(params);
			});
		}

		_loadData(){ // Загрузка категорий
			this._initTree(data_vars.tree_data_load);
		}

		init(){
			this._loadData()
		}
		_moveCategory(params) { // Перемещение категории
			// let data = $.extend(params, {
			// 	action: 'move_category'
			// });

			post('/admin/enum/cafe/ajax_move_category_cafe_groups', params)
			.then(data => {
				if (io_res(data)) {
					$('#checkTree').jstree(true).settings.core.data = data.groups;
					$('#checkTree').jstree(true).refresh();
				} else {
					// обработка ошибок
				}

			})
			.catch(data => {
				console.log('object error =>',data);
			})
		}
	};
});

