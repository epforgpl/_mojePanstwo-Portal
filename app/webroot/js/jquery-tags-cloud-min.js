(function (a) {
    function b(b, c) {
        var h, i, j, k, l, m, p, r, s, t, w, x, E, e = jQuery.extend({}, {
            width: b.width(),
            height: b.height(),
            hwratio: 1,
            enable: !0,
            draggable: !0,
            gravitydriven: !1,
            template: 1,
            maxspeed: 4,
            attenuation: .01,
            perspective: .4,
            sensitivityx: .05,
            sensitivityy: .05,
            fadein: 800,
            fog: .5,
            zsort: !0,
            fps: 60,
            fpsmobile: 30,
            scale: 1,
            imgscale: 0,
            onclick: function () {
            }
        }, c), f = 0, g = 0, n = 0, o = 0, q = 0, u = -1, v = -1, y = !1, z = !1, A = !1, B = {}, C = null, D = 0;
        Date.now === void 0 && (Date.now = function () {
            return (new Date).getTime()
        });
        var F = Date.now(), G = function () {
            b.attr("unselectable", "on").css({
                "-moz-user-select": "none",
                "-o-user-select": "none",
                "-khtml-user-select": "none",
                "-webkit-user-select": "none",
                "-ms-user-select": "none",
                "user-select": "none"
            }).each(function () {
                a(this).attr("unselectable", "on").bind("selectstart", function () {
                    return !1
                })
            }), b.find("img").bind("dragstart", function (a) {
                a.preventDefault()
            }), tb(), r = b.children(""), s = r.length, t = Array(), C = "ontouchstart"in document.documentElement ? !0 : !1, p = C ? 30 / e.fpsmobile : 60 / e.fps, E = Math.round(1e3 / (C ? e.fpsmobile : e.fps)), b.css("position", "relative").css("padding", "0px"), r.css("position", "absolute"), N(), L(), db(), K(), e.fadein > 1 && b.hide().fadeIn(e.fadein), a(window).resize(function () {
                H(), clearTimeout(x), x = setTimeout(H, 100)
            }), H(), O(), r.bind("click", J)
        }, H = function () {
            e.width = b.width(), e.height = e.width * e.hwratio, b.height(e.height), Z()
        };
        if (b[0].style.opacity === void 0)var I = function (b, c) {
            a(r[b]).css({opacity: c})
        }; else var I = function (a, b) {
            r[a].style.opacity = b
        };
        var J = function (b) {
            if (C && D > 1e3)return b.stopPropagation(), b.preventDefault(), void 0;
            if (e.fog > 0 && .05 > a(this).css("opacity"))return b.stopPropagation(), b.preventDefault(), void 0;
            if (f = 0, g = 0, F = Date.now() + 500, "function" == typeof e.onclick) {
                var c = a(this).data("onclick");
                e.onclick(c)
            }
        }, K = function () {
            var a, b = 0;
            if (l = 1, m = 1, hb = 0, ib = 0, 0 == e.template) {
                N();
                for (var c = 0; s > c; c++)b = Math.max(b, t[c].x * t[c].x + t[c].y * t[c].y + t[c].z * t[c].z)
            } else for (var c = 0; s > c; c++)"function" == typeof e.template ? (a = e.template(c, s), a.h !== void 0 && (m = a.h), a.v !== void 0 && (l = a.v)) : a = fb(c, s), b = Math.max(b, a.x * a.x + a.y * a.y + a.z * a.z), t[c].x = a.x * (1 - .2 * m), t[c].y = a.y * (1 - .2 * l), t[c].z = .8 * a.z;
            if (b > 1 || 1 != e.scale) {
                b = b > 1 ? e.scale / Math.sqrt(b) : e.scale;
                for (var c = 0; s > c; c++)t[c].x *= b, t[c].y *= b, t[c].z *= b
            }
            M(), Z()
        }, L = function () {
            for (var b, c = 0; s > c; c++)b = a(r[c]), t[c].w = b.width() / 2, t[c].h = b.height() / 2
        }, M = function () {
            for (var b = 0; s > b; b++)a(r[b]).css("z-index", b).data("ztemp", b), t[b].o = 1
        }, N = function () {
            for (var a, b, c = 0; s > c; c++) {
                t[c] = {}, b = lb(c, s, !1), a = parseFloat(jQuery(r[c]).data("x")), t[c].x = isNaN(a) ? b.x : a / 100, a = parseFloat(jQuery(r[c]).data("y")), t[c].y = isNaN(a) ? b.y : a / 100, a = parseFloat(jQuery(r[c]).data("z")), t[c].z = isNaN(a) ? b.z : a / 100;
                var d = jQuery(r[c]).data("lock");
                void 0 != d ? ("string" == typeof d && (d = d.replace(/^\s+|\s+$/g, "").toLowerCase()), "false" != d && 0 != d && "no" != d && (t[c].locked = !0)) : t[c].locked = !1, t[c].img = jQuery(r[c]).is("img")
            }
        }, O = function () {
            C || (b.unbind("mousemove mousedown mouseup mouseleave", R), 1 == e.enable && b.bind("mousemove mouseleave", R), 1 == e.draggable && b.bind("mousedown mouseup", R)), P(), C && (b.unbind("touchstart touchend touchmove", R), 1 == e.draggable && b.bind("touchstart touchend touchmove", R))
        }, P = function () {
            "DeviceOrientationEvent"in window && (window.removeEventListener("deviceorientation", R), 1 == e.gravitydriven && window.addEventListener("deviceorientation", R))
        }, Q = function (a) {
            var b = null, c = null;
            if (C) {
                "touchstart" != a.type && a.preventDefault();
                var d = a.originalEvent.touches[0] || a.originalEvent.changedTouches[0];
                b = d.pageX, c = d.pageY
            } else b = a.clientX, c = a.clientY;
            return {x: b, y: c}
        }, R = function (c) {
            switch (c.type) {
                case"touchmove":
                case"mousemove":
                    if (F + E > Date.now())return;
                    A = !1;
                    var d = Q(c);
                    if (y) {
                        var h = -(d.x - B.x) / e.width * Math.abs(e.sensitivityx) * p, i = (d.y - B.y) / e.height * Math.abs(e.sensitivityy) * p;
                        "mousemove" == c.type ? (f = h, g = i) : (f += h, g += i)
                    } else if (!z) {
                        if (0 != e.sensitivityx) {
                            var j = a("html").scrollLeft();
                            j || (j = a("body").scrollLeft());
                            var k = d.x - b.offset().left + j;
                            k > e.width ? k = e.width : 0 > k && (k = 0), f = (k / e.width - .5) * e.sensitivityx * p
                        } else f = 0;
                        if (0 != e.sensitivityy) {
                            var j = a("html").scrollTop();
                            j || (j = a("body").scrollTop());
                            var l = d.y - b.offset().top + j;
                            l > e.height ? l = e.height : 0 > l && (l = 0), g = (-l / e.height + .5) * e.sensitivityy * p
                        } else g = 0
                    }
                    z || V(), Z(), F = Date.now();
                    break;
                case"deviceorientation":
                    if (F + 3 * E > Date.now() || z || y)return;
                    if (Math.round(c.gamma) != n || Math.round(c.beta) != o) {
                        n = Math.round(c.gamma), o = Math.round(c.beta);
                        var k = 0, l = 0;
                        switch (window.orientation) {
                            case 90:
                                k = -Math.max(-.5, Math.min(.5, o / 90)), l = Math.max(-45, Math.min(45, n + 20)) / 90;
                                break;
                            case 180:
                                k = Math.max(-.5, Math.min(.5, n / 90)), l = Math.max(-45, Math.min(45, o + 20)) / 90;
                                break;
                            case-90:
                                k = Math.max(-.5, Math.min(.5, o / 90)), l = -Math.max(-45, Math.min(45, n - 20)) / 90;
                                break;
                            case 0:
                            default:
                                (-90 > n || n > 90) && (n = Math.abs(c.gamma) / c.gamma * (180 - Math.abs(c.gamma))), k = -Math.max(-45, Math.min(45, n)) / 90, l = -Math.max(-45, Math.min(45, o - 20)) / 90
                        }
                        f = 5 * k * Math.abs(e.sensitivityx) * p, g = 5 * -l * Math.abs(e.sensitivityy) * p, A = !1, V(), Z()
                    }
                    F = Date.now();
                    break;
                case"touchstart":
                    window.removeEventListener("deviceorientation", R);
                case"mousedown":
                    if (D + 2 * E > Date.now())return;
                    B = Q(c), y = !0, z = !1, V(), $(), "mousedown" == c.type && (1 != e.enable && b.bind("mouseleave", R), b.unbind("mouseup mousemove", R).bind("mouseup mousemove", R).css("cursor", "move")), D = Date.now();
                    break;
                case"touchend":
                    D = Date.now() - D, A = !0;
                case"mouseup":
                    if ("mouseup" == c.type)b.unbind("mouseup", R).css("cursor", "auto"), e.enable || (b.unbind("mousemove mouseleave", R), A = !0); else if (D > 500) {
                        var d = Q(c);
                        10 > Math.abs(d.x - B.x) && 10 > Math.abs(d.y - B.y) && (f = 0, g = 0, $())
                    }
                    y = !1, (0 != f || 0 != g) && (V(), z = !0, clearTimeout(w), w = setTimeout(U, 900), Z());
                    break;
                case"mouseleave":
                    b.unbind("mouseup", R).css("cursor", "auto"), A = !0, e.enable || (b.unbind("mousemove mouseleave", R), y = !1)
            }
        }, S = function () {
            .001 > Math.abs(f) && .001 > Math.abs(g) && ($(), Date.now() > F && P(), q = 0);
            for (var a, c, b = 1, d = 0; s > d; d++)if (1 != t[d].locked && (W(t[d]), e.fog > 0 && (b = t[d].z + (1 - e.fog), (b > 0 || 0 >= b && t[d].o > 0) && (t[d].o = b, I(d, b))), b > 0))if (a = Y(t[d]), e.imgscale > 0 && t[d].img) {
                c = t[d].z * e.imgscale + 1;
                var h = t[d].w * c, i = t[d].h * c;
                h = 1 > h ? 0 : h, i = 1 > i ? 0 : i, ab(d, a.x - h, a.y - i), bb(d, h, i)
            } else ab(d, a.x - t[d].w, a.y - t[d].h);
            if (1 == e.zsort && (0 == q % 5 && (q -= 5, cb()), q++), e.attenuation > 0 && A) {
                var j = (1 - e.attenuation) * T(f, g);
                f *= j, g *= j, V()
            }
        }, T = function (a, b) {
            var c = Math.abs(a) + Math.abs(b);
            return c > .02 ? 1 : .98
        }, U = function () {
            z = !1
        }, V = function () {
            (0 == e.sensitivityx || 0 == m) && (f = 0), (0 == e.sensitivityy || 0 == l) && (g = 0);
            var a = Math.sqrt(f * f + g * g);
            a > .01 * e.maxspeed && (a = .01 * e.maxspeed / a, f *= a, g *= a), h = Math.cos(f), i = Math.cos(g), j = Math.sin(g), k = Math.sin(f)
        }, W = function (a) {
            var b = a.z * h + a.x * k;
            a.x = a.x * h - a.z * k, a.z = b * i - a.y * j, a.y = b * j + a.y * i
        }, Y = function (a) {
            var b = .5 * (a.z * e.perspective + 1);
            return {x: (a.x * b + .5) * e.width, y: (a.y * b + .5) * e.height}
        }, Z = function () {
            _(), -1 == u && (V(), u = setInterval(S, E))
        }, $ = function () {
            clearInterval(u), u = -1
        }, _ = function () {
            -1 != v && (clearTimeout(v), v = -1)
        }, ab = function (a, b, c) {
            r[a].style.left = (0 | b) + "px", r[a].style.top = (0 | c) + "px"
        }, bb = function (a, b, c) {
            r[a].style.width = (0 | 2 * b) + "px", r[a].style.height = (0 | 2 * c) + "px"
        }, cb = function () {
            for (var b = [a(r[0]).data("ztemp")], c = 0; s > c; c++) {
                for (var d = c + 1; s > d; d++)0 == c && (b[d] = a(r[d]).data("ztemp")), (t[c].z < t[d].z && b[d] < b[c] || t[c].z > t[d].z && b[c] < b[d]) && (b[s] = b[c], b[c] = b[d], b[d] = b[s]);
                a(r[c]).data("ztemp", b[c]).css("z-index", b[c])
            }
        }, db = function () {
            for (var b, c = [], d = [], e = 0; s > e; e++)t[e].img ? (b = a(r[e]), t[e].img = !1, d[e] = !0) : (b = a(r[e]).find("img"), d[e] = !1), c[e] = b.length, b.each(function () {
                jQuery.data(this, "layerindex", e)
            }).one("load", function () {
                var b = a(this), e = jQuery.data(this, "layerindex");
                if (c[e]--, 0 == c[e]) {
                    var f = a(r[e]);
                    t[e].w = f.width() / 2, t[e].h = f.height() / 2, t[e].img = d[e], b.show(), Z()
                }
            }).each(function () {
                var b = a(this);
                this.complete && this.width > 0 ? b.trigger("load") : b.hide()
            })
        }, eb = function () {
            for (var a = 0; s > a; a++)t[a].img && bb(a, t[a].w, t[a].h)
        }, fb = function (a, b) {
            var c;
            switch (e.template) {
                case 1:
                    c = jb(a, b);
                    break;
                case 2:
                    c = lb(a, b, !0);
                    break;
                case 3:
                    c = lb(a, b, !1);
                    break;
                case 4:
                    c = qb(a, b, !0), m = 0;
                    break;
                case 5:
                    c = qb(a, b, !1), l = 0;
                    break;
                case 6:
                    c = rb(a, b), l = 0;
                    break;
                case 7:
                    c = mb(a, b);
                    break;
                case 8:
                    c = ob(a, b);
                    break;
                case 9:
                    c = pb(a, b);
                    break;
                default:
                    c = gb()
            }
            return c
        }, gb = function () {
            return {x: 2 * Math.random() - 1, y: 2 * Math.random() - 1, z: 2 * Math.random() - 1}
        }, hb = 0, ib = 0, jb = function (a, b) {
            if (0 == a)return kb(Math.PI, 0);
            if (a == b - 1)return kb(0, 0);
            b = 2 > b ? 2 : b;
            var c = 1 - 1 / (b > 3 ? b - 3 : b), d = .5 * (b + 1) / (b > 3 ? b - 3 : b), e = -1 + 2 * (c * (a + 1) + d - 1) / (b - 1), f = Math.sqrt(1 - e * e);
            return c = Math.acos(e), d = (ib + 2 * (3.6 / Math.sqrt(b)) / (hb + f)) % (2 * Math.PI), hb = f, ib = d, kb(c, d)
        }, kb = function (a, b) {
            var c = Math.cos(a), d = Math.sin(a) * Math.cos(b), e = Math.sin(a) * Math.sin(b);
            return {x: d, y: e, z: c}
        }, lb = function (a, b, c) {
            b = a > b ? a : b;
            var h, d = c ? .8 * Math.PI / b : Math.PI / b, e = .1 * Math.PI;
            return c ? kb(a * d + e, 10 * a * d + e) : (h = Math.random() * b, e = 2 * Math.random() * b, kb(h * d, e * d))
        }, mb = function (a, b) {
            b = a > b ? a : b;
            var c = Math.sin(2 * Math.PI * a / b), d = Math.cos(2 * Math.PI * a / b);
            return {x: c, y: d, z: 0}
        }, ob = function (a, b) {
            b = a > b ? a : b;
            var c = .25 * Math.PI + 2 * Math.PI * (a % 4) / 4, d = 4 * Math.ceil((a + 1) / 4) / b, e = d * Math.sin(c), f = d * Math.cos(c);
            return {x: e, y: f, z: 0}
        }, pb = function (a, b) {
            b = a > b ? a : b;
            var d, e, c = 8 * a / b;
            return 2 > c ? (d = c - 1, e = -1) : 4 > c ? (d = 1, e = c - 3) : 6 > c ? (d = 5 - c, e = 1) : (d = -1, e = 7 - c), {
                x: d,
                y: e,
                z: 0
            }
        }, qb = function (a, b, c) {
            var d = 1, e = 4.4 * Math.PI / b, f = 2 * (a / b - .5) / d, g = Math.cos(a * e) / d, h = Math.sin(a * e) / d;
            return {x: c ? f : h, y: c ? h : f, z: g}
        }, rb = function (a, b) {
            var c = 1, d = 6 * Math.PI / b, e = 2 * (Math.pow(a / b, .8) - .5) / c, f = a * Math.cos(a * d) / (b * c), g = a * Math.sin(a * d) / (b * c);
            return {x: g, y: e, z: f}
        }, sb = function (a) {
            var b = a.toLowerCase();
            if (b == "false" + "" || b == "no" + "")return !1;
            if (b == "true" + "" || b == "yes" + "")return !0;
            var c = parseFloat(a);
            return 0 == isNaN(c) ? c : a
        }, tb = function () {
            0 >= e.width && (e.width = 150), 0 >= e.height && (e.height = 150), 0 > e.fog && (e.fog = 0), 1 > e.fps && (e.fps = 1), 1 > e.fpsmobile && (e.fpsmobile = 1), 0 >= e.hwratio && (e.hwratio = 1), 0 > e.maxspeed && (e.maxspeed = 0), 0 > e.attenuation ? e.attenuation = 0 : e.attenuation > 1 && (e.attenuation = 1), 0 > e.fadein && (e.fadein = 0), 0 > e.scale ? e.scale = 0 : e.scale > 1 && (e.scale = 1)
        };
        this.option = function (c, d) {
            if (c !== void 0) {
                if (c = c.replace(/^\s+|\s+$/g, ""), e[c] === void 0)return b;
                if (d === void 0)return e[c];
                var h = e[c];
                if ("string" == typeof d ? (d = d.replace(/^\s+|\s+$/g, ""), e[c] = sb(d)) : ("boolean" == typeof d || "number" == typeof d || "function" == typeof d) && (e[c] = d), h === e[c])return;
                tb(), "enable" == c || "draggable" == c ? O() : "gravitydriven" == c ? P() : "template" == c ? e.fadein > 1 ? b.fadeOut(e.fadein, function () {
                    $(), K(), Z(), b.fadeIn(e.fadein)
                }) : K() : "scale" == c ? (f = 0, g = 0, K()) : "fps" == c || "fpsmobile" == c ? (p = C ? 30 / e.fpsmobile : 60 / e.fps, E = Math.round(1e3 / (C ? e.fpsmobile : e.fps)), $(), Z()) : "width" == c ? (b.width(e.width), e.hwratio = e.height / e.width, H()) : "height" == c ? (b.height(e.height), e.hwratio = e.height / e.width, H()) : "hwratio" == c ? H() : "perspective" == c ? Z() : "imgscale" == c ? 0 == e.imgscale ? eb() : -1 == u && S() : "fog" == c && (0 == e.fog && a(r).css({opacity: 1}), Z())
            }
        }, this.toggleMouse = function () {
            e.enable = !e.enable, O()
        }, this.pause = function (a) {
            -1 != u && ($(), a > 0 && (_(), v = setTimeout(Z, a)))
        }, this.update = function () {
            L(), S()
        }, this.unpause = function () {
            Z()
        }, this.triggerPause = function () {
            -1 != u ? $() : Z()
        }, this.stop = function () {
            f = 0, g = 0, V(), Z()
        }, this.mouseTo = function (a) {
            if ("object" == typeof a) {
                var b = parseFloat(a.x);
                isNaN(b) || (f = e.sensitivityx * b / 100), b = parseFloat(a.y), isNaN(b) || (g = e.sensitivityx * b / 100), A = !0, V(), Z()
            }
        }, this.mouseToRandom = function () {
            f = (.5 - Math.random()) * e.sensitivityx, g = (.5 - Math.random()) * e.sensitivityx, A = !0, V(), Z()
        }, this.reset = function () {
            f = 0, g = 0, K()
        }, this.reinit = function (a) {
            f = 0, g = 0, $(), r.unbind("click", J), b.find("img").unbind(), a !== void 0 && "" != a && b.html(a), G()
        }, G()
    }

    var c = "cloud";
    a.fn[c] = function (d) {
        var f, g, e = arguments;
        if (0 == this.length)return !1;
        if (f = a(this), g = f.data(c)) {
            if (g[d])return g[d].apply(this, Array.prototype.slice.call(e, 1))
        } else if ("object" == typeof d || !d)return f.data(c, new b(f, d))
    }
})(jQuery);