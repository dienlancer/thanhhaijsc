(function($){
    $(document).ready(function() {
 	    qodeRepeater.rowRepeater.init();
 	    qodeRepeater.rowInnerRepeater.init();
	    qodefInitSortable();
    });

	var qodeRepeater = function() {
		var repeaterHolder = $('.qodef-repeater-wrapper'),
			numberOfRows;

		var rowRepeater = function() {

			var addNewRow = function(holder) {
				var $addButton = holder.find('.qodef-repeater-add a');
				var templateName = holder.find('.qodef-repeater-wrapper-inner').data('template');
				var $repeaterContent = holder.find('.qodef-repeater-wrapper-inner');
				var repeaterTemplate = wp.template('qodef-repeater-template-' + templateName);
				$addButton.on('click', function(e) {
					e.preventDefault();
					e.stopPropagation();


					var $row = $(repeaterTemplate({
						rowIndex: getLastRowIndex(holder) + 1 || 0
					}));

					$repeaterContent.append($row);
					var new_holder = $row.find('.qodef-repeater-inner-wrapper');
					qodeRepeater.rowInnerRepeater.addNewRowInner(new_holder);
					qodeRepeater.rowInnerRepeater.removeRowInner(new_holder);
					qodefInitSortable();
					qodeAdmin.framework.qodefInitSwitch();
					qodeAdmin.framework.qodefInitMediaUploader();
					qodeAdmin.framework.qodefInitColorpicker();
					qodeAdmin.framework.qodefInitSelectChange();
					numberOfRows += 1;

				});
			};

			var removeRow = function(holder) {

				var repeaterContent = holder.find('.qodef-repeater-wrapper-inner');
				repeaterContent.on('click', '.qodef-clone-remove', function(e) {
					e.preventDefault();
					e.stopPropagation();

					if(!window.confirm('Are you sure you want to remove this section?')) {
						return;
					}

					var $rowParent = $(this).parents('.qodef-repeater-fields-holder');
					$rowParent.remove();

					decrementNumberOfRows();

				});
			};

			var getLastRowIndex = function(holder) {
				var $repeaterContent = holder.find('.qodef-repeater-wrapper-inner');
				var $lastRow = $repeaterContent.find('.qodef-repeater-fields-holder').last();

				if(typeof $lastRow === 'undefined') {
					return false;
				}

				return $lastRow.data('index');
			};

			var decrementNumberOfRows = function() {
				if(numberOfRows <= 0) {
					return;
				}

				numberOfRows -= 1;
			}
			var serNumberOfRows = function(holder) {
				numberOfRows =  holder.find('.qodef-repeater-fields-holder').length

			}
			var getNumberOfRows = function() {
				return numberOfRows;
			}

			return {
				init: function() {
					repeaterHolder.each(function(){
						serNumberOfRows($(this));
						addNewRow($(this));
						removeRow($(this));
					});
				},
				numberOfRows: getNumberOfRows
			}
		}();

		var rowInnerRepeater = function() {
			var repeaterInnerHolder = $('.qodef-repeater-inner-wrapper');


			var addNewRowInner = function(holder) {

				//var repeaterInnerContent = holder.find('.qodef-repeater-inner-wrapper-inner');
				var templateInnerName = holder.find('.qodef-repeater-inner-wrapper-inner').data('template');
				var rowInnerTemplate = wp.template('qodef-repeater-inner-template-' + templateInnerName);
				holder.on('click', '.qodef-inner-clone', function(e) {

					e.preventDefault();
					e.stopPropagation();

					var $clickedButton = $(this);
					var $parentRow = $clickedButton.parents('.qodef-repeater-fields-holder').first();

					var parentIndex = $parentRow.data('index');

					var $rowInnerContent = $clickedButton.parent().prev();

					var lastRowInnerIndex = $parentRow.find('.qodef-repeater-inner-fields-holder').last().data('index');

					lastRowInnerIndex = typeof lastRowInnerIndex !== 'undefined' ? lastRowInnerIndex : -1;

					var $repeaterInnerRow = $(rowInnerTemplate({
						rowIndex: parentIndex,
						rowInnerIndex: lastRowInnerIndex + 1
					}));

					$rowInnerContent.append($repeaterInnerRow);
				});
			};

			var removeRowInner = function(holder) {
				var repeaterInnerContent = holder.find('.qodef-repeater-inner-wrapper-inner');
				repeaterInnerContent.on('click', '.qodef-clone-inner-remove', function(e) {
					e.preventDefault();
					e.stopPropagation();

					if(!confirm('Are you sure you want to remove section?')) {
						return;
					}

					var $removeButton = $(this);
					var $parent = $removeButton.parents('.qodef-repeater-inner-fields-holder');

					$parent.remove();
				});
			};

			return {
				init: function() {
					repeaterInnerHolder.each(function(){
						addNewRowInner($(this));
						removeRowInner($(this));
					});

				},
				addNewRowInner:addNewRowInner,
				removeRowInner:removeRowInner
			}
		}();

		return {
			rowRepeater: rowRepeater,
			rowInnerRepeater: rowInnerRepeater
		}
	}();

	function qodefInitSortable() {
		$('.qodef-repeater-wrapper-inner').sortable();
		$('.qodef-repeater-inner-wrapper-inner').sortable();
	}

})(jQuery);
