//Here we set a globally the altRows option
jQuery.extend(jQuery.jgrid.defaults, {
	datatype : "json",
	sortable : true,
	height : '100%',
	//altRow : true,
	autowidth : true,
	gridview : true,   //afterInsertRow will not work if it is true.
	viewrecords : true,
	loadError : function(x, st, err) {
		$('#errorBox').show();
		var xtype;
		if (x.status == 0) {
			xtype = 'You are offline!!\n Please Check Your Network.';
		} else if (x.status == 404) {
			xtype = 'Requested URL not found.';
		} else if (x.status == 500) {
			xtype = 'Internel Server Error.';
		} else if (st == 'parsererror') {
			xtype = 'Error.\nParsing JSON Request failed.';
		} else if (st == 'timeout') {
			xtype = 'Request Time out.';
		} else {
			xtype = 'Unknown Error.\n' + x.responseText;
		}

		jQuery("#rsperror").html(xtype + '\n' + x.statusText);
	},
	loadComplete : function() {
		$('#errorBox').hide();
	}
});

function addPager(gridTable, gridPager) {
	jQuery(gridTable).jqGrid('gridResize');
	var sgrid = $(gridTable)[0];

	jQuery(gridTable).jqGrid('navButtonAdd', gridPager, {
		caption : "",
		title : "Toggle Search Toolbar",
		buttonicon : 'ui-icon-search',
		onClickButton : function() {
			sgrid.toggleToolbar();
		}
	});

	jQuery(gridTable).jqGrid('navButtonAdd', gridPager, {
		caption : "",
		title : "Clear Search",
		buttonicon : 'ui-icon-refresh',
		onClickButton : function() {
			sgrid.clearToolbar();
		}
	});
	jQuery(gridTable).jqGrid('navButtonAdd', gridPager, {
		caption : "",
		title : "Reorder Columns",
		buttonicon : 'ui-icon-grip-dotted-horizontal',
		onClickButton : function() {
			jQuery(gridTable).jqGrid('columnChooser', {
				   done : function (perm) {
				      if (perm)  {
				          this.jqGrid("remapColumns", perm, true);
				          var gwdth = this.jqGrid("getGridParam","width");
				          this.jqGrid("setGridWidth",gwdth);
				      }
				   }
				});
		}
	});
	jQuery(gridTable).jqGrid('filterToolbar', {
		searchOnEnter : true
	});
	sgrid.toggleToolbar();

	/*
	 * Following function(s) should be handled n implemented in better way...
	 */

	$("#ajaxStatus").bind("ajaxSend", function() {
		$(this).show();
		$(this).text('Sending...');
	}).bind("ajaxComplete", function() {
		$(this).hide();
	});
	
	
	$("#debugBox").bind("ajaxError",
					function(event, XMLHttpRequest, ajaxOptions, thrownError) {
						$(this).html('');
						$(this).append("<p>event.data :" + event.data + "</p>");
						$(this).append("<p>event.result :" + event.result + "</p>");
						$(this).append("<p>event.type :" + event.type + "</p>");
						$(this).append("<p>XMLHttpRequest.readyState :"
										+ XMLHttpRequest.readyState + "</p>");
						$(this).append("<p>XMLHttpRequest.responseText :"
										+ XMLHttpRequest.responseText + "</p>");
						$(this).append("<p>XMLHttpRequest.status :"
										+ XMLHttpRequest.status + "</p>");
						$(this).append("<p>XMLHttpRequest.statusText :"
										+ XMLHttpRequest.statusText + "</p>");
						$(this).append("<p>ajaxOptions.data :" 
										+ ajaxOptions.data + "</p>");
						$(this).append("<p>ajaxOptions.dataType :" 
										+ ajaxOptions.dataType + "</p>");
						$(this).append("<p>ajaxOptions.type :" 
										+ ajaxOptions.type + "</p>");
						$(this).append("<p>ajaxOptions.url :" 
										+ ajaxOptions.url + "</p>");
						$(this).append("<p>^^^^^^^^^^^^^^^^^^^^</p>");
						console.log(thrownError);
				});
				
				/*.bind("ajaxSuccess",
					function(event, XMLHttpRequest, ajaxOptions) {
						$(this).append("<p>event.data :" + event.data + "</p>");
						$(this).append("<p>event.result :" + event.result + "</p>");
						$(this).append("<p>event.type :" + event.type + "</p>");
						$(this).append("<p>XMLHttpRequest.readyState :"
										+ XMLHttpRequest.readyState + "</p>");
						$(this).append("<p>XMLHttpRequest.responseText :"
										+ XMLHttpRequest.responseText + "</p>");
						$(this).append("<p>XMLHttpRequest.status :"
										+ XMLHttpRequest.status + "</p>");
						$(this).append("<p>XMLHttpRequest.statusText :"
										+ XMLHttpRequest.statusText + "</p>");
						$(this).append("<p>ajaxOptions.data :" 
										+ ajaxOptions.data + "</p>");
						$(this).append("<p>ajaxOptions.dataType :" 
										+ ajaxOptions.dataType + "</p>");
						$(this).append("<p>ajaxOptions.type :" 
										+ ajaxOptions.type + "</p>");
						$(this).append("<p>ajaxOptions.url :" 
										+ ajaxOptions.url + "</p>");
						$(this).append("<p>___________________</p>");
				});*/

}