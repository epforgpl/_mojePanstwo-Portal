/*LANGUAGE PACK FOR HIGHCHARTS.JS*/
if (typeof(Highcharts) !== "undefined") {
    if (mPHeart.language.threeDig == 'pol') {
        Highcharts.setOptions({
            lang: {
                loading: "Ładowanie...",
                printChart: 'Drukuj',
                rangeSelectorFrom: 'Od',
                rangeSelectorTo: 'Do',
                months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
                shortMonths: ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru'],
                weekdays: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
                resetZoom: 'Reset',
                resetZoomTitle: 'Reset do 1:1'
            }
        });
    }
}