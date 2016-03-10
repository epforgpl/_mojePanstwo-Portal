/*global pl_number_format,$,Class,Geohash,document,window,google,history,location*/

var polandShape = "w`alIgp|dBnD{pHsD}oAyn@syDoa@whEyOwaAmK`A|HgAaMorA{GaW{PPxRwOqKy}Dyu@odE}oAcbF_{CemHciEivH_MehAwm@mpCutBw~K}gDm`Nam@ajDqcAcuMmV{w@cKikAwUkdGgIs{Ho]g_HwZivC{NkqD_Naj@fFaJsGc_Cc^wtFaw@aqIsfBaoNct@ubLyqAyvLmZ{fEu]meIgR{{RvIkgH}DmfNfBwnEqRasKpIuqF|b@ijAjw@ufAjc@grAxqAisF~OivArDkKqCtIbR`P`h@gaBzlE}gQbvCwmLvrBsjJdeBigGxbBatEtzCqpHxxD{iG`VsQ`~AwKjg@v]~g@x|@gB`b@_f@h\\tArV}_@mJoOnRyFjQtIpLaWbc@}Lns@ip@~FyfBbtAkgF~qGkw@thAsbAfdCzKlw@mBv]me@h\\gEn}Aex@bgAwlAjpC_f@|iCywBlqImHrtAwS`UkPzLyi@jeDw\\ztAc_@ls@aEbu@gm@rzA{LbjAqf@p~AvJfPtIaFlBlMxSyHvYnYlVqMrQhJny@zdAtsA~x@xmBvQrL{RvY{aAjDafAjw@e{A`y@ctAny@w~Cxs@nj@|~BmDz`@fRrWiHl_@m{@~m@nZvTy\\fDpVaErOlQ}ElKjL~OeRxL}lAaQc|C_\\gp@prAja@jaAiEjjCypBlk@mgArhAen@zsA}Trp@ch@f{A}UvwBrFwEpd@~IfJq@nRzO`BdfBuoA|iAqd@r|@jj@zgAfCne@qFrl@_^rlAalAhp@ocA`oA_vClr@gzCvEwy@aEcj@gLy_@m`@bPpUaNdh@gzBpoA{eAht@}wAaOuRfQm^yZek@rKiR|i@dl@n_@k`BfZyjGsAy]aWbLzj@wm@zz@chFfj@{gElVqzDrF{~CcDgoAu[{iAah@eY|K~PwFfDid@umArb@`TsByWwCuXuIaCjf@{aAxMv@~LkUp\\q`C?ulMkWs|Nyn@umSq}@q}NykA}|LctBamNevAeaH_}A}dGgkAoxD}wBstFh^i{@ncAex^xlBmge@dOu`KfU{}Fl|@kuT|g@gaQrEwrB``@otDtQkgGx]kzEr_@_bLdLg{@w@}`CzPckHda@{lE~e@swAm]oiBu@qb@aCasF~P}xCI}pCzx@_dNgCwzD`MarFpKgpFiCs}CnNqi@jEinHl^gcE~LowGwDui@n\\_mIz_@oaCaB{jEpQysCdg@qoIqWgdBsFskAbYibCsIozIpR{vAtIy`CgCexBpC{Sbm@mr@uFqkCwWonDaHylEj@muCtMoAdAce@`B}bA}SaTc@aWuJmfJxBedGcQweKaLuhJfBemIgNahKlAkxCxB_eE}Tc|FtBq~HcJs_F|Ds`GgIaiFrDeU{FyKe`@csGnScUj@aPcHui@fF}cCcCikFnCqaCoIkCsMc|@tFkHkAi{BeNitIsMifBtLgnAcNylA}CeuGx@cdFg\\kmG`Ak{CmLc}B|Ji{CcJauBi\\_}BgRgwTyn@kxB}|EozCuCyoAyRaa@dKooA}Bu~Bbx@bB}AmaAhYocFr_@kiDxG{gCl^yD|I_~CraCzdBre@u_Bxg@onF~Vc`AlZo^jm@nkAlf@n[heAnY`Rsn@lyAchGgC_n@i^}l@whAooE|Hos@t\\ocAvmA~`@xKu~ApXoi@~LoaD~_@iRb_@gd@jf@}kAtcAc~@|UclAmTi}ErUmj@pHep@vVs~Fvd@ccA`oAobAlQyj@gBom@lHsn@rXka@p_@tFhPcu@b{@kVn^wc@pc@}Nr_@ynA~sAg`@lKwvEpo@}LdZkxAh`@xLz[ax@n@gTlmBg`@rQaYh`B~OzWaWPwa@~rA{]r{@_fAndAMpoAy~@rv@zOrz@}Gh{@hXhYwP~MxFrNfu@`j@r\\lVaJle@pYpXxq@rAyNzE~AgMn`@lMu@}Dp[jJvOxLaDhVxk@aBnMjJjFp`@kXlSnNu@aPfYt@fSyPsBqIzTdSvK}TbOlAbIgR_BmS`JcPzLfQ~FqHsCkWrJ^lEmi@tGpJlN{k@zEpH`EeYfHjExD{KnGvIj|FnRldHy{An[iCc@jOdKvAx@aYzHOrToi@}E{_@bIcKn@u_@ha@{ZlJ|EnGf_@jPtBrYal@be@|ZvUge@tCp\\jUnPj}D|I~pD_ZvtCwmEt_B_UrlC`A~{@eT~lQi`FteJ_gDhmCgq@xu@cn@fkNyeGn|CagB|_FaeCxqGydCpsIw{Dn{DszBfkAucF`cAce@pTVjFjMdFoShH`AtSt\\ti@ei@jGfLp^qDlC}NpDzGnMqe@kDiGjPsLdIe`@zAtIjAaRjQuChO}o@hJpDiAuNd_@eZdAom@|Xia@d]aJnDc\\]rJ~IuCbEdPiBcLfHkN|a@|Dw@mZlLjF|@zNhL}GlR`f@nj@}d@hP`WvMu@{@jTjGlHsGhGrQ|ClIhQmDvF~PtBiCrMpHvFxSyB~DfUxGmXj@bZhp@pWjCnPlLwCeA|LdN_BPyR~XxQaAuKtQmCtVbh@xQwEtCrMlIgJfG~J~DkKxC~ObHoByAhRp\\lVfLgD~CfP|^aM{AeZhSqD~CtLgAiLdJmMbD|Oz@{Mji@kErGkNrNyGqEuJzHc`@}CsLtNk`@tLqKfo@`[lBuMvGpEy@kR`KcRdIvDh@yf@~MfFxLkf@rNfApS|a@dZkGv[_w@zBu[daFyp@vc@xWnf@yIjlBw}Ah{BfyDtsEl@xA_Upa@sd@~hLhFflBo|A~pJbCv_Gt@|fC|oFtfAbn@?bqAngIngRx[x^x@bY|e@haA|L~l@qCvPbNnc@Rlb@ba@~]gNbF?|Okb@rfAxk@hcNb_@bzBhr@tsEruA~gHx`BnvFt}AbsEvw@tu@t_A~hCrrBxkD`iGp`I`gGjjGlnAzUn~@z_AvcA|gCzb@tc@|eJf`JtaHvgFQeSd_@yyBbNcS|o@l\\jaA{c@lmB|fAdpAuz@tG}~A`^sjBpEysAvYsmBMuc@ee@aeCqAkaA`XkJlNtLjG~c@dKH`Vs`B}OygAf[_fAmVuj@sC{o@pHaMpTlRhGuG_Uiy@`Gij@hu@eDxLyQX{}@mL}^}OqJgBe]rGqHrU`QdFia@nJ_Ole@r[vg@uErOqOqA}\\gUgZcEc^bx@wo@xEk]qb@ckA{^ma@lB_g@qKcg@jEmWzd@lAnSaa@SgXmj@gyAxD_~@tOsq@pYcSpIbx@cPxDwBdZb^yQtJhb@`UzWb]kU|^dO~RqFx[}mAgTac@rC_Zfh@{Zlc@tEcGuZxa@{NrHob@wFue@fScXtGo^hs@kFfYs^jW`C~K_NyEge@ok@t@_IqQxU{w@uY_kA~Nul@cBsy@~Vkm@h_@_^w@sm@`J{QzL`AnExi@tLfMra@gWhn@}gAnQixAvt@}O|Mg_@uAuSbP{Mjm@tz@jMgSRif@pUiGsIz`AzLpKdVueAtdAeWjVs^do@pKhq@wMba@zb@vXk|@rz@kk@dRo\\jGo]zN\\ve@e`@jb@~Szo@|_CxY}@xm@w]`KhE~ExnBbz@j|@xF|bAdS~VhL_LyO}v@nBqN~h@^h]ma@vb@nErErlAdy@pK_Sx_Adg@vo@vo@{r@xm@pKnVyrAhd@qf@dKdFr]zrAxKxF`j@ms@h[~@wCv`@gXpj@Ezb@bKf_@v`BkSr[wk@vZv_@lf@j@tNj[rCfe@~LbFhFyw@fLxBtMjh@fW}CjBm[qJk}@xDgXv[wQv_@hQ|Jkj@rRiH|`Am}@~ZgH|`@~j@fIiP`KfBzDdImGz[rGtJdZyO~h@jCv@jHcQx@cA~K`Pm@hLlXnCrm@hN{GtKdJwBfdA|Evi@hnAl|@mDnb@vSni@sA~w@yXph@vWnNtQvg@re@|WxQ`a@`Mz|@`e@sIlo@d_@vFkm@dZ~AnFsRmGwe@uUqBhAeQlq@gGbQk\\~d@nb@pBqj@~McGpQdk@tPy~@|MyIbPp]v[zC|i@xc@fTkk@th@dVty@kd@pMnVcCtc@fHtU|WlLfGzTh_@iZdL|Tt`@dNwFyZjZug@tXrEpR~r@rQgZr^`Db]kUr^dKxUfYnDuPjf@oDhRhVdYiu@`e@}H~UeWdZlFfIoQtCqo@|KqR~TcD~`@rWnS}^|_@lD|Jai@lOkQjk@pnAvc@rOv{@mObLwb@Taf@vSqr@o]cWgHk^bf@mr@^i_Ave@oIlu@g`A|U`n@rk@lDjNqr@`Q~^rGiBtKgk@nQ}QxEqc@j\\kLkAssAwVsT{CmYbNyUfQ_DrL{c@nr@eIrGsU~OcEe@px@vVtGlMt`@pPzJbQxb@oAr_@dJxDnWs[lPjLtFuMfW|E`JubAqGoj@lYar@iX_l@jCePzk@x[jUa[~C`q@h[eBlKif@`m@eYfAk`@iLki@dEaKhLnIfS|r@xMwLlB{k@fVnc@~JoClBqXtJaIrBjc@rYdd@uEjTxFv^jEfCrKg`@jIvAwIbf@hH~TpUmR~Lgx@lFbZ~SzA_GhX|EpI`NyNlZ~RpEqL{LoGN_Qpb@jIxVeWnDzRqFr_@zNrUmGro@zOfI`YmXvBhNiMx\\b[mFiEng@rg@lJxFoTtErXlTxBnKeMxFde@nKyp@jNpHcClu@j`@hL|^pw@bM~@Qq]lFgGvOb]pWfJld@{r@|PzA}@tVjXkGxk@cfA~F~`@`XuSfInYvNoT|OfEeIm\\xJoYmMqCcQu]Bac@pIjAhCkMqNsk@|KxA_HmTfHcDwCyT|OzChKoUe@cZkL_QiQvA`t@aOtIwSy@uTh\\u_@rMvVmDk^dMlElXsYsLcPvIsCx@iSpFfPnFqJvPrLmC_NdU}OBwXhDhSlE_PrHlQzj@oNjZfHzFwNjBuSfRt@kD~U~NuD~FcZB~[rLXj]elAxX}@`@kM~PkHlUl@vGzi@do@}UuAmPaPJjTgVsG_BrKqVoHuf@lH}F|FfJtJqWf]aB}OmObRhA^mW|MyJqA}l@|Gsj@|MdNpDqQ|WrEbL}OtJujAxNs[b@ih@ld@mc@lV`Lj[eLhV}kArBd^`\\wOuFoPrQwHoL{BbDuWmMoNfYwNi]g]~IqGrJzMhCsw@x\\zEmOcaAxP}OhTfD~F}i@dP~VnNgd@~QzThI_Np`AxArMdr@wUlGpSh^_QtEpZbC~MrWvIaUdXvEHs_@bWhKdHsj@rMl`@tKsJfBoVjCz]|Wq[tSj`@jRy[iNoP`DmPtNBzNcDuIcLzB}IpX|ErrAi`@mAwUyQn@uIob@|S}Gq@eUr[wMaMoWpOcKPy^uZ}M~Vy`@hNvDnLyMbc@pV~DwXnyAqRdKnMl@}e@b]fj@`LoQdCsa@xM^yJed@xAiYtT|q@ve@tm@vGe`@xHnQz`@ow@bFxUdN|@gDci@bO}a@hJpEuHrI|Bh[{ErNvMv@q@fUvRk@_Pfh@rLpD~CmVpMlTzHkp@yBof@|O_o@jt@_bAmAyPrMcVfuAylA|nAyDdi@}QrNnOne@wIpHe\\zSgIcOiU`M}I`Uay@ryAuh@nQ{u@ra@u]fV_qAphAevA~T}w@zSkUpb@oD`FsVeJkh@`HifAtGgh@~NaPkKyUrkAwpAhF_pArc@aYkKoe@jTsQl@cl@`HkQqOuPn@kj@nbAhNpx@deA~I~n@tLtAhA`f@vS~O~RjwAzLfCzAzzAuFvZ`MQuEtXrGhNaLx|@nLtEiGzOlEb_@qJtR~Af^tLhTeRtYqIel@sF`nApUfNaQdScG_K{GlJpArLnQq@wN`NyDtZbQjDcAx|@iLjNlKxcApJhh@x\\dh@jQbJhRgNkGxQlUjCaPzNdDvG|VfBpJ|OlTmKuLbc@|RkKUtSdLtWdNca@dnA|`@zZpd@hT_R|Ge]rWiQpZr]rSkPcCqYhVvHsKiShNb@rFch@bWfIvFiKf@yR{RbFpKagBcQquArc@wlAjk@sGhElWqSjAuEv_@lDrHfGgKfSzU`Aw`@~Lnh@hEcLwEuWdOIzEag@dGtPoI`QfW`OtDmMyLcMvRaSM`Q~r@rXeByZ|ZzCpSpWoDaWjo@vRvF_d@gQdD_A}Kvk@opBtOqLiWmh@bGqPkP_o@lMoQeSeK`HcG}Au[|Sf@jJpBrJyWfIdVpFyUlPvJ|Cbf@hMcSzMmFxFfIlMsNvjAxk@vOmYlDpQmJhQ|ZxAd@aKhNdPzA}c@uGkMt^}OyLeApMmNyMgBvQiOuII?{RzPpBvPc^rExI~g@}AcMkb@~s@v_@`G}YrEzPfIkK|Mza@tX|TRsn@hIxNbFmL~h@cEoLW`L{^yLs[lqBnj@ft@qe@ddA{F~eC|r@nbBaEfsF`aBdyBna@tlHrgEf_AvTbz@jrDdpCvr@_JzaJfb@zaJzTzvN|UlxCf|@`nFpSrsAnnAjtC|w@ng@hoAla@dg@Qj~Ar]pdAvgHdaBxo@ta@txBznE|}DztAthE~gCdhGxlAdaFlqEf}FfzC`rHltAr}BxqEb_Ht]n_B~XjIbWzoAmH|VbxAvCjm@~zAlxAx{Ab~@d`Atj@zpCfeBrQbwH`nJb}@vgAxzAdlDbzAlm@|mAtvA~aCpoD|gDrfEzsFhkF|TxyC~jDtvAbg@y_@tGvm@r}@bfCdsD|xElnAhFnk@xgA`XbhAtZ|]~aBjeBf_A|Yd`Bt`D~EfeBjp@rt@nw@|{@dwBlWjaDtrEbsJnsKxcA~g@dgAvTp_A~fAdv@pjC`fC}_AzbA{vB~MgcDzh@oV||HqlAnrFqyB`sDahAx|@qOvlBpOng@dEjwBuo@~mBzi@x}E~V~aBzBpd@nqBta@|[`y@fJn`@u_@Cyw@pQ{h@aBoe@zSua@`V~j@N~g@f[eAhUp^b^kHrNtq@llAzg@jOto@|h@dCdVwi@pYiCzGgQgT_h@ie@~BmD}c@_ZgScO|A_Heo@zDuN_Ja[~Rq^{G{SfKqBjXvh@lVzBtYvi@ju@|VdMiEeAa`@fKiDI{VbSwMaFmTjHo^wSmuAzSdEe^_hA[kZlTsSb[nTrS}U~q@aBnMwh@rKaHjHii@zUdCcIg`@tB}U|IC`QnYdJ{PaQ_W|TuFxT}w@rHeIl^zHfI_MsGk^dKTbAue@q[mt@vU_ReFce@rp@r]zX}l@gBgWxHwDiAuOvOcc@wJ{VtGsEwH}\\`MlCwD}XnPgUpv@pj@`Jf^`GcByH{KdR}AbXn`BtNdHhQc^lLv^|QtJfZoWpK|LtOcGkE}RzUuDqBaQbZcFbYx`@nj@rWbFuf@hMiEwSeXdImS`^zi@lP\\hw@sw@tUobAzXvZjd@yKjDxv@~Wr{A~Ap`C{NnRqg@_BszA|aAvSzy@}MrdAkz@~UoKpy@i|@|uAek@p`CzGhV`]nIdZ~^\\lQkNtSYh\\wU|t@xClp@uQ|RqHbg@fRftBh}@zmArCh\\}Vz`Ac]xKfBfy@eV~r@mj@|a@}Uvp@oxAzi@cQfSkI~LmDbm@mQv^iAbr@cw@r_@}VjkB~t@hzAnGrq@g\\rwAyOne@nHtd@jE`iCrGpf@t]j_@ChPyQddAiLbFqMxo@il@t|@wRddA|JfgCbTlc@oU|yA_}AxjB{D`]ky@|Hc[fhAeYrBsy@tr@cHtT`NtWgKvkDvMn^jt@lw@B~PyGbSGrs@i[|u@mBp_BocA~nEfF~u@{NtUvJt_Aey@kBoe@_y@{Ku@saAt_@aV`u@rBn\\uIre@|PvEpBxUtMdGj`@riARj]}WtM}\\`}@wGny@aVxg@sAre@yX`bAqo@kCx@luAaKna@|E`j@}XfnAcCjeAwf@jaD|Bnb@_QfKmJhy@se@vaBcR`\\{h@m[oz@xGkS_b@e_@dDwj@mVma@hgAeO{Q_rAiCmn@naAeTjnAg|@f}@c^vx@gYjOsJnb@_h@~[_g@P{h@dR{gAd~@oTaDqWt^iEdt@lMrRwDj[`Nrr@c@v[mo@`vAvDl~@tSvXwXfTk[jt@wUrNcLmIy[|Uc\\biAdAl\\p\\nhAwz@ddAmd@oGuk@lt@|A`|Ahg@|s@rPjv@cCna@dVvd@|ZnJzF|Sj^nWvk@uQlMnMfPkCoAf_A}Rl`@sUdIc[tb@wo@`SoRgLm`@`Jkb@hpAaXncAkc@v\\hDno@gnAbTkK|QcGd`@fCb^a_@tbAdo@hpByTji@uNd`B}o@dNoa@bk@cB|^agBnrApN`dBdz@xoAaI`a@rSfs@qIbo@m@r_@qb@pdArRdm@h^f[iKfgChTve@j[dMzIhRba@c]hLpg@cKxc@s|@p_BhBxi@brAh|@tLl`@jAxh@iRhbAfXdfAEfbA_[f~@ud@`t@}Vzv@wa@hMkI|a@eCz_@hJ|JaKtx@lKjz@mg@rYaR|a@aPjcA}Zt`@{Kjz@~Tn_CeHb\\rGd\\{oAjxDhFha@bOh\\v~@|G~B|l@~jAznBwS~g@~DnG~TbC|m@|t@nt@wVhw@n|Aba@rXmLvf@vUt{@oJxt@dCxTsQsGgWjKyXhy@k_@t`@sOfz@_Ta@gOtRc{@joDjSx^ry@p_@}NheAwQ`e@|ZfzAJfx@~Zrv@eG~OnBjf@lJjd@hNlHpnAkk@`Kyc@f@{j@|LcJbZpElh@m_Bz^qd@lCa]th@{|@|eAn}@}Blh@`Jht@v[rU{e@~w@bVnhAmXni@jEz^`g@vu@jK~k@vQnHfh@bv@eCz]fm@fZjRoLxLjEtIbXp@`m@xZtn@p_@nD~n@kc@~PYxd@ln@kSzhBbFff@vN`HtXpiAtBvg@jSpd@jMhrA{Th@c]xg@kKnd@q_@zEwZtj@eQkD{BwTaTnN{Nrp@dItm@|[na@iCpfAuPcj@o`AePqQf`@yfAlhAgDza@|El`@pa@~ZpKfh@vb@hd@eGjQxD`t@_rA|vAKpPv^jaAiL|L{\\k^gc@kEySbZkHuPjCeXtf@mL_KeVoW`EuY|fA`Ob}A_MvK}SmCcc@mh@sMlQcBhj@`XjzAyP~_@iKvDsr@iW{]|lAsMrHqOcD_Zqy@}KiA{JnSl@fa@uJbk@oz@oR_Rlb@pAne@xErb@w\\z]~Fv[kLtxBlBpe@htAfgDfPL~PdxB_AdVySfB{RhVmQntAwf@zOmE|j@t`@zUlaAoMhBzo@|i@b]he@vC|_@jq@kNv_@`In_@po@pe@aTdlArGha@qm@zdAeLx{Ai]bhA{Dr}@{TrVs^{AgKhSmNrqAiKrHwJjp@e_@tu@qBrl@~GnTaJd~AjV_]pBp]ePxn@aQpJ`@vY`LpOpk@rCd@ab@hJsOj[dQzX_@vIvPih@dXaTvw@pKpWhe@aAtN`NrOzg@fLv~AwB|p@y[fKsn@wAy[t_@~Al[|f@jL`P~h@s@v^cQtb@|Cvk@oJzi@fE~MuHl}@|FfQzt@tYpZhA}O_uAtvAt~@he@c[x`@}BxvA~N|r@fz@uAzb@sn@r`Bb@nzBnb@nZaSvzAyP|CtKf]cFnc@xNbJpKtv@ma@|_AfTlm@jUnF`R~y@{Axq@j[x^da@vDxZr^LxsAfPuQdJfe@zw@es@leA`pB_XoF}r@`k@wS?}CvMvI~Wp]fAbA~S~_@xQvEp[hMyItn@dd@~NiLti@lYh~@yBls@df@x\\xr@v\\dO~`@vv@~QjIzt@e@dj@nRpv@cZvQlBlOba@~lAbw@~q@C`StPtj@iHlGeTfRnNb_@oGvEbfAmLjm@uf@dx@sSbpAc\\vg@gMtBuO~o@uHhhAygAzvAaf@uP{i@byBsa@dr@pJ~_AaOnhCaKvb@|CjRsPxq@hGni@}Ble@lVdp@|Exq@lfAgKnRnTbRmBxXfvAh^xZe@rPvc@pbAxOjD{AhqBlFlg@hN~UoS`EoDfe@w]xZr@ni@|JrPie@|kApl@`mAwDjbAmb@lb@mOv_Bqs@h\\kh@it@qq@_Myc@bNX{O_O_W{f@a_@{Feh@wt@ea@wf@tIeJeTo[{@qO}{@eWwXkM{eBki@nR_iA||@}Bl~A}PbJga@uB{qBygA}bArc@qy@~KoHjMwQwBoZuToF{Uuc@hEek@}Lc[nJeq@~x@apBxGoZxL}z@kI{HbxAqCtu@r^ddCxRx]lpAbhAd`@~iAk[bFyEbOjF`ZqKcEyKbPjE`F}LpAbExPqG}EVdPkStKpIpGeHdHTfVqHrAhEzOiFuHOnQmK~HdDdGeGnA`EjIqGrHlJ~KiLxFfFtMmItG~@|Q{HrA~Ab[eLlZrFrHoKzDxAzm@mKvLbJ`f@_NsAhDjUiHpInO~C_JzPbJdUo`Bul@wdAiw@k_@nbAmn@@mGsVw^gGwQ`Jtp@~`BbPlvAsZt`@gMQo^ru@jBft@tOjm@ic@nDa}@ltA{SkLwd@lTsIpUyb@vUzEbEiRlVuu@sCyv@hPmaAhu@g^xGcRbg@cYaB}_@b_@y}C|Q_iA_KzCxl@eJ~\\km@vj@Y`pAgPf\\aVlwAws@h}@qj@ef@q_Axl@~PtlAgQdg@nBdMjo@hYhWgRlRhRhRbfAcArp@rUrnAre@pR`_@aDxh@tn@YjWrN|e@_Afc@~[nnA|z@aL|Xzi@du@kKbe@dNzPtVd@b_BpMbvAjJrU`CjaAmRX}MjRwAr_@jTvaAtAhi@kLbfAjTni@_Bb`AdFpUrWcA|gBnlDji@{CrKuQvd@nHfV`o@z^gV|OxYlaAli@dY~AvMsk@`ScFzy@lQjTvb@fMtBaSp}@zU``A~rAhoAhPuBbd@gk@`^~Mxl@qe@hXv{@oX`iAh}@ziCX~OaZbb@kK`n@vJ|]lQfHjN`bAkEtpAee@vYsFjPh@dh@i_@pLqK`tB|a@|N{Kjc@mCh`At\\zKnb@dn@rP}IdHnGjZfs@`Ljy@kNbkAhIv\\}Pfs@oChjAtRd|@s]hg@cKzLo]iK{MdUaXjDet@ciBmx@uSeN``@ek@fd@_MgFiOdSef@nJaRxpAyqA{`@a[bIiZab@cd@z{@mJ{Oet@gReVkk@ab@bBsWv[nAbS}P~MoVlp@Gpa@s\\dOcOhaBna@rqEeMb`AdDdeAgUpu@jNnrAe@rNeFiC_Anu@u^bb@k[mm@sc@vBaHcR~EkO{T_o@cnAgJiVh}@cYvA}MjSLtf@iLjK}e@{@oYbZgVwIwj@dSyN{Uau@gVhAd|@y_@p[i`@hIyv@kFsX`a@gb@aHom@dR}OlYea@yAufAbk@ef@kQwq@lOah@oTmh@la@gAr~@wa@xeArA~^fL|dA{MhOjo@dpAdAt~@{YvP}Sds@jHpg@cD|e@{XqDiX~SoZw@fCdb@uYaMeO|VyLyJcLhbBvPjnA_LlQ~Md|@{e@hGiFxr@~Rrd@aTt@aGjaAwOja@qL[cHbYiStOkBtYkVwUcVjOmjB{Q_T|T_Nnz@qMvP}e@uEmy@|WmXtb@ie@tLqUn`@oc@_Lgm@jg@_[v@qUlp@i]tMgh@gAy_AjpAeh@x@cgAw}Byg@zc@qB{_@yR_QuEcjA_[qJk\\fh@gGvu@dDh~@cOxBoXv}@wNmJk\\zb@qJm@{`@kn@kVjOwuAox@}Lvf@mOoKcFhLwIgOes@lSjVpqAwp@n{A^la@fSwUvO`Ofo@rB`Q_l@|g@rt@zBlTzMhCQb[kGvDhHdCyH|IbI|PuPxZuCdtAxFPmC`K_E_Fr@dTmI|GxJbJuS|NhQx[mJpAiF|`@oZ~Kc`@zbB}e@lVkCjnB_`@zo@Zv\\o}@fLuAfy@pFjU|SfaDaIz}A_ItPnBr`@gl@ziAmKbtBuTb]xy@}J`Iec@qJ}b@d]y_@vHpJoDbp@dO|EvNkx@o@j_@bYt\\yHtf@}Qj@cArRpl@dBtj@zm@~BtZoRtQk^~aB}GwHyTfI@ly@us@xp@kKyDyDnTo`AmOawApa@ag@lxFdTh{AeZzl@iwAxAwhAjl@hTlrAqYrRcIhk@Rr|@xIkCHpc@`\\[vX}U|XtYtRplAkx@`r@gM|bA_UrIaChSnWlwAaOjHeYxaA{dAd~@cQtGqn@u|@qy@rlB{jAmVoJlT|@pt@iNlfAo^kInAzVig@zK`DfiAiYnViAv_@qPfc@z]nxAbe@nu@tFvi@zu@iHfj@rMtg@g[nEwYoFs\\k\\gZsA}MwL]nLwyBjx@}[r`@~d@rOkXzTfC^~VfLvHtS}\\h_@n@wTfs@_NhJz@|lD{n@tPd]~~Azs@ld@wV`sA|B~YjSzUOxo@frBztCdp@bl@~LptAiUxyBnn@hbC_r@vj@zCx\\cQzLRtSwXfDC`n@ua@h_@zNrUeYzn@_{@o`Aco@fx@_FzqCuJxv@iTn@mH`QxJrTaQ~TO|o@ua@|d@sMm^yM_Ek[~Ka@p`@qNhBw[aXsHvOs\\eD_BrN{Mi@`BpMaOt`@{LgCYiLgE~PwJv@v@fZwFkIoOdUmJ_\\cGdReLcOjBhP_HoB}E~YuTjI_FoI_JlSkPh@_Ozc@`BfP{Jp@dAjJeb@dv@ax@cHwjB|_DeOxr@}@xsAfxAhh@kb@tzAgLvgAkiAdh@iKsE{d@n[eh@dnC{J~BaDjc@yv@t^ycA`qAi{@}s@cGoSo@m~AjKmd@uYc^}@se@_Nkg@oIikCy^otAfG}XqSsbCmH_GqSlIgMeg@al@lCiS}l@iSEqDyi@pX_`AvAwg@cSgj@cG_`AaX`Ekd@uNo]nTm|Ass@g~BbyFkcBwDw\\wu@esA}r@yKo]oUgC}FkUyHdCeI`JeAzXhFtBcIlXpCzReMhZh@|Z_yArf@aOtTeo@pgEjlA}Kp|@xJfWsKpPpRzKn_@f]d_@dE`k@~X|ZfLhf@nk@fk@fItw@dNhSdi@dcCbE`d@eF|c@gPpP}Ct[cYpAuX|b@nEvdAln@|hBqDtUtDhlBwOfoAsKn`@x@ryB|DhjBv[~aBoApRtNr_@oOpl@ly@aE`U~Ll_@`_B}Np|@}ZpKqZ{TyxAt`AxTfuAkb@vd@uRrhAhChnChb@vUnjAIaEb[vGfr@{bAfh@_[eCoYpe@wWk`As\\vTyf@eI}c@_^mU{MmVr^}FndAc{@uQUio@}NiJyQpGxFlaCjh@~|ArQtmCoUtwAej@nfA{VpeBa^d^}]laAoZbw@efA|~@mg@liAcdAtKadA_\\}VdzBvVp[rN|hBjUb`@eH~^~Exu@ktAvzBnAtlAoeAdAuFtu@pAlhBtVnPeVbvA{FbbBgp@jzAkB|q@ae@ha@J`d@tPb]{c@`m@mSbp@|n@f|ApMny@qUjPe\\bp@sp@dkBwg@vuCqXfZk]n{@xIvy@`Zh`@yChh@~I~`@|e@nA`Uf_@xZq@nb@dh@z`@eAza@~u@lVxAeFoTpd@ss@ne@koBrk@kv@wImq@fMgW`W`D|Os]vNlCtcAs_@jd@fYhP{W|xAo`ApUyn@lZfEn\\kKpO~X|r@k^vMuGdKoa@hNPdLw^lCe|@oIeEoIcf@jo@{_@lc@o{BoC{k@~DqKhc@uEhEe`@liB}cAfcAxThk@zh@bWzr@hT{InV_n@`p@mCzDsVvbAgnApR`i@`l@bi@`TxbBicAnf@mj@b~@gp@~IyRvZle@fqAfTdIfa@m\\~Ufm@jUpNnFle@qIn^j@nbByOn`@mCbe@bUbtBjXnBnMdy@bSlVpy@x@xXpPdOj_AeFhs@uQpGaVf`AyPrPjYbdAhEzM`[kCvSr}@bd@xQkT|d@fCvVdu@hn@lOr\\hyAvS~u@dj@na@dv@ze@eFz]v|A~e@rlAwG|ZxBlc@~yAneApSh\\tgAl_@bu@rnBsKdkBi_@taAqd@lxC}MlkAfDzn@q{@ts@qX`eAol@bLaIfs@yRjUqSx[hAbd@oM`y@gSu[uQ|ZuUq_@sQjn@eNgBch@llBc{@pOgd@cb@uY`ToCzSwYaJkk@~ZySeOkUhEqQc_@km@fQaHx\\aLySwSwBsOne@ai@~Ps@dRyV|[q_@tR`Htr@_Jnf@qWrc@{XdYeYkHcFrc@_P|ImLsGsOnJxAxu@_VpVoCzWyg@lPaCh^gb@jJk|@~rAySaHePbT_P\\ky@peB{`@lKod@jr@g[~GeYrg@vBnkBh@lQdYlZ~D|d@e{@fcBcsAdq@u[|`Aii@vT_Vo\\oc@t@yVaNgVrZkSeG_`@pWsCrVlGb\\wKdXdPnm@gYn{A~Jry@kQdr@hBbXlJ~`@taA`o@xNn^Vfp@wu@bJaQtt@uNpMc_@cHsi@bZLnlAyOlSyKDaHk[gd@mEeXteAcVlJgCpOvJhj@x_@fs@_ZbfAqTwUqjArYqPxc@tClb@qS`OeOoQck@_@}i@qe@sSqjAtE_Zz[vBdYyRwDcl@sb@{PwK`U_R~@uXn|@yPmWbDqcAoUa@oO|UcCcJnVm|@q[clAyc@jh@sh@c{@Vae@bYsVmCie@wQr^wSbFaJoQxBgMpHx@zOe_AwEa]vIwa@sd@gb@cf@wC~A{XoRqo@y_@nQii@_LaHqx@jXohAlV_JNiWbWkb@mCwWmPwBnGiSef@{mA}lA__AuUikA_c@yo@wJya@{JwIeTj^}FeHom@vbA}c@crCet@x@c^hMqSfZw[aCNyeBy_AysCkj@zH}zBh~BwVp~@{k@|o@yGr`AugA|vAmX`McLyGkAvILvZwfA`cA`Izf@eFp]_\\hJg]|`@aYrDaDjNi@fi@kXnjAfLxp@lLrEhSro@aJl\\lA~cB{DdMyh@tJlBfp@yCxu@jF~]yZbrC`Wp[hdBvu@hhAjBbHbKlJoHrRxRzPnlCfSrk@yGfr@e^{Cod@~Reb@dh@kq@jhC|Npv@k`@j^_Hxg@{QdLd@hz@bJ~SqMzIaFrWaGtUtCbP`{@tc@|@zc@bb@rZvl@djB~zApo@|q@nNnVqEjTlMi[dsAp`BbnBgI``@qc@`WsCh[nLlOoc@loBmQrXyIu@ul@ccAyn@}uCoR`a@oFpo@{p@lRiMd[wWoX_OhIyi@eEah@`W_WdOuWiDoDj^uU`Tag@kB}r@jsCnA~gAxYzoA~Ad`Afc@~c@_Wrh@z\\doA|ZffCbYpEoS`oCcj@qM_gDpkAyIx]qyAhdBgqBqK_k@hkAwa@|T|Ddp@zJjx@c@|n@|c@~O|Zpz@_GrxBpn@z{Bm@`a@cSjc@jLpmCwOj`A{Pfh@k|@n\\gLxUsKrmAmRns@mDxkB{ZpzBcO`Lq[lUwWxnAsOtzCxPb{AcZvqBvE|_AxMlcAiuAdrAdOlkBiO`qA_d@~j@gY~{@oR|nA}QjCgKtfA`PnrAjRr[j`A`c@x`AvfArb@~y@tE`w@wNp\\hAlb@aUz]uUuUscA~Dmf@nf@oSuNqKi`@aDnKuU}K_OfXw\\aKsKyXcNnW_mA|Wye@fp@_x@`h@hBnUoSj[vFhCmB`KwJJdCxKeObNdFzE_FpZ`DhVaOxAjDtMqK|YjA`l@sIx^a|AtkBs`@zNgy@`oAkULej@tDa|@~b@{YsAi\\|Vm_@oP}j@rJ{VkQiPug@aUaOaVgv@qf@aUq`@zXs]zwAou@ySop@rRsHn|BxGra@qf@fx@}MaXyL~[aFuGuP|P{Mc_@wI`c@rOdv@dBrx@xTfb@cBlt@`Ybo@`ZiTrTbr@mN|iA{Tht@oLaY}\\uI_eDl`@lHpUd_@ftCtxBjeAv@ao@hMgGoAvd@~Htn@}R`o@`Kl`BcOhZaw@~W_PgTwGmd@wSgB{Pxr@rC~[eMlu@bGlDJ`m@yQ}@}Fvo@}KlEgKxKmD|r@`{@dAvDzqBaDzVqOtNsFmMy\\lOh@zVaK|HtFt`@yEfJ|FxTlc@lLdBj`@bf@jhAeI|hA`ZxHbfBn`BbL}c@v|@k{AuSmQq_@uvAl]}^`z@eXf_@sh@t@tZ|Vzg@jnAk[vh@fMpViGtUre@lc@|]rMbO~Dr_@z`@dd@zg@_a@rHiUbi@iCoA{n@dh@laAvb@uAhRlO~MkWxoAkTfo@{BiBd~A`m@njDkMbeAk_@taAkg@`~EQlHxt@`Qum@t}AsMtr@Mhi@~h@pS`Jjs@mHls@rFlg@cWly@pM`p@wUhXq`@`Kok@qTgvAclC_}@mr@oh@i`BqYwS_cAqf@}P}uA}`@ec@kh@fFoMdNi|@a\\kJcf@aLvYeYwZkY|DeHmz@aEqa@aLoHof@jGq`@mKwKpPs_@x@sOyRpFi[iG}XisA{v@wa@iGuEvTwKrC_L{MtHmNiQjCWwRsN|KiBcb@gVaRwB|M}K}IkZ_TeJpUwIuI_IfGqDsKtEwGsY_JMaY}R_U_@oSip@`Iao@gr@{U]a@zSyHrAsf@ciAyy@bSqAyVsNhAaFkYaXlFiDrNoHiUe]_@od@~c@iEuRaH|FoPyOePzIaJkKbHkM[aWwYmk@_KgI}EzQkx@yJ{{@de@sFsc@ad@o[im@th@w^fF_`@qiA{XnUuv@il@oRtBuj@`T}\\gz@gON_G`g@_^V{Ue`@}Mu@sClReMn@gJcm@oJfFqVqLgf@nLw\\u|@sKqCuE~RkLca@gMhLcMkJ`Dm]{QiZem@ls@~MhT_IdPmSaI{Cw_@gM_D{Hcl@ob@hMkPsM{TdH}CaMoQmPsT`n@{_@yEc]bTuf@sGw@nSiN`EuV~l@iA|y@sYkI{SlGsOvc@q^sNqDrVmRvQm@`]kNd[y]cCqEnl@qWnG_FrQoc@pHqJ~Pe~AtHoPjSlA|a@kJpLuG{DuGgq@cNcWoSr@oZmc@_Z~w@oCp_@cQN}XdZs_@oEiPvM_I``@oK}ZcAkg@a\\hG_k@~w@gN{b@c_@gOud@`QgT}J_[rm@oQc\\tHym@qx@cTwXtl@al@vXg`@|i@k]uBip@~l@gK`kCsk@bKgT`w@g@tu@|Jpx@wMnf@qTrWzRlbBwb@`e@hD|uAq~@piBoXpLeGvo@yNn_@tHvn@kt@xj@yCzd@kN`P|Cvr@sG~WzC`g@gGbjAsZp^|Gxy@mS`o@kC|l@ia@ph@{YBiSjPu`@__@m`@`LwX~b@iGxk@um@h_@exAkiB{w@uYsj@a{@iM{x@sWuJmSmo@}_@wXafA~Jkv@~|@q^sPoo@rKu]eJ{g@v]}u@ki@gRvZoQzBwt@b`@gIdn@cLvP_XiN_]jOcAtq@gdBniDoTf`Aay@jbAk_@rNsR~z@{bAle@{[~b@sm@{V{\\bNwRwg@kIzGiKr~@{I~Kk`@_Yme@}Awd@tMg\\gDwLpUiy@h]wJpw@cTdLzBzdAuHvi@yKhMpBx`@uHvSwkAjo@eV|j@sd@dAoU{S{m@rQoXee@vNi^}AcVeo@dDg@wQpPkKj@iPaM{@{]r^k_@yZ_DqoAwk@o~@{Ksz@m]iOyKqc@ew@cKaVgl@uTcGzDoeAs\\`@aDmf@oe@kpAoLmDi\\pRge@qs@aj@wOaNuReo@zKu[iV{Dm`@g_@ui@o{@oKwU`N_Kx_@im@|b@ykAhRwOeL[c\\_Pm[qtA__@gn@nl@m[_eAsb@eHez@gzAmb@|D}Ogp@ieAqH{TjXwl@|Aqi@ajAk^oJcZdW_~AbvAyr@`iBy[vtCqx@nmA}l@bb@kz@wKu`C~[{wB{qCm`@sMsaAhYcw@vpAc]lQa]aTal@uvAgb@kc@ahBc[ka@wTmPjHsf@l}@el@~Wi`@dr@ch@tpE}@fnAev@jvD_DdnBmNxh@wu@|^cVb~@oRfPy_@O{i@kz@eXeC}h@zh@_s@tKyf@nzA}~@oHs{@|o@yc@nRehBwCed@bK}rBrfByf@uIufA_aAudAzOw\\wHm]eXc[wl@sUakCyj@gj@o}AklCkiAqTq|@{eB_i@oc@cXeDii@pa@il@|iB{x@bO{|@fd@sWMy`Aww@kfAiTajAcgCyXgFmVxOga@fuAic@jz@_nAb`@}_Af`Amd@heBkv@hfBenAxiFwZjnBybAvlCo`@`bBmf@jz@}s@bQaSpTkOt_@gHdtAoQb_@so@jMqa@f^c\\r`A}`Avt@}wAhcC_dA|~@wWzmA_~@ns@aXzsAqp@pjB_QhgBmr@nxCmcBdjDq_AzjAo]tbA{_@bUch@nw@oNjdAwK|hFiPhfBz@hx@{ZjqAmy@tk@wf@Kku@yi@uhCcmDkrAiWmmA|x@u`BhLaiBdn@ygAiH_j@``@}z@a]iMgc@aIynAis@ug@eKgX_YsgBwo@kkBkF{fAsUs|@iDcm@um@k}AoMsr@qj@_{@y}@coC{{@e~Aac@ia@ie@adAy]gzAc_@om@ubBslAaZaDcm@wm@ys@gUygB}A}r@kv@auBgPgaAia@c|A`dByzAh]k|@{Tqd@e]cvAwOgSit@iJqsAoWyg@_mAqOgdAknA}h@mgAgo@cNib@qd@ue@ow@ue@fGob@|[qKyDsIfuCg`Dhf@mi@tq@y`B_u@odA~j@mgAbQsh@`~Ay_Bw^og@hBujAxa@yvA`fAek@r[{rC`\\a~AaS{t@xBqDrqAmbEfWim@zTyo@jsCidCtdAg\\iUmk@zTsj@z}@wm@aHqK~[}gAieAm_ClFwiEwYmAlc@}bBbiDqvCsDmZtb@_A|i@mStHgf@s`Ae{@yNq\\fv@cfAdq@ad@wDsFeYeOjUwvDc\\_Q~GwUgKax@`h@qtB_gBe`BrgAopNtsJorAaRyxBlRsf@bs@oWgJyGv~BiL?oIcc@SkfB}oAgvB~b@_nCl@mlCkLie@qi@bDtY{`@|b@oKb~@yoHfBy~Ca]oiE{VggB}_A_jEghA{sCehCa~Eog@kuEwbAurEqi@coD{hA{vIiSofBe}@moEqo@ehCcHcRaJrIdFoP}PchBok@iiEegC}eVgpByhNsdC_~Nc^wrE}_C_ePo~AupLux@_bEaM}b@oKsA|G_HsF}pAmbAejPwf@_bGsD{zIcb@}nDm|@myDg]gw@yRzDzMeRlBifDawAckQygBmaOmz@kwE_t@kwDci@edF}v@cwUgg@e|Hgh@wwEm}@ugGefBmoHesBciGadAy_CulEwtIezD_wGo`CcaDmqB}wBs~Ae~AmYfMpHcd@oHij@ub@s{@c[cXoxEqlEy|Cw}ForAiyDcqA{oCuTe_AwdBg~Lay@ekKcHuqD";


