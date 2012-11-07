$(document).delegate('#page-secure-stats', 'pageshow', function(){
  $.post( "/secure/stats/data", {}, function( data ){
    var i = 0;
    $.each(data, function(key, val) {
        val.color = i;
        ++i;
    });
    
    var choiceContainer = $("#flot-series");
    choiceContainer.html("");
    $.each(data, function(key, val) {
        choiceContainer.append('<input type="checkbox" name="' + key +
                               '" checked="checked" class="custom" data-mini="true" id="cbid' + key + '">' +
                               '<label for="cbid' + key + '">'
                                + val.label + '</label>');
    });
    
    var options = {
        series: {
            lines: { show: true },
            points: { show: true }
        },
        xaxis: {
            mode: "time",
            timeformat: "%d"
        }
    };
    
    function plotAccordingToChoices() {
        var dataFiltered = [];

        choiceContainer.find("input:checked").each(function(){
            var key = $(this).attr("name");
            if( key && data[key] )
                dataFiltered.push(data[key]);
        });

        if( dataFiltered.length > 0 )
            var plot = $.plot($("#flot-container"), dataFiltered, options);
    }
    
    choiceContainer.find("input").unbind( "click", plotAccordingToChoices );
    choiceContainer.find("input").bind( "click", plotAccordingToChoices );
    plotAccordingToChoices();
  });
});
