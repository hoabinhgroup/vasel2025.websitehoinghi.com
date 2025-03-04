@extends('base::cmspanel.layout.dashboard')

@section('title',' - Danh sách Categories')

@push('styles')
     
@endpush

@section('sidebar')
	@parent
@stop

@section('content')
@php
$dropdown = array(
	array(
		'id' => 0,
		'text' => 'Chon Menu cha',
		),
	array(
		'id' => 1,
		'text' => 'Iphone',
		),
	array(
		'id' => 2,
		'text' => 'Android',
		),
	array(
		'id' => 3,
		'text' => 'Waifu',
		),	
	array(
		'id' => 4,
		'text' => 'Xiaomi',
		),
);
$dropdown = json_encode($dropdown);

@endphp;
<div class="content-wrapper">
      <div class="content-header row">
	    
      </div>
      <div class="content-body"> 
	      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Danh sách danh mục</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                  </ul>
                </div>
              </div>
              <div class="card-content collapse show">
	           <select data-column="3" name="parent" id="parent">
		           <option value="0">Chon menu cha</option>
		           <option value="1">Iphone</option>
		           <option value="2">Android</option>
		           <option value="3">Waifu</option>
		           <option value="4">Xiaomi</option>
	           </select>   
              <div class="card-body">
<a href="{!! route('menu.create') !!}" class="btn btn-info" data-keyboard="false" title="Thêm"><i class="icon-plus font-weight-bold"></i> Thêm</a>    

	   
	    
	 <div class="table-responsive">
	     <div class="dataTables_wrapper dt-bootstrap4">
		     	 <table class="table table-bordered table-striped dataTable" id="menu-table">
        <thead>
            <tr>
	            <th>Index</th>
                <th>Id</th>
                <th>Tiêu đề</th>
                <th class="text-center">Danh mục cha</th>
                <th>Thao tác</th>
            </tr>
        </thead>
    </table>
			 	 
		 </div>	 
     </div>
	
	 
              </div><!--.card-body-->
              </div><!-- .card-content -->
            </div><!-- .card-->
          </div>
	      </div>
      </div>
</div>
@stop

@push('scripts')

     <script>
