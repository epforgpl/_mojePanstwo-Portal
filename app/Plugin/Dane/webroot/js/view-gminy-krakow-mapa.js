/**
 * Created by tomaszdrazewski on 15/09/15.
 */
var map,
	markers = [],
	mapUpdateTimer;

$(document).ready(function () {
	var options = {
			zoom: 12,
			center: new google.maps.LatLng(50.0467656, 20.0048731),
			panControl: true,
			zoomControl: true,
			mapTypeControl: true,
			scaleControl: true,
			streetViewControl: false,
			overviewMapControl: false,
			scrollwheel: false,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
				position: google.maps.ControlPosition.RIGHT_TOP
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			backgroundColor: '#FFFFFF',
			minZoom: 11,
			maxZoom: 20
		},
		style = [
			{
				featureType: "administrative.country",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}, {
				featureType: "poi",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}, {
				featureType: "water",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}, {
				featureType: "road",
				elementType: "labels",
				stylers: [{visibility: "off"}]
			}
		], border = new google.maps.Polygon({
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
	map.mapTypes.set('style', new google.maps.StyledMapType(style, {name: 'My Style'}));
	map.setTilt(0);
	border.setMap(map);


	if ($(window).outerWidth() > 728) {
		var mapa = $('#map'),
			fundatorzy = $('#fundatorzy').outerHeight(true),
			header=$('.appHeader').outerHeight(true),
			submenu=$('.appMenu').outerHeight(true);
		var size = $(window).outerHeight() - fundatorzy-header-submenu;

		mapa.css('min-height', size);
	}
});
var krakow_spat='sxcpHsdzwBCxBa@jAd@x@zAbAfA~ClAjEmCdDqXcB{ZxEic@zKkRhBcKoJiHaYeN{KyTsFsR{NiGiZhC}PxAaD|P_LxJmOf@mSwNqc@uPgQyRrEiGhCsG`DmCj@v@vGPrDNpDNtGI`Ee@xEk@nEoA`DsAdDw@~B{@tC_AlAyArAiBxBmB`DsAP{@T_ATm@RyAp@s@VeAOeE[}Cx@sAtAUn@uAvFyAQgBHcC]iB]m@k@mBwA_DuD_EwFmDyDsBuBmBwB_A_AwA_B{@{@aA{@gAuAgE_BmCwC{Ay@mAaA{@IsBIyBcAgAWmBHoBo@iAs@gB]{ACeAV}AO}@[oBiAgAuAk@q@@bD?dBAjCg@bBY`Bc@nCS~A}@nC_@tBIbCV`C@tA^jA^rC|@bFXnFu@^yAt@q@bAs@zAcAj@eDjA{@vCa@|C_ArGy@jFc@nCYAsCGuF~~~~~~~~~~~~NaAG_Bn@gE~BeEnBoAp@kCfBgDpBgAKe@}@y@}AeAkBeAmBaAcBeAkBg@_AcA_BgAgA}@k@sBu@wCaA_CeA{Bq@wDqA}EiBqGFoByBw@cA{AcD_AkCi@cDEoDE_EUiDYwBe@sCOcE_@eEQqDmAiAaA_CWuB_@uCi@uBYmCm@kFuBa@_AgAi@aB}@_DkAoC_CcE{BeE{@o@_BiAoBqAiC{Ai@uB{@wAs@yDMeBCkABaALsCL{BDwBcAu@uDqDyAiIqAyB_@wBEuAeA{Bi@eAy@cAUiBm@oA@wCsAoCDwDDsCAoB_@kAk@iCk@}Bk@qAQ_B_@qCq@_EkBqGiA{Gx@}HpBiQAqGd@kGj@wCZsB\\oBf@uBmCyBsAiA}CkCwCeC}CkC}BqB_DoC}CmC}CqCcDvCsH`MyE|Ce]uVcQyg@sEeJ{AoAsAmAw@e@u@Qw@@w@C_A[gBu@cB}@iB}@aCw@_Bk@mAc@kBs@kBQmAQi@W_BeAkAaAiA{@uAoAgAoAkAcBiAqBaAqCeAiEm@aDEiAA}AAsCWmE_@yDYcBOgAMwB@mBVmDVoBgALk@?o@j@sAvBgAoEo@kCoAe@gBJ{CSOcI@iB@}FAqDAcGlAkDbC`CuAuLj@m@`@kAbAa@~@YV[~AoAv@q@r@_Ax@yAh@sAj@qAlA}Bj@uAl@o@dAgAbAcA`A}@z@u@`BcA`BoAbAqAdAw@j@m@l@_Ar@i@lBs@pDeAhCc@lA[hBo@~@q@~@YhA]rBm@tBq@vAo@zA{@nBw@vCgAjDwA~AY|Ae@hDcAdDiAnDqA~@YnBk@fBU~@SvA[l@Ml@I|@OjAMfAMVAr@Ez@Kj@Ih@IbAKn@uATuCVeBZ_CVyAVsBSwA}AEg@?}@XUeAWiAa@sAUcAa@{Am@]k@gB}BcHy@gCqAuEu@mCc@{AYeABaAmAwAm@mE|@w@nBU~@iCmBeEkD{A_Az@eEfCu@mCuAoC}@kAgAG_Cb@o@d@_BhCkBzDeB~DJtF`EeE|BeCzAkBn@[n@PUlDI~A|AbAVdAmAlCsAfA}BxA}B`@kB\\qA`As@j@aAZqA`Ak@_B}@gBoAi@y@C}CpAmC~@QUc@gBUkBWuBO_BhCgAv@iBcAiD_@aBMwCOqEW{Ci@kFk@iDkAuGeBkC]wCQ}BYiEYyEy@{@kCR_BK_Eq@aAqBKiB?}@PyARmC~~~~~~~~~~~~NoC]mFQ_CWaECmF|@]vAm@pA_@j@Mz@[n@Wp@WtAy@nA_AhAgAfAgAvAqAz@_A~@eAr@s@p@{@j@aAdAqBrAeCt@qAnB_D~BgDpAsAfByAG{HnFXlBaAhBgBE}CEqEa@qBgAaD_B}Ce@gAgByBI}@r@yAf@_Ct@aDh@kB^}Ch@qCz@gDf@gAfCmEjAoDz@yEd@mDn@iLd@yFr@wDp@kFA_Ef@yBfBgEyAeDNiEXiDj@{FfAwLy@qCi@oDEsEuAwC}AsD{@kE_AeIa@cFMeD[mMA}HAsD@aBDgEJ{MHmKj@u[PsKLsCBeEJaIfAgLvEiVvFmLU}Da@aFe@eG_BSc@OiA_@g@E[CQkIsKeKsCqLXqCkAkFiDjAmAkAcBqAk@{@{@oAwAs@{@QoCb@e@a@e@kBe@mDa@kFUmHv@sCxAo@rBaB|A_BzA}ApDoEsCcCpB}BhCkBvAkAs@_CKyCEaDu@eC}@iCeCXR_I{Be@gAm@_@Kq@q@}@kAg@{AM{BEkBh@eC~~~~~~~~~~~~NoA?uAa@cBgByCcBkBcBs@g@mEHiCFgBPkCbDuCJ{BDyCKuC[_Dc@oDc@wDCcEHiEFgF`A_AzBIp@yB~~~~~~~~~~~~NyF?qFImDOiDU}GXaBTsCPwBj@gCZAt@jANt@`@dA`ArAp@j@p@r@xAbBnBxBh@p@t@Fl@mBxA_Bx@y@j@_AIeBAq@Gu@Kg@g@cB_@aBeAqEsAkEi@kFOyDu@aAa@YyAQq@Cg@?Wy@Qu@]gEJeEToDy@y@_EQ_DIWqCIyAO_Ba@qCa@wBk@oC_@cBWwAi@oD}B{AcCCeDgAaF{CuBkB{Aq@{@m@`@sBp@gFb@iDfBoNnCaTx@wGrAaLNwFPoA_A}IEyDCkE?wI\\}IhBsDuAsCnAsG~@WvFOdDK`My@tH]lIMEyECmBBoAZiCNsBXuAb@_AP{Cl@cDZqA\\eD^oGRuDXyFVaC~~~~~~~~~~~~NwDEeDEqC?sDHwBDeFHiDf@uBB{EBiH?}DJ{EcDk@}Ew@aF_AiA[qBa@oDgAiDcBsCsB_D_CiCiCeBmEoBoDuEiJ_CiE}AeBaDmBs@]k@}@{AoEf@oBtAsDJWEeBk@i@oA{B_Ai@sAiC}@cBm@cAc@s@gBFa@yDJgKEcG~~~~~~~~~~~~NkGEeFvEcOJwUbC{BlDiBgDeKjCeK~CyJ~CsB`CkIcCiD@kHv@cL{EeFb@qJg@kIeEgEyAoG|AcDjCoLuCoAiAoIqBsNt@qEjJW|A}K`B_AxFaGzBeVbHvHfGnGbEnCx@vJTxE|A`DfC`Dv@hD~@xB|CfFp@|BbAlGfC`ArBbAtD\\nCdBfAtAtCzBtChBhC\\`Dr@nHdBbFh@vDb@vDd@hCQ`D[`El@xHGnEQfGw@`FaAxCk@zEw@lAvAl@lDr@hGfAvBd@xCVlGT`KpAfBrAkCRkF^qIbBwDlDwAlEd@dEsBb@uC~@u@fB_EhCqA~BqCdCcFjCuD`GAxAs@pAiFlB{FlEmGr@tWv@jA|@bDjCfDjAlBnFj@jGgK`IgY|FwChIeYRaH|@iF`DeDdCkBlCoBvCqB`DsBzHuFxHkFvHoIjGyHhFoHvEhCtKrOfHhG`LpFzJ`F~EhKrAzKFlSqClRaFbO}G`OeF~U_@lXdDd`@vHlg@jGh_@tF~b@dBlj@eB`^sEdZyDhT{B`VjB`WrDxJpFzGbD`EjJ|LpCpJg@h\\_DxKqEbP{AtKm@p[l@v_@lDrJvK|Ud@h@rH|IhC|LEnRmDnJ}LhBkJ_Ce@rBq@By@f@kA`@i@z@o@XeA`Cm@bA_@r@OdAcA`@[fBJrBfAzC|@z@f@FRxAf@`AbAv@n@Vz@r@p@rAdAfAh@r@d@v@b@dAl@`BHfC`@xA|@z@HhAP`ALb@GfAv@d@`AAfD_AhBiAc@aD^oAz@kBj@wBfAm@XrAn@j@n@v@|@dA~@bCrA`GfB~BdC}D|@wC`AIb@`@VrDP~A^bCZ~BVtAZlBh@pDp@tDdBrIt@vCdAxA~@n@zBDpBp@rAh@p@d@rA`BfAtAdB~BbAnAvBtCzBdClBfBtAr@lA|@fAxCpAdFnAtDlDiDtDcFnAoB\\oExCy@vBk@z@WdBc@rCs@fDc@zAZhBd@fBLzATbCn@lAp@jAt@`Bv@`C|@`AXlBT`Ao@fAGzBPnATz@FrBb@|AZvBdCLnAdBr@nClAc@jCKlAUdDC~A\\hAn@|@bAj@z@Qz@]n@b@t@ZLtAfA`@t@pAr@rA~~~~~~~~~~~~Nt@SjBOrBIxALlD~@t@rAhAX|AFrG`BtAApDJtCJfAHbBDhAPrBI`B[zAe@zCMz@GrAFfBTxAz@^rAErBHl@Rt@Lz@Lj@Hj@Bx@~~~~~~~~~~~~NjA@h@~~~~~~~~~~~~NpAFfBEzBYTARdBM|@S~@D~@~~~~~~~~~~~~NhBEnAFlBG~CCt@IlAa@bEKxAUzCUtCOvAKbD]pA{@f@m@x@cApAy@dCg@hDQtCLvDL~BPlE\\xDLhB~~~~~~~~~~~~NvCI|DSnEhAMt@]n@SnAQbAJz@xCmAxAeDlEeC~CwC`EcG`MWdD@lBPjEJfE@hAEpAeALkDzA|@vGNrDFzADhAFpBRzDH|A^jElAjPz@pH~@rHhD|CtA|EBr@hAjAv@Lv@f@tABbBtBx@Rz@w@jBg@t@iA`@w@l@YbBwAIsATyAd@cBRw@BkA\\}An@uAv@eBfA{Al@qDTeBRyAOmC^kBp@}A^u@pAs@xAw@|@Ql@yBrBc@nABbCa@zBoA~DiCrDmAvBmAdBsCjB{DtAyBrB_Cf@QpBn@pA`Dx@bB`ApBnBxCpBbBzBpCfB|BrBvDtAlCdBhDn@dBv@dCj@pB|ADxCQ~CYdCIv@BdB`AxBfDRfBnBpBn@y@^L\\jCPvDP`EF`GqA|Ci@HUfAA~Bo@bDr@lDj@rAt@z@F|Ax@lCv@rBl@nAZdFNzCJ~A\\rFRxC\\vBN~BTxCLfBLhCEfE@xB~~~~~~~~~~~~NjB@pARvDPjBRbDN|CL~B~~~~~~~~~~~~NrEKzGu@TkABkA_A{@Ic@GuBmAmBo@{CQkDP_A\\w@p@g@n@q@\\aACs@c@o@w@aA]u@Gm@GG]UEs@k@_AEu@Ie@Lc@v@FnEBpB~~~~~~~~~~~~NhAIzAIhAEx@Ep@@z@?f@GpANz@FbAf@f@JdBE`BTfEn@fCLrAFxAh@`DT~AOb@^PLh@Bn@AV?p@G|@^rA^fAFb@Jr@OZZbAB~@f@v@t@bAHrA@v@Xx@QlAd@|@r@DTtAS`Bf@^z@f@\\xB^m@xAy@v@SjBqAdAc@|AY`CoAp@QvAoA^Q`DUJ`EL|Df@lC|@fDtBrBjALbADbCMnCi@vDm@jAF@~Ch@lDmBFIzCe@hCY|Bv@Z~@tAhAPKf@@pGz@m@Kn@_@fCjAlBTbCoCs@w@`ByA~@q@rCmA\\u@pAr@|Ak@jC`AhAr@z@i@fB{B~@aAOSpA_AGs@~FKhBkD`FBpAd@`Ce@zBF|EiAI]fAo@nAXfB_AvA{@hAkAgAOhBaAxAObBk@tEw@lBsAA^pAx@V~~~~~~~~~~~~NxAv@BKr@e@f@b@b@ErAi@~GgA|Fw@jEiCGo@fB]l@q@\\At@Il@sAB}@_@a@Eu@b@QjAoABa@xAh@bBAzBgAvAWxB_@bBSbATfCi@Zk@TArAcAdAeAuAeA`A{@`BGtBMzAo@h@b@zDj@vEn@zFNv@f@~FRhBHjAVrBLlC~~~~~~~~~~~~NxC@nD@pCDzFDjFH~AW`Ag@|@cBtA_Bp@mAzEk@hDUpATbALz@VzAJr@FhAA~A@fATpBHrBFzBIxEKzBFh@DzBDjC\\|DC~@ItBBlAZpBTtAd@pAV`B~~~~~~~~~~~~NnBB~@N~@LdBc@fA@xDN`CXhDFjABtC@pBm@dAE~D?pCEbDPvB^lBJnAVHN~~~~~~~~~~~~NT?NKL@N@R@XCLFLHJZTf@H`AL^ZTR\\Pb@d@QPZJf@Ln@PPRCPPR^NCXMZRl@D^i@^Oj@Tx@zAx@Jf@b@Pt@Fv@LnAd@bBFp@Z`@LTR`@TZTJVJLh@J`@~~~~~~~~~~~~Np@LXDl@Ht@Vp@Vp@T`@V^j@d@j@Zd@RnAAxBPnDh@r@jDIzEE`EF~FHpE[|FWv@~~~~~~~~~~~~NrCMvF}@dEuApCcAf@cBrA_Br@}BdAUdA~~~~~~~~~~~~NfBGdDIfDGhBObBOzCu@|DoAjD{@~Bs@kA[cCo@gCqBoAw@IwAF}@HsBBi@rBgEOc@_FaCiDyCUgF@mBHm@t@]hAw@fCmA`BiBt@J`EDvCS`DUdCOxAi@|Aa@xAQxAUrBGbA?jB?tC~~~~~~~~~~~~NfCHtAR~CE`CEdC@|BXvEFvBFzBsBt@}DJ}CFy@VoDXoCTqCDsAk@oBc@_BYiCgAaBOcBIq@G}@KsAKoAQUp@Qt@Jr@Qv@Nj@Hz@\\n@Op@At@CrARx@FpABhBMnCGn@X~@Hj@_@Le@z@HfABf@Wl@UhAFdCZbDGfBYdIUdEy@tBMh@Ml@EbBGfBGjAClAApBAr@SzCKhCIrCShEMtCKfCAzBCdDA`DChEEnFAjDC`CGtCQlBmA`BElD_@vGVlBTpBh@LLp@zA~IVbCj@jC~@pBl@f@zAsAv@NMdFaAtCN`Bx@vAElCxA_AhAp@d@rAfAd@TjAUdAhA^hBJo@nFiB|JMjIYxFkA?kBsAu@LFx@ZjCb@x@lBp@AzBmB|Ak@~@gAl@s@Pg@cAu@r@a@Sk@tASrA';