function CustomMarker(mapaWarstwy, latlng, map, args) {
	this.mapaWarstwy = mapaWarstwy;
	this.latlng = latlng;
	this.args = args;
	this.setMap(map);
	this.maxZoom = 16;
}

CustomMarker.prototype = new google.maps.OverlayView();

CustomMarker.prototype.draw = function () {
	var self = this,
		div = this.div;

	if (!div) {
		div = self.div = document.createElement('div');
		div.className = 'btn btn-xs cluster';

		if (self.map.getZoom() >= self.maxZoom) {
			if (self.args.count === 0) {
				div.className += ' btn-default';
			} else {
				div.className += ' btn-primary';
				if (self.args.count > 1) {
					div.innerHTML = pl_number_format(self.args.count, 1);
				}
			}
		} else {
			div.className += ' btn-primary';
			div.innerHTML = pl_number_format(self.args.count, 1);
		}

		if (typeof(self.args.marker_id) !== 'undefined') {
			div.dataset.marker_id = self.args.marker_id;
		}

		google.maps.event.addDomListener(div, "click", function () {
			var ngoPlaceBlock, infoWindowBlock;

			if (self.map.getZoom() >= self.maxZoom) {
				var p = self.args.data;

				ngoPlaceBlock = '';

				if (self.mapaWarstwy.infowindow) {
					self.mapaWarstwy.infowindow.close();
				}

				if (self.args.data.key !== '') {
					$.get('/dane/krs_podmioty.json?limit=20&conditions[-adres.punkt_id]=' + self.args.data.key, function (data) {
						$.each(data.hits, function () {
							var info = this;

							ngoPlaceBlock += '<div class="ngoPlace">' +
								'<div class="title">' +
								'<a href="/dane/krs_podmioty/' + info.id + ',' + info.slug + '">' +
								'<span class="object-icon icon-datasets-krs_podmioty"></span>' +
								'<div itemprop="name" class="titleName">' + info.data.nazwa + '</div>' +
								'</a>' +
								'</div>' +
								'</div>';
						});
						infoWindowBlock = '<div class="infoWindowNgo"><div class="ngoPlace">' +
							'<div class="margin-bottom-20">' +
							'<div class="title">Ulica: ' + p.miejsce.ulica + '</div>' +
							'<div class="title">Numer: ' + p.numer + '</div>' +
							'</div>' +
							ngoPlaceBlock +
							'</div></div>';

						self.mapaWarstwy.infowindow.setContent(infoWindowBlock);
					});

					self.mapaWarstwy.infowindow = new google.maps.InfoWindow({
						position: self.latlng,
						content: '<div class="spinner grey">' +
						'<div class="bounce1"></div>' +
						'<div class="bounce2"></div>' +
						'<div class="bounce3"></div>' +
						'</li>'
					});
				} else {
					infoWindowBlock = '<div class="infoWindowNgo"><div class="ngoPlace">' +
						'<div class="title">Ulica: ' + p.miejsce.ulica + '</div>' +
						'<div class="title">Numer: ' + p.numer + '</div>' +
						'</div></div>';

					self.mapaWarstwy.infowindow = new google.maps.InfoWindow({
						position: self.latlng,
						content: infoWindowBlock
					});
				}

				self.mapaWarstwy.infowindow.open(self.map);
			} else {
				if (self.args.mode === 'warstwa' && self.args.count === 1) {
					ngoPlaceBlock = '';

					if (self.mapaWarstwy.infowindow) {
						self.mapaWarstwy.infowindow.close();
					}

					$.get('/dane/krs_podmioty.json?limit=20&conditions[-adres.punkt_id]=' + self.args.data, function (data) {
						$.each(data.hits, function () {
							var info = this;

							ngoPlaceBlock += '<div class="ngoPlace">' +
								'<div class="title">' +
								'<a href="/dane/krs_podmioty/' + info.id + ',' + info.slug + '">' +
								'<span class="object-icon icon-datasets-krs_podmioty"></span>' +
								'<div itemprop="name" class="titleName">' + info.data.nazwa + '</div>' +
								'</a>' +
								'</div>' +
								'</div>';
						});
						infoWindowBlock = '<div class="infoWindowNgo">' + ngoPlaceBlock + '</div>';

						self.mapaWarstwy.infowindow.setContent(infoWindowBlock);
					});
					if (self.mapaWarstwy.infowindow) {
						self.mapaWarstwy.infowindow.close();
					}
					self.mapaWarstwy.infowindow = new google.maps.InfoWindow({
						position: self.latlng,
						content: '<div class="spinner grey">' +
						'<div class="bounce1"></div>' +
						'<div class="bounce2"></div>' +
						'<div class="bounce3"></div>' +
						'</li>'
					});

					self.mapaWarstwy.infowindow.open(self.map);
					self.map.setCenter(self.latlng);
					google.maps.event.addListener(self.mapaWarstwy.infowindow, 'domready', function () {
						self.mapaWarstwy.map.setCenter(self.mapaWarstwy.infowindow.getPosition());
					});
				} else {
					self.map.setCenter(self.latlng);
					self.map.setZoom(self.map.getZoom() + 1);
				}
			}
		});

		var panes = self.getPanes();
		panes.overlayImage.appendChild(div);

		var size = $(div).outerWidth();
		$(div).css({'width': size, 'height': size, 'line-height': (size / 10) - 1.2});
	}

	var point = self.getProjection().fromLatLngToDivPixel(self.latlng);

	if (point) {
		div.style.left = (point.x - div.offsetWidth / 2) + 'px';
		div.style.top = (point.y - div.offsetHeight / 2) + 'px';
	}
};

