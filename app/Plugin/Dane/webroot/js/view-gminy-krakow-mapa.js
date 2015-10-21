/**
 * Created by tomaszdrazewski on 15/09/15.
 */
var map,
	markers = [],
	layers = {},
	options,
	layers_colors = {
		dzielnice: {
			I: '#7cb5ec',
			II: '#434348',
			III: '#90ed7d',
			IV: '#f7a35c',
			V: '#8085e9',
			VI: '#f15c80',
			VII: '#e4d354',
			VIII: '#2b908f',
			IX: '#f45b5b',
			X: '#91e8e1',
			XI: '#7cb5ec',
			XII: '#434348',
			XIII: '#90ed7d',
			XIV: '#f7a35c',
			XV: '#8085e9',
			XVI: '#f15c80',
			XVII: '#e4d354',
			XVIII: '#2b908f'
		}
	};
$(document).ready(function () {
	var mapa = $('#map');

	options = {
		zoom: 11,
		center: new google.maps.LatLng(50.0467656, 20.0048731),
		zoomControl: true,
		mapTypeControl: true,
		scaleControl: true,
		streetViewControl: false,
		overviewMapControl: true,
		scrollwheel: true,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
			position: google.maps.ControlPosition.TOP_RIGHT
		},
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.LARGE,
			position: google.maps.ControlPosition.RIGHT_TOP
		},
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		backgroundColor: '#FFFFFF',
		minZoom: 11,
		maxZoom: 20,
		styles: [
			{
				featureType: "all",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}
		]
	};

	var border = new google.maps.Polygon({
		paths: [
			[
				new google.maps.LatLng(-90, -90),
				new google.maps.LatLng(-90, 90),
				new google.maps.LatLng(90, 90),
				new google.maps.LatLng(90, -90)
			],
			google.maps.geometry.encoding.decodePath(krakow_spat)
		],
		fillColor: "#FFFFFF",
		fillOpacity: .8,
		strokeOpacity: .5,
		strokeColor: "#444499",
		strokeWeight: 1
	});

	map = new google.maps.Map(document.getElementById('map'), options);
	map.setTilt(0);
	border.setMap(map);

	function getLayers(type) {
		$.ajax({
			method: 'GET',
			url: 'mapa_layer.json',
			data: {type: type},
			async: false,
			success: function (res) {

				if (res.type == 'polygon') {
					layers[res.layer] = {};
					$.each(res.dane, function (k, v) {
						var path = google.maps.geometry.encoding.decodePath(v['spat']);

						layers[res.layer][v['id']] = new google.maps.Polygon({
							path: path,
							fillColor: layers_colors[res.layer][v['id']],
							fillOpacity: .2,
							strokeOpacity: .5,
							strokeColor: layers_colors[res.layer][v['id']],
							strokeWeight: 1,
							clickable: false
						});
					});
				}
				if (res.type == 'markers') {
					layers[res.layer] = {};
					$.each(res.dane, function (key, val) {
						layers[res.layer][key] = [];
						$.each(val, function (k, v) {

							var latlang = v['latlng'].split(',');
							var lang = parseFloat(latlang[0]);
							var lat = parseFloat(latlang[1]);

							layers[res.layer][key][k] = new google.maps.Marker({
								position: new google.maps.LatLng(lat,lang),//{lat:v['latlng'].replace(",", ",lang:")},
								title: v['etykieta']+"\n"+v['adres'],
								label: v['etykieta']
							});
						});
					});
				}
				if (res.type == 'path') {
					layers[res.layer] = {};
					$.each(res.dane, function (k, v) {
						var path = google.maps.geometry.encoding.decodePath(v['spat']);

						layers[res.layer][v['id']] = new google.maps.Polyline({
							path: path,
							strokeColor: layers_colors[res.layer][v['id']],
							strokeOpacity: 0.5,
							strokeWeight: 1,
							clickable: false
						});
					});
				}
				if (res.type == 'mixed') {

					layers[res.layer] = {};
					$.each(res.dane, function (k, v) {
						var i=0;
						//var color=
						if(v['type']=='polyline') {
							var path = google.maps.geometry.encoding.decodePath(v['spat']);

							layers[res.layer][v['id']] = new google.maps.Polyline({
								path: path,
								strokeColor: layers_colors[res.layer][v['id']],
								strokeOpacity: 0.5,
								strokeWeight: 1,
								clickable: false
							});
						}
						if(v['type']=='polygon') {
							var path = google.maps.geometry.encoding.decodePath(v['spat']);

							layers[res.layer][v['id']] = new google.maps.Polygon({
								path: path,
								fillColor: layers_colors[res.layer][v['id']],
								fillOpacity: .2,
								strokeOpacity: .5,
								strokeColor: layers_colors[res.layer][v['id']],
								strokeWeight: 1,
								clickable: false
							});
						}
						if(v['type']=='marker'){

							var latlang = v['latlng'].split(',');
							var lang = parseFloat(latlang[0]);
							var lat = parseFloat(latlang[1]);

							layers[res.layer][key][k] = new google.maps.Marker({
								position: new google.maps.LatLng(lat,lang),
								title: v['etykieta'],
								label: v['etykieta']
							});
						}
						i++;
					});

				}
			},
			error: function (xhr) {
				alert("Wystąpił błąd: " + xhr.status + " " + xhr.statusText);
			}
		});
	}

	$('#dzielnice_all').change(function () {
		var $dzielnica = $('.dzielnica');

		if (!(typeof(layers[$(this).val()]) != "undefined" && layers[$(this).val()] != null)) {
			getLayers($(this).val());
		}
		$dzielnica.prop('checked', $(this).is(':checked'));

		$dzielnica.each(function () {
			if ($(this).is(':checked')) {
				layers[$(this).data('layer')][$(this).val()].setMap(map);
			} else {
				layers[$(this).data('layer')][$(this).val()].setMap(null);
			}
		});
	});

	$('#edukacja_all').change(function () {
		var $this = $(this);
		var $edukacja = $('.edukacja');

		if (!(typeof(layers[$(this).val()]) != "undefined" && layers[$(this).val()] != null)) {
			getLayers($(this).val());
		}

		$edukacja.prop('checked', $(this).is(':checked'));

		$edukacja.each(function () {
			if ($this.is(':checked')) {
				$.each(layers[$(this).data('layer')][$(this).val()], function (k, v) {
					v.setMap(map);
				});
			} else {
				$.each(layers[$(this).data('layer')][$(this).val()], function (k, v) {
					v.setMap(null);
				});
			}
		});

	});

	$('.layer').change(function () {
		var $this = $(this);

		if (!(typeof(layers[$(this).data('layer')]) != "undefined" && layers[$(this).data('layer')] != null)) {
			getLayers($(this).data('layer'));
		}

		if ($this.hasClass('dzielnica')) {
			if ($(this).is(':checked')) {
				layers[$(this).data('layer')][$(this).val()].setMap(map);
			} else {
				layers[$(this).data('layer')][$(this).val()].setMap(null);
			}
		}
		if ($this.hasClass('edukacja')) {
			if ($(this).is(':checked')) {
				$.each(layers[$(this).data('layer')][$(this).val()], function (k, v) {
					v.setMap(map);
				});
			} else {
				$.each(layers[$(this).data('layer')][$(this).val()], function (k, v) {
					v.setMap(null);
				});
			}
		}

	});

	$('.menu_scroling ul.list-unstyled.first > li > .glyphicon').click(function () {
		var that = $(this);

		if (that.hasClass('glyphicon-minus')) {
			that.removeClass('glyphicon-minus').addClass('glyphicon-plus');
			that.parent().find('>ul').hide();
		} else {
			that.removeClass('glyphicon-plus').addClass('glyphicon-minus');
			that.parent().find('>ul').removeClass('hide').show();
		}
	});

	function google_layers() {
		var styling = [];

		if ($('#place_i_wezly').is(':checked')) {
			styling.push({
				featureType: "all",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "all",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}

		if ($('#administrative_locality').is(':checked')) {
			styling.push({
				featureType: "administrative.locality",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "administrative.locality",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#administrative_neighborhood').is(':checked')) {
			styling.push({
				featureType: "administrative.neighborhood",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "administrative.neighborhood",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#administrative_land_parcel').is(':checked')) {
			styling.push({
				featureType: "administrative.land_parcel",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "administrative.land_parcel",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}


		if ($('#road_arterial').is(':checked')) {
			styling.push({
				featureType: "road.arterial",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "road.arterial",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#road_highway').is(':checked')) {
			styling.push({
				featureType: "road.highway",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "road.highway",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#road_highway_controlled_access').is(':checked')) {
			styling.push({
				featureType: "road.highway.controlled_access",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "road.highway.controlled_access",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#road_local').is(':checked')) {
			styling.push({
				featureType: "road.local",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "road.local",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#water').is(':checked')) {
			styling.push({
				featureType: "water",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "water",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#transit_station_bus').is(':checked')) {
			styling.push({
				featureType: "transit.station.bus",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "transit.station.bus",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#transit_station_airport').is(':checked')) {
			styling.push({
				featureType: "transit.station.airport",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "transit.station.airport",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}
		if ($('#transit_station_rail').is(':checked')) {
			styling.push({
				featureType: "transit.station.rail",
				elementType: "labels",
				stylers: [{visibility: "on"}]
			});
		} else {
			styling.push({
				featureType: "transit.station.rail",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			});
		}

		styling.push({
			featureType: "poi",
			elementType: "labels",
			stylers: [{visibility: "off"}]
		});

		styling.push({
			featureType: "landscape",
			elementType: "labels",
			stylers: [{visibility: "off"}]
		});

		options.zoom = map.getZoom();
		options.center = map.getCenter();
		options.styles = styling;

		map.setOptions(options);
	}

	$('.google_layers_switch').change(function () {
		google_layers();
	});

	$('#road').change(function () {
		$('.typy_drog').prop('checked', $(this).is(':checked'));
		google_layers();
	});

	$('#transit').change(function () {
		$('.transport').prop('checked', $(this).is(':checked'));
		google_layers();
	});

	$('#transit_station').change(function () {
		$('.stacje').prop('checked', $(this).is(':checked'));
		google_layers();
	});

	if ($(window).outerWidth() > 728) {
		var menuholder = $('.menuholder'),
			mapholder = $('.mapholder'),
			fundatorzy = $('#fundatorzy').outerHeight(true),
			header = $('.appHeader').outerHeight(true),
			submenu = $('.appMenu').outerHeight(true);
		var size = $(window).outerHeight() - fundatorzy - header - submenu;

		if (size > 500) {
			mapa.css('min-height', size);
			mapholder.css('min-height', size);
			menuholder.css('min-height', size);
		}
	}

	var map_height = mapa.height();
	$("#map_menu").draggable({
		containment: "parent",
		zIndex: 100,
		handle: 'span'
	}).resizable({
		minWidth: 200,
		maxWidth: 500,
		minHeight: 400,
		maxHeight: map_height - 50
	}).height(Math.round(map_height / 2));
});

var krakow_spat = 'ixcpHmfzwBCLE\\?J?@@D?JC\\@p@CVILEHEHEFE`@?N?NPNFEJNHPPXXRZVHSRd@N\\NX?BR|@b@xA@@^pABRBJ@FSRk@Vq@J]bBiBmAyCaA}Co@qDr@_Ff@{GvAgGv@aCt@_BGuBZkEl@mF^gFdAwElBoGxCqBz@cDbAyCZyAKaBe@_A_@cCsBm@YwAcBw@{Aa@qAw@oEs@uEk@mCqB{D}B{CmCcCyA}@_Ae@}@WiAEqA[yD]KEwImDwBm@_E}BwBcB}BqCeAwAgBkDcAuCcAqFWcDAqCDsC^uDd@iB^gA\\aABIn@uAJUDKP_@xB{ApB_BvA{@xAiA`D}AzCwAr@}@v@uAt@mBx@sD^wBBSVeDAkDOoD_@kCs@}Cc@u@}B}GaGsOyCqHcAyA}BiBiBo@oBa@uA@gCZaC~@aFxAw@XmAb@kAd@GBo@Zw@^aAf@y@`@gAf@k@Xc@TOD[FODI@iATXnBBNFp@Ff@H|@BRB\\B`@@VDfABz@Dz@@V?D@ZD`AB~@Bl@Bl@Av@?p@Aj@?Z?LGx@Et@Ev@Id@APKr@MdAIv@Kj@G\\ADCJUl@]r@Sj@CFAD[~@Uf@O\\OXKRKTELIZOl@?@Kr@Q`@O^M\\A?OXILOPSROLQPYTMLMLURMHURWPYt@Ob@Wp@Wr@IPa@FM@E?[BSDODG@]HEBE@KBC@A@_@HC?SFKBE@MDMDA@WLGDMDUJUHSJC@MDC@GBWB??MCECYMa@C]MMC{@A{@C{@AGB_@RYN_@ROHKFGH[^SXGHCJELCF?BGR[~@AFWfAWrAE?c@GKASCOCM@[?]@W?IDG?UC_AOGC]E_@IA@e@IOEQESCOKGO?AAIu@Q[c@EGOMEKw@{Ac@_@g@_@USEEm@k@k@}@s@qA[e@UUMOSSq@u@q@s@g@k@e@a@YYUW[_@AASWUWk@s@??USA?SQ?Ag@i@AAUU?AQSWWW[SQSUIKEECAIEEKKKUSOIEAE?ICEIk@eA{@Yi@Sa@SYKe@Qc@Qe@y@e@y@G?SQYMKIICWKSQUU@ESO[QICOCEAGASCI?[?]BM?SEWGWIMG[Qc@USIAGUCEAOGY?O@W?U?OH_@AYEOCWIKGa@U?CA?WMOK_@SOKYGYGOAS?W@YDI?E?YKOBODODG@MBI@[CQAKCWGOEICMGA?SIWKMG[QYSSOGGWWMOKOMUS_@??OYCCCJBjA@PDXCREVAR?j@?D@N?P@\\?\\?ZAVAX?LGRCJUb@CRGVEXERCRAFGZIf@CPGXE\\CXCT?DEREVERGTKPWh@Kh@GZGXG\\CLCRCTCLANAt@@Z@XB`@?HN^@Z?BETAFBRD^@Db@RCVCN@FDn@@NDTNp@@JFz@HfA^fABFFNSz@NdAFf@Lz@DHAHCNM@S@KBWBg@HWJAL?LARCf@U@G@MBKTKRKRITGFORABKBOFUFaAZGBuAh@C@A?A?YLEZYjB?@EVIp@??Il@Gd@QlAM~@Kp@Ih@Ih@Kh@Ih@Ih@O`AIj@ADSvAGb@ALC?C?A?K?A?E???C?sAEE?u@Am@AuAA[?g@?k@BU@W@AGIAIAk@VOFC@]LA?[Nm@XiAr@a@TQJq@`@_@Pw@\\UHe@TSHEBYNSLGBa@V]VYRUN]R??[Rw@h@kAl@GD??OJE@YJWe@CGAAQ]IOCECEIQMSKUQ]AAOWOYQYQ]KQQYGOMSQ[S]OWCGGMQYQ[OWMWMSGKCECESa@GICGIOIOOWIOUUQSCCKMUQMOIGCCCASMYOECICUKQG{@[aA[cA[CA??MG_Ac@s@]A?GCA?]IQCIEOEq@WiAa@A?GC{@[g@Ow@Y{@[o@W]O[K]Ig@Gm@Co@@kBZSUUWk@m@SUEGMMEGMOAASYWa@KWOYYq@M_@K[Qc@KYKWIYI]GYKg@Ea@Ea@Ca@Ac@?aA?A?e@@c@A{@?a@C_@A]Cc@Gw@ASC]C[C[E]CSEWCSGUG[EWG_@Gi@E[MmA?Y?[Ba@@m@@k@Ie@Ma@Kc@Ge@A[@c@Ag@Gc@IOKISOQMSOOSS_@M]IUCWAAC[E_@E[E[E]G_@C_@E[G[E[IUAEI]M_@Oq@CUCUAW@WE?A?Im@OmAKmBKUOOu@LUCMGKIMKQUCAOYGQGOKWI[AKOc@AGOm@So@IUEQO_@Sc@Ue@KUa@u@OYa@w@QWYc@c@s@c@y@Yo@MSKSMOIOCEMIQ?IFAOk@a@SOSMKIOIQKg@_@YQCCWS_@Sg@[e@SG]CYCGMUK_@[@MDIy@AQESGc@EUCMWoAGa@ACEe@CO?KA]AIA_@?U?C?G?E?A?E@U@]?CBc@B[Bu@@YF{@@Q?CBa@@E@W@SBe@B_@EEYUKGWSEC?AKIi@a@QQkAqAa@a@H]Ha@^sBaAeAkAoA??CCI[eAkA@MNWBW?U[c@WKIOAKCa@FS@C@SEQWs@KU]MSKEIAEGYEOGGISAA[SIQCUCc@EYCKCIUSIKEOAOEOCi@Di@HSCSE[GIUc@Ua@M_@Oa@Is@Sq@FSNSHg@?W@EDQ?c@A_ACU?EAG?g@Bc@ASAAAOO[IIIWGa@ASKUMe@GYCUO]IWEWEAQWE[MS?IKe@BQCMAQCEW]DQCSEICcAQs@M[C_@Eq@G]c@qACu@_@q@Mg@Uo@_@kAKu@?GOmAMcAFq@LqALsAHq@Ju@Hu@`AsGL}@PuBBkA?cAAkA?}@?w@?KH_BFiAH}@DODSVsAHM?K@GFa@BUDSD[DWDUDWDUDUDUBUHWFUHUPm@ECG@s@q@WU]Y[WWSQQCCGE][_@[]Y_@[_@[_@]YU_@]_@W]]_@[_@]][YSc@_@a@][Y_@[][c@_@??_@[][_@[_@Yc@a@YU]]_@Yq@m@SQ_@]_@]a@]_@[[YEBe@Z[R[T_AlAbBjFITgCxByAr@kDPK@[@Yd@MHgChBsI`DqA~@sFxBsGiHWgXc@_Bc@oA_Le\\cAsCWo@_AgCk@yA]q@a@k@g@g@_@YMKMKOMOMOQSQMMQOOMMIKIKEIEGEMEICKCG?IAYEGEEDGBEBG@E?K?QCKAOCGCICMEOI]O[MA?[OOGOIQIOIYOWOYQUMSKQGSIWIQIUGUEk@SWISIOGQGSGMEOEKEGC[KMGMESGYOa@MUEUC[EO?SCSASCSCC?MEIEKEGCECEC]UOMOIOKQKOKQOKIIGSSCACC_@[GEYSYSWYCCMKQSQQMOOQOQIIIKGKIKU]Ya@MQIOQYSa@ISGMSe@KYGUQm@IWKg@Om@Su@Ke@Kc@Mo@Im@EMCQAK?W?K?MCKAQ?Q?S@UAQ?MA_@?g@?m@@OAIAOG_BEk@Eg@C_@Iy@Gq@CSEYEUG_@ES?CEUACAECQCSCWCSC[AYAUAW?W?S?S?W@U@a@@EFw@@YFs@B[BQ@IHa@BUg@JM@E?E?C?KCEAGAI@GDMNSHE?CFAFa@~@EDMNI\\UB[FYBIuAE}AAg@UBUB?_@?_@CsA?y@UDMBSBUDUBUDUBO?UASA[CMAi@Cs@GC?EAEmD?c@?mBCa@?SBE?I?c@?}@?u@@k@?q@?k@Ac@@QAo@?cA?G?{@?aA?i@AY?aAAk@D@@?pACK}BK}BjAj@@bALrCr@CLM?}A_@cC[qAg@sBJM@AJKNM@CTMBANIBAIm@LGNGPGLGBAHCRINEFAJCD?DACOLG@ALKHKFEb@YZWACJILILIPMHKFIFIJMLQLUNSDKLSFOHOFQFQDKHSHQFMDOHOHQJUL]Xe@JQLQFQBOBUDETWJAFOFIFIHIJIHINORWLKVWPSJIDGDGNQNMDETOFGBCHIBCPOTSXQXQVOHGJGVQRMNKNOVS@CHOFGV]VW^a@DEF?JIJEFGFEDGHKJKFKJMNUBGDIDGFGHGHGPINGLENGJCr@Yf@Kf@Qn@WRE\\IXGTCn@GTETGRITELCJCHCDGPIVG`@OVGPEFCFEHGRWFGJEJCLARGDAD@JCTIXMRG`@GRGPIXKRKXO\\MXENAJCNELGVOTMPMTMf@WDCDCNGXSPMZITCZEXEXMVOp@]p@WXMVQVMn@QTGVGVEL?JCRENELGRGVI`@M^KXIj@O`@Mh@Sh@Qp@WXKDABAx@Yl@Sj@UVK??LERELELG^OVIXIDAVEHA@?ZALEp@K@?HC`@IFAHCB?TCTGRGRGBAVE@ADAHAJAJAJCD?BALADANCPEFAPCF?LCJAVATEVC@ALAFAB?B?@?B?HA@???VA@?XC??RCXC@?HALA@ALCB?HALC??LCJA@?LALCB?JAVCXAFA@K?EJ_AFc@Ds@BY@W@IBK@KBMJq@@MBWDYFm@BODQDUDS@G?AHe@D]BUBSBUBUBWFe@@Q@Gc@AU@C?OAa@AQCA?KAG@Q???KD[JOFEB?AGWGUCMCG?AEUCII_@CG?ACIK]?AGSIU??EUGUCICKGUGS?AGUIYCI??K_@EOWZCEOc@EQOg@AC[_Ac@qASo@]eAM[EMSi@Og@?AOe@Qs@K]IUUy@Ss@Om@Mc@AAAISm@GUMa@AECKGQEQCGCIGSCKEO?AAEIa@TGY]GASQIIM[CKW{@EM[mANi@J_@BQLCLCP?RBRD`@?NSVK^s@b@g@HUIMEGKY]s@Q]Q_@_@y@k@mAm@uAQRQRm@^QHKHSPOR@Be@Zg@Zc@Ti@Zg@ZYNACKy@AMKoAG{@EKMG]Q]m@GMCCc@o@CCGECAOGQCO@QBWH]HUD]DUDI@GDGDGDMNMR_@l@OTMTSZU^Wj@KRQ^_@x@_@z@M\\S`@]r@EPSn@@d@A`@@X\\bBdAcA`@e@RU`@c@b@c@HINO`@c@\\_@b@g@b@i@NSV[LO@AHGFEHEJEF?H?DBFBFBLBCf@MhB?FAHAJ?PCd@?FAFAVTHLHDBVPXXDDBDJR@L@VARCXc@|@a@^A@OJOLQNQLQNAPAVMCm@R}@^[@WDYHYHUD[D]FUFMBMDUHWHIJOPINSVMHC@IDC@C@A@A?g@LQHWRQN[TE@EDESQe@ISIQ?A]y@MWGICEEEGGGCQGQI[KQGEAECCAWJc@R_@Pg@P_@PQFSHc@Na@Lc@TM@K@AE?CCGAEKa@AGGWK_@ACE_@Gc@E]AE?CIg@AGCYEc@AGE[CYAIAKASCUp@Mh@ILEb@Qh@Ud@SCI??Su@Su@AC[gAK[CKK[AIEMEWEWC]C]AYAU?k@Aq@Ag@Cu@C_@Ec@?AI_AAII}@AQGu@IcAIq@Ku@AIAMKu@Ga@Ki@GYOu@Io@SuAUyAG@cA^OiAK}@CQCQGg@Ea@AIG_@Ce@Gk@AS?A??G{@E{@MiAAYAOAYGgACa@Cc@Ca@Ei@GeAG?SBK@KBg@Hg@FS@S?Q?UCe@AKAKCMAGAw@Gs@Ui@K_@E{@EA[Au@AS?EACAYCi@?EE[?GAEB[AE?M@M@M@KFa@@OD_@@QDk@@SB[Bw@?G@_@AQC_@Cg@MiAA[Ey@Cc@Ac@E[C_@AMCQAKAg@Ek@Go@Es@GiAIwAGw@HIJGHEJCPG@ARIVKd@WBAHCJCHCZGBARGRIBABALAJCFCPG@ANE@?VKHCHCBALGHCNGDCFANIBARIROTMRMBAPMTQFEXUBCRSROHITW@ARUNOTS@AJKFETUVSJKTUBCTUNOHIHKJOPQDGNOHKHIJKFGJKHIDELMBERWDIJO@CHMBENYNY@ALYR_@P[^s@Vc@HOJSBIPYJO@?FONW@CP]R_@T[p@_AFGFKb@k@^o@j@w@`@g@PU??DEVOd@a@j@e@NM@A@CHGA[KqCI{BFIB?|AJVBfADl@B@?XIRKTMd@]l@e@PQd@a@BA?K@?Ai@Cm@?EA_AAcAAk@?m@?AAq@C[E[I[?AK[K[Oa@M]Y}@CGSc@k@gAKWKOGI?ACESe@MW?Ae@g@A?]c@AC_@i@CCSW??@CJ[BEBEBC\\s@HW@G?CJm@FYPk@L]R{@FUDWDYJc@?GBGVk@@KFe@BWDUFe@Fa@D[FW@KJg@Li@Jc@La@Ja@Ja@H]BEFO@EFKP_@d@y@V_@V_@X]Vu@LSJ]To@H[Po@BK@OB@Jo@d@oCD[Hm@Hc@Fe@B[Bs@HcBF_ADm@RcDDiAFy@JgABUDWFUDULq@NcAHUb@wBDYDk@@c@?IEsAAm@@GAMDg@BQF]BODKPm@f@yAXo@Te@HMDK^e@i@y@WYSSc@WB[?CB[B_@BmBDi@@UBUB[Hw@BOFm@Fe@H_ALwAJ_BHy@Fy@Hw@^iDYwAA?E@A?U}@AE]oAAWEw@AI?AVq@Da@OaAS{@CKEQe@s@a@{@EIGOWg@i@gAQq@?AUiASaAMm@AICGACUeBKu@MqAMsAMqACa@Ca@Gu@CW?C@G?EGaBEq@AQOyCA}BG_D?C?K?MAuB?mA?aBCeA?e@@g@?G?U?C@_A?I?C?O?u@@_@?]?o@@e@DiABaBBq@D{BGaCCo@?G@a@HcG@o@J_HJsFP_I?G@y@D{B@a@?AD{CDuA@]@GBO@g@@w@@_A@{@@a@?K?[@{@@iABeA@u@@_ABWV{DFs@XqBHm@h@sCj@aDj@eCt@mE^_BpAyCTe@pAiCJUp@kAG_B?AGs@?AEg@Ei@AAIy@Ew@IcAGiAGcAK_B?UIAI?UCYCQCSGGAECICCAGAQGA?MGc@OC?EAKAIAC?E?C?E?E?K??A?GIcD?K?EGoCAg@AO?OmDgCcFsDA_@GUkA{FEKw@uBUm@t@MAAOmAJEKcCCq@GgA[JWFWFWLa@N]Ly@Ts@RACCGG]Ku@Gm@AMo@@a@QGEIGIIEIAAO]Sc@GGIMIIKI[SIEYOMEIEGCKCICI?SC{A^I?M@M@K?GAECGEGIGKEKEIGYGYGa@@?QeACMGk@Ik@Gm@Eg@Gw@Ew@Ee@Ew@Cw@Cm@CqAE}@C_AEgAb@ELCNCNERGPINIRMZWNKXS\\YNOJKb@e@TURU@A^_@LOb@]FI@CfBgB?AfAcB@A?A}@q@}@s@CCACQSQUHIJGt@k@t@k@n@e@l@e@LIJGRKPMZYZYBAHGHGo@qACGCGCUEWA]A_@Aa@?a@?y@?y@AQAQAIAKAGCEOq@]y@OQg@g@EW?e@@Q?S?OCQu@{@kAjCMSc@s@r@gBx@}Bg@QCSCYgARe@KG?SEQOEEOIKII?GCCAIC?A??MIECOOOSOSKMQWKOCAISGQEKEMI[KFCi@Ca@D_@@WAMIe@AQ?UFQJq@BQJIFUFa@FS?G?EAAEi@CSCWACBMDY?EFEA_@QYU[SYGGQ[MUk@gAi@o@MS[q@G@GFG@i@YQIGEWKg@Sa@S^yB@U?U@a@Dc@@KBs@CCA[?Q@QBSBS@UDk@De@@S@O?ENiBpCd@@g@?c@Be@@e@BQ@Q?K@]?Y?Y?YBm@@]A[?MAUIy@Iq@Gm@E]AWAIGo@Kw@ACEe@G]My@Ge@E_@E_@AWEaA?W?]?i@?a@@o@@e@?c@@m@Ba@@_@@e@@s@@u@?w@?w@?ANARA\\Al@ALAD@ZE\\Ab@CJ??a@@Y?y@@mA@o@?o@As@?W?cA?o@@m@Ak@Ac@Am@C}@?I?UCa@?SGu@Cm@Ak@?ECi@Aq@A]E_AGcBDMDMBWD[BQ@E@OFo@Di@Ba@D]@WD_@@KBU@ED]Hc@Ni@HUBGDGDBBBFDZf@HJFFDF@H?@FV?B@HDJDFBJJVJT@BDJLTPTHJPNDFBBNJRNBBFFB@LLTX@@RVVVTVJNJJVZPRXXTVTVFFJL?@FLLJNPTX@EBEFWBIPm@HUJYBELUX]HIb@]BCHINM@AVYDERYFGDGHO?EACAOAUA[A_@AS@?AY???CAQ??AU??CO?EAECM??EM?AGMK]K_@GUGSIY?ACGKi@G[Su@UaAAGQu@Ki@I_@WkASUQ_@Ka@E[OiACq@Cq@Ag@EoA?KAMEg@ECMSKQIKKKEEIEECEEGAEAOCSEKAc@EKAG?IAK?G?C?O?K?C?C?E?CECGEYCQCMACAKCKEKEOYoA@a@?}@?G?QDyA?U@e@B]Fq@Fu@B[@W?S?MIW?GQI]Ae@Cg@Ec@Cu@CW?WAo@?q@AIA[CKA?ECo@Cg@Cq@AYAEAOAWAOCQASCWCSAMCYGa@EYIe@EWMq@G[CQ??GUEYKe@I_@I]EQCOIY?EGSI_@?CEICSG]EWE]Ms@Ie@EYE]EYGk@CScAAg@?Y?U?Y@c@EW?QAi@Ki@Uc@U[MuAw@e@Uw@k@CCi@]YUa@YMQOQYYEAq@a@QEGCIAs@M??IBGWHMPq@?C?ABIJo@Hi@BQ??XeCHg@?M@?BYJy@NgAPsARyATkBTeBTmBDSTeBb@eDb@kDj@wEPmADg@@MNiANgAVuBVoBTqBFi@Fa@BW?WBwAF_B?O?IHF@I?CB_ADcBH{C@c@oAI?o@AS?c@Ak@Aw@A]?o@?e@?i@Ai@A_@C_AAaA?yB@e@Bu@D{@DaA@{AJsABo@Di@JQJOPWv@oA@?iAwAECQ]HYFeAHq@Hq@XwAZQHMHA@?ZCJCPAf@Gt@Ct@?pAApACHA~@CBEDBPAtAGrBQhBKzBQVEjAIpBIp@Cl@?~@Ax@AjBAhAC\\CAm@?k@Ag@Aa@@u@?k@AS?M?IAUAK?M?K@QBWDq@Hc@Dc@BI@E@MBS@OBa@B_@BW@MDODOFQJODGDIFOBM@O@MDg@@k@Di@Bc@DYF[Ps@HSDOBKBMFWBOFa@D_@Dc@D]Da@H}@Fy@D}@B]B{@Ds@B[@ID}@@]D_AD}@Bq@Bi@F_@DWH[@SBQ@g@@k@?_@?]Ay@?SAUAq@Aa@@GAq@C}@As@?G?G?O?y@?c@Ac@@E?k@?i@@[?QBO@O?K?o@?e@@e@B}ABoA@UBq@?E?K??d@K?C@_B?E?Y@{@?o@@s@?a@Am@@o@?wA@q@@aA?Q?ICcA?I@sAB_ABo@@m@?e@@WOGYG_@Iq@Kg@Ge@Ge@Im@Kq@Mq@Kc@Ia@Gu@Mo@Ks@Ua@QQMEAECIJCA[Ia@IEAi@Kq@Sm@QOEe@OYIWIe@UGCs@]q@a@a@WMKGEk@a@o@g@SQUSm@_@c@]c@[e@a@[Ye@a@OOQ[Su@M[M]Ym@[o@We@k@aA?Ac@w@GK]u@s@}AeAsBw@yAEG]s@CCm@iAQ[_@k@Y_@GG[_@OOMMc@c@GEWQi@Us@[MGOICAA?OIMKMS??EGIS]iA[iA[u@A?CGEGJWFMJSLk@Ps@Ti@Tk@JSLUBI@CBA?C@CH]Ry@@EC?c@IMGSJGAKSHW]{@S@Im@KSE?SNEEGSYMEOEs@W_@WKE]WMGME][G?]QQAUSMGIOSA?GUGEAAGSICON[OMPk@IA@OHG@WHLcE?KL_E?_@?Y?aB?k@AyA?M?o@Aw@As@As@@u@?u@?qA?Y?[?w@?AAy@CuAdBBdBBB}BBwCBuFB{D@{D@eC@oC@iA?_Ab@OVIPIt@Wz@e@rAg@ZIHKIEi@_@JgDyCmCHYDUN{@Z_BNm@l@iBb@qA?A`AaD~@aDNc@LQLMXS`@Sd@Wl@e@TSLUn@kC^_BNu@H[La@yA{@]Uc@YKIe@[c@]h@mBl@yBn@aCh@oBd@iB_@g@g@_@o@]q@{@k@u@OS}@aAKi@\\eDXeCKMBM`@qCL}@Kk@a@u@i@Yi@Kg@Qi@w@e@m@c@cAWw@[{AG_@Sm@Km@?_@BQJQr@s@Xk@PmBVcBt@_Bp@qAEk@M]QMa@Kc@Eo@QqA[JoAJeA?yAOcAIUkBmCcAiANuAv@oDu@B?s@@{CFBbBIxAMv@OtAJv@?jAE~@@z@a@MyEIyAEiAEkBH_AXs@RWn@tDxCHTI|@WFmCByAB_ADmBNaGf@cJx@j@vA~BnA~@z@l@X^f@h@NR`CzB|@t@JLh@z@d@h@n@h@x@`@LDd@RJDJDt@ZKtDGzC@^?VBv@FbAFd@BDFLJTf@lA\\h@f@`@XRl@`@LPHt@Jx@DJH\\L`@Lb@@BJXJTJTVn@@@j@dAh@|@PVt@hALXPb@H\\@BD^FhA@d@?h@B|Av@Tj@Rn@P^NHH@@RTFHVRLHp@DBAdAFTBD@pAPJ@f@JXLZXb@n@@?^l@FHJLRN^VHJ^b@h@^^TFBd@X\\Vn@d@XJ@?v@HJBf@FZFD@z@PJBp@N`@J`@L`A\\`AZ`AXfABdAHJ@v@JdALTBn@HZDf@F`@D`@FdAPj@HZDX@N@X?dB?F?@M?C?@VEn@Ez@K\\E^A^Bb@HZD`AZxADXAvACz@Cp@CBANChBEnAE@?|@@b@CVC^IlBg@@?hB_@HA`B]FAREh@K^G\\G\\IpAUVE`AOXEVERJRNHFNXJX?@DJPt@DVNpAPxBDd@BZHj@L`@d@~@FLNTBFDHJXFZD\\D`@Db@Dz@F~ADnA@J?TDhB@fA@`A@~@HnADf@LrARAPCXMTOT[R_@Jc@F[NiADi@?_@Am@?i@AM@kBFkAPwBDQDUZeAHSVa@^g@^c@VU~@_@XEZF`@Tv@PJCZ?hA@`AAd@Wb@W\\[\\e@HMBM@S?u@Ro@LSPSDAHCNGLEv@_APk@Hs@D[@Kh@{@n@K`@@J@b@QJc@H]He@z@Wj@[Ha@l@oBHu@V?^@`@?T@N{D`@B`@@h@Gh@@vACr@Br@MDALO@CLO@MJqAPsBl@SDAVIHEDIDO~@oEhAqFDGFAfAKl@ELdFPpFHbE@^DvA@PBz@\\OPGBVD`@Nj@Lj@P`@FFd@l@DCRXRTv@lAHJ@@j@|@JLFPDLpAb@^@xAB^I|Bi@b@cBTs@\\iAt@{BZyDX_DbAsEvBcEnAuAjBSd@GrAOPuABUrAsEp@{Bt@cCVsBtB}Ft@iA\\Sg@_DQBEg@Eu@N}@NsAPDPg@Vq@\\Yz@q@d@_@HGLKTQh@_@f@a@NKPMFE@AhAy@f@_@f@_@BCPKPMfAu@TQTOHE`@WhAs@|@k@rA}@fAu@lAcARQdCgB??ZU`C_BTOn@m@dAcAxAyALQzAqBhA}ADGh@m@~@iAnA{AFIzAuBHKtByCFIHM\\e@h@w@tAdDn@nAfBvC~@|AnAhBtAdBfAlAdAjAr@r@r@l@d@`@rAx@~Av@fBfAbAj@|@`@vAb@~Af@vAf@tAj@hA|@`@f@^`@n@`Ar@nAr@hBf@jBZlBHj@Jv@NxAPpBPjCJhCCxBG|BI|BSbCMlCk@bCWfBm@pBs@bDe@rA[|@s@dBw@dBw@fBgAtBYh@eAzB}@|B{@fCu@xCc@nBs@lD[`DQxBMzBGzCAbCHtGXxGPnCJ`Bz@jHp@nFt@pF|@jG~@hGbAdG~@|F~@hGDXz@dFhAbG~@zFpAfI~@pG@Fn@jGp@pGl@rGb@tGRzG@pJAtDApAKzG_@fH_@vDWrCE`@UdBc@bDkA`HiAvGgAfGYxBERq@hD]hBMr@]vCc@|CUjCUjF@xB?bB\\rF\\jCl@bDp@hCTp@Zz@d@dAh@z@h@`AFJdAvA|@bAz@p@j@\\t@t@TV`@d@Hn@^XvAjAlBpClAnBv@vAx@nBDNX~@Pf@d@hCTdBVnE@dDGrCoAxHADa@dCk@dBg@tAg@pAu@vBq@|B]rAi@bBa@vBc@~BGj@CRQhBYhB]tDGfAEfFAjF?~D?fAJbEJhGJbGH|Fb@~@p@tA^jCNRf@|@x@|B?bCRfBfB~B~EtFJJLN@@B@DFpEnEn@bABF@@l@`AZjABH@BdArD^lDDb@XfE?`@E`E_@~Ca@fAYv@EJ{@~Bo@bBwA`Am@^iAHiBPcCQqEkACA??{A}@y@JQxASFC@E@HL@JSCKLGIKGICKAQRIPGFI?QESFMHMTKPA@INIJGJIDIBIBEBMFA@Sb@Sf@Uh@CFMTIJILEHGJGLCDGJILADAFAHCTCZC@KDO@U@QRABGRIVEV?BC^A^?`@BL?@Fb@L^L`@Th@Rh@BBHJRPHHJJHFDHJG@ADCLJBPBV@J?HHXHTDLDHFHHHJ@JFJNHRTFB@JBLD@@NHNFRJFLBBHLDNBLDPNBR\\RXHJHHVRDBHLHLFJFDDDNTJP@@@@DJDJDJHRBFHPDFLNLZFXBRFZD^A\\AZ@P?NHTFXJT@BDDVVJHBBNPJJ@BHPGVENCJ@P@LJJDH@?JHDB@FGLAJANARA@@T@PAJAXDDr@WD@RDB?RCPGTIh@Qd@O^K`@G\\GTEZO\\OC[?SIm@G_@G_@I_@?EDUBK@CTc@?AVe@FODWR[L]BO@QJ_@JWPSNOPOLIDPBN@JDXFPDHHJFDHFJJFD@BLRHJHHHJNLNNJJFJJNHPPb@Th@FTBL\\pA@HBJRx@Z|A~@fCDDFDDFRYP[RUVWb@y@b@y@Rg@Lc@Lc@FYFMDKFEJ@NBV@VQ@P@BDP@JFf@?XFr@B\\B^D`@BTBNBP?D@FF`@BLD\\Jl@DX@J@BJz@DXDP@D@HBPH`@Hf@DPBNF`@?@Lv@F`@F\\@FHn@Hf@BHJl@Jd@Ln@Ln@P`AVlAPhAXhAPt@Lf@?B@BRp@BDHL@@Xb@Z^NPNL@@VJD@PDJBf@A\\?V?H@B@HBf@Pr@VH@XHPHZN@@RJDB??@?TVRRPTNRJLNT^d@RTFHBDHHRXd@n@TX@@RXBDJNRVJLRRLR^f@d@l@DHZ`@|@fANNVVHFJLPRHH\\^FFh@^JFRLFD^PNF@@PJZRBBVVN\\P^FRDJVz@Rt@HXR~@Vx@HXDTBH`@lALf@T`@HKP?^Wv@_Ax@eA^m@b@o@b@i@f@i@f@q@BEd@i@NMHQH_@J{@DgA?gAFABAXGZKRGf@Mf@O^KPE\\IXILEd@ONC@A??BA@?@?`@KXGd@O??b@KZIr@Q^Kb@KPE\\Kp@Q`@JVDB@B?d@LTDTDVFB@HBl@P^DJ?TAVDLBBBVLR?R@V@VDj@JJ@PB`@VRFRBNDHLJNHJLHXNFBRJLFFBXJHDd@XNHXNRFVFj@RRFD@B@XHHBj@JNBH@R@T?D[ZBLMFEHAHCHANCN?R@`@?d@@\\FF@LBPDd@L@?D?L@L@P@J@@?N@??`@H^H`@JNBd@JX@HBD@LH\\Th@l@FFZd@HRHRBH@L?NARHBHBVJ`@PVLB@z@^\\Jr@RAHABI`@Kp@Gb@CNKR@J?P?FARCLER?DKtB?FA^CRAV@J@F@LDVBFDLJLLNHHFDDHHRJNJLFFN@RBN@L?LGFEFELKJOLAJ?F?FHHH?FLBNBL@PCJDJD?P@JFLDN@NCXT?TFLBALNHTHId@?B\\DJVHRFPHLFHLT@BDFAPCR?BEVAPGd@ADAVCTCPAX?PE^ANCX?LCZ?DEr@A`@En@@DX`@LNHFB@NLRLJHHFf@\\JJHLFNDPF\\@J@P@p@@j@?|@@fA@p@@NDf@E\\r@Cl@@A^Ab@?`@@|@?N@p@?@@VB`@Bf@?@@HD^@JBN@J?@@RBV@h@?@@^@\\?D@B@R?@Ff@Dr@?@?P?RAVE`@A@ERIX?@Kh@?@Kn@G`@G^Ih@?@EPCN?@CP?DAJ?@C`@AV?H?N?V@ZDb@???DD^BPDRDNHN?@DBRDVBP?JAH?T?VCXCX@V@RBPDJDLD@?FDH@??JBVDJ@D@B?LBD?D@\\DB@RDN@@?B@L@??V@??BAHAB?T?R@@?X@P?L?N@@?P???L?F?@?P?N@??\\@RBX?V@@?r@G??\\Ch@CPCPGNERM?B??@D@@F\\D`@@J?@@V?D?PCTAHGDCHANABCNGPARBN@LBJA@A@?PBH?\\Aj@?D?HCTAV@RDH@PBn@APALCx@?D?FCp@?d@?@AP?RAH?BAJATAD?@Cb@E\\Ef@ALA`@SlAAP@DG`@?PALAFEn@Gp@CVAXEd@G`A?FGb@?@GZ?@CVAFAX?^?X?\\C`@Gj@EXETENINA?SD]TC@ADCDMVA@A@KJOP[h@A@MHMNKJ?@]h@CFG^Or@Kh@ABKl@It@CVCZGx@Et@?F?@Dd@@R@P@x@@p@BZBd@@B@l@@J@\\B`@Bt@Br@Bb@?BFn@Df@FZF`A?JCZ?XBPLT?P@L@VBfAGXEPCJBz@Bt@Ej@ALI~@CjACh@?LFRLILFVSLKBCBC@ARMTGJKJAFAD?JALGTBLELCNEPEH@J@HBPHN@THDd@BNJvAQNONQTILORMR{@lAk@r@IJe@l@e@d@]f@a@h@]d@A@i@r@OPQTk@z@_@f@kFfI?NARCJQhAIr@AFCPCZCz@?@?b@?`@?@@b@Dj@DlADlA?@?@Dp@@H@P@tA?b@?F?D?P?J@Z?L?H?HANC`@QCQDC?WHG@o@Xo@Xm@AW^EHBTF|@DjAh@lBBHJ\\H|A@^EVA@@B?H?@Br@@T@FBRCX@H@JBPAR@ZDJ?`@@VB^Df@?p@Fh@BXBVABERFTHvA@FLpADN?FRlENrBHz@Jz@RpBPvAFn@Hn@J|@Lz@RvALv@Jr@Jz@Dp@~@Vh@Nd@~@FFRn@J\\HVRn@Pv@V~@DP@HAF?FAFNDHHJLPXRPFHNFRFDEDEJJLR@BLBJ?LELFPAV?NBPTTXXf@ZTDFBDLRRGJJHGDETUFQFCNGRCNGTCVKVKd@BDWH]@E?QBGFCDSHMDIFEHG@AH[NRDBX_@FYNQj@QHJSi@IK?OJYAYD_@DEFIBODQHc@BYLKBGCOFUD?BEDK@Q@MAMFMGOFODKDSFc@BIDS@CLUL]JINSJg@J@FOF[JGP]NMN]HINUDs@F[D[Fo@BMBSBYBSDU@EBOF[A[FMBCC]EM@UKgACEJYFWDSH_@@KRc@DOPUDE?AFODKJMDIJIXKLGJGNOVKTKRIRIDI?ARa@TM@AP`@PBBIJaB@MHCFA^K\\KTCVELAFBFBT?XAb@CXEp@MFCLEVKZID?ZYd@]Z[^[n@o@f@Kh@UjAUPWN?t@[NCNEVIVOXU\\WX[LOR]P_@Vi@\\s@`@_ADMTa@NWLUBCVe@T_@TWT[RWTYTU\\[FEBCHCFAFAP@TDJBf@@T`@Rb@J^N\\@B^x@HTR^R^DH@BVf@DDFb@NNJP??^r@b@t@RRXX`@XPJPPTTTTTTV\\VZ\\d@VZT\\RTNR\\ZNX\\`@LTXl@LZ^t@\\t@NHBNHTVf@Vb@LXTb@R\\Tf@LVHXHRFLFPDLJ^JXHVNd@H\\DPJ`@FVFHHFF@J?HAt@CX?^GTA^Ah@Eh@Gt@KNAVCV?`@Bb@C\\AVEHALAPELEFL@BZPLFRHRVRDNNtAz@LHORT|@J^?LCL@NJZNLNXXT^ZRV??JEFILQLWFWH[@HDNDf@D^FXDVBb@DTFXJd@?^Ax@?Z?XFl@Dn@B`@@f@?r@@z@@V@t@@bA@bAC~@GzAo@e@W[KOIOIPCFELADCHELCJE\\CVDt@?ZA@ARCVKf@ADMb@Ox@Mn@BHN`@Vh@Th@P`@@DTd@??@BTh@HHF@@?JD?N?D@^@JDZNf@@@LRVjA@DJZNZFZFTJFNHHADAD^Fh@LbAFdABT?N@t@DlA@F@JB^@X@J@P@LBb@@N@HHlAFjABl@B`@Dz@?LD\\BZDT@FF^DTDXF^@R?HDj@B`@@PFh@Fr@Dt@@BA@@HFx@BZ?F??Db@B\\@RBd@AL?fAA|@?DA^A\\?F?`@@r@?H?P?R?@?b@?L?b@?@?L@L?f@?JAJAbABJDXL`AAF?FAJJn@H^Dh@@RBV@\\Dn@C\\F\\@^@RDl@?@@JBf@F~@?H@f@@b@?\\?TCrA?nAA|AC~AAFCDEBMBGDA@WDI@SJI@SAOIKIQOSQMIKIOGGACAI?U@G?A?ECOACACAa@Q]Wa@WOI_Ac@SGCAOAGAg@E[E]A[A]AeBDi@JG@E?MAYME?GLEHQRQh@MLEEEAK@CBEHKPGFIFE?GDKBQJEDE?IB]AIEI?EEO@CCQQGIMMIMEGIQGAKEQKEAOEMCIBMAKEKAEAGBCCK?O?EGGG@IAA?EACA?C@EEE@ACI?GGCOOEMMMEIKIBK?SFI@MCMBIKE@ECIBCFG@G@E?GBELCJKZCb@?n@BhAD`@?N?VBJ@p@?J?P@FBTAPEH@N?RALEXBHETCVCF@L@FERFH?NKJEBBN?JBL?LG@AFCHFLBL@BGRGFADBFA@DLAVBRCL?LEH?PFPDDFFEH?BBX@N@J?HDJ@ZNAF?F@AHLRAb@@Z?F@HIVATEZHLLl@EXMTHf@P`AB\\Pf@F`@JLDPJ@BB?b@C`@@FBDBVCPBNAVF^DXHf@BXLd@FTJRBVFZIBK@@L?DAFCDH@DDBHBBFC@D?DAF@NJD@FLLMJAH@B@F?DG@ADD@?JJH?LAFIFKH@DAPAJBNBDFHBHLf@@PFBDZJH?HDR@J?FFAAJ@DJIAJDHGZBJDDIBI??@ANFZFLPDEJ@FCD@RELBFFNAHJFTHBJBNJEJCBPJPLh@?D@T?HBRBX@N@D?L?HAHFHFVJL?B?D@P?RGHIBCXDDJL?NBVP?LAH@J?@@JDJR@BFXBPANMh@GPEP?LFDN?LABL?HBHNCLPFBL@HPBf@DJFLFZ@\\Dh@ETPIHaADa@BABC\\S`@SPKREDADB?EVGVSVUHONO`@G@A`@Q@ALEPG@?j@WNAV?F?`@UXU\\ORIRIBAHC@ARCNEXONMJMHMVUNIHC@ABA??LEFAVQh@@jA@BhABZ@LC`@Dj@@`@@DBfA@T@v@Bj@?@Jd@Rl@DLNb@Nt@@FTz@BHJZHTRj@TJt@HF@B?^DL@PBJ@P@P?P@@?`@AFAVCZEd@?b@AB?v@Ql@U@?XGTETGd@GhAOj@EDAHAL?@PG|@GJCb@Cl@XBVLJ~@@n@BT?XGXMHUK[Ec@IOFGn@CJ?RPdACXDh@M\\QNGVE^Cd@@LIVGNCNHHJHPERAJB\\NBJ@XLZLPNBJQLBPHF@EFIJILDBLJI`BO~ABf@HZNDRGLOBg@DJL@FCHBSRWX_@VE\\?FHj@C\\Tn@Th@DDHDND^M@TDhAGv@ICYS[CG?a@Jq@g@OMOBMfAH\\QDe@PIBODMFM\\MZMx@ETCLKXONYHU?I?CBe@ZEBI`@AB@H@l@?BTRJJLLFTCZOTMRQl@GR@BD^n@VPERETDHTBJEZONIb@ADEPGZENSt@w@NSAUSC[AYs@OId@?N@FATDZGPOBWa@G@[B?DCLKj@C^EfA]lAA\\Hj@BR?BKXMJq@?OR}@dAOr@[rA?FAD?VAb@DFHF@TBp@NBDj@Kv@IXELGFARJr@Bz@Ap@?p@EHIBGDMAQ?WQIDC\\AFANMHUHOHSDL`@CRXb@BFBT?LGVKJMPQ\\IJING\\IXINMFQEQEQKKQMSMOKM?`@BZAZE\\GZEZQNG\\YKEAGDF`@@`@KXQV?|A?d@?bAYIUMMAE?G~@E~@aAq@IBELCRBHDHJHBHBPB`@?XJLJKRCL?HBNFGb@KTERBJHFRDPYBBBF@JCPAHKBC@MFILA@GLEVFBJ?NBDDNTDNCTEFONQVHJ\\Pg@nCWvAQ|@ABOz@GZ[dBETOz@I`@Ib@Mr@G\\ETe@Qk@Ui@Sq@W?t@@V@ZAT?JAJCJCFS@QBGBKFGDCFCFAJ?R@D@F?B@PALCBGDMBS@Y?Q?C?QAOAKEGIIMACEGGEIBEFCBIJMJKBMBOBCDC@@j@BRENEFG@YK_@Kq@G?VBPB\\FXHVJJ@XPN?TFPDNEh@CLE`@GLIHWLUPG^KXIf@EXDNALGDM\\Oh@BF@LCDELCFEN?V?TFRH^F\\E^GPKHI@EBEEKCKDIACBEPMNBNDN@P?PKREF?B[^WDQ?O]IGK[KSMNMHIPKFSLUPOJCRKPE\\GRBV?T?ZEVAT@RCTEFARKFEFMDIJEFGFPdAL~@F`@@J@BJt@Hv@Jn@Hr@NnAJ`AFj@BTFf@BN@F@BDRBFHvBD\\D\\F^Hj@Df@BLD\\@H?LBR?FBR@L@LDPDZDV@PBZ@TBV?HH\\Av@?F?`@?r@?L?l@@`@?t@@d@?`@?L?z@Bb@Af@?F?B@~@?r@?F@z@@bABfA?v@?dA@X?JDb@BP@J?R?J@FCJCHGNKRKPGLEFEFGJELENKBq@VYZYJQL[LQFC@]NGd@Q`@KvAKl@Kl@Kr@AHGXG`@ERARAFARKLOLD@LVHLHN@DBH@LBP@J@JHr@BJBFBFB@FBBB?NCXAL?HD\\?BBN@J?F@TATC^AT?P@L?J@DBJBTD`@BTBV@JBj@?@@b@BT?F?XDd@?F?j@Al@C|@?TAj@Aj@?T?RARAPGj@@H?@@D?FBN@V@V@R?Z?Z@X@V@p@?X?LANAXd@lB?PCRFAB?A`@GRCJAV?JEf@?`@AFALAFDT?P@NHVFTDZB\\?HBRFJKTLXHDN^L\\@B?@DLBHBNDVFX@T@N@h@@^?HELBLBH?JAJ?NDFBH?T@RBB@@DRA\\?TFZAV?p@E?WAE?@^?^Az@@Z?`@@V@TBNBb@D`@B^D^Dl@Bb@BVBR?B@D@R@VAb@?FAv@Bd@@LDv@BZ?DBTI?O?[@@BCV?f@Av@Ah@Ab@?X?^AXAd@?R@Z@^@X@XC\\Aj@Cd@Ct@A\\?`@H?L@HRHTJb@?\\?@EhABCBCDD@F@@B?DBFADD?EBABDBBBA?DB?D@DEDA@CD@@E@@@EB?@CB@BA@DBA@DBAB@@AB?BA@B@CDBBEBFBCDAF?@@B@@@B?@@@?D?@B@@B@BA@BB??J@LEB@NHBBJHBMb@LFBLF??H@DEJDBD?DHDPD?HE@BBDFJHE@DBFAHDV@FBABD?@DCFHF?AIRMBCBFDD@B@LBHDHADBD?F@DAJDHDL@BBLB?D@B@@?@@BCB@B?DCDBBB@?BC@L@N@B@DBDF??LBAD?BI@EDBDKHK@F@CB?FJBF@DHCF?F@FBJEHB@ID@FQHGDGLABC@AF@BGL@@?J?DDHLFBF@Lj@LPLVHAVFNA?LFEFFHBDHF@DJDPBP@HBBBB@HD?APCPDH@JDJANDR@RJR?TDPL`@DBALFB?FDNCFHNBJDCBBDDBBDB?D?DB@?HH@@JBB@DBLFBBFD?@BD?BHD?@BBCDBDBBDBIBF@HD@BF@J?HDD@F@@BH?FBNAF@JE@@H@FDA?HDD?B@F?H@DDDCNDHAJ@HAJDHBJFL@H@@DJFNFL@DDH@B@FFD@DDD@FDFBFDBDHBBFDHJHFDFH@DJPD@AD@JHBBJJJADDB?FFJ?N@ZGNCJ@@?`@B|@DJBf@Ln@Tp@@Z@H@T?Z@@lB?R?d@A|@@X@LGfAAn@ADC`A?f@Al@?b@@X@fA@fA?TB~@?hABtA@T@D?V@t@InBEr@GRCNEFE?G@Ab@AHCb@?h@AR@XBV@t@?j@Gp@?v@Gj@OpAITI\\Oh@GTYl@Sd@QZOTEJIBUNC@YJEDa@^ABSJQJ[VSJA@QJa@PUHIB_@Pg@T]NMFGDE^???BGZ?b@?B?X@R?PATAd@?RAl@Ah@Cz@?TCZAh@?N?T?`@CT?FCRCVEZCLA\\?BAT?TCTE`ACVEXE\\Kp@G\\Ut@Mj@]x@Uh@GNEJGTIXKXKVQ^Ub@GUKa@?UIa@?AG]Ec@Ge@EYKa@I[ISG]GWKe@Me@k@Ca@?I?CAE?E?WCOCUDUBSCC?S@UCE@IBK@KDKBYBUAYA]??N?F?f@An@g@B[Dy@FCi@w@Du@DC]IeACUEg@I}@Iw@IgAGy@o@Bu@H_@@WCc@Kc@AYEm@GQ?gA@eAD[@G@c@B_@BC?]@A?E?WPABK\\?BOb@AD??IZUv@K^ITCHILQXQTW\\ABMPSJm@TCB[JGB@\\@r@Bt@@^@V@Z@X@`@@r@AJ?LCZ?DMjBADAJEb@C^Ed@ALCNEf@?BEZ?@KZCHGPCDM^M^GL?BGPCVCNAHCTE`@AF?@Ip@Gj@?DCJ?FCP?JAH?T?J?B?V?r@?N?t@?f@?LAP?V?F?X?x@?H@`@@R?DBT?BB^Hv@Fn@?L@R?T?T?NARAp@ATAf@?ZA@?\\A^Cd@?H@^@Z?R@DFhABNDv@D~@Bb@@P?P@R?ZB`@@h@@T?@@V@l@c@?_@@S@]Bi@Bi@@_@@k@@_@@a@@W?e@@s@@G@G@IDQFMBG@M@_@Dy@Fw@FQ@I@{@FA?KD{@DI@i@@UBg@?_@AA?_@ISOMEOKSKCA_@IYE]EWGWCWEMCIE_Bs@OIKEKAAAIAWCQCUEW?C?m@GI?GA]?]CIAA?EAC?[EWCE?A?A?KASCC?SC[C[G_@EE?KAA?IXELCBAB??CHCLAJAHEHDLDF@H??AR?@ARIDCPAH?NDBBDBJ@D@HDR?@@R@FFDN?BR?H@J?D?HAJCLIDEDEHBRDB?NADC`@?BATBN?DFP?BFRBJDRDNAVAJ?HC`@?J?XBT@JBV?FErAA^ICA@MC?L?NFRFLBHDHDJ@P?L@B@DBF@JGNE?IAA?E?KDIBEVGLAHFXBP?NAH?@CF?FBF@D@JC?EJADADITCJA@ITKFF\\?@B^?R@\\@p@?NJn@Jn@DVA\\A\\AVC`@?D?FATKlDCl@AXCx@C|@CzAGTAFCLUf@AFO`@GJKVGRAB?@AFAFC?I@?T@DCNCXCT@T?P?JAPAj@?@Cd@??CV?JAJAXAB?VAB?FAb@?DAX?T?\\?L?T?@?R?BAVA@?REf@C`@C^E\\AHA`@CT?VAn@Ad@A^Af@ARCRA^A`@SL@z@@|@ABE^Cd@Ax@?P?^Cr@?BAh@CDAZ?L?X?^?V?R?XA^?b@Cr@?h@?H?R?n@Ah@Aj@?B?p@?|@Ah@?f@?XA`@ArAAv@?p@?x@?B?LAl@?@?fA?^AR?@?BADEj@?n@Ap@?F@`@BPFR]Z_@\\ONGFSPCXC\\LHEp@Gz@AVU`C@XCb@E`@At@Ad@@\\NXFJA@@DB^BLFh@BTPEHLFHB?@CB@L@@?AHAb@Jh@f@xCRzABRNj@DZFZBh@BX@FDf@Bb@DZJNNRVZR`@FPFRBLJR@BDFJ@LDTCVk@JIRQLGBAl@U@H@LBNDp@@\\BXKr@OdAQjAg@EANCh@AT@PDRDR@T@PBHVb@HJHLHNDP@DEl@Gp@?VNBPIP[Ze@FDNJR?B?NHPZDLDLHZBJJNJPJLRDNAJ@HF@@HNBVEVAHGLIRIJHNHLRV@?PEVAP?x@HH@D?L@Gj@Ir@KbAMx@APKr@MhAIv@s@jCQz@StA?XAn@@f@BbC@j@@b@?LDfCc@REBC?K@OAe@CIEYQe@]OQQMKCMAI@GDIL@@BL?N?N@HDZF`@BXBPF`@?BBNFJHLLJJFJDj@NXJLFHR?P@REf@GXSF[POJ_@\\MXFZIh@WEKAE?KJMJMNOBO@IEE?CAMFOPC[GUGIIEKAG?CFEJMLUPEDIQCCGGEBC@GRA@IPSj@IX';


