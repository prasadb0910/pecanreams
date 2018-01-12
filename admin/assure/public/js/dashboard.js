var tbl_project_details;

$(function () {
	$(".select2").select2({
		closeOnSelect: false
	});
	set_datatable();
});

var set_datatable = function () {
	tbl_project_details = $("#tbl_project_details").DataTable({
								aLengthMenu:[10,25,50,100],
								ordering: false,
								scrollX: true,
							});
};


/*
* Custom Label formatter
* ----------------------
*/
function labelFormatter(label, series) {
	return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
	+ label
	+ "<br>"
	+ Math.round(series.percent) + "%</div>";
}
var set_total_sf_donut = function (sold, unsold) {
	/*
	* DONUT CHART
	* -----------
	*/
	var donutData = [
		{label: "Sold", data: sold, color: "#004d99"},
		{label: "Unsold", data: unsold, color: "rgb(204, 0, 0)"},
	];
	$.plot("#total_sf_chart", donutData, {
		series: {
			pie: {
				show: true,
				radius: 1,
				innerRadius: 0.5,
				label: {
					show: true,
					radius: 2 / 3,
					formatter: labelFormatter,
					threshold: 0.1
				}
			}
		},
		legend: {
			show: false
		}
	});
	/*
	* END DONUT CHART
	*/
};
var set_total_units_donut = function (sold, unsold) {
	/*
	* DONUT CHART
	* -----------
	*/
	var donutData = [
		{label: "Sold", data: sold, color: "#004d99"},
		{label: "Unsold", data: unsold, color: "rgb(204, 0, 0)"},
	];
	$.plot("#total_units_chart", donutData, {
		series: {
			pie: {
				show: true,
				radius: 1,
				innerRadius: 0.5,
				label: {
					show: true,
					radius: 2 / 3,
					formatter: labelFormatter,
					threshold: 0.1
				}
			}
		},
		legend: {
			show: false
		}
	});
	/*
	* END DONUT CHART
	*/
};
var set_total_fsi_donut = function (sold, unsold) {
	/*
	* DONUT CHART
	* -----------
	*/
	var donutData = [
		{label: "Proposed " + sold, data: sold, color: "#004d99"},
		{label: "Approved " + unsold, data: unsold, color: "rgb(204, 0, 0)"},
	];
	$.plot("#total_fsi_chart", donutData, {
		series: {
			pie: {
				show: true,
				radius: 1,
				innerRadius: 0.5,
				label: {
					show: true,
					radius: 2 / 3,
					formatter: labelFormatter,
					threshold: 0.1
				}
			}
		},
		legend: {
			show: false
		}
	});
	/*
	* END DONUT CHART
	*/
};

var set_type_of_apt_area_bar_graph =  function (data,data1,data2,data3) {
$('#type_of_apt_area').html('');
Highcharts.chart('type_of_apt_area', {
	colors: ['#004d99','#cc0000'],
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data1,
        labels: {
            rotation: 0,
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Area in Lacs sf'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -00,
        verticalAlign: 'top',
        y: 0,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: 'Sold',
        data: data2,
        pointWidth: 35
    }, {
        name: 'Unsold',
        data: data3,
        pointWidth: 35
    }]
});
};


var set_type_of_apt_units_bar_graph =  function (data,data1,data2,data3) {
$('#type_of_apt_units').html('');
Highcharts.chart('type_of_apt_units', {
	colors: ['#004d99','#cc0000'],
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data1,
        labels: {
            rotation: 0,
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total No of Units'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -00,
        verticalAlign: 'top',
        y: 0,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: 'Sold',
        data: data2,
        pointWidth: 35
    }, {
        name: 'Unsold',
        data: data3,
        pointWidth: 35
    }]
});
};


var set_type_of_completion_area_bar_graph =  function (data,data1,data2,data3) {
$('#type_of_completion_area').html('');
Highcharts.chart('type_of_completion_area', {
	colors: ['#004d99','#cc0000'],
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data1,
        labels: {
            rotation: 0,
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Area in Lacs sf'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -00,
        verticalAlign: 'top',
        y: 0,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: 'Sold',
        data: data2,
        pointWidth: 35
    }, {
        name: 'Unsold',
        data: data3,
        pointWidth: 35
    }]
});
};

var set_type_of_completion_units_bar_graph =  function (data,data1,data2,data3) {
$('#type_of_completion_units').html('');
Highcharts.chart('type_of_completion_units', {
	colors: ['#004d99','#cc0000'],
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data1,
        labels: {
            rotation: 0,
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total No in Units'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -00,
        verticalAlign: 'top',
        y: 0,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: 'Sold',
        data: data2,
        pointWidth: 35
    }, {
        name: 'Unsold',
        data: data3,
        pointWidth: 35
    }]
});
};

var set_type_of_subregion_area_bar_graph =  function (data,data1,data2,data3) {
$('#type_of_subregion_area').html('');
Highcharts.chart('type_of_subregion_area', {
	colors: ['#004d99','#cc0000'],
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data1,
        labels: {
            rotation: 0,
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Area in Lacs sf'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -00,
        verticalAlign: 'top',
        y: 0,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: 'Sold',
        data: data2,
        pointWidth: 35
    }, {
        name: 'Unsold',
        data: data3,
        pointWidth: 35
    }]
});
};

