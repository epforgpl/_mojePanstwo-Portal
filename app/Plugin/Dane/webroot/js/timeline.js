//! moment.js
//! version : 2.5.0
//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
//! license : MIT
//! momentjs.com
(function (a) {
    function b(a, b) {
        return function (c) {
            return i(a.call(this, c), b)
        }
    }

    function c(a, b) {
        return function (c) {
            return this.lang().ordinal(a.call(this, c), b)
        }
    }

    function d() {
    }

    function e(a) {
        u(a), g(this, a)
    }

    function f(a) {
        var b = o(a), c = b.year || 0, d = b.month || 0, e = b.week || 0, f = b.day || 0, g = b.hour || 0, h = b.minute || 0, i = b.second || 0, j = b.millisecond || 0;
        this._milliseconds = +j + 1e3 * i + 6e4 * h + 36e5 * g, this._days = +f + 7 * e, this._months = +d + 12 * c, this._data = {}, this._bubble()
    }

    function g(a, b) {
        for (var c in b)b.hasOwnProperty(c) && (a[c] = b[c]);
        return b.hasOwnProperty("toString") && (a.toString = b.toString), b.hasOwnProperty("valueOf") && (a.valueOf = b.valueOf), a
    }

    function h(a) {
        return 0 > a ? Math.ceil(a) : Math.floor(a)
    }

    function i(a, b, c) {
        for (var d = Math.abs(a) + "", e = a >= 0; d.length < b;)d = "0" + d;
        return (e ? c ? "+" : "" : "-") + d
    }

    function j(a, b, c, d) {
        var e, f, g = b._milliseconds, h = b._days, i = b._months;
        g && a._d.setTime(+a._d + g * c), (h || i) && (e = a.minute(), f = a.hour()), h && a.date(a.date() + h * c), i && a.month(a.month() + i * c), g && !d && cb.updateOffset(a), (h || i) && (a.minute(e), a.hour(f))
    }

    function k(a) {
        return "[object Array]" === Object.prototype.toString.call(a)
    }

    function l(a) {
        return "[object Date]" === Object.prototype.toString.call(a) || a instanceof Date
    }

    function m(a, b, c) {
        var d, e = Math.min(a.length, b.length), f = Math.abs(a.length - b.length), g = 0;
        for (d = 0; e > d; d++)(c && a[d] !== b[d] || !c && q(a[d]) !== q(b[d])) && g++;
        return g + f
    }

    function n(a) {
        if (a) {
            var b = a.toLowerCase().replace(/(.)s$/, "$1");
            a = Qb[a] || Rb[b] || b
        }
        return a
    }

    function o(a) {
        var b, c, d = {};
        for (c in a)a.hasOwnProperty(c) && (b = n(c), b && (d[b] = a[c]));
        return d
    }

    function p(b) {
        var c, d;
        if (0 === b.indexOf("week"))c = 7, d = "day"; else {
            if (0 !== b.indexOf("month"))return;
            c = 12, d = "month"
        }
        cb[b] = function (e, f) {
            var g, h, i = cb.fn._lang[b], j = [];
            if ("number" == typeof e && (f = e, e = a), h = function (a) {
                    var b = cb().utc().set(d, a);
                    return i.call(cb.fn._lang, b, e || "")
                }, null != f)return h(f);
            for (g = 0; c > g; g++)j.push(h(g));
            return j
        }
    }

    function q(a) {
        var b = +a, c = 0;
        return 0 !== b && isFinite(b) && (c = b >= 0 ? Math.floor(b) : Math.ceil(b)), c
    }

    function r(a, b) {
        return new Date(Date.UTC(a, b + 1, 0)).getUTCDate()
    }

    function s(a) {
        return t(a) ? 366 : 365
    }

    function t(a) {
        return a % 4 === 0 && a % 100 !== 0 || a % 400 === 0
    }

    function u(a) {
        var b;
        a._a && -2 === a._pf.overflow && (b = a._a[ib] < 0 || a._a[ib] > 11 ? ib : a._a[jb] < 1 || a._a[jb] > r(a._a[hb], a._a[ib]) ? jb : a._a[kb] < 0 || a._a[kb] > 23 ? kb : a._a[lb] < 0 || a._a[lb] > 59 ? lb : a._a[mb] < 0 || a._a[mb] > 59 ? mb : a._a[nb] < 0 || a._a[nb] > 999 ? nb : -1, a._pf._overflowDayOfYear && (hb > b || b > jb) && (b = jb), a._pf.overflow = b)
    }

    function v(a) {
        a._pf = {
            empty: !1,
            unusedTokens: [],
            unusedInput: [],
            overflow: -2,
            charsLeftOver: 0,
            nullInput: !1,
            invalidMonth: null,
            invalidFormat: !1,
            userInvalidated: !1,
            iso: !1
        }
    }

    function w(a) {
        return null == a._isValid && (a._isValid = !isNaN(a._d.getTime()) && a._pf.overflow < 0 && !a._pf.empty && !a._pf.invalidMonth && !a._pf.nullInput && !a._pf.invalidFormat && !a._pf.userInvalidated, a._strict && (a._isValid = a._isValid && 0 === a._pf.charsLeftOver && 0 === a._pf.unusedTokens.length)), a._isValid
    }

    function x(a) {
        return a ? a.toLowerCase().replace("_", "-") : a
    }

    function y(a, b) {
        return b._isUTC ? cb(a).zone(b._offset || 0) : cb(a).local()
    }

    function z(a, b) {
        return b.abbr = a, ob[a] || (ob[a] = new d), ob[a].set(b), ob[a]
    }

    function A(a) {
        delete ob[a]
    }

    function B(a) {
        var b, c, d, e, f = 0, g = function (a) {
            if (!ob[a] && pb)try {
                require("./lang/" + a)
            } catch (b) {
            }
            return ob[a]
        };
        if (!a)return cb.fn._lang;
        if (!k(a)) {
            if (c = g(a))return c;
            a = [a]
        }
        for (; f < a.length;) {
            for (e = x(a[f]).split("-"), b = e.length, d = x(a[f + 1]), d = d ? d.split("-") : null; b > 0;) {
                if (c = g(e.slice(0, b).join("-")))return c;
                if (d && d.length >= b && m(e, d, !0) >= b - 1)break;
                b--
            }
            f++
        }
        return cb.fn._lang
    }

    function C(a) {
        return a.match(/\[[\s\S]/) ? a.replace(/^\[|\]$/g, "") : a.replace(/\\/g, "")
    }

    function D(a) {
        var b, c, d = a.match(tb);
        for (b = 0, c = d.length; c > b; b++)d[b] = Vb[d[b]] ? Vb[d[b]] : C(d[b]);
        return function (e) {
            var f = "";
            for (b = 0; c > b; b++)f += d[b]instanceof Function ? d[b].call(e, a) : d[b];
            return f
        }
    }

    function E(a, b) {
        return a.isValid() ? (b = F(b, a.lang()), Sb[b] || (Sb[b] = D(b)), Sb[b](a)) : a.lang().invalidDate()
    }

    function F(a, b) {
        function c(a) {
            return b.longDateFormat(a) || a
        }

        var d = 5;
        for (ub.lastIndex = 0; d >= 0 && ub.test(a);)a = a.replace(ub, c), ub.lastIndex = 0, d -= 1;
        return a
    }

    function G(a, b) {
        var c, d = b._strict;
        switch (a) {
            case"DDDD":
                return Gb;
            case"YYYY":
            case"GGGG":
            case"gggg":
                return d ? Hb : xb;
            case"YYYYYY":
            case"YYYYY":
            case"GGGGG":
            case"ggggg":
                return d ? Ib : yb;
            case"S":
                if (d)return Eb;
            case"SS":
                if (d)return Fb;
            case"SSS":
            case"DDD":
                return d ? Gb : wb;
            case"MMM":
            case"MMMM":
            case"dd":
            case"ddd":
            case"dddd":
                return Ab;
            case"a":
            case"A":
                return B(b._l)._meridiemParse;
            case"X":
                return Db;
            case"Z":
            case"ZZ":
                return Bb;
            case"T":
                return Cb;
            case"SSSS":
                return zb;
            case"MM":
            case"DD":
            case"YY":
            case"GG":
            case"gg":
            case"HH":
            case"hh":
            case"mm":
            case"ss":
            case"ww":
            case"WW":
                return d ? Fb : vb;
            case"M":
            case"D":
            case"d":
            case"H":
            case"h":
            case"m":
            case"s":
            case"w":
            case"W":
            case"e":
            case"E":
                return d ? Eb : vb;
            default:
                return c = new RegExp(O(N(a.replace("\\", "")), "i"))
        }
    }

    function H(a) {
        a = a || "";
        var b = a.match(Bb) || [], c = b[b.length - 1] || [], d = (c + "").match(Nb) || ["-", 0, 0], e = +(60 * d[1]) + q(d[2]);
        return "+" === d[0] ? -e : e
    }

    function I(a, b, c) {
        var d, e = c._a;
        switch (a) {
            case"M":
            case"MM":
                null != b && (e[ib] = q(b) - 1);
                break;
            case"MMM":
            case"MMMM":
                d = B(c._l).monthsParse(b), null != d ? e[ib] = d : c._pf.invalidMonth = b;
                break;
            case"D":
            case"DD":
                null != b && (e[jb] = q(b));
                break;
            case"DDD":
            case"DDDD":
                null != b && (c._dayOfYear = q(b));
                break;
            case"YY":
                e[hb] = q(b) + (q(b) > 68 ? 1900 : 2e3);
                break;
            case"YYYY":
            case"YYYYY":
            case"YYYYYY":
                e[hb] = q(b);
                break;
            case"a":
            case"A":
                c._isPm = B(c._l).isPM(b);
                break;
            case"H":
            case"HH":
            case"h":
            case"hh":
                e[kb] = q(b);
                break;
            case"m":
            case"mm":
                e[lb] = q(b);
                break;
            case"s":
            case"ss":
                e[mb] = q(b);
                break;
            case"S":
            case"SS":
            case"SSS":
            case"SSSS":
                e[nb] = q(1e3 * ("0." + b));
                break;
            case"X":
                c._d = new Date(1e3 * parseFloat(b));
                break;
            case"Z":
            case"ZZ":
                c._useUTC = !0, c._tzm = H(b);
                break;
            case"w":
            case"ww":
            case"W":
            case"WW":
            case"d":
            case"dd":
            case"ddd":
            case"dddd":
            case"e":
            case"E":
                a = a.substr(0, 1);
            case"gg":
            case"gggg":
            case"GG":
            case"GGGG":
            case"GGGGG":
                a = a.substr(0, 2), b && (c._w = c._w || {}, c._w[a] = b)
        }
    }

    function J(a) {
        var b, c, d, e, f, g, h, i, j, k, l = [];
        if (!a._d) {
            for (d = L(a), a._w && null == a._a[jb] && null == a._a[ib] && (f = function (b) {
                var c = parseInt(b, 10);
                return b ? b.length < 3 ? c > 68 ? 1900 + c : 2e3 + c : c : null == a._a[hb] ? cb().weekYear() : a._a[hb]
            }, g = a._w, null != g.GG || null != g.W || null != g.E ? h = Y(f(g.GG), g.W || 1, g.E, 4, 1) : (i = B(a._l), j = null != g.d ? U(g.d, i) : null != g.e ? parseInt(g.e, 10) + i._week.dow : 0, k = parseInt(g.w, 10) || 1, null != g.d && j < i._week.dow && k++, h = Y(f(g.gg), k, j, i._week.doy, i._week.dow)), a._a[hb] = h.year, a._dayOfYear = h.dayOfYear), a._dayOfYear && (e = null == a._a[hb] ? d[hb] : a._a[hb], a._dayOfYear > s(e) && (a._pf._overflowDayOfYear = !0), c = T(e, 0, a._dayOfYear), a._a[ib] = c.getUTCMonth(), a._a[jb] = c.getUTCDate()), b = 0; 3 > b && null == a._a[b]; ++b)a._a[b] = l[b] = d[b];
            for (; 7 > b; b++)a._a[b] = l[b] = null == a._a[b] ? 2 === b ? 1 : 0 : a._a[b];
            l[kb] += q((a._tzm || 0) / 60), l[lb] += q((a._tzm || 0) % 60), a._d = (a._useUTC ? T : S).apply(null, l)
        }
    }

    function K(a) {
        var b;
        a._d || (b = o(a._i), a._a = [b.year, b.month, b.day, b.hour, b.minute, b.second, b.millisecond], J(a))
    }

    function L(a) {
        var b = new Date;
        return a._useUTC ? [b.getUTCFullYear(), b.getUTCMonth(), b.getUTCDate()] : [b.getFullYear(), b.getMonth(), b.getDate()]
    }

    function M(a) {
        a._a = [], a._pf.empty = !0;
        var b, c, d, e, f, g = B(a._l), h = "" + a._i, i = h.length, j = 0;
        for (d = F(a._f, g).match(tb) || [], b = 0; b < d.length; b++)e = d[b], c = (h.match(G(e, a)) || [])[0], c && (f = h.substr(0, h.indexOf(c)), f.length > 0 && a._pf.unusedInput.push(f), h = h.slice(h.indexOf(c) + c.length), j += c.length), Vb[e] ? (c ? a._pf.empty = !1 : a._pf.unusedTokens.push(e), I(e, c, a)) : a._strict && !c && a._pf.unusedTokens.push(e);
        a._pf.charsLeftOver = i - j, h.length > 0 && a._pf.unusedInput.push(h), a._isPm && a._a[kb] < 12 && (a._a[kb] += 12), a._isPm === !1 && 12 === a._a[kb] && (a._a[kb] = 0), J(a), u(a)
    }

    function N(a) {
        return a.replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function (a, b, c, d, e) {
            return b || c || d || e
        })
    }

    function O(a) {
        return a.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&")
    }

    function P(a) {
        var b, c, d, e, f;
        if (0 === a._f.length)return a._pf.invalidFormat = !0, a._d = new Date(0 / 0), void 0;
        for (e = 0; e < a._f.length; e++)f = 0, b = g({}, a), v(b), b._f = a._f[e], M(b), w(b) && (f += b._pf.charsLeftOver, f += 10 * b._pf.unusedTokens.length, b._pf.score = f, (null == d || d > f) && (d = f, c = b));
        g(a, c || b)
    }

    function Q(a) {
        var b, c = a._i, d = Jb.exec(c);
        if (d) {
            for (a._pf.iso = !0, b = 4; b > 0; b--)if (d[b]) {
                a._f = Lb[b - 1] + (d[6] || " ");
                break
            }
            for (b = 0; 4 > b; b++)if (Mb[b][1].exec(c)) {
                a._f += Mb[b][0];
                break
            }
            c.match(Bb) && (a._f += "Z"), M(a)
        } else a._d = new Date(c)
    }

    function R(b) {
        var c = b._i, d = qb.exec(c);
        c === a ? b._d = new Date : d ? b._d = new Date(+d[1]) : "string" == typeof c ? Q(b) : k(c) ? (b._a = c.slice(0), J(b)) : l(c) ? b._d = new Date(+c) : "object" == typeof c ? K(b) : b._d = new Date(c)
    }

    function S(a, b, c, d, e, f, g) {
        var h = new Date(a, b, c, d, e, f, g);
        return 1970 > a && h.setFullYear(a), h
    }

    function T(a) {
        var b = new Date(Date.UTC.apply(null, arguments));
        return 1970 > a && b.setUTCFullYear(a), b
    }

    function U(a, b) {
        if ("string" == typeof a)if (isNaN(a)) {
            if (a = b.weekdaysParse(a), "number" != typeof a)return null
        } else a = parseInt(a, 10);
        return a
    }

    function V(a, b, c, d, e) {
        return e.relativeTime(b || 1, !!c, a, d)
    }

    function W(a, b, c) {
        var d = gb(Math.abs(a) / 1e3), e = gb(d / 60), f = gb(e / 60), g = gb(f / 24), h = gb(g / 365), i = 45 > d && ["s", d] || 1 === e && ["m"] || 45 > e && ["mm", e] || 1 === f && ["h"] || 22 > f && ["hh", f] || 1 === g && ["d"] || 25 >= g && ["dd", g] || 45 >= g && ["M"] || 345 > g && ["MM", gb(g / 30)] || 1 === h && ["y"] || ["yy", h];
        return i[2] = b, i[3] = a > 0, i[4] = c, V.apply({}, i)
    }

    function X(a, b, c) {
        var d, e = c - b, f = c - a.day();
        return f > e && (f -= 7), e - 7 > f && (f += 7), d = cb(a).add("d", f), {
            week: Math.ceil(d.dayOfYear() / 7),
            year: d.year()
        }
    }

    function Y(a, b, c, d, e) {
        var f, g, h = new Date(i(a, 6, !0) + "-01-01").getUTCDay();
        return c = null != c ? c : e, f = e - h + (h > d ? 7 : 0), g = 7 * (b - 1) + (c - e) + f + 1, {
            year: g > 0 ? a : a - 1,
            dayOfYear: g > 0 ? g : s(a - 1) + g
        }
    }

    function Z(a) {
        var b = a._i, c = a._f;
        return "undefined" == typeof a._pf && v(a), null === b ? cb.invalid({nullInput: !0}) : ("string" == typeof b && (a._i = b = B().preparse(b)), cb.isMoment(b) ? (a = g({}, b), a._d = new Date(+b._d)) : c ? k(c) ? P(a) : M(a) : R(a), new e(a))
    }

    function $(a, b) {
        cb.fn[a] = cb.fn[a + "s"] = function (a) {
            var c = this._isUTC ? "UTC" : "";
            return null != a ? (this._d["set" + c + b](a), cb.updateOffset(this), this) : this._d["get" + c + b]()
        }
    }

    function _(a) {
        cb.duration.fn[a] = function () {
            return this._data[a]
        }
    }

    function ab(a, b) {
        cb.duration.fn["as" + a] = function () {
            return +this / b
        }
    }

    function bb(a) {
        var b = !1, c = cb;
        "undefined" == typeof ender && (a ? (fb.moment = function () {
            return !b && console && console.warn && (b = !0, console.warn("Accessing Moment through the global scope is deprecated, and will be removed in an upcoming release.")), c.apply(null, arguments)
        }, g(fb.moment, c)) : fb.moment = cb)
    }

    for (var cb, db, eb = "2.5.0", fb = this, gb = Math.round, hb = 0, ib = 1, jb = 2, kb = 3, lb = 4, mb = 5, nb = 6, ob = {}, pb = "undefined" != typeof module && module.exports && "undefined" != typeof require, qb = /^\/?Date\((\-?\d+)/i, rb = /(\-)?(?:(\d*)\.)?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?)?/, sb = /^(-)?P(?:(?:([0-9,.]*)Y)?(?:([0-9,.]*)M)?(?:([0-9,.]*)D)?(?:T(?:([0-9,.]*)H)?(?:([0-9,.]*)M)?(?:([0-9,.]*)S)?)?|([0-9,.]*)W)$/, tb = /(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|S{1,4}|X|zz?|ZZ?|.)/g, ub = /(\[[^\[]*\])|(\\)?(LT|LL?L?L?|l{1,4})/g, vb = /\d\d?/, wb = /\d{1,3}/, xb = /\d{1,4}/, yb = /[+\-]?\d{1,6}/, zb = /\d+/, Ab = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i, Bb = /Z|[\+\-]\d\d:?\d\d/gi, Cb = /T/i, Db = /[\+\-]?\d+(\.\d{1,3})?/, Eb = /\d/, Fb = /\d\d/, Gb = /\d{3}/, Hb = /\d{4}/, Ib = /[+\-]?\d{6}/, Jb = /^\s*\d{4}-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/, Kb = "YYYY-MM-DDTHH:mm:ssZ", Lb = ["YYYY-MM-DD", "GGGG-[W]WW", "GGGG-[W]WW-E", "YYYY-DDD"], Mb = [["HH:mm:ss.SSSS", /(T| )\d\d:\d\d:\d\d\.\d{1,3}/], ["HH:mm:ss", /(T| )\d\d:\d\d:\d\d/], ["HH:mm", /(T| )\d\d:\d\d/], ["HH", /(T| )\d\d/]], Nb = /([\+\-]|\d\d)/gi, Ob = "Date|Hours|Minutes|Seconds|Milliseconds".split("|"), Pb = {
        Milliseconds: 1,
        Seconds: 1e3,
        Minutes: 6e4,
        Hours: 36e5,
        Days: 864e5,
        Months: 2592e6,
        Years: 31536e6
    }, Qb = {
        ms: "millisecond",
        s: "second",
        m: "minute",
        h: "hour",
        d: "day",
        D: "date",
        w: "week",
        W: "isoWeek",
        M: "month",
        y: "year",
        DDD: "dayOfYear",
        e: "weekday",
        E: "isoWeekday",
        gg: "weekYear",
        GG: "isoWeekYear"
    }, Rb = {
        dayofyear: "dayOfYear",
        isoweekday: "isoWeekday",
        isoweek: "isoWeek",
        weekyear: "weekYear",
        isoweekyear: "isoWeekYear"
    }, Sb = {}, Tb = "DDD w W M D d".split(" "), Ub = "M D H h m s w W".split(" "), Vb = {
        M: function () {
            return this.month() + 1
        }, MMM: function (a) {
            return this.lang().monthsShort(this, a)
        }, MMMM: function (a) {
            return this.lang().months(this, a)
        }, D: function () {
            return this.date()
        }, DDD: function () {
            return this.dayOfYear()
        }, d: function () {
            return this.day()
        }, dd: function (a) {
            return this.lang().weekdaysMin(this, a)
        }, ddd: function (a) {
            return this.lang().weekdaysShort(this, a)
        }, dddd: function (a) {
            return this.lang().weekdays(this, a)
        }, w: function () {
            return this.week()
        }, W: function () {
            return this.isoWeek()
        }, YY: function () {
            return i(this.year() % 100, 2)
        }, YYYY: function () {
            return i(this.year(), 4)
        }, YYYYY: function () {
            return i(this.year(), 5)
        }, YYYYYY: function () {
            var a = this.year(), b = a >= 0 ? "+" : "-";
            return b + i(Math.abs(a), 6)
        }, gg: function () {
            return i(this.weekYear() % 100, 2)
        }, gggg: function () {
            return this.weekYear()
        }, ggggg: function () {
            return i(this.weekYear(), 5)
        }, GG: function () {
            return i(this.isoWeekYear() % 100, 2)
        }, GGGG: function () {
            return this.isoWeekYear()
        }, GGGGG: function () {
            return i(this.isoWeekYear(), 5)
        }, e: function () {
            return this.weekday()
        }, E: function () {
            return this.isoWeekday()
        }, a: function () {
            return this.lang().meridiem(this.hours(), this.minutes(), !0)
        }, A: function () {
            return this.lang().meridiem(this.hours(), this.minutes(), !1)
        }, H: function () {
            return this.hours()
        }, h: function () {
            return this.hours() % 12 || 12
        }, m: function () {
            return this.minutes()
        }, s: function () {
            return this.seconds()
        }, S: function () {
            return q(this.milliseconds() / 100)
        }, SS: function () {
            return i(q(this.milliseconds() / 10), 2)
        }, SSS: function () {
            return i(this.milliseconds(), 3)
        }, SSSS: function () {
            return i(this.milliseconds(), 3)
        }, Z: function () {
            var a = -this.zone(), b = "+";
            return 0 > a && (a = -a, b = "-"), b + i(q(a / 60), 2) + ":" + i(q(a) % 60, 2)
        }, ZZ: function () {
            var a = -this.zone(), b = "+";
            return 0 > a && (a = -a, b = "-"), b + i(q(a / 60), 2) + i(q(a) % 60, 2)
        }, z: function () {
            return this.zoneAbbr()
        }, zz: function () {
            return this.zoneName()
        }, X: function () {
            return this.unix()
        }, Q: function () {
            return this.quarter()
        }
    }, Wb = ["months", "monthsShort", "weekdays", "weekdaysShort", "weekdaysMin"]; Tb.length;)db = Tb.pop(), Vb[db + "o"] = c(Vb[db], db);
    for (; Ub.length;)db = Ub.pop(), Vb[db + db] = b(Vb[db], 2);
    for (Vb.DDDD = b(Vb.DDD, 3), g(d.prototype, {
        set: function (a) {
            var b, c;
            for (c in a)b = a[c], "function" == typeof b ? this[c] = b : this["_" + c] = b
        },
        _months: "Stycznia_Lutego_Marca_Kwietnia_Maja_Czerwca_Lipca_Sierpnia_Września_Października_Listopada_Grudnia".split("_"),
        months: function (a) {
            return this._months[a.month()]
        },
        _monthsShort: "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
        monthsShort: function (a) {
            return this._monthsShort[a.month()]
        },
        monthsParse: function (a) {
            var b, c, d;
            for (this._monthsParse || (this._monthsParse = []), b = 0; 12 > b; b++)if (this._monthsParse[b] || (c = cb.utc([2e3, b]), d = "^" + this.months(c, "") + "|^" + this.monthsShort(c, ""), this._monthsParse[b] = new RegExp(d.replace(".", ""), "i")), this._monthsParse[b].test(a))return b
        },
        _weekdays: "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"),
        weekdays: function (a) {
            return this._weekdays[a.day()]
        },
        _weekdaysShort: "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"),
        weekdaysShort: function (a) {
            return this._weekdaysShort[a.day()]
        },
        _weekdaysMin: "Su_Mo_Tu_We_Th_Fr_Sa".split("_"),
        weekdaysMin: function (a) {
            return this._weekdaysMin[a.day()]
        },
        weekdaysParse: function (a) {
            var b, c, d;
            for (this._weekdaysParse || (this._weekdaysParse = []), b = 0; 7 > b; b++)if (this._weekdaysParse[b] || (c = cb([2e3, 1]).day(b), d = "^" + this.weekdays(c, "") + "|^" + this.weekdaysShort(c, "") + "|^" + this.weekdaysMin(c, ""), this._weekdaysParse[b] = new RegExp(d.replace(".", ""), "i")), this._weekdaysParse[b].test(a))return b
        },
        _longDateFormat: {
            LT: "h:mm A",
            L: "MM/DD/YYYY",
            LL: "MMMM D YYYY",
            LLL: "MMMM D YYYY LT",
            LLLL: "dddd, MMMM D YYYY LT"
        },
        longDateFormat: function (a) {
            var b = this._longDateFormat[a];
            return !b && this._longDateFormat[a.toUpperCase()] && (b = this._longDateFormat[a.toUpperCase()].replace(/MMMM|MM|DD|dddd/g, function (a) {
                return a.slice(1)
            }), this._longDateFormat[a] = b), b
        },
        isPM: function (a) {
            return "p" === (a + "").toLowerCase().charAt(0)
        },
        _meridiemParse: /[ap]\.?m?\.?/i,
        meridiem: function (a, b, c) {
            return a > 11 ? c ? "pm" : "PM" : c ? "am" : "AM"
        },
        _calendar: {
            sameDay: "[Today at] LT",
            nextDay: "[Tomorrow at] LT",
            nextWeek: "dddd [at] LT",
            lastDay: "[Yesterday at] LT",
            lastWeek: "[Last] dddd [at] LT",
            sameElse: "L"
        },
        calendar: function (a, b) {
            var c = this._calendar[a];
            return "function" == typeof c ? c.apply(b) : c
        },
        _relativeTime: {
            future: "in %s",
            past: "%s ago",
            s: "a few seconds",
            m: "a minute",
            mm: "%d minutes",
            h: "an hour",
            hh: "%d hours",
            d: "a day",
            dd: "%d days",
            M: "a month",
            MM: "%d months",
            y: "a year",
            yy: "%d years"
        },
        relativeTime: function (a, b, c, d) {
            var e = this._relativeTime[c];
            return "function" == typeof e ? e(a, b, c, d) : e.replace(/%d/i, a)
        },
        pastFuture: function (a, b) {
            var c = this._relativeTime[a > 0 ? "future" : "past"];
            return "function" == typeof c ? c(b) : c.replace(/%s/i, b)
        },
        ordinal: function (a) {
            return this._ordinal.replace("%d", a)
        },
        _ordinal: "%d",
        preparse: function (a) {
            return a
        },
        postformat: function (a) {
            return a
        },
        week: function (a) {
            return X(a, this._week.dow, this._week.doy).week
        },
        _week: {dow: 0, doy: 6},
        _invalidDate: "Invalid date",
        invalidDate: function () {
            return this._invalidDate
        }
    }), cb = function (b, c, d, e) {
        return "boolean" == typeof d && (e = d, d = a), Z({_i: b, _f: c, _l: d, _strict: e, _isUTC: !1})
    }, cb.utc = function (b, c, d, e) {
        var f;
        return "boolean" == typeof d && (e = d, d = a), f = Z({
            _useUTC: !0,
            _isUTC: !0,
            _l: d,
            _i: b,
            _f: c,
            _strict: e
        }).utc()
    }, cb.unix = function (a) {
        return cb(1e3 * a)
    }, cb.duration = function (a, b) {
        var c, d, e, g = a, h = null;
        return cb.isDuration(a) ? g = {
            ms: a._milliseconds,
            d: a._days,
            M: a._months
        } : "number" == typeof a ? (g = {}, b ? g[b] = a : g.milliseconds = a) : (h = rb.exec(a)) ? (c = "-" === h[1] ? -1 : 1, g = {
            y: 0,
            d: q(h[jb]) * c,
            h: q(h[kb]) * c,
            m: q(h[lb]) * c,
            s: q(h[mb]) * c,
            ms: q(h[nb]) * c
        }) : (h = sb.exec(a)) && (c = "-" === h[1] ? -1 : 1, e = function (a) {
            var b = a && parseFloat(a.replace(",", "."));
            return (isNaN(b) ? 0 : b) * c
        }, g = {
            y: e(h[2]),
            M: e(h[3]),
            d: e(h[4]),
            h: e(h[5]),
            m: e(h[6]),
            s: e(h[7]),
            w: e(h[8])
        }), d = new f(g), cb.isDuration(a) && a.hasOwnProperty("_lang") && (d._lang = a._lang), d
    }, cb.version = eb, cb.defaultFormat = Kb, cb.updateOffset = function () {
    }, cb.lang = function (a, b) {
        var c;
        return a ? (b ? z(x(a), b) : null === b ? (A(a), a = "en") : ob[a] || B(a), c = cb.duration.fn._lang = cb.fn._lang = B(a), c._abbr) : cb.fn._lang._abbr
    }, cb.langData = function (a) {
        return a && a._lang && a._lang._abbr && (a = a._lang._abbr), B(a)
    }, cb.isMoment = function (a) {
        return a instanceof e
    }, cb.isDuration = function (a) {
        return a instanceof f
    }, db = Wb.length - 1; db >= 0; --db)p(Wb[db]);
    for (cb.normalizeUnits = function (a) {
        return n(a)
    }, cb.invalid = function (a) {
        var b = cb.utc(0 / 0);
        return null != a ? g(b._pf, a) : b._pf.userInvalidated = !0, b
    }, cb.parseZone = function (a) {
        return cb(a).parseZone()
    }, g(cb.fn = e.prototype, {
        clone: function () {
            return cb(this)
        }, valueOf: function () {
            return +this._d + 6e4 * (this._offset || 0)
        }, unix: function () {
            return Math.floor(+this / 1e3)
        }, toString: function () {
            return this.clone().lang("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ")
        }, toDate: function () {
            return this._offset ? new Date(+this) : this._d
        }, toISOString: function () {
            var a = cb(this).utc();
            return 0 < a.year() && a.year() <= 9999 ? E(a, "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]") : E(a, "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]")
        }, toArray: function () {
            var a = this;
            return [a.year(), a.month(), a.date(), a.hours(), a.minutes(), a.seconds(), a.milliseconds()]
        }, isValid: function () {
            return w(this)
        }, isDSTShifted: function () {
            return this._a ? this.isValid() && m(this._a, (this._isUTC ? cb.utc(this._a) : cb(this._a)).toArray()) > 0 : !1
        }, parsingFlags: function () {
            return g({}, this._pf)
        }, invalidAt: function () {
            return this._pf.overflow
        }, utc: function () {
            return this.zone(0)
        }, local: function () {
            return this.zone(0), this._isUTC = !1, this
        }, format: function (a) {
            var b = E(this, a || cb.defaultFormat);
            return this.lang().postformat(b)
        }, add: function (a, b) {
            var c;
            return c = "string" == typeof a ? cb.duration(+b, a) : cb.duration(a, b), j(this, c, 1), this
        }, subtract: function (a, b) {
            var c;
            return c = "string" == typeof a ? cb.duration(+b, a) : cb.duration(a, b), j(this, c, -1), this
        }, diff: function (a, b, c) {
            var d, e, f = y(a, this), g = 6e4 * (this.zone() - f.zone());
            return b = n(b), "year" === b || "month" === b ? (d = 432e5 * (this.daysInMonth() + f.daysInMonth()), e = 12 * (this.year() - f.year()) + (this.month() - f.month()), e += (this - cb(this).startOf("month") - (f - cb(f).startOf("month"))) / d, e -= 6e4 * (this.zone() - cb(this).startOf("month").zone() - (f.zone() - cb(f).startOf("month").zone())) / d, "year" === b && (e /= 12)) : (d = this - f, e = "second" === b ? d / 1e3 : "minute" === b ? d / 6e4 : "hour" === b ? d / 36e5 : "day" === b ? (d - g) / 864e5 : "week" === b ? (d - g) / 6048e5 : d), c ? e : h(e)
        }, from: function (a, b) {
            return cb.duration(this.diff(a)).lang(this.lang()._abbr).humanize(!b)
        }, fromNow: function (a) {
            return this.from(cb(), a)
        }, calendar: function () {
            var a = y(cb(), this).startOf("day"), b = this.diff(a, "days", !0), c = -6 > b ? "sameElse" : -1 > b ? "lastWeek" : 0 > b ? "lastDay" : 1 > b ? "sameDay" : 2 > b ? "nextDay" : 7 > b ? "nextWeek" : "sameElse";
            return this.format(this.lang().calendar(c, this))
        }, isLeapYear: function () {
            return t(this.year())
        }, isDST: function () {
            return this.zone() < this.clone().month(0).zone() || this.zone() < this.clone().month(5).zone()
        }, day: function (a) {
            var b = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
            return null != a ? (a = U(a, this.lang()), this.add({d: a - b})) : b
        }, month: function (a) {
            var b, c = this._isUTC ? "UTC" : "";
            return null != a ? "string" == typeof a && (a = this.lang().monthsParse(a), "number" != typeof a) ? this : (b = this.date(), this.date(1), this._d["set" + c + "Month"](a), this.date(Math.min(b, this.daysInMonth())), cb.updateOffset(this), this) : this._d["get" + c + "Month"]()
        }, startOf: function (a) {
            switch (a = n(a)) {
                case"year":
                    this.month(0);
                case"month":
                    this.date(1);
                case"week":
                case"isoWeek":
                case"day":
                    this.hours(0);
                case"hour":
                    this.minutes(0);
                case"minute":
                    this.seconds(0);
                case"second":
                    this.milliseconds(0)
            }
            return "week" === a ? this.weekday(0) : "isoWeek" === a && this.isoWeekday(1), this
        }, endOf: function (a) {
            return a = n(a), this.startOf(a).add("isoWeek" === a ? "week" : a, 1).subtract("ms", 1)
        }, isAfter: function (a, b) {
            return b = "undefined" != typeof b ? b : "millisecond", +this.clone().startOf(b) > +cb(a).startOf(b)
        }, isBefore: function (a, b) {
            return b = "undefined" != typeof b ? b : "millisecond", +this.clone().startOf(b) < +cb(a).startOf(b)
        }, isSame: function (a, b) {
            return b = b || "ms", +this.clone().startOf(b) === +y(a, this).startOf(b)
        }, min: function (a) {
            return a = cb.apply(null, arguments), this > a ? this : a
        }, max: function (a) {
            return a = cb.apply(null, arguments), a > this ? this : a
        }, zone: function (a) {
            var b = this._offset || 0;
            return null == a ? this._isUTC ? b : this._d.getTimezoneOffset() : ("string" == typeof a && (a = H(a)), Math.abs(a) < 16 && (a = 60 * a), this._offset = a, this._isUTC = !0, b !== a && j(this, cb.duration(b - a, "m"), 1, !0), this)
        }, zoneAbbr: function () {
            return this._isUTC ? "UTC" : ""
        }, zoneName: function () {
            return this._isUTC ? "Coordinated Universal Time" : ""
        }, parseZone: function () {
            return this._tzm ? this.zone(this._tzm) : "string" == typeof this._i && this.zone(this._i), this
        }, hasAlignedHourOffset: function (a) {
            return a = a ? cb(a).zone() : 0, (this.zone() - a) % 60 === 0
        }, daysInMonth: function () {
            return r(this.year(), this.month())
        }, dayOfYear: function (a) {
            var b = gb((cb(this).startOf("day") - cb(this).startOf("year")) / 864e5) + 1;
            return null == a ? b : this.add("d", a - b)
        }, quarter: function () {
            return Math.ceil((this.month() + 1) / 3)
        }, weekYear: function (a) {
            var b = X(this, this.lang()._week.dow, this.lang()._week.doy).year;
            return null == a ? b : this.add("y", a - b)
        }, isoWeekYear: function (a) {
            var b = X(this, 1, 4).year;
            return null == a ? b : this.add("y", a - b)
        }, week: function (a) {
            var b = this.lang().week(this);
            return null == a ? b : this.add("d", 7 * (a - b))
        }, isoWeek: function (a) {
            var b = X(this, 1, 4).week;
            return null == a ? b : this.add("d", 7 * (a - b))
        }, weekday: function (a) {
            var b = (this.day() + 7 - this.lang()._week.dow) % 7;
            return null == a ? b : this.add("d", a - b)
        }, isoWeekday: function (a) {
            return null == a ? this.day() || 7 : this.day(this.day() % 7 ? a : a - 7)
        }, get: function (a) {
            return a = n(a), this[a]()
        }, set: function (a, b) {
            return a = n(a), "function" == typeof this[a] && this[a](b), this
        }, lang: function (b) {
            return b === a ? this._lang : (this._lang = B(b), this)
        }
    }), db = 0; db < Ob.length; db++)$(Ob[db].toLowerCase().replace(/s$/, ""), Ob[db]);
    $("year", "FullYear"), cb.fn.days = cb.fn.day, cb.fn.months = cb.fn.month, cb.fn.weeks = cb.fn.week, cb.fn.isoWeeks = cb.fn.isoWeek, cb.fn.toJSON = cb.fn.toISOString, g(cb.duration.fn = f.prototype, {
        _bubble: function () {
            var a, b, c, d, e = this._milliseconds, f = this._days, g = this._months, i = this._data;
            i.milliseconds = e % 1e3, a = h(e / 1e3), i.seconds = a % 60, b = h(a / 60), i.minutes = b % 60, c = h(b / 60), i.hours = c % 24, f += h(c / 24), i.days = f % 30, g += h(f / 30), i.months = g % 12, d = h(g / 12), i.years = d
        }, weeks: function () {
            return h(this.days() / 7)
        }, valueOf: function () {
            return this._milliseconds + 864e5 * this._days + this._months % 12 * 2592e6 + 31536e6 * q(this._months / 12)
        }, humanize: function (a) {
            var b = +this, c = W(b, !a, this.lang());
            return a && (c = this.lang().pastFuture(b, c)), this.lang().postformat(c)
        }, add: function (a, b) {
            var c = cb.duration(a, b);
            return this._milliseconds += c._milliseconds, this._days += c._days, this._months += c._months, this._bubble(), this
        }, subtract: function (a, b) {
            var c = cb.duration(a, b);
            return this._milliseconds -= c._milliseconds, this._days -= c._days, this._months -= c._months, this._bubble(), this
        }, get: function (a) {
            return a = n(a), this[a.toLowerCase() + "s"]()
        }, as: function (a) {
            return a = n(a), this["as" + a.charAt(0).toUpperCase() + a.slice(1) + "s"]()
        }, lang: cb.fn.lang, toIsoString: function () {
            var a = Math.abs(this.years()), b = Math.abs(this.months()), c = Math.abs(this.days()), d = Math.abs(this.hours()), e = Math.abs(this.minutes()), f = Math.abs(this.seconds() + this.milliseconds() / 1e3);
            return this.asSeconds() ? (this.asSeconds() < 0 ? "-" : "") + "P" + (a ? a + "Y" : "") + (b ? b + "M" : "") + (c ? c + "D" : "") + (d || e || f ? "T" : "") + (d ? d + "H" : "") + (e ? e + "M" : "") + (f ? f + "S" : "") : "P0D"
        }
    });
    for (db in Pb)Pb.hasOwnProperty(db) && (ab(db, Pb[db]), _(db.toLowerCase()));
    ab("Weeks", 6048e5), cb.duration.fn.asMonths = function () {
        return (+this - 31536e6 * this.years()) / 2592e6 + 12 * this.years()
    }, cb.lang("en", {
        ordinal: function (a) {
            var b = a % 10, c = 1 === q(a % 100 / 10) ? "th" : 1 === b ? "st" : 2 === b ? "nd" : 3 === b ? "rd" : "th";
            return a + c
        }
    }), pb ? (module.exports = cb, bb(!0)) : "function" == typeof define && define.amd ? define("moment", function (b, c, d) {
        return d.config && d.config() && d.config().noGlobal !== !0 && bb(d.config().noGlobal === a), cb
    }) : bb()
}).call(this);

