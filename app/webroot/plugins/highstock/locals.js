/*global mPHeart, Highcharts*/

/*LANGUAGE PACK FOR HIGHCHARTS.JS*/
if (typeof Highcharts !== "undefined") {
	if (mPHeart.language.threeDig === 'pol') {
		Highcharts.setOptions({
			lang: {
				drillUpText: "◁ Powrót {series.name}",
				downloadJPEG: "Ściągnij plik w formacie JPEG",
				downloadPDF: "Ściągnij plik w formacie PDF",
				downloadPNG: "Ściągnij plik w formacie PNG",
				downloadSVG: "Ściągnij plik w formacie SVG",
				loading: "Ładowanie...",
				months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
				noData: "Brak danych do wyświetlenia",
				printChart: 'Drukuj',
				rangeSelectorFrom: 'Od',
				rangeSelectorTo: 'Do',
				rangeSelectorZoom: 'Wybrany zakres',
				resetZoom: 'Reset',
				resetZoomTitle: 'Reset do 1:1',
				shortMonths: ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru'],
				weekdays: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota']
			},
			rangeSelector: {
				buttonTheme: {
					states: {
						hover: {
							fill: '#337ab7',
							style: {
								color: '#ffffff'
							}
						},
						select: {
							fill: '#337ab7',
							style: {
								color: '#ffffff'
							}
						}
					}
				}
			}
		});
	}
}
