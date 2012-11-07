var page_stats_flot_options = {
    series: {
        lines: { show: true },
        points: { show: true }
    }
};

$(document).delegate('#page-secure-stats', 'pageshow', function(){
  var plot = $.plot($("#flot-container"), page_stats_flot_data, page_stats_flot_options);
});