/**
 * Copyright (c) 2007-2012 Ariel Flesler - aflesler(at)gmail(dot)com | http://flesler.blogspot.com
 * Dual licensed under MIT and GPL.
 * @author Ariel Flesler
 * @version 1.4.3.1
 */
(function ($) {
    var h = $.scrollTo = function (a, b, c) {
        $(window).scrollTo(a, b, c)
    };
    h.defaults = {axis: 'xy', duration: parseFloat($.fn.jquery) >= 1.3 ? 0 : 1, limit: true};
    h.window = function (a) {
        return $(window)._scrollable()
    };
    $.fn._scrollable = function () {
        return this.map(function () {
            var a = this, isWin = !a.nodeName || $.inArray(a.nodeName.toLowerCase(), ['iframe', '#document', 'html', 'body']) != -1;
            if (!isWin)return a;
            var b = (a.contentWindow || a).document || a.ownerDocument || a;
            return /webkit/i.test(navigator.userAgent) || b.compatMode == 'BackCompat' ? b.body : b.documentElement
        })
    };
    $.fn.scrollTo = function (e, f, g) {
        if (typeof f == 'object') {
            g = f;
            f = 0
        }
        if (typeof g == 'function')g = {onAfter: g};
        if (e == 'max')e = 9e9;
        g = $.extend({}, h.defaults, g);
        f = f || g.duration;
        g.queue = g.queue && g.axis.length > 1;
        if (g.queue)f /= 2;
        g.offset = both(g.offset);
        g.over = both(g.over);
        return this._scrollable().each(function () {
            if (e == null)return;
            var d = this, $elem = $(d), targ = e, toff, attr = {}, win = $elem.is('html,body');
            switch (typeof targ) {
                case'number':
                case'string':
                    if (/^([+-]=)?\d+(\.\d+)?(px|%)?$/.test(targ)) {
                        targ = both(targ);
                        break
                    }
                    targ = $(targ, this);
                    if (!targ.length)return;
                case'object':
                    if (targ.is || targ.style)toff = (targ = $(targ)).offset()
            }
            $.each(g.axis.split(''), function (i, a) {
                var b = a == 'x' ? 'Left' : 'Top', pos = b.toLowerCase(), key = 'scroll' + b, old = d[key], max = h.max(d, a);
                if (toff) {
                    attr[key] = toff[pos] + (win ? 0 : old - $elem.offset()[pos]);
                    if (g.margin) {
                        attr[key] -= parseInt(targ.css('margin' + b)) || 0;
                        attr[key] -= parseInt(targ.css('border' + b + 'Width')) || 0
                    }
                    attr[key] += g.offset[pos] || 0;
                    if (g.over[pos])attr[key] += targ[a == 'x' ? 'width' : 'height']() * g.over[pos]
                } else {
                    var c = targ[pos];
                    attr[key] = c.slice && c.slice(-1) == '%' ? parseFloat(c) / 100 * max : c
                }
                if (g.limit && /^\d+$/.test(attr[key]))attr[key] = attr[key] <= 0 ? 0 : Math.min(attr[key], max);
                if (!i && g.queue) {
                    if (old != attr[key])animate(g.onAfterFirst);
                    delete attr[key]
                }
            });
            animate(g.onAfter);
            function animate(a) {
                $elem.animate(attr, f, g.easing, a && function () {
                    a.call(this, e, g)
                })
            }
        }).end()
    };
    h.max = function (a, b) {
        var c = b == 'x' ? 'Width' : 'Height', scroll = 'scroll' + c;
        if (!$(a).is('html,body'))return a[scroll] - $(a)[c.toLowerCase()]();
        var d = 'client' + c, html = a.ownerDocument.documentElement, body = a.ownerDocument.body;
        return Math.max(html[scroll], body[scroll]) - Math.min(html[d], body[d])
    };
    function both(a) {
        return typeof a == 'object' ? a : {top: a, left: a}
    }
})(jQuery);