$(function() {
	var filterParams = [];
	
	AppHelper = {};
    AppHelper.baseUrl = "http://geminilouis.com/cmspanel/";
    AppHelper.assetsDirectory = "s";
    AppHelper.settings = {};
    AppHelper.settings.firstDayOfWeek =1;
    AppHelper.settings.currencySymbol = "VND";
    AppHelper.settings.decimalSeparator = ".";
	
	(function($) {
    //appTable using datatable
    $.fn.appTable = function(options) {

        //set default display length
        var displayLength = AppHelper.settings.displayLength * 1;

        if (isNaN(displayLength) || !displayLength) {
            displayLength = 10;
        }

        var defaults = {
            source: "", //data url
            xlsColumns: [], // array of excel exportable column numbers
            pdfColumns: [], // array of pdf exportable column numbers
            printColumns: [], // array of printable column numbers
            columns: [], //column title and options
            order: [[0, "asc"]], //default sort value
            hideTools: false, //show/hide tools section
            displayLength: displayLength, //default rows per page
            dateRangeType: "", // type: daily, weekly, monthly, yearly. output params: start_date and end_date
            checkBoxes: [], // [{text: "Caption", name: "status", value: "in_progress", isChecked: true}] 
            radioButtons: [], // [{text: "Caption", name: "status", value: "in_progress", isChecked: true}] 
            filterDropdown: [], // [{id: 10, text:'Caption', isSelected:true}] 
            filterParams: {datatable: true}, //will post this vales on source url
            onDeleteSuccess: function() {
            },
            onUndoSuccess: function() {
            },
            onInitComplete: function() {
            },
            customLanguage: {
                printButtonToolTip: "Press escape when finished",
                today: "Today",
                yesterday: "Yesterday",
                tomorrow: "Tomorrow"
            },
            footerCallback: function(row, data, start, end, display) {
            },
            rowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            },
            summation: "", /* {column: 5, dataType: 'currency'}  dataType:currency, time */
        };

        var $instance = $(this);

        //check if this binding with a table or not
        if (!$instance.is("table")) {
            console.log("Element must have to be a table", this);
            return false;
        }

        var settings = $.extend({}, defaults, options);

        // reload
        if (settings.reload) {
            var table = $(this).dataTable();
            var instanceSettings = window.InstanceCollection[$(this).selector];
            if (!instanceSettings) {
                instanceSettings = settings;
            }
			table.fnReloadAjax(instanceSettings.filterParams);
            return false;
        }

        // add/edit row
        if (settings.newData) {
            var table = $(this).dataTable();
            if (settings.dataId) {
                //check for existing row; if found, delete the row; 

                var $row = $(this).find("[data-post-id='" + settings.dataId + "']");

                if ($row.length) {
                    table.fnDeleteRow($row.closest('tr'));
                } else {
                    var $row2 = $(this).find("[data-index-id='" + settings.dataId + "']");
                    if ($row2.length) {
                        table.fnDeleteRow($row2.closest('tr'));
                    }
                }
            }
            table.fnAddRow(settings.newData);
            return false;
        }

        settings._visible_columns = [];
        $.each(settings.columns, function(index, column) {
            if (column.visible !== false) {
                settings._visible_columns.push(index);
            }
        });

        settings._exportable = settings.xlsColumns.length + settings.pdfColumns.length + settings.printColumns.length;
        settings._firstDayOfWeek = AppHelper.settings.firstDayOfWeek || 0;
        settings._inputDateFormat = "YYYY-MM-DD";


        var getWeekRange = function(date) {
            //set first and last day of week
            if (!date)
                date = moment().format("YYYY-MM-DD");

            var dayOfWeek = moment(date).format("E"),
                    diff = dayOfWeek - AppHelper.settings.firstDayOfWeek,
                    range = {};

            if (diff < 7) {
                range.firstDateOfWeek = moment(date).subtract(diff, 'days').format("YYYY-MM-DD");
            } else {
                range.firstDateOfWeek = moment(date).format("YYYY-MM-DD");
            }

            if (diff < 0) {
                range.firstDateOfWeek = moment(range.firstDateOfWeek).subtract(7, 'days').format("YYYY-MM-DD");
            }

            range.lastDateOfWeek = moment(range.firstDateOfWeek).add(6, 'days').format("YYYY-MM-DD");
            return range;
        };

        var prepareDefaultDateRangeFilterParams = function() {
            if (settings.dateRangeType === "daily") {
                settings.filterParams.start_date = moment().format(settings._inputDateFormat);
                settings.filterParams.end_date = settings.filterParams.start_date;
            } else if (settings.dateRangeType === "monthly") {
                var daysInMonth = moment().daysInMonth(),
                        yearMonth = moment().format("YYYY-MM");
                settings.filterParams.start_date = yearMonth + "-01";
                settings.filterParams.end_date = yearMonth + "-" + daysInMonth;
            } else if (settings.dateRangeType === "yearly") {
                var year = moment().format("YYYY");
                settings.filterParams.start_date = year + "-01-01";
                settings.filterParams.end_date = year + "-12-31";
            } else if (settings.dateRangeType === "weekly") {
                var range = getWeekRange();
                settings.filterParams.start_date = range.firstDateOfWeek;
                settings.filterParams.end_date = range.lastDateOfWeek;
            }
        };

        var prepareDefaultCheckBoxFilterParams = function() {
            var values = [],
                    name = "";
            $.each(settings.checkBoxes, function(index, option) {
                name = option.name;
                if (option.isChecked) {
                    values.push(option.value);
                }
            });
            settings.filterParams[name] = values;
        };

        var prepareDefaultRadioFilterParams = function() {
            $.each(settings.radioButtons, function(index, option) {
                if (option.isChecked) {
                    settings.filterParams[option.name] = option.value;
                }
            });
        };

        prepareDefaultDateRangeFilterParams();
        prepareDefaultCheckBoxFilterParams();
        prepareDefaultRadioFilterParams();

        var datatableOptions = {
		dom: 'lfrtBip',
		sorting: [[ 0, "asc" ]],
        processing: true,
        serverSide: true,
        "language": {
			processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
			emptyTable:     "Không có dữ liệu",
			info: "Hiển thị _START_ đến _END_ / _TOTAL_ dòng",
			infoEmpty:      "Hiển thị 0 đến 0 / 0 dòng",
			infoFiltered:   "(đã lọc từ _MAX_ dòng)",
			lengthMenu:     "Hiển thị _MENU_",
			search:         "Tìm kiếm:",
			zeroRecords:    "Không có dữ liệu được tìm thấy",
			paginate: {
				"first":      "First",
				"last":       "Last",
				"next":       "Next",
				"previous":   "Previous"
			},
			
		},
        ajax: {
	        url: '{!! route('datatables.data') !!}',
	        data: settings.filterParams
        },
        columns: settings.columns,
        initComplete: function(settings, json) {
	        
			console.log(json);
			}
		};	

        if (!settings.hideTools) {
            datatableOptions.sDom = "<'datatable-tools'<'col-md-3'l><'col-md-9 custom-toolbar'f>r>t<'datatable-tools clearfix'<'col-md-3'i><'col-md-9'p>>";
        }


        if (settings._exportable) {
            var datatableButtons = [];

            if (settings.xlsColumns.length) {
                //add excel button
                datatableButtons.push({
                    sExtends: "xls",
                    mColumns: settings.xlsColumns
                });
            }

            if (settings.pdfColumns.length) {
                //add pdf button
                datatableButtons.push({
                    sExtends: "pdf",
                    mColumns: settings.pdfColumns
                });
            }

            if (settings.printColumns.length) {
                //prepear print preview
                var arrayDiff = function(array1, array2) {
                    return array1.filter(function(i) {
                        return array2.indexOf(i) < 0;
                    });
                };
                settings._hiddenColumns = (arrayDiff(settings._visible_columns, settings.printColumns));
                datatableButtons.push({
                    sExtends: "print",
                    sToolTip: settings.customLanguage.printButtonToolTip,
                    sInfo: "",
                    fnClick: function(nButton, oConfig) {
                        //hide columns
                        for (var key in settings._hiddenColumns) {
                            oTable.fnSetColumnVis(settings._hiddenColumns[key], false);
                        }

                        $("html").addClass('print-peview');
                        $(".slimScrollDiv").addClass("print-peview");
                        $(".scrollable-page").addClass("print-peview");
                        this.fnPrint(true, oConfig);
                        //window.print();
                        $(window).keydown(function(e) {
                            //exit print preview;
                            if (e.which === 27) {
                                //show columns which has hidden during print preview
                                for (var key in settings._hiddenColumns) {
                                    oTable.fnSetColumnVis(settings._hiddenColumns[key], true);
                                }
                                $(".print-peview").removeClass("print-peview");
                                setPageScrollable();
                                $(".dataTables_processing").hide();
                            }
                        });
                    }
                });
            }
            if (!settings.hideTools) {
                datatableOptions.sDom = "<'datatable-tools'<'col-md-3'l><'col-md-9 custom-toolbar'f<'datatable-export'T>>r>t<'datatable-tools clearfix'<'col-md-3'i><'col-md-9'p>>";
            }

            datatableOptions.oTableTools = {
                aButtons: datatableButtons
            };
        }
        var oTable = $instance.DataTable(datatableOptions),
                $instanceWrapper = $instance.closest(".dataTables_wrapper");

        $instanceWrapper.find('.DTTT_button_print').tooltip({
            placement: 'bottom',
            container: 'body'
        });
       /* $instanceWrapper.find("select").select2({
            minimumResultsForSearch: -1
        });
*/

        //build date wise filter selectors
        if (settings.dateRangeType) {
            var dateRangeFilterDom = '<div class="mr15 DTTT_container">'
                    + '<button data-act="prev" class="btn btn-default date-range-selector"><i class="fa fa-chevron-left"></i></button>'
                    + '<button data-act="datepicker" class="btn btn-default" style="margin: -1px"></button>'
                    + '<button data-act="next"  class="btn btn-default date-range-selector"><i class="fa fa-chevron-right"></i></button>'
                    + '</div>';
            $instanceWrapper.find(".custom-toolbar").append(dateRangeFilterDom);

            var $datepicker = $instanceWrapper.find("[data-act='datepicker']"),
                    $dateRangeSelector = $instanceWrapper.find(".date-range-selector");

            //init single day selector
            if (settings.dateRangeType === "daily") {
                var initSingleDaySelectorText = function($elector) {
                    if (settings.filterParams.start_date === moment().format(settings._inputDateFormat)) {
                        $elector.html(settings.customLanguage.today);
                    } else if (settings.filterParams.start_date === moment().subtract(1, 'days').format(settings._inputDateFormat)) {
                        $elector.html(settings.customLanguage.yesterday);
                    } else if (settings.filterParams.start_date === moment().add(1, 'days').format(settings._inputDateFormat)) {
                        $elector.html(settings.customLanguage.tomorrow);
                    } else {
                        $elector.html(moment(settings.filterParams.start_date).format("Do, MMMM YYYY"));
                    }
                };
                prepareDefaultDateRangeFilterParams();
                initSingleDaySelectorText($datepicker);

                //bind the click events
                $datepicker.datepicker({
                    format: settings._inputDateFormat,
                    autoclose: true,
                    todayHighlight: true
                }).on('changeDate', function(e) {
                    var date = moment(e.date).format(settings._inputDateFormat);
                    settings.filterParams.start_date = date;
                    settings.filterParams.end_date = date;
                    initSingleDaySelectorText($datepicker);
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });

                $dateRangeSelector.click(function() {
                    var type = $(this).attr("data-act"), date = "";
                    if (type === "next") {
                        date = moment(settings.filterParams.start_date).add(1, 'days').format(settings._inputDateFormat);
                    } else if (type === "prev") {
                        date = moment(settings.filterParams.start_date).subtract(1, 'days').format(settings._inputDateFormat)
                    }
                    settings.filterParams.start_date = date;
                    settings.filterParams.end_date = date;
                    initSingleDaySelectorText($datepicker);
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });
            }


            //init month selector
            if (settings.dateRangeType === "monthly") {
                var initMonthSelectorText = function($elector) {
                    $elector.html(moment(settings.filterParams.start_date).format("MMMM YYYY"));
                };

                prepareDefaultDateRangeFilterParams();
                initMonthSelectorText($datepicker);

                //bind the click events
                $datepicker.datepicker({
                    format: "YYYY-MM",
                    viewMode: "months",
                    minViewMode: "months",
                    autoclose: true
                }).on('changeDate', function(e) {
                    var date = moment(e.date).format(settings._inputDateFormat);
                    var daysInMonth = moment(date).daysInMonth(),
                            yearMonth = moment(date).format("YYYY-MM");
                    settings.filterParams.start_date = yearMonth + "-01";
                    settings.filterParams.end_date = yearMonth + "-" + daysInMonth;
                    initMonthSelectorText($datepicker);
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });

                $dateRangeSelector.click(function() {
                    var type = $(this).attr("data-act"),
                            startDate = moment(settings.filterParams.start_date),
                            endDate = moment(settings.filterParams.end_date);
                    if (type === "next") {
                        startDate = startDate.add(1, 'months').format(settings._inputDateFormat);
                        endDate = endDate.add(1, 'months').format(settings._inputDateFormat);
                    } else if (type === "prev") {
                        startDate = startDate.subtract(1, 'months').format(settings._inputDateFormat);
                        endDate = endDate.subtract(1, 'months').format(settings._inputDateFormat);
                    }
                    settings.filterParams.start_date = startDate;
                    settings.filterParams.end_date = endDate;
                    initMonthSelectorText($datepicker);
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });
            }

            //init year selector
            if (settings.dateRangeType === "yearly") {
                var inityearSelectorText = function($elector) {
                    $elector.html(moment(settings.filterParams.start_date).format("YYYY"));
                };
                prepareDefaultDateRangeFilterParams();
                inityearSelectorText($datepicker);

                //bind the click events
                $datepicker.datepicker({
                    format: "YYYY-MM",
                    viewMode: "years",
                    minViewMode: "years",
                    autoclose: true
                }).on('changeDate', function(e) {
                    var date = moment(e.date).format(settings._inputDateFormat),
                            year = moment(date).format("YYYY");
                    settings.filterParams.start_date = year + "-01-01";
                    settings.filterParams.end_date = year + "-12-31";
                    inityearSelectorText($datepicker);
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });

                $dateRangeSelector.click(function() {
                    var type = $(this).attr("data-act"),
                            startDate = moment(settings.filterParams.start_date),
                            endDate = moment(settings.filterParams.end_date);
                    if (type === "next") {
                        startDate = startDate.add(1, 'years').format(settings._inputDateFormat);
                        endDate = endDate.add(1, 'years').format(settings._inputDateFormat);
                    } else if (type === "prev") {
                        startDate = startDate.subtract(1, 'years').format(settings._inputDateFormat);
                        endDate = endDate.subtract(1, 'years').format(settings._inputDateFormat);
                    }
                    settings.filterParams.start_date = startDate;
                    settings.filterParams.end_date = endDate;
                    inityearSelectorText($datepicker);
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });
            }

            //init week selector
            if (settings.dateRangeType === "weekly") {
                var initWeekSelectorText = function($elector) {
                    var from = moment(settings.filterParams.start_date).format("Do MMM"),
                            to = moment(settings.filterParams.end_date).format("Do MMM, YYYY");
                    $datepicker.datepicker({
                        format: "YYYY-MM-DD",
                        autoclose: true,
                        calendarWeeks: true,
                        weekStart: AppHelper.settings.firstDayOfWeek
                    });
                    $elector.html(from + " - " + to);
                };

                prepareDefaultDateRangeFilterParams();
                initWeekSelectorText($datepicker);

                //bind the click events
                $dateRangeSelector.click(function() {
                    var type = $(this).attr("data-act"),
                            startDate = moment(settings.filterParams.start_date),
                            endDate = moment(settings.filterParams.end_date);
                    if (type === "next") {
                        startDate = startDate.add(7, 'days').format(settings._inputDateFormat);
                        endDate = endDate.add(7, 'days').format(settings._inputDateFormat);
                    } else if (type === "prev") {
                        startDate = startDate.subtract(7, 'days').format(settings._inputDateFormat);
                        endDate = endDate.subtract(7, 'days').format(settings._inputDateFormat);
                    }
                    settings.filterParams.start_date = startDate;
                    settings.filterParams.end_date = endDate;
                    initWeekSelectorText($datepicker);
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });

                $datepicker.datepicker({
                    format: settings._inputDateFormat,
                    autoclose: true,
                    calendarWeeks: true,
                    weekStart: AppHelper.settings.firstDayOfWeek
                }).on("show", function() {
                    $(".datepicker").addClass("week-view");
                    $(".datepicker-days").find(".active").siblings(".day").addClass("active");
                }).on('changeDate', function(e) {
                    var range = getWeekRange(e.date);
                    settings.filterParams.start_date = range.firstDateOfWeek;
                    settings.filterParams.end_date = range.lastDateOfWeek;
                    initWeekSelectorText($datepicker);
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });
            }
        }

        //build checkbox filter
        if (typeof settings.checkBoxes[0] !== 'undefined') {
            var checkboxes = "", values = [], name = "";
            $.each(settings.checkBoxes, function(index, option) {
                var checked = "", active = "";
                name = option.name;
                if (option.isChecked) {
                    checked = " checked";
                    active = " active";
                    values.push(option.value);
                }
                checkboxes += '<label class="btn btn-default ' + active + '">';
                checkboxes += '<input type="checkbox" name="' + option.name + '" value="' + option.value + '" autocomplete="off" ' + checked + '>' + option.text;
                checkboxes += '</label>';
            });
            settings.filterParams[name] = values;
            var checkboxDom = '<div class="mr15 DTTT_container">'
                    + '<div class="btn-group filter" data-act="checkbox" data-toggle="buttons">'
                    + checkboxes
                    + '</div>'
                    + '</div>';
            $instanceWrapper.find(".custom-toolbar").append(checkboxDom);

            var $checkbox = $instanceWrapper.find("[data-act='checkbox']");
            $checkbox.click(function() {
                var $selector = $(this);
                setTimeout(function() {
                    var values = [],
                            name = "";
                    $selector.parent().find("input:checkbox").each(function() {
                        name = $(this).attr("name");
                        if ($(this).is(":checked")) {
                            values.push($(this).val());
                        }
                    });
                    settings.filterParams[name] = values;
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });
            });
        }


        //build radio button filter
        if (typeof settings.radioButtons[0] !== 'undefined') {
            var radiobuttons = "";
            $.each(settings.radioButtons, function(index, option) {
                var checked = "", active = "";
                if (option.isChecked) {
                    checked = " checked";
                    active = " active";
                    settings.filterParams[option.name] = option.value;
                }
                radiobuttons += '<label class="btn btn-default ' + active + '">';
                radiobuttons += '<input type="radio" name="' + option.name + '" value="' + option.value + '" autocomplete="off" ' + checked + '>' + option.text;
                radiobuttons += '</label>';
            });
            var radioDom = '<div class="mr15 DTTT_container">'
                    + '<div class="btn-group filter" data-act="radio" data-toggle="buttons">'
                    + radiobuttons
                    + '</div>'
                    + '</div>';
            $instanceWrapper.find(".custom-toolbar").append(radioDom);

            var $radioButtons = $instanceWrapper.find("[data-act='radio']");
            $radioButtons.click(function() {
                var $selector = $(this);
                setTimeout(function() {
                    $selector.parent().find("input:radio").each(function() {
                        if ($(this).is(":checked")) {
                            settings.filterParams[$(this).attr("name")] = $(this).val();
                        }
                    });
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });
            });
        }


        //build dropdown filter
        if (typeof settings.filterDropdown[0] !== 'undefined') {
            var radiobuttons = "";
            $.each(settings.filterDropdown, function(index, dropdown) {
                var optons = "", selectedValue = "";

                $.each(dropdown.options, function(index, option) {
                    var isSelected = "";
                    if (option.isSelected) {
                        isSelected = "selected";
                        selectedValue = option.id;
                    }
                    optons += '<option ' + isSelected + ' value="' + option.id + '">' + option.text + '</option>';
                });

                if (dropdown.name) {
                    settings.filterParams[dropdown.name] = selectedValue;
                }

                var selectDom = '<div class="mr15 DTTT_container">'
                        + '<select class="' + dropdown.class + '" name="' + dropdown.name + '">'
                        + optons
                        + '</select>'
                        + '</div>';
                $instanceWrapper.find(".custom-toolbar").append(selectDom);

                var $dropdown = $instanceWrapper.find("[name='" + dropdown.name + "']");
                if (window.Select2 !== undefined) {
                    $dropdown.select2();
                }


                $dropdown.change(function() {
                    var $selector = $(this);
                    settings.filterParams[$selector.attr("name")] = $selector.val();
                    $instance.appTable({reload: true, filterParams: settings.filterParams});
                });
            });
        }


        var undoHandler = function(eventData) {
            $('<a class="undo-delete" href="javascript:;"><strong>Undo</strong></a>').insertAfter($(eventData.alertSelector).find(".app-alert-message"));
            $(eventData.alertSelector).find(".undo-delete").bind("click", function() {
                $(eventData.alertSelector).remove();
                appLoader.show();
                $.ajax({
                    url: eventData.url,
                    type: 'POST',
                    dataType: 'json',
                    data: {id: eventData.id, undo: true},
                    success: function(result) {
                        appLoader.hide();
                        if (result.success) {
                            $instance.appTable({newData: result.data});
                            //fire success callback
                            settings.onUndoSuccess(result);
                        }
                    }
                });
            });
        };
        
        var deleteConfirmationHandler = function (e) {
            var alert = confirm("Bạn muốn xóa?");
            if(alert){
	            deleteHandler(e);
            }
        };


        var deleteHandler = function(e) {
            appLoader.show();
            var $target = $(e.currentTarget),
                    url = $target.attr('data-action-url'),
                    id = $target.attr('data-id');
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {id: id},
                success: function(result) {
                    if (result.success) {
                        var tr = $target.closest('tr'),
                                table = $instance.DataTable();
                        oTable.fnDeleteRow(table.row(tr).index());
                        var alertId = appAlert.warning(result.message, {duration: 20000});

                        //fire success callback
                        settings.onDeleteSuccess(result);

                        //bind undo selector
                        undoHandler({
                            alertSelector: alertId,
                            url: url,
                            id: id
                        });
                    } else {
                        appAlert.error(result.message);
                    }
                    appLoader.hide();
                }
            });
        };

        window.InstanceCollection = window.InstanceCollection || {};
        window.InstanceCollection["#" + this.id] = settings;



        $('body').find($instance).on('click', '[data-action=delete]', deleteHandler);
		$('body').find($instance).on('click', '[data-action=delete-confirmation]', deleteConfirmationHandler);


        $.fn.dataTableExt.oApi.getSettings = function(oSettings) {
            return oSettings;
        };

        $.fn.dataTableExt.oApi.fnReloadAjax = function(oSettings, filterParams) {
            this.fnClearTable(this);
            this.oApi._fnProcessingDisplay(oSettings, true);
            var that = this;
            $.ajax({
                url: oSettings.ajax.url,
                type: "POST",
                dataType: "json",
                data: filterParams,
                success: function(json) {
	                console.log('json',json);
	               $instance.DataTable().destroy();
                    /* Got the data - add it to the table */
                    for (var i = 0; i < json.data.length; i++) {
                        that.oApi._fnAddData(oSettings, json.data[i]);
                    }

                    oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
                    that.fnDraw(that);
                    that.oApi._fnProcessingDisplay(oSettings, false);
                }
            });
        };
        $.fn.dataTableExt.oApi.fnAddRow = function(oSettings, data) {
            this.oApi._fnAddData(oSettings, data);
            this.fnDraw(this);
        };

    };
})(jQuery);   
   

	 $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    
	$(document).ready(function() {
        $('#menu-table').appTable({
            source: '{!! route('datatables.data') !!}',
            order: [[0, "asc"]],
            filterDropdown: [{name: "parent", class: "w200", options: {!! $dropdown !!} }],
            columns: [
	        { data: 'index', name: 'index' , 'width' : "5%", visible: false },
            { data: 'id', name: 'id' , 'width' : "5%", visible: true },
            { data: 'name', name: 'name', 'width' : "50%" },
            { data: 'parent', name: 'parent', 'width' : "20%" },
            { data: 'action', name: 'action', orderable: false },
			]
        });
    });
	

    
    
     $('body').on('click', '[data-action="delete-confirmation"]', function () {
 
        var post_id = $(this).attr("data-post-id");
        
        if(confirm("Bạn có chắc muốn xóa !")){
 
        $.ajax({
            type: "POST",
            url: '{!! route('menu.delete') !!}',
            data: {'id' : post_id},
            success: function (data) {
	            console.log('success',data);
            let oTable = $('#menu-table').dataTable(); 
           	    oTable.fnDraw(false);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
        }
    });
    
    
     $("#parent").on('change', function(){
	    filterParams['parent'] = $(this).val();
	    let oTable = $('#menu-table').dataTable(); 
           	    oTable.fnDraw(false);
	   /* table.column($(this).data('column'))
	    	 .search($(this).val())
			 .draw();	
			 */
    });
 
    
});


	</script>
@endpush