CustomMarker.prototype.remove = function () {
	if (this.div) {
		this.div.parentNode.removeChild(this.div);
		this.div = null;
	}
};

CustomMarker.prototype.getPosition = function () {
	return this.latlng;
};


var getUrlParameter = function getUrlParameter(sParam) {
	var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split('&'),
		sParameterName,
		i;

	for (i = 0; i < sURLVariables.length; i++) {
		sParameterName = sURLVariables[i].split('=');

		if (sParameterName[0] === sParam) {
			return sParameterName[1] === undefined ? true : sParameterName[1];
		}
	}
};

var MapBrowser = Class.extend({
	spinnerCounter: 0,
	retina: false,
	map: false,
	fitBounds: false,
	mapOptions: {
		panControl: false,
		zoomControl: true,
		mapTypeControl: true,
		scaleControl: true,
		streetViewControl: false,
		overviewMapControl: false,
		scrollwheel: false,
		mapTypeControlOptions: {
			style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
			position: google.maps.ControlPosition.RIGHT_BOTTOM
		},
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.SMALL,
			position: google.maps.ControlPosition.RIGHT_TOP
		},
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		backgroundColor: '#FFFFFF',
		styles: [
			{
				featureType: "administrative.country",
				elementType: "labels",
				stylers: [
					{visibility: "off"}
				]
			}, {
				featureType: "administrative.country",
				elementType: "geometry.stroke",
				stylers: [
					{visibility: "off"}
				]
			}, {
				featureType: "poi",
				elementType: "labels",
				stylers: [
					{visibility: "off"}
				]
			}, {
				featureType: "water",
				elementType: "labels",
				stylers: [
					{visibility: "off"}
				]
			}, {
				featureType: "road",
				elementType: "labels",
				stylers: [
					{visibility: "off"}
				]
			}
		]
	},
	mapPointIcon: {
		path: 'M-4,0a4,4 0 1,0 8,0a4,4 0 1,0 -8,0',
		fillColor: '#337ab7',
		strokeColor: '#337ab7',
		fillOpacity: 1
	},
	mapBorder: new google.maps.Polygon({
		paths: [
			[
				new google.maps.LatLng(-90, -90),
				new google.maps.LatLng(-90, 90),
				new google.maps.LatLng(90, 90),
				new google.maps.LatLng(90, -90)
			],
			google.maps.geometry.encoding.decodePath(polandShape)
		],
		fillColor: "#FFFFFF",
		fillOpacity: 0.8,
		strokeOpacity: 0.5,
		strokeColor: "#444499",
		strokeWeight: 1
	}),
	plCenter: [51.986797406813125, 19.32958984375001],
	plZoom: 6,
	layers: [],
	loadDelay: 400,
	markers: {
		wojewodztwa: {},
		powiaty: {},
		gminy: {},
		krs: {},
		ngo: {},
		instytucje: {},
		wybory: {},
		adres: {}
	},
	cacheAjax: {},
	cacheAjaxPoints: {},
	dataLoaded: {
		'points': false,
		'pointsData': {},
		'layers': false,
		'layersData': {}
	},

	init: function () {
		// SETUP
		var self = this,
			center = self.plCenter,
			zoom = self.plZoom;

		self.div = $('#mapBrowser');
		self.map_div = self.div.find('.map');
		self.sidebar = $('.app-sidebar');
		self.menu = self.sidebar.find('.app-list');
		self.layers = self.div.data('layers') ? self.div.data('layers').split(',') : [];

		// set center i zoom to display
		if (getUrlParameter('clat')) {
			center[0] = getUrlParameter('clat');
		}
		if (getUrlParameter('clng')) {
			center[1] = getUrlParameter('clng');
		}
		if (getUrlParameter('z')) {
			zoom = Number(getUrlParameter('z'));
		}
		self.mapOptions.center = new google.maps.LatLng(center[0], center[1]);
		self.mapOptions.zoom = zoom;

		// construct google map
		self.map = new google.maps.Map(self.map_div.get(0), self.mapOptions);
		self.map.addListener('bounds_changed', $.proxy(self.load, self));

		/*
		 if (self.fitBounds) {
		 self.map.fitBounds(self.fitBounds);
		 }
		 */

		// settings Poland borders to display
		self.mapBorder.setMap(self.map);
		if (window.devicePixelRatio > 1.5) {
			self.retina = true;
		}
		$(window).resize($.proxy(self.resize, self));
		self.resize();
	},


	// resize function gets called on viewport size changed
	resize: function () {
		var h = $(window).height() - 48;
		this.map_div.css({
			'height': h + 'px'
		});
	},


	// load function gets called on map bounds changed (this includes center or zoom changes)
	load: function () {
		var self = this,
			center = self.map.getCenter(),
			zoom = self.map.getZoom(),
			q = {
				clat: center.lat(),
				clng: center.lng(),
				z: zoom
			},
			param = $.param(q),
			chapters = self.menu.find('a'),
			i, a;

		for (i = 0; i < chapters.length; i++) {
			a = $(chapters[i]);
			a.attr('href', a.data('href') + '?' + param);
		}

		if (history.pushState) {
			history.pushState(null, null, '?' + param);
		}
		else {
			location.hash = '?' + param;
		}

		$('head > title').text('Mapa');
		$('link[rel*=icon]').detach().appendTo('head');

		self.clearPlaces();

		// load points
		if (zoom > 15) {
			self.dataLoaded.points = false;
			self.pendingAreaPoints = self.getArea();
			window.clearTimeout(self.loadTimerPoints);

			self.loadTimerPoints = window.setTimeout(function () {
				var area = self.getArea();

				if ((area.tl === self.pendingAreaPoints.tl) && (area.br === self.pendingAreaPoints.br) && (area.zoom === self.pendingAreaPoints.zoom)) {
					var params = {
						tl: area.tl,
						br: area.br,
						zoom: area.zoom
					};

					self.spinnerOn();

					var checkParams = $.param(params);
					if (checkParams in self.cacheAjaxPoints) {
						self.dataLoaded.points = true;
						self.render(self.cacheAjaxPoints[checkParams], area, params.layer);
					} else {
						self.xhr = $.get('/mapa/points.json', params, function (data) {
							self.dataLoaded.points = true;
							self.cacheAjaxPoints[checkParams] = data;
							self.render(data, area, '');
						}, 'json');
					}

				}
			}, self.loadDelay);
		}


		// load data in separate API calls (one call for one layer)
		if (self.layers.length) {
			self.dataLoaded.layers = false;
			self.pendingArea = self.getArea();

			window.clearTimeout(self.loadTimer);
			self.loadTimer = window.setTimeout(function () {
				var area = self.getArea();

				if ((area.tl === self.pendingArea.tl) && (area.br === self.pendingArea.br) && (area.zoom === self.pendingArea.zoom)) {
					var params = {
						tl: area.tl,
						br: area.br,
						zoom: area.zoom
					};

					for (var i = 0; i < self.layers.length; i++) {
						params.layer = self.layers[i];
						self.spinnerOn();

						var checkParams = $.param(params);
						if (checkParams in self.cacheAjax) {
							self.dataLoaded.layers = true;
							self.render(self.cacheAjax[checkParams], area, params.layer);
						} else {
							self.xhr = $.get('/mapa/layer.json', params, function (data) {
								self.dataLoaded.layers = true;
								self.cacheAjax[checkParams] = data;
								self.render(data, area, params.layer);
							}, 'json');
						}
					}
				}
			}, self.loadDelay);
		} else {
			self.spinnerReset();
		}
	},

	render: function (data, area, layer) {
		var self = this;
		self.spinnerOff();

		if (data.grid && data.grid.buckets && data.grid.buckets.length) {
			self.showPlaces('warstwy', data, layer);
		}

		if (data.points && data.points.buckets && data.points.buckets.length) {
			self.showPlaces('warstwy_adres', data, layer);
		}

		if (data[0] && data[0].miejsce && data[0].punkty) {
			self.showPlaces('adres', data, layer);
		}

		/*if (data.hits && data.hits.length) {
		 //TODO: show grids
		 }*/
	},

	clearPlaces: function () {
		var self = this,
			zoom = self.map.getZoom(),
			clickZoom = 16;

		$.each(self.markers, function (key, val) {
			if (key !== 'adres') {
				if ($.inArray(key, self.layers) === -1) {
					$.each(val, function (k, v) {
						$('[data-marker_id*="' + k + '"]').remove();
					});
					self.markers[key] = {};
				} else {
					$.each(val, function (k, v) {
						if (!(k.startsWith('marker-' + zoom))) {
							$('[data-marker_id*="' + k + '"]').remove();
							delete self.markers[key][k];
						}
					});
				}
			}
		});

		if (!$.isEmptyObject(self.markers.adres)) {
			if (zoom >= clickZoom) {
				$.each(self.markers.adres, function (k, v) {
					if (!(k.startsWith('adres-' + zoom))) {
						$('[data-marker_id="' + k + '"]').remove();
						delete self.markers.adres[k];
					}
				});
			} else {
				$('[data-marker_id^="adres-"]').remove();
				self.markers.adres = {};
			}
		}
	},

	showPlaces: function (mode, data, layer) {
		var self = this,
			zoom = self.map.getZoom();

		if (mode === 'warstwy') {
			for (var i = 0; i < data.grid.buckets.length; i++) {
				var cell = data.grid.buckets[i],
					center = Geohash.decode(cell.key),
					f = 0.7,
					term = 'marker-' + zoom + '-' + center.lat + '-' + center.lon;

				if (!(term in self.markers[layer])) {
					if (cell.doc_count === 1) {
						self.markers[layer][term] = new CustomMarker(self, new google.maps.LatLng(cell.location.lat, cell.location.lon), self.map, {
							mode: 'warstwa',
							count: 1,
							marker_id: term,
							data: cell.location.punkt_id
						});
					} else {
						var inner_center,
							centerLat,
							centerLng;

						if (cell.inner_key) {
							inner_center = Geohash.decode(cell.inner_key);
							centerLat = center.lat + (inner_center.lat - center.lat) * f;
							centerLng = center.lon + (inner_center.lon - center.lon) * f;
						} else {
							centerLat = center.lat;
							centerLng = center.lon;
						}

						if (self.markers[layer][term] == null) {
							self.markers[layer][term] = new CustomMarker(self, new google.maps.LatLng(centerLat, centerLng), self.map, {
								mode: 'warstwa',
								count: cell.doc_count,
								marker_id: layer + '-' + zoom + '-' + term,
								data: cell
							});
						}
					}
				}
			}
		}
		if (mode === 'adres' || mode === 'warstwy_adres') {
			if (mode === 'adres') {
				self.dataLoaded.pointsData = data;
			}

			if (mode === 'warstwy_adres') {
				self.dataLoaded.layersData = data;
			}

			if (self.dataLoaded.points && (self.dataLoaded.layers || self.layers.length === 0)) {
				var points = self.dataLoaded.pointsData,
					i, j;

				for (i = 0; i < points.length; i++) {
					var m = points[i].miejsce;

					for (j = 0; j < points[i].punkty.length; j++) {
						var p = points[i].punkty[j],
							count = 0;

						if (!($.isEmptyObject(self.dataLoaded.layersData))) {
							count = self.dataLoaded.layersData.points.buckets.filter(function (i) {
								if (i.key === p.id) {
									return i;
								}
							});
						}

						if (self.markers.adres['adres-' + zoom + '-' + p.id] == null) {
							self.markers.adres['adres-' + zoom + '-' + p.id] = new CustomMarker(self, new google.maps.LatLng(p.lat, p.lon), self.map, {
								mode: 'adres',
								marker_id: 'adres-' + zoom + '-' + p.id,
								count: (count.length) ? count[0].doc_count : 0,
								data: {
									'miejsce': m,
									'numer': p.numer,
									'key': (count.length) ? count[0].key : ''
								}
							});
						}
					}
				}
			}
		}
	},

	spinnerOn: function () {
		this.spinnerCounter++;
		this.spinnerUpdate();
	},

	spinnerOff: function () {
		this.spinnerCounter--;
		this.spinnerUpdate();
	},

	spinnerUpdate: function () {
		var self = this,
			spinner = self.sidebar.find('.app-logo .spinner');

		if (self.spinnerCounter) {
			if (spinner.is(':hidden')) {
				spinner.show();
			}
		} else {
			spinner.hide();
		}
	},
	spinnerReset: function () {
		this.spinnerCounter = 0;
		this.spinnerUpdate();
	},

	getArea: function () {
		var self = this,
			bounds = self.map.getBounds(),
			precision = Math.ceil(self.map.getZoom() / 2),
			ne_lat = bounds.getNorthEast().lat(),
			sw_lng = bounds.getSouthWest().lng(),
			sw_lat = bounds.getSouthWest().lat(),
			ne_lng = bounds.getNorthEast().lng(),
			f = .1,
			ne_lat_fixed = ne_lat + ((ne_lat - sw_lat) * f),
			ne_lng_fixed = ne_lng + ((ne_lng - sw_lng) * f),
			sw_lat_fixed = sw_lat - ((ne_lat - sw_lat) * f),
			sw_lng_fixed = sw_lng - ((ne_lng - sw_lng) * f);

		return {
			tl: Geohash.encode(ne_lat_fixed, sw_lng_fixed, precision),
			br: Geohash.encode(sw_lat_fixed, ne_lng_fixed, precision),
			zoom: self.map.getZoom()
		};
	},

	formatAddress: function (data) {
		var html = '<ul class="address">';

		if (this._data.ulica) {
			html += '<li>' + this._data.ulica;
			if (data.label) {
				html += ' <b>' + data.label + '</b>';
			}
			html += '</li>';
		}

		if (this._data.miejscowosc) {
			html += '<li>';
			if (data.kod) {
				html += data.kod + ' ';
			}
			html += this._data.miejscowosc + '</li>';
		}

		html += '</ul>';

		return html;
	}
});

var mapBrowser;

$(document).ready(function () {

	mapBrowser = new MapBrowser();

	/*
	 localizer = new Localizer();

	 $('.localizeMe').click(function () {
	 var self = $(this);

	 if (!self.hasClass('loading')) {
	 if (self.hasClass('btn-primary')) {
	 self.addClass('loading disabled');
	 }
	 localizer.request_position();
	 }
	 });
	 */

});
