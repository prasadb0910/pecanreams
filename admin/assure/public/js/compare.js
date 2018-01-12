var tbl_project_details_1;
var tbl_project_details_2;
var tbl_project_details_3;

$(function () {
    $(".select2").select2({
        closeOnSelect: false
    });
    set_datatable(1);
    set_datatable(2);
    set_datatable(3);
});

var set_datatable = function (index) {
    if(index==1){
        tbl_project_details_1 = $("#tbl_project_details_1").DataTable({
                                                                        aLengthMenu:[10,25,50,100],
                                                                        ordering: false,
                                                                        scrollX: true,
                                                                    });
    } else if(index==2){
        tbl_project_details_2 = $("#tbl_project_details_2").DataTable({
                                                                        aLengthMenu:[10,25,50,100],
                                                                        ordering: false,
                                                                        scrollX: true,
                                                                    });
    } else if(index==3){
        tbl_project_details_3 = $("#tbl_project_details_3").DataTable({
                                                                        aLengthMenu:[10,25,50,100],
                                                                        ordering: false,
                                                                        scrollX: true,
                                                                    });
    }
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
var set_total_sf_donut = function (sold, unsold, index) {
  /*
  * DONUT CHART
  * -----------
  */
  var donutData = [
    {label: "Sold", data: sold, color: "#004d99"},
    {label: "Unsold", data: unsold, color: "rgb(204, 0, 0)"},
  ];
  $.plot("#total_sf_chart_"+index, donutData, {
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
var set_total_units_donut = function (sold, unsold, index) {
  /*
  * DONUT CHART
  * -----------
  */
  var donutData = [
    {label: "Sold", data: sold, color: "#004d99"},
    {label: "Unsold", data: unsold, color: "rgb(204, 0, 0)"},
  ];
  $.plot("#total_units_chart_"+index, donutData, {
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
var set_total_fsi_donut = function (sold, unsold, index) {
  /*
  * DONUT CHART
  * -----------
  */
  var donutData = [
    {label: "Proposed " + sold, data: sold, color: "#004d99"},
    {label: "Approved " + unsold, data: unsold, color: "rgb(204, 0, 0)"},
  ];
  $.plot("#total_fsi_chart_"+index, donutData, {
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

var set_type_of_apt_area_bar_graph =  function (data,data1,data2,data3,index) {
$('#type_of_apt_area_'+index).html('');
Highcharts.chart('type_of_apt_area_'+index, {
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


var set_type_of_apt_units_bar_graph =  function (data,data1,data2,data3,index) {
$('#type_of_apt_units_'+index).html('');
Highcharts.chart('type_of_apt_units_'+index, {
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


var set_type_of_completion_area_bar_graph =  function (data,data1,data2,data3,index) {
$('#type_of_completion_area_'+index).html('');
Highcharts.chart('type_of_completion_area_'+index, {
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

var set_type_of_completion_units_bar_graph =  function (data,data1,data2,data3,index) {
$('#type_of_completion_units_'+index).html('');
Highcharts.chart('type_of_completion_units_'+index, {
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

var set_type_of_subregion_area_bar_graph =  function (data,data1,data2,data3,index) {
$('#type_of_subregion_area_'+index).html('');
Highcharts.chart('type_of_subregion_area_'+index, {
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

var set_type_of_subregion_units_bar_graph =  function (data,data1,data2,data3,index) {
$('#type_of_subregion_units_'+index).html('');
Highcharts.chart('type_of_subregion_units_'+index, {
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

// $('#btn_get_details_1').click(function(){
//     var locations = $('#location_1').val();
//     var project_types = $('#project_type_1').val();
//     var entity_type = $('#entity_type_1').val();
//     // if (locations!=null || project_types!=null || entity_type!=null){
//     //  get_data(locations, project_types, entity_type);
//     // }
//     get_data(locations_1, project_types_1, entity_type_1);
// });

var set_criteria = function (elem) {
    var id = elem.id;
    var index = id.substr(id.lastIndexOf('_')+1);

    if(document.getElementById(id).value == 'Developer'){
        $('#developer_div_'+index).show();
        $('#location_div_'+index).hide();
        $('#project_div_'+index).hide();
    } else if(document.getElementById(id).value == 'Market'){
        $('#developer_div_'+index).hide();
        $('#location_div_'+index).show();
        $('#project_div_'+index).hide();
    } else {
        $('#developer_div_'+index).hide();
        $('#location_div_'+index).hide();
        $('#project_div_'+index).show();
    }
}

var get_data = function(elem){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var id = elem.id;
    var index = id.substr(id.lastIndexOf('_')+1);

    var locations = null;
    var developers = null;
    var projects = null;

    // console.log(document.getElementById('criteria_'+index).value);

    if(document.getElementById('criteria_'+index).value == 'Developer'){
        developers = $('#developer_'+index).val();
    } else if(document.getElementById('criteria_'+index).value == 'Market'){
        locations = $('#location_'+index).val();
    } else {
        projects = $('#project_name_'+index).val();
        // console.log(projects);
    }

    $.ajax({
        url:BASE_URL+'compare/get_data',
        type:'post',
        data: {_token: CSRF_TOKEN, locations: locations, developers: developers, projects: projects},
        datatype:'json',
        beforeSend: function(){
            $('.chart_div_'+index).html('');
            $('.loader_'+index).show();
            $('.loader_'+index).html('Loading...');
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

            $('#total_fsi_' + index).html(total_fsi);
            $('#master_proj_cnt_' + index).html(master_proj_cnt);
            $('#no_of_prop_' + index).html(total_cnt);
            $('.total_sf_' + index).html(total_carpet_area);
            $('.total_units_' + index).html(total_units);

            set_total_sf_donut(sold_carpet_area, unsold_carpet_area, index);
            set_total_units_donut(sold_units, unsold_units, index);
            set_total_fsi_donut(proposed_fsi, approved_fsi, index);

            set_type_of_apt_area_bar_graph(apartment_area,apartment_type_bhk,sold_carpet_area_bhk,unsold_carpet_area_bhk, index);
            set_type_of_apt_units_bar_graph(apartment_units,apartment_type_units_bhk,sold_units_bhk,unsold_units_bhk, index);

            set_type_of_completion_area_bar_graph(completion_area,year_of_completion_area_year,sold_carpet_area_year,unsold_carpet_area_year, index);
            set_type_of_completion_units_bar_graph(completion_units,year_of_completion_units_year,sold_units_year,unsold_units_year, index);

            set_type_of_subregion_area_bar_graph(subregion_area,sub_location_area_loc,sold_carpet_area_loc,unsold_carpet_area_loc, index);
            set_type_of_subregion_units_bar_graph(subregion_units,sub_location_units_loc,sold_units_loc,unsold_units_loc, index);

            if(index==1){
                tbl_project_details_1.destroy();
            } else if(index==2){
                tbl_project_details_2.destroy();
            } else if(index==3){
                tbl_project_details_3.destroy();
            }
            
            $("#tbl_project_details_" + index + " tbody").html(project_details);
            set_datatable(index);

            // console.log(subregion_units);
        },
        complete: function(){
            $('.loader_'+index).hide();
        },
        error: function(response){
            var r = jQuery.parseJSON(response.responseText);
            console.log("Message: " + r.Message);
            console.log("StackTrace: " + r.StackTrace);
            console.log("ExceptionType: " + r.ExceptionType);
        }
    });
};