var set_type_of_subregion_units_bar_graph =  function (data,data1,data2,data3) {
$('#type_of_subregion_units').html('');
Highcharts.chart('type_of_subregion_units', {
	colors: ['#004d99','#cc0000'],
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data1,
        labels: {
            rotation: 0,
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total No in Units'
        },
        stackLabels: {
            enabled: false,
            style: {
                fontWeight: 'bold',
                color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
            }
        }
    },
    legend: {
        align: 'right',
        x: -00,
        verticalAlign: 'top',
        y: 0,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
            }
        }
    },
    series: [{
        name: 'Sold',
        data: data2,
        pointWidth: 35
    }, {
        name: 'Unsold',
        data: data3,
        pointWidth: 35
    }]
});
};



$('#btn_get_details').click(function(){
	var locations = $('#location').val();
	var project_types = $('#project_type').val();
    var entity_type = $('#entity_type').val();
	// if (locations!=null || project_types!=null || entity_type!=null){
	// 	get_data(locations, project_types, entity_type);
	// }
    get_data(locations, project_types, entity_type);
});

var get_data = function(locations, project_types, entity_type){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url:BASE_URL+'home/get_data',
        type:'post',
        data: {_token: CSRF_TOKEN, locations: locations, project_types: project_types, entity_type: entity_type},
        datatype:'json',
        beforeSend: function(){
            $('.chart_div').html('');
            $('.loader').show();
            $('.loader').html('Loading...');
        },
        success: function(response){
            data = JSON.parse(response);

            var master_proj_cnt = data.master_proj_cnt;
            var total_cnt = data.total_cnt;

            var proposed_fsi = data.proposed_fsi;
            var approved_fsi = data.approved_fsi;
            var total_fsi = data.total_fsi;
            var proposed_fsi_per = data.proposed_fsi_per;
            var approved_fsi_per = data.approved_fsi_per;

            var total_carpet_area = data.total_carpet_area;
            var sold_carpet_area = data.sold_carpet_area;
            var unsold_carpet_area = data.unsold_carpet_area;
            var total_units = data.total_units;
            var sold_units = data.sold_units;
            var unsold_units = data.unsold_units;
            var apartment_area = data.apartment_area;
            var apartment_units = data.apartment_units;
            var completion_area = data.completion_area;
            var completion_units = data.completion_units;
            var subregion_area = data.subregion_area;
            var subregion_units = data.subregion_units;
            var project_details = data.project_details;

            var apartment_type_bhk = data.apartment_type_bhk;
            var sold_carpet_area_bhk = data.sold_carpet_area_bhk;
            var unsold_carpet_area_bhk = data.unsold_carpet_area_bhk;

            var apartment_type_units_bhk = data.apartment_type_units_bhk;
            var sold_units_bhk = data.sold_units_bhk;
            var unsold_units_bhk = data.unsold_units_bhk;

			var year_of_completion_area_year = data.year_of_completion_area_year;
            var sold_carpet_area_year = data.sold_carpet_area_year;
            var unsold_carpet_area_year = data.unsold_carpet_area_year;

            var year_of_completion_units_year = data.year_of_completion_units_year;
            var sold_units_year = data.sold_units_year;
            var unsold_units_year = data.unsold_units_year;

            var sub_location_area_loc = data.sub_location_area_loc;
            var sold_carpet_area_loc = data.sold_carpet_area_loc;
            var unsold_carpet_area_loc = data.unsold_carpet_area_loc;

            var sub_location_units_loc = data.sub_location_units_loc;
            var sold_units_loc = data.sold_units_loc;
            var unsold_units_loc = data.unsold_units_loc;            

            $('#total_fsi').html(total_fsi);
            $('#master_proj_cnt').html(master_proj_cnt);
            $('#no_of_prop').html(total_cnt);
            $('.total_sf').html(total_carpet_area);
            $('.total_units').html(total_units);

            set_total_sf_donut(sold_carpet_area, unsold_carpet_area);
            set_total_units_donut(sold_units, unsold_units);
            set_total_fsi_donut(proposed_fsi, approved_fsi);

            set_type_of_apt_area_bar_graph(apartment_area,apartment_type_bhk,sold_carpet_area_bhk,unsold_carpet_area_bhk);
            set_type_of_apt_units_bar_graph(apartment_units,apartment_type_units_bhk,sold_units_bhk,unsold_units_bhk);

            set_type_of_completion_area_bar_graph(completion_area,year_of_completion_area_year,sold_carpet_area_year,unsold_carpet_area_year);
            set_type_of_completion_units_bar_graph(completion_units,year_of_completion_units_year,sold_units_year,unsold_units_year);

            set_type_of_subregion_area_bar_graph(subregion_area,sub_location_area_loc,sold_carpet_area_loc,unsold_carpet_area_loc);
            set_type_of_subregion_units_bar_graph(subregion_units,sub_location_units_loc,sold_units_loc,unsold_units_loc);

            tbl_project_details.destroy();
            $("#tbl_project_details tbody").html(project_details);
            set_datatable();

            // console.log(subregion_units);
        },
        complete: function(){
            $('.loader').hide();
        },
        error: function(response){
            var r = jQuery.parseJSON(response.responseText);
            console.log("Message: " + r.Message);
            console.log("StackTrace: " + r.StackTrace);
            console.log("ExceptionType: " + r.ExceptionType);
        }
    });
};