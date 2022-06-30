function showProcessingOverlay()
{
    var doc_height = $(document).height();
    var doc_width  = $(document).width();
    var spinner_html = "";

    // spinner_html += '<div class="sk-cube1 sk-cube"></div>';
    // spinner_html += '<div class="sk-cube2 sk-cube"></div>';
    // spinner_html += '<div class="sk-cube4 sk-cube"></div>';
    // spinner_html += '<div class="sk-cube3 sk-cube"></div>';
    spinner_html += '<img src="'+asset_url+'/images/loader.gif">';

    $("body").append("<div id='global_processing_overlay'><div class='sk-folding-cube'>"+spinner_html+"</div></div>");

    $("#global_processing_overlay").height(doc_height)
    .css({
        'opacity' : 1,
        'position': 'fixed',
        'top': 0,
        'left': 0,
        'background-color': 'rgb(230 230 230 / 90%)',
        'width': '100%',
        'z-index': 2147483647,
        'text-align': 'center',
        'vertical-align': 'middle',
        'margin': 'auto',
    });
}

function hideProcessingOverlay()
{
    $("#global_processing_overlay").remove();
}