/**
 |------------------------------------------|
 | MelonHTML5 - Timeline                    |
 |------------------------------------------|
 | @author:  Lee Le (lee@melonhtml5.com)    |
 | @version: 2.01 (26th July 2014)           |
 | @website: www.melonhtml5.com             |
 |------------------------------------------|
 */

String.prototype.parseURL = function () {
    return this.replace(/[A-Za-z]+:\/\/[A-Za-z0-9-_]+\.[A-Za-z0-9-_:%&~\?\/.=]+/g, function (url) {
        return url.link(url);
    });
};

String.prototype.parseHashtag = function () {
    return this.replace(/[#]+[A-Za-z0-9-_]+/g, function (t) {
        var tag = t.replace("#", "%23");
        return t.link("//twitter.com/search?q=" + tag);
    });
};

String.prototype.trimString = function (length) {
    return this.substr(0, length) + (this.length > length ? '...' : '');
};

function Timeline(element, data, $, undefined) {
    if ($ === undefined) {
        $ = jQuery;
    }

    var SELF = this;
    var BODY = $(document.body);

    this._container = null;  // cached DOM
    this._spine = null;  // cached DOM
    this._overlay = null;  // cached DOM
    this._lightbox = null;  // cached DOM

    this._original_data = data ? $.extend(true, [], data) : [];  // a copy of the original data
    this._data = [];  // main data

    this._responsive = false; // in responsive mode?

    this._options = {
        first_separator: false,          // display the first separator?
        separator: 'year',         // year, month, month_year, null
        columnMode: 'dual',         // dual, left, right, center
        order: 'desc',         // "asc", "desc",
        responsive_width: null,           // swith to responsive mode when window width is smaller than the width
        animation: true,           // animate on page load?
        lightbox: true,           // use lightbox?
        max: null,           // maximum number of elements
        loadmore: 0,              // load more data. Set to 5 to load 5 additional data each time
        facebookAccessToken: null,           // facebook access token  "https://graph.facebook.com/oauth/access_token?client_id={app-id}&client_secret={app-secret}&grant_type=client_credentials"
        facebookPageId: null,           // facebook page id
        twitterSearchKey: null,           // twitter search key
        onSearchSuccess: null,           // XHR search success handler
        onSearchError: null            // XHR search error handler
    };

    this._years = [];
    this._months = [];

    // settings that user can't change via setOptions()
    this._readmore_text = 'Read More';
    thisl_loadmore_text = 'Load More';
    this._month_translation = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']; // month separators
    this._spine_margin = 100;

    this._facebook_content_length = 300;
    this._facebook_description_length = 150;

    // cache timeline elements in an array
    this._elements = [];
    this._separators = [];

    // process queue
    this._iframe_queue = [];  // iframe queue

    // detect css3 transition support
    this._use_css3 = (function () {
        var style = document.body.style;

        if (typeof style['transition'] == 'string') {
            return true;
        }

        // Tests for vendor specific prop
        var prefix = ['Webkit', 'Moz', 'Khtml', 'O', 'ms'];
        for (var i = 0; i < prefix.length; i++) {
            if (typeof (style[prefix[i] + 'Transition']) == 'string') {
                return true;
            }
        }

        return false;
    })();

    // default timeline element options
    this._default_element_data = {
        type: 'blog_post',      // blog_post   gallery    slider   iframe
        date: '2000-01-01',     // blog_post   gallery    slider   iframe
        dateFormat: 'DD MMMM YYYY',   // blog_post   gallery    slider   iframe
        title: null,             // blog_post   gallery    slider   iframe
        content: null,             // blog_post
        image: null,             // blog_post
        readmore: null,             // blog_post
        height: 300,              //             gallery    slider   iframe
        images: [],               //             gallery    slider
        speed: null,             //                        slider
        url: null              //                                 iframe
    };

    this._prepareData = function () {
        SELF._sortData(SELF._original_data);

        if (SELF._options.max && SELF._options.max < SELF._original_data.length) {
            SELF._data = SELF._original_data.slice(0, SELF._options.max);
            SELF._original_data.splice(0, SELF._options.max)
        } else {
            SELF._data = SELF._original_data;
        }
    };

    // create a single timeline element
    this._createElement = function (element_data, position) {
        element_data = $.extend({}, SELF._default_element_data, element_data);

        // element DIV
        var element = $('<div>').addClass('timeline_element ' + element_data.type);

        if (position === 'left') {
            element.addClass('timeline_element_left');
        } else if (position === 'right') {
            element.addClass('timeline_element_right');
        }

        if (!SELF._options.animation) {
            element.addClass('animated');
        }

        var element_box = $('<div>').addClass('timeline_element_box').appendTo(element);

        // title DIV
        if (element_data.title) {
            var title = $('<div>').addClass('timeline_title').html('<span class="timeline_title_label">' + element_data.title + '</span><span class="timeline_title_date">' + SELF._getDateString(element_data.date, element_data.dateFormat) + '</span>').appendTo(element_box);
        } else {
            element.addClass('notitle');
        }

        switch (element_data.type) {
            case 'iframe':
                // content DIV
                var content = $('<div>').addClass('content loading').height(element_data.height).appendTo(element_box);

                SELF._iframe_queue.push({
                    element: content,
                    url: element_data.url
                });

                break;
            case 'blog_post':
                // image
                if (element_data.image) {
                    var img_container = $('<div>').addClass('img_container')
                        .append($('<img>').attr('src', element_data.image))
                        .appendTo(element_box);

                    if (SELF._options.lightbox) {
                        img_container.append($('<div>').addClass('img_overlay').html('<span class="magnifier" data-type="blog_post" data-img="' + element_data.image + '"></span>'));
                    }
                }

                // content DIV
                if (element_data.content) {
                    $('<div>').addClass('content').html(element_data.content).appendTo(element_box);
                }

                if (element_data.readmore) {
                    $('<div>').addClass('readmore').html('<a href="' + element_data.readmore + '">' + SELF._readmore_text + '</a>').appendTo(element_box);
                }

                break;
            case 'gallery':
                // mini gallery
                if (element_data.images.length) {
                    var scroll_container = $('<div>').addClass('scroll_container').appendTo(element_box);

                    var image_html = '';
                    var _loaded = 0;
                    var _total = element_data.images.length;
                    $(element_data.images).each(function (index, image_src) {
                        image_html += '<div class="img_container"><img style="height:' + element_data.height + 'px;" src="' + image_src + '" />';
                        if (SELF._options.lightbox) {
                            image_html += '<div class="img_overlay"><span class="magnifier" data-total="' + element_data.images.length + '" data-order="' + index + '" data-type="gallery" data-img="' + image_src + '"></span></div>';
                        }
                        image_html += '</div>';
                    });

                    scroll_container.html(image_html);
                }

                break;
            case 'slider':
                var html = '';
                $(element_data.images).each(function (index, image_src) {
                    html += '<div data-total="' + element_data.images.length + '" data-order="' + index + '" class="img_container' + (index === 0 ? ' active' : '') + '" style="display:' + (index === 0 ? 'block' : 'none') + ';"><img src="' + image_src + '" />';
                    if (SELF._options.lightbox) {
                        html += '<div class="img_overlay"><span class="magnifier" data-total="' + element_data.images.length + '" data-order="' + index + '" data-type="slider" data-img="' + image_src + '"></span></div>';
                    }
                    html += '</div>';
                });

                if (element_data.images.length > 1) {
                    html += '<span class="slider_prev"></span><span class="slider_next"></span>';
                }

                $('<div>').addClass('content').height(element_data.height).html(html).appendTo(element_box);

                if (element_data.images.length > 1) {
                    if (element_data.speed) {
                        element.data('speed', element_data.speed);
                        setTimeout(function () {
                            SELF._updateSlider(element, 'next');
                        }, element_data.speed);
                    }
                }

                break;
        }

        element.appendTo(SELF._container);

        // cache element in the array
        SELF._elements.push(element);

        return element;
    };

    // create a year separator
    this._createSeparator = function (time) {
        var separator = $('<div>').addClass('date_separator').attr('id', 'timeline_date_separator_' + time).html('<span>' + time + '</span>').appendTo(SELF._container);
        if (!SELF._options.animation) {
            separator.addClass('animated');
        }
        SELF._separators.push(separator);
    };

    // create DOM from JSON
    this._render = function (timeline_data, is_append) {
        var is_odd = true;

        $(timeline_data).each(function (index, data) {
            if (SELF._options.max && SELF._options.max <= index && !is_append) {
                return false;
            }

            if (is_append && index === 0) {
                var last_element = SELF._container.children(':last');
                if (last_element.length && last_element.hasClass('timeline_element_left')) {
                    is_odd = false;
                }
            }

            var year = parseInt(data.date.split('-')[0], 10);
            var month = parseInt(data.date.split('-')[1], 10);

            if (month < 10) {
                month = '0' + month;
            }

            month = year + '-' + month;

            var start_new = false;

            if ($.inArray(year, SELF._years) === -1 && (SELF._options.separator === 'year' || SELF._options.separator === null)) {
                start_new = true;
                SELF._years.push(year);
            }

            if ($.inArray(month, SELF._months) === -1 && (SELF._options.separator === 'month' || SELF._options.separator === 'month_year')) {
                start_new = true;
                SELF._months.push(month);
            }

            if (start_new) {
                if (SELF._options.separator === 'year') {
                    if (SELF._years.length > 1 || SELF._options.first_separator) {
                        SELF._createSeparator(year);
                    }
                } else if (SELF._options.separator === 'month' || SELF._options.separator === 'month_year') {
                    if (SELF._months.length > 1 || SELF._options.first_separator) {
                        var month_display = SELF._month_translation[parseInt(month.split('-')[1], 10) - 1];

                        if (SELF._options.separator === 'month_year') {
                            month_display = month_display + ' ' + year;
                        }

                        SELF._createSeparator(month_display);
                    }
                }

                if (SELF._options.separator) {
                    is_odd = true;
                }
            }

            if (SELF._options.columnMode === 'dual') {
                SELF._createElement(data, is_odd ? 'left' : 'right');
            } else {
                SELF._createElement(data);
            }

            is_odd = is_odd ? false : true;
        });
    };

    this._updateSlider = function (timeline_element, direction) {
        if (timeline_element.data('timeout_id')) {
            clearTimeout(timeline_element.data('timeout_id'));
        }

        if (!this._options.lightbox || !SELF._overlay.hasClass('open')) {
            var current_image = timeline_element.find('.img_container.active').removeClass('active');

            if (direction === 'next') {
                if (current_image.data('order') === current_image.data('total') - 1) {
                    var next_image = timeline_element.find('.img_container:first').addClass('active');
                } else {
                    var next_image = current_image.next().addClass('active');
                }
            } else {
                if (current_image.data('order') === 0) {
                    var next_image = timeline_element.find('.img_container:last').addClass('active');
                } else {
                    var next_image = current_image.prev().addClass('active');
                }
            }

            current_image.fadeOut();
            next_image.fadeIn();
        }

        if (timeline_element.data('speed')) {
            var timeout_id = setTimeout(function () {
                SELF._updateSlider(timeline_element, direction);
            }, timeline_element.data('speed'));

            timeline_element.data('timeout_id', timeout_id);
        }
    };

    // start animation on page load
    this._startAnimation = function (callback) {
        $(window).width(); // force page reflow

        if (SELF._use_css3) {
            SELF._spine.addClass('animated');
        } else {
            SELF._spine.animate({bottom: '0%'}, 500, function () {
                SELF._spine.addClass('animated');
            });
        }

        if (SELF._options.separator === 'year' || SELF._options.separator === 'month' || SELF._options.separator === 'month_year') {
            setTimeout(function () {
                // separator
                $(SELF._separators).each(function (index, separator) {
                    if (SELF._use_css3) {
                        separator.addClass('animated');
                    } else {
                        separator.children('span').animate({opacity: 1, top: '50%'}, 300, function () {
                            separator.addClass('animated');
                        });
                    }
                });
            }, 500);
        }

        // timeline element
        var count = 0;
        $(SELF._elements).each(function (index, element) {
            if (!element.hasClass('animated')) {
                count++;

                setTimeout(function (count) {
                    if (SELF._use_css3) {
                        element.addClass('animated');
                    } else {
                        element.hide().addClass('animated').fadeIn();
                    }

                    if (index === SELF._elements.length - 1) {
                        setTimeout(callback, 200);
                    }

                }, (SELF._options.separator === 'year' || SELF._options.separator === 'month' || SELF._options.separator === 'month_year' ? 1000 : 500) + count * 100);
            }
        });

        return true;
    };

    // convert 2013-12-19 to 19 Dec 2013
    this._getDateString = function (string, format) {
        // validations
        var string_array = string.split('-');
        if (string_array.length >= 3) {
            var year = string_array[0];
            var month = string_array[1];
            var day = string_array[2];
        } else if (string_array.length === 2) {
            var year = string_array[0];
            var month = string_array[1];
            var day = '01';
        } else if (string_array.length === 1) {
            var year = string_array[0];
            var month = '01';
            var day = '01';
        }

        var date_string = year + '-' + month + '-' + day;

        return moment(date_string).format(format);
    };

    this._loadMore = function () {
        if (SELF._loadmore.hasClass('loading')) {
            return;
        }

        SELF._loadmore.addClass('loading');

        setTimeout(function () {
            SELF._loadmore.removeClass('loading');

            if (SELF._original_data.length <= SELF._options.loadmore) {
                var new_data = SELF._original_data;
                SELF._original_data = [];

                SELF._loadmore.remove();
            } else {
                var new_data = SELF._original_data.slice(0, SELF._options.loadmore);
                SELF._original_data.splice(0, SELF._options.loadmore);
            }

            SELF.appendData(new_data);
        }, 1000);
    };

    // sort data in desc or asc order
    this._sortData = function (timeline_data) {
        if (timeline_data) {
            // sort data by date
            timeline_data.sort(function (a, b) {
                if (SELF._options.order === 'desc') {
                    return parseInt(b.date.replace(/-/g, ''), 10) - parseInt(a.date.replace(/-/g, ''), 10);
                } else {
                    return parseInt(a.date.replace(/-/g, ''), 10) - parseInt(b.date.replace(/-/g, ''), 10);
                }
            });
        }

        return timeline_data;
    };

    // display timeline
    this._display = function () {
        if (SELF._options.responsive_width) {
            $(window).on('resize', SELF._windowResize);
        }

        if ($(document).data('timeline_events_binded') !== true) {
            $(document)
                .data('timeline_events_binded', true)
                .click(SELF._handleClick)
                .keydown(SELF._handleKeyDown);
        }

        if (SELF._options.lightbox) {
            SELF._overlay = $('.timeline_overlay');
            if (SELF._overlay.length) {
                SELF._lightbox = SELF._overlay.children('.lightbox');
            } else {
                // lightbox
                SELF._overlay = $('<div>').addClass('timeline_overlay');
                SELF._lightbox = $('<div>').addClass('lightbox').html('<div class="navigation"><a class="close" href="#"></a><span class="prev"></span><span class="next"></span></div>').appendTo(SELF._overlay);
                SELF._overlay.appendTo(BODY);
            }
        }

        // build container
        SELF._container = $('<div>').addClass('timeline timeline_' + SELF._options.columnMode);

        if (!$.support.opacity) {
            SELF._container.addClass('opacityFilter');
        }

        if (!SELF._use_css3) {
            SELF._container.addClass('noneCSS3');
        }

        if (SELF._options.responsive_width) {
            $(window).resize();
        }

        // spine
        SELF._spine = $('<div>').addClass('spine').appendTo(SELF._container);
        if (!SELF._options.animation) {
            SELF._spine.addClass('animated');
        }

        // render: create DOM
        SELF._render(SELF._data);

        SELF._container.data('loaded', true).appendTo(element);

        // load more
        if (SELF._options.loadmore && SELF._options.max && SELF._original_data.length && SELF._original_data.length > this._options.max) {
            SELF._loadmore = $('<div>').addClass('timeline_loadmore').text(thisl_loadmore_text).appendTo(element);
        }

        if (SELF._options.animation) {
            setTimeout(function () {
                SELF._startAnimation(SELF._processIframeQueue);
            }, 200);  // fix animation cannot be fully seen from the very beginning
        } else {
            SELF._processIframeQueue();
        }

        return true;
    };

    this._makeResponsive = function (responsive) {
        if (responsive) {
            if (!this._responsive) {
                this._responsive = true;
                SELF._container.removeClass('timeline_left timeline_right timeline_dual');
                SELF._container.addClass('timeline_center');
            }
        } else {
            if (this._responsive) {
                this._responsive = false;
                SELF._container.removeClass('timeline_center');
                SELF._container.addClass('timeline_' + SELF._options.columnMode);
            }
        }
    };

    /*
     |-------------------|
     |     LIGHTBOX      |
     |-------------------|
     */

    // open image in a lighbox
    this._openLightBox = function (magnifier, image_url) {
        magnifier.parent().addClass('loading');

        if (magnifier.data('type') === 'gallery' || magnifier.data('type') === 'slider') {
            SELF._lightbox.find('.navigation span').show();
            SELF._lightbox.data('magnifier', magnifier);
        } else {
            SELF._lightbox.find('.navigation span').hide();
        }

        setTimeout(function () {
            var _addImage = function () {
                magnifier.parent().removeClass('loading');
                SELF._overlay.addClass('open');
                $('<img>').attr('src', image_url).appendTo(SELF._lightbox);

                var lightbox_size = SELF._getLightboxSize(image.width, image.height);

                SELF._lightbox.addClass('loaded').css({
                    width: lightbox_size.width,
                    height: lightbox_size.height
                });
            };

            var image = new Image();
            image.onload = _addImage;
            image.src = image_url;
        }, 1000);

        return image_url;
    };

    // close lightbox
    this._closeLightBox = function (e) {
        if (SELF._use_css3) {
            SELF._lightbox.removeClass('loaded');
        } else {
            SELF._lightbox.animate({top: 0, opacity: 0}, 300, function () {
                SELF._lightbox.removeClass('loaded');
            });
        }

        setTimeout(function () {
            SELF._overlay.removeClass('open');
            SELF._lightbox.removeAttr('style').children('img').remove();
        }, 300);
    };

    // get lightbox size (max: 90% of window size)
    this._getLightboxSize = function (width, height) {
        var max_width = $(window).width() - 100;
        var max_height = $(window).height() - 100;

        var new_width = width;
        var new_height = height;

        if (width > max_width || height > max_height) {
            var ratio = width / height;

            if (width > max_width && height <= max_height) {
                var new_width = max_width;
                var new_height = height / (width / new_width);
            } else if (height > max_height && width <= max_width) {
                var new_height = max_height;
                var new_width = width / (height / new_height);
            } else {
                var new_width = max_width;
                var new_height = height / (width / new_width);

                if (new_height > max_height) {
                    var new_height = max_height;
                    var new_width = width / (height / new_height);
                }
            }
        }

        return {width: new_width, height: new_height};
    };

    // navigate to next/previous image
    this._navLightBox = function (element, direction) {
        var current_magnifier = SELF._lightbox.data('magnifier');

        if (direction === 'next') {
            var next_image = current_magnifier.parents('.img_container:first').next('.img_container');

            if (!next_image.length) {
                next_image = current_magnifier.parents('.img_container:first').parent().children('.img_container:first');
            }
        } else {
            var next_image = current_magnifier.parents('.img_container:first').prev('.img_container');

            if (!next_image.length) {
                next_image = current_magnifier.parents('.img_container:first').parent().children('.img_container:last');
            }
        }

        var next_magnifier = next_image.find('span.magnifier');
        var image_url = next_magnifier.data('img');

        var _updateImage = function () {
            SELF._lightbox.data('magnifier', next_magnifier).addClass('updating');

            SELF._lightbox.children('img').attr('src', image_url);

            var lightbox_size = SELF._getLightboxSize(image.width, image.height);

            SELF._lightbox.css({
                width: lightbox_size.width,
                height: lightbox_size.height
            });

            setTimeout(function () {
                SELF._lightbox.removeClass('updating');
            }, 500);
        };

        var image = new Image();
        image.onload = _updateImage;
        image.src = image_url;
    };

    /*
     |-------------------|
     |      PROCESS      |
     |-------------------|
     */

    this._processIframeQueue = function () {
        $(SELF._iframe_queue).each(function (index, queue) {
            queue.element.removeClass('loading').html('<iframe frameborder="0" src="' + queue.url + '"></iframe>');
        });
        intervalRunable = true;
    };

    /*
     |-------------------|
     |      EVENTS       |
     |-------------------|
     */

    this._windowResize = function (e) {
        if ($(window).width() < SELF._options.responsive_width) {
            SELF._makeResponsive(true);
        } else {
            SELF._makeResponsive(false);
        }
    };

    this._handleClick = function (e) {
        var element = $(e.target);

        if (element.hasClass('timeline_overlay')) {
            SELF._closeLightBox(e);
        } else if (element.hasClass('magnifier')) {
            SELF._openLightBox(element, element.data('img'));
        } else if (element.hasClass('close')) {
            e.preventDefault();
            SELF._closeLightBox(e);
        } else if (element.hasClass('prev')) {
            SELF._navLightBox(element, 'prev');
        } else if (element.hasClass('next')) {
            SELF._navLightBox(element, 'next');
        } else if (element.hasClass('slider_prev')) {
            SELF._updateSlider(element.parents('.timeline_element:first'), 'prev');
        } else if (element.hasClass('slider_next')) {
            SELF._updateSlider(element.parents('.timeline_element:first'), 'next');
        } else if (element.hasClass('timeline_loadmore')) {
            SELF._loadMore();
        }

        return true;
    };

    this._handleKeyDown = function (e) {
        switch (parseInt(e.which, 10)) {
            case 27:   // ESC
                if (SELF._overlay.hasClass('open')) {
                    SELF._closeLightBox(e);
                }
                break;
            case 37:   // LEFT
                if (SELF._lightbox.hasClass('loaded') && SELF._lightbox.find('.navigation span.prev').is(':visible')) {
                    SELF._lightbox.find('.navigation span.prev').click();
                    return false;
                }
                break;
            case 39:   // RIGHT
                if (SELF._lightbox.hasClass('loaded') && SELF._lightbox.find('.navigation span.next').is(':visible')) {
                    SELF._lightbox.find('.navigation span.next').click();
                    return false;
                }

                break;
        }
    };

    /*
     |-------------------|
     |     Facebook      |
     |-------------------|
     */

    this._loadFacebook = function (callback) {
        var api_url = '/' + SELF._options.facebookPageId + '/feed';
        var api_option = {'access_token': SELF._options.facebookAccessToken};

        var facebook_posts = [];

        var picture_in_loading = 0;

        var _done = function () {
            SELF._original_data = facebook_posts;

            if (callback !== undefined) {
                callback();
            }

            if (SELF._options.onSearchSuccess) {
                SELF._options.onSearchSuccess(facebook_posts);
            }
        };

        var _initContent = function (facebook_data) {
            var content = '<div class="facebook_type_' + facebook_data.type + '">' +
                '<div class="facebook_left_column"><img class="facebook_profile" src="https://graph.facebook.com/' + facebook_data.from.id + '/picture?type=square" /></div>' +
                '<div class="facebook_right_column">';

            if (facebook_data.message) {
                content += '<div class="facebook_content">' + facebook_data.message.trimString(SELF._facebook_message_length).parseURL() + '</div>';
            }

            content += '</div>' +
            '<div style="clear:both;"></div>';

            return content;
        };

        var _pushData = function (facebook_data, content) {
            var date = facebook_data.updated_time.split('-');
            var year = date[0];
            var month = date[1];
            var day = date[2].substr(0, 2);

            facebook_posts.push({
                type: 'blog_post',
                date: year + '-' + month + '-' + day,
                title: facebook_data.from.name,
                content: content
            });
        };

        FB.api(api_url, api_option, function (response) {
            if (!response || !response.data || !response.data.length) {
                if (SELF._options.onSearchError) {
                    SELF._options.onSearchError(response);
                }

                // no data
                return;
            }

            // Get Timeline data via Facebook API
            $(response.data).each(function (index, facebook_data) {
                if (facebook_data.from.id) {
                    if (facebook_data.type === 'photo') {
                        picture_in_loading++;
                        FB.api('/' + facebook_data.object_id, api_option, function (response) {
                            var content = _initContent(facebook_data);

                            if (response.source) {
                                content += '<div class="facebook_post">' +
                                '<a href="' + facebook_data.link + '" style="display:inline;"><img class="facebook_picture" align="left" src="' + response.source + '" /></a>' +
                                '</div>';
                            }

                            content += '</div>';

                            _pushData(facebook_data, content);

                            picture_in_loading--;

                            if (picture_in_loading === 0) {
                                _done();
                            }
                        });
                    } else if (facebook_data.message) {
                        var content = _initContent(facebook_data);

                        if (facebook_data.picture) {
                            content += '<div class="facebook_post">' +
                            '<a href="' + facebook_data.link + '" style="display:inline;"><img class="facebook_picture" align="left" src="' + facebook_data.picture + '" /></a>' +
                            '<div class="description_container">' +
                            (facebook_data.name ? '<a href="' + facebook_data.link + '">' + facebook_data.name + '</a>' : '') +
                            (facebook_data.caption ? '<div class="facebook_caption">' + facebook_data.caption + '</div>' : '') +
                            (facebook_data.description ? '<div class="facebook_description">' + facebook_data.description.trimString(SELF._facebook_description_length).parseURL() + '</div>' : '') +
                            '</div>' +
                            '</div>';
                        }

                        content += '</div>';

                        _pushData(facebook_data, content);
                    }
                }
            });

            if (picture_in_loading === 0) {
                _done();
            }
        });
    };

    /*
     |-------------------|
     |     Twitter       |
     |-------------------|
     */
    this._loadTwitter = function (callback) {
        $.getJSON('http://api.melonhtml5.com/?action=twittersearch&q=' + SELF._options.twitterSearchKey + '&callback=?', function (response) {
            var twitter_data = [];

            if (!response.statuses.length) {
                if (SELF._options.onSearchError) {
                    SELF._options.onSearchError(response);
                }
                return;
            }

            $(response.statuses).each(function (index, tweet_data) {
                var months = [];
                months['Jan'] = '01';
                months['Feb'] = '02';
                months['Mar'] = '03';
                months['Apr'] = '04';
                months['May'] = '05';
                months['Jun'] = '06';
                months['Jul'] = '07';
                months['Aug'] = '08';
                months['Sep'] = '09';
                months['Oct'] = '10';
                months['Nov'] = '11';
                months['Dec'] = '12';

                var date = tweet_data.created_at.split(' ');
                var year = date[5];
                var month = months[date[1]];
                var day = date[2];

                twitter_data.push({
                    type: 'blog_post',
                    date: year + '-' + month + '-' + day,
                    title: '<a href="http://www.twitter.com/' + tweet_data.user.screen_name + '" target="_blank" style="text-decoration:none;color:#AAAAAA;">' + tweet_data.user.screen_name + '</a>',
                    content: '<div><img style="margin:0px 5px 5px 0px;" align="left" src="' + tweet_data.user.profile_image_url + '" /></div>' + tweet_data.text.parseURL().parseHashtag()
                });
            });

            SELF._original_data = twitter_data;

            if (callback !== undefined) {
                callback();
            }

            if (SELF._options.onSearchSuccess) {
                SELF._options.onSearchSuccess(response);
            }
        });
    };


    /*
     |-------------------|
     |        API        |
     |-------------------|
     */

    // set options
    this.setOptions = function (opts) {
        SELF._options = $.extend(SELF._options, opts);
        return SELF._options;
    };

    // display
    this.display = function () {
        var _go = function () {
            SELF._prepareData();
            SELF._display();
        };

        if (SELF._original_data && SELF._original_data.length) {
            _go();
        } else if (SELF._options.twitterSearchKey) {
            SELF._loadTwitter(_go);
        } else if (SELF._options.facebookAccessToken && SELF._options.facebookPageId) {
            if (FB) {
                SELF._loadFacebook(_go);
            }
        }
    };

    // add additional data into an existing timeline
    this.appendData = function (timeline_data) {
        var end_date = parseInt(SELF._data[SELF._data.length - 1].date.replace(/-/g, ''), 10);
        var new_data = [];

        if (SELF._options.order === 'desc') {
            $(timeline_data).each(function (index, data) {
                if (parseInt(data.date.replace(/-/g, ''), 10) <= end_date) {
                    new_data.push(data);
                }
            });
        } else {
            $(timeline_data).each(function (index, data) {
                if (parseInt(data.date.replace(/-/g, ''), 10) >= end_date) {
                    new_data.push(data);
                }
            });
        }

        SELF._data = SELF._data.concat(new_data);

        // render: create DOM
        SELF._render(new_data, true);

        if (SELF._options.animation) {
            SELF._startAnimation(SELF._processIframeQueue);
        } else {
            SELF._processIframeQueue();
        }
    };
}