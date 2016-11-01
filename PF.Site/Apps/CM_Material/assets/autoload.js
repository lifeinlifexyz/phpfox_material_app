if(!jQuery().tableDnD) {
    document.write('<link rel="stylesheet" type="text/css" href="' + getParam('sStylePath') + 'drag.css?v=' + getParam('sVersion') + '" />');
    document.write('<script type="text/javascript" src="' + getParam('sJsHome') + 'static/jscript/jquery/plugin/jquery.tablednd.js?v=' + getParam('sVersion') + '"></script>');
    //run plugin dependent code
}
Core_drag =
{
    init: function(aParams)
    {
        $(document).ready(function()
        {
            $(aParams['table']).tableDnD(
                {
                    dragHandle: 'drag_handle',
                    onDragClass: 'drag_my_class',
                    onDrop: function (oTable, oRow)
                    {
                        iCnt = 0;
                        sParams = '';
                        $('.drag_handle input').each(function()
                        {
                            iCnt++;

                            sParams += '&' + $(this).attr('name') + '=' + iCnt;
                        });

                        $('.drag_handle_input').each(function()
                        {
                            sParams += '&' + $(this).attr('name') + '=' + $(this).attr('value');
                        });

                        if (aParams['ajax'].substr(0, 7) == 'http://' || aParams['ajax'].substr(0, 8) == 'https://') {
                            $Core.processing();
                            $.ajax({
                                url: aParams['ajax'],
                                type: 'POST',
                                data: sParams,
                                success: function() {
                                    $('.ajax_processing').remove();
                                }
                            });
                        }
                        else {
                            $Core.ajaxMessage();
                            $.ajaxCall(aParams['ajax'], sParams + '&global_ajax_message=true');
                        }
                    }
                });

            $(aParams['table'] + " tr.checkRow").hover(
                function()
                {
                    $(this.cells[0]).addClass('drag_show_handle');
                },
                function()
                {
                    $(this.cells[0]).removeClass('drag_show_handle');
                }
            );
        });
    }
};

function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}
var cmContentIsLoaded = false;
$Ready(function() {
    if (findGetParameter('sectiontype') == 'coll' && !cmContentIsLoaded) {

        cmContentIsLoaded = true;
        $('.apps_menu a[href*="cmmaterial/section/coll/"]').addClass('active');

        $.ajax({
            url: getParam('sBaseURL') + '/admincp/cmmaterial/section/coll/',
            contentType: 'application/json',
            success: function(e) {
                $('#custom-app-content').html(e.content).show();
                $Core.loadInit();
            }
        });
    }
   Core_drag.init({
        table: '#js_drag_drop',
        ajax: 'cmmaterial.sectionOrdering'
    });
});