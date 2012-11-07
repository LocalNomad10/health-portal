var page_stats_flot_options = {
    series: {
        lines: { show: true },
        points: { show: true }
    },
    xaxis: {
        mode: "time",
        timeformat: "%d"
    }
};

$(document).delegate('#page-secure-stats', 'pageshow', function(){
  $.post( "/secure/stats/data", {}, function( data ){
    var plot = $.plot($("#flot-container"), data, page_stats_flot_options);
  });
});
