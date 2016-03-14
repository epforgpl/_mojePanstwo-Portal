/*global pl_number_format,$,Class,Geohash,document,window,google,history,location*/

var polandShape = "w`alIgp|dBnD{pHsD}oAyn@syDoa@whEyOwaAmK`A|HgAaMorA{GaW{PPxRwOqKy}Dyu@odE}oAcbF_{CemHciEivH_MehAwm@mpCutBw~K}gDm`Nam@ajDqcAcuMmV{w@cKikAwUkdGgIs{Ho]g_HwZivC{NkqD_Naj@fFaJsGc_Cc^wtFaw@aqIsfBaoNct@ubLyqAyvLmZ{fEu]meIgR{{RvIkgH}DmfNfBwnEqRasKpIuqF|b@ijAjw@ufAjc@grAxqAisF~OivArDkKqCtIbR`P`h@gaBzlE}gQbvCwmLvrBsjJdeBigGxbBatEtzCqpHxxD{iG`VsQ`~AwKjg@v]~g@x|@gB`b@_f@h\\tArV}_@mJoOnRyFjQtIpLaWbc@}Lns@ip@~FyfBbtAkgF~qGkw@thAsbAfdCzKlw@mBv]me@h\\gEn}Aex@bgAwlAjpC_f@|iCywBlqImHrtAwS`UkPzLyi@jeDw\\ztAc_@ls@aEbu@gm@rzA{LbjAqf@p~AvJfPtIaFlBlMxSyHvYnYlVqMrQhJny@zdAtsA~x@xmBvQrL{RvY{aAjDafAjw@e{A`y@ctAny@w~Cxs@nj@|~BmDz`@fRrWiHl_@m{@~m@nZvTy\\fDpVaErOlQ}ElKjL~OeRxL}lAaQc|C_\\gp@prAja@jaAiEjjCypBlk@mgArhAen@zsA}Trp@ch@f{A}UvwBrFwEpd@~IfJq@nRzO`BdfBuoA|iAqd@r|@jj@zgAfCne@qFrl@_^rlAalAhp@ocA`oA_vClr@gzCvEwy@aEcj@gLy_@m`@bPpUaNdh@gzBpoA{eAht@}wAaOuRfQm^yZek@rKiR|i@dl@n_@k`BfZyjGsAy]aWbLzj@wm@zz@chFfj@{gElVqzDrF{~CcDgoAu[{iAah@eY|K~PwFfDid@umArb@`TsByWwCuXuIaCjf@{aAxMv@~LkUp\\q`C?ulMkWs|Nyn@umSq}@q}NykA}|LctBamNevAeaH_}A}dGgkAoxD}wBstFh^i{@ncAex^xlBmge@dOu`KfU{}Fl|@kuT|g@gaQrEwrB``@otDtQkgGx]kzEr_@_bLdLg{@w@}`CzPckHda@{lE~e@swAm]oiBu@qb@aCasF~P}xCI}pCzx@_dNgCwzD`MarFpKgpFiCs}CnNqi@jEinHl^gcE~LowGwDui@n\\_mIz_@oaCaB{jEpQysCdg@qoIqWgdBsFskAbYibCsIozIpR{vAtIy`CgCexBpC{Sbm@mr@uFqkCwWonDaHylEj@muCtMoAdAce@`B}bA}SaTc@aWuJmfJxBedGcQweKaLuhJfBemIgNahKlAkxCxB_eE}Tc|FtBq~HcJs_F|Ds`GgIaiFrDeU{FyKe`@csGnScUj@aPcHui@fF}cCcCikFnCqaCoIkCsMc|@tFkHkAi{BeNitIsMifBtLgnAcNylA}CeuGx@cdFg\\kmG`Ak{CmLc}B|Ji{CcJauBi\\_}BgRgwTyn@kxB}|EozCuCyoAyRaa@dKooA}Bu~Bbx@bB}AmaAhYocFr_@kiDxG{gCl^yD|I_~CraCzdBre@u_Bxg@onF~Vc`AlZo^jm@nkAlf@n[heAnY`Rsn@lyAchGgC_n@i^}l@whAooE|Hos@t\\ocAvmA~`@xKu~ApXoi@~LoaD~_@iRb_@gd@jf@}kAtcAc~@|UclAmTi}ErUmj@pHep@vVs~Fvd@ccA`oAobAlQyj@gBom@lHsn@rXka@p_@tFhPcu@b{@kVn^wc@pc@}Nr_@ynA~sAg`@lKwvEpo@}LdZkxAh`@xLz[ax@n@gTlmBg`@rQaYh`B~OzWaWPwa@~rA{]r{@_fAndAMpoAy~@rv@zOrz@}Gh{@hXhYwP~MxFrNfu@`j@r\\lVaJle@pYpXxq@rAyNzE~AgMn`@lMu@}Dp[jJvOxLaDhVxk@aBnMjJjFp`@kXlSnNu@aPfYt@fSyPsBqIzTdSvK}TbOlAbIgR_BmS`JcPzLfQ~FqHsCkWrJ^lEmi@tGpJlN{k@zEpH`EeYfHjExD{KnGvIj|FnRldHy{An[iCc@jOdKvAx@aYzHOrToi@}E{_@bIcKn@u_@ha@{ZlJ|EnGf_@jPtBrYal@be@|ZvUge@tCp\\jUnPj}D|I~pD_ZvtCwmEt_B_UrlC`A~{@eT~lQi`FteJ_gDhmCgq@xu@cn@fkNyeGn|CagB|_FaeCxqGydCpsIw{Dn{DszBfkAucF`cAce@pTVjFjMdFoShH`AtSt\\ti@ei@jGfLp^qDlC}NpDzGnMqe@kDiGjPsLdIe`@zAtIjAaRjQuChO}o@hJpDiAuNd_@eZdAom@|Xia@d]aJnDc\\]rJ~IuCbEdPiBcLfHkN|a@|Dw@mZlLjF|@zNhL}GlR`f@nj@}d@hP`WvMu@{@jTjGlHsGhGrQ|ClIhQmDvF~PtBiCrMpHvFxSyB~DfUxGmXj@bZhp@pWjCnPlLwCeA|LdN_BPyR~XxQaAuKtQmCtVbh@xQwEtCrMlIgJfG~J~DkKxC~ObHoByAhRp\\lVfLgD~CfP|^aM{AeZhSqD~CtLgAiLdJmMbD|Oz@{Mji@kErGkNrNyGqEuJzHc`@}CsLtNk`@tLqKfo@`[lBuMvGpEy@kR`KcRdIvDh@yf@~MfFxLkf@rNfApS|a@dZkGv[_w@zBu[daFyp@vc@xWnf@yIjlBw}Ah{BfyDtsEl@xA_Upa@sd@~hLhFflBo|A~pJbCv_Gt@|fC|oFtfAbn@?bqAngIngRx[x^x@bY|e@haA|L~l@qCvPbNnc@Rlb@ba@~]gNbF?|Okb@rfAxk@hcNb_@bzBhr@tsEruA~gHx`BnvFt}AbsEvw@tu@t_A~hCrrBxkD`iGp`I`gGjjGlnAzUn~@z_AvcA|gCzb@tc@|eJf`JtaHvgFQeSd_@yyBbNcS|o@l\\jaA{c@lmB|fAdpAuz@tG}~A`^sjBpEysAvYsmBMuc@ee@aeCqAkaA`XkJlNtLjG~c@dKH`Vs`B}OygAf[_fAmVuj@sC{o@pHaMpTlRhGuG_Uiy@`Gij@hu@eDxLyQX{}@mL}^}OqJgBe]rGqHrU`QdFia@nJ_Ole@r[vg@uErOqOqA}\\gUgZcEc^bx@wo@xEk]qb@ckA{^ma@lB_g@qKcg@jEmWzd@lAnSaa@SgXmj@gyAxD_~@tOsq@pYcSpIbx@cPxDwBdZb^yQtJhb@`UzWb]kU|^dO~RqFx[}mAgTac@rC_Zfh@{Zlc@tEcGuZxa@{NrHob@wFue@fScXtGo^hs@kFfYs^jW`C~K_NyEge@ok@t@_IqQxU{w@uY_kA~Nul@cBsy@~Vkm@h_@_^w@sm@`J{QzL`AnExi@tLfMra@gWhn@}gAnQixAvt@}O|Mg_@uAuSbP{Mjm@tz@jMgSRif@pUiGsIz`AzLpKdVueAtdAeWjVs^do@pKhq@wMba@zb@vXk|@rz@kk@dRo\\jGo]zN\\ve@e`@jb@~Szo@|_CxY}@xm@w]`KhE~ExnBbz@j|@xF|bAdS~VhL_LyO}v@nBqN~h@^h]ma@vb@nErErlAdy@pK_Sx_Adg@vo@vo@{r@xm@pKnVyrAhd@qf@dKdFr]zrAxKxF`j@ms@h[~@wCv`@gXpj@Ezb@bKf_@v`BkSr[wk@vZv_@lf@j@tNj[rCfe@~LbFhFyw@fLxBtMjh@fW}CjBm[qJk}@xDgXv[wQv_@hQ|Jkj@rRiH|`Am}@~ZgH|`@~j@fIiP`KfBzDdImGz[rGtJdZyO~h@jCv@jHcQx@cA~K`Pm@hLlXnCrm@hN{GtKdJwBfdA|Evi@hnAl|@mDnb@vSni@sA~w@yXph@vWnNtQvg@re@|WxQ`a@`Mz|@`e@sIlo@d_@vFkm@dZ~AnFsRmGwe@uUqBhAeQlq@gGbQk\\~d@nb@pBqj@~McGpQdk@tPy~@|MyIbPp]v[zC|i@xc@fTkk@th@dVty@kd@pMnVcCtc@fHtU|WlLfGzTh_@iZdL|Tt`@dNwFyZjZug@tXrEpR~r@rQgZr^`Db]kUr^dKxUfYnDuPjf@oDhRhVdYiu@`e@}H~UeWdZlFfIoQtCqo@|KqR~TcD~`@rWnS}^|_@lD|Jai@lOkQjk@pnAvc@rOv{@mObLwb@Taf@vSqr@o]cWgHk^bf@mr@^i_Ave@oIlu@g`A|U`n@rk@lDjNqr@`Q~^rGiBtKgk@nQ}QxEqc@j\\kLkAssAwVsT{CmYbNyUfQ_DrL{c@nr@eIrGsU~OcEe@px@vVtGlMt`@pPzJbQxb@oAr_@dJxDnWs[lPjLtFuMfW|E`JubAqGoj@lYar@iX_l@jCePzk@x[jUa[~C`q@h[eBlKif@`m@eYfAk`@iLki@dEaKhLnIfS|r@xMwLlB{k@fVnc@~JoClBqXtJaIrBjc@rYdd@uEjTxFv^jEfCrKg`@jIvAwIbf@hH~TpUmR~Lgx@lFbZ~SzA_GhX|EpI`NyNlZ~RpEqL{LoGN_Qpb@jIxVeWnDzRqFr_@zNrUmGro@zOfI`YmXvBhNiMx\\b[mFiEng@rg@lJxFoTtErXlTxBnKeMxFde@nKyp@jNpHcClu@j`@hL|^pw@bM~@Qq]lFgGvOb]pWfJld@{r@|PzA}@tVjXkGxk@cfA~F~`@`XuSfInYvNoT|OfEeIm\\xJoYmMqCcQu]Bac@pIjAhCkMqNsk@|KxA_HmTfHcDwCyT|OzChKoUe@cZkL_QiQvA`t@aOtIwSy@uTh\\u_@rMvVmDk^dMlElXsYsLcPvIsCx@iSpFfPnFqJvPrLmC_NdU}OBwXhDhSlE_PrHlQzj@oNjZfHzFwNjBuSfRt@kD~U~NuD~FcZB~[rLXj]elAxX}@`@kM~PkHlUl@vGzi@do@}UuAmPaPJjTgVsG_BrKqVoHuf@lH}F|FfJtJqWf]aB}OmObRhA^mW|MyJqA}l@|Gsj@|MdNpDqQ|WrEbL}OtJujAxNs[b@ih@ld@mc@lV`Lj[eLhV}kArBd^`\\wOuFoPrQwHoL{BbDuWmMoNfYwNi]g]~IqGrJzMhCsw@x\\zEmOcaAxP}OhTfD~F}i@dP~VnNgd@~QzThI_Np`AxArMdr@wUlGpSh^_QtEpZbC~MrWvIaUdXvEHs_@bWhKdHsj@rMl`@tKsJfBoVjCz]|Wq[tSj`@jRy[iNoP`DmPtNBzNcDuIcLzB}IpX|ErrAi`@mAwUyQn@uIob@|S}Gq@eUr[wMaMoWpOcKPy^uZ}M~Vy`@hNvDnLyMbc@pV~DwXnyAqRdKnMl@}e@b]fj@`LoQdCsa@xM^yJed@xAiYtT|q@ve@tm@vGe`@xHnQz`@ow@bFxUdN|@gDci@bO}a@hJpEuHrI|Bh[{ErNvMv@q@fUvRk@_Pfh@rLpD~CmVpMlTzHkp@yBof@|O_o@jt@_bAmAyPrMcVfuAylA|nAyDdi@}QrNnOne@wIpHe\\zSgIcOiU`M}I`Uay@ryAuh@nQ{u@ra@u]fV_qAphAevA~T}w@zSkUpb@oD`FsVeJkh@`HifAtGgh@~NaPkKyUrkAwpAhF_pArc@aYkKoe@jTsQl@cl@`HkQqOuPn@kj@nbAhNpx@deA~I~n@tLtAhA`f@vS~O~RjwAzLfCzAzzAuFvZ`MQuEtXrGhNaLx|@nLtEiGzOlEb_@qJtR~Af^tLhTeRtYqIel@sF`nApUfNaQdScG_K{GlJpArLnQq@wN`NyDtZbQjDcAx|@iLjNlKxcApJhh@x\\dh@jQbJhRgNkGxQlUjCaPzNdDvG|VfBpJ|OlTmKuLbc@|RkKUtSdLtWdNca@dnA|`@zZpd@hT_R|Ge]rWiQpZr]rSkPcCqYhVvHsKiShNb@rFch@bWfIvFiKf@yR{RbFpKagBcQquArc@wlAjk@sGhElWqSjAuEv_@lDrHfGgKfSzU`Aw`@~Lnh@hEcLwEuWdOIzEag@dGtPoI`QfW`OtDmMyLcMvRaSM`Q~r@rXeByZ|ZzCpSpWoDaWjo@vRvF_d@gQdD_A}Kvk@opBtOqLiWmh@bGqPkP_o@lMoQeSeK`HcG}Au[|Sf@jJpBrJyWfIdVpFyUlPvJ|Cbf@hMcSzMmFxFfIlMsNvjAxk@vOmYlDpQmJhQ|ZxAd@aKhNdPzA}c@uGkMt^}OyLeApMmNyMgBvQiOuII?{RzPpBvPc^rExI~g@}AcMkb@~s@v_@`G}YrEzPfIkK|Mza@tX|TRsn@hIxNbFmL~h@cEoLW`L{^yLs[lqBnj@ft@qe@ddA{F~eC|r@nbBaEfsF`aBdyBna@tlHrgEf_AvTbz@jrDdpCvr@_JzaJfb@zaJzTzvN|UlxCf|@`nFpSrsAnnAjtC|w@ng@hoAla@dg@Qj~Ar]pdAvgHdaBxo@ta@txBznE|}DztAthE~gCdhGxlAdaFlqEf}FfzC`rHltAr}BxqEb_Ht]n_B~XjIbWzoAmH|VbxAvCjm@~zAlxAx{Ab~@d`Atj@zpCfeBrQbwH`nJb}@vgAxzAdlDbzAlm@|mAtvA~aCpoD|gDrfEzsFhkF|TxyC~jDtvAbg@y_@tGvm@r}@bfCdsD|xElnAhFnk@xgA`XbhAtZ|]~aBjeBf_A|Yd`Bt`D~EfeBjp@rt@nw@|{@dwBlWjaDtrEbsJnsKxcA~g@dgAvTp_A~fAdv@pjC`fC}_AzbA{vB~MgcDzh@oV||HqlAnrFqyB`sDahAx|@qOvlBpOng@dEjwBuo@~mBzi@x}E~V~aBzBpd@nqBta@|[`y@fJn`@u_@Cyw@pQ{h@aBoe@zSua@`V~j@N~g@f[eAhUp^b^kHrNtq@llAzg@jOto@|h@dCdVwi@pYiCzGgQgT_h@ie@~BmD}c@_ZgScO|A_Heo@zDuN_Ja[~Rq^{G{SfKqBjXvh@lVzBtYvi@ju@|VdMiEeAa`@fKiDI{VbSwMaFmTjHo^wSmuAzSdEe^_hA[kZlTsSb[nTrS}U~q@aBnMwh@rKaHjHii@zUdCcIg`@tB}U|IC`QnYdJ{PaQ_W|TuFxT}w@rHeIl^zHfI_MsGk^dKTbAue@q[mt@vU_ReFce@rp@r]zX}l@gBgWxHwDiAuOvOcc@wJ{VtGsEwH}\\`MlCwD}XnPgUpv@pj@`Jf^`GcByH{KdR}AbXn`BtNdHhQc^lLv^|QtJfZoWpK|LtOcGkE}RzUuDqBaQbZcFbYx`@nj@rWbFuf@hMiEwSeXdImS`^zi@lP\\hw@sw@tUobAzXvZjd@yKjDxv@~Wr{A~Ap`C{NnRqg@_BszA|aAvSzy@}MrdAkz@~UoKpy@i|@|uAek@p`CzGhV`]nIdZ~^\\lQkNtSYh\\wU|t@xClp@uQ|RqHbg@fRftBh}@zmArCh\\}Vz`Ac]xKfBfy@eV~r@mj@|a@}Uvp@oxAzi@cQfSkI~LmDbm@mQv^iAbr@cw@r_@}VjkB~t@hzAnGrq@g\\rwAyOne@nHtd@jE`iCrGpf@t]j_@ChPyQddAiLbFqMxo@il@t|@wRddA|JfgCbTlc@oU|yA_}AxjB{D`]ky@|Hc[fhAeYrBsy@tr@cHtT`NtWgKvkDvMn^jt@lw@B~PyGbSGrs@i[|u@mBp_BocA~nEfF~u@{NtUvJt_Aey@kBoe@_y@{Ku@saAt_@aV`u@rBn\\uIre@|PvEpBxUtMdGj`@riARj]}WtM}\\`}@wGny@aVxg@sAre@yX`bAqo@kCx@luAaKna@|E`j@}XfnAcCjeAwf@jaD|Bnb@_QfKmJhy@se@vaBcR`\\{h@m[oz@xGkS_b@e_@dDwj@mVma@hgAeO{Q_rAiCmn@naAeTjnAg|@f}@c^vx@gYjOsJnb@_h@~[_g@P{h@dR{gAd~@oTaDqWt^iEdt@lMrRwDj[`Nrr@c@v[mo@`vAvDl~@tSvXwXfTk[jt@wUrNcLmIy[|Uc\\biAdAl\\p\\nhAwz@ddAmd@oGuk@lt@|A`|Ahg@|s@rPjv@cCna@dVvd@|ZnJzF|Sj^nWvk@uQlMnMfPkCoAf_A}Rl`@sUdIc[tb@wo@`SoRgLm`@`Jkb@hpAaXncAkc@v\\hDno@gnAbTkK|QcGd`@fCb^a_@tbAdo@hpByTji@uNd`B}o@dNoa@bk@cB|^agBnrApN`dBdz@xoAaI`a@rSfs@qIbo@m@r_@qb@pdArRdm@h^f[iKfgChTve@j[dMzIhRba@c]hLpg@cKxc@s|@p_BhBxi@brAh|@tLl`@jAxh@iRhbAfXdfAEfbA_[f~@ud@`t@}Vzv@wa@hMkI|a@eCz_@hJ|JaKtx@lKjz@mg@rYaR|a@aPjcA}Zt`@{Kjz@~Tn_CeHb\\rGd\\{oAjxDhFha@bOh\\v~@|G~B|l@~jAznBwS~g@~DnG~TbC|m@|t@nt@wVhw@n|Aba@rXmLvf@vUt{@oJxt@dCxTsQsGgWjKyXhy@k_@t`@sOfz@_Ta@gOtRc{@joDjSx^ry@p_@}NheAwQ`e@|ZfzAJfx@~Zrv@eG~OnBjf@lJjd@hNlHpnAkk@`Kyc@f@{j@|LcJbZpElh@m_Bz^qd@lCa]th@{|@|eAn}@}Blh@`Jht@v[rU{e@~w@bVnhAmXni@jEz^`g@vu@jK~k@vQnHfh@bv@eCz]fm@fZjRoLxLjEtIbXp@`m@xZtn@p_@nD~n@kc@~PYxd@ln@kSzhBbFff@vN`HtXpiAtBvg@jSpd@jMhrA{Th@c]xg@kKnd@q_@zEwZtj@eQkD{BwTaTnN{Nrp@dItm@|[na@iCpfAuPcj@o`AePqQf`@yfAlhAgDza@|El`@pa@~ZpKfh@vb@hd@eGjQxD`t@_rA|vAKpPv^jaAiL|L{\\k^gc@kEySbZkHuPjCeXtf@mL_KeVoW`EuY|fA`Ob}A_MvK}SmCcc@mh@sMlQcBhj@`XjzAyP~_@iKvDsr@iW{]|lAsMrHqOcD_Zqy@}KiA{JnSl@fa@uJbk@oz@oR_Rlb@pAne@xErb@w\\z]~Fv[kLtxBlBpe@htAfgDfPL~PdxB_AdVySfB{RhVmQntAwf@zOmE|j@t`@zUlaAoMhBzo@|i@b]he@vC|_@jq@kNv_@`In_@po@pe@aTdlArGha@qm@zdAeLx{Ai]bhA{Dr}@{TrVs^{AgKhSmNrqAiKrHwJjp@e_@tu@qBrl@~GnTaJd~AjV_]pBp]ePxn@aQpJ`@vY`LpOpk@rCd@ab@hJsOj[dQzX_@vIvPih@dXaTvw@pKpWhe@aAtN`NrOzg@fLv~AwB|p@y[fKsn@wAy[t_@~Al[|f@jL`P~h@s@v^cQtb@|Cvk@oJzi@fE~MuHl}@|FfQzt@tYpZhA}O_uAtvAt~@he@c[x`@}BxvA~N|r@fz@uAzb@sn@r`Bb@nzBnb@nZaSvzAyP|CtKf]cFnc@xNbJpKtv@ma@|_AfTlm@jUnF`R~y@{Axq@j[x^da@vDxZr^LxsAfPuQdJfe@zw@es@leA`pB_XoF}r@`k@wS?}CvMvI~Wp]fAbA~S~_@xQvEp[hMyItn@dd@~NiLti@lYh~@yBls@df@x\\xr@v\\dO~`@vv@~QjIzt@e@dj@nRpv@cZvQlBlOba@~lAbw@~q@C`StPtj@iHlGeTfRnNb_@oGvEbfAmLjm@uf@dx@sSbpAc\\vg@gMtBuO~o@uHhhAygAzvAaf@uP{i@byBsa@dr@pJ~_AaOnhCaKvb@|CjRsPxq@hGni@}Ble@lVdp@|Exq@lfAgKnRnTbRmBxXfvAh^xZe@rPvc@pbAxOjD{AhqBlFlg@hN~UoS`EoDfe@w]xZr@ni@|JrPie@|kApl@`mAwDjbAmb@lb@mOv_Bqs@h\\kh@it@qq@_Myc@bNX{O_O_W{f@a_@{Feh@wt@ea@wf@tIeJeTo[{@qO}{@eWwXkM{eBki@nR_iA||@}Bl~A}PbJga@uB{qBygA}bArc@qy@~KoHjMwQwBoZuToF{Uuc@hEek@}Lc[nJeq@~x@apBxGoZxL}z@kI{HbxAqCtu@r^ddCxRx]lpAbhAd`@~iAk[bFyEbOjF`ZqKcEyKbPjE`F}LpAbExPqG}EVdPkStKpIpGeHdHTfVqHrAhEzOiFuHOnQmK~HdDdGeGnA`EjIqGrHlJ~KiLxFfFtMmItG~@|Q{HrA~Ab[eLlZrFrHoKzDxAzm@mKvLbJ`f@_NsAhDjUiHpInO~C_JzPbJdUo`Bul@wdAiw@k_@nbAmn@@mGsVw^gGwQ`Jtp@~`BbPlvAsZt`@gMQo^ru@jBft@tOjm@ic@nDa}@ltA{SkLwd@lTsIpUyb@vUzEbEiRlVuu@sCyv@hPmaAhu@g^xGcRbg@cYaB}_@b_@y}C|Q_iA_KzCxl@eJ~\\km@vj@Y`pAgPf\\aVlwAws@h}@qj@ef@q_Axl@~PtlAgQdg@nBdMjo@hYhWgRlRhRhRbfAcArp@rUrnAre@pR`_@aDxh@tn@YjWrN|e@_Afc@~[nnA|z@aL|Xzi@du@kKbe@dNzPtVd@b_BpMbvAjJrU`CjaAmRX}MjRwAr_@jTvaAtAhi@kLbfAjTni@_Bb`AdFpUrWcA|gBnlDji@{CrKuQvd@nHfV`o@z^gV|OxYlaAli@dY~AvMsk@`ScFzy@lQjTvb@fMtBaSp}@zU``A~rAhoAhPuBbd@gk@`^~Mxl@qe@hXv{@oX`iAh}@ziCX~OaZbb@kK`n@vJ|]lQfHjN`bAkEtpAee@vYsFjPh@dh@i_@pLqK`tB|a@|N{Kjc@mCh`At\\zKnb@dn@rP}IdHnGjZfs@`Ljy@kNbkAhIv\\}Pfs@oChjAtRd|@s]hg@cKzLo]iK{MdUaXjDet@ciBmx@uSeN``@ek@fd@_MgFiOdSef@nJaRxpAyqA{`@a[bIiZab@cd@z{@mJ{Oet@gReVkk@ab@bBsWv[nAbS}P~MoVlp@Gpa@s\\dOcOhaBna@rqEeMb`AdDdeAgUpu@jNnrAe@rNeFiC_Anu@u^bb@k[mm@sc@vBaHcR~EkO{T_o@cnAgJiVh}@cYvA}MjSLtf@iLjK}e@{@oYbZgVwIwj@dSyN{Uau@gVhAd|@y_@p[i`@hIyv@kFsX`a@gb@aHom@dR}OlYea@yAufAbk@ef@kQwq@lOah@oTmh@la@gAr~@wa@xeArA~^fL|dA{MhOjo@dpAdAt~@{YvP}Sds@jHpg@cD|e@{XqDiX~SoZw@fCdb@uYaMeO|VyLyJcLhbBvPjnA_LlQ~Md|@{e@hGiFxr@~Rrd@aTt@aGjaAwOja@qL[cHbYiStOkBtYkVwUcVjOmjB{Q_T|T_Nnz@qMvP}e@uEmy@|WmXtb@ie@tLqUn`@oc@_Lgm@jg@_[v@qUlp@i]tMgh@gAy_AjpAeh@x@cgAw}Byg@zc@qB{_@yR_QuEcjA_[qJk\\fh@gGvu@dDh~@cOxBoXv}@wNmJk\\zb@qJm@{`@kn@kVjOwuAox@}Lvf@mOoKcFhLwIgOes@lSjVpqAwp@n{A^la@fSwUvO`Ofo@rB`Q_l@|g@rt@zBlTzMhCQb[kGvDhHdCyH|IbI|PuPxZuCdtAxFPmC`K_E_Fr@dTmI|GxJbJuS|NhQx[mJpAiF|`@oZ~Kc`@zbB}e@lVkCjnB_`@zo@Zv\\o}@fLuAfy@pFjU|SfaDaIz}A_ItPnBr`@gl@ziAmKbtBuTb]xy@}J`Iec@qJ}b@d]y_@vHpJoDbp@dO|EvNkx@o@j_@bYt\\yHtf@}Qj@cArRpl@dBtj@zm@~BtZoRtQk^~aB}GwHyTfI@ly@us@xp@kKyDyDnTo`AmOawApa@ag@lxFdTh{AeZzl@iwAxAwhAjl@hTlrAqYrRcIhk@Rr|@xIkCHpc@`\\[vX}U|XtYtRplAkx@`r@gM|bA_UrIaChSnWlwAaOjHeYxaA{dAd~@cQtGqn@u|@qy@rlB{jAmVoJlT|@pt@iNlfAo^kInAzVig@zK`DfiAiYnViAv_@qPfc@z]nxAbe@nu@tFvi@zu@iHfj@rMtg@g[nEwYoFs\\k\\gZsA}MwL]nLwyBjx@}[r`@~d@rOkXzTfC^~VfLvHtS}\\h_@n@wTfs@_NhJz@|lD{n@tPd]~~Azs@ld@wV`sA|B~YjSzUOxo@frBztCdp@bl@~LptAiUxyBnn@hbC_r@vj@zCx\\cQzLRtSwXfDC`n@ua@h_@zNrUeYzn@_{@o`Aco@fx@_FzqCuJxv@iTn@mH`QxJrTaQ~TO|o@ua@|d@sMm^yM_Ek[~Ka@p`@qNhBw[aXsHvOs\\eD_BrN{Mi@`BpMaOt`@{LgCYiLgE~PwJv@v@fZwFkIoOdUmJ_\\cGdReLcOjBhP_HoB}E~YuTjI_FoI_JlSkPh@_Ozc@`BfP{Jp@dAjJeb@dv@ax@cHwjB|_DeOxr@}@xsAfxAhh@kb@tzAgLvgAkiAdh@iKsE{d@n[eh@dnC{J~BaDjc@yv@t^ycA`qAi{@}s@cGoSo@m~AjKmd@uYc^}@se@_Nkg@oIikCy^otAfG}XqSsbCmH_GqSlIgMeg@al@lCiS}l@iSEqDyi@pX_`AvAwg@cSgj@cG_`AaX`Ekd@uNo]nTm|Ass@g~BbyFkcBwDw\\wu@esA}r@yKo]oUgC}FkUyHdCeI`JeAzXhFtBcIlXpCzReMhZh@|Z_yArf@aOtTeo@pgEjlA}Kp|@xJfWsKpPpRzKn_@f]d_@dE`k@~X|ZfLhf@nk@fk@fItw@dNhSdi@dcCbE`d@eF|c@gPpP}Ct[cYpAuX|b@nEvdAln@|hBqDtUtDhlBwOfoAsKn`@x@ryB|DhjBv[~aBoApRtNr_@oOpl@ly@aE`U~Ll_@`_B}Np|@}ZpKqZ{TyxAt`AxTfuAkb@vd@uRrhAhChnChb@vUnjAIaEb[vGfr@{bAfh@_[eCoYpe@wWk`As\\vTyf@eI}c@_^mU{MmVr^}FndAc{@uQUio@}NiJyQpGxFlaCjh@~|ArQtmCoUtwAej@nfA{VpeBa^d^}]laAoZbw@efA|~@mg@liAcdAtKadA_\\}VdzBvVp[rN|hBjUb`@eH~^~Exu@ktAvzBnAtlAoeAdAuFtu@pAlhBtVnPeVbvA{FbbBgp@jzAkB|q@ae@ha@J`d@tPb]{c@`m@mSbp@|n@f|ApMny@qUjPe\\bp@sp@dkBwg@vuCqXfZk]n{@xIvy@`Zh`@yChh@~I~`@|e@nA`Uf_@xZq@nb@dh@z`@eAza@~u@lVxAeFoTpd@ss@ne@koBrk@kv@wImq@fMgW`W`D|Os]vNlCtcAs_@jd@fYhP{W|xAo`ApUyn@lZfEn\\kKpO~X|r@k^vMuGdKoa@hNPdLw^lCe|@oIeEoIcf@jo@{_@lc@o{BoC{k@~DqKhc@uEhEe`@liB}cAfcAxThk@zh@bWzr@hT{InV_n@`p@mCzDsVvbAgnApR`i@`l@bi@`TxbBicAnf@mj@b~@gp@~IyRvZle@fqAfTdIfa@m\\~Ufm@jUpNnFle@qIn^j@nbByOn`@mCbe@bUbtBjXnBnMdy@bSlVpy@x@xXpPdOj_AeFhs@uQpGaVf`AyPrPjYbdAhEzM`[kCvSr}@bd@xQkT|d@fCvVdu@hn@lOr\\hyAvS~u@dj@na@dv@ze@eFz]v|A~e@rlAwG|ZxBlc@~yAneApSh\\tgAl_@bu@rnBsKdkBi_@taAqd@lxC}MlkAfDzn@q{@ts@qX`eAol@bLaIfs@yRjUqSx[hAbd@oM`y@gSu[uQ|ZuUq_@sQjn@eNgBch@llBc{@pOgd@cb@uY`ToCzSwYaJkk@~ZySeOkUhEqQc_@km@fQaHx\\aLySwSwBsOne@ai@~Ps@dRyV|[q_@tR`Htr@_Jnf@qWrc@{XdYeYkHcFrc@_P|ImLsGsOnJxAxu@_VpVoCzWyg@lPaCh^gb@jJk|@~rAySaHePbT_P\\ky@peB{`@lKod@jr@g[~GeYrg@vBnkBh@lQdYlZ~D|d@e{@fcBcsAdq@u[|`Aii@vT_Vo\\oc@t@yVaNgVrZkSeG_`@pWsCrVlGb\\wKdXdPnm@gYn{A~Jry@kQdr@hBbXlJ~`@taA`o@xNn^Vfp@wu@bJaQtt@uNpMc_@cHsi@bZLnlAyOlSyKDaHk[gd@mEeXteAcVlJgCpOvJhj@x_@fs@_ZbfAqTwUqjArYqPxc@tClb@qS`OeOoQck@_@}i@qe@sSqjAtE_Zz[vBdYyRwDcl@sb@{PwK`U_R~@uXn|@yPmWbDqcAoUa@oO|UcCcJnVm|@q[clAyc@jh@sh@c{@Vae@bYsVmCie@wQr^wSbFaJoQxBgMpHx@zOe_AwEa]vIwa@sd@gb@cf@wC~A{XoRqo@y_@nQii@_LaHqx@jXohAlV_JNiWbWkb@mCwWmPwBnGiSef@{mA}lA__AuUikA_c@yo@wJya@{JwIeTj^}FeHom@vbA}c@crCet@x@c^hMqSfZw[aCNyeBy_AysCkj@zH}zBh~BwVp~@{k@|o@yGr`AugA|vAmX`McLyGkAvILvZwfA`cA`Izf@eFp]_\\hJg]|`@aYrDaDjNi@fi@kXnjAfLxp@lLrEhSro@aJl\\lA~cB{DdMyh@tJlBfp@yCxu@jF~]yZbrC`Wp[hdBvu@hhAjBbHbKlJoHrRxRzPnlCfSrk@yGfr@e^{Cod@~Reb@dh@kq@jhC|Npv@k`@j^_Hxg@{QdLd@hz@bJ~SqMzIaFrWaGtUtCbP`{@tc@|@zc@bb@rZvl@djB~zApo@|q@nNnVqEjTlMi[dsAp`BbnBgI``@qc@`WsCh[nLlOoc@loBmQrXyIu@ul@ccAyn@}uCoR`a@oFpo@{p@lRiMd[wWoX_OhIyi@eEah@`W_WdOuWiDoDj^uU`Tag@kB}r@jsCnA~gAxYzoA~Ad`Afc@~c@_Wrh@z\\doA|ZffCbYpEoS`oCcj@qM_gDpkAyIx]qyAhdBgqBqK_k@hkAwa@|T|Ddp@zJjx@c@|n@|c@~O|Zpz@_GrxBpn@z{Bm@`a@cSjc@jLpmCwOj`A{Pfh@k|@n\\gLxUsKrmAmRns@mDxkB{ZpzBcO`Lq[lUwWxnAsOtzCxPb{AcZvqBvE|_AxMlcAiuAdrAdOlkBiO`qA_d@~j@gY~{@oR|nA}QjCgKtfA`PnrAjRr[j`A`c@x`AvfArb@~y@tE`w@wNp\\hAlb@aUz]uUuUscA~Dmf@nf@oSuNqKi`@aDnKuU}K_OfXw\\aKsKyXcNnW_mA|Wye@fp@_x@`h@hBnUoSj[vFhCmB`KwJJdCxKeObNdFzE_FpZ`DhVaOxAjDtMqK|YjA`l@sIx^a|AtkBs`@zNgy@`oAkULej@tDa|@~b@{YsAi\\|Vm_@oP}j@rJ{VkQiPug@aUaOaVgv@qf@aUq`@zXs]zwAou@ySop@rRsHn|BxGra@qf@fx@}MaXyL~[aFuGuP|P{Mc_@wI`c@rOdv@dBrx@xTfb@cBlt@`Ybo@`ZiTrTbr@mN|iA{Tht@oLaY}\\uI_eDl`@lHpUd_@ftCtxBjeAv@ao@hMgGoAvd@~Htn@}R`o@`Kl`BcOhZaw@~W_PgTwGmd@wSgB{Pxr@rC~[eMlu@bGlDJ`m@yQ}@}Fvo@}KlEgKxKmD|r@`{@dAvDzqBaDzVqOtNsFmMy\\lOh@zVaK|HtFt`@yEfJ|FxTlc@lLdBj`@bf@jhAeI|hA`ZxHbfBn`BbL}c@v|@k{AuSmQq_@uvAl]}^`z@eXf_@sh@t@tZ|Vzg@jnAk[vh@fMpViGtUre@lc@|]rMbO~Dr_@z`@dd@zg@_a@rHiUbi@iCoA{n@dh@laAvb@uAhRlO~MkWxoAkTfo@{BiBd~A`m@njDkMbeAk_@taAkg@`~EQlHxt@`Qum@t}AsMtr@Mhi@~h@pS`Jjs@mHls@rFlg@cWly@pM`p@wUhXq`@`Kok@qTgvAclC_}@mr@oh@i`BqYwS_cAqf@}P}uA}`@ec@kh@fFoMdNi|@a\\kJcf@aLvYeYwZkY|DeHmz@aEqa@aLoHof@jGq`@mKwKpPs_@x@sOyRpFi[iG}XisA{v@wa@iGuEvTwKrC_L{MtHmNiQjCWwRsN|KiBcb@gVaRwB|M}K}IkZ_TeJpUwIuI_IfGqDsKtEwGsY_JMaY}R_U_@oSip@`Iao@gr@{U]a@zSyHrAsf@ciAyy@bSqAyVsNhAaFkYaXlFiDrNoHiUe]_@od@~c@iEuRaH|FoPyOePzIaJkKbHkM[aWwYmk@_KgI}EzQkx@yJ{{@de@sFsc@ad@o[im@th@w^fF_`@qiA{XnUuv@il@oRtBuj@`T}\\gz@gON_G`g@_^V{Ue`@}Mu@sClReMn@gJcm@oJfFqVqLgf@nLw\\u|@sKqCuE~RkLca@gMhLcMkJ`Dm]{QiZem@ls@~MhT_IdPmSaI{Cw_@gM_D{Hcl@ob@hMkPsM{TdH}CaMoQmPsT`n@{_@yEc]bTuf@sGw@nSiN`EuV~l@iA|y@sYkI{SlGsOvc@q^sNqDrVmRvQm@`]kNd[y]cCqEnl@qWnG_FrQoc@pHqJ~Pe~AtHoPjSlA|a@kJpLuG{DuGgq@cNcWoSr@oZmc@_Z~w@oCp_@cQN}XdZs_@oEiPvM_I``@oK}ZcAkg@a\\hG_k@~w@gN{b@c_@gOud@`QgT}J_[rm@oQc\\tHym@qx@cTwXtl@al@vXg`@|i@k]uBip@~l@gK`kCsk@bKgT`w@g@tu@|Jpx@wMnf@qTrWzRlbBwb@`e@hD|uAq~@piBoXpLeGvo@yNn_@tHvn@kt@xj@yCzd@kN`P|Cvr@sG~WzC`g@gGbjAsZp^|Gxy@mS`o@kC|l@ia@ph@{YBiSjPu`@__@m`@`LwX~b@iGxk@um@h_@exAkiB{w@uYsj@a{@iM{x@sWuJmSmo@}_@wXafA~Jkv@~|@q^sPoo@rKu]eJ{g@v]}u@ki@gRvZoQzBwt@b`@gIdn@cLvP_XiN_]jOcAtq@gdBniDoTf`Aay@jbAk_@rNsR~z@{bAle@{[~b@sm@{V{\\bNwRwg@kIzGiKr~@{I~Kk`@_Yme@}Awd@tMg\\gDwLpUiy@h]wJpw@cTdLzBzdAuHvi@yKhMpBx`@uHvSwkAjo@eV|j@sd@dAoU{S{m@rQoXee@vNi^}AcVeo@dDg@wQpPkKj@iPaM{@{]r^k_@yZ_DqoAwk@o~@{Ksz@m]iOyKqc@ew@cKaVgl@uTcGzDoeAs\\`@aDmf@oe@kpAoLmDi\\pRge@qs@aj@wOaNuReo@zKu[iV{Dm`@g_@ui@o{@oKwU`N_Kx_@im@|b@ykAhRwOeL[c\\_Pm[qtA__@gn@nl@m[_eAsb@eHez@gzAmb@|D}Ogp@ieAqH{TjXwl@|Aqi@ajAk^oJcZdW_~AbvAyr@`iBy[vtCqx@nmA}l@bb@kz@wKu`C~[{wB{qCm`@sMsaAhYcw@vpAc]lQa]aTal@uvAgb@kc@ahBc[ka@wTmPjHsf@l}@el@~Wi`@dr@ch@tpE}@fnAev@jvD_DdnBmNxh@wu@|^cVb~@oRfPy_@O{i@kz@eXeC}h@zh@_s@tKyf@nzA}~@oHs{@|o@yc@nRehBwCed@bK}rBrfByf@uIufA_aAudAzOw\\wHm]eXc[wl@sUakCyj@gj@o}AklCkiAqTq|@{eB_i@oc@cXeDii@pa@il@|iB{x@bO{|@fd@sWMy`Aww@kfAiTajAcgCyXgFmVxOga@fuAic@jz@_nAb`@}_Af`Amd@heBkv@hfBenAxiFwZjnBybAvlCo`@`bBmf@jz@}s@bQaSpTkOt_@gHdtAoQb_@so@jMqa@f^c\\r`A}`Avt@}wAhcC_dA|~@wWzmA_~@ns@aXzsAqp@pjB_QhgBmr@nxCmcBdjDq_AzjAo]tbA{_@bUch@nw@oNjdAwK|hFiPhfBz@hx@{ZjqAmy@tk@wf@Kku@yi@uhCcmDkrAiWmmA|x@u`BhLaiBdn@ygAiH_j@``@}z@a]iMgc@aIynAis@ug@eKgX_YsgBwo@kkBkF{fAsUs|@iDcm@um@k}AoMsr@qj@_{@y}@coC{{@e~Aac@ia@ie@adAy]gzAc_@om@ubBslAaZaDcm@wm@ys@gUygB}A}r@kv@auBgPgaAia@c|A`dByzAh]k|@{Tqd@e]cvAwOgSit@iJqsAoWyg@_mAqOgdAknA}h@mgAgo@cNib@qd@ue@ow@ue@fGob@|[qKyDsIfuCg`Dhf@mi@tq@y`B_u@odA~j@mgAbQsh@`~Ay_Bw^og@hBujAxa@yvA`fAek@r[{rC`\\a~AaS{t@xBqDrqAmbEfWim@zTyo@jsCidCtdAg\\iUmk@zTsj@z}@wm@aHqK~[}gAieAm_ClFwiEwYmAlc@}bBbiDqvCsDmZtb@_A|i@mStHgf@s`Ae{@yNq\\fv@cfAdq@ad@wDsFeYeOjUwvDc\\_Q~GwUgKax@`h@qtB_gBe`BrgAopNtsJorAaRyxBlRsf@bs@oWgJyGv~BiL?oIcc@SkfB}oAgvB~b@_nCl@mlCkLie@qi@bDtY{`@|b@oKb~@yoHfBy~Ca]oiE{VggB}_A_jEghA{sCehCa~Eog@kuEwbAurEqi@coD{hA{vIiSofBe}@moEqo@ehCcHcRaJrIdFoP}PchBok@iiEegC}eVgpByhNsdC_~Nc^wrE}_C_ePo~AupLux@_bEaM}b@oKsA|G_HsF}pAmbAejPwf@_bGsD{zIcb@}nDm|@myDg]gw@yRzDzMeRlBifDawAckQygBmaOmz@kwE_t@kwDci@edF}v@cwUgg@e|Hgh@wwEm}@ugGefBmoHesBciGadAy_CulEwtIezD_wGo`CcaDmqB}wBs~Ae~AmYfMpHcd@oHij@ub@s{@c[cXoxEqlEy|Cw}ForAiyDcqA{oCuTe_AwdBg~Lay@ekKcHuqD";

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var MapBrowser = Class.extend({
	retina: false,
	map: false,
    options: [],
	$station: false,
	chartDataCache: {},
    selectedOption: false,
	selectedStation: -1,
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
			position: google.maps.ControlPosition.LEFT_BOTTOM
		},
		zoomControlOptions: {
			style: google.maps.ZoomControlStyle.SMALL,
			position: google.maps.ControlPosition.LEFT_TOP
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
		fillColor: "#f4f5f6",
		fillOpacity: 1,
		strokeOpacity: 0.5,
		strokeColor: "#444499",
		strokeWeight: 1
	}),
	plCenter: [51.986797406813125, 19.32958984375001],
	plZoom: 6,
	rankingOption: 'latest',
	loadDelay: 400,

	init: function ($menu, $station, $worstPlaces, $bestPlaces, $dateRangeChartModal, $rankingButtons, $appLogo, $morePlacesModal) {

		var self = this,
			center = self.plCenter,
			zoom = self.plZoom;

		self.$station = $station;
		self.$worstPlaces = $worstPlaces;
		self.$bestPlaces = $bestPlaces;
		self.$dateRangeChartModal = $dateRangeChartModal;
		self.$morePlacesModal = $morePlacesModal;
		self.$rankingButtons = $rankingButtons;
		self.$appLogo = $appLogo;

		self.$appLogo.append('<div class="spinner" style="display: none;"><div class="bounce1"></div> <div class="bounce2"></div><div class="bounce3"></div></div>');

		self.$spinner = self.$appLogo.find('.spinner').first();

		self.$rankingButtons.on('click', 'a', function() {
			self.rankingOption = $(this).data('optionValue');
			self.updatePlaces(self.selectedOption);
		});

		self.$worstPlaces.on('click', 'a.showMorePlaces', function() {
			self.showMorePlacesModal(
				$(this).data()
			);

			return false;
		});

		self.$bestPlaces.on('click', 'a.showMorePlaces', function() {
			self.showMorePlacesModal(
				$(this).data()
			);

			return false;
		});

        $menu.find('li a').each(function() {
            var href = $(this).attr('href'),
                text = $(this).text();

            self.options.push({
                $a: $(this),
                short: href.substr(1),
                text: text.trim(),
				stations: []
            });
        });

		$menu.find('li a').click(function() {
			for(var o = 0; o < self.options.length; o++) {
				var href = $(this).attr('href'),
					short = href.substr(1);
				if(self.options[o].short == short) {
					self.setSelectedOption(o);
					return false;
				}
			}

			return false;
		});

        //self.setSelectedOption(0);

		self.div = $('#mapBrowser');
		self.map_div = self.div.find('.map');
		self.sidebar = $('.app-sidebar');
		self.menu = self.sidebar.find('.app-list');


		self.mapOptions.center = new google.maps.LatLng(center[0], center[1]);
		self.mapOptions.zoom = zoom;

		// construct google map
		self.map = new google.maps.Map(self.map_div.get(0), self.mapOptions);

		// settings Poland borders to display
		self.mapBorder.setMap(self.map);
		if (window.devicePixelRatio > 1.5) {
			self.retina = true;
		}

		this.loadStations();
	},

	showMorePlacesModal: function(data) {
		var self = this,
			headers = {
				'worst': 'Najbardziej',
				'most': 'Najmniej',
				'best': 'Najmniej',
				'least': 'Najbardziej'
			},
			$h3 = self.$morePlacesModal.find('.modal-header h3').first(),
			$body = self.$morePlacesModal.find('.modal-body').first(),
			text = headers[data['placesType']];

		$body.html(self.getSpinnerDOM());
		$h3.html(text + ' zanieczyszczone miejsca');

		if(self.rankingOption == 'latest') {

			var h = ['<div class="block places"><section class="content">'];

			var optStations = self.options[self.selectedOption]['stations'];
			optStations.sort(function(a, b) {
				return a.value == b.value ? 0 : a.value > b.value ? 1 : -1;
			});

			if(text == 'Najbardziej') {

				for(var s = optStations.length - 1; s >= 0; s--) {
					var station = optStations[s];
					for(var m = 0; m < stations.length; m++) {
						if(stations[m].id == station.id) {
							var v = Math.round( station.value * 100 ) / 100;
							h.push('<div class="place"><a href="#" class="title setStationAction" data-station-index="' + m + '"><span class="glyphicon glyphicon-map-marker"></span>' + stations[m].nazwa + '<span class="v">' + v + ' ' + self.getUnitDOMByShort(self.options[self.selectedOption]['short']) + '</span></a></div>');
							break;
						}
					}
				}

			} else {

				for(var s = 0; s < optStations.length; s++) {
					var station = optStations[s];
					for(var m = 0; m < stations.length; m++) {
						if(stations[m].id == station.id) {
							var v = Math.round( station.value * 100 ) / 100;
							h.push('<div class="place"><a href="#" class="title setStationAction" data-station-index="' + m + '"><span class="glyphicon glyphicon-map-marker"></span>' + stations[m].nazwa + '<span class="v">' + v + ' ' + self.getUnitDOMByShort(self.options[self.selectedOption]['short']) + '</span></a></div>');
							break;
						}
					}
				}

			}

			h.push('</section></div>');
			$body.html(h.join(''));

		} else {

			$.get('/srodowisko/ranking.json?param=' + self.options[self.selectedOption]['short'] + '&option=' + self.rankingOption + '&limit=x', function(res) {

				var h = ['<div class="block places"><section class="content">'],
					key = (text == 'Najbardziej' ? 'least' : 'most'),
					data = res[key];

				if(data.length == 0) {
					h.push('<div class="place text-center">Brak danych</div>');
 				} else {
					for (var d = 0; d < data.length; d++) {
						for (var m = 0; m < stations.length; m++) {
							if (data[d]['srodowisko_pomiary']['station_id'] == stations[m].id) {
								var v = Math.round(parseFloat(data[d]['srodowisko_pomiary']['value'] || data[d][0]['val']) * 100) / 100;
								h.push('<div class="place"><a href="#" class="title setStationAction" data-station-index="' + m + '"><span class="glyphicon glyphicon-map-marker"></span>' + stations[m].nazwa + '<span class="v">' + v + ' ' + self.getUnitDOMByShort(self.options[self.selectedOption]['short']) + '</span></a></div>');
								break;
							}
						}
					}
				}

				h.push('</section></div>');
				$body.html(h.join(''));
			});

		}

		self.$morePlacesModal.modal('show');
	},

    setSelectedOption: function(optionIndex) {
        var self = this;

        if(self.selectedOption !== false) {
            if(self.options.hasOwnProperty(self.selectedOption)) {
                self.options[self.selectedOption].$a.parent().removeClass('active');
            }
        }

        if(self.options.hasOwnProperty(optionIndex)) {
			var option = self.options[optionIndex];
			option.$a.parent().addClass('active');

			if(option.stations.length === 0) {
				self.$spinner.show();
				var short = option.short.replace('_', '.');
				$.get('/srodowisko/dane.json?param=' + short, function(res) {
					self.options[optionIndex].stations = res.stations;
					self.setOptionMarkers(optionIndex);
					self.updatePlaces(optionIndex);
					self.$spinner.hide();
				});
			} else {
				self.setOptionMarkers(optionIndex);
				self.updatePlaces(optionIndex);
			}

            self.selectedOption = optionIndex;
        }
    },

	setOptionMarkers: function(optionIndex) {
		var self = this;
		if(self.options.hasOwnProperty(optionIndex)) {
			var option = self.options[optionIndex],
				min = Number.MAX_VALUE,
				max = Number.MIN_VALUE;

			for(var o = 0; o < option.stations.length; o++) {
				if(option.stations[o].value < min)
					min = option.stations[o].value;
				if(option.stations[o].value > max)
					max = option.stations[o].value;
			}

			var diff = max - min,
				per = diff / 100;

			for(var s = 0; s < stations.length; s++) {
				var found = false;
				for(o = 0; o < option.stations.length; o++) {
					if(stations[s].id == option.stations[o].id) {
						var color = Math.ceil(option.stations[o].value / per);
						stations[s].marker.setIcon(
							self.getIcon(
								3,
								color
							)
						);

						if(stations[s].marker.map === null)
							stations[s].marker.setMap(self.map);

						stations[s].color = color;
						stations[s].stat = {
							min: min,
							max: max,
							value: option.stations[o].value
						};

						found = true;
						break;
					}
				}

				if(found === false) {
					stations[s].marker.setIcon(self.getIcon(3));
					stations[s].marker.setMap(null);
					stations[s].color = false;
					stations[s].stat = undefined;
				}
			}

			self.setStation(self.selectedStation);
		}
	},

	updatePlaces: function(optionIndex) {
		var self = this,
			s, h, m,
			optStations, station;

		if(self.rankingOption == 'latest' && self.options.hasOwnProperty(optionIndex)) {
			optStations = self.options[optionIndex]['stations'];
			optStations.sort(function(a, b) {
				return a.value == b.value ? 0 : a.value > b.value ? 1 : -1;
			});

			h = [];
			for(s = 0; s < 10; s++) {
				station = optStations[s];
				for(m = 0; m < stations.length; m++) {
					if(stations[m].id == station.id) {
						var v = Math.round( station.value * 100 ) / 100;
						h.push('<div class="place"><a href="#" class="title setStationAction" data-station-index="' + m + '"><span class="glyphicon glyphicon-map-marker"></span>' + stations[m].nazwa + '<span class="v">' + v + ' ' + self.getUnitDOMByShort(self.options[self.selectedOption]['short']) + '</span></a></div>');
						break;
					}
				}
			}

			h.push('<div class="place text-center"><a href="#" class="title showMorePlaces" data-places-type="best" data-places-option="' + self.rankingOption + '">więcej &nbsp;<span class="caret"></span></a></div>');

			self.$bestPlaces.html(h.join(''));

			h = [];
			for(s = optStations.length - 1; s > optStations.length - 11; s--) {
				station = optStations[s];
				for(m = 0; m < stations.length; m++) {
					if(stations[m].id == station.id) {
						var v = Math.round( station.value * 100 ) / 100;
						h.push('<div class="place"><a href="#" class="title setStationAction" data-station-index="' + m + '"><span class="glyphicon glyphicon-map-marker"></span>' + stations[m].nazwa + '<span class="v">' + v + ' ' + self.getUnitDOMByShort(self.options[self.selectedOption]['short']) + '</span></a></div>');
						break;
					}
				}
			}

			h.push('<div class="place text-center"><a href="#" class="title showMorePlaces" data-places-type="worst" data-places-option="' + self.rankingOption + '">więcej &nbsp;<span class="caret"></span></a></div>');

			self.$worstPlaces.html(h.join(''));

		} else {

			if(self.options.hasOwnProperty(self.selectedOption)) {

				var rankingOptions = [{
					key: 'most',
					list: self.$bestPlaces
				}, {
					key: 'least',
					list: self.$worstPlaces
				}];

				for(var rrr = 0; rrr < rankingOptions.length; rrr++) {
					rankingOptions[rrr].list.html('<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
				}

				$.get('/srodowisko/ranking.json?param=' + self.options[self.selectedOption]['short'] + '&option=' + self.rankingOption, function(res) {

					for(var rOpt = 0; rOpt < rankingOptions.length; rOpt++) {

						if(res.hasOwnProperty(rankingOptions[rOpt]['key'])) {
							var rankingOption = rankingOptions[rOpt],
								data = res[rankingOption['key']],
								html = [];

							if(data.length == 0) {
								rankingOption.list.html('<p class="help-block margin-sides-15">Brak danych</p>');
								continue;
							}

							for(var d = 0; d < data.length; d++) {
								for(m = 0; m < stations.length; m++) {
									if(data[d]['srodowisko_pomiary']['station_id'] == stations[m].id) {
										var v = Math.round( parseFloat(data[d]['srodowisko_pomiary']['value'] || data[d][0]['val']) * 100 ) / 100;
										html.push('<div class="place"><a href="#" class="title setStationAction" data-station-index="' + m + '"><span class="glyphicon glyphicon-map-marker"></span>' + stations[m].nazwa + '<span class="v">' + v + ' ' + self.getUnitDOMByShort(self.options[self.selectedOption]['short']) + '</span></a></div>');
										break;
									}
								}
							}

							html.push('<div class="place text-center"><a href="#" class="title showMorePlaces" data-places-type="' + rankingOptions[rOpt]['key'] + '" data-places-option="' + self.rankingOption + '">więcej &nbsp;<span class="caret"></span></a></div>');

							rankingOption.list.html(html.join(''));
						}
					}
				});
			}
		}

		$('body').on('click', '.setStationAction', function() {
			self.setStation(parseInt($(this).data('stationIndex')));
			return false;
		});

	},

	loadStations: function() {

		var self = this;

		for (var i = 0; i < stations.length; i++) {

			var s = stations[i];

			var marker = new google.maps.Marker({
				title: i.toString(),
				position: {
					lat: Number(s.lat),
					lng: Number(s.lng)
				},
				icon: self.getIcon(3),
				map: null
			});

			marker.addListener('click', function() {
				var index = parseInt(this.title);
				self.setStation(index);
			});

			stations[i]['marker'] = marker;

		}
		
		if( location.hash.length ) {

			var hash = location.hash.substr(1);
			var params = hash.split('&'),
				options = {},
				index = false;

			for(var p = 0; p < params.length; p++) {
				var parts = params[p].split('=');
				if(parts.length === 2) {
					options[parts[0]] = parts[1];
				}
			}

			var def = true;
			if(options.hasOwnProperty('param')) {
				var param = options['param'];
				index = false;

				for(var o = 0; o < self.options.length; o++) {
					if(self.options[o]['short'] == param) {
						index = o;
						break;
					}
				}

				if(index) {
					self.setSelectedOption(index);
					def = false;
				}
			}

			if(def === true) {
				self.setSelectedOption(0);
			}

			if(options.hasOwnProperty('station_id')) {
				var station_id = parseInt(options['station_id']);
				index = false;

				for(var _s = 0; _s < stations.length; _s++) {
					if(stations[_s]['id'] == station_id) {
						index = _s;
						break;
					}
				}

				if(index)
					this.setStation(index);
			}
			
		}

	},

	getSpinnerDOM: function() {
		return '<div class="spinner grey"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
	},

	setStation: function(stationIndex) {
		var self = this;

		if(self.selectedStation !== false && self.selectedStation !== -1) {
			var color = undefined;
			if(typeof stations[self.selectedStation].color != 'undefined') {
				if(stations[self.selectedStation].color !== false) {
					color = stations[self.selectedStation].color;
				}
			}

			stations[self.selectedStation].marker.setIcon(
				self.getIcon(3, color)
			);
		}

		if(stationIndex === -1) {

			var short = self.options[self.selectedOption]['short'];
			short = short.replace('.', '_');
			location.hash = '#param=' + short;
			
			self.$station.html('<p class="blank_msg">Wybierz stacje pomiarową na mapie aby zobaczyć szczegóły</p>');

			self.map.setZoom(self.plZoom);
			self.map.setCenter(new google.maps.LatLng(self.plCenter[0], self.plCenter[1]));
			self.selectedStation = -1;			
			
		} else if(stations.hasOwnProperty(stationIndex)) {

			var station = stations[stationIndex];

			location.hash = '#param=' + self.options[self.selectedOption]['short'] + '&station_id=' + station.id;
			
			this.map.setZoom(10);
		    this.map.setCenter(station.marker.getPosition());
			
			var col = undefined;
			if(typeof stations[stationIndex].color !== 'undefined') {
				if(stations[stationIndex].color !== false) {
					col = stations[stationIndex].color;
				}
			}

			stations[stationIndex].marker.setIcon(
				self.getIcon(5, col)
			);

			var option = self.options[self.selectedOption];

			var h = [
				'<h1>',
					'<span class="glyphicon glyphicon-map-marker"></span>',
					'<button type="button" class="close pull-right resetSelectedStation" aria-label="Close"><span aria-hidden="true">&times;</span></button>',
					station.nazwa,
				'</h1>'
			];

			if(typeof station.stat != 'undefined' && station.stat !== false) {


				var date = '';
				for(var s = 0; s < option.stations.length; s++) {
					if(option.stations[s].id == station.id) {
						date = option.stations[s].time;
						break;
					}
				}

				if(date == '')
					date = '2016-03-07T09:00:00';

				var dates = date.split('T');
				date = dates[0] + ' ' + dates[1];

				var v = Math.round( station.stat.value * 100 ) / 100;
				var unit = self.getUnitDOMByShort(option['short']);
				var t = date;
				
				h.push('<p class="param">Stężenie ' + self.getDopelniaczbyShort(option['short']) + ' w powietrzu:</p>');
				
				h.push('<p class="value">' + v + ' <span class="unit">' + unit + '</span></p>');
				h.push('<p class="desc">Stan na ' + t + '</p>');
				
				h.push('<div class="chart-buttons"><ul class="nav nav-tabs"><li><a href="#h" data-toggle="tab" data-timestamp="h">Ostatnie godziny</a></li><li class="active"><a href="#d" data-toggle="tab" data-timestamp="d">Ostatnie dni</a></li><li><a href="#home" data-toggle="tab">Wybierz zakres...</a></li></ul></div>');
				h.push('<div class="chart">' + self.getSpinnerDOM() + '</div>');
				h.push('<p class="param-desc"><a href="#">Dowiedz się więcej o tym wskaźniku &raquo;</a></p>');
				
			} else {
				h.push([
					'<p class="help-block">',
						'Brak danych',
					'</p>'
				].join(''));
			}


			self.$station.html(h.join(''));

			self.$station.find('.resetSelectedStation').click(function() {
				self.setStation(-1);
			});

			self.$station.find('ul.nav.nav-tabs li a').click(function() {
				var timestamp = $(this).data('timestamp');
				if(typeof timestamp == 'undefined') {

					$('#datepicker').bootstrapDP({
						language: 'pl',
						orientation: 'auto top',
						format: "yyyy-mm-dd",
						autoclose: true
					});

					self.$dateRangeChartModal.modal('show');
					self.$station.find('.chart').first().html(self.getSpinnerDOM());
					self.$dateRangeChartModal.find('.applyDateRange').click(function() {
						var dateFrom = $('#datepicker input[name="start"]').first().val(),
							dateTo = $('#datepicker input[name="end"]').first().val(),
							timestamp = dateFrom + '_' + dateTo;

						self.updateChart(station.id, option.short, timestamp);
						self.$dateRangeChartModal.modal('hide');
					});

				} else {
					self.updateChart(station.id, option.short, timestamp);
				}
			});

			self.updateChart(station.id, option.short, 'd');
			self.selectedStation = stationIndex;
		}
	},

	getUnitDOMByShort: function(short) {
		return (short == 'CO' ? 'm' : '&micro;') + 'g/m<sup>3</sup>';
	},

	getDopelniaczbyShort: function(short) {
		switch(short) {
			case 'C6H6':
				return 'benzenu';
			break;

			case 'NO2':
				return 'dwutlenku azotu';
			break;

			case 'O3':
				return 'ozonu';
			break;

			case 'PM10':
				return 'pyłu PM10';
			break;

			case 'PM2_5':
				return 'pyłu PM2.5';
			break;

			case 'SO2':
				return 'dwutlenku siarki';
			break;

			default:
				return 'czadu';
			break;
		}
	},

	updateChart: function(station_id, short, timestamp) {
		var self = this;

		var $chart = self.$station.find('.chart').first();
		$chart.html(self.getSpinnerDOM());

		self.getChartData(station_id, short, timestamp, function(data) {

			if(data.length === 0) {
				$chart.html('<p class="help-block">Brak danych</p>');
				return true;
			}

			$chart.highcharts({
				chart: {
					animation: false,
					backgroundColor: null,
					height: 230
				},
				title: {
					text: ''
				},
				credits: {
					enabled: false
				},
				xAxis: {
					type: 'datetime'
				},
				yAxis: {
					title: {
						text: null
					}
				},
				legend: {
					enabled: false
				},
				series: [{
					type: 'area',
					name: short,
					data: data,
					tooltip: {
						valueDecimals: 5
					},
					animation: false
				}]
			});
		});
	},

	getChartData: function(station_id, param, timestamp, success, empty) {
		var key = station_id + '_' + param + '_' + timestamp,
			self = this;
		if(this.chartDataCache.hasOwnProperty(key)) {
			success(this.chartDataCache[key]);
		} else {
			param = param.replace('_', '.');
			$.get('/srodowisko/chart.json?station_id=' + station_id + '&param=' + param + '&timestamp=' + timestamp, function(res) {
				var data = [];
				for(var r = 0; r < res.length; r++) {
					var s = res[r]['srodowisko_pomiary']['timestamp'],
						ss = s.split(' '),
						d = ss[0].split('-'),
						value = 0;

					if(typeof res[r][0] == 'undefined') {
						value = res[r]['srodowisko_pomiary']['avg'];
					} else {
						value = res[r][0].avg;
					}

					value = parseFloat(value);

					if(timestamp == 'd') {

						data.push([
							Date.UTC(d[0], parseInt(d[1]) - 1, d[2]),
							value
						]);

					} else if(timestamp == 'h') {

						var hours = ss[1].split(':');

						data.push([
							Date.UTC(d[0], parseInt(d[1]) - 1, d[2], parseInt(hours[0])),
							value
						]);

					} else {

						data.push([
							Date.UTC(d[0], parseInt(d[1]) - 1, d[2]),
							value
						]);

					}
				}

				self.chartDataCache[key] = data;
				success(self.chartDataCache[key]);
			});
		}
	},

	getGreenToRed: function(percent) {
		var r = percent<50 ? 255 : Math.floor(255-(percent*2-100)*255/100);
		var g = percent>50 ? 255 : Math.floor((percent*2)*255/100);
		return 'rgb('+r+','+g+',0)';
	},

	getIcon: function(scale, color) {
		if(typeof color !== 'undefined') {
			color = this.getGreenToRed(100 - color);
		}

		return {
			path: google.maps.SymbolPath.CIRCLE,
			scale: scale * 2.5,
			fillColor: color || '#3b83c5',
			strokeColor: '#AAA',
			strokeWeight: 1,
			fillOpacity: 0.7
		};
	},

});

var mapBrowser;

$(document).ready(function () {

	$.fn.bootstrapDP = $.fn.datepicker.noConflict();

	mapBrowser = new MapBrowser(
        $('ul.app-list').first(),
		$('.stationContent').first(),
		$('#worst-places').find('section').first(),
		$('#best-places').find('section').first(),
		$('#dateRangeChartModal'),
		$('.ranking-buttons').first(),
		$('.app-logo').first(),
		$('#morePlacesModal')
    );

});
