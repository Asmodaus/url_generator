'use strict';
document.addEventListener('DOMContentLoaded', () => {

	// tooltip and popover
	$('[data-toggle="tooltip"]').tooltip();


	$('[data-toggle="popover-custom"]').popover({
		html: true,
		customClass: 'custom_popover',
		sanitize: false,
		content: function () {
			let content = $(this).attr("data-popover-content");
			let new_id = $(this).attr("data-id");
			admin_open(content,new_id);
			return $(content).children(".popover-body").html();
		},
		title: function () {
			let title = $(this).attr("data-popover-content");
			return $(title).children(".popover-heading").html();
		}
	});
	// .on('shown.bs.popover', function () {
	// 	$('.selectpicker').selectpicker('refresh');
	// })
	$(document).on("click", ".popover .close_popover_js", function () {
		$(this).parents(".popover").popover('hide');
	});



	const btnTrMoreUnfo = document.querySelectorAll('.toggle_show_js'),
		btnOperationCheck = document.querySelectorAll('.check_btn_js');

	btnTrMoreUnfo.forEach(element => {
		element.addEventListener('click', (event) => {
			event.preventDefault();
			element.closest('tr').nextElementSibling.classList.toggle('d-none');
		});
	});


	btnOperationCheck.forEach(element => {
		element.addEventListener('click', (event) => {
			event.preventDefault();
			element.classList.toggle('text-success');
		});
	});


	$('.table_js').DataTable({
		scrollY: '200px',
		scrollCollapse: true,
		// paging: false,
	});
	$('.unsearch_table_js').DataTable({
		scrollY: '200px',
		scrollCollapse: true,
		bFilter: false,
		bLengthChange: false,
		// paging: false,
	});
	$(document).on('shown.bs.tab', '[data-toggle="tab"]', function (e) {
		$.fn.dataTable.tables({
			visible: true,
			api: true
		}).columns.adjust();
	});
	$(document).on('shown.bs.modal', function (event) {
		$.fn.dataTable.tables({
			visible: true,
			api: true
		}).columns.adjust();
	});
	// $('.selectpicker').selectpicker('refresh');
	// $(document).on('show.bs.popover', function (event) {
	// 	// $('.selectpicker').selectpicker('destroy');
	// 	// $('.selectpicker').selectpicker('refresh');
	// 	$('.selectpicker').selectpicker('render');
	// });
});