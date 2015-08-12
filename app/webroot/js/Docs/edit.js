/**
 * Created by tomaszdrazewski on 12/08/15.
 */

$(document).ready(function () {
    window.setTimeout(function (){
        var pages=$('.pf');

        console.log(pages);
        pages.each(function(page){
            console.log(page.html);
        });
    }, 1000);
});