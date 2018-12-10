var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; };

/*
 Copyright (C) Federico Zivolo 2018
 Distributed under the MIT License (license terms are at http://opensource.org/licenses/MIT).
 */(function (e, t) {
	'object' == (typeof exports === 'undefined' ? 'undefined' : _typeof(exports)) && 'undefined' != typeof module ? module.exports = t() : 'function' == typeof define && define.amd ? define(t) : e.Popper = t();
})(this, function () {
	'use strict';
	function e(e) {
		return e && '[object Function]' === {}.toString.call(e);
	}function t(e, t) {
		if (1 !== e.nodeType) return [];var o = getComputedStyle(e, null);return t ? o[t] : o;
	}function o(e) {
		return 'HTML' === e.nodeName ? e : e.parentNode || e.host;
	}function n(e) {
		if (!e) return document.body;switch (e.nodeName) {case 'HTML':case 'BODY':
				return e.ownerDocument.body;case '#document':
				return e.body;}var i = t(e),
		    r = i.overflow,
		    p = i.overflowX,
		    s = i.overflowY;return (/(auto|scroll|overlay)/.test(r + s + p) ? e : n(o(e))
		);
	}function r(e) {
		return 11 === e ? re : 10 === e ? pe : re || pe;
	}function p(e) {
		if (!e) return document.documentElement;for (var o = r(10) ? document.body : null, n = e.offsetParent; n === o && e.nextElementSibling;) {
			n = (e = e.nextElementSibling).offsetParent;
		}var i = n && n.nodeName;return i && 'BODY' !== i && 'HTML' !== i ? -1 !== ['TD', 'TABLE'].indexOf(n.nodeName) && 'static' === t(n, 'position') ? p(n) : n : e ? e.ownerDocument.documentElement : document.documentElement;
	}function s(e) {
		var t = e.nodeName;return 'BODY' !== t && ('HTML' === t || p(e.firstElementChild) === e);
	}function d(e) {
		return null === e.parentNode ? e : d(e.parentNode);
	}function a(e, t) {
		if (!e || !e.nodeType || !t || !t.nodeType) return document.documentElement;var o = e.compareDocumentPosition(t) & Node.DOCUMENT_POSITION_FOLLOWING,
		    n = o ? e : t,
		    i = o ? t : e,
		    r = document.createRange();r.setStart(n, 0), r.setEnd(i, 0);var l = r.commonAncestorContainer;if (e !== l && t !== l || n.contains(i)) return s(l) ? l : p(l);var f = d(e);return f.host ? a(f.host, t) : a(e, d(t).host);
	}function l(e) {
		var t = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 'top',
		    o = 'top' === t ? 'scrollTop' : 'scrollLeft',
		    n = e.nodeName;if ('BODY' === n || 'HTML' === n) {
			var i = e.ownerDocument.documentElement,
			    r = e.ownerDocument.scrollingElement || i;return r[o];
		}return e[o];
	}function f(e, t) {
		var o = 2 < arguments.length && void 0 !== arguments[2] && arguments[2],
		    n = l(t, 'top'),
		    i = l(t, 'left'),
		    r = o ? -1 : 1;return e.top += n * r, e.bottom += n * r, e.left += i * r, e.right += i * r, e;
	}function m(e, t) {
		var o = 'x' === t ? 'Left' : 'Top',
		    n = 'Left' == o ? 'Right' : 'Bottom';return parseFloat(e['border' + o + 'Width'], 10) + parseFloat(e['border' + n + 'Width'], 10);
	}function h(e, t, o, n) {
		return $(t['offset' + e], t['scroll' + e], o['client' + e], o['offset' + e], o['scroll' + e], r(10) ? o['offset' + e] + n['margin' + ('Height' === e ? 'Top' : 'Left')] + n['margin' + ('Height' === e ? 'Bottom' : 'Right')] : 0);
	}function c() {
		var e = document.body,
		    t = document.documentElement,
		    o = r(10) && getComputedStyle(t);return { height: h('Height', e, t, o), width: h('Width', e, t, o) };
	}function g(e) {
		return le({}, e, { right: e.left + e.width, bottom: e.top + e.height });
	}function u(e) {
		var o = {};try {
			if (r(10)) {
				o = e.getBoundingClientRect();var n = l(e, 'top'),
				    i = l(e, 'left');o.top += n, o.left += i, o.bottom += n, o.right += i;
			} else o = e.getBoundingClientRect();
		} catch (t) {}var p = { left: o.left, top: o.top, width: o.right - o.left, height: o.bottom - o.top },
		    s = 'HTML' === e.nodeName ? c() : {},
		    d = s.width || e.clientWidth || p.right - p.left,
		    a = s.height || e.clientHeight || p.bottom - p.top,
		    f = e.offsetWidth - d,
		    h = e.offsetHeight - a;if (f || h) {
			var u = t(e);f -= m(u, 'x'), h -= m(u, 'y'), p.width -= f, p.height -= h;
		}return g(p);
	}function b(e, o) {
		var i = 2 < arguments.length && void 0 !== arguments[2] && arguments[2],
		    p = r(10),
		    s = 'HTML' === o.nodeName,
		    d = u(e),
		    a = u(o),
		    l = n(e),
		    m = t(o),
		    h = parseFloat(m.borderTopWidth, 10),
		    c = parseFloat(m.borderLeftWidth, 10);i && 'HTML' === o.nodeName && (a.top = $(a.top, 0), a.left = $(a.left, 0));var b = g({ top: d.top - a.top - h, left: d.left - a.left - c, width: d.width, height: d.height });if (b.marginTop = 0, b.marginLeft = 0, !p && s) {
			var y = parseFloat(m.marginTop, 10),
			    w = parseFloat(m.marginLeft, 10);b.top -= h - y, b.bottom -= h - y, b.left -= c - w, b.right -= c - w, b.marginTop = y, b.marginLeft = w;
		}return (p && !i ? o.contains(l) : o === l && 'BODY' !== l.nodeName) && (b = f(b, o)), b;
	}function y(e) {
		var t = 1 < arguments.length && void 0 !== arguments[1] && arguments[1],
		    o = e.ownerDocument.documentElement,
		    n = b(e, o),
		    i = $(o.clientWidth, window.innerWidth || 0),
		    r = $(o.clientHeight, window.innerHeight || 0),
		    p = t ? 0 : l(o),
		    s = t ? 0 : l(o, 'left'),
		    d = { top: p - n.top + n.marginTop, left: s - n.left + n.marginLeft, width: i, height: r };return g(d);
	}function w(e) {
		var n = e.nodeName;return 'BODY' === n || 'HTML' === n ? !1 : 'fixed' === t(e, 'position') || w(o(e));
	}function E(e) {
		if (!e || !e.parentElement || r()) return document.documentElement;for (var o = e.parentElement; o && 'none' === t(o, 'transform');) {
			o = o.parentElement;
		}return o || document.documentElement;
	}function v(e, t, i, r) {
		var p = 4 < arguments.length && void 0 !== arguments[4] && arguments[4],
		    s = { top: 0, left: 0 },
		    d = p ? E(e) : a(e, t);if ('viewport' === r) s = y(d, p);else {
			var l;'scrollParent' === r ? (l = n(o(t)), 'BODY' === l.nodeName && (l = e.ownerDocument.documentElement)) : 'window' === r ? l = e.ownerDocument.documentElement : l = r;var f = b(l, d, p);if ('HTML' === l.nodeName && !w(d)) {
				var m = c(),
				    h = m.height,
				    g = m.width;s.top += f.top - f.marginTop, s.bottom = h + f.top, s.left += f.left - f.marginLeft, s.right = g + f.left;
			} else s = f;
		}return s.left += i, s.top += i, s.right -= i, s.bottom -= i, s;
	}function x(e) {
		var t = e.width,
		    o = e.height;return t * o;
	}function O(e, t, o, n, i) {
		var r = 5 < arguments.length && void 0 !== arguments[5] ? arguments[5] : 0;if (-1 === e.indexOf('auto')) return e;var p = v(o, n, r, i),
		    s = { top: { width: p.width, height: t.top - p.top }, right: { width: p.right - t.right, height: p.height }, bottom: { width: p.width, height: p.bottom - t.bottom }, left: { width: t.left - p.left, height: p.height } },
		    d = Object.keys(s).map(function (e) {
			return le({ key: e }, s[e], { area: x(s[e]) });
		}).sort(function (e, t) {
			return t.area - e.area;
		}),
		    a = d.filter(function (e) {
			var t = e.width,
			    n = e.height;return t >= o.clientWidth && n >= o.clientHeight;
		}),
		    l = 0 < a.length ? a[0].key : d[0].key,
		    f = e.split('-')[1];return l + (f ? '-' + f : '');
	}function L(e, t, o) {
		var n = 3 < arguments.length && void 0 !== arguments[3] ? arguments[3] : null,
		    i = n ? E(t) : a(t, o);return b(o, i, n);
	}function S(e) {
		var t = getComputedStyle(e),
		    o = parseFloat(t.marginTop) + parseFloat(t.marginBottom),
		    n = parseFloat(t.marginLeft) + parseFloat(t.marginRight),
		    i = { width: e.offsetWidth + n, height: e.offsetHeight + o };return i;
	}function T(e) {
		var t = { left: 'right', right: 'left', bottom: 'top', top: 'bottom' };return e.replace(/left|right|bottom|top/g, function (e) {
			return t[e];
		});
	}function C(e, t, o) {
		o = o.split('-')[0];var n = S(e),
		    i = { width: n.width, height: n.height },
		    r = -1 !== ['right', 'left'].indexOf(o),
		    p = r ? 'top' : 'left',
		    s = r ? 'left' : 'top',
		    d = r ? 'height' : 'width',
		    a = r ? 'width' : 'height';return i[p] = t[p] + t[d] / 2 - n[d] / 2, i[s] = o === s ? t[s] - n[a] : t[T(s)], i;
	}function D(e, t) {
		return Array.prototype.find ? e.find(t) : e.filter(t)[0];
	}function N(e, t, o) {
		if (Array.prototype.findIndex) return e.findIndex(function (e) {
			return e[t] === o;
		});var n = D(e, function (e) {
			return e[t] === o;
		});return e.indexOf(n);
	}function P(t, o, n) {
		var i = void 0 === n ? t : t.slice(0, N(t, 'name', n));return i.forEach(function (t) {
			t['function'] && console.warn('`modifier.function` is deprecated, use `modifier.fn`!');var n = t['function'] || t.fn;t.enabled && e(n) && (o.offsets.popper = g(o.offsets.popper), o.offsets.reference = g(o.offsets.reference), o = n(o, t));
		}), o;
	}function k() {
		if (!this.state.isDestroyed) {
			var e = { instance: this, styles: {}, arrowStyles: {}, attributes: {}, flipped: !1, offsets: {} };e.offsets.reference = L(this.state, this.popper, this.reference, this.options.positionFixed), e.placement = O(this.options.placement, e.offsets.reference, this.popper, this.reference, this.options.modifiers.flip.boundariesElement, this.options.modifiers.flip.padding), e.originalPlacement = e.placement, e.positionFixed = this.options.positionFixed, e.offsets.popper = C(this.popper, e.offsets.reference, e.placement), e.offsets.popper.position = this.options.positionFixed ? 'fixed' : 'absolute', e = P(this.modifiers, e), this.state.isCreated ? this.options.onUpdate(e) : (this.state.isCreated = !0, this.options.onCreate(e));
		}
	}function W(e, t) {
		return e.some(function (e) {
			var o = e.name,
			    n = e.enabled;return n && o === t;
		});
	}function B(e) {
		for (var t = [!1, 'ms', 'Webkit', 'Moz', 'O'], o = e.charAt(0).toUpperCase() + e.slice(1), n = 0; n < t.length; n++) {
			var i = t[n],
			    r = i ? '' + i + o : e;if ('undefined' != typeof document.body.style[r]) return r;
		}return null;
	}function H() {
		return this.state.isDestroyed = !0, W(this.modifiers, 'applyStyle') && (this.popper.removeAttribute('x-placement'), this.popper.style.position = '', this.popper.style.top = '', this.popper.style.left = '', this.popper.style.right = '', this.popper.style.bottom = '', this.popper.style.willChange = '', this.popper.style[B('transform')] = ''), this.disableEventListeners(), this.options.removeOnDestroy && this.popper.parentNode.removeChild(this.popper), this;
	}function A(e) {
		var t = e.ownerDocument;return t ? t.defaultView : window;
	}function M(e, t, o, i) {
		var r = 'BODY' === e.nodeName,
		    p = r ? e.ownerDocument.defaultView : e;p.addEventListener(t, o, { passive: !0 }), r || M(n(p.parentNode), t, o, i), i.push(p);
	}function I(e, t, o, i) {
		o.updateBound = i, A(e).addEventListener('resize', o.updateBound, { passive: !0 });var r = n(e);return M(r, 'scroll', o.updateBound, o.scrollParents), o.scrollElement = r, o.eventsEnabled = !0, o;
	}function F() {
		this.state.eventsEnabled || (this.state = I(this.reference, this.options, this.state, this.scheduleUpdate));
	}function R(e, t) {
		return A(e).removeEventListener('resize', t.updateBound), t.scrollParents.forEach(function (e) {
			e.removeEventListener('scroll', t.updateBound);
		}), t.updateBound = null, t.scrollParents = [], t.scrollElement = null, t.eventsEnabled = !1, t;
	}function U() {
		this.state.eventsEnabled && (cancelAnimationFrame(this.scheduleUpdate), this.state = R(this.reference, this.state));
	}function Y(e) {
		return '' !== e && !isNaN(parseFloat(e)) && isFinite(e);
	}function j(e, t) {
		Object.keys(t).forEach(function (o) {
			var n = '';-1 !== ['width', 'height', 'top', 'right', 'bottom', 'left'].indexOf(o) && Y(t[o]) && (n = 'px'), e.style[o] = t[o] + n;
		});
	}function K(e, t) {
		Object.keys(t).forEach(function (o) {
			var n = t[o];!1 === n ? e.removeAttribute(o) : e.setAttribute(o, t[o]);
		});
	}function q(e, t, o) {
		var n = D(e, function (e) {
			var o = e.name;return o === t;
		}),
		    i = !!n && e.some(function (e) {
			return e.name === o && e.enabled && e.order < n.order;
		});if (!i) {
			var r = '`' + t + '`';console.warn('`' + o + '`' + ' modifier is required by ' + r + ' modifier in order to work, be sure to include it before ' + r + '!');
		}return i;
	}function G(e) {
		return 'end' === e ? 'start' : 'start' === e ? 'end' : e;
	}function z(e) {
		var t = 1 < arguments.length && void 0 !== arguments[1] && arguments[1],
		    o = me.indexOf(e),
		    n = me.slice(o + 1).concat(me.slice(0, o));return t ? n.reverse() : n;
	}function V(e, t, o, n) {
		var i = e.match(/((?:\-|\+)?\d*\.?\d*)(.*)/),
		    r = +i[1],
		    p = i[2];if (!r) return e;if (0 === p.indexOf('%')) {
			var s;switch (p) {case '%p':
					s = o;break;case '%':case '%r':default:
					s = n;}var d = g(s);return d[t] / 100 * r;
		}if ('vh' === p || 'vw' === p) {
			var a;return a = 'vh' === p ? $(document.documentElement.clientHeight, window.innerHeight || 0) : $(document.documentElement.clientWidth, window.innerWidth || 0), a / 100 * r;
		}return r;
	}function _(e, t, o, n) {
		var i = [0, 0],
		    r = -1 !== ['right', 'left'].indexOf(n),
		    p = e.split(/(\+|\-)/).map(function (e) {
			return e.trim();
		}),
		    s = p.indexOf(D(p, function (e) {
			return -1 !== e.search(/,|\s/);
		}));p[s] && -1 === p[s].indexOf(',') && console.warn('Offsets separated by white space(s) are deprecated, use a comma (,) instead.');var d = /\s*,\s*|\s+/,
		    a = -1 === s ? [p] : [p.slice(0, s).concat([p[s].split(d)[0]]), [p[s].split(d)[1]].concat(p.slice(s + 1))];return a = a.map(function (e, n) {
			var i = (1 === n ? !r : r) ? 'height' : 'width',
			    p = !1;return e.reduce(function (e, t) {
				return '' === e[e.length - 1] && -1 !== ['+', '-'].indexOf(t) ? (e[e.length - 1] = t, p = !0, e) : p ? (e[e.length - 1] += t, p = !1, e) : e.concat(t);
			}, []).map(function (e) {
				return V(e, i, t, o);
			});
		}), a.forEach(function (e, t) {
			e.forEach(function (o, n) {
				Y(o) && (i[t] += o * ('-' === e[n - 1] ? -1 : 1));
			});
		}), i;
	}function X(e, t) {
		var o,
		    n = t.offset,
		    i = e.placement,
		    r = e.offsets,
		    p = r.popper,
		    s = r.reference,
		    d = i.split('-')[0];return o = Y(+n) ? [+n, 0] : _(n, p, s, d), 'left' === d ? (p.top += o[0], p.left -= o[1]) : 'right' === d ? (p.top += o[0], p.left += o[1]) : 'top' === d ? (p.left += o[0], p.top -= o[1]) : 'bottom' === d && (p.left += o[0], p.top += o[1]), e.popper = p, e;
	}for (var J = Math.min, Q = Math.round, Z = Math.floor, $ = Math.max, ee = 'undefined' != typeof window && 'undefined' != typeof document, te = ['Edge', 'Trident', 'Firefox'], oe = 0, ne = 0; ne < te.length; ne += 1) {
		if (ee && 0 <= navigator.userAgent.indexOf(te[ne])) {
			oe = 1;break;
		}
	}var i = ee && window.Promise,
	    ie = i ? function (e) {
		var t = !1;return function () {
			t || (t = !0, window.Promise.resolve().then(function () {
				t = !1, e();
			}));
		};
	} : function (e) {
		var t = !1;return function () {
			t || (t = !0, setTimeout(function () {
				t = !1, e();
			}, oe));
		};
	},
	    re = ee && !!(window.MSInputMethodContext && document.documentMode),
	    pe = ee && /MSIE 10/.test(navigator.userAgent),
	    se = function se(e, t) {
		if (!(e instanceof t)) throw new TypeError('Cannot call a class as a function');
	},
	    de = function () {
		function e(e, t) {
			for (var o, n = 0; n < t.length; n++) {
				o = t[n], o.enumerable = o.enumerable || !1, o.configurable = !0, 'value' in o && (o.writable = !0), Object.defineProperty(e, o.key, o);
			}
		}return function (t, o, n) {
			return o && e(t.prototype, o), n && e(t, n), t;
		};
	}(),
	    ae = function ae(e, t, o) {
		return t in e ? Object.defineProperty(e, t, { value: o, enumerable: !0, configurable: !0, writable: !0 }) : e[t] = o, e;
	},
	    le = Object.assign || function (e) {
		for (var t, o = 1; o < arguments.length; o++) {
			for (var n in t = arguments[o], t) {
				Object.prototype.hasOwnProperty.call(t, n) && (e[n] = t[n]);
			}
		}return e;
	},
	    fe = ['auto-start', 'auto', 'auto-end', 'top-start', 'top', 'top-end', 'right-start', 'right', 'right-end', 'bottom-end', 'bottom', 'bottom-start', 'left-end', 'left', 'left-start'],
	    me = fe.slice(3),
	    he = { FLIP: 'flip', CLOCKWISE: 'clockwise', COUNTERCLOCKWISE: 'counterclockwise' },
	    ce = function () {
		function t(o, n) {
			var i = this,
			    r = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : {};se(this, t), this.scheduleUpdate = function () {
				return requestAnimationFrame(i.update);
			}, this.update = ie(this.update.bind(this)), this.options = le({}, t.Defaults, r), this.state = { isDestroyed: !1, isCreated: !1, scrollParents: [] }, this.reference = o && o.jquery ? o[0] : o, this.popper = n && n.jquery ? n[0] : n, this.options.modifiers = {}, Object.keys(le({}, t.Defaults.modifiers, r.modifiers)).forEach(function (e) {
				i.options.modifiers[e] = le({}, t.Defaults.modifiers[e] || {}, r.modifiers ? r.modifiers[e] : {});
			}), this.modifiers = Object.keys(this.options.modifiers).map(function (e) {
				return le({ name: e }, i.options.modifiers[e]);
			}).sort(function (e, t) {
				return e.order - t.order;
			}), this.modifiers.forEach(function (t) {
				t.enabled && e(t.onLoad) && t.onLoad(i.reference, i.popper, i.options, t, i.state);
			}), this.update();var p = this.options.eventsEnabled;p && this.enableEventListeners(), this.state.eventsEnabled = p;
		}return de(t, [{ key: 'update', value: function value() {
				return k.call(this);
			} }, { key: 'destroy', value: function value() {
				return H.call(this);
			} }, { key: 'enableEventListeners', value: function value() {
				return F.call(this);
			} }, { key: 'disableEventListeners', value: function value() {
				return U.call(this);
			} }]), t;
	}();return ce.Utils = ('undefined' == typeof window ? global : window).PopperUtils, ce.placements = fe, ce.Defaults = { placement: 'bottom', positionFixed: !1, eventsEnabled: !0, removeOnDestroy: !1, onCreate: function onCreate() {}, onUpdate: function onUpdate() {}, modifiers: { shift: { order: 100, enabled: !0, fn: function fn(e) {
					var t = e.placement,
					    o = t.split('-')[0],
					    n = t.split('-')[1];if (n) {
						var i = e.offsets,
						    r = i.reference,
						    p = i.popper,
						    s = -1 !== ['bottom', 'top'].indexOf(o),
						    d = s ? 'left' : 'top',
						    a = s ? 'width' : 'height',
						    l = { start: ae({}, d, r[d]), end: ae({}, d, r[d] + r[a] - p[a]) };e.offsets.popper = le({}, p, l[n]);
					}return e;
				} }, offset: { order: 200, enabled: !0, fn: X, offset: 0 }, preventOverflow: { order: 300, enabled: !0, fn: function fn(e, t) {
					var o = t.boundariesElement || p(e.instance.popper);e.instance.reference === o && (o = p(o));var n = B('transform'),
					    i = e.instance.popper.style,
					    r = i.top,
					    s = i.left,
					    d = i[n];i.top = '', i.left = '', i[n] = '';var a = v(e.instance.popper, e.instance.reference, t.padding, o, e.positionFixed);i.top = r, i.left = s, i[n] = d, t.boundaries = a;var l = t.priority,
					    f = e.offsets.popper,
					    m = { primary: function primary(e) {
							var o = f[e];return f[e] < a[e] && !t.escapeWithReference && (o = $(f[e], a[e])), ae({}, e, o);
						}, secondary: function secondary(e) {
							var o = 'right' === e ? 'left' : 'top',
							    n = f[o];return f[e] > a[e] && !t.escapeWithReference && (n = J(f[o], a[e] - ('right' === e ? f.width : f.height))), ae({}, o, n);
						} };return l.forEach(function (e) {
						var t = -1 === ['left', 'top'].indexOf(e) ? 'secondary' : 'primary';f = le({}, f, m[t](e));
					}), e.offsets.popper = f, e;
				}, priority: ['left', 'right', 'top', 'bottom'], padding: 5, boundariesElement: 'scrollParent' }, keepTogether: { order: 400, enabled: !0, fn: function fn(e) {
					var t = e.offsets,
					    o = t.popper,
					    n = t.reference,
					    i = e.placement.split('-')[0],
					    r = Z,
					    p = -1 !== ['top', 'bottom'].indexOf(i),
					    s = p ? 'right' : 'bottom',
					    d = p ? 'left' : 'top',
					    a = p ? 'width' : 'height';return o[s] < r(n[d]) && (e.offsets.popper[d] = r(n[d]) - o[a]), o[d] > r(n[s]) && (e.offsets.popper[d] = r(n[s])), e;
				} }, arrow: { order: 500, enabled: !0, fn: function fn(e, o) {
					var n;if (!q(e.instance.modifiers, 'arrow', 'keepTogether')) return e;var i = o.element;if ('string' == typeof i) {
						if (i = e.instance.popper.querySelector(i), !i) return e;
					} else if (!e.instance.popper.contains(i)) return console.warn('WARNING: `arrow.element` must be child of its popper element!'), e;var r = e.placement.split('-')[0],
					    p = e.offsets,
					    s = p.popper,
					    d = p.reference,
					    a = -1 !== ['left', 'right'].indexOf(r),
					    l = a ? 'height' : 'width',
					    f = a ? 'Top' : 'Left',
					    m = f.toLowerCase(),
					    h = a ? 'left' : 'top',
					    c = a ? 'bottom' : 'right',
					    u = S(i)[l];d[c] - u < s[m] && (e.offsets.popper[m] -= s[m] - (d[c] - u)), d[m] + u > s[c] && (e.offsets.popper[m] += d[m] + u - s[c]), e.offsets.popper = g(e.offsets.popper);var b = d[m] + d[l] / 2 - u / 2,
					    y = t(e.instance.popper),
					    w = parseFloat(y['margin' + f], 10),
					    E = parseFloat(y['border' + f + 'Width'], 10),
					    v = b - e.offsets.popper[m] - w - E;return v = $(J(s[l] - u, v), 0), e.arrowElement = i, e.offsets.arrow = (n = {}, ae(n, m, Q(v)), ae(n, h, ''), n), e;
				}, element: '[x-arrow]' }, flip: { order: 600, enabled: !0, fn: function fn(e, t) {
					if (W(e.instance.modifiers, 'inner')) return e;if (e.flipped && e.placement === e.originalPlacement) return e;var o = v(e.instance.popper, e.instance.reference, t.padding, t.boundariesElement, e.positionFixed),
					    n = e.placement.split('-')[0],
					    i = T(n),
					    r = e.placement.split('-')[1] || '',
					    p = [];switch (t.behavior) {case he.FLIP:
							p = [n, i];break;case he.CLOCKWISE:
							p = z(n);break;case he.COUNTERCLOCKWISE:
							p = z(n, !0);break;default:
							p = t.behavior;}return p.forEach(function (s, d) {
						if (n !== s || p.length === d + 1) return e;n = e.placement.split('-')[0], i = T(n);var a = e.offsets.popper,
						    l = e.offsets.reference,
						    f = Z,
						    m = 'left' === n && f(a.right) > f(l.left) || 'right' === n && f(a.left) < f(l.right) || 'top' === n && f(a.bottom) > f(l.top) || 'bottom' === n && f(a.top) < f(l.bottom),
						    h = f(a.left) < f(o.left),
						    c = f(a.right) > f(o.right),
						    g = f(a.top) < f(o.top),
						    u = f(a.bottom) > f(o.bottom),
						    b = 'left' === n && h || 'right' === n && c || 'top' === n && g || 'bottom' === n && u,
						    y = -1 !== ['top', 'bottom'].indexOf(n),
						    w = !!t.flipVariations && (y && 'start' === r && h || y && 'end' === r && c || !y && 'start' === r && g || !y && 'end' === r && u);(m || b || w) && (e.flipped = !0, (m || b) && (n = p[d + 1]), w && (r = G(r)), e.placement = n + (r ? '-' + r : ''), e.offsets.popper = le({}, e.offsets.popper, C(e.instance.popper, e.offsets.reference, e.placement)), e = P(e.instance.modifiers, e, 'flip'));
					}), e;
				}, behavior: 'flip', padding: 5, boundariesElement: 'viewport' }, inner: { order: 700, enabled: !1, fn: function fn(e) {
					var t = e.placement,
					    o = t.split('-')[0],
					    n = e.offsets,
					    i = n.popper,
					    r = n.reference,
					    p = -1 !== ['left', 'right'].indexOf(o),
					    s = -1 === ['top', 'left'].indexOf(o);return i[p ? 'left' : 'top'] = r[o] - (s ? i[p ? 'width' : 'height'] : 0), e.placement = T(t), e.offsets.popper = g(i), e;
				} }, hide: { order: 800, enabled: !0, fn: function fn(e) {
					if (!q(e.instance.modifiers, 'hide', 'preventOverflow')) return e;var t = e.offsets.reference,
					    o = D(e.instance.modifiers, function (e) {
						return 'preventOverflow' === e.name;
					}).boundaries;if (t.bottom < o.top || t.left > o.right || t.top > o.bottom || t.right < o.left) {
						if (!0 === e.hide) return e;e.hide = !0, e.attributes['x-out-of-boundaries'] = '';
					} else {
						if (!1 === e.hide) return e;e.hide = !1, e.attributes['x-out-of-boundaries'] = !1;
					}return e;
				} }, computeStyle: { order: 850, enabled: !0, fn: function fn(e, t) {
					var o = t.x,
					    n = t.y,
					    i = e.offsets.popper,
					    r = D(e.instance.modifiers, function (e) {
						return 'applyStyle' === e.name;
					}).gpuAcceleration;void 0 !== r && console.warn('WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!');var s,
					    d,
					    a = void 0 === r ? t.gpuAcceleration : r,
					    l = p(e.instance.popper),
					    f = u(l),
					    m = { position: i.position },
					    h = { left: Z(i.left), top: Q(i.top), bottom: Q(i.bottom), right: Z(i.right) },
					    c = 'bottom' === o ? 'top' : 'bottom',
					    g = 'right' === n ? 'left' : 'right',
					    b = B('transform');if (d = 'bottom' == c ? -f.height + h.bottom : h.top, s = 'right' == g ? -f.width + h.right : h.left, a && b) m[b] = 'translate3d(' + s + 'px, ' + d + 'px, 0)', m[c] = 0, m[g] = 0, m.willChange = 'transform';else {
						var y = 'bottom' == c ? -1 : 1,
						    w = 'right' == g ? -1 : 1;m[c] = d * y, m[g] = s * w, m.willChange = c + ', ' + g;
					}var E = { "x-placement": e.placement };return e.attributes = le({}, E, e.attributes), e.styles = le({}, m, e.styles), e.arrowStyles = le({}, e.offsets.arrow, e.arrowStyles), e;
				}, gpuAcceleration: !0, x: 'bottom', y: 'right' }, applyStyle: { order: 900, enabled: !0, fn: function fn(e) {
					return j(e.instance.popper, e.styles), K(e.instance.popper, e.attributes), e.arrowElement && Object.keys(e.arrowStyles).length && j(e.arrowElement, e.arrowStyles), e;
				}, onLoad: function onLoad(e, t, o, n, i) {
					var r = L(i, t, e, o.positionFixed),
					    p = O(o.placement, r, t, e, o.modifiers.flip.boundariesElement, o.modifiers.flip.padding);return t.setAttribute('x-placement', p), j(t, { position: o.positionFixed ? 'fixed' : 'absolute' }), o;
				}, gpuAcceleration: void 0 } } }, ce;
});
//# sourceMappingURL=popper.min.js.map
/*!
  * Bootstrap v4.1.1 (https://getbootstrap.com/)
  * Copyright 2011-2018 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
  */
!function (t, e) {
	"object" == (typeof exports === 'undefined' ? 'undefined' : _typeof(exports)) && "undefined" != typeof module ? e(exports, require("jquery"), require("popper.js")) : "function" == typeof define && define.amd ? define(["exports", "jquery", "popper.js"], e) : e(t.bootstrap = {}, t.jQuery, t.Popper);
}(this, function (t, e, c) {
	"use strict";
	function i(t, e) {
		for (var n = 0; n < e.length; n++) {
			var i = e[n];i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(t, i.key, i);
		}
	}function o(t, e, n) {
		return e && i(t.prototype, e), n && i(t, n), t;
	}function h(r) {
		for (var t = 1; t < arguments.length; t++) {
			var s = null != arguments[t] ? arguments[t] : {},
			    e = Object.keys(s);"function" == typeof Object.getOwnPropertySymbols && (e = e.concat(Object.getOwnPropertySymbols(s).filter(function (t) {
				return Object.getOwnPropertyDescriptor(s, t).enumerable;
			}))), e.forEach(function (t) {
				var e, n, i;e = r, i = s[n = t], n in e ? Object.defineProperty(e, n, { value: i, enumerable: !0, configurable: !0, writable: !0 }) : e[n] = i;
			});
		}return r;
	}e = e && e.hasOwnProperty("default") ? e.default : e, c = c && c.hasOwnProperty("default") ? c.default : c;var r,
	    n,
	    s,
	    a,
	    l,
	    u,
	    f,
	    d,
	    _,
	    g,
	    m,
	    p,
	    v,
	    E,
	    y,
	    T,
	    C,
	    I,
	    A,
	    D,
	    b,
	    S,
	    w,
	    N,
	    O,
	    k,
	    P,
	    L,
	    j,
	    R,
	    H,
	    W,
	    M,
	    x,
	    U,
	    K,
	    F,
	    V,
	    Q,
	    B,
	    Y,
	    G,
	    q,
	    z,
	    X,
	    J,
	    Z,
	    $,
	    tt,
	    et,
	    nt,
	    it,
	    rt,
	    st,
	    ot,
	    at,
	    lt,
	    ht,
	    ct,
	    ut,
	    ft,
	    dt,
	    _t,
	    gt,
	    mt,
	    pt,
	    vt,
	    Et,
	    yt,
	    Tt,
	    Ct,
	    It,
	    At,
	    Dt,
	    bt,
	    St,
	    wt,
	    Nt,
	    Ot,
	    kt,
	    Pt,
	    Lt,
	    jt,
	    Rt,
	    Ht,
	    Wt,
	    Mt,
	    xt,
	    Ut,
	    Kt,
	    Ft,
	    Vt,
	    Qt,
	    Bt,
	    Yt,
	    Gt,
	    qt,
	    zt,
	    Xt,
	    Jt,
	    Zt,
	    $t,
	    te,
	    ee,
	    ne,
	    ie,
	    re,
	    se,
	    oe,
	    ae,
	    le,
	    he,
	    ce,
	    ue,
	    fe,
	    de,
	    _e,
	    ge,
	    me,
	    pe,
	    ve,
	    Ee,
	    ye,
	    Te,
	    Ce,
	    Ie,
	    Ae,
	    De,
	    be,
	    Se,
	    we,
	    Ne,
	    Oe,
	    ke,
	    Pe,
	    Le,
	    je,
	    Re,
	    He,
	    We,
	    Me,
	    xe,
	    Ue,
	    Ke,
	    Fe,
	    Ve,
	    Qe,
	    Be,
	    Ye,
	    Ge,
	    qe,
	    ze,
	    Xe,
	    Je,
	    Ze,
	    $e,
	    tn,
	    en,
	    nn,
	    rn,
	    sn,
	    on,
	    an,
	    ln,
	    hn,
	    cn,
	    un,
	    fn,
	    dn,
	    _n,
	    gn,
	    mn,
	    pn,
	    vn,
	    En,
	    yn,
	    Tn,
	    Cn = function (i) {
		var e = "transitionend";function t(t) {
			var e = this,
			    n = !1;return i(this).one(l.TRANSITION_END, function () {
				n = !0;
			}), setTimeout(function () {
				n || l.triggerTransitionEnd(e);
			}, t), this;
		}var l = { TRANSITION_END: "bsTransitionEnd", getUID: function getUID(t) {
				for (; t += ~~(1e6 * Math.random()), document.getElementById(t);) {}return t;
			}, getSelectorFromElement: function getSelectorFromElement(t) {
				var e = t.getAttribute("data-target");e && "#" !== e || (e = t.getAttribute("href") || "");try {
					return 0 < i(document).find(e).length ? e : null;
				} catch (t) {
					return null;
				}
			}, getTransitionDurationFromElement: function getTransitionDurationFromElement(t) {
				if (!t) return 0;var e = i(t).css("transition-duration");return parseFloat(e) ? (e = e.split(",")[0], 1e3 * parseFloat(e)) : 0;
			}, reflow: function reflow(t) {
				return t.offsetHeight;
			}, triggerTransitionEnd: function triggerTransitionEnd(t) {
				i(t).trigger(e);
			}, supportsTransitionEnd: function supportsTransitionEnd() {
				return Boolean(e);
			}, isElement: function isElement(t) {
				return (t[0] || t).nodeType;
			}, typeCheckConfig: function typeCheckConfig(t, e, n) {
				for (var i in n) {
					if (Object.prototype.hasOwnProperty.call(n, i)) {
						var r = n[i],
						    s = e[i],
						    o = s && l.isElement(s) ? "element" : (a = s, {}.toString.call(a).match(/\s([a-z]+)/i)[1].toLowerCase());if (!new RegExp(r).test(o)) throw new Error(t.toUpperCase() + ': Option "' + i + '" provided type "' + o + '" but expected type "' + r + '".');
					}
				}var a;
			} };return i.fn.emulateTransitionEnd = t, i.event.special[l.TRANSITION_END] = { bindType: e, delegateType: e, handle: function handle(t) {
				if (i(t.target).is(this)) return t.handleObj.handler.apply(this, arguments);
			} }, l;
	}(e),
	    In = (n = "alert", a = "." + (s = "bs.alert"), l = (r = e).fn[n], u = { CLOSE: "close" + a, CLOSED: "closed" + a, CLICK_DATA_API: "click" + a + ".data-api" }, f = "alert", d = "fade", _ = "show", g = function () {
		function i(t) {
			this._element = t;
		}var t = i.prototype;return t.close = function (t) {
			var e = this._element;t && (e = this._getRootElement(t)), this._triggerCloseEvent(e).isDefaultPrevented() || this._removeElement(e);
		}, t.dispose = function () {
			r.removeData(this._element, s), this._element = null;
		}, t._getRootElement = function (t) {
			var e = Cn.getSelectorFromElement(t),
			    n = !1;return e && (n = r(e)[0]), n || (n = r(t).closest("." + f)[0]), n;
		}, t._triggerCloseEvent = function (t) {
			var e = r.Event(u.CLOSE);return r(t).trigger(e), e;
		}, t._removeElement = function (e) {
			var n = this;if (r(e).removeClass(_), r(e).hasClass(d)) {
				var t = Cn.getTransitionDurationFromElement(e);r(e).one(Cn.TRANSITION_END, function (t) {
					return n._destroyElement(e, t);
				}).emulateTransitionEnd(t);
			} else this._destroyElement(e);
		}, t._destroyElement = function (t) {
			r(t).detach().trigger(u.CLOSED).remove();
		}, i._jQueryInterface = function (n) {
			return this.each(function () {
				var t = r(this),
				    e = t.data(s);e || (e = new i(this), t.data(s, e)), "close" === n && e[n](this);
			});
		}, i._handleDismiss = function (e) {
			return function (t) {
				t && t.preventDefault(), e.close(this);
			};
		}, o(i, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }]), i;
	}(), r(document).on(u.CLICK_DATA_API, '[data-dismiss="alert"]', g._handleDismiss(new g())), r.fn[n] = g._jQueryInterface, r.fn[n].Constructor = g, r.fn[n].noConflict = function () {
		return r.fn[n] = l, g._jQueryInterface;
	}, g),
	    An = (p = "button", E = "." + (v = "bs.button"), y = ".data-api", T = (m = e).fn[p], C = "active", I = "btn", D = '[data-toggle^="button"]', b = '[data-toggle="buttons"]', S = "input", w = ".active", N = ".btn", O = { CLICK_DATA_API: "click" + E + y, FOCUS_BLUR_DATA_API: (A = "focus") + E + y + " blur" + E + y }, k = function () {
		function n(t) {
			this._element = t;
		}var t = n.prototype;return t.toggle = function () {
			var t = !0,
			    e = !0,
			    n = m(this._element).closest(b)[0];if (n) {
				var i = m(this._element).find(S)[0];if (i) {
					if ("radio" === i.type) if (i.checked && m(this._element).hasClass(C)) t = !1;else {
						var r = m(n).find(w)[0];r && m(r).removeClass(C);
					}if (t) {
						if (i.hasAttribute("disabled") || n.hasAttribute("disabled") || i.classList.contains("disabled") || n.classList.contains("disabled")) return;i.checked = !m(this._element).hasClass(C), m(i).trigger("change");
					}i.focus(), e = !1;
				}
			}e && this._element.setAttribute("aria-pressed", !m(this._element).hasClass(C)), t && m(this._element).toggleClass(C);
		}, t.dispose = function () {
			m.removeData(this._element, v), this._element = null;
		}, n._jQueryInterface = function (e) {
			return this.each(function () {
				var t = m(this).data(v);t || (t = new n(this), m(this).data(v, t)), "toggle" === e && t[e]();
			});
		}, o(n, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }]), n;
	}(), m(document).on(O.CLICK_DATA_API, D, function (t) {
		t.preventDefault();var e = t.target;m(e).hasClass(I) || (e = m(e).closest(N)), k._jQueryInterface.call(m(e), "toggle");
	}).on(O.FOCUS_BLUR_DATA_API, D, function (t) {
		var e = m(t.target).closest(N)[0];m(e).toggleClass(A, /^focus(in)?$/.test(t.type));
	}), m.fn[p] = k._jQueryInterface, m.fn[p].Constructor = k, m.fn[p].noConflict = function () {
		return m.fn[p] = T, k._jQueryInterface;
	}, k),
	    Dn = (L = "carousel", R = "." + (j = "bs.carousel"), H = ".data-api", W = (P = e).fn[L], M = { interval: 5e3, keyboard: !0, slide: !1, pause: "hover", wrap: !0 }, x = { interval: "(number|boolean)", keyboard: "boolean", slide: "(boolean|string)", pause: "(string|boolean)", wrap: "boolean" }, U = "next", K = "prev", F = "left", V = "right", Q = { SLIDE: "slide" + R, SLID: "slid" + R, KEYDOWN: "keydown" + R, MOUSEENTER: "mouseenter" + R, MOUSELEAVE: "mouseleave" + R, TOUCHEND: "touchend" + R, LOAD_DATA_API: "load" + R + H, CLICK_DATA_API: "click" + R + H }, B = "carousel", Y = "active", G = "slide", q = "carousel-item-right", z = "carousel-item-left", X = "carousel-item-next", J = "carousel-item-prev", Z = { ACTIVE: ".active", ACTIVE_ITEM: ".active.carousel-item", ITEM: ".carousel-item", NEXT_PREV: ".carousel-item-next, .carousel-item-prev", INDICATORS: ".carousel-indicators", DATA_SLIDE: "[data-slide], [data-slide-to]", DATA_RIDE: '[data-ride="carousel"]' }, $ = function () {
		function s(t, e) {
			this._items = null, this._interval = null, this._activeElement = null, this._isPaused = !1, this._isSliding = !1, this.touchTimeout = null, this._config = this._getConfig(e), this._element = P(t)[0], this._indicatorsElement = P(this._element).find(Z.INDICATORS)[0], this._addEventListeners();
		}var t = s.prototype;return t.next = function () {
			this._isSliding || this._slide(U);
		}, t.nextWhenVisible = function () {
			!document.hidden && P(this._element).is(":visible") && "hidden" !== P(this._element).css("visibility") && this.next();
		}, t.prev = function () {
			this._isSliding || this._slide(K);
		}, t.pause = function (t) {
			t || (this._isPaused = !0), P(this._element).find(Z.NEXT_PREV)[0] && (Cn.triggerTransitionEnd(this._element), this.cycle(!0)), clearInterval(this._interval), this._interval = null;
		}, t.cycle = function (t) {
			t || (this._isPaused = !1), this._interval && (clearInterval(this._interval), this._interval = null), this._config.interval && !this._isPaused && (this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval));
		}, t.to = function (t) {
			var e = this;this._activeElement = P(this._element).find(Z.ACTIVE_ITEM)[0];var n = this._getItemIndex(this._activeElement);if (!(t > this._items.length - 1 || t < 0)) if (this._isSliding) P(this._element).one(Q.SLID, function () {
				return e.to(t);
			});else {
				if (n === t) return this.pause(), void this.cycle();var i = n < t ? U : K;this._slide(i, this._items[t]);
			}
		}, t.dispose = function () {
			P(this._element).off(R), P.removeData(this._element, j), this._items = null, this._config = null, this._element = null, this._interval = null, this._isPaused = null, this._isSliding = null, this._activeElement = null, this._indicatorsElement = null;
		}, t._getConfig = function (t) {
			return t = h({}, M, t), Cn.typeCheckConfig(L, t, x), t;
		}, t._addEventListeners = function () {
			var e = this;this._config.keyboard && P(this._element).on(Q.KEYDOWN, function (t) {
				return e._keydown(t);
			}), "hover" === this._config.pause && (P(this._element).on(Q.MOUSEENTER, function (t) {
				return e.pause(t);
			}).on(Q.MOUSELEAVE, function (t) {
				return e.cycle(t);
			}), "ontouchstart" in document.documentElement && P(this._element).on(Q.TOUCHEND, function () {
				e.pause(), e.touchTimeout && clearTimeout(e.touchTimeout), e.touchTimeout = setTimeout(function (t) {
					return e.cycle(t);
				}, 500 + e._config.interval);
			}));
		}, t._keydown = function (t) {
			if (!/input|textarea/i.test(t.target.tagName)) switch (t.which) {case 37:
					t.preventDefault(), this.prev();break;case 39:
					t.preventDefault(), this.next();}
		}, t._getItemIndex = function (t) {
			return this._items = P.makeArray(P(t).parent().find(Z.ITEM)), this._items.indexOf(t);
		}, t._getItemByDirection = function (t, e) {
			var n = t === U,
			    i = t === K,
			    r = this._getItemIndex(e),
			    s = this._items.length - 1;if ((i && 0 === r || n && r === s) && !this._config.wrap) return e;var o = (r + (t === K ? -1 : 1)) % this._items.length;return -1 === o ? this._items[this._items.length - 1] : this._items[o];
		}, t._triggerSlideEvent = function (t, e) {
			var n = this._getItemIndex(t),
			    i = this._getItemIndex(P(this._element).find(Z.ACTIVE_ITEM)[0]),
			    r = P.Event(Q.SLIDE, { relatedTarget: t, direction: e, from: i, to: n });return P(this._element).trigger(r), r;
		}, t._setActiveIndicatorElement = function (t) {
			if (this._indicatorsElement) {
				P(this._indicatorsElement).find(Z.ACTIVE).removeClass(Y);var e = this._indicatorsElement.children[this._getItemIndex(t)];e && P(e).addClass(Y);
			}
		}, t._slide = function (t, e) {
			var n,
			    i,
			    r,
			    s = this,
			    o = P(this._element).find(Z.ACTIVE_ITEM)[0],
			    a = this._getItemIndex(o),
			    l = e || o && this._getItemByDirection(t, o),
			    h = this._getItemIndex(l),
			    c = Boolean(this._interval);if (t === U ? (n = z, i = X, r = F) : (n = q, i = J, r = V), l && P(l).hasClass(Y)) this._isSliding = !1;else if (!this._triggerSlideEvent(l, r).isDefaultPrevented() && o && l) {
				this._isSliding = !0, c && this.pause(), this._setActiveIndicatorElement(l);var u = P.Event(Q.SLID, { relatedTarget: l, direction: r, from: a, to: h });if (P(this._element).hasClass(G)) {
					P(l).addClass(i), Cn.reflow(l), P(o).addClass(n), P(l).addClass(n);var f = Cn.getTransitionDurationFromElement(o);P(o).one(Cn.TRANSITION_END, function () {
						P(l).removeClass(n + " " + i).addClass(Y), P(o).removeClass(Y + " " + i + " " + n), s._isSliding = !1, setTimeout(function () {
							return P(s._element).trigger(u);
						}, 0);
					}).emulateTransitionEnd(f);
				} else P(o).removeClass(Y), P(l).addClass(Y), this._isSliding = !1, P(this._element).trigger(u);c && this.cycle();
			}
		}, s._jQueryInterface = function (i) {
			return this.each(function () {
				var t = P(this).data(j),
				    e = h({}, M, P(this).data());"object" == (typeof i === 'undefined' ? 'undefined' : _typeof(i)) && (e = h({}, e, i));var n = "string" == typeof i ? i : e.slide;if (t || (t = new s(this, e), P(this).data(j, t)), "number" == typeof i) t.to(i);else if ("string" == typeof n) {
					if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');t[n]();
				} else e.interval && (t.pause(), t.cycle());
			});
		}, s._dataApiClickHandler = function (t) {
			var e = Cn.getSelectorFromElement(this);if (e) {
				var n = P(e)[0];if (n && P(n).hasClass(B)) {
					var i = h({}, P(n).data(), P(this).data()),
					    r = this.getAttribute("data-slide-to");r && (i.interval = !1), s._jQueryInterface.call(P(n), i), r && P(n).data(j).to(r), t.preventDefault();
				}
			}
		}, o(s, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }, { key: "Default", get: function get() {
				return M;
			} }]), s;
	}(), P(document).on(Q.CLICK_DATA_API, Z.DATA_SLIDE, $._dataApiClickHandler), P(window).on(Q.LOAD_DATA_API, function () {
		P(Z.DATA_RIDE).each(function () {
			var t = P(this);$._jQueryInterface.call(t, t.data());
		});
	}), P.fn[L] = $._jQueryInterface, P.fn[L].Constructor = $, P.fn[L].noConflict = function () {
		return P.fn[L] = W, $._jQueryInterface;
	}, $),
	    bn = (et = "collapse", it = "." + (nt = "bs.collapse"), rt = (tt = e).fn[et], st = { toggle: !0, parent: "" }, ot = { toggle: "boolean", parent: "(string|element)" }, at = { SHOW: "show" + it, SHOWN: "shown" + it, HIDE: "hide" + it, HIDDEN: "hidden" + it, CLICK_DATA_API: "click" + it + ".data-api" }, lt = "show", ht = "collapse", ct = "collapsing", ut = "collapsed", ft = "width", dt = "height", _t = { ACTIVES: ".show, .collapsing", DATA_TOGGLE: '[data-toggle="collapse"]' }, gt = function () {
		function a(t, e) {
			this._isTransitioning = !1, this._element = t, this._config = this._getConfig(e), this._triggerArray = tt.makeArray(tt('[data-toggle="collapse"][href="#' + t.id + '"],[data-toggle="collapse"][data-target="#' + t.id + '"]'));for (var n = tt(_t.DATA_TOGGLE), i = 0; i < n.length; i++) {
				var r = n[i],
				    s = Cn.getSelectorFromElement(r);null !== s && 0 < tt(s).filter(t).length && (this._selector = s, this._triggerArray.push(r));
			}this._parent = this._config.parent ? this._getParent() : null, this._config.parent || this._addAriaAndCollapsedClass(this._element, this._triggerArray), this._config.toggle && this.toggle();
		}var t = a.prototype;return t.toggle = function () {
			tt(this._element).hasClass(lt) ? this.hide() : this.show();
		}, t.show = function () {
			var t,
			    e,
			    n = this;if (!this._isTransitioning && !tt(this._element).hasClass(lt) && (this._parent && 0 === (t = tt.makeArray(tt(this._parent).find(_t.ACTIVES).filter('[data-parent="' + this._config.parent + '"]'))).length && (t = null), !(t && (e = tt(t).not(this._selector).data(nt)) && e._isTransitioning))) {
				var i = tt.Event(at.SHOW);if (tt(this._element).trigger(i), !i.isDefaultPrevented()) {
					t && (a._jQueryInterface.call(tt(t).not(this._selector), "hide"), e || tt(t).data(nt, null));var r = this._getDimension();tt(this._element).removeClass(ht).addClass(ct), (this._element.style[r] = 0) < this._triggerArray.length && tt(this._triggerArray).removeClass(ut).attr("aria-expanded", !0), this.setTransitioning(!0);var s = "scroll" + (r[0].toUpperCase() + r.slice(1)),
					    o = Cn.getTransitionDurationFromElement(this._element);tt(this._element).one(Cn.TRANSITION_END, function () {
						tt(n._element).removeClass(ct).addClass(ht).addClass(lt), n._element.style[r] = "", n.setTransitioning(!1), tt(n._element).trigger(at.SHOWN);
					}).emulateTransitionEnd(o), this._element.style[r] = this._element[s] + "px";
				}
			}
		}, t.hide = function () {
			var t = this;if (!this._isTransitioning && tt(this._element).hasClass(lt)) {
				var e = tt.Event(at.HIDE);if (tt(this._element).trigger(e), !e.isDefaultPrevented()) {
					var n = this._getDimension();if (this._element.style[n] = this._element.getBoundingClientRect()[n] + "px", Cn.reflow(this._element), tt(this._element).addClass(ct).removeClass(ht).removeClass(lt), 0 < this._triggerArray.length) for (var i = 0; i < this._triggerArray.length; i++) {
						var r = this._triggerArray[i],
						    s = Cn.getSelectorFromElement(r);if (null !== s) tt(s).hasClass(lt) || tt(r).addClass(ut).attr("aria-expanded", !1);
					}this.setTransitioning(!0);this._element.style[n] = "";var o = Cn.getTransitionDurationFromElement(this._element);tt(this._element).one(Cn.TRANSITION_END, function () {
						t.setTransitioning(!1), tt(t._element).removeClass(ct).addClass(ht).trigger(at.HIDDEN);
					}).emulateTransitionEnd(o);
				}
			}
		}, t.setTransitioning = function (t) {
			this._isTransitioning = t;
		}, t.dispose = function () {
			tt.removeData(this._element, nt), this._config = null, this._parent = null, this._element = null, this._triggerArray = null, this._isTransitioning = null;
		}, t._getConfig = function (t) {
			return (t = h({}, st, t)).toggle = Boolean(t.toggle), Cn.typeCheckConfig(et, t, ot), t;
		}, t._getDimension = function () {
			return tt(this._element).hasClass(ft) ? ft : dt;
		}, t._getParent = function () {
			var n = this,
			    t = null;Cn.isElement(this._config.parent) ? (t = this._config.parent, "undefined" != typeof this._config.parent.jquery && (t = this._config.parent[0])) : t = tt(this._config.parent)[0];var e = '[data-toggle="collapse"][data-parent="' + this._config.parent + '"]';return tt(t).find(e).each(function (t, e) {
				n._addAriaAndCollapsedClass(a._getTargetFromElement(e), [e]);
			}), t;
		}, t._addAriaAndCollapsedClass = function (t, e) {
			if (t) {
				var n = tt(t).hasClass(lt);0 < e.length && tt(e).toggleClass(ut, !n).attr("aria-expanded", n);
			}
		}, a._getTargetFromElement = function (t) {
			var e = Cn.getSelectorFromElement(t);return e ? tt(e)[0] : null;
		}, a._jQueryInterface = function (i) {
			return this.each(function () {
				var t = tt(this),
				    e = t.data(nt),
				    n = h({}, st, t.data(), "object" == (typeof i === 'undefined' ? 'undefined' : _typeof(i)) && i ? i : {});if (!e && n.toggle && /show|hide/.test(i) && (n.toggle = !1), e || (e = new a(this, n), t.data(nt, e)), "string" == typeof i) {
					if ("undefined" == typeof e[i]) throw new TypeError('No method named "' + i + '"');e[i]();
				}
			});
		}, o(a, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }, { key: "Default", get: function get() {
				return st;
			} }]), a;
	}(), tt(document).on(at.CLICK_DATA_API, _t.DATA_TOGGLE, function (t) {
		"A" === t.currentTarget.tagName && t.preventDefault();var n = tt(this),
		    e = Cn.getSelectorFromElement(this);tt(e).each(function () {
			var t = tt(this),
			    e = t.data(nt) ? "toggle" : n.data();gt._jQueryInterface.call(t, e);
		});
	}), tt.fn[et] = gt._jQueryInterface, tt.fn[et].Constructor = gt, tt.fn[et].noConflict = function () {
		return tt.fn[et] = rt, gt._jQueryInterface;
	}, gt),
	    Sn = (pt = "dropdown", Et = "." + (vt = "bs.dropdown"), yt = ".data-api", Tt = (mt = e).fn[pt], Ct = new RegExp("38|40|27"), It = { HIDE: "hide" + Et, HIDDEN: "hidden" + Et, SHOW: "show" + Et, SHOWN: "shown" + Et, CLICK: "click" + Et, CLICK_DATA_API: "click" + Et + yt, KEYDOWN_DATA_API: "keydown" + Et + yt, KEYUP_DATA_API: "keyup" + Et + yt }, At = "disabled", Dt = "show", bt = "dropup", St = "dropright", wt = "dropleft", Nt = "dropdown-menu-right", Ot = "position-static", kt = '[data-toggle="dropdown"]', Pt = ".dropdown form", Lt = ".dropdown-menu", jt = ".navbar-nav", Rt = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)", Ht = "top-start", Wt = "top-end", Mt = "bottom-start", xt = "bottom-end", Ut = "right-start", Kt = "left-start", Ft = { offset: 0, flip: !0, boundary: "scrollParent", reference: "toggle", display: "dynamic" }, Vt = { offset: "(number|string|function)", flip: "boolean", boundary: "(string|element)", reference: "(string|element)", display: "string" }, Qt = function () {
		function l(t, e) {
			this._element = t, this._popper = null, this._config = this._getConfig(e), this._menu = this._getMenuElement(), this._inNavbar = this._detectNavbar(), this._addEventListeners();
		}var t = l.prototype;return t.toggle = function () {
			if (!this._element.disabled && !mt(this._element).hasClass(At)) {
				var t = l._getParentFromElement(this._element),
				    e = mt(this._menu).hasClass(Dt);if (l._clearMenus(), !e) {
					var n = { relatedTarget: this._element },
					    i = mt.Event(It.SHOW, n);if (mt(t).trigger(i), !i.isDefaultPrevented()) {
						if (!this._inNavbar) {
							if ("undefined" == typeof c) throw new TypeError("Bootstrap dropdown require Popper.js (https://popper.js.org)");var r = this._element;"parent" === this._config.reference ? r = t : Cn.isElement(this._config.reference) && (r = this._config.reference, "undefined" != typeof this._config.reference.jquery && (r = this._config.reference[0])), "scrollParent" !== this._config.boundary && mt(t).addClass(Ot), this._popper = new c(r, this._menu, this._getPopperConfig());
						}"ontouchstart" in document.documentElement && 0 === mt(t).closest(jt).length && mt(document.body).children().on("mouseover", null, mt.noop), this._element.focus(), this._element.setAttribute("aria-expanded", !0), mt(this._menu).toggleClass(Dt), mt(t).toggleClass(Dt).trigger(mt.Event(It.SHOWN, n));
					}
				}
			}
		}, t.dispose = function () {
			mt.removeData(this._element, vt), mt(this._element).off(Et), this._element = null, (this._menu = null) !== this._popper && (this._popper.destroy(), this._popper = null);
		}, t.update = function () {
			this._inNavbar = this._detectNavbar(), null !== this._popper && this._popper.scheduleUpdate();
		}, t._addEventListeners = function () {
			var e = this;mt(this._element).on(It.CLICK, function (t) {
				t.preventDefault(), t.stopPropagation(), e.toggle();
			});
		}, t._getConfig = function (t) {
			return t = h({}, this.constructor.Default, mt(this._element).data(), t), Cn.typeCheckConfig(pt, t, this.constructor.DefaultType), t;
		}, t._getMenuElement = function () {
			if (!this._menu) {
				var t = l._getParentFromElement(this._element);this._menu = mt(t).find(Lt)[0];
			}return this._menu;
		}, t._getPlacement = function () {
			var t = mt(this._element).parent(),
			    e = Mt;return t.hasClass(bt) ? (e = Ht, mt(this._menu).hasClass(Nt) && (e = Wt)) : t.hasClass(St) ? e = Ut : t.hasClass(wt) ? e = Kt : mt(this._menu).hasClass(Nt) && (e = xt), e;
		}, t._detectNavbar = function () {
			return 0 < mt(this._element).closest(".navbar").length;
		}, t._getPopperConfig = function () {
			var e = this,
			    t = {};"function" == typeof this._config.offset ? t.fn = function (t) {
				return t.offsets = h({}, t.offsets, e._config.offset(t.offsets) || {}), t;
			} : t.offset = this._config.offset;var n = { placement: this._getPlacement(), modifiers: { offset: t, flip: { enabled: this._config.flip }, preventOverflow: { boundariesElement: this._config.boundary } } };return "static" === this._config.display && (n.modifiers.applyStyle = { enabled: !1 }), n;
		}, l._jQueryInterface = function (e) {
			return this.each(function () {
				var t = mt(this).data(vt);if (t || (t = new l(this, "object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e)) ? e : null), mt(this).data(vt, t)), "string" == typeof e) {
					if ("undefined" == typeof t[e]) throw new TypeError('No method named "' + e + '"');t[e]();
				}
			});
		}, l._clearMenus = function (t) {
			if (!t || 3 !== t.which && ("keyup" !== t.type || 9 === t.which)) for (var e = mt.makeArray(mt(kt)), n = 0; n < e.length; n++) {
				var i = l._getParentFromElement(e[n]),
				    r = mt(e[n]).data(vt),
				    s = { relatedTarget: e[n] };if (r) {
					var o = r._menu;if (mt(i).hasClass(Dt) && !(t && ("click" === t.type && /input|textarea/i.test(t.target.tagName) || "keyup" === t.type && 9 === t.which) && mt.contains(i, t.target))) {
						var a = mt.Event(It.HIDE, s);mt(i).trigger(a), a.isDefaultPrevented() || ("ontouchstart" in document.documentElement && mt(document.body).children().off("mouseover", null, mt.noop), e[n].setAttribute("aria-expanded", "false"), mt(o).removeClass(Dt), mt(i).removeClass(Dt).trigger(mt.Event(It.HIDDEN, s)));
					}
				}
			}
		}, l._getParentFromElement = function (t) {
			var e,
			    n = Cn.getSelectorFromElement(t);return n && (e = mt(n)[0]), e || t.parentNode;
		}, l._dataApiKeydownHandler = function (t) {
			if ((/input|textarea/i.test(t.target.tagName) ? !(32 === t.which || 27 !== t.which && (40 !== t.which && 38 !== t.which || mt(t.target).closest(Lt).length)) : Ct.test(t.which)) && (t.preventDefault(), t.stopPropagation(), !this.disabled && !mt(this).hasClass(At))) {
				var e = l._getParentFromElement(this),
				    n = mt(e).hasClass(Dt);if ((n || 27 === t.which && 32 === t.which) && (!n || 27 !== t.which && 32 !== t.which)) {
					var i = mt(e).find(Rt).get();if (0 !== i.length) {
						var r = i.indexOf(t.target);38 === t.which && 0 < r && r--, 40 === t.which && r < i.length - 1 && r++, r < 0 && (r = 0), i[r].focus();
					}
				} else {
					if (27 === t.which) {
						var s = mt(e).find(kt)[0];mt(s).trigger("focus");
					}mt(this).trigger("click");
				}
			}
		}, o(l, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }, { key: "Default", get: function get() {
				return Ft;
			} }, { key: "DefaultType", get: function get() {
				return Vt;
			} }]), l;
	}(), mt(document).on(It.KEYDOWN_DATA_API, kt, Qt._dataApiKeydownHandler).on(It.KEYDOWN_DATA_API, Lt, Qt._dataApiKeydownHandler).on(It.CLICK_DATA_API + " " + It.KEYUP_DATA_API, Qt._clearMenus).on(It.CLICK_DATA_API, kt, function (t) {
		t.preventDefault(), t.stopPropagation(), Qt._jQueryInterface.call(mt(this), "toggle");
	}).on(It.CLICK_DATA_API, Pt, function (t) {
		t.stopPropagation();
	}), mt.fn[pt] = Qt._jQueryInterface, mt.fn[pt].Constructor = Qt, mt.fn[pt].noConflict = function () {
		return mt.fn[pt] = Tt, Qt._jQueryInterface;
	}, Qt),
	    wn = (Yt = "modal", qt = "." + (Gt = "bs.modal"), zt = (Bt = e).fn[Yt], Xt = { backdrop: !0, keyboard: !0, focus: !0, show: !0 }, Jt = { backdrop: "(boolean|string)", keyboard: "boolean", focus: "boolean", show: "boolean" }, Zt = { HIDE: "hide" + qt, HIDDEN: "hidden" + qt, SHOW: "show" + qt, SHOWN: "shown" + qt, FOCUSIN: "focusin" + qt, RESIZE: "resize" + qt, CLICK_DISMISS: "click.dismiss" + qt, KEYDOWN_DISMISS: "keydown.dismiss" + qt, MOUSEUP_DISMISS: "mouseup.dismiss" + qt, MOUSEDOWN_DISMISS: "mousedown.dismiss" + qt, CLICK_DATA_API: "click" + qt + ".data-api" }, $t = "modal-scrollbar-measure", te = "modal-backdrop", ee = "modal-open", ne = "fade", ie = "show", re = { DIALOG: ".modal-dialog", DATA_TOGGLE: '[data-toggle="modal"]', DATA_DISMISS: '[data-dismiss="modal"]', FIXED_CONTENT: ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top", STICKY_CONTENT: ".sticky-top", NAVBAR_TOGGLER: ".navbar-toggler" }, se = function () {
		function r(t, e) {
			this._config = this._getConfig(e), this._element = t, this._dialog = Bt(t).find(re.DIALOG)[0], this._backdrop = null, this._isShown = !1, this._isBodyOverflowing = !1, this._ignoreBackdropClick = !1, this._scrollbarWidth = 0;
		}var t = r.prototype;return t.toggle = function (t) {
			return this._isShown ? this.hide() : this.show(t);
		}, t.show = function (t) {
			var e = this;if (!this._isTransitioning && !this._isShown) {
				Bt(this._element).hasClass(ne) && (this._isTransitioning = !0);var n = Bt.Event(Zt.SHOW, { relatedTarget: t });Bt(this._element).trigger(n), this._isShown || n.isDefaultPrevented() || (this._isShown = !0, this._checkScrollbar(), this._setScrollbar(), this._adjustDialog(), Bt(document.body).addClass(ee), this._setEscapeEvent(), this._setResizeEvent(), Bt(this._element).on(Zt.CLICK_DISMISS, re.DATA_DISMISS, function (t) {
					return e.hide(t);
				}), Bt(this._dialog).on(Zt.MOUSEDOWN_DISMISS, function () {
					Bt(e._element).one(Zt.MOUSEUP_DISMISS, function (t) {
						Bt(t.target).is(e._element) && (e._ignoreBackdropClick = !0);
					});
				}), this._showBackdrop(function () {
					return e._showElement(t);
				}));
			}
		}, t.hide = function (t) {
			var e = this;if (t && t.preventDefault(), !this._isTransitioning && this._isShown) {
				var n = Bt.Event(Zt.HIDE);if (Bt(this._element).trigger(n), this._isShown && !n.isDefaultPrevented()) {
					this._isShown = !1;var i = Bt(this._element).hasClass(ne);if (i && (this._isTransitioning = !0), this._setEscapeEvent(), this._setResizeEvent(), Bt(document).off(Zt.FOCUSIN), Bt(this._element).removeClass(ie), Bt(this._element).off(Zt.CLICK_DISMISS), Bt(this._dialog).off(Zt.MOUSEDOWN_DISMISS), i) {
						var r = Cn.getTransitionDurationFromElement(this._element);Bt(this._element).one(Cn.TRANSITION_END, function (t) {
							return e._hideModal(t);
						}).emulateTransitionEnd(r);
					} else this._hideModal();
				}
			}
		}, t.dispose = function () {
			Bt.removeData(this._element, Gt), Bt(window, document, this._element, this._backdrop).off(qt), this._config = null, this._element = null, this._dialog = null, this._backdrop = null, this._isShown = null, this._isBodyOverflowing = null, this._ignoreBackdropClick = null, this._scrollbarWidth = null;
		}, t.handleUpdate = function () {
			this._adjustDialog();
		}, t._getConfig = function (t) {
			return t = h({}, Xt, t), Cn.typeCheckConfig(Yt, t, Jt), t;
		}, t._showElement = function (t) {
			var e = this,
			    n = Bt(this._element).hasClass(ne);this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE || document.body.appendChild(this._element), this._element.style.display = "block", this._element.removeAttribute("aria-hidden"), this._element.scrollTop = 0, n && Cn.reflow(this._element), Bt(this._element).addClass(ie), this._config.focus && this._enforceFocus();var i = Bt.Event(Zt.SHOWN, { relatedTarget: t }),
			    r = function r() {
				e._config.focus && e._element.focus(), e._isTransitioning = !1, Bt(e._element).trigger(i);
			};if (n) {
				var s = Cn.getTransitionDurationFromElement(this._element);Bt(this._dialog).one(Cn.TRANSITION_END, r).emulateTransitionEnd(s);
			} else r();
		}, t._enforceFocus = function () {
			var e = this;Bt(document).off(Zt.FOCUSIN).on(Zt.FOCUSIN, function (t) {
				document !== t.target && e._element !== t.target && 0 === Bt(e._element).has(t.target).length && e._element.focus();
			});
		}, t._setEscapeEvent = function () {
			var e = this;this._isShown && this._config.keyboard ? Bt(this._element).on(Zt.KEYDOWN_DISMISS, function (t) {
				27 === t.which && (t.preventDefault(), e.hide());
			}) : this._isShown || Bt(this._element).off(Zt.KEYDOWN_DISMISS);
		}, t._setResizeEvent = function () {
			var e = this;this._isShown ? Bt(window).on(Zt.RESIZE, function (t) {
				return e.handleUpdate(t);
			}) : Bt(window).off(Zt.RESIZE);
		}, t._hideModal = function () {
			var t = this;this._element.style.display = "none", this._element.setAttribute("aria-hidden", !0), this._isTransitioning = !1, this._showBackdrop(function () {
				Bt(document.body).removeClass(ee), t._resetAdjustments(), t._resetScrollbar(), Bt(t._element).trigger(Zt.HIDDEN);
			});
		}, t._removeBackdrop = function () {
			this._backdrop && (Bt(this._backdrop).remove(), this._backdrop = null);
		}, t._showBackdrop = function (t) {
			var e = this,
			    n = Bt(this._element).hasClass(ne) ? ne : "";if (this._isShown && this._config.backdrop) {
				if (this._backdrop = document.createElement("div"), this._backdrop.className = te, n && Bt(this._backdrop).addClass(n), Bt(this._backdrop).appendTo(document.body), Bt(this._element).on(Zt.CLICK_DISMISS, function (t) {
					e._ignoreBackdropClick ? e._ignoreBackdropClick = !1 : t.target === t.currentTarget && ("static" === e._config.backdrop ? e._element.focus() : e.hide());
				}), n && Cn.reflow(this._backdrop), Bt(this._backdrop).addClass(ie), !t) return;if (!n) return void t();var i = Cn.getTransitionDurationFromElement(this._backdrop);Bt(this._backdrop).one(Cn.TRANSITION_END, t).emulateTransitionEnd(i);
			} else if (!this._isShown && this._backdrop) {
				Bt(this._backdrop).removeClass(ie);var r = function r() {
					e._removeBackdrop(), t && t();
				};if (Bt(this._element).hasClass(ne)) {
					var s = Cn.getTransitionDurationFromElement(this._backdrop);Bt(this._backdrop).one(Cn.TRANSITION_END, r).emulateTransitionEnd(s);
				} else r();
			} else t && t();
		}, t._adjustDialog = function () {
			var t = this._element.scrollHeight > document.documentElement.clientHeight;!this._isBodyOverflowing && t && (this._element.style.paddingLeft = this._scrollbarWidth + "px"), this._isBodyOverflowing && !t && (this._element.style.paddingRight = this._scrollbarWidth + "px");
		}, t._resetAdjustments = function () {
			this._element.style.paddingLeft = "", this._element.style.paddingRight = "";
		}, t._checkScrollbar = function () {
			var t = document.body.getBoundingClientRect();this._isBodyOverflowing = t.left + t.right < window.innerWidth, this._scrollbarWidth = this._getScrollbarWidth();
		}, t._setScrollbar = function () {
			var r = this;if (this._isBodyOverflowing) {
				Bt(re.FIXED_CONTENT).each(function (t, e) {
					var n = Bt(e)[0].style.paddingRight,
					    i = Bt(e).css("padding-right");Bt(e).data("padding-right", n).css("padding-right", parseFloat(i) + r._scrollbarWidth + "px");
				}), Bt(re.STICKY_CONTENT).each(function (t, e) {
					var n = Bt(e)[0].style.marginRight,
					    i = Bt(e).css("margin-right");Bt(e).data("margin-right", n).css("margin-right", parseFloat(i) - r._scrollbarWidth + "px");
				}), Bt(re.NAVBAR_TOGGLER).each(function (t, e) {
					var n = Bt(e)[0].style.marginRight,
					    i = Bt(e).css("margin-right");Bt(e).data("margin-right", n).css("margin-right", parseFloat(i) + r._scrollbarWidth + "px");
				});var t = document.body.style.paddingRight,
				    e = Bt(document.body).css("padding-right");Bt(document.body).data("padding-right", t).css("padding-right", parseFloat(e) + this._scrollbarWidth + "px");
			}
		}, t._resetScrollbar = function () {
			Bt(re.FIXED_CONTENT).each(function (t, e) {
				var n = Bt(e).data("padding-right");"undefined" != typeof n && Bt(e).css("padding-right", n).removeData("padding-right");
			}), Bt(re.STICKY_CONTENT + ", " + re.NAVBAR_TOGGLER).each(function (t, e) {
				var n = Bt(e).data("margin-right");"undefined" != typeof n && Bt(e).css("margin-right", n).removeData("margin-right");
			});var t = Bt(document.body).data("padding-right");"undefined" != typeof t && Bt(document.body).css("padding-right", t).removeData("padding-right");
		}, t._getScrollbarWidth = function () {
			var t = document.createElement("div");t.className = $t, document.body.appendChild(t);var e = t.getBoundingClientRect().width - t.clientWidth;return document.body.removeChild(t), e;
		}, r._jQueryInterface = function (n, i) {
			return this.each(function () {
				var t = Bt(this).data(Gt),
				    e = h({}, Xt, Bt(this).data(), "object" == (typeof n === 'undefined' ? 'undefined' : _typeof(n)) && n ? n : {});if (t || (t = new r(this, e), Bt(this).data(Gt, t)), "string" == typeof n) {
					if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');t[n](i);
				} else e.show && t.show(i);
			});
		}, o(r, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }, { key: "Default", get: function get() {
				return Xt;
			} }]), r;
	}(), Bt(document).on(Zt.CLICK_DATA_API, re.DATA_TOGGLE, function (t) {
		var e,
		    n = this,
		    i = Cn.getSelectorFromElement(this);i && (e = Bt(i)[0]);var r = Bt(e).data(Gt) ? "toggle" : h({}, Bt(e).data(), Bt(this).data());"A" !== this.tagName && "AREA" !== this.tagName || t.preventDefault();var s = Bt(e).one(Zt.SHOW, function (t) {
			t.isDefaultPrevented() || s.one(Zt.HIDDEN, function () {
				Bt(n).is(":visible") && n.focus();
			});
		});se._jQueryInterface.call(Bt(e), r, this);
	}), Bt.fn[Yt] = se._jQueryInterface, Bt.fn[Yt].Constructor = se, Bt.fn[Yt].noConflict = function () {
		return Bt.fn[Yt] = zt, se._jQueryInterface;
	}, se),
	    Nn = (ae = "tooltip", he = "." + (le = "bs.tooltip"), ce = (oe = e).fn[ae], ue = "bs-tooltip", fe = new RegExp("(^|\\s)" + ue + "\\S+", "g"), ge = { animation: !0, template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>', trigger: "hover focus", title: "", delay: 0, html: !(_e = { AUTO: "auto", TOP: "top", RIGHT: "right", BOTTOM: "bottom", LEFT: "left" }), selector: !(de = { animation: "boolean", template: "string", title: "(string|element|function)", trigger: "string", delay: "(number|object)", html: "boolean", selector: "(string|boolean)", placement: "(string|function)", offset: "(number|string)", container: "(string|element|boolean)", fallbackPlacement: "(string|array)", boundary: "(string|element)" }), placement: "top", offset: 0, container: !1, fallbackPlacement: "flip", boundary: "scrollParent" }, pe = "out", ve = { HIDE: "hide" + he, HIDDEN: "hidden" + he, SHOW: (me = "show") + he, SHOWN: "shown" + he, INSERTED: "inserted" + he, CLICK: "click" + he, FOCUSIN: "focusin" + he, FOCUSOUT: "focusout" + he, MOUSEENTER: "mouseenter" + he, MOUSELEAVE: "mouseleave" + he }, Ee = "fade", ye = "show", Te = ".tooltip-inner", Ce = ".arrow", Ie = "hover", Ae = "focus", De = "click", be = "manual", Se = function () {
		function i(t, e) {
			if ("undefined" == typeof c) throw new TypeError("Bootstrap tooltips require Popper.js (https://popper.js.org)");this._isEnabled = !0, this._timeout = 0, this._hoverState = "", this._activeTrigger = {}, this._popper = null, this.element = t, this.config = this._getConfig(e), this.tip = null, this._setListeners();
		}var t = i.prototype;return t.enable = function () {
			this._isEnabled = !0;
		}, t.disable = function () {
			this._isEnabled = !1;
		}, t.toggleEnabled = function () {
			this._isEnabled = !this._isEnabled;
		}, t.toggle = function (t) {
			if (this._isEnabled) if (t) {
				var e = this.constructor.DATA_KEY,
				    n = oe(t.currentTarget).data(e);n || (n = new this.constructor(t.currentTarget, this._getDelegateConfig()), oe(t.currentTarget).data(e, n)), n._activeTrigger.click = !n._activeTrigger.click, n._isWithActiveTrigger() ? n._enter(null, n) : n._leave(null, n);
			} else {
				if (oe(this.getTipElement()).hasClass(ye)) return void this._leave(null, this);this._enter(null, this);
			}
		}, t.dispose = function () {
			clearTimeout(this._timeout), oe.removeData(this.element, this.constructor.DATA_KEY), oe(this.element).off(this.constructor.EVENT_KEY), oe(this.element).closest(".modal").off("hide.bs.modal"), this.tip && oe(this.tip).remove(), this._isEnabled = null, this._timeout = null, this._hoverState = null, (this._activeTrigger = null) !== this._popper && this._popper.destroy(), this._popper = null, this.element = null, this.config = null, this.tip = null;
		}, t.show = function () {
			var e = this;if ("none" === oe(this.element).css("display")) throw new Error("Please use show on visible elements");var t = oe.Event(this.constructor.Event.SHOW);if (this.isWithContent() && this._isEnabled) {
				oe(this.element).trigger(t);var n = oe.contains(this.element.ownerDocument.documentElement, this.element);if (t.isDefaultPrevented() || !n) return;var i = this.getTipElement(),
				    r = Cn.getUID(this.constructor.NAME);i.setAttribute("id", r), this.element.setAttribute("aria-describedby", r), this.setContent(), this.config.animation && oe(i).addClass(Ee);var s = "function" == typeof this.config.placement ? this.config.placement.call(this, i, this.element) : this.config.placement,
				    o = this._getAttachment(s);this.addAttachmentClass(o);var a = !1 === this.config.container ? document.body : oe(this.config.container);oe(i).data(this.constructor.DATA_KEY, this), oe.contains(this.element.ownerDocument.documentElement, this.tip) || oe(i).appendTo(a), oe(this.element).trigger(this.constructor.Event.INSERTED), this._popper = new c(this.element, i, { placement: o, modifiers: { offset: { offset: this.config.offset }, flip: { behavior: this.config.fallbackPlacement }, arrow: { element: Ce }, preventOverflow: { boundariesElement: this.config.boundary } }, onCreate: function onCreate(t) {
						t.originalPlacement !== t.placement && e._handlePopperPlacementChange(t);
					}, onUpdate: function onUpdate(t) {
						e._handlePopperPlacementChange(t);
					} }), oe(i).addClass(ye), "ontouchstart" in document.documentElement && oe(document.body).children().on("mouseover", null, oe.noop);var l = function l() {
					e.config.animation && e._fixTransition();var t = e._hoverState;e._hoverState = null, oe(e.element).trigger(e.constructor.Event.SHOWN), t === pe && e._leave(null, e);
				};if (oe(this.tip).hasClass(Ee)) {
					var h = Cn.getTransitionDurationFromElement(this.tip);oe(this.tip).one(Cn.TRANSITION_END, l).emulateTransitionEnd(h);
				} else l();
			}
		}, t.hide = function (t) {
			var e = this,
			    n = this.getTipElement(),
			    i = oe.Event(this.constructor.Event.HIDE),
			    r = function r() {
				e._hoverState !== me && n.parentNode && n.parentNode.removeChild(n), e._cleanTipClass(), e.element.removeAttribute("aria-describedby"), oe(e.element).trigger(e.constructor.Event.HIDDEN), null !== e._popper && e._popper.destroy(), t && t();
			};if (oe(this.element).trigger(i), !i.isDefaultPrevented()) {
				if (oe(n).removeClass(ye), "ontouchstart" in document.documentElement && oe(document.body).children().off("mouseover", null, oe.noop), this._activeTrigger[De] = !1, this._activeTrigger[Ae] = !1, this._activeTrigger[Ie] = !1, oe(this.tip).hasClass(Ee)) {
					var s = Cn.getTransitionDurationFromElement(n);oe(n).one(Cn.TRANSITION_END, r).emulateTransitionEnd(s);
				} else r();this._hoverState = "";
			}
		}, t.update = function () {
			null !== this._popper && this._popper.scheduleUpdate();
		}, t.isWithContent = function () {
			return Boolean(this.getTitle());
		}, t.addAttachmentClass = function (t) {
			oe(this.getTipElement()).addClass(ue + "-" + t);
		}, t.getTipElement = function () {
			return this.tip = this.tip || oe(this.config.template)[0], this.tip;
		}, t.setContent = function () {
			var t = oe(this.getTipElement());this.setElementContent(t.find(Te), this.getTitle()), t.removeClass(Ee + " " + ye);
		}, t.setElementContent = function (t, e) {
			var n = this.config.html;"object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e)) && (e.nodeType || e.jquery) ? n ? oe(e).parent().is(t) || t.empty().append(e) : t.text(oe(e).text()) : t[n ? "html" : "text"](e);
		}, t.getTitle = function () {
			var t = this.element.getAttribute("data-original-title");return t || (t = "function" == typeof this.config.title ? this.config.title.call(this.element) : this.config.title), t;
		}, t._getAttachment = function (t) {
			return _e[t.toUpperCase()];
		}, t._setListeners = function () {
			var i = this;this.config.trigger.split(" ").forEach(function (t) {
				if ("click" === t) oe(i.element).on(i.constructor.Event.CLICK, i.config.selector, function (t) {
					return i.toggle(t);
				});else if (t !== be) {
					var e = t === Ie ? i.constructor.Event.MOUSEENTER : i.constructor.Event.FOCUSIN,
					    n = t === Ie ? i.constructor.Event.MOUSELEAVE : i.constructor.Event.FOCUSOUT;oe(i.element).on(e, i.config.selector, function (t) {
						return i._enter(t);
					}).on(n, i.config.selector, function (t) {
						return i._leave(t);
					});
				}oe(i.element).closest(".modal").on("hide.bs.modal", function () {
					return i.hide();
				});
			}), this.config.selector ? this.config = h({}, this.config, { trigger: "manual", selector: "" }) : this._fixTitle();
		}, t._fixTitle = function () {
			var t = _typeof(this.element.getAttribute("data-original-title"));(this.element.getAttribute("title") || "string" !== t) && (this.element.setAttribute("data-original-title", this.element.getAttribute("title") || ""), this.element.setAttribute("title", ""));
		}, t._enter = function (t, e) {
			var n = this.constructor.DATA_KEY;(e = e || oe(t.currentTarget).data(n)) || (e = new this.constructor(t.currentTarget, this._getDelegateConfig()), oe(t.currentTarget).data(n, e)), t && (e._activeTrigger["focusin" === t.type ? Ae : Ie] = !0), oe(e.getTipElement()).hasClass(ye) || e._hoverState === me ? e._hoverState = me : (clearTimeout(e._timeout), e._hoverState = me, e.config.delay && e.config.delay.show ? e._timeout = setTimeout(function () {
				e._hoverState === me && e.show();
			}, e.config.delay.show) : e.show());
		}, t._leave = function (t, e) {
			var n = this.constructor.DATA_KEY;(e = e || oe(t.currentTarget).data(n)) || (e = new this.constructor(t.currentTarget, this._getDelegateConfig()), oe(t.currentTarget).data(n, e)), t && (e._activeTrigger["focusout" === t.type ? Ae : Ie] = !1), e._isWithActiveTrigger() || (clearTimeout(e._timeout), e._hoverState = pe, e.config.delay && e.config.delay.hide ? e._timeout = setTimeout(function () {
				e._hoverState === pe && e.hide();
			}, e.config.delay.hide) : e.hide());
		}, t._isWithActiveTrigger = function () {
			for (var t in this._activeTrigger) {
				if (this._activeTrigger[t]) return !0;
			}return !1;
		}, t._getConfig = function (t) {
			return "number" == typeof (t = h({}, this.constructor.Default, oe(this.element).data(), "object" == (typeof t === 'undefined' ? 'undefined' : _typeof(t)) && t ? t : {})).delay && (t.delay = { show: t.delay, hide: t.delay }), "number" == typeof t.title && (t.title = t.title.toString()), "number" == typeof t.content && (t.content = t.content.toString()), Cn.typeCheckConfig(ae, t, this.constructor.DefaultType), t;
		}, t._getDelegateConfig = function () {
			var t = {};if (this.config) for (var e in this.config) {
				this.constructor.Default[e] !== this.config[e] && (t[e] = this.config[e]);
			}return t;
		}, t._cleanTipClass = function () {
			var t = oe(this.getTipElement()),
			    e = t.attr("class").match(fe);null !== e && 0 < e.length && t.removeClass(e.join(""));
		}, t._handlePopperPlacementChange = function (t) {
			this._cleanTipClass(), this.addAttachmentClass(this._getAttachment(t.placement));
		}, t._fixTransition = function () {
			var t = this.getTipElement(),
			    e = this.config.animation;null === t.getAttribute("x-placement") && (oe(t).removeClass(Ee), this.config.animation = !1, this.hide(), this.show(), this.config.animation = e);
		}, i._jQueryInterface = function (n) {
			return this.each(function () {
				var t = oe(this).data(le),
				    e = "object" == (typeof n === 'undefined' ? 'undefined' : _typeof(n)) && n;if ((t || !/dispose|hide/.test(n)) && (t || (t = new i(this, e), oe(this).data(le, t)), "string" == typeof n)) {
					if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');t[n]();
				}
			});
		}, o(i, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }, { key: "Default", get: function get() {
				return ge;
			} }, { key: "NAME", get: function get() {
				return ae;
			} }, { key: "DATA_KEY", get: function get() {
				return le;
			} }, { key: "Event", get: function get() {
				return ve;
			} }, { key: "EVENT_KEY", get: function get() {
				return he;
			} }, { key: "DefaultType", get: function get() {
				return de;
			} }]), i;
	}(), oe.fn[ae] = Se._jQueryInterface, oe.fn[ae].Constructor = Se, oe.fn[ae].noConflict = function () {
		return oe.fn[ae] = ce, Se._jQueryInterface;
	}, Se),
	    On = (Ne = "popover", ke = "." + (Oe = "bs.popover"), Pe = (we = e).fn[Ne], Le = "bs-popover", je = new RegExp("(^|\\s)" + Le + "\\S+", "g"), Re = h({}, Nn.Default, { placement: "right", trigger: "click", content: "", template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>' }), He = h({}, Nn.DefaultType, { content: "(string|element|function)" }), We = "fade", xe = ".popover-header", Ue = ".popover-body", Ke = { HIDE: "hide" + ke, HIDDEN: "hidden" + ke, SHOW: (Me = "show") + ke, SHOWN: "shown" + ke, INSERTED: "inserted" + ke, CLICK: "click" + ke, FOCUSIN: "focusin" + ke, FOCUSOUT: "focusout" + ke, MOUSEENTER: "mouseenter" + ke, MOUSELEAVE: "mouseleave" + ke }, Fe = function (t) {
		var e, n;function i() {
			return t.apply(this, arguments) || this;
		}n = t, (e = i).prototype = Object.create(n.prototype), (e.prototype.constructor = e).__proto__ = n;var r = i.prototype;return r.isWithContent = function () {
			return this.getTitle() || this._getContent();
		}, r.addAttachmentClass = function (t) {
			we(this.getTipElement()).addClass(Le + "-" + t);
		}, r.getTipElement = function () {
			return this.tip = this.tip || we(this.config.template)[0], this.tip;
		}, r.setContent = function () {
			var t = we(this.getTipElement());this.setElementContent(t.find(xe), this.getTitle());var e = this._getContent();"function" == typeof e && (e = e.call(this.element)), this.setElementContent(t.find(Ue), e), t.removeClass(We + " " + Me);
		}, r._getContent = function () {
			return this.element.getAttribute("data-content") || this.config.content;
		}, r._cleanTipClass = function () {
			var t = we(this.getTipElement()),
			    e = t.attr("class").match(je);null !== e && 0 < e.length && t.removeClass(e.join(""));
		}, i._jQueryInterface = function (n) {
			return this.each(function () {
				var t = we(this).data(Oe),
				    e = "object" == (typeof n === 'undefined' ? 'undefined' : _typeof(n)) ? n : null;if ((t || !/destroy|hide/.test(n)) && (t || (t = new i(this, e), we(this).data(Oe, t)), "string" == typeof n)) {
					if ("undefined" == typeof t[n]) throw new TypeError('No method named "' + n + '"');t[n]();
				}
			});
		}, o(i, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }, { key: "Default", get: function get() {
				return Re;
			} }, { key: "NAME", get: function get() {
				return Ne;
			} }, { key: "DATA_KEY", get: function get() {
				return Oe;
			} }, { key: "Event", get: function get() {
				return Ke;
			} }, { key: "EVENT_KEY", get: function get() {
				return ke;
			} }, { key: "DefaultType", get: function get() {
				return He;
			} }]), i;
	}(Nn), we.fn[Ne] = Fe._jQueryInterface, we.fn[Ne].Constructor = Fe, we.fn[Ne].noConflict = function () {
		return we.fn[Ne] = Pe, Fe._jQueryInterface;
	}, Fe),
	    kn = (Qe = "scrollspy", Ye = "." + (Be = "bs.scrollspy"), Ge = (Ve = e).fn[Qe], qe = { offset: 10, method: "auto", target: "" }, ze = { offset: "number", method: "string", target: "(string|element)" }, Xe = { ACTIVATE: "activate" + Ye, SCROLL: "scroll" + Ye, LOAD_DATA_API: "load" + Ye + ".data-api" }, Je = "dropdown-item", Ze = "active", $e = { DATA_SPY: '[data-spy="scroll"]', ACTIVE: ".active", NAV_LIST_GROUP: ".nav, .list-group", NAV_LINKS: ".nav-link", NAV_ITEMS: ".nav-item", LIST_ITEMS: ".list-group-item", DROPDOWN: ".dropdown", DROPDOWN_ITEMS: ".dropdown-item", DROPDOWN_TOGGLE: ".dropdown-toggle" }, tn = "offset", en = "position", nn = function () {
		function n(t, e) {
			var n = this;this._element = t, this._scrollElement = "BODY" === t.tagName ? window : t, this._config = this._getConfig(e), this._selector = this._config.target + " " + $e.NAV_LINKS + "," + this._config.target + " " + $e.LIST_ITEMS + "," + this._config.target + " " + $e.DROPDOWN_ITEMS, this._offsets = [], this._targets = [], this._activeTarget = null, this._scrollHeight = 0, Ve(this._scrollElement).on(Xe.SCROLL, function (t) {
				return n._process(t);
			}), this.refresh(), this._process();
		}var t = n.prototype;return t.refresh = function () {
			var e = this,
			    t = this._scrollElement === this._scrollElement.window ? tn : en,
			    r = "auto" === this._config.method ? t : this._config.method,
			    s = r === en ? this._getScrollTop() : 0;this._offsets = [], this._targets = [], this._scrollHeight = this._getScrollHeight(), Ve.makeArray(Ve(this._selector)).map(function (t) {
				var e,
				    n = Cn.getSelectorFromElement(t);if (n && (e = Ve(n)[0]), e) {
					var i = e.getBoundingClientRect();if (i.width || i.height) return [Ve(e)[r]().top + s, n];
				}return null;
			}).filter(function (t) {
				return t;
			}).sort(function (t, e) {
				return t[0] - e[0];
			}).forEach(function (t) {
				e._offsets.push(t[0]), e._targets.push(t[1]);
			});
		}, t.dispose = function () {
			Ve.removeData(this._element, Be), Ve(this._scrollElement).off(Ye), this._element = null, this._scrollElement = null, this._config = null, this._selector = null, this._offsets = null, this._targets = null, this._activeTarget = null, this._scrollHeight = null;
		}, t._getConfig = function (t) {
			if ("string" != typeof (t = h({}, qe, "object" == (typeof t === 'undefined' ? 'undefined' : _typeof(t)) && t ? t : {})).target) {
				var e = Ve(t.target).attr("id");e || (e = Cn.getUID(Qe), Ve(t.target).attr("id", e)), t.target = "#" + e;
			}return Cn.typeCheckConfig(Qe, t, ze), t;
		}, t._getScrollTop = function () {
			return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop;
		}, t._getScrollHeight = function () {
			return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
		}, t._getOffsetHeight = function () {
			return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height;
		}, t._process = function () {
			var t = this._getScrollTop() + this._config.offset,
			    e = this._getScrollHeight(),
			    n = this._config.offset + e - this._getOffsetHeight();if (this._scrollHeight !== e && this.refresh(), n <= t) {
				var i = this._targets[this._targets.length - 1];this._activeTarget !== i && this._activate(i);
			} else {
				if (this._activeTarget && t < this._offsets[0] && 0 < this._offsets[0]) return this._activeTarget = null, void this._clear();for (var r = this._offsets.length; r--;) {
					this._activeTarget !== this._targets[r] && t >= this._offsets[r] && ("undefined" == typeof this._offsets[r + 1] || t < this._offsets[r + 1]) && this._activate(this._targets[r]);
				}
			}
		}, t._activate = function (e) {
			this._activeTarget = e, this._clear();var t = this._selector.split(",");t = t.map(function (t) {
				return t + '[data-target="' + e + '"],' + t + '[href="' + e + '"]';
			});var n = Ve(t.join(","));n.hasClass(Je) ? (n.closest($e.DROPDOWN).find($e.DROPDOWN_TOGGLE).addClass(Ze), n.addClass(Ze)) : (n.addClass(Ze), n.parents($e.NAV_LIST_GROUP).prev($e.NAV_LINKS + ", " + $e.LIST_ITEMS).addClass(Ze), n.parents($e.NAV_LIST_GROUP).prev($e.NAV_ITEMS).children($e.NAV_LINKS).addClass(Ze)), Ve(this._scrollElement).trigger(Xe.ACTIVATE, { relatedTarget: e });
		}, t._clear = function () {
			Ve(this._selector).filter($e.ACTIVE).removeClass(Ze);
		}, n._jQueryInterface = function (e) {
			return this.each(function () {
				var t = Ve(this).data(Be);if (t || (t = new n(this, "object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e)) && e), Ve(this).data(Be, t)), "string" == typeof e) {
					if ("undefined" == typeof t[e]) throw new TypeError('No method named "' + e + '"');t[e]();
				}
			});
		}, o(n, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }, { key: "Default", get: function get() {
				return qe;
			} }]), n;
	}(), Ve(window).on(Xe.LOAD_DATA_API, function () {
		for (var t = Ve.makeArray(Ve($e.DATA_SPY)), e = t.length; e--;) {
			var n = Ve(t[e]);nn._jQueryInterface.call(n, n.data());
		}
	}), Ve.fn[Qe] = nn._jQueryInterface, Ve.fn[Qe].Constructor = nn, Ve.fn[Qe].noConflict = function () {
		return Ve.fn[Qe] = Ge, nn._jQueryInterface;
	}, nn),
	    Pn = (on = "." + (sn = "bs.tab"), an = (rn = e).fn.tab, ln = { HIDE: "hide" + on, HIDDEN: "hidden" + on, SHOW: "show" + on, SHOWN: "shown" + on, CLICK_DATA_API: "click" + on + ".data-api" }, hn = "dropdown-menu", cn = "active", un = "disabled", fn = "fade", dn = "show", _n = ".dropdown", gn = ".nav, .list-group", mn = ".active", pn = "> li > .active", vn = '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]', En = ".dropdown-toggle", yn = "> .dropdown-menu .active", Tn = function () {
		function i(t) {
			this._element = t;
		}var t = i.prototype;return t.show = function () {
			var n = this;if (!(this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && rn(this._element).hasClass(cn) || rn(this._element).hasClass(un))) {
				var t,
				    i,
				    e = rn(this._element).closest(gn)[0],
				    r = Cn.getSelectorFromElement(this._element);if (e) {
					var s = "UL" === e.nodeName ? pn : mn;i = (i = rn.makeArray(rn(e).find(s)))[i.length - 1];
				}var o = rn.Event(ln.HIDE, { relatedTarget: this._element }),
				    a = rn.Event(ln.SHOW, { relatedTarget: i });if (i && rn(i).trigger(o), rn(this._element).trigger(a), !a.isDefaultPrevented() && !o.isDefaultPrevented()) {
					r && (t = rn(r)[0]), this._activate(this._element, e);var l = function l() {
						var t = rn.Event(ln.HIDDEN, { relatedTarget: n._element }),
						    e = rn.Event(ln.SHOWN, { relatedTarget: i });rn(i).trigger(t), rn(n._element).trigger(e);
					};t ? this._activate(t, t.parentNode, l) : l();
				}
			}
		}, t.dispose = function () {
			rn.removeData(this._element, sn), this._element = null;
		}, t._activate = function (t, e, n) {
			var i = this,
			    r = ("UL" === e.nodeName ? rn(e).find(pn) : rn(e).children(mn))[0],
			    s = n && r && rn(r).hasClass(fn),
			    o = function o() {
				return i._transitionComplete(t, r, n);
			};if (r && s) {
				var a = Cn.getTransitionDurationFromElement(r);rn(r).one(Cn.TRANSITION_END, o).emulateTransitionEnd(a);
			} else o();
		}, t._transitionComplete = function (t, e, n) {
			if (e) {
				rn(e).removeClass(dn + " " + cn);var i = rn(e.parentNode).find(yn)[0];i && rn(i).removeClass(cn), "tab" === e.getAttribute("role") && e.setAttribute("aria-selected", !1);
			}if (rn(t).addClass(cn), "tab" === t.getAttribute("role") && t.setAttribute("aria-selected", !0), Cn.reflow(t), rn(t).addClass(dn), t.parentNode && rn(t.parentNode).hasClass(hn)) {
				var r = rn(t).closest(_n)[0];r && rn(r).find(En).addClass(cn), t.setAttribute("aria-expanded", !0);
			}n && n();
		}, i._jQueryInterface = function (n) {
			return this.each(function () {
				var t = rn(this),
				    e = t.data(sn);if (e || (e = new i(this), t.data(sn, e)), "string" == typeof n) {
					if ("undefined" == typeof e[n]) throw new TypeError('No method named "' + n + '"');e[n]();
				}
			});
		}, o(i, null, [{ key: "VERSION", get: function get() {
				return "4.1.1";
			} }]), i;
	}(), rn(document).on(ln.CLICK_DATA_API, vn, function (t) {
		t.preventDefault(), Tn._jQueryInterface.call(rn(this), "show");
	}), rn.fn.tab = Tn._jQueryInterface, rn.fn.tab.Constructor = Tn, rn.fn.tab.noConflict = function () {
		return rn.fn.tab = an, Tn._jQueryInterface;
	}, Tn);!function (t) {
		if ("undefined" == typeof t) throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");var e = t.fn.jquery.split(" ")[0].split(".");if (e[0] < 2 && e[1] < 9 || 1 === e[0] && 9 === e[1] && e[2] < 1 || 4 <= e[0]) throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0");
	}(e), t.Util = Cn, t.Alert = In, t.Button = An, t.Carousel = Dn, t.Collapse = bn, t.Dropdown = Sn, t.Modal = wn, t.Popover = On, t.Scrollspy = kn, t.Tab = Pn, t.Tooltip = Nn, Object.defineProperty(t, "__esModule", { value: !0 });
});
//# sourceMappingURL=bootstrap.min.js.map
/*!
 * fancyBox - jQuery Plugin
 * version: 2.1.5 (Fri, 14 Jun 2013)
 * @requires jQuery v1.6 or later
 *
 * Examples at http://fancyapps.com/fancybox/
 * License: www.fancyapps.com/fancybox/#license
 *
 * Copyright 2012 Janis Skarnelis - janis@fancyapps.com
 *
 */

(function (window, document, $, undefined) {
	"use strict";

	var H = $("html"),
	    W = $(window),
	    D = $(document),
	    F = $.fancybox = function () {
		F.open.apply(this, arguments);
	},
	    IE = navigator.userAgent.match(/msie/i),
	    didUpdate = null,
	    isTouch = document.createTouch !== undefined,
	    isQuery = function isQuery(obj) {
		return obj && obj.hasOwnProperty && obj instanceof $;
	},
	    isString = function isString(str) {
		return str && $.type(str) === "string";
	},
	    isPercentage = function isPercentage(str) {
		return isString(str) && str.indexOf('%') > 0;
	},
	    isScrollable = function isScrollable(el) {
		return el && !(el.style.overflow && el.style.overflow === 'hidden') && (el.clientWidth && el.scrollWidth > el.clientWidth || el.clientHeight && el.scrollHeight > el.clientHeight);
	},
	    getScalar = function getScalar(orig, dim) {
		var value = parseInt(orig, 10) || 0;

		if (dim && isPercentage(orig)) {
			value = F.getViewport()[dim] / 100 * value;
		}

		return Math.ceil(value);
	},
	    getValue = function getValue(value, dim) {
		return getScalar(value, dim) + 'px';
	};

	$.extend(F, {
		// The current version of fancyBox
		version: '2.1.5',

		defaults: {
			padding: 15,
			margin: 20,

			width: 800,
			height: 600,
			minWidth: 100,
			minHeight: 100,
			maxWidth: 9999,
			maxHeight: 9999,
			pixelRatio: 1, // Set to 2 for retina display support

			autoSize: true,
			autoHeight: false,
			autoWidth: false,

			autoResize: true,
			autoCenter: !isTouch,
			fitToView: true,
			aspectRatio: false,
			topRatio: 0.5,
			leftRatio: 0.5,

			scrolling: 'auto', // 'auto', 'yes' or 'no'
			wrapCSS: '',

			arrows: true,
			closeBtn: true,
			closeClick: false,
			nextClick: false,
			mouseWheel: true,
			autoPlay: false,
			playSpeed: 3000,
			preload: 3,
			modal: false,
			loop: true,

			ajax: {
				dataType: 'html',
				headers: { 'X-fancyBox': true }
			},
			iframe: {
				scrolling: 'auto',
				preload: true
			},
			swf: {
				wmode: 'transparent',
				allowfullscreen: 'true',
				allowscriptaccess: 'always'
			},

			keys: {
				next: {
					13: 'left', // enter
					34: 'up', // page down
					39: 'left', // right arrow
					40: 'up' // down arrow
				},
				prev: {
					8: 'right', // backspace
					33: 'down', // page up
					37: 'right', // left arrow
					38: 'down' // up arrow
				},
				close: [27], // escape key
				play: [32], // space - start/stop slideshow
				toggle: [70] // letter "f" - toggle fullscreen
			},

			direction: {
				next: 'left',
				prev: 'right'
			},

			scrollOutside: true,

			// Override some properties
			index: 0,
			type: null,
			href: null,
			content: null,
			title: null,

			// HTML templates
			tpl: {
				wrap: '<div class="fancybox-wrap" tabIndex="-1"><div class="fancybox-skin"><div class="fancybox-outer"><div class="fancybox-inner"></div></div></div></div>',
				image: '<img class="fancybox-image" src="{href}" alt="" />',
				iframe: '<iframe id="fancybox-frame{rnd}" name="fancybox-frame{rnd}" class="fancybox-iframe" frameborder="0" vspace="0" hspace="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen' + (IE ? ' allowtransparency="true"' : '') + '></iframe>',
				error: '<p class="fancybox-error">The requested content cannot be loaded.<br/>Please try again later.</p>',
				closeBtn: '<a title="Close" class="fancybox-item fancybox-close" href="javascript:;"></a>',
				next: '<a title="Next" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
				prev: '<a title="Previous" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
			},

			// Properties for each animation type
			// Opening fancyBox
			openEffect: 'fade', // 'elastic', 'fade' or 'none'
			openSpeed: 250,
			openEasing: 'swing',
			openOpacity: true,
			openMethod: 'zoomIn',

			// Closing fancyBox
			closeEffect: 'fade', // 'elastic', 'fade' or 'none'
			closeSpeed: 250,
			closeEasing: 'swing',
			closeOpacity: true,
			closeMethod: 'zoomOut',

			// Changing next gallery item
			nextEffect: 'elastic', // 'elastic', 'fade' or 'none'
			nextSpeed: 250,
			nextEasing: 'swing',
			nextMethod: 'changeIn',

			// Changing previous gallery item
			prevEffect: 'elastic', // 'elastic', 'fade' or 'none'
			prevSpeed: 250,
			prevEasing: 'swing',
			prevMethod: 'changeOut',

			// Enable default helpers
			helpers: {
				overlay: true,
				title: true
			},

			// Callbacks
			onCancel: $.noop, // If canceling
			beforeLoad: $.noop, // Before loading
			afterLoad: $.noop, // After loading
			beforeShow: $.noop, // Before changing in current item
			afterShow: $.noop, // After opening
			beforeChange: $.noop, // Before changing gallery item
			beforeClose: $.noop, // Before closing
			afterClose: $.noop // After closing
		},

		//Current state
		group: {}, // Selected group
		opts: {}, // Group options
		previous: null, // Previous element
		coming: null, // Element being loaded
		current: null, // Currently loaded element
		isActive: false, // Is activated
		isOpen: false, // Is currently open
		isOpened: false, // Have been fully opened at least once

		wrap: null,
		skin: null,
		outer: null,
		inner: null,

		player: {
			timer: null,
			isActive: false
		},

		// Loaders
		ajaxLoad: null,
		imgPreload: null,

		// Some collections
		transitions: {},
		helpers: {},

		/*
   *	Static methods
   */

		open: function open(group, opts) {
			if (!group) {
				return;
			}

			if (!$.isPlainObject(opts)) {
				opts = {};
			}

			// Close if already active
			if (false === F.close(true)) {
				return;
			}

			// Normalize group
			if (!$.isArray(group)) {
				group = isQuery(group) ? $(group).get() : [group];
			}

			// Recheck if the type of each element is `object` and set content type (image, ajax, etc)
			$.each(group, function (i, element) {
				var obj = {},
				    href,
				    title,
				    content,
				    type,
				    rez,
				    hrefParts,
				    selector;

				if ($.type(element) === "object") {
					// Check if is DOM element
					if (element.nodeType) {
						element = $(element);
					}

					if (isQuery(element)) {
						obj = {
							href: element.data('fancybox-href') || element.attr('href'),
							title: element.data('fancybox-title') || element.attr('title'),
							isDom: true,
							element: element
						};

						if ($.metadata) {
							$.extend(true, obj, element.metadata());
						}
					} else {
						obj = element;
					}
				}

				href = opts.href || obj.href || (isString(element) ? element : null);
				title = opts.title !== undefined ? opts.title : obj.title || '';

				content = opts.content || obj.content;
				type = content ? 'html' : opts.type || obj.type;

				if (!type && obj.isDom) {
					type = element.data('fancybox-type');

					if (!type) {
						rez = element.prop('class').match(/fancybox\.(\w+)/);
						type = rez ? rez[1] : null;
					}
				}

				if (isString(href)) {
					// Try to guess the content type
					if (!type) {
						if (F.isImage(href)) {
							type = 'image';
						} else if (F.isSWF(href)) {
							type = 'swf';
						} else if (href.charAt(0) === '#') {
							type = 'inline';
						} else if (isString(element)) {
							type = 'html';
							content = element;
						}
					}

					// Split url into two pieces with source url and content selector, e.g,
					// "/mypage.html #my_id" will load "/mypage.html" and display element having id "my_id"
					if (type === 'ajax') {
						hrefParts = href.split(/\s+/, 2);
						href = hrefParts.shift();
						selector = hrefParts.shift();
					}
				}

				if (!content) {
					if (type === 'inline') {
						if (href) {
							content = $(isString(href) ? href.replace(/.*(?=#[^\s]+$)/, '') : href); //strip for ie7
						} else if (obj.isDom) {
							content = element;
						}
					} else if (type === 'html') {
						content = href;
					} else if (!type && !href && obj.isDom) {
						type = 'inline';
						content = element;
					}
				}

				$.extend(obj, {
					href: href,
					type: type,
					content: content,
					title: title,
					selector: selector
				});

				group[i] = obj;
			});

			// Extend the defaults
			F.opts = $.extend(true, {}, F.defaults, opts);

			// All options are merged recursive except keys
			if (opts.keys !== undefined) {
				F.opts.keys = opts.keys ? $.extend({}, F.defaults.keys, opts.keys) : false;
			}

			F.group = group;

			return F._start(F.opts.index);
		},

		// Cancel image loading or abort ajax request
		cancel: function cancel() {
			var coming = F.coming;

			if (!coming || false === F.trigger('onCancel')) {
				return;
			}

			F.hideLoading();

			if (F.ajaxLoad) {
				F.ajaxLoad.abort();
			}

			F.ajaxLoad = null;

			if (F.imgPreload) {
				F.imgPreload.onload = F.imgPreload.onerror = null;
			}

			if (coming.wrap) {
				coming.wrap.stop(true, true).trigger('onReset').remove();
			}

			F.coming = null;

			// If the first item has been canceled, then clear everything
			if (!F.current) {
				F._afterZoomOut(coming);
			}
		},

		// Start closing animation if is open; remove immediately if opening/closing
		close: function close(event) {
			F.cancel();

			if (false === F.trigger('beforeClose')) {
				return;
			}

			F.unbindEvents();

			if (!F.isActive) {
				return;
			}

			if (!F.isOpen || event === true) {
				$('.fancybox-wrap').stop(true).trigger('onReset').remove();

				F._afterZoomOut();
			} else {
				F.isOpen = F.isOpened = false;
				F.isClosing = true;

				$('.fancybox-item, .fancybox-nav').remove();

				F.wrap.stop(true, true).removeClass('fancybox-opened');

				F.transitions[F.current.closeMethod]();
			}
		},

		// Manage slideshow:
		//   $.fancybox.play(); - toggle slideshow
		//   $.fancybox.play( true ); - start
		//   $.fancybox.play( false ); - stop
		play: function play(action) {
			var clear = function clear() {
				clearTimeout(F.player.timer);
			},
			    set = function set() {
				clear();

				if (F.current && F.player.isActive) {
					F.player.timer = setTimeout(F.next, F.current.playSpeed);
				}
			},
			    stop = function stop() {
				clear();

				D.unbind('.player');

				F.player.isActive = false;

				F.trigger('onPlayEnd');
			},
			    start = function start() {
				if (F.current && (F.current.loop || F.current.index < F.group.length - 1)) {
					F.player.isActive = true;

					D.bind({
						'onCancel.player beforeClose.player': stop,
						'onUpdate.player': set,
						'beforeLoad.player': clear
					});

					set();

					F.trigger('onPlayStart');
				}
			};

			if (action === true || !F.player.isActive && action !== false) {
				start();
			} else {
				stop();
			}
		},

		// Navigate to next gallery item
		next: function next(direction) {
			var current = F.current;

			if (current) {
				if (!isString(direction)) {
					direction = current.direction.next;
				}

				F.jumpto(current.index + 1, direction, 'next');
			}
		},

		// Navigate to previous gallery item
		prev: function prev(direction) {
			var current = F.current;

			if (current) {
				if (!isString(direction)) {
					direction = current.direction.prev;
				}

				F.jumpto(current.index - 1, direction, 'prev');
			}
		},

		// Navigate to gallery item by index
		jumpto: function jumpto(index, direction, router) {
			var current = F.current;

			if (!current) {
				return;
			}

			index = getScalar(index);

			F.direction = direction || current.direction[index >= current.index ? 'next' : 'prev'];
			F.router = router || 'jumpto';

			if (current.loop) {
				if (index < 0) {
					index = current.group.length + index % current.group.length;
				}

				index = index % current.group.length;
			}

			if (current.group[index] !== undefined) {
				F.cancel();

				F._start(index);
			}
		},

		// Center inside viewport and toggle position type to fixed or absolute if needed
		reposition: function reposition(e, onlyAbsolute) {
			var current = F.current,
			    wrap = current ? current.wrap : null,
			    pos;

			if (wrap) {
				pos = F._getPosition(onlyAbsolute);

				if (e && e.type === 'scroll') {
					delete pos.position;

					wrap.stop(true, true).animate(pos, 200);
				} else {
					wrap.css(pos);

					current.pos = $.extend({}, current.dim, pos);
				}
			}
		},

		update: function update(e) {
			var type = e && e.type,
			    anyway = !type || type === 'orientationchange';

			if (anyway) {
				clearTimeout(didUpdate);

				didUpdate = null;
			}

			if (!F.isOpen || didUpdate) {
				return;
			}

			didUpdate = setTimeout(function () {
				var current = F.current;

				if (!current || F.isClosing) {
					return;
				}

				F.wrap.removeClass('fancybox-tmp');

				if (anyway || type === 'load' || type === 'resize' && current.autoResize) {
					F._setDimension();
				}

				if (!(type === 'scroll' && current.canShrink)) {
					F.reposition(e);
				}

				F.trigger('onUpdate');

				didUpdate = null;
			}, anyway && !isTouch ? 0 : 300);
		},

		// Shrink content to fit inside viewport or restore if resized
		toggle: function toggle(action) {
			if (F.isOpen) {
				F.current.fitToView = $.type(action) === "boolean" ? action : !F.current.fitToView;

				// Help browser to restore document dimensions
				if (isTouch) {
					F.wrap.removeAttr('style').addClass('fancybox-tmp');

					F.trigger('onUpdate');
				}

				F.update();
			}
		},

		hideLoading: function hideLoading() {
			D.unbind('.loading');

			$('#fancybox-loading').remove();
		},

		showLoading: function showLoading() {
			var el, viewport;

			F.hideLoading();

			el = $('<div id="fancybox-loading"><div></div></div>').click(F.cancel).appendTo('body');

			// If user will press the escape-button, the request will be canceled
			D.bind('keydown.loading', function (e) {
				if ((e.which || e.keyCode) === 27) {
					e.preventDefault();

					F.cancel();
				}
			});

			if (!F.defaults.fixed) {
				viewport = F.getViewport();

				el.css({
					position: 'absolute',
					top: viewport.h * 0.5 + viewport.y,
					left: viewport.w * 0.5 + viewport.x
				});
			}
		},

		getViewport: function getViewport() {
			var locked = F.current && F.current.locked || false,
			    rez = {
				x: W.scrollLeft(),
				y: W.scrollTop()
			};

			if (locked) {
				rez.w = locked[0].clientWidth;
				rez.h = locked[0].clientHeight;
			} else {
				// See http://bugs.jquery.com/ticket/6724
				rez.w = isTouch && window.innerWidth ? window.innerWidth : W.width();
				rez.h = isTouch && window.innerHeight ? window.innerHeight : W.height();
			}

			return rez;
		},

		// Unbind the keyboard / clicking actions
		unbindEvents: function unbindEvents() {
			if (F.wrap && isQuery(F.wrap)) {
				F.wrap.unbind('.fb');
			}

			D.unbind('.fb');
			W.unbind('.fb');
		},

		bindEvents: function bindEvents() {
			var current = F.current,
			    keys;

			if (!current) {
				return;
			}

			// Changing document height on iOS devices triggers a 'resize' event,
			// that can change document height... repeating infinitely
			W.bind('orientationchange.fb' + (isTouch ? '' : ' resize.fb') + (current.autoCenter && !current.locked ? ' scroll.fb' : ''), F.update);

			keys = current.keys;

			if (keys) {
				D.bind('keydown.fb', function (e) {
					var code = e.which || e.keyCode,
					    target = e.target || e.srcElement;

					// Skip esc key if loading, because showLoading will cancel preloading
					if (code === 27 && F.coming) {
						return false;
					}

					// Ignore key combinations and key events within form elements
					if (!e.ctrlKey && !e.altKey && !e.shiftKey && !e.metaKey && !(target && (target.type || $(target).is('[contenteditable]')))) {
						$.each(keys, function (i, val) {
							if (current.group.length > 1 && val[code] !== undefined) {
								F[i](val[code]);

								e.preventDefault();
								return false;
							}

							if ($.inArray(code, val) > -1) {
								F[i]();

								e.preventDefault();
								return false;
							}
						});
					}
				});
			}

			if ($.fn.mousewheel && current.mouseWheel) {
				F.wrap.bind('mousewheel.fb', function (e, delta, deltaX, deltaY) {
					var target = e.target || null,
					    parent = $(target),
					    canScroll = false;

					while (parent.length) {
						if (canScroll || parent.is('.fancybox-skin') || parent.is('.fancybox-wrap')) {
							break;
						}

						canScroll = isScrollable(parent[0]);
						parent = $(parent).parent();
					}

					if (delta !== 0 && !canScroll) {
						if (F.group.length > 1 && !current.canShrink) {
							if (deltaY > 0 || deltaX > 0) {
								F.prev(deltaY > 0 ? 'down' : 'left');
							} else if (deltaY < 0 || deltaX < 0) {
								F.next(deltaY < 0 ? 'up' : 'right');
							}

							e.preventDefault();
						}
					}
				});
			}
		},

		trigger: function trigger(event, o) {
			var ret,
			    obj = o || F.coming || F.current;

			if (!obj) {
				return;
			}

			if ($.isFunction(obj[event])) {
				ret = obj[event].apply(obj, Array.prototype.slice.call(arguments, 1));
			}

			if (ret === false) {
				return false;
			}

			if (obj.helpers) {
				$.each(obj.helpers, function (helper, opts) {
					if (opts && F.helpers[helper] && $.isFunction(F.helpers[helper][event])) {
						F.helpers[helper][event]($.extend(true, {}, F.helpers[helper].defaults, opts), obj);
					}
				});
			}

			D.trigger(event);
		},

		isImage: function isImage(str) {
			return isString(str) && str.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp|svg)((\?|#).*)?$)/i);
		},

		isSWF: function isSWF(str) {
			return isString(str) && str.match(/\.(swf)((\?|#).*)?$/i);
		},

		_start: function _start(index) {
			var coming = {},
			    obj,
			    href,
			    type,
			    margin,
			    padding;

			index = getScalar(index);
			obj = F.group[index] || null;

			if (!obj) {
				return false;
			}

			coming = $.extend(true, {}, F.opts, obj);

			// Convert margin and padding properties to array - top, right, bottom, left
			margin = coming.margin;
			padding = coming.padding;

			if ($.type(margin) === 'number') {
				coming.margin = [margin, margin, margin, margin];
			}

			if ($.type(padding) === 'number') {
				coming.padding = [padding, padding, padding, padding];
			}

			// 'modal' propery is just a shortcut
			if (coming.modal) {
				$.extend(true, coming, {
					closeBtn: false,
					closeClick: false,
					nextClick: false,
					arrows: false,
					mouseWheel: false,
					keys: null,
					helpers: {
						overlay: {
							closeClick: false
						}
					}
				});
			}

			// 'autoSize' property is a shortcut, too
			if (coming.autoSize) {
				coming.autoWidth = coming.autoHeight = true;
			}

			if (coming.width === 'auto') {
				coming.autoWidth = true;
			}

			if (coming.height === 'auto') {
				coming.autoHeight = true;
			}

			/*
    * Add reference to the group, so it`s possible to access from callbacks, example:
    * afterLoad : function() {
    *     this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
    * }
    */

			coming.group = F.group;
			coming.index = index;

			// Give a chance for callback or helpers to update coming item (type, title, etc)
			F.coming = coming;

			if (false === F.trigger('beforeLoad')) {
				F.coming = null;

				return;
			}

			type = coming.type;
			href = coming.href;

			if (!type) {
				F.coming = null;

				//If we can not determine content type then drop silently or display next/prev item if looping through gallery
				if (F.current && F.router && F.router !== 'jumpto') {
					F.current.index = index;

					return F[F.router](F.direction);
				}

				return false;
			}

			F.isActive = true;

			if (type === 'image' || type === 'swf') {
				coming.autoHeight = coming.autoWidth = false;
				coming.scrolling = 'visible';
			}

			if (type === 'image') {
				coming.aspectRatio = true;
			}

			if (type === 'iframe' && isTouch) {
				coming.scrolling = 'scroll';
			}

			// Build the neccessary markup
			coming.wrap = $(coming.tpl.wrap).addClass('fancybox-' + (isTouch ? 'mobile' : 'desktop') + ' fancybox-type-' + type + ' fancybox-tmp ' + coming.wrapCSS).appendTo(coming.parent || 'body');

			$.extend(coming, {
				skin: $('.fancybox-skin', coming.wrap),
				outer: $('.fancybox-outer', coming.wrap),
				inner: $('.fancybox-inner', coming.wrap)
			});

			$.each(["Top", "Right", "Bottom", "Left"], function (i, v) {
				coming.skin.css('padding' + v, getValue(coming.padding[i]));
			});

			F.trigger('onReady');

			// Check before try to load; 'inline' and 'html' types need content, others - href
			if (type === 'inline' || type === 'html') {
				if (!coming.content || !coming.content.length) {
					return F._error('content');
				}
			} else if (!href) {
				return F._error('href');
			}

			if (type === 'image') {
				F._loadImage();
			} else if (type === 'ajax') {
				F._loadAjax();
			} else if (type === 'iframe') {
				F._loadIframe();
			} else {
				F._afterLoad();
			}
		},

		_error: function _error(type) {
			$.extend(F.coming, {
				type: 'html',
				autoWidth: true,
				autoHeight: true,
				minWidth: 0,
				minHeight: 0,
				scrolling: 'no',
				hasError: type,
				content: F.coming.tpl.error
			});

			F._afterLoad();
		},

		_loadImage: function _loadImage() {
			// Reset preload image so it is later possible to check "complete" property
			var img = F.imgPreload = new Image();

			img.onload = function () {
				this.onload = this.onerror = null;

				F.coming.width = this.width / F.opts.pixelRatio;
				F.coming.height = this.height / F.opts.pixelRatio;

				F._afterLoad();
			};

			img.onerror = function () {
				this.onload = this.onerror = null;

				F._error('image');
			};

			img.src = F.coming.href;

			if (img.complete !== true) {
				F.showLoading();
			}
		},

		_loadAjax: function _loadAjax() {
			var coming = F.coming;

			F.showLoading();

			F.ajaxLoad = $.ajax($.extend({}, coming.ajax, {
				url: coming.href,
				error: function error(jqXHR, textStatus) {
					if (F.coming && textStatus !== 'abort') {
						F._error('ajax', jqXHR);
					} else {
						F.hideLoading();
					}
				},
				success: function success(data, textStatus) {
					if (textStatus === 'success') {
						coming.content = data;

						F._afterLoad();
					}
				}
			}));
		},

		_loadIframe: function _loadIframe() {
			var coming = F.coming,
			    iframe = $(coming.tpl.iframe.replace(/\{rnd\}/g, new Date().getTime())).attr('scrolling', isTouch ? 'auto' : coming.iframe.scrolling).attr('src', coming.href);

			// This helps IE
			$(coming.wrap).bind('onReset', function () {
				try {
					$(this).find('iframe').hide().attr('src', '//about:blank').end().empty();
				} catch (e) {}
			});

			if (coming.iframe.preload) {
				F.showLoading();

				iframe.one('load', function () {
					$(this).data('ready', 1);

					// iOS will lose scrolling if we resize
					if (!isTouch) {
						$(this).bind('load.fb', F.update);
					}

					// Without this trick:
					//   - iframe won't scroll on iOS devices
					//   - IE7 sometimes displays empty iframe
					$(this).parents('.fancybox-wrap').width('100%').removeClass('fancybox-tmp').show();

					F._afterLoad();
				});
			}

			coming.content = iframe.appendTo(coming.inner);

			if (!coming.iframe.preload) {
				F._afterLoad();
			}
		},

		_preloadImages: function _preloadImages() {
			var group = F.group,
			    current = F.current,
			    len = group.length,
			    cnt = current.preload ? Math.min(current.preload, len - 1) : 0,
			    item,
			    i;

			for (i = 1; i <= cnt; i += 1) {
				item = group[(current.index + i) % len];

				if (item.type === 'image' && item.href) {
					new Image().src = item.href;
				}
			}
		},

		_afterLoad: function _afterLoad() {
			var coming = F.coming,
			    previous = F.current,
			    placeholder = 'fancybox-placeholder',
			    current,
			    content,
			    type,
			    scrolling,
			    href,
			    embed;

			F.hideLoading();

			if (!coming || F.isActive === false) {
				return;
			}

			if (false === F.trigger('afterLoad', coming, previous)) {
				coming.wrap.stop(true).trigger('onReset').remove();

				F.coming = null;

				return;
			}

			if (previous) {
				F.trigger('beforeChange', previous);

				previous.wrap.stop(true).removeClass('fancybox-opened').find('.fancybox-item, .fancybox-nav').remove();
			}

			F.unbindEvents();

			current = coming;
			content = coming.content;
			type = coming.type;
			scrolling = coming.scrolling;

			$.extend(F, {
				wrap: current.wrap,
				skin: current.skin,
				outer: current.outer,
				inner: current.inner,
				current: current,
				previous: previous
			});

			href = current.href;

			switch (type) {
				case 'inline':
				case 'ajax':
				case 'html':
					if (current.selector) {
						content = $('<div>').html(content).find(current.selector);
					} else if (isQuery(content)) {
						if (!content.data(placeholder)) {
							content.data(placeholder, $('<div class="' + placeholder + '"></div>').insertAfter(content).hide());
						}

						content = content.show().detach();

						current.wrap.bind('onReset', function () {
							if ($(this).find(content).length) {
								content.hide().replaceAll(content.data(placeholder)).data(placeholder, false);
							}
						});
					}
					break;

				case 'image':
					content = current.tpl.image.replace('{href}', href);
					break;

				case 'swf':
					content = '<object id="fancybox-swf" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="100%" height="100%"><param name="movie" value="' + href + '"></param>';
					embed = '';

					$.each(current.swf, function (name, val) {
						content += '<param name="' + name + '" value="' + val + '"></param>';
						embed += ' ' + name + '="' + val + '"';
					});

					content += '<embed src="' + href + '" type="application/x-shockwave-flash" width="100%" height="100%"' + embed + '></embed></object>';
					break;
			}

			if (!(isQuery(content) && content.parent().is(current.inner))) {
				current.inner.append(content);
			}

			// Give a chance for helpers or callbacks to update elements
			F.trigger('beforeShow');

			// Set scrolling before calculating dimensions
			current.inner.css('overflow', scrolling === 'yes' ? 'scroll' : scrolling === 'no' ? 'hidden' : scrolling);

			// Set initial dimensions and start position
			F._setDimension();

			F.reposition();

			F.isOpen = false;
			F.coming = null;

			F.bindEvents();

			if (!F.isOpened) {
				$('.fancybox-wrap').not(current.wrap).stop(true).trigger('onReset').remove();
			} else if (previous.prevMethod) {
				F.transitions[previous.prevMethod]();
			}

			F.transitions[F.isOpened ? current.nextMethod : current.openMethod]();

			F._preloadImages();
		},

		_setDimension: function _setDimension() {
			var viewport = F.getViewport(),
			    steps = 0,
			    canShrink = false,
			    canExpand = false,
			    wrap = F.wrap,
			    skin = F.skin,
			    inner = F.inner,
			    current = F.current,
			    width = current.width,
			    height = current.height,
			    minWidth = current.minWidth,
			    minHeight = current.minHeight,
			    maxWidth = current.maxWidth,
			    maxHeight = current.maxHeight,
			    scrolling = current.scrolling,
			    scrollOut = current.scrollOutside ? current.scrollbarWidth : 0,
			    margin = current.margin,
			    wMargin = getScalar(margin[1] + margin[3]),
			    hMargin = getScalar(margin[0] + margin[2]),
			    wPadding,
			    hPadding,
			    wSpace,
			    hSpace,
			    origWidth,
			    origHeight,
			    origMaxWidth,
			    origMaxHeight,
			    ratio,
			    width_,
			    height_,
			    maxWidth_,
			    maxHeight_,
			    iframe,
			    body;

			// Reset dimensions so we could re-check actual size
			wrap.add(skin).add(inner).width('auto').height('auto').removeClass('fancybox-tmp');

			wPadding = getScalar(skin.outerWidth(true) - skin.width());
			hPadding = getScalar(skin.outerHeight(true) - skin.height());

			// Any space between content and viewport (margin, padding, border, title)
			wSpace = wMargin + wPadding;
			hSpace = hMargin + hPadding;

			origWidth = isPercentage(width) ? (viewport.w - wSpace) * getScalar(width) / 100 : width;
			origHeight = isPercentage(height) ? (viewport.h - hSpace) * getScalar(height) / 100 : height;

			if (current.type === 'iframe') {
				iframe = current.content;

				if (current.autoHeight && iframe.data('ready') === 1) {
					try {
						if (iframe[0].contentWindow.document.location) {
							inner.width(origWidth).height(9999);

							body = iframe.contents().find('body');

							if (scrollOut) {
								body.css('overflow-x', 'hidden');
							}

							origHeight = body.outerHeight(true);
						}
					} catch (e) {}
				}
			} else if (current.autoWidth || current.autoHeight) {
				inner.addClass('fancybox-tmp');

				// Set width or height in case we need to calculate only one dimension
				if (!current.autoWidth) {
					inner.width(origWidth);
				}

				if (!current.autoHeight) {
					inner.height(origHeight);
				}

				if (current.autoWidth) {
					origWidth = inner.width();
				}

				if (current.autoHeight) {
					origHeight = inner.height();
				}

				inner.removeClass('fancybox-tmp');
			}

			width = getScalar(origWidth);
			height = getScalar(origHeight);

			ratio = origWidth / origHeight;

			// Calculations for the content
			minWidth = getScalar(isPercentage(minWidth) ? getScalar(minWidth, 'w') - wSpace : minWidth);
			maxWidth = getScalar(isPercentage(maxWidth) ? getScalar(maxWidth, 'w') - wSpace : maxWidth);

			minHeight = getScalar(isPercentage(minHeight) ? getScalar(minHeight, 'h') - hSpace : minHeight);
			maxHeight = getScalar(isPercentage(maxHeight) ? getScalar(maxHeight, 'h') - hSpace : maxHeight);

			// These will be used to determine if wrap can fit in the viewport
			origMaxWidth = maxWidth;
			origMaxHeight = maxHeight;

			if (current.fitToView) {
				maxWidth = Math.min(viewport.w - wSpace, maxWidth);
				maxHeight = Math.min(viewport.h - hSpace, maxHeight);
			}

			maxWidth_ = viewport.w - wMargin;
			maxHeight_ = viewport.h - hMargin;

			if (current.aspectRatio) {
				if (width > maxWidth) {
					width = maxWidth;
					height = getScalar(width / ratio);
				}

				if (height > maxHeight) {
					height = maxHeight;
					width = getScalar(height * ratio);
				}

				if (width < minWidth) {
					width = minWidth;
					height = getScalar(width / ratio);
				}

				if (height < minHeight) {
					height = minHeight;
					width = getScalar(height * ratio);
				}
			} else {
				width = Math.max(minWidth, Math.min(width, maxWidth));

				if (current.autoHeight && current.type !== 'iframe') {
					inner.width(width);

					height = inner.height();
				}

				height = Math.max(minHeight, Math.min(height, maxHeight));
			}

			// Try to fit inside viewport (including the title)
			if (current.fitToView) {
				inner.width(width).height(height);

				wrap.width(width + wPadding);

				// Real wrap dimensions
				width_ = wrap.width();
				height_ = wrap.height();

				if (current.aspectRatio) {
					while ((width_ > maxWidth_ || height_ > maxHeight_) && width > minWidth && height > minHeight) {
						if (steps++ > 19) {
							break;
						}

						height = Math.max(minHeight, Math.min(maxHeight, height - 10));
						width = getScalar(height * ratio);

						if (width < minWidth) {
							width = minWidth;
							height = getScalar(width / ratio);
						}

						if (width > maxWidth) {
							width = maxWidth;
							height = getScalar(width / ratio);
						}

						inner.width(width).height(height);

						wrap.width(width + wPadding);

						width_ = wrap.width();
						height_ = wrap.height();
					}
				} else {
					width = Math.max(minWidth, Math.min(width, width - (width_ - maxWidth_)));
					height = Math.max(minHeight, Math.min(height, height - (height_ - maxHeight_)));
				}
			}

			if (scrollOut && scrolling === 'auto' && height < origHeight && width + wPadding + scrollOut < maxWidth_) {
				width += scrollOut;
			}

			inner.width(width).height(height);

			wrap.width(width + wPadding);

			width_ = wrap.width();
			height_ = wrap.height();

			canShrink = (width_ > maxWidth_ || height_ > maxHeight_) && width > minWidth && height > minHeight;
			canExpand = current.aspectRatio ? width < origMaxWidth && height < origMaxHeight && width < origWidth && height < origHeight : (width < origMaxWidth || height < origMaxHeight) && (width < origWidth || height < origHeight);

			$.extend(current, {
				dim: {
					width: getValue(width_),
					height: getValue(height_)
				},
				origWidth: origWidth,
				origHeight: origHeight,
				canShrink: canShrink,
				canExpand: canExpand,
				wPadding: wPadding,
				hPadding: hPadding,
				wrapSpace: height_ - skin.outerHeight(true),
				skinSpace: skin.height() - height
			});

			if (!iframe && current.autoHeight && height > minHeight && height < maxHeight && !canExpand) {
				inner.height('auto');
			}
		},

		_getPosition: function _getPosition(onlyAbsolute) {
			var current = F.current,
			    viewport = F.getViewport(),
			    margin = current.margin,
			    width = F.wrap.width() + margin[1] + margin[3],
			    height = F.wrap.height() + margin[0] + margin[2],
			    rez = {
				position: 'absolute',
				top: margin[0],
				left: margin[3]
			};

			if (current.autoCenter && current.fixed && !onlyAbsolute && height <= viewport.h && width <= viewport.w) {
				rez.position = 'fixed';
			} else if (!current.locked) {
				rez.top += viewport.y;
				rez.left += viewport.x;
			}

			rez.top = getValue(Math.max(rez.top, rez.top + (viewport.h - height) * current.topRatio));
			rez.left = getValue(Math.max(rez.left, rez.left + (viewport.w - width) * current.leftRatio));

			return rez;
		},

		_afterZoomIn: function _afterZoomIn() {
			var current = F.current;

			if (!current) {
				return;
			}

			F.isOpen = F.isOpened = true;

			F.wrap.css('overflow', 'visible').addClass('fancybox-opened');

			F.update();

			// Assign a click event
			if (current.closeClick || current.nextClick && F.group.length > 1) {
				F.inner.css('cursor', 'pointer').bind('click.fb', function (e) {
					if (!$(e.target).is('a') && !$(e.target).parent().is('a')) {
						e.preventDefault();

						F[current.closeClick ? 'close' : 'next']();
					}
				});
			}

			// Create a close button
			if (current.closeBtn) {
				$(current.tpl.closeBtn).appendTo(F.skin).bind('click.fb', function (e) {
					e.preventDefault();

					F.close();
				});
			}

			// Create navigation arrows
			if (current.arrows && F.group.length > 1) {
				if (current.loop || current.index > 0) {
					$(current.tpl.prev).appendTo(F.outer).bind('click.fb', F.prev);
				}

				if (current.loop || current.index < F.group.length - 1) {
					$(current.tpl.next).appendTo(F.outer).bind('click.fb', F.next);
				}
			}

			F.trigger('afterShow');

			// Stop the slideshow if this is the last item
			if (!current.loop && current.index === current.group.length - 1) {
				F.play(false);
			} else if (F.opts.autoPlay && !F.player.isActive) {
				F.opts.autoPlay = false;

				F.play();
			}
		},

		_afterZoomOut: function _afterZoomOut(obj) {
			obj = obj || F.current;

			$('.fancybox-wrap').trigger('onReset').remove();

			$.extend(F, {
				group: {},
				opts: {},
				router: false,
				current: null,
				isActive: false,
				isOpened: false,
				isOpen: false,
				isClosing: false,
				wrap: null,
				skin: null,
				outer: null,
				inner: null
			});

			F.trigger('afterClose', obj);
		}
	});

	/*
  *	Default transitions
  */

	F.transitions = {
		getOrigPosition: function getOrigPosition() {
			var current = F.current,
			    element = current.element,
			    orig = current.orig,
			    pos = {},
			    width = 50,
			    height = 50,
			    hPadding = current.hPadding,
			    wPadding = current.wPadding,
			    viewport = F.getViewport();

			if (!orig && current.isDom && element.is(':visible')) {
				orig = element.find('img:first');

				if (!orig.length) {
					orig = element;
				}
			}

			if (isQuery(orig)) {
				pos = orig.offset();

				if (orig.is('img')) {
					width = orig.outerWidth();
					height = orig.outerHeight();
				}
			} else {
				pos.top = viewport.y + (viewport.h - height) * current.topRatio;
				pos.left = viewport.x + (viewport.w - width) * current.leftRatio;
			}

			if (F.wrap.css('position') === 'fixed' || current.locked) {
				pos.top -= viewport.y;
				pos.left -= viewport.x;
			}

			pos = {
				top: getValue(pos.top - hPadding * current.topRatio),
				left: getValue(pos.left - wPadding * current.leftRatio),
				width: getValue(width + wPadding),
				height: getValue(height + hPadding)
			};

			return pos;
		},

		step: function step(now, fx) {
			var ratio,
			    padding,
			    value,
			    prop = fx.prop,
			    current = F.current,
			    wrapSpace = current.wrapSpace,
			    skinSpace = current.skinSpace;

			if (prop === 'width' || prop === 'height') {
				ratio = fx.end === fx.start ? 1 : (now - fx.start) / (fx.end - fx.start);

				if (F.isClosing) {
					ratio = 1 - ratio;
				}

				padding = prop === 'width' ? current.wPadding : current.hPadding;
				value = now - padding;

				F.skin[prop](getScalar(prop === 'width' ? value : value - wrapSpace * ratio));
				F.inner[prop](getScalar(prop === 'width' ? value : value - wrapSpace * ratio - skinSpace * ratio));
			}
		},

		zoomIn: function zoomIn() {
			var current = F.current,
			    startPos = current.pos,
			    effect = current.openEffect,
			    elastic = effect === 'elastic',
			    endPos = $.extend({ opacity: 1 }, startPos);

			// Remove "position" property that breaks older IE
			delete endPos.position;

			if (elastic) {
				startPos = this.getOrigPosition();

				if (current.openOpacity) {
					startPos.opacity = 0.1;
				}
			} else if (effect === 'fade') {
				startPos.opacity = 0.1;
			}

			F.wrap.css(startPos).animate(endPos, {
				duration: effect === 'none' ? 0 : current.openSpeed,
				easing: current.openEasing,
				step: elastic ? this.step : null,
				complete: F._afterZoomIn
			});
		},

		zoomOut: function zoomOut() {
			var current = F.current,
			    effect = current.closeEffect,
			    elastic = effect === 'elastic',
			    endPos = { opacity: 0.1 };

			if (elastic) {
				endPos = this.getOrigPosition();

				if (current.closeOpacity) {
					endPos.opacity = 0.1;
				}
			}

			F.wrap.animate(endPos, {
				duration: effect === 'none' ? 0 : current.closeSpeed,
				easing: current.closeEasing,
				step: elastic ? this.step : null,
				complete: F._afterZoomOut
			});
		},

		changeIn: function changeIn() {
			var current = F.current,
			    effect = current.nextEffect,
			    startPos = current.pos,
			    endPos = { opacity: 1 },
			    direction = F.direction,
			    distance = 200,
			    field;

			startPos.opacity = 0.1;

			if (effect === 'elastic') {
				field = direction === 'down' || direction === 'up' ? 'top' : 'left';

				if (direction === 'down' || direction === 'right') {
					startPos[field] = getValue(getScalar(startPos[field]) - distance);
					endPos[field] = '+=' + distance + 'px';
				} else {
					startPos[field] = getValue(getScalar(startPos[field]) + distance);
					endPos[field] = '-=' + distance + 'px';
				}
			}

			// Workaround for http://bugs.jquery.com/ticket/12273
			if (effect === 'none') {
				F._afterZoomIn();
			} else {
				F.wrap.css(startPos).animate(endPos, {
					duration: current.nextSpeed,
					easing: current.nextEasing,
					complete: F._afterZoomIn
				});
			}
		},

		changeOut: function changeOut() {
			var previous = F.previous,
			    effect = previous.prevEffect,
			    endPos = { opacity: 0.1 },
			    direction = F.direction,
			    distance = 200;

			if (effect === 'elastic') {
				endPos[direction === 'down' || direction === 'up' ? 'top' : 'left'] = (direction === 'up' || direction === 'left' ? '-' : '+') + '=' + distance + 'px';
			}

			previous.wrap.animate(endPos, {
				duration: effect === 'none' ? 0 : previous.prevSpeed,
				easing: previous.prevEasing,
				complete: function complete() {
					$(this).trigger('onReset').remove();
				}
			});
		}
	};

	/*
  *	Overlay helper
  */

	F.helpers.overlay = {
		defaults: {
			closeClick: true, // if true, fancyBox will be closed when user clicks on the overlay
			speedOut: 200, // duration of fadeOut animation
			showEarly: true, // indicates if should be opened immediately or wait until the content is ready
			css: {}, // custom CSS properties
			locked: !isTouch, // if true, the content will be locked into overlay
			fixed: true // if false, the overlay CSS position property will not be set to "fixed"
		},

		overlay: null, // current handle
		fixed: false, // indicates if the overlay has position "fixed"
		el: $('html'), // element that contains "the lock"

		// Public methods
		create: function create(opts) {
			opts = $.extend({}, this.defaults, opts);

			if (this.overlay) {
				this.close();
			}

			this.overlay = $('<div class="fancybox-overlay"></div>').appendTo(F.coming ? F.coming.parent : opts.parent);
			this.fixed = false;

			if (opts.fixed && F.defaults.fixed) {
				this.overlay.addClass('fancybox-overlay-fixed');

				this.fixed = true;
			}
		},

		open: function open(opts) {
			var that = this;

			opts = $.extend({}, this.defaults, opts);

			if (this.overlay) {
				this.overlay.unbind('.overlay').width('auto').height('auto');
			} else {
				this.create(opts);
			}

			if (!this.fixed) {
				W.bind('resize.overlay', $.proxy(this.update, this));

				this.update();
			}

			if (opts.closeClick) {
				this.overlay.bind('click.overlay', function (e) {
					if ($(e.target).hasClass('fancybox-overlay')) {
						if (F.isActive) {
							F.close();
						} else {
							that.close();
						}

						return false;
					}
				});
			}

			this.overlay.css(opts.css).show();
		},

		close: function close() {
			var scrollV, scrollH;

			W.unbind('resize.overlay');

			if (this.el.hasClass('fancybox-lock')) {
				$('.fancybox-margin').removeClass('fancybox-margin');

				scrollV = W.scrollTop();
				scrollH = W.scrollLeft();

				this.el.removeClass('fancybox-lock');

				W.scrollTop(scrollV).scrollLeft(scrollH);
			}

			$('.fancybox-overlay').remove().hide();

			$.extend(this, {
				overlay: null,
				fixed: false
			});
		},

		// Private, callbacks

		update: function update() {
			var width = '100%',
			    offsetWidth;

			// Reset width/height so it will not mess
			this.overlay.width(width).height('100%');

			// jQuery does not return reliable result for IE
			if (IE) {
				offsetWidth = Math.max(document.documentElement.offsetWidth, document.body.offsetWidth);

				if (D.width() > offsetWidth) {
					width = D.width();
				}
			} else if (D.width() > W.width()) {
				width = D.width();
			}

			this.overlay.width(width).height(D.height());
		},

		// This is where we can manipulate DOM, because later it would cause iframes to reload
		onReady: function onReady(opts, obj) {
			var overlay = this.overlay;

			$('.fancybox-overlay').stop(true, true);

			if (!overlay) {
				this.create(opts);
			}

			if (opts.locked && this.fixed && obj.fixed) {
				if (!overlay) {
					this.margin = D.height() > W.height() ? $('html').css('margin-right').replace("px", "") : false;
				}

				obj.locked = this.overlay.append(obj.wrap);
				obj.fixed = false;
			}

			if (opts.showEarly === true) {
				this.beforeShow.apply(this, arguments);
			}
		},

		beforeShow: function beforeShow(opts, obj) {
			var scrollV, scrollH;

			if (obj.locked) {
				if (this.margin !== false) {
					$('*').filter(function () {
						return $(this).css('position') === 'fixed' && !$(this).hasClass("fancybox-overlay") && !$(this).hasClass("fancybox-wrap");
					}).addClass('fancybox-margin');

					this.el.addClass('fancybox-margin');
				}

				scrollV = W.scrollTop();
				scrollH = W.scrollLeft();

				this.el.addClass('fancybox-lock');

				W.scrollTop(scrollV).scrollLeft(scrollH);
			}

			this.open(opts);
		},

		onUpdate: function onUpdate() {
			if (!this.fixed) {
				this.update();
			}
		},

		afterClose: function afterClose(opts) {
			// Remove overlay if exists and fancyBox is not opening
			// (e.g., it is not being open using afterClose callback)
			//if (this.overlay && !F.isActive) {
			if (this.overlay && !F.coming) {
				this.overlay.fadeOut(opts.speedOut, $.proxy(this.close, this));
			}
		}
	};

	/*
  *	Title helper
  */

	F.helpers.title = {
		defaults: {
			type: 'float', // 'float', 'inside', 'outside' or 'over',
			position: 'bottom' // 'top' or 'bottom'
		},

		beforeShow: function beforeShow(opts) {
			var current = F.current,
			    text = current.title,
			    type = opts.type,
			    title,
			    target;

			if ($.isFunction(text)) {
				text = text.call(current.element, current);
			}

			if (!isString(text) || $.trim(text) === '') {
				return;
			}

			title = $('<div class="fancybox-title fancybox-title-' + type + '-wrap">' + text + '</div>');

			switch (type) {
				case 'inside':
					target = F.skin;
					break;

				case 'outside':
					target = F.wrap;
					break;

				case 'over':
					target = F.inner;
					break;

				default:
					// 'float'
					target = F.skin;

					title.appendTo('body');

					if (IE) {
						title.width(title.width());
					}

					title.wrapInner('<span class="child"></span>');

					//Increase bottom margin so this title will also fit into viewport
					F.current.margin[2] += Math.abs(getScalar(title.css('margin-bottom')));
					break;
			}

			title[opts.position === 'top' ? 'prependTo' : 'appendTo'](target);
		}
	};

	// jQuery plugin initialization
	$.fn.fancybox = function (options) {
		var index,
		    that = $(this),
		    selector = this.selector || '',
		    run = function run(e) {
			var what = $(this).blur(),
			    idx = index,
			    relType,
			    relVal;

			if (!(e.ctrlKey || e.altKey || e.shiftKey || e.metaKey) && !what.is('.fancybox-wrap')) {
				relType = options.groupAttr || 'data-fancybox-group';
				relVal = what.attr(relType);

				if (!relVal) {
					relType = 'rel';
					relVal = what.get(0)[relType];
				}

				if (relVal && relVal !== '' && relVal !== 'nofollow') {
					what = selector.length ? $(selector) : that;
					what = what.filter('[' + relType + '="' + relVal + '"]');
					idx = what.index(this);
				}

				options.index = idx;

				// Stop an event from bubbling if everything is fine
				if (F.open(what, options) !== false) {
					e.preventDefault();
				}
			}
		};

		options = options || {};
		index = options.index || 0;

		if (!selector || options.live === false) {
			that.unbind('click.fb-start').bind('click.fb-start', run);
		} else {
			D.undelegate(selector, 'click.fb-start').delegate(selector + ":not('.fancybox-item, .fancybox-nav')", 'click.fb-start', run);
		}

		this.filter('[data-fancybox-start=1]').trigger('click');

		return this;
	};

	// Tests that need a body at doc ready
	D.ready(function () {
		var w1, w2;

		if ($.scrollbarWidth === undefined) {
			// http://benalman.com/projects/jquery-misc-plugins/#scrollbarwidth
			$.scrollbarWidth = function () {
				var parent = $('<div style="width:50px;height:50px;overflow:auto"><div/></div>').appendTo('body'),
				    child = parent.children(),
				    width = child.innerWidth() - child.height(99).innerWidth();

				parent.remove();

				return width;
			};
		}

		if ($.support.fixedPosition === undefined) {
			$.support.fixedPosition = function () {
				var elem = $('<div style="position:fixed;top:20px;"></div>').appendTo('body'),
				    fixed = elem[0].offsetTop === 20 || elem[0].offsetTop === 15;

				elem.remove();

				return fixed;
			}();
		}

		$.extend(F.defaults, {
			scrollbarWidth: $.scrollbarWidth(),
			fixed: $.support.fixedPosition,
			parent: $('body')
		});

		//Get real width of page scroll-bar
		w1 = $(window).width();

		H.addClass('fancybox-lock-test');

		w2 = $(window).width();

		H.removeClass('fancybox-lock-test');

		$("<style type='text/css'>.fancybox-margin{margin-right:" + (w2 - w1) + "px;}</style>").appendTo("head");
	});
})(window, document, jQuery);
!function (i) {
	"use strict";
	"function" == typeof define && define.amd ? define(["jquery"], i) : "undefined" != typeof exports ? module.exports = i(require("jquery")) : i(jQuery);
}(function (i) {
	"use strict";
	var e = window.Slick || {};(e = function () {
		var e = 0;return function (t, o) {
			var s,
			    n = this;n.defaults = { accessibility: !0, adaptiveHeight: !1, appendArrows: i(t), appendDots: i(t), arrows: !0, asNavFor: null, prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>', nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>', autoplay: !1, autoplaySpeed: 3e3, centerMode: !1, centerPadding: "50px", cssEase: "ease", customPaging: function customPaging(e, t) {
					return i('<button type="button" />').text(t + 1);
				}, dots: !1, dotsClass: "slick-dots", draggable: !0, easing: "linear", edgeFriction: .35, fade: !1, focusOnSelect: !1, focusOnChange: !1, infinite: !0, initialSlide: 0, lazyLoad: "ondemand", mobileFirst: !1, pauseOnHover: !0, pauseOnFocus: !0, pauseOnDotsHover: !1, respondTo: "window", responsive: null, rows: 1, rtl: !1, slide: "", slidesPerRow: 1, slidesToShow: 1, slidesToScroll: 1, speed: 500, swipe: !0, swipeToSlide: !1, touchMove: !0, touchThreshold: 5, useCSS: !0, useTransform: !0, variableWidth: !1, vertical: !1, verticalSwiping: !1, waitForAnimate: !0, zIndex: 1e3 }, n.initials = { animating: !1, dragging: !1, autoPlayTimer: null, currentDirection: 0, currentLeft: null, currentSlide: 0, direction: 1, $dots: null, listWidth: null, listHeight: null, loadIndex: 0, $nextArrow: null, $prevArrow: null, scrolling: !1, slideCount: null, slideWidth: null, $slideTrack: null, $slides: null, sliding: !1, slideOffset: 0, swipeLeft: null, swiping: !1, $list: null, touchObject: {}, transformsEnabled: !1, unslicked: !1 }, i.extend(n, n.initials), n.activeBreakpoint = null, n.animType = null, n.animProp = null, n.breakpoints = [], n.breakpointSettings = [], n.cssTransitions = !1, n.focussed = !1, n.interrupted = !1, n.hidden = "hidden", n.paused = !0, n.positionProp = null, n.respondTo = null, n.rowCount = 1, n.shouldClick = !0, n.$slider = i(t), n.$slidesCache = null, n.transformType = null, n.transitionType = null, n.visibilityChange = "visibilitychange", n.windowWidth = 0, n.windowTimer = null, s = i(t).data("slick") || {}, n.options = i.extend({}, n.defaults, o, s), n.currentSlide = n.options.initialSlide, n.originalSettings = n.options, void 0 !== document.mozHidden ? (n.hidden = "mozHidden", n.visibilityChange = "mozvisibilitychange") : void 0 !== document.webkitHidden && (n.hidden = "webkitHidden", n.visibilityChange = "webkitvisibilitychange"), n.autoPlay = i.proxy(n.autoPlay, n), n.autoPlayClear = i.proxy(n.autoPlayClear, n), n.autoPlayIterator = i.proxy(n.autoPlayIterator, n), n.changeSlide = i.proxy(n.changeSlide, n), n.clickHandler = i.proxy(n.clickHandler, n), n.selectHandler = i.proxy(n.selectHandler, n), n.setPosition = i.proxy(n.setPosition, n), n.swipeHandler = i.proxy(n.swipeHandler, n), n.dragHandler = i.proxy(n.dragHandler, n), n.keyHandler = i.proxy(n.keyHandler, n), n.instanceUid = e++, n.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, n.registerBreakpoints(), n.init(!0);
		};
	}()).prototype.activateADA = function () {
		this.$slideTrack.find(".slick-active").attr({ "aria-hidden": "false" }).find("a, input, button, select").attr({ tabindex: "0" });
	}, e.prototype.addSlide = e.prototype.slickAdd = function (e, t, o) {
		var s = this;if ("boolean" == typeof t) o = t, t = null;else if (t < 0 || t >= s.slideCount) return !1;s.unload(), "number" == typeof t ? 0 === t && 0 === s.$slides.length ? i(e).appendTo(s.$slideTrack) : o ? i(e).insertBefore(s.$slides.eq(t)) : i(e).insertAfter(s.$slides.eq(t)) : !0 === o ? i(e).prependTo(s.$slideTrack) : i(e).appendTo(s.$slideTrack), s.$slides = s.$slideTrack.children(this.options.slide), s.$slideTrack.children(this.options.slide).detach(), s.$slideTrack.append(s.$slides), s.$slides.each(function (e, t) {
			i(t).attr("data-slick-index", e);
		}), s.$slidesCache = s.$slides, s.reinit();
	}, e.prototype.animateHeight = function () {
		var i = this;if (1 === i.options.slidesToShow && !0 === i.options.adaptiveHeight && !1 === i.options.vertical) {
			var e = i.$slides.eq(i.currentSlide).outerHeight(!0);i.$list.animate({ height: e }, i.options.speed);
		}
	}, e.prototype.animateSlide = function (e, t) {
		var o = {},
		    s = this;s.animateHeight(), !0 === s.options.rtl && !1 === s.options.vertical && (e = -e), !1 === s.transformsEnabled ? !1 === s.options.vertical ? s.$slideTrack.animate({ left: e }, s.options.speed, s.options.easing, t) : s.$slideTrack.animate({ top: e }, s.options.speed, s.options.easing, t) : !1 === s.cssTransitions ? (!0 === s.options.rtl && (s.currentLeft = -s.currentLeft), i({ animStart: s.currentLeft }).animate({ animStart: e }, { duration: s.options.speed, easing: s.options.easing, step: function step(i) {
				i = Math.ceil(i), !1 === s.options.vertical ? (o[s.animType] = "translate(" + i + "px, 0px)", s.$slideTrack.css(o)) : (o[s.animType] = "translate(0px," + i + "px)", s.$slideTrack.css(o));
			}, complete: function complete() {
				t && t.call();
			} })) : (s.applyTransition(), e = Math.ceil(e), !1 === s.options.vertical ? o[s.animType] = "translate3d(" + e + "px, 0px, 0px)" : o[s.animType] = "translate3d(0px," + e + "px, 0px)", s.$slideTrack.css(o), t && setTimeout(function () {
			s.disableTransition(), t.call();
		}, s.options.speed));
	}, e.prototype.getNavTarget = function () {
		var e = this,
		    t = e.options.asNavFor;return t && null !== t && (t = i(t).not(e.$slider)), t;
	}, e.prototype.asNavFor = function (e) {
		var t = this.getNavTarget();null !== t && "object" == (typeof t === 'undefined' ? 'undefined' : _typeof(t)) && t.each(function () {
			var t = i(this).slick("getSlick");t.unslicked || t.slideHandler(e, !0);
		});
	}, e.prototype.applyTransition = function (i) {
		var e = this,
		    t = {};!1 === e.options.fade ? t[e.transitionType] = e.transformType + " " + e.options.speed + "ms " + e.options.cssEase : t[e.transitionType] = "opacity " + e.options.speed + "ms " + e.options.cssEase, !1 === e.options.fade ? e.$slideTrack.css(t) : e.$slides.eq(i).css(t);
	}, e.prototype.autoPlay = function () {
		var i = this;i.autoPlayClear(), i.slideCount > i.options.slidesToShow && (i.autoPlayTimer = setInterval(i.autoPlayIterator, i.options.autoplaySpeed));
	}, e.prototype.autoPlayClear = function () {
		var i = this;i.autoPlayTimer && clearInterval(i.autoPlayTimer);
	}, e.prototype.autoPlayIterator = function () {
		var i = this,
		    e = i.currentSlide + i.options.slidesToScroll;i.paused || i.interrupted || i.focussed || (!1 === i.options.infinite && (1 === i.direction && i.currentSlide + 1 === i.slideCount - 1 ? i.direction = 0 : 0 === i.direction && (e = i.currentSlide - i.options.slidesToScroll, i.currentSlide - 1 == 0 && (i.direction = 1))), i.slideHandler(e));
	}, e.prototype.buildArrows = function () {
		var e = this;!0 === e.options.arrows && (e.$prevArrow = i(e.options.prevArrow).addClass("slick-arrow"), e.$nextArrow = i(e.options.nextArrow).addClass("slick-arrow"), e.slideCount > e.options.slidesToShow ? (e.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.prependTo(e.options.appendArrows), e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.appendTo(e.options.appendArrows), !0 !== e.options.infinite && e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : e.$prevArrow.add(e.$nextArrow).addClass("slick-hidden").attr({ "aria-disabled": "true", tabindex: "-1" }));
	}, e.prototype.buildDots = function () {
		var e,
		    t,
		    o = this;if (!0 === o.options.dots) {
			for (o.$slider.addClass("slick-dotted"), t = i("<ul />").addClass(o.options.dotsClass), e = 0; e <= o.getDotCount(); e += 1) {
				t.append(i("<li />").append(o.options.customPaging.call(this, o, e)));
			}o.$dots = t.appendTo(o.options.appendDots), o.$dots.find("li").first().addClass("slick-active");
		}
	}, e.prototype.buildOut = function () {
		var e = this;e.$slides = e.$slider.children(e.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), e.slideCount = e.$slides.length, e.$slides.each(function (e, t) {
			i(t).attr("data-slick-index", e).data("originalStyling", i(t).attr("style") || "");
		}), e.$slider.addClass("slick-slider"), e.$slideTrack = 0 === e.slideCount ? i('<div class="slick-track"/>').appendTo(e.$slider) : e.$slides.wrapAll('<div class="slick-track"/>').parent(), e.$list = e.$slideTrack.wrap('<div class="slick-list"/>').parent(), e.$slideTrack.css("opacity", 0), !0 !== e.options.centerMode && !0 !== e.options.swipeToSlide || (e.options.slidesToScroll = 1), i("img[data-lazy]", e.$slider).not("[src]").addClass("slick-loading"), e.setupInfinite(), e.buildArrows(), e.buildDots(), e.updateDots(), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), !0 === e.options.draggable && e.$list.addClass("draggable");
	}, e.prototype.buildRows = function () {
		var i,
		    e,
		    t,
		    o,
		    s,
		    n,
		    r,
		    l = this;if (o = document.createDocumentFragment(), n = l.$slider.children(), l.options.rows > 1) {
			for (r = l.options.slidesPerRow * l.options.rows, s = Math.ceil(n.length / r), i = 0; i < s; i++) {
				var d = document.createElement("div");for (e = 0; e < l.options.rows; e++) {
					var a = document.createElement("div");for (t = 0; t < l.options.slidesPerRow; t++) {
						var c = i * r + (e * l.options.slidesPerRow + t);n.get(c) && a.appendChild(n.get(c));
					}d.appendChild(a);
				}o.appendChild(d);
			}l.$slider.empty().append(o), l.$slider.children().children().children().css({ width: 100 / l.options.slidesPerRow + "%", display: "inline-block" });
		}
	}, e.prototype.checkResponsive = function (e, t) {
		var o,
		    s,
		    n,
		    r = this,
		    l = !1,
		    d = r.$slider.width(),
		    a = window.innerWidth || i(window).width();if ("window" === r.respondTo ? n = a : "slider" === r.respondTo ? n = d : "min" === r.respondTo && (n = Math.min(a, d)), r.options.responsive && r.options.responsive.length && null !== r.options.responsive) {
			s = null;for (o in r.breakpoints) {
				r.breakpoints.hasOwnProperty(o) && (!1 === r.originalSettings.mobileFirst ? n < r.breakpoints[o] && (s = r.breakpoints[o]) : n > r.breakpoints[o] && (s = r.breakpoints[o]));
			}null !== s ? null !== r.activeBreakpoint ? (s !== r.activeBreakpoint || t) && (r.activeBreakpoint = s, "unslick" === r.breakpointSettings[s] ? r.unslick(s) : (r.options = i.extend({}, r.originalSettings, r.breakpointSettings[s]), !0 === e && (r.currentSlide = r.options.initialSlide), r.refresh(e)), l = s) : (r.activeBreakpoint = s, "unslick" === r.breakpointSettings[s] ? r.unslick(s) : (r.options = i.extend({}, r.originalSettings, r.breakpointSettings[s]), !0 === e && (r.currentSlide = r.options.initialSlide), r.refresh(e)), l = s) : null !== r.activeBreakpoint && (r.activeBreakpoint = null, r.options = r.originalSettings, !0 === e && (r.currentSlide = r.options.initialSlide), r.refresh(e), l = s), e || !1 === l || r.$slider.trigger("breakpoint", [r, l]);
		}
	}, e.prototype.changeSlide = function (e, t) {
		var o,
		    s,
		    n,
		    r = this,
		    l = i(e.currentTarget);switch (l.is("a") && e.preventDefault(), l.is("li") || (l = l.closest("li")), n = r.slideCount % r.options.slidesToScroll != 0, o = n ? 0 : (r.slideCount - r.currentSlide) % r.options.slidesToScroll, e.data.message) {case "previous":
				s = 0 === o ? r.options.slidesToScroll : r.options.slidesToShow - o, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide - s, !1, t);break;case "next":
				s = 0 === o ? r.options.slidesToScroll : o, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide + s, !1, t);break;case "index":
				var d = 0 === e.data.index ? 0 : e.data.index || l.index() * r.options.slidesToScroll;r.slideHandler(r.checkNavigable(d), !1, t), l.children().trigger("focus");break;default:
				return;}
	}, e.prototype.checkNavigable = function (i) {
		var e, t;if (e = this.getNavigableIndexes(), t = 0, i > e[e.length - 1]) i = e[e.length - 1];else for (var o in e) {
			if (i < e[o]) {
				i = t;break;
			}t = e[o];
		}return i;
	}, e.prototype.cleanUpEvents = function () {
		var e = this;e.options.dots && null !== e.$dots && (i("li", e.$dots).off("click.slick", e.changeSlide).off("mouseenter.slick", i.proxy(e.interrupt, e, !0)).off("mouseleave.slick", i.proxy(e.interrupt, e, !1)), !0 === e.options.accessibility && e.$dots.off("keydown.slick", e.keyHandler)), e.$slider.off("focus.slick blur.slick"), !0 === e.options.arrows && e.slideCount > e.options.slidesToShow && (e.$prevArrow && e.$prevArrow.off("click.slick", e.changeSlide), e.$nextArrow && e.$nextArrow.off("click.slick", e.changeSlide), !0 === e.options.accessibility && (e.$prevArrow && e.$prevArrow.off("keydown.slick", e.keyHandler), e.$nextArrow && e.$nextArrow.off("keydown.slick", e.keyHandler))), e.$list.off("touchstart.slick mousedown.slick", e.swipeHandler), e.$list.off("touchmove.slick mousemove.slick", e.swipeHandler), e.$list.off("touchend.slick mouseup.slick", e.swipeHandler), e.$list.off("touchcancel.slick mouseleave.slick", e.swipeHandler), e.$list.off("click.slick", e.clickHandler), i(document).off(e.visibilityChange, e.visibility), e.cleanUpSlideEvents(), !0 === e.options.accessibility && e.$list.off("keydown.slick", e.keyHandler), !0 === e.options.focusOnSelect && i(e.$slideTrack).children().off("click.slick", e.selectHandler), i(window).off("orientationchange.slick.slick-" + e.instanceUid, e.orientationChange), i(window).off("resize.slick.slick-" + e.instanceUid, e.resize), i("[draggable!=true]", e.$slideTrack).off("dragstart", e.preventDefault), i(window).off("load.slick.slick-" + e.instanceUid, e.setPosition);
	}, e.prototype.cleanUpSlideEvents = function () {
		var e = this;e.$list.off("mouseenter.slick", i.proxy(e.interrupt, e, !0)), e.$list.off("mouseleave.slick", i.proxy(e.interrupt, e, !1));
	}, e.prototype.cleanUpRows = function () {
		var i,
		    e = this;e.options.rows > 1 && ((i = e.$slides.children().children()).removeAttr("style"), e.$slider.empty().append(i));
	}, e.prototype.clickHandler = function (i) {
		!1 === this.shouldClick && (i.stopImmediatePropagation(), i.stopPropagation(), i.preventDefault());
	}, e.prototype.destroy = function (e) {
		var t = this;t.autoPlayClear(), t.touchObject = {}, t.cleanUpEvents(), i(".slick-cloned", t.$slider).detach(), t.$dots && t.$dots.remove(), t.$prevArrow && t.$prevArrow.length && (t.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.remove()), t.$nextArrow && t.$nextArrow.length && (t.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.remove()), t.$slides && (t.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
			i(this).attr("style", i(this).data("originalStyling"));
		}), t.$slideTrack.children(this.options.slide).detach(), t.$slideTrack.detach(), t.$list.detach(), t.$slider.append(t.$slides)), t.cleanUpRows(), t.$slider.removeClass("slick-slider"), t.$slider.removeClass("slick-initialized"), t.$slider.removeClass("slick-dotted"), t.unslicked = !0, e || t.$slider.trigger("destroy", [t]);
	}, e.prototype.disableTransition = function (i) {
		var e = this,
		    t = {};t[e.transitionType] = "", !1 === e.options.fade ? e.$slideTrack.css(t) : e.$slides.eq(i).css(t);
	}, e.prototype.fadeSlide = function (i, e) {
		var t = this;!1 === t.cssTransitions ? (t.$slides.eq(i).css({ zIndex: t.options.zIndex }), t.$slides.eq(i).animate({ opacity: 1 }, t.options.speed, t.options.easing, e)) : (t.applyTransition(i), t.$slides.eq(i).css({ opacity: 1, zIndex: t.options.zIndex }), e && setTimeout(function () {
			t.disableTransition(i), e.call();
		}, t.options.speed));
	}, e.prototype.fadeSlideOut = function (i) {
		var e = this;!1 === e.cssTransitions ? e.$slides.eq(i).animate({ opacity: 0, zIndex: e.options.zIndex - 2 }, e.options.speed, e.options.easing) : (e.applyTransition(i), e.$slides.eq(i).css({ opacity: 0, zIndex: e.options.zIndex - 2 }));
	}, e.prototype.filterSlides = e.prototype.slickFilter = function (i) {
		var e = this;null !== i && (e.$slidesCache = e.$slides, e.unload(), e.$slideTrack.children(this.options.slide).detach(), e.$slidesCache.filter(i).appendTo(e.$slideTrack), e.reinit());
	}, e.prototype.focusHandler = function () {
		var e = this;e.$slider.off("focus.slick blur.slick").on("focus.slick blur.slick", "*", function (t) {
			t.stopImmediatePropagation();var o = i(this);setTimeout(function () {
				e.options.pauseOnFocus && (e.focussed = o.is(":focus"), e.autoPlay());
			}, 0);
		});
	}, e.prototype.getCurrent = e.prototype.slickCurrentSlide = function () {
		return this.currentSlide;
	}, e.prototype.getDotCount = function () {
		var i = this,
		    e = 0,
		    t = 0,
		    o = 0;if (!0 === i.options.infinite) {
			if (i.slideCount <= i.options.slidesToShow) ++o;else for (; e < i.slideCount;) {
				++o, e = t + i.options.slidesToScroll, t += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow;
			}
		} else if (!0 === i.options.centerMode) o = i.slideCount;else if (i.options.asNavFor) for (; e < i.slideCount;) {
			++o, e = t + i.options.slidesToScroll, t += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow;
		} else o = 1 + Math.ceil((i.slideCount - i.options.slidesToShow) / i.options.slidesToScroll);return o - 1;
	}, e.prototype.getLeft = function (i) {
		var e,
		    t,
		    o,
		    s,
		    n = this,
		    r = 0;return n.slideOffset = 0, t = n.$slides.first().outerHeight(!0), !0 === n.options.infinite ? (n.slideCount > n.options.slidesToShow && (n.slideOffset = n.slideWidth * n.options.slidesToShow * -1, s = -1, !0 === n.options.vertical && !0 === n.options.centerMode && (2 === n.options.slidesToShow ? s = -1.5 : 1 === n.options.slidesToShow && (s = -2)), r = t * n.options.slidesToShow * s), n.slideCount % n.options.slidesToScroll != 0 && i + n.options.slidesToScroll > n.slideCount && n.slideCount > n.options.slidesToShow && (i > n.slideCount ? (n.slideOffset = (n.options.slidesToShow - (i - n.slideCount)) * n.slideWidth * -1, r = (n.options.slidesToShow - (i - n.slideCount)) * t * -1) : (n.slideOffset = n.slideCount % n.options.slidesToScroll * n.slideWidth * -1, r = n.slideCount % n.options.slidesToScroll * t * -1))) : i + n.options.slidesToShow > n.slideCount && (n.slideOffset = (i + n.options.slidesToShow - n.slideCount) * n.slideWidth, r = (i + n.options.slidesToShow - n.slideCount) * t), n.slideCount <= n.options.slidesToShow && (n.slideOffset = 0, r = 0), !0 === n.options.centerMode && n.slideCount <= n.options.slidesToShow ? n.slideOffset = n.slideWidth * Math.floor(n.options.slidesToShow) / 2 - n.slideWidth * n.slideCount / 2 : !0 === n.options.centerMode && !0 === n.options.infinite ? n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2) - n.slideWidth : !0 === n.options.centerMode && (n.slideOffset = 0, n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2)), e = !1 === n.options.vertical ? i * n.slideWidth * -1 + n.slideOffset : i * t * -1 + r, !0 === n.options.variableWidth && (o = n.slideCount <= n.options.slidesToShow || !1 === n.options.infinite ? n.$slideTrack.children(".slick-slide").eq(i) : n.$slideTrack.children(".slick-slide").eq(i + n.options.slidesToShow), e = !0 === n.options.rtl ? o[0] ? -1 * (n.$slideTrack.width() - o[0].offsetLeft - o.width()) : 0 : o[0] ? -1 * o[0].offsetLeft : 0, !0 === n.options.centerMode && (o = n.slideCount <= n.options.slidesToShow || !1 === n.options.infinite ? n.$slideTrack.children(".slick-slide").eq(i) : n.$slideTrack.children(".slick-slide").eq(i + n.options.slidesToShow + 1), e = !0 === n.options.rtl ? o[0] ? -1 * (n.$slideTrack.width() - o[0].offsetLeft - o.width()) : 0 : o[0] ? -1 * o[0].offsetLeft : 0, e += (n.$list.width() - o.outerWidth()) / 2)), e;
	}, e.prototype.getOption = e.prototype.slickGetOption = function (i) {
		return this.options[i];
	}, e.prototype.getNavigableIndexes = function () {
		var i,
		    e = this,
		    t = 0,
		    o = 0,
		    s = [];for (!1 === e.options.infinite ? i = e.slideCount : (t = -1 * e.options.slidesToScroll, o = -1 * e.options.slidesToScroll, i = 2 * e.slideCount); t < i;) {
			s.push(t), t = o + e.options.slidesToScroll, o += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow;
		}return s;
	}, e.prototype.getSlick = function () {
		return this;
	}, e.prototype.getSlideCount = function () {
		var e,
		    t,
		    o = this;return t = !0 === o.options.centerMode ? o.slideWidth * Math.floor(o.options.slidesToShow / 2) : 0, !0 === o.options.swipeToSlide ? (o.$slideTrack.find(".slick-slide").each(function (s, n) {
			if (n.offsetLeft - t + i(n).outerWidth() / 2 > -1 * o.swipeLeft) return e = n, !1;
		}), Math.abs(i(e).attr("data-slick-index") - o.currentSlide) || 1) : o.options.slidesToScroll;
	}, e.prototype.goTo = e.prototype.slickGoTo = function (i, e) {
		this.changeSlide({ data: { message: "index", index: parseInt(i) } }, e);
	}, e.prototype.init = function (e) {
		var t = this;i(t.$slider).hasClass("slick-initialized") || (i(t.$slider).addClass("slick-initialized"), t.buildRows(), t.buildOut(), t.setProps(), t.startLoad(), t.loadSlider(), t.initializeEvents(), t.updateArrows(), t.updateDots(), t.checkResponsive(!0), t.focusHandler()), e && t.$slider.trigger("init", [t]), !0 === t.options.accessibility && t.initADA(), t.options.autoplay && (t.paused = !1, t.autoPlay());
	}, e.prototype.initADA = function () {
		var e = this,
		    t = Math.ceil(e.slideCount / e.options.slidesToShow),
		    o = e.getNavigableIndexes().filter(function (i) {
			return i >= 0 && i < e.slideCount;
		});e.$slides.add(e.$slideTrack.find(".slick-cloned")).attr({ "aria-hidden": "true", tabindex: "-1" }).find("a, input, button, select").attr({ tabindex: "-1" }), null !== e.$dots && (e.$slides.not(e.$slideTrack.find(".slick-cloned")).each(function (t) {
			var s = o.indexOf(t);i(this).attr({ role: "tabpanel", id: "slick-slide" + e.instanceUid + t, tabindex: -1 }), -1 !== s && i(this).attr({ "aria-describedby": "slick-slide-control" + e.instanceUid + s });
		}), e.$dots.attr("role", "tablist").find("li").each(function (s) {
			var n = o[s];i(this).attr({ role: "presentation" }), i(this).find("button").first().attr({ role: "tab", id: "slick-slide-control" + e.instanceUid + s, "aria-controls": "slick-slide" + e.instanceUid + n, "aria-label": s + 1 + " of " + t, "aria-selected": null, tabindex: "-1" });
		}).eq(e.currentSlide).find("button").attr({ "aria-selected": "true", tabindex: "0" }).end());for (var s = e.currentSlide, n = s + e.options.slidesToShow; s < n; s++) {
			e.$slides.eq(s).attr("tabindex", 0);
		}e.activateADA();
	}, e.prototype.initArrowEvents = function () {
		var i = this;!0 === i.options.arrows && i.slideCount > i.options.slidesToShow && (i.$prevArrow.off("click.slick").on("click.slick", { message: "previous" }, i.changeSlide), i.$nextArrow.off("click.slick").on("click.slick", { message: "next" }, i.changeSlide), !0 === i.options.accessibility && (i.$prevArrow.on("keydown.slick", i.keyHandler), i.$nextArrow.on("keydown.slick", i.keyHandler)));
	}, e.prototype.initDotEvents = function () {
		var e = this;!0 === e.options.dots && (i("li", e.$dots).on("click.slick", { message: "index" }, e.changeSlide), !0 === e.options.accessibility && e.$dots.on("keydown.slick", e.keyHandler)), !0 === e.options.dots && !0 === e.options.pauseOnDotsHover && i("li", e.$dots).on("mouseenter.slick", i.proxy(e.interrupt, e, !0)).on("mouseleave.slick", i.proxy(e.interrupt, e, !1));
	}, e.prototype.initSlideEvents = function () {
		var e = this;e.options.pauseOnHover && (e.$list.on("mouseenter.slick", i.proxy(e.interrupt, e, !0)), e.$list.on("mouseleave.slick", i.proxy(e.interrupt, e, !1)));
	}, e.prototype.initializeEvents = function () {
		var e = this;e.initArrowEvents(), e.initDotEvents(), e.initSlideEvents(), e.$list.on("touchstart.slick mousedown.slick", { action: "start" }, e.swipeHandler), e.$list.on("touchmove.slick mousemove.slick", { action: "move" }, e.swipeHandler), e.$list.on("touchend.slick mouseup.slick", { action: "end" }, e.swipeHandler), e.$list.on("touchcancel.slick mouseleave.slick", { action: "end" }, e.swipeHandler), e.$list.on("click.slick", e.clickHandler), i(document).on(e.visibilityChange, i.proxy(e.visibility, e)), !0 === e.options.accessibility && e.$list.on("keydown.slick", e.keyHandler), !0 === e.options.focusOnSelect && i(e.$slideTrack).children().on("click.slick", e.selectHandler), i(window).on("orientationchange.slick.slick-" + e.instanceUid, i.proxy(e.orientationChange, e)), i(window).on("resize.slick.slick-" + e.instanceUid, i.proxy(e.resize, e)), i("[draggable!=true]", e.$slideTrack).on("dragstart", e.preventDefault), i(window).on("load.slick.slick-" + e.instanceUid, e.setPosition), i(e.setPosition);
	}, e.prototype.initUI = function () {
		var i = this;!0 === i.options.arrows && i.slideCount > i.options.slidesToShow && (i.$prevArrow.show(), i.$nextArrow.show()), !0 === i.options.dots && i.slideCount > i.options.slidesToShow && i.$dots.show();
	}, e.prototype.keyHandler = function (i) {
		var e = this;i.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === i.keyCode && !0 === e.options.accessibility ? e.changeSlide({ data: { message: !0 === e.options.rtl ? "next" : "previous" } }) : 39 === i.keyCode && !0 === e.options.accessibility && e.changeSlide({ data: { message: !0 === e.options.rtl ? "previous" : "next" } }));
	}, e.prototype.lazyLoad = function () {
		function e(e) {
			i("img[data-lazy]", e).each(function () {
				var e = i(this),
				    t = i(this).attr("data-lazy"),
				    o = i(this).attr("data-srcset"),
				    s = i(this).attr("data-sizes") || n.$slider.attr("data-sizes"),
				    r = document.createElement("img");r.onload = function () {
					e.animate({ opacity: 0 }, 100, function () {
						o && (e.attr("srcset", o), s && e.attr("sizes", s)), e.attr("src", t).animate({ opacity: 1 }, 200, function () {
							e.removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading");
						}), n.$slider.trigger("lazyLoaded", [n, e, t]);
					});
				}, r.onerror = function () {
					e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), n.$slider.trigger("lazyLoadError", [n, e, t]);
				}, r.src = t;
			});
		}var t,
		    o,
		    s,
		    n = this;if (!0 === n.options.centerMode ? !0 === n.options.infinite ? s = (o = n.currentSlide + (n.options.slidesToShow / 2 + 1)) + n.options.slidesToShow + 2 : (o = Math.max(0, n.currentSlide - (n.options.slidesToShow / 2 + 1)), s = n.options.slidesToShow / 2 + 1 + 2 + n.currentSlide) : (o = n.options.infinite ? n.options.slidesToShow + n.currentSlide : n.currentSlide, s = Math.ceil(o + n.options.slidesToShow), !0 === n.options.fade && (o > 0 && o--, s <= n.slideCount && s++)), t = n.$slider.find(".slick-slide").slice(o, s), "anticipated" === n.options.lazyLoad) for (var r = o - 1, l = s, d = n.$slider.find(".slick-slide"), a = 0; a < n.options.slidesToScroll; a++) {
			r < 0 && (r = n.slideCount - 1), t = (t = t.add(d.eq(r))).add(d.eq(l)), r--, l++;
		}e(t), n.slideCount <= n.options.slidesToShow ? e(n.$slider.find(".slick-slide")) : n.currentSlide >= n.slideCount - n.options.slidesToShow ? e(n.$slider.find(".slick-cloned").slice(0, n.options.slidesToShow)) : 0 === n.currentSlide && e(n.$slider.find(".slick-cloned").slice(-1 * n.options.slidesToShow));
	}, e.prototype.loadSlider = function () {
		var i = this;i.setPosition(), i.$slideTrack.css({ opacity: 1 }), i.$slider.removeClass("slick-loading"), i.initUI(), "progressive" === i.options.lazyLoad && i.progressiveLazyLoad();
	}, e.prototype.next = e.prototype.slickNext = function () {
		this.changeSlide({ data: { message: "next" } });
	}, e.prototype.orientationChange = function () {
		var i = this;i.checkResponsive(), i.setPosition();
	}, e.prototype.pause = e.prototype.slickPause = function () {
		var i = this;i.autoPlayClear(), i.paused = !0;
	}, e.prototype.play = e.prototype.slickPlay = function () {
		var i = this;i.autoPlay(), i.options.autoplay = !0, i.paused = !1, i.focussed = !1, i.interrupted = !1;
	}, e.prototype.postSlide = function (e) {
		var t = this;t.unslicked || (t.$slider.trigger("afterChange", [t, e]), t.animating = !1, t.slideCount > t.options.slidesToShow && t.setPosition(), t.swipeLeft = null, t.options.autoplay && t.autoPlay(), !0 === t.options.accessibility && (t.initADA(), t.options.focusOnChange && i(t.$slides.get(t.currentSlide)).attr("tabindex", 0).focus()));
	}, e.prototype.prev = e.prototype.slickPrev = function () {
		this.changeSlide({ data: { message: "previous" } });
	}, e.prototype.preventDefault = function (i) {
		i.preventDefault();
	}, e.prototype.progressiveLazyLoad = function (e) {
		e = e || 1;var t,
		    o,
		    s,
		    n,
		    r,
		    l = this,
		    d = i("img[data-lazy]", l.$slider);d.length ? (t = d.first(), o = t.attr("data-lazy"), s = t.attr("data-srcset"), n = t.attr("data-sizes") || l.$slider.attr("data-sizes"), (r = document.createElement("img")).onload = function () {
			s && (t.attr("srcset", s), n && t.attr("sizes", n)), t.attr("src", o).removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading"), !0 === l.options.adaptiveHeight && l.setPosition(), l.$slider.trigger("lazyLoaded", [l, t, o]), l.progressiveLazyLoad();
		}, r.onerror = function () {
			e < 3 ? setTimeout(function () {
				l.progressiveLazyLoad(e + 1);
			}, 500) : (t.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), l.$slider.trigger("lazyLoadError", [l, t, o]), l.progressiveLazyLoad());
		}, r.src = o) : l.$slider.trigger("allImagesLoaded", [l]);
	}, e.prototype.refresh = function (e) {
		var t,
		    o,
		    s = this;o = s.slideCount - s.options.slidesToShow, !s.options.infinite && s.currentSlide > o && (s.currentSlide = o), s.slideCount <= s.options.slidesToShow && (s.currentSlide = 0), t = s.currentSlide, s.destroy(!0), i.extend(s, s.initials, { currentSlide: t }), s.init(), e || s.changeSlide({ data: { message: "index", index: t } }, !1);
	}, e.prototype.registerBreakpoints = function () {
		var e,
		    t,
		    o,
		    s = this,
		    n = s.options.responsive || null;if ("array" === i.type(n) && n.length) {
			s.respondTo = s.options.respondTo || "window";for (e in n) {
				if (o = s.breakpoints.length - 1, n.hasOwnProperty(e)) {
					for (t = n[e].breakpoint; o >= 0;) {
						s.breakpoints[o] && s.breakpoints[o] === t && s.breakpoints.splice(o, 1), o--;
					}s.breakpoints.push(t), s.breakpointSettings[t] = n[e].settings;
				}
			}s.breakpoints.sort(function (i, e) {
				return s.options.mobileFirst ? i - e : e - i;
			});
		}
	}, e.prototype.reinit = function () {
		var e = this;e.$slides = e.$slideTrack.children(e.options.slide).addClass("slick-slide"), e.slideCount = e.$slides.length, e.currentSlide >= e.slideCount && 0 !== e.currentSlide && (e.currentSlide = e.currentSlide - e.options.slidesToScroll), e.slideCount <= e.options.slidesToShow && (e.currentSlide = 0), e.registerBreakpoints(), e.setProps(), e.setupInfinite(), e.buildArrows(), e.updateArrows(), e.initArrowEvents(), e.buildDots(), e.updateDots(), e.initDotEvents(), e.cleanUpSlideEvents(), e.initSlideEvents(), e.checkResponsive(!1, !0), !0 === e.options.focusOnSelect && i(e.$slideTrack).children().on("click.slick", e.selectHandler), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), e.setPosition(), e.focusHandler(), e.paused = !e.options.autoplay, e.autoPlay(), e.$slider.trigger("reInit", [e]);
	}, e.prototype.resize = function () {
		var e = this;i(window).width() !== e.windowWidth && (clearTimeout(e.windowDelay), e.windowDelay = window.setTimeout(function () {
			e.windowWidth = i(window).width(), e.checkResponsive(), e.unslicked || e.setPosition();
		}, 50));
	}, e.prototype.removeSlide = e.prototype.slickRemove = function (i, e, t) {
		var o = this;if (i = "boolean" == typeof i ? !0 === (e = i) ? 0 : o.slideCount - 1 : !0 === e ? --i : i, o.slideCount < 1 || i < 0 || i > o.slideCount - 1) return !1;o.unload(), !0 === t ? o.$slideTrack.children().remove() : o.$slideTrack.children(this.options.slide).eq(i).remove(), o.$slides = o.$slideTrack.children(this.options.slide), o.$slideTrack.children(this.options.slide).detach(), o.$slideTrack.append(o.$slides), o.$slidesCache = o.$slides, o.reinit();
	}, e.prototype.setCSS = function (i) {
		var e,
		    t,
		    o = this,
		    s = {};!0 === o.options.rtl && (i = -i), e = "left" == o.positionProp ? Math.ceil(i) + "px" : "0px", t = "top" == o.positionProp ? Math.ceil(i) + "px" : "0px", s[o.positionProp] = i, !1 === o.transformsEnabled ? o.$slideTrack.css(s) : (s = {}, !1 === o.cssTransitions ? (s[o.animType] = "translate(" + e + ", " + t + ")", o.$slideTrack.css(s)) : (s[o.animType] = "translate3d(" + e + ", " + t + ", 0px)", o.$slideTrack.css(s)));
	}, e.prototype.setDimensions = function () {
		var i = this;!1 === i.options.vertical ? !0 === i.options.centerMode && i.$list.css({ padding: "0px " + i.options.centerPadding }) : (i.$list.height(i.$slides.first().outerHeight(!0) * i.options.slidesToShow), !0 === i.options.centerMode && i.$list.css({ padding: i.options.centerPadding + " 0px" })), i.listWidth = i.$list.width(), i.listHeight = i.$list.height(), !1 === i.options.vertical && !1 === i.options.variableWidth ? (i.slideWidth = Math.ceil(i.listWidth / i.options.slidesToShow), i.$slideTrack.width(Math.ceil(i.slideWidth * i.$slideTrack.children(".slick-slide").length))) : !0 === i.options.variableWidth ? i.$slideTrack.width(5e3 * i.slideCount) : (i.slideWidth = Math.ceil(i.listWidth), i.$slideTrack.height(Math.ceil(i.$slides.first().outerHeight(!0) * i.$slideTrack.children(".slick-slide").length)));var e = i.$slides.first().outerWidth(!0) - i.$slides.first().width();!1 === i.options.variableWidth && i.$slideTrack.children(".slick-slide").width(i.slideWidth - e);
	}, e.prototype.setFade = function () {
		var e,
		    t = this;t.$slides.each(function (o, s) {
			e = t.slideWidth * o * -1, !0 === t.options.rtl ? i(s).css({ position: "relative", right: e, top: 0, zIndex: t.options.zIndex - 2, opacity: 0 }) : i(s).css({ position: "relative", left: e, top: 0, zIndex: t.options.zIndex - 2, opacity: 0 });
		}), t.$slides.eq(t.currentSlide).css({ zIndex: t.options.zIndex - 1, opacity: 1 });
	}, e.prototype.setHeight = function () {
		var i = this;if (1 === i.options.slidesToShow && !0 === i.options.adaptiveHeight && !1 === i.options.vertical) {
			var e = i.$slides.eq(i.currentSlide).outerHeight(!0);i.$list.css("height", e);
		}
	}, e.prototype.setOption = e.prototype.slickSetOption = function () {
		var e,
		    t,
		    o,
		    s,
		    n,
		    r = this,
		    l = !1;if ("object" === i.type(arguments[0]) ? (o = arguments[0], l = arguments[1], n = "multiple") : "string" === i.type(arguments[0]) && (o = arguments[0], s = arguments[1], l = arguments[2], "responsive" === arguments[0] && "array" === i.type(arguments[1]) ? n = "responsive" : void 0 !== arguments[1] && (n = "single")), "single" === n) r.options[o] = s;else if ("multiple" === n) i.each(o, function (i, e) {
			r.options[i] = e;
		});else if ("responsive" === n) for (t in s) {
			if ("array" !== i.type(r.options.responsive)) r.options.responsive = [s[t]];else {
				for (e = r.options.responsive.length - 1; e >= 0;) {
					r.options.responsive[e].breakpoint === s[t].breakpoint && r.options.responsive.splice(e, 1), e--;
				}r.options.responsive.push(s[t]);
			}
		}l && (r.unload(), r.reinit());
	}, e.prototype.setPosition = function () {
		var i = this;i.setDimensions(), i.setHeight(), !1 === i.options.fade ? i.setCSS(i.getLeft(i.currentSlide)) : i.setFade(), i.$slider.trigger("setPosition", [i]);
	}, e.prototype.setProps = function () {
		var i = this,
		    e = document.body.style;i.positionProp = !0 === i.options.vertical ? "top" : "left", "top" === i.positionProp ? i.$slider.addClass("slick-vertical") : i.$slider.removeClass("slick-vertical"), void 0 === e.WebkitTransition && void 0 === e.MozTransition && void 0 === e.msTransition || !0 === i.options.useCSS && (i.cssTransitions = !0), i.options.fade && ("number" == typeof i.options.zIndex ? i.options.zIndex < 3 && (i.options.zIndex = 3) : i.options.zIndex = i.defaults.zIndex), void 0 !== e.OTransform && (i.animType = "OTransform", i.transformType = "-o-transform", i.transitionType = "OTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (i.animType = !1)), void 0 !== e.MozTransform && (i.animType = "MozTransform", i.transformType = "-moz-transform", i.transitionType = "MozTransition", void 0 === e.perspectiveProperty && void 0 === e.MozPerspective && (i.animType = !1)), void 0 !== e.webkitTransform && (i.animType = "webkitTransform", i.transformType = "-webkit-transform", i.transitionType = "webkitTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (i.animType = !1)), void 0 !== e.msTransform && (i.animType = "msTransform", i.transformType = "-ms-transform", i.transitionType = "msTransition", void 0 === e.msTransform && (i.animType = !1)), void 0 !== e.transform && !1 !== i.animType && (i.animType = "transform", i.transformType = "transform", i.transitionType = "transition"), i.transformsEnabled = i.options.useTransform && null !== i.animType && !1 !== i.animType;
	}, e.prototype.setSlideClasses = function (i) {
		var e,
		    t,
		    o,
		    s,
		    n = this;if (t = n.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), n.$slides.eq(i).addClass("slick-current"), !0 === n.options.centerMode) {
			var r = n.options.slidesToShow % 2 == 0 ? 1 : 0;e = Math.floor(n.options.slidesToShow / 2), !0 === n.options.infinite && (i >= e && i <= n.slideCount - 1 - e ? n.$slides.slice(i - e + r, i + e + 1).addClass("slick-active").attr("aria-hidden", "false") : (o = n.options.slidesToShow + i, t.slice(o - e + 1 + r, o + e + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === i ? t.eq(t.length - 1 - n.options.slidesToShow).addClass("slick-center") : i === n.slideCount - 1 && t.eq(n.options.slidesToShow).addClass("slick-center")), n.$slides.eq(i).addClass("slick-center");
		} else i >= 0 && i <= n.slideCount - n.options.slidesToShow ? n.$slides.slice(i, i + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : t.length <= n.options.slidesToShow ? t.addClass("slick-active").attr("aria-hidden", "false") : (s = n.slideCount % n.options.slidesToShow, o = !0 === n.options.infinite ? n.options.slidesToShow + i : i, n.options.slidesToShow == n.options.slidesToScroll && n.slideCount - i < n.options.slidesToShow ? t.slice(o - (n.options.slidesToShow - s), o + s).addClass("slick-active").attr("aria-hidden", "false") : t.slice(o, o + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false"));"ondemand" !== n.options.lazyLoad && "anticipated" !== n.options.lazyLoad || n.lazyLoad();
	}, e.prototype.setupInfinite = function () {
		var e,
		    t,
		    o,
		    s = this;if (!0 === s.options.fade && (s.options.centerMode = !1), !0 === s.options.infinite && !1 === s.options.fade && (t = null, s.slideCount > s.options.slidesToShow)) {
			for (o = !0 === s.options.centerMode ? s.options.slidesToShow + 1 : s.options.slidesToShow, e = s.slideCount; e > s.slideCount - o; e -= 1) {
				t = e - 1, i(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t - s.slideCount).prependTo(s.$slideTrack).addClass("slick-cloned");
			}for (e = 0; e < o + s.slideCount; e += 1) {
				t = e, i(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t + s.slideCount).appendTo(s.$slideTrack).addClass("slick-cloned");
			}s.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
				i(this).attr("id", "");
			});
		}
	}, e.prototype.interrupt = function (i) {
		var e = this;i || e.autoPlay(), e.interrupted = i;
	}, e.prototype.selectHandler = function (e) {
		var t = this,
		    o = i(e.target).is(".slick-slide") ? i(e.target) : i(e.target).parents(".slick-slide"),
		    s = parseInt(o.attr("data-slick-index"));s || (s = 0), t.slideCount <= t.options.slidesToShow ? t.slideHandler(s, !1, !0) : t.slideHandler(s);
	}, e.prototype.slideHandler = function (i, e, t) {
		var o,
		    s,
		    n,
		    r,
		    l,
		    d = null,
		    a = this;if (e = e || !1, !(!0 === a.animating && !0 === a.options.waitForAnimate || !0 === a.options.fade && a.currentSlide === i)) if (!1 === e && a.asNavFor(i), o = i, d = a.getLeft(o), r = a.getLeft(a.currentSlide), a.currentLeft = null === a.swipeLeft ? r : a.swipeLeft, !1 === a.options.infinite && !1 === a.options.centerMode && (i < 0 || i > a.getDotCount() * a.options.slidesToScroll)) !1 === a.options.fade && (o = a.currentSlide, !0 !== t ? a.animateSlide(r, function () {
			a.postSlide(o);
		}) : a.postSlide(o));else if (!1 === a.options.infinite && !0 === a.options.centerMode && (i < 0 || i > a.slideCount - a.options.slidesToScroll)) !1 === a.options.fade && (o = a.currentSlide, !0 !== t ? a.animateSlide(r, function () {
			a.postSlide(o);
		}) : a.postSlide(o));else {
			if (a.options.autoplay && clearInterval(a.autoPlayTimer), s = o < 0 ? a.slideCount % a.options.slidesToScroll != 0 ? a.slideCount - a.slideCount % a.options.slidesToScroll : a.slideCount + o : o >= a.slideCount ? a.slideCount % a.options.slidesToScroll != 0 ? 0 : o - a.slideCount : o, a.animating = !0, a.$slider.trigger("beforeChange", [a, a.currentSlide, s]), n = a.currentSlide, a.currentSlide = s, a.setSlideClasses(a.currentSlide), a.options.asNavFor && (l = (l = a.getNavTarget()).slick("getSlick")).slideCount <= l.options.slidesToShow && l.setSlideClasses(a.currentSlide), a.updateDots(), a.updateArrows(), !0 === a.options.fade) return !0 !== t ? (a.fadeSlideOut(n), a.fadeSlide(s, function () {
				a.postSlide(s);
			})) : a.postSlide(s), void a.animateHeight();!0 !== t ? a.animateSlide(d, function () {
				a.postSlide(s);
			}) : a.postSlide(s);
		}
	}, e.prototype.startLoad = function () {
		var i = this;!0 === i.options.arrows && i.slideCount > i.options.slidesToShow && (i.$prevArrow.hide(), i.$nextArrow.hide()), !0 === i.options.dots && i.slideCount > i.options.slidesToShow && i.$dots.hide(), i.$slider.addClass("slick-loading");
	}, e.prototype.swipeDirection = function () {
		var i,
		    e,
		    t,
		    o,
		    s = this;return i = s.touchObject.startX - s.touchObject.curX, e = s.touchObject.startY - s.touchObject.curY, t = Math.atan2(e, i), (o = Math.round(180 * t / Math.PI)) < 0 && (o = 360 - Math.abs(o)), o <= 45 && o >= 0 ? !1 === s.options.rtl ? "left" : "right" : o <= 360 && o >= 315 ? !1 === s.options.rtl ? "left" : "right" : o >= 135 && o <= 225 ? !1 === s.options.rtl ? "right" : "left" : !0 === s.options.verticalSwiping ? o >= 35 && o <= 135 ? "down" : "up" : "vertical";
	}, e.prototype.swipeEnd = function (i) {
		var e,
		    t,
		    o = this;if (o.dragging = !1, o.swiping = !1, o.scrolling) return o.scrolling = !1, !1;if (o.interrupted = !1, o.shouldClick = !(o.touchObject.swipeLength > 10), void 0 === o.touchObject.curX) return !1;if (!0 === o.touchObject.edgeHit && o.$slider.trigger("edge", [o, o.swipeDirection()]), o.touchObject.swipeLength >= o.touchObject.minSwipe) {
			switch (t = o.swipeDirection()) {case "left":case "down":
					e = o.options.swipeToSlide ? o.checkNavigable(o.currentSlide + o.getSlideCount()) : o.currentSlide + o.getSlideCount(), o.currentDirection = 0;break;case "right":case "up":
					e = o.options.swipeToSlide ? o.checkNavigable(o.currentSlide - o.getSlideCount()) : o.currentSlide - o.getSlideCount(), o.currentDirection = 1;}"vertical" != t && (o.slideHandler(e), o.touchObject = {}, o.$slider.trigger("swipe", [o, t]));
		} else o.touchObject.startX !== o.touchObject.curX && (o.slideHandler(o.currentSlide), o.touchObject = {});
	}, e.prototype.swipeHandler = function (i) {
		var e = this;if (!(!1 === e.options.swipe || "ontouchend" in document && !1 === e.options.swipe || !1 === e.options.draggable && -1 !== i.type.indexOf("mouse"))) switch (e.touchObject.fingerCount = i.originalEvent && void 0 !== i.originalEvent.touches ? i.originalEvent.touches.length : 1, e.touchObject.minSwipe = e.listWidth / e.options.touchThreshold, !0 === e.options.verticalSwiping && (e.touchObject.minSwipe = e.listHeight / e.options.touchThreshold), i.data.action) {case "start":
				e.swipeStart(i);break;case "move":
				e.swipeMove(i);break;case "end":
				e.swipeEnd(i);}
	}, e.prototype.swipeMove = function (i) {
		var e,
		    t,
		    o,
		    s,
		    n,
		    r,
		    l = this;return n = void 0 !== i.originalEvent ? i.originalEvent.touches : null, !(!l.dragging || l.scrolling || n && 1 !== n.length) && (e = l.getLeft(l.currentSlide), l.touchObject.curX = void 0 !== n ? n[0].pageX : i.clientX, l.touchObject.curY = void 0 !== n ? n[0].pageY : i.clientY, l.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(l.touchObject.curX - l.touchObject.startX, 2))), r = Math.round(Math.sqrt(Math.pow(l.touchObject.curY - l.touchObject.startY, 2))), !l.options.verticalSwiping && !l.swiping && r > 4 ? (l.scrolling = !0, !1) : (!0 === l.options.verticalSwiping && (l.touchObject.swipeLength = r), t = l.swipeDirection(), void 0 !== i.originalEvent && l.touchObject.swipeLength > 4 && (l.swiping = !0, i.preventDefault()), s = (!1 === l.options.rtl ? 1 : -1) * (l.touchObject.curX > l.touchObject.startX ? 1 : -1), !0 === l.options.verticalSwiping && (s = l.touchObject.curY > l.touchObject.startY ? 1 : -1), o = l.touchObject.swipeLength, l.touchObject.edgeHit = !1, !1 === l.options.infinite && (0 === l.currentSlide && "right" === t || l.currentSlide >= l.getDotCount() && "left" === t) && (o = l.touchObject.swipeLength * l.options.edgeFriction, l.touchObject.edgeHit = !0), !1 === l.options.vertical ? l.swipeLeft = e + o * s : l.swipeLeft = e + o * (l.$list.height() / l.listWidth) * s, !0 === l.options.verticalSwiping && (l.swipeLeft = e + o * s), !0 !== l.options.fade && !1 !== l.options.touchMove && (!0 === l.animating ? (l.swipeLeft = null, !1) : void l.setCSS(l.swipeLeft))));
	}, e.prototype.swipeStart = function (i) {
		var e,
		    t = this;if (t.interrupted = !0, 1 !== t.touchObject.fingerCount || t.slideCount <= t.options.slidesToShow) return t.touchObject = {}, !1;void 0 !== i.originalEvent && void 0 !== i.originalEvent.touches && (e = i.originalEvent.touches[0]), t.touchObject.startX = t.touchObject.curX = void 0 !== e ? e.pageX : i.clientX, t.touchObject.startY = t.touchObject.curY = void 0 !== e ? e.pageY : i.clientY, t.dragging = !0;
	}, e.prototype.unfilterSlides = e.prototype.slickUnfilter = function () {
		var i = this;null !== i.$slidesCache && (i.unload(), i.$slideTrack.children(this.options.slide).detach(), i.$slidesCache.appendTo(i.$slideTrack), i.reinit());
	}, e.prototype.unload = function () {
		var e = this;i(".slick-cloned", e.$slider).remove(), e.$dots && e.$dots.remove(), e.$prevArrow && e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.remove(), e.$nextArrow && e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.remove(), e.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "");
	}, e.prototype.unslick = function (i) {
		var e = this;e.$slider.trigger("unslick", [e, i]), e.destroy();
	}, e.prototype.updateArrows = function () {
		var i = this;Math.floor(i.options.slidesToShow / 2), !0 === i.options.arrows && i.slideCount > i.options.slidesToShow && !i.options.infinite && (i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), i.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === i.currentSlide ? (i.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : i.currentSlide >= i.slideCount - i.options.slidesToShow && !1 === i.options.centerMode ? (i.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : i.currentSlide >= i.slideCount - 1 && !0 === i.options.centerMode && (i.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), i.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")));
	}, e.prototype.updateDots = function () {
		var i = this;null !== i.$dots && (i.$dots.find("li").removeClass("slick-active").end(), i.$dots.find("li").eq(Math.floor(i.currentSlide / i.options.slidesToScroll)).addClass("slick-active"));
	}, e.prototype.visibility = function () {
		var i = this;i.options.autoplay && (document[i.hidden] ? i.interrupted = !0 : i.interrupted = !1);
	}, i.fn.slick = function () {
		var i,
		    t,
		    o = this,
		    s = arguments[0],
		    n = Array.prototype.slice.call(arguments, 1),
		    r = o.length;for (i = 0; i < r; i++) {
			if ("object" == (typeof s === 'undefined' ? 'undefined' : _typeof(s)) || void 0 === s ? o[i].slick = new e(o[i], s) : t = o[i].slick[s].apply(o[i].slick, n), void 0 !== t) return t;
		}return o;
	};
});

/*!
 * Flickity PACKAGED v2.1.2
 * Touch, responsive, flickable carousels
 *
 * Licensed GPLv3 for open source use
 * or Flickity Commercial License for commercial use
 *
 * https://flickity.metafizzy.co
 * Copyright 2015-2018 Metafizzy
 */

!function (t, e) {
	"function" == typeof define && define.amd ? define("jquery-bridget/jquery-bridget", ["jquery"], function (i) {
		return e(t, i);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("jquery")) : t.jQueryBridget = e(t, t.jQuery);
}(window, function (t, e) {
	"use strict";
	function i(i, o, a) {
		function l(t, e, n) {
			var s,
			    o = "$()." + i + '("' + e + '")';return t.each(function (t, l) {
				var h = a.data(l, i);if (!h) return void r(i + " not initialized. Cannot call methods, i.e. " + o);var c = h[e];if (!c || "_" == e.charAt(0)) return void r(o + " is not a valid method");var d = c.apply(h, n);s = void 0 === s ? d : s;
			}), void 0 !== s ? s : t;
		}function h(t, e) {
			t.each(function (t, n) {
				var s = a.data(n, i);s ? (s.option(e), s._init()) : (s = new o(n, e), a.data(n, i, s));
			});
		}a = a || e || t.jQuery, a && (o.prototype.option || (o.prototype.option = function (t) {
			a.isPlainObject(t) && (this.options = a.extend(!0, this.options, t));
		}), a.fn[i] = function (t) {
			if ("string" == typeof t) {
				var e = s.call(arguments, 1);return l(this, t, e);
			}return h(this, t), this;
		}, n(a));
	}function n(t) {
		!t || t && t.bridget || (t.bridget = i);
	}var s = Array.prototype.slice,
	    o = t.console,
	    r = "undefined" == typeof o ? function () {} : function (t) {
		o.error(t);
	};return n(e || t.jQuery), i;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("ev-emitter/ev-emitter", e) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e() : t.EvEmitter = e();
}("undefined" != typeof window ? window : this, function () {
	function t() {}var e = t.prototype;return e.on = function (t, e) {
		if (t && e) {
			var i = this._events = this._events || {},
			    n = i[t] = i[t] || [];return n.indexOf(e) == -1 && n.push(e), this;
		}
	}, e.once = function (t, e) {
		if (t && e) {
			this.on(t, e);var i = this._onceEvents = this._onceEvents || {},
			    n = i[t] = i[t] || {};return n[e] = !0, this;
		}
	}, e.off = function (t, e) {
		var i = this._events && this._events[t];if (i && i.length) {
			var n = i.indexOf(e);return n != -1 && i.splice(n, 1), this;
		}
	}, e.emitEvent = function (t, e) {
		var i = this._events && this._events[t];if (i && i.length) {
			i = i.slice(0), e = e || [];for (var n = this._onceEvents && this._onceEvents[t], s = 0; s < i.length; s++) {
				var o = i[s],
				    r = n && n[o];r && (this.off(t, o), delete n[o]), o.apply(this, e);
			}return this;
		}
	}, e.allOff = function () {
		delete this._events, delete this._onceEvents;
	}, t;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("get-size/get-size", e) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e() : t.getSize = e();
}(window, function () {
	"use strict";
	function t(t) {
		var e = parseFloat(t),
		    i = t.indexOf("%") == -1 && !isNaN(e);return i && e;
	}function e() {}function i() {
		for (var t = { width: 0, height: 0, innerWidth: 0, innerHeight: 0, outerWidth: 0, outerHeight: 0 }, e = 0; e < h; e++) {
			var i = l[e];t[i] = 0;
		}return t;
	}function n(t) {
		var e = getComputedStyle(t);return e || a("Style returned " + e + ". Are you running this code in a hidden iframe on Firefox? See https://bit.ly/getsizebug1"), e;
	}function s() {
		if (!c) {
			c = !0;var e = document.createElement("div");e.style.width = "200px", e.style.padding = "1px 2px 3px 4px", e.style.borderStyle = "solid", e.style.borderWidth = "1px 2px 3px 4px", e.style.boxSizing = "border-box";var i = document.body || document.documentElement;i.appendChild(e);var s = n(e);r = 200 == Math.round(t(s.width)), o.isBoxSizeOuter = r, i.removeChild(e);
		}
	}function o(e) {
		if (s(), "string" == typeof e && (e = document.querySelector(e)), e && "object" == (typeof e === 'undefined' ? 'undefined' : _typeof(e)) && e.nodeType) {
			var o = n(e);if ("none" == o.display) return i();var a = {};a.width = e.offsetWidth, a.height = e.offsetHeight;for (var c = a.isBorderBox = "border-box" == o.boxSizing, d = 0; d < h; d++) {
				var u = l[d],
				    f = o[u],
				    p = parseFloat(f);a[u] = isNaN(p) ? 0 : p;
			}var g = a.paddingLeft + a.paddingRight,
			    v = a.paddingTop + a.paddingBottom,
			    m = a.marginLeft + a.marginRight,
			    y = a.marginTop + a.marginBottom,
			    b = a.borderLeftWidth + a.borderRightWidth,
			    E = a.borderTopWidth + a.borderBottomWidth,
			    S = c && r,
			    C = t(o.width);C !== !1 && (a.width = C + (S ? 0 : g + b));var x = t(o.height);return x !== !1 && (a.height = x + (S ? 0 : v + E)), a.innerWidth = a.width - (g + b), a.innerHeight = a.height - (v + E), a.outerWidth = a.width + m, a.outerHeight = a.height + y, a;
		}
	}var r,
	    a = "undefined" == typeof console ? e : function (t) {
		console.error(t);
	},
	    l = ["paddingLeft", "paddingRight", "paddingTop", "paddingBottom", "marginLeft", "marginRight", "marginTop", "marginBottom", "borderLeftWidth", "borderRightWidth", "borderTopWidth", "borderBottomWidth"],
	    h = l.length,
	    c = !1;return o;
}), function (t, e) {
	"use strict";
	"function" == typeof define && define.amd ? define("desandro-matches-selector/matches-selector", e) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e() : t.matchesSelector = e();
}(window, function () {
	"use strict";
	var t = function () {
		var t = window.Element.prototype;if (t.matches) return "matches";if (t.matchesSelector) return "matchesSelector";for (var e = ["webkit", "moz", "ms", "o"], i = 0; i < e.length; i++) {
			var n = e[i],
			    s = n + "MatchesSelector";if (t[s]) return s;
		}
	}();return function (e, i) {
		return e[t](i);
	};
}), function (t, e) {
	"function" == typeof define && define.amd ? define("fizzy-ui-utils/utils", ["desandro-matches-selector/matches-selector"], function (i) {
		return e(t, i);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("desandro-matches-selector")) : t.fizzyUIUtils = e(t, t.matchesSelector);
}(window, function (t, e) {
	var i = {};i.extend = function (t, e) {
		for (var i in e) {
			t[i] = e[i];
		}return t;
	}, i.modulo = function (t, e) {
		return (t % e + e) % e;
	};var n = Array.prototype.slice;i.makeArray = function (t) {
		if (Array.isArray(t)) return t;if (null === t || void 0 === t) return [];var e = "object" == (typeof t === 'undefined' ? 'undefined' : _typeof(t)) && "number" == typeof t.length;return e ? n.call(t) : [t];
	}, i.removeFrom = function (t, e) {
		var i = t.indexOf(e);i != -1 && t.splice(i, 1);
	}, i.getParent = function (t, i) {
		for (; t.parentNode && t != document.body;) {
			if (t = t.parentNode, e(t, i)) return t;
		}
	}, i.getQueryElement = function (t) {
		return "string" == typeof t ? document.querySelector(t) : t;
	}, i.handleEvent = function (t) {
		var e = "on" + t.type;this[e] && this[e](t);
	}, i.filterFindElements = function (t, n) {
		t = i.makeArray(t);var s = [];return t.forEach(function (t) {
			if (t instanceof HTMLElement) {
				if (!n) return void s.push(t);e(t, n) && s.push(t);for (var i = t.querySelectorAll(n), o = 0; o < i.length; o++) {
					s.push(i[o]);
				}
			}
		}), s;
	}, i.debounceMethod = function (t, e, i) {
		i = i || 100;var n = t.prototype[e],
		    s = e + "Timeout";t.prototype[e] = function () {
			var t = this[s];clearTimeout(t);var e = arguments,
			    o = this;this[s] = setTimeout(function () {
				n.apply(o, e), delete o[s];
			}, i);
		};
	}, i.docReady = function (t) {
		var e = document.readyState;"complete" == e || "interactive" == e ? setTimeout(t) : document.addEventListener("DOMContentLoaded", t);
	}, i.toDashed = function (t) {
		return t.replace(/(.)([A-Z])/g, function (t, e, i) {
			return e + "-" + i;
		}).toLowerCase();
	};var s = t.console;return i.htmlInit = function (e, n) {
		i.docReady(function () {
			var o = i.toDashed(n),
			    r = "data-" + o,
			    a = document.querySelectorAll("[" + r + "]"),
			    l = document.querySelectorAll(".js-" + o),
			    h = i.makeArray(a).concat(i.makeArray(l)),
			    c = r + "-options",
			    d = t.jQuery;h.forEach(function (t) {
				var i,
				    o = t.getAttribute(r) || t.getAttribute(c);try {
					i = o && JSON.parse(o);
				} catch (a) {
					return void (s && s.error("Error parsing " + r + " on " + t.className + ": " + a));
				}var l = new e(t, i);d && d.data(t, n, l);
			});
		});
	}, i;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/cell", ["get-size/get-size"], function (i) {
		return e(t, i);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("get-size")) : (t.Flickity = t.Flickity || {}, t.Flickity.Cell = e(t, t.getSize));
}(window, function (t, e) {
	function i(t, e) {
		this.element = t, this.parent = e, this.create();
	}var n = i.prototype;return n.create = function () {
		this.element.style.position = "absolute", this.element.setAttribute("aria-selected", "false"), this.x = 0, this.shift = 0;
	}, n.destroy = function () {
		this.element.style.position = "";var t = this.parent.originSide;this.element.removeAttribute("aria-selected"), this.element.style[t] = "";
	}, n.getSize = function () {
		this.size = e(this.element);
	}, n.setPosition = function (t) {
		this.x = t, this.updateTarget(), this.renderPosition(t);
	}, n.updateTarget = n.setDefaultTarget = function () {
		var t = "left" == this.parent.originSide ? "marginLeft" : "marginRight";this.target = this.x + this.size[t] + this.size.width * this.parent.cellAlign;
	}, n.renderPosition = function (t) {
		var e = this.parent.originSide;this.element.style[e] = this.parent.getPositionValue(t);
	}, n.wrapShift = function (t) {
		this.shift = t, this.renderPosition(this.x + this.parent.slideableWidth * t);
	}, n.remove = function () {
		this.element.parentNode.removeChild(this.element);
	}, i;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/slide", e) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e() : (t.Flickity = t.Flickity || {}, t.Flickity.Slide = e());
}(window, function () {
	"use strict";
	function t(t) {
		this.parent = t, this.isOriginLeft = "left" == t.originSide, this.cells = [], this.outerWidth = 0, this.height = 0;
	}var e = t.prototype;return e.addCell = function (t) {
		if (this.cells.push(t), this.outerWidth += t.size.outerWidth, this.height = Math.max(t.size.outerHeight, this.height), 1 == this.cells.length) {
			this.x = t.x;var e = this.isOriginLeft ? "marginLeft" : "marginRight";this.firstMargin = t.size[e];
		}
	}, e.updateTarget = function () {
		var t = this.isOriginLeft ? "marginRight" : "marginLeft",
		    e = this.getLastCell(),
		    i = e ? e.size[t] : 0,
		    n = this.outerWidth - (this.firstMargin + i);this.target = this.x + this.firstMargin + n * this.parent.cellAlign;
	}, e.getLastCell = function () {
		return this.cells[this.cells.length - 1];
	}, e.select = function () {
		this.changeSelected(!0);
	}, e.unselect = function () {
		this.changeSelected(!1);
	}, e.changeSelected = function (t) {
		var e = t ? "add" : "remove";this.cells.forEach(function (i) {
			i.element.classList[e]("is-selected"), i.element.setAttribute("aria-selected", t.toString());
		});
	}, e.getCellElements = function () {
		return this.cells.map(function (t) {
			return t.element;
		});
	}, t;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/animate", ["fizzy-ui-utils/utils"], function (i) {
		return e(t, i);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("fizzy-ui-utils")) : (t.Flickity = t.Flickity || {}, t.Flickity.animatePrototype = e(t, t.fizzyUIUtils));
}(window, function (t, e) {
	var i = {};return i.startAnimation = function () {
		this.isAnimating || (this.isAnimating = !0, this.restingFrames = 0, this.animate());
	}, i.animate = function () {
		this.applyDragForce(), this.applySelectedAttraction();var t = this.x;if (this.integratePhysics(), this.positionSlider(), this.settle(t), this.isAnimating) {
			var e = this;requestAnimationFrame(function () {
				e.animate();
			});
		}
	}, i.positionSlider = function () {
		var t = this.x;this.options.wrapAround && this.cells.length > 1 && (t = e.modulo(t, this.slideableWidth), t -= this.slideableWidth, this.shiftWrapCells(t)), t += this.cursorPosition, t = this.options.rightToLeft ? -t : t;var i = this.getPositionValue(t);this.slider.style.transform = this.isAnimating ? "translate3d(" + i + ",0,0)" : "translateX(" + i + ")";var n = this.slides[0];if (n) {
			var s = -this.x - n.target,
			    o = s / this.slidesWidth;this.dispatchEvent("scroll", null, [o, s]);
		}
	}, i.positionSliderAtSelected = function () {
		this.cells.length && (this.x = -this.selectedSlide.target, this.velocity = 0, this.positionSlider());
	}, i.getPositionValue = function (t) {
		return this.options.percentPosition ? .01 * Math.round(t / this.size.innerWidth * 1e4) + "%" : Math.round(t) + "px";
	}, i.settle = function (t) {
		this.isPointerDown || Math.round(100 * this.x) != Math.round(100 * t) || this.restingFrames++, this.restingFrames > 2 && (this.isAnimating = !1, delete this.isFreeScrolling, this.positionSlider(), this.dispatchEvent("settle", null, [this.selectedIndex]));
	}, i.shiftWrapCells = function (t) {
		var e = this.cursorPosition + t;this._shiftCells(this.beforeShiftCells, e, -1);var i = this.size.innerWidth - (t + this.slideableWidth + this.cursorPosition);this._shiftCells(this.afterShiftCells, i, 1);
	}, i._shiftCells = function (t, e, i) {
		for (var n = 0; n < t.length; n++) {
			var s = t[n],
			    o = e > 0 ? i : 0;s.wrapShift(o), e -= s.size.outerWidth;
		}
	}, i._unshiftCells = function (t) {
		if (t && t.length) for (var e = 0; e < t.length; e++) {
			t[e].wrapShift(0);
		}
	}, i.integratePhysics = function () {
		this.x += this.velocity, this.velocity *= this.getFrictionFactor();
	}, i.applyForce = function (t) {
		this.velocity += t;
	}, i.getFrictionFactor = function () {
		return 1 - this.options[this.isFreeScrolling ? "freeScrollFriction" : "friction"];
	}, i.getRestingPosition = function () {
		return this.x + this.velocity / (1 - this.getFrictionFactor());
	}, i.applyDragForce = function () {
		if (this.isDraggable && this.isPointerDown) {
			var t = this.dragX - this.x,
			    e = t - this.velocity;this.applyForce(e);
		}
	}, i.applySelectedAttraction = function () {
		var t = this.isDraggable && this.isPointerDown;if (!t && !this.isFreeScrolling && this.slides.length) {
			var e = this.selectedSlide.target * -1 - this.x,
			    i = e * this.options.selectedAttraction;this.applyForce(i);
		}
	}, i;
}), function (t, e) {
	if ("function" == typeof define && define.amd) define("flickity/js/flickity", ["ev-emitter/ev-emitter", "get-size/get-size", "fizzy-ui-utils/utils", "./cell", "./slide", "./animate"], function (i, n, s, o, r, a) {
		return e(t, i, n, s, o, r, a);
	});else if ("object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports) module.exports = e(t, require("ev-emitter"), require("get-size"), require("fizzy-ui-utils"), require("./cell"), require("./slide"), require("./animate"));else {
		var i = t.Flickity;t.Flickity = e(t, t.EvEmitter, t.getSize, t.fizzyUIUtils, i.Cell, i.Slide, i.animatePrototype);
	}
}(window, function (t, e, i, n, s, o, r) {
	function a(t, e) {
		for (t = n.makeArray(t); t.length;) {
			e.appendChild(t.shift());
		}
	}function l(t, e) {
		var i = n.getQueryElement(t);if (!i) return void (d && d.error("Bad element for Flickity: " + (i || t)));if (this.element = i, this.element.flickityGUID) {
			var s = f[this.element.flickityGUID];return s.option(e), s;
		}h && (this.$element = h(this.element)), this.options = n.extend({}, this.constructor.defaults), this.option(e), this._create();
	}var h = t.jQuery,
	    c = t.getComputedStyle,
	    d = t.console,
	    u = 0,
	    f = {};l.defaults = { accessibility: !0, cellAlign: "center", freeScrollFriction: .075, friction: .28, namespaceJQueryEvents: !0, percentPosition: !0, resize: !0, selectedAttraction: .025, setGallerySize: !0 }, l.createMethods = [];var p = l.prototype;n.extend(p, e.prototype), p._create = function () {
		var e = this.guid = ++u;this.element.flickityGUID = e, f[e] = this, this.selectedIndex = 0, this.restingFrames = 0, this.x = 0, this.velocity = 0, this.originSide = this.options.rightToLeft ? "right" : "left", this.viewport = document.createElement("div"), this.viewport.className = "flickity-viewport", this._createSlider(), (this.options.resize || this.options.watchCSS) && t.addEventListener("resize", this);for (var i in this.options.on) {
			var n = this.options.on[i];this.on(i, n);
		}l.createMethods.forEach(function (t) {
			this[t]();
		}, this), this.options.watchCSS ? this.watchCSS() : this.activate();
	}, p.option = function (t) {
		n.extend(this.options, t);
	}, p.activate = function () {
		if (!this.isActive) {
			this.isActive = !0, this.element.classList.add("flickity-enabled"), this.options.rightToLeft && this.element.classList.add("flickity-rtl"), this.getSize();var t = this._filterFindCellElements(this.element.children);a(t, this.slider), this.viewport.appendChild(this.slider), this.element.appendChild(this.viewport), this.reloadCells(), this.options.accessibility && (this.element.tabIndex = 0, this.element.addEventListener("keydown", this)), this.emitEvent("activate");var e,
			    i = this.options.initialIndex;e = this.isInitActivated ? this.selectedIndex : void 0 !== i && this.cells[i] ? i : 0, this.select(e, !1, !0), this.isInitActivated = !0, this.dispatchEvent("ready");
		}
	}, p._createSlider = function () {
		var t = document.createElement("div");t.className = "flickity-slider", t.style[this.originSide] = 0, this.slider = t;
	}, p._filterFindCellElements = function (t) {
		return n.filterFindElements(t, this.options.cellSelector);
	}, p.reloadCells = function () {
		this.cells = this._makeCells(this.slider.children), this.positionCells(), this._getWrapShiftCells(), this.setGallerySize();
	}, p._makeCells = function (t) {
		var e = this._filterFindCellElements(t),
		    i = e.map(function (t) {
			return new s(t, this);
		}, this);return i;
	}, p.getLastCell = function () {
		return this.cells[this.cells.length - 1];
	}, p.getLastSlide = function () {
		return this.slides[this.slides.length - 1];
	}, p.positionCells = function () {
		this._sizeCells(this.cells), this._positionCells(0);
	}, p._positionCells = function (t) {
		t = t || 0, this.maxCellHeight = t ? this.maxCellHeight || 0 : 0;var e = 0;if (t > 0) {
			var i = this.cells[t - 1];e = i.x + i.size.outerWidth;
		}for (var n = this.cells.length, s = t; s < n; s++) {
			var o = this.cells[s];o.setPosition(e), e += o.size.outerWidth, this.maxCellHeight = Math.max(o.size.outerHeight, this.maxCellHeight);
		}this.slideableWidth = e, this.updateSlides(), this._containSlides(), this.slidesWidth = n ? this.getLastSlide().target - this.slides[0].target : 0;
	}, p._sizeCells = function (t) {
		t.forEach(function (t) {
			t.getSize();
		});
	}, p.updateSlides = function () {
		if (this.slides = [], this.cells.length) {
			var t = new o(this);this.slides.push(t);var e = "left" == this.originSide,
			    i = e ? "marginRight" : "marginLeft",
			    n = this._getCanCellFit();this.cells.forEach(function (e, s) {
				if (!t.cells.length) return void t.addCell(e);var r = t.outerWidth - t.firstMargin + (e.size.outerWidth - e.size[i]);n.call(this, s, r) ? t.addCell(e) : (t.updateTarget(), t = new o(this), this.slides.push(t), t.addCell(e));
			}, this), t.updateTarget(), this.updateSelectedSlide();
		}
	}, p._getCanCellFit = function () {
		var t = this.options.groupCells;if (!t) return function () {
			return !1;
		};if ("number" == typeof t) {
			var e = parseInt(t, 10);return function (t) {
				return t % e !== 0;
			};
		}var i = "string" == typeof t && t.match(/^(\d+)%$/),
		    n = i ? parseInt(i[1], 10) / 100 : 1;return function (t, e) {
			return e <= (this.size.innerWidth + 1) * n;
		};
	}, p._init = p.reposition = function () {
		this.positionCells(), this.positionSliderAtSelected();
	}, p.getSize = function () {
		this.size = i(this.element), this.setCellAlign(), this.cursorPosition = this.size.innerWidth * this.cellAlign;
	};var g = { center: { left: .5, right: .5 }, left: { left: 0, right: 1 }, right: { right: 0, left: 1 } };return p.setCellAlign = function () {
		var t = g[this.options.cellAlign];this.cellAlign = t ? t[this.originSide] : this.options.cellAlign;
	}, p.setGallerySize = function () {
		if (this.options.setGallerySize) {
			var t = this.options.adaptiveHeight && this.selectedSlide ? this.selectedSlide.height : this.maxCellHeight;this.viewport.style.height = t + "px";
		}
	}, p._getWrapShiftCells = function () {
		if (this.options.wrapAround) {
			this._unshiftCells(this.beforeShiftCells), this._unshiftCells(this.afterShiftCells);var t = this.cursorPosition,
			    e = this.cells.length - 1;this.beforeShiftCells = this._getGapCells(t, e, -1), t = this.size.innerWidth - this.cursorPosition, this.afterShiftCells = this._getGapCells(t, 0, 1);
		}
	}, p._getGapCells = function (t, e, i) {
		for (var n = []; t > 0;) {
			var s = this.cells[e];if (!s) break;n.push(s), e += i, t -= s.size.outerWidth;
		}return n;
	}, p._containSlides = function () {
		if (this.options.contain && !this.options.wrapAround && this.cells.length) {
			var t = this.options.rightToLeft,
			    e = t ? "marginRight" : "marginLeft",
			    i = t ? "marginLeft" : "marginRight",
			    n = this.slideableWidth - this.getLastCell().size[i],
			    s = n < this.size.innerWidth,
			    o = this.cursorPosition + this.cells[0].size[e],
			    r = n - this.size.innerWidth * (1 - this.cellAlign);this.slides.forEach(function (t) {
				s ? t.target = n * this.cellAlign : (t.target = Math.max(t.target, o), t.target = Math.min(t.target, r));
			}, this);
		}
	}, p.dispatchEvent = function (t, e, i) {
		var n = e ? [e].concat(i) : i;if (this.emitEvent(t, n), h && this.$element) {
			t += this.options.namespaceJQueryEvents ? ".flickity" : "";var s = t;if (e) {
				var o = h.Event(e);o.type = t, s = o;
			}this.$element.trigger(s, i);
		}
	}, p.select = function (t, e, i) {
		if (this.isActive && (t = parseInt(t, 10), this._wrapSelect(t), (this.options.wrapAround || e) && (t = n.modulo(t, this.slides.length)), this.slides[t])) {
			var s = this.selectedIndex;this.selectedIndex = t, this.updateSelectedSlide(), i ? this.positionSliderAtSelected() : this.startAnimation(), this.options.adaptiveHeight && this.setGallerySize(), this.dispatchEvent("select", null, [t]), t != s && this.dispatchEvent("change", null, [t]), this.dispatchEvent("cellSelect");
		}
	}, p._wrapSelect = function (t) {
		var e = this.slides.length,
		    i = this.options.wrapAround && e > 1;if (!i) return t;var s = n.modulo(t, e),
		    o = Math.abs(s - this.selectedIndex),
		    r = Math.abs(s + e - this.selectedIndex),
		    a = Math.abs(s - e - this.selectedIndex);!this.isDragSelect && r < o ? t += e : !this.isDragSelect && a < o && (t -= e), t < 0 ? this.x -= this.slideableWidth : t >= e && (this.x += this.slideableWidth);
	}, p.previous = function (t, e) {
		this.select(this.selectedIndex - 1, t, e);
	}, p.next = function (t, e) {
		this.select(this.selectedIndex + 1, t, e);
	}, p.updateSelectedSlide = function () {
		var t = this.slides[this.selectedIndex];t && (this.unselectSelectedSlide(), this.selectedSlide = t, t.select(), this.selectedCells = t.cells, this.selectedElements = t.getCellElements(), this.selectedCell = t.cells[0], this.selectedElement = this.selectedElements[0]);
	}, p.unselectSelectedSlide = function () {
		this.selectedSlide && this.selectedSlide.unselect();
	}, p.selectCell = function (t, e, i) {
		var n = this.queryCell(t);if (n) {
			var s = this.getCellSlideIndex(n);this.select(s, e, i);
		}
	}, p.getCellSlideIndex = function (t) {
		for (var e = 0; e < this.slides.length; e++) {
			var i = this.slides[e],
			    n = i.cells.indexOf(t);if (n != -1) return e;
		}
	}, p.getCell = function (t) {
		for (var e = 0; e < this.cells.length; e++) {
			var i = this.cells[e];if (i.element == t) return i;
		}
	}, p.getCells = function (t) {
		t = n.makeArray(t);var e = [];return t.forEach(function (t) {
			var i = this.getCell(t);i && e.push(i);
		}, this), e;
	}, p.getCellElements = function () {
		return this.cells.map(function (t) {
			return t.element;
		});
	}, p.getParentCell = function (t) {
		var e = this.getCell(t);return e ? e : (t = n.getParent(t, ".flickity-slider > *"), this.getCell(t));
	}, p.getAdjacentCellElements = function (t, e) {
		if (!t) return this.selectedSlide.getCellElements();e = void 0 === e ? this.selectedIndex : e;var i = this.slides.length;if (1 + 2 * t >= i) return this.getCellElements();for (var s = [], o = e - t; o <= e + t; o++) {
			var r = this.options.wrapAround ? n.modulo(o, i) : o,
			    a = this.slides[r];a && (s = s.concat(a.getCellElements()));
		}return s;
	}, p.queryCell = function (t) {
		return "number" == typeof t ? this.cells[t] : ("string" == typeof t && (t = this.element.querySelector(t)), this.getCell(t));
	}, p.uiChange = function () {
		this.emitEvent("uiChange");
	}, p.childUIPointerDown = function (t) {
		this.emitEvent("childUIPointerDown", [t]);
	}, p.onresize = function () {
		this.watchCSS(), this.resize();
	}, n.debounceMethod(l, "onresize", 150), p.resize = function () {
		if (this.isActive) {
			this.getSize(), this.options.wrapAround && (this.x = n.modulo(this.x, this.slideableWidth)), this.positionCells(), this._getWrapShiftCells(), this.setGallerySize(), this.emitEvent("resize");var t = this.selectedElements && this.selectedElements[0];this.selectCell(t, !1, !0);
		}
	}, p.watchCSS = function () {
		var t = this.options.watchCSS;if (t) {
			var e = c(this.element, ":after").content;e.indexOf("flickity") != -1 ? this.activate() : this.deactivate();
		}
	}, p.onkeydown = function (t) {
		var e = document.activeElement && document.activeElement != this.element;if (this.options.accessibility && !e) {
			var i = l.keyboardHandlers[t.keyCode];i && i.call(this);
		}
	}, l.keyboardHandlers = { 37: function _() {
			var t = this.options.rightToLeft ? "next" : "previous";this.uiChange(), this[t]();
		}, 39: function _() {
			var t = this.options.rightToLeft ? "previous" : "next";this.uiChange(), this[t]();
		} }, p.focus = function () {
		var e = t.pageYOffset;this.element.focus({ preventScroll: !0 }), t.pageYOffset != e && t.scrollTo(t.pageXOffset, e);
	}, p.deactivate = function () {
		this.isActive && (this.element.classList.remove("flickity-enabled"), this.element.classList.remove("flickity-rtl"), this.unselectSelectedSlide(), this.cells.forEach(function (t) {
			t.destroy();
		}), this.element.removeChild(this.viewport), a(this.slider.children, this.element), this.options.accessibility && (this.element.removeAttribute("tabIndex"), this.element.removeEventListener("keydown", this)), this.isActive = !1, this.emitEvent("deactivate"));
	}, p.destroy = function () {
		this.deactivate(), t.removeEventListener("resize", this), this.emitEvent("destroy"), h && this.$element && h.removeData(this.element, "flickity"), delete this.element.flickityGUID, delete f[this.guid];
	}, n.extend(p, r), l.data = function (t) {
		t = n.getQueryElement(t);var e = t && t.flickityGUID;return e && f[e];
	}, n.htmlInit(l, "flickity"), h && h.bridget && h.bridget("flickity", l), l.setJQuery = function (t) {
		h = t;
	}, l.Cell = s, l;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("unipointer/unipointer", ["ev-emitter/ev-emitter"], function (i) {
		return e(t, i);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("ev-emitter")) : t.Unipointer = e(t, t.EvEmitter);
}(window, function (t, e) {
	function i() {}function n() {}var s = n.prototype = Object.create(e.prototype);s.bindStartEvent = function (t) {
		this._bindStartEvent(t, !0);
	}, s.unbindStartEvent = function (t) {
		this._bindStartEvent(t, !1);
	}, s._bindStartEvent = function (e, i) {
		i = void 0 === i || i;var n = i ? "addEventListener" : "removeEventListener",
		    s = "mousedown";t.PointerEvent ? s = "pointerdown" : "ontouchstart" in t && (s = "touchstart"), e[n](s, this);
	}, s.handleEvent = function (t) {
		var e = "on" + t.type;this[e] && this[e](t);
	}, s.getTouch = function (t) {
		for (var e = 0; e < t.length; e++) {
			var i = t[e];if (i.identifier == this.pointerIdentifier) return i;
		}
	}, s.onmousedown = function (t) {
		var e = t.button;e && 0 !== e && 1 !== e || this._pointerDown(t, t);
	}, s.ontouchstart = function (t) {
		this._pointerDown(t, t.changedTouches[0]);
	}, s.onpointerdown = function (t) {
		this._pointerDown(t, t);
	}, s._pointerDown = function (t, e) {
		t.button || this.isPointerDown || (this.isPointerDown = !0, this.pointerIdentifier = void 0 !== e.pointerId ? e.pointerId : e.identifier, this.pointerDown(t, e));
	}, s.pointerDown = function (t, e) {
		this._bindPostStartEvents(t), this.emitEvent("pointerDown", [t, e]);
	};var o = { mousedown: ["mousemove", "mouseup"], touchstart: ["touchmove", "touchend", "touchcancel"], pointerdown: ["pointermove", "pointerup", "pointercancel"] };return s._bindPostStartEvents = function (e) {
		if (e) {
			var i = o[e.type];i.forEach(function (e) {
				t.addEventListener(e, this);
			}, this), this._boundPointerEvents = i;
		}
	}, s._unbindPostStartEvents = function () {
		this._boundPointerEvents && (this._boundPointerEvents.forEach(function (e) {
			t.removeEventListener(e, this);
		}, this), delete this._boundPointerEvents);
	}, s.onmousemove = function (t) {
		this._pointerMove(t, t);
	}, s.onpointermove = function (t) {
		t.pointerId == this.pointerIdentifier && this._pointerMove(t, t);
	}, s.ontouchmove = function (t) {
		var e = this.getTouch(t.changedTouches);e && this._pointerMove(t, e);
	}, s._pointerMove = function (t, e) {
		this.pointerMove(t, e);
	}, s.pointerMove = function (t, e) {
		this.emitEvent("pointerMove", [t, e]);
	}, s.onmouseup = function (t) {
		this._pointerUp(t, t);
	}, s.onpointerup = function (t) {
		t.pointerId == this.pointerIdentifier && this._pointerUp(t, t);
	}, s.ontouchend = function (t) {
		var e = this.getTouch(t.changedTouches);e && this._pointerUp(t, e);
	}, s._pointerUp = function (t, e) {
		this._pointerDone(), this.pointerUp(t, e);
	}, s.pointerUp = function (t, e) {
		this.emitEvent("pointerUp", [t, e]);
	}, s._pointerDone = function () {
		this._pointerReset(), this._unbindPostStartEvents(), this.pointerDone();
	}, s._pointerReset = function () {
		this.isPointerDown = !1, delete this.pointerIdentifier;
	}, s.pointerDone = i, s.onpointercancel = function (t) {
		t.pointerId == this.pointerIdentifier && this._pointerCancel(t, t);
	}, s.ontouchcancel = function (t) {
		var e = this.getTouch(t.changedTouches);e && this._pointerCancel(t, e);
	}, s._pointerCancel = function (t, e) {
		this._pointerDone(), this.pointerCancel(t, e);
	}, s.pointerCancel = function (t, e) {
		this.emitEvent("pointerCancel", [t, e]);
	}, n.getPointerPoint = function (t) {
		return { x: t.pageX, y: t.pageY };
	}, n;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("unidragger/unidragger", ["unipointer/unipointer"], function (i) {
		return e(t, i);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("unipointer")) : t.Unidragger = e(t, t.Unipointer);
}(window, function (t, e) {
	function i() {}var n = i.prototype = Object.create(e.prototype);n.bindHandles = function () {
		this._bindHandles(!0);
	}, n.unbindHandles = function () {
		this._bindHandles(!1);
	}, n._bindHandles = function (e) {
		e = void 0 === e || e;for (var i = e ? "addEventListener" : "removeEventListener", n = e ? this._touchActionValue : "", s = 0; s < this.handles.length; s++) {
			var o = this.handles[s];this._bindStartEvent(o, e), o[i]("click", this), t.PointerEvent && (o.style.touchAction = n);
		}
	}, n._touchActionValue = "none", n.pointerDown = function (t, e) {
		var i = this.okayPointerDown(t);i && (this.pointerDownPointer = e, t.preventDefault(), this.pointerDownBlur(), this._bindPostStartEvents(t), this.emitEvent("pointerDown", [t, e]));
	};var s = { TEXTAREA: !0, INPUT: !0, SELECT: !0, OPTION: !0 },
	    o = { radio: !0, checkbox: !0, button: !0, submit: !0, image: !0, file: !0 };return n.okayPointerDown = function (t) {
		var e = s[t.target.nodeName],
		    i = o[t.target.type],
		    n = !e || i;return n || this._pointerReset(), n;
	}, n.pointerDownBlur = function () {
		var t = document.activeElement,
		    e = t && t.blur && t != document.body;e && t.blur();
	}, n.pointerMove = function (t, e) {
		var i = this._dragPointerMove(t, e);this.emitEvent("pointerMove", [t, e, i]), this._dragMove(t, e, i);
	}, n._dragPointerMove = function (t, e) {
		var i = { x: e.pageX - this.pointerDownPointer.pageX, y: e.pageY - this.pointerDownPointer.pageY };return !this.isDragging && this.hasDragStarted(i) && this._dragStart(t, e), i;
	}, n.hasDragStarted = function (t) {
		return Math.abs(t.x) > 3 || Math.abs(t.y) > 3;
	}, n.pointerUp = function (t, e) {
		this.emitEvent("pointerUp", [t, e]), this._dragPointerUp(t, e);
	}, n._dragPointerUp = function (t, e) {
		this.isDragging ? this._dragEnd(t, e) : this._staticClick(t, e);
	}, n._dragStart = function (t, e) {
		this.isDragging = !0, this.isPreventingClicks = !0, this.dragStart(t, e);
	}, n.dragStart = function (t, e) {
		this.emitEvent("dragStart", [t, e]);
	}, n._dragMove = function (t, e, i) {
		this.isDragging && this.dragMove(t, e, i);
	}, n.dragMove = function (t, e, i) {
		t.preventDefault(), this.emitEvent("dragMove", [t, e, i]);
	}, n._dragEnd = function (t, e) {
		this.isDragging = !1, setTimeout(function () {
			delete this.isPreventingClicks;
		}.bind(this)), this.dragEnd(t, e);
	}, n.dragEnd = function (t, e) {
		this.emitEvent("dragEnd", [t, e]);
	}, n.onclick = function (t) {
		this.isPreventingClicks && t.preventDefault();
	}, n._staticClick = function (t, e) {
		this.isIgnoringMouseUp && "mouseup" == t.type || (this.staticClick(t, e), "mouseup" != t.type && (this.isIgnoringMouseUp = !0, setTimeout(function () {
			delete this.isIgnoringMouseUp;
		}.bind(this), 400)));
	}, n.staticClick = function (t, e) {
		this.emitEvent("staticClick", [t, e]);
	}, i.getPointerPoint = e.getPointerPoint, i;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/drag", ["./flickity", "unidragger/unidragger", "fizzy-ui-utils/utils"], function (i, n, s) {
		return e(t, i, n, s);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("./flickity"), require("unidragger"), require("fizzy-ui-utils")) : t.Flickity = e(t, t.Flickity, t.Unidragger, t.fizzyUIUtils);
}(window, function (t, e, i, n) {
	function s() {
		return { x: t.pageXOffset, y: t.pageYOffset };
	}n.extend(e.defaults, { draggable: ">1", dragThreshold: 3 }), e.createMethods.push("_createDrag");var o = e.prototype;n.extend(o, i.prototype), o._touchActionValue = "pan-y";var r = "createTouch" in document,
	    a = !1;o._createDrag = function () {
		this.on("activate", this.onActivateDrag), this.on("uiChange", this._uiChangeDrag), this.on("childUIPointerDown", this._childUIPointerDownDrag), this.on("deactivate", this.onDeactivateDrag), this.on("cellChange", this.updateDraggable), r && !a && (t.addEventListener("touchmove", function () {}), a = !0);
	}, o.onActivateDrag = function () {
		this.handles = [this.viewport], this.bindHandles(), this.updateDraggable();
	}, o.onDeactivateDrag = function () {
		this.unbindHandles(), this.element.classList.remove("is-draggable");
	}, o.updateDraggable = function () {
		">1" == this.options.draggable ? this.isDraggable = this.slides.length > 1 : this.isDraggable = this.options.draggable, this.isDraggable ? this.element.classList.add("is-draggable") : this.element.classList.remove("is-draggable");
	}, o.bindDrag = function () {
		this.options.draggable = !0, this.updateDraggable();
	}, o.unbindDrag = function () {
		this.options.draggable = !1, this.updateDraggable();
	}, o._uiChangeDrag = function () {
		delete this.isFreeScrolling;
	}, o._childUIPointerDownDrag = function (t) {
		t.preventDefault(), this.pointerDownFocus(t);
	}, o.pointerDown = function (e, i) {
		if (!this.isDraggable) return void this._pointerDownDefault(e, i);var n = this.okayPointerDown(e);n && (this._pointerDownPreventDefault(e), this.pointerDownFocus(e), document.activeElement != this.element && this.pointerDownBlur(), this.dragX = this.x, this.viewport.classList.add("is-pointer-down"), this.pointerDownScroll = s(), t.addEventListener("scroll", this), this._pointerDownDefault(e, i));
	}, o._pointerDownDefault = function (t, e) {
		this.pointerDownPointer = e, this._bindPostStartEvents(t), this.dispatchEvent("pointerDown", t, [e]);
	};var l = { INPUT: !0, TEXTAREA: !0, SELECT: !0 };return o.pointerDownFocus = function (t) {
		var e = l[t.target.nodeName];e || this.focus();
	}, o._pointerDownPreventDefault = function (t) {
		var e = "touchstart" == t.type,
		    i = "touch" == t.pointerType,
		    n = l[t.target.nodeName];e || i || n || t.preventDefault();
	}, o.hasDragStarted = function (t) {
		return Math.abs(t.x) > this.options.dragThreshold;
	}, o.pointerUp = function (t, e) {
		delete this.isTouchScrolling, this.viewport.classList.remove("is-pointer-down"), this.dispatchEvent("pointerUp", t, [e]), this._dragPointerUp(t, e);
	}, o.pointerDone = function () {
		t.removeEventListener("scroll", this), delete this.pointerDownScroll;
	}, o.dragStart = function (e, i) {
		this.isDraggable && (this.dragStartPosition = this.x, this.startAnimation(), t.removeEventListener("scroll", this), this.dispatchEvent("dragStart", e, [i]));
	}, o.pointerMove = function (t, e) {
		var i = this._dragPointerMove(t, e);this.dispatchEvent("pointerMove", t, [e, i]), this._dragMove(t, e, i);
	}, o.dragMove = function (t, e, i) {
		if (this.isDraggable) {
			t.preventDefault(), this.previousDragX = this.dragX;var n = this.options.rightToLeft ? -1 : 1;this.options.wrapAround && (i.x = i.x % this.slideableWidth);var s = this.dragStartPosition + i.x * n;if (!this.options.wrapAround && this.slides.length) {
				var o = Math.max(-this.slides[0].target, this.dragStartPosition);s = s > o ? .5 * (s + o) : s;var r = Math.min(-this.getLastSlide().target, this.dragStartPosition);s = s < r ? .5 * (s + r) : s;
			}this.dragX = s, this.dragMoveTime = new Date(), this.dispatchEvent("dragMove", t, [e, i]);
		}
	}, o.dragEnd = function (t, e) {
		if (this.isDraggable) {
			this.options.freeScroll && (this.isFreeScrolling = !0);var i = this.dragEndRestingSelect();if (this.options.freeScroll && !this.options.wrapAround) {
				var n = this.getRestingPosition();this.isFreeScrolling = -n > this.slides[0].target && -n < this.getLastSlide().target;
			} else this.options.freeScroll || i != this.selectedIndex || (i += this.dragEndBoostSelect());delete this.previousDragX, this.isDragSelect = this.options.wrapAround, this.select(i), delete this.isDragSelect, this.dispatchEvent("dragEnd", t, [e]);
		}
	}, o.dragEndRestingSelect = function () {
		var t = this.getRestingPosition(),
		    e = Math.abs(this.getSlideDistance(-t, this.selectedIndex)),
		    i = this._getClosestResting(t, e, 1),
		    n = this._getClosestResting(t, e, -1),
		    s = i.distance < n.distance ? i.index : n.index;return s;
	}, o._getClosestResting = function (t, e, i) {
		for (var n = this.selectedIndex, s = 1 / 0, o = this.options.contain && !this.options.wrapAround ? function (t, e) {
			return t <= e;
		} : function (t, e) {
			return t < e;
		}; o(e, s) && (n += i, s = e, e = this.getSlideDistance(-t, n), null !== e);) {
			e = Math.abs(e);
		}return { distance: s, index: n - i };
	}, o.getSlideDistance = function (t, e) {
		var i = this.slides.length,
		    s = this.options.wrapAround && i > 1,
		    o = s ? n.modulo(e, i) : e,
		    r = this.slides[o];if (!r) return null;var a = s ? this.slideableWidth * Math.floor(e / i) : 0;return t - (r.target + a);
	}, o.dragEndBoostSelect = function () {
		if (void 0 === this.previousDragX || !this.dragMoveTime || new Date() - this.dragMoveTime > 100) return 0;var t = this.getSlideDistance(-this.dragX, this.selectedIndex),
		    e = this.previousDragX - this.dragX;return t > 0 && e > 0 ? 1 : t < 0 && e < 0 ? -1 : 0;
	}, o.staticClick = function (t, e) {
		var i = this.getParentCell(t.target),
		    n = i && i.element,
		    s = i && this.cells.indexOf(i);this.dispatchEvent("staticClick", t, [e, n, s]);
	}, o.onscroll = function () {
		var t = s(),
		    e = this.pointerDownScroll.x - t.x,
		    i = this.pointerDownScroll.y - t.y;(Math.abs(e) > 3 || Math.abs(i) > 3) && this._pointerDone();
	}, e;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("tap-listener/tap-listener", ["unipointer/unipointer"], function (i) {
		return e(t, i);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("unipointer")) : t.TapListener = e(t, t.Unipointer);
}(window, function (t, e) {
	function i(t) {
		this.bindTap(t);
	}var n = i.prototype = Object.create(e.prototype);return n.bindTap = function (t) {
		t && (this.unbindTap(), this.tapElement = t, this._bindStartEvent(t, !0));
	}, n.unbindTap = function () {
		this.tapElement && (this._bindStartEvent(this.tapElement, !0), delete this.tapElement);
	}, n.pointerUp = function (i, n) {
		if (!this.isIgnoringMouseUp || "mouseup" != i.type) {
			var s = e.getPointerPoint(n),
			    o = this.tapElement.getBoundingClientRect(),
			    r = t.pageXOffset,
			    a = t.pageYOffset,
			    l = s.x >= o.left + r && s.x <= o.right + r && s.y >= o.top + a && s.y <= o.bottom + a;if (l && this.emitEvent("tap", [i, n]), "mouseup" != i.type) {
				this.isIgnoringMouseUp = !0;var h = this;setTimeout(function () {
					delete h.isIgnoringMouseUp;
				}, 400);
			}
		}
	}, n.destroy = function () {
		this.pointerDone(), this.unbindTap();
	}, i;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/prev-next-button", ["./flickity", "tap-listener/tap-listener", "fizzy-ui-utils/utils"], function (i, n, s) {
		return e(t, i, n, s);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("./flickity"), require("tap-listener"), require("fizzy-ui-utils")) : e(t, t.Flickity, t.TapListener, t.fizzyUIUtils);
}(window, function (t, e, i, n) {
	"use strict";
	function s(t, e) {
		this.direction = t, this.parent = e, this._create();
	}function o(t) {
		return "string" == typeof t ? t : "M " + t.x0 + ",50 L " + t.x1 + "," + (t.y1 + 50) + " L " + t.x2 + "," + (t.y2 + 50) + " L " + t.x3 + ",50  L " + t.x2 + "," + (50 - t.y2) + " L " + t.x1 + "," + (50 - t.y1) + " Z";
	}var r = "http://www.w3.org/2000/svg";s.prototype = Object.create(i.prototype), s.prototype._create = function () {
		this.isEnabled = !0, this.isPrevious = this.direction == -1;var t = this.parent.options.rightToLeft ? 1 : -1;this.isLeft = this.direction == t;var e = this.element = document.createElement("button");e.className = "flickity-button flickity-prev-next-button", e.className += this.isPrevious ? " previous" : " next", e.setAttribute("type", "button"), this.disable(), e.setAttribute("aria-label", this.isPrevious ? "Previous" : "Next");var i = this.createSVG();e.appendChild(i), this.on("tap", this.onTap), this.parent.on("select", this.update.bind(this)), this.on("pointerDown", this.parent.childUIPointerDown.bind(this.parent));
	}, s.prototype.activate = function () {
		this.bindTap(this.element), this.element.addEventListener("click", this), this.parent.element.appendChild(this.element);
	}, s.prototype.deactivate = function () {
		this.parent.element.removeChild(this.element), i.prototype.destroy.call(this), this.element.removeEventListener("click", this);
	}, s.prototype.createSVG = function () {
		var t = document.createElementNS(r, "svg");t.setAttribute("class", "flickity-button-icon"), t.setAttribute("viewBox", "0 0 100 100");var e = document.createElementNS(r, "path"),
		    i = o(this.parent.options.arrowShape);return e.setAttribute("d", i), e.setAttribute("class", "arrow"), this.isLeft || e.setAttribute("transform", "translate(100, 100) rotate(180) "), t.appendChild(e), t;
	}, s.prototype.onTap = function () {
		if (this.isEnabled) {
			this.parent.uiChange();var t = this.isPrevious ? "previous" : "next";this.parent[t]();
		}
	}, s.prototype.handleEvent = n.handleEvent, s.prototype.onclick = function (t) {
		var e = document.activeElement;e && e == this.element && this.onTap(t, t);
	}, s.prototype.enable = function () {
		this.isEnabled || (this.element.disabled = !1, this.isEnabled = !0);
	}, s.prototype.disable = function () {
		this.isEnabled && (this.element.disabled = !0, this.isEnabled = !1);
	}, s.prototype.update = function () {
		var t = this.parent.slides;if (this.parent.options.wrapAround && t.length > 1) return void this.enable();var e = t.length ? t.length - 1 : 0,
		    i = this.isPrevious ? 0 : e,
		    n = this.parent.selectedIndex == i ? "disable" : "enable";this[n]();
	}, s.prototype.destroy = function () {
		this.deactivate();
	}, n.extend(e.defaults, { prevNextButtons: !0, arrowShape: { x0: 10, x1: 60, y1: 50, x2: 70, y2: 40, x3: 30 } }), e.createMethods.push("_createPrevNextButtons");var a = e.prototype;return a._createPrevNextButtons = function () {
		this.options.prevNextButtons && (this.prevButton = new s(-1, this), this.nextButton = new s(1, this), this.on("activate", this.activatePrevNextButtons));
	}, a.activatePrevNextButtons = function () {
		this.prevButton.activate(), this.nextButton.activate(), this.on("deactivate", this.deactivatePrevNextButtons);
	}, a.deactivatePrevNextButtons = function () {
		this.prevButton.deactivate(), this.nextButton.deactivate(), this.off("deactivate", this.deactivatePrevNextButtons);
	}, e.PrevNextButton = s, e;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/page-dots", ["./flickity", "tap-listener/tap-listener", "fizzy-ui-utils/utils"], function (i, n, s) {
		return e(t, i, n, s);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("./flickity"), require("tap-listener"), require("fizzy-ui-utils")) : e(t, t.Flickity, t.TapListener, t.fizzyUIUtils);
}(window, function (t, e, i, n) {
	function s(t) {
		this.parent = t, this._create();
	}s.prototype = new i(), s.prototype._create = function () {
		this.holder = document.createElement("ol"), this.holder.className = "flickity-page-dots", this.dots = [], this.on("tap", this.onTap), this.on("pointerDown", this.parent.childUIPointerDown.bind(this.parent));
	}, s.prototype.activate = function () {
		this.setDots(), this.bindTap(this.holder), this.parent.element.appendChild(this.holder);
	}, s.prototype.deactivate = function () {
		this.parent.element.removeChild(this.holder), i.prototype.destroy.call(this);
	}, s.prototype.setDots = function () {
		var t = this.parent.slides.length - this.dots.length;t > 0 ? this.addDots(t) : t < 0 && this.removeDots(-t);
	}, s.prototype.addDots = function (t) {
		for (var e = document.createDocumentFragment(), i = [], n = this.dots.length, s = n + t, o = n; o < s; o++) {
			var r = document.createElement("li");r.className = "dot", r.setAttribute("aria-label", "Page dot " + (o + 1)), e.appendChild(r), i.push(r);
		}this.holder.appendChild(e), this.dots = this.dots.concat(i);
	}, s.prototype.removeDots = function (t) {
		var e = this.dots.splice(this.dots.length - t, t);e.forEach(function (t) {
			this.holder.removeChild(t);
		}, this);
	}, s.prototype.updateSelected = function () {
		this.selectedDot && (this.selectedDot.className = "dot", this.selectedDot.removeAttribute("aria-current")), this.dots.length && (this.selectedDot = this.dots[this.parent.selectedIndex], this.selectedDot.className = "dot is-selected", this.selectedDot.setAttribute("aria-current", "step"));
	}, s.prototype.onTap = function (t) {
		var e = t.target;if ("LI" == e.nodeName) {
			this.parent.uiChange();var i = this.dots.indexOf(e);this.parent.select(i);
		}
	}, s.prototype.destroy = function () {
		this.deactivate();
	}, e.PageDots = s, n.extend(e.defaults, { pageDots: !0 }), e.createMethods.push("_createPageDots");var o = e.prototype;return o._createPageDots = function () {
		this.options.pageDots && (this.pageDots = new s(this), this.on("activate", this.activatePageDots), this.on("select", this.updateSelectedPageDots), this.on("cellChange", this.updatePageDots), this.on("resize", this.updatePageDots), this.on("deactivate", this.deactivatePageDots));
	}, o.activatePageDots = function () {
		this.pageDots.activate();
	}, o.updateSelectedPageDots = function () {
		this.pageDots.updateSelected();
	}, o.updatePageDots = function () {
		this.pageDots.setDots();
	}, o.deactivatePageDots = function () {
		this.pageDots.deactivate();
	}, e.PageDots = s, e;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/player", ["ev-emitter/ev-emitter", "fizzy-ui-utils/utils", "./flickity"], function (t, i, n) {
		return e(t, i, n);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(require("ev-emitter"), require("fizzy-ui-utils"), require("./flickity")) : e(t.EvEmitter, t.fizzyUIUtils, t.Flickity);
}(window, function (t, e, i) {
	function n(t) {
		this.parent = t, this.state = "stopped", this.onVisibilityChange = this.visibilityChange.bind(this), this.onVisibilityPlay = this.visibilityPlay.bind(this);
	}n.prototype = Object.create(t.prototype), n.prototype.play = function () {
		if ("playing" != this.state) {
			var t = document.hidden;if (t) return void document.addEventListener("visibilitychange", this.onVisibilityPlay);this.state = "playing", document.addEventListener("visibilitychange", this.onVisibilityChange), this.tick();
		}
	}, n.prototype.tick = function () {
		if ("playing" == this.state) {
			var t = this.parent.options.autoPlay;t = "number" == typeof t ? t : 3e3;var e = this;this.clear(), this.timeout = setTimeout(function () {
				e.parent.next(!0), e.tick();
			}, t);
		}
	}, n.prototype.stop = function () {
		this.state = "stopped", this.clear(), document.removeEventListener("visibilitychange", this.onVisibilityChange);
	}, n.prototype.clear = function () {
		clearTimeout(this.timeout);
	}, n.prototype.pause = function () {
		"playing" == this.state && (this.state = "paused", this.clear());
	}, n.prototype.unpause = function () {
		"paused" == this.state && this.play();
	}, n.prototype.visibilityChange = function () {
		var t = document.hidden;this[t ? "pause" : "unpause"]();
	}, n.prototype.visibilityPlay = function () {
		this.play(), document.removeEventListener("visibilitychange", this.onVisibilityPlay);
	}, e.extend(i.defaults, { pauseAutoPlayOnHover: !0 }), i.createMethods.push("_createPlayer");var s = i.prototype;return s._createPlayer = function () {
		this.player = new n(this), this.on("activate", this.activatePlayer), this.on("uiChange", this.stopPlayer), this.on("pointerDown", this.stopPlayer), this.on("deactivate", this.deactivatePlayer);
	}, s.activatePlayer = function () {
		this.options.autoPlay && (this.player.play(), this.element.addEventListener("mouseenter", this));
	}, s.playPlayer = function () {
		this.player.play();
	}, s.stopPlayer = function () {
		this.player.stop();
	}, s.pausePlayer = function () {
		this.player.pause();
	}, s.unpausePlayer = function () {
		this.player.unpause();
	}, s.deactivatePlayer = function () {
		this.player.stop(), this.element.removeEventListener("mouseenter", this);
	}, s.onmouseenter = function () {
		this.options.pauseAutoPlayOnHover && (this.player.pause(), this.element.addEventListener("mouseleave", this));
	}, s.onmouseleave = function () {
		this.player.unpause(), this.element.removeEventListener("mouseleave", this);
	}, i.Player = n, i;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/add-remove-cell", ["./flickity", "fizzy-ui-utils/utils"], function (i, n) {
		return e(t, i, n);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("./flickity"), require("fizzy-ui-utils")) : e(t, t.Flickity, t.fizzyUIUtils);
}(window, function (t, e, i) {
	function n(t) {
		var e = document.createDocumentFragment();return t.forEach(function (t) {
			e.appendChild(t.element);
		}), e;
	}var s = e.prototype;return s.insert = function (t, e) {
		var i = this._makeCells(t);if (i && i.length) {
			var s = this.cells.length;e = void 0 === e ? s : e;var o = n(i),
			    r = e == s;if (r) this.slider.appendChild(o);else {
				var a = this.cells[e].element;this.slider.insertBefore(o, a);
			}if (0 === e) this.cells = i.concat(this.cells);else if (r) this.cells = this.cells.concat(i);else {
				var l = this.cells.splice(e, s - e);this.cells = this.cells.concat(i).concat(l);
			}this._sizeCells(i), this.cellChange(e, !0);
		}
	}, s.append = function (t) {
		this.insert(t, this.cells.length);
	}, s.prepend = function (t) {
		this.insert(t, 0);
	}, s.remove = function (t) {
		var e = this.getCells(t);if (e && e.length) {
			var n = this.cells.length - 1;e.forEach(function (t) {
				t.remove();var e = this.cells.indexOf(t);n = Math.min(e, n), i.removeFrom(this.cells, t);
			}, this), this.cellChange(n, !0);
		}
	}, s.cellSizeChange = function (t) {
		var e = this.getCell(t);if (e) {
			e.getSize();var i = this.cells.indexOf(e);this.cellChange(i);
		}
	}, s.cellChange = function (t, e) {
		var i = this.selectedElement;this._positionCells(t), this._getWrapShiftCells(), this.setGallerySize();var n = this.getCell(i);n && (this.selectedIndex = this.getCellSlideIndex(n)), this.selectedIndex = Math.min(this.slides.length - 1, this.selectedIndex), this.emitEvent("cellChange", [t]), this.select(this.selectedIndex), e && this.positionSliderAtSelected();
	}, e;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/lazyload", ["./flickity", "fizzy-ui-utils/utils"], function (i, n) {
		return e(t, i, n);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("./flickity"), require("fizzy-ui-utils")) : e(t, t.Flickity, t.fizzyUIUtils);
}(window, function (t, e, i) {
	"use strict";
	function n(t) {
		if ("IMG" == t.nodeName) {
			var e = t.getAttribute("data-flickity-lazyload"),
			    n = t.getAttribute("data-flickity-lazyload-src"),
			    s = t.getAttribute("data-flickity-lazyload-srcset");if (e || n || s) return [t];
		}var o = "img[data-flickity-lazyload], img[data-flickity-lazyload-src], img[data-flickity-lazyload-srcset]",
		    r = t.querySelectorAll(o);return i.makeArray(r);
	}function s(t, e) {
		this.img = t, this.flickity = e, this.load();
	}e.createMethods.push("_createLazyload");var o = e.prototype;return o._createLazyload = function () {
		this.on("select", this.lazyLoad);
	}, o.lazyLoad = function () {
		var t = this.options.lazyLoad;if (t) {
			var e = "number" == typeof t ? t : 0,
			    i = this.getAdjacentCellElements(e),
			    o = [];i.forEach(function (t) {
				var e = n(t);o = o.concat(e);
			}), o.forEach(function (t) {
				new s(t, this);
			}, this);
		}
	}, s.prototype.handleEvent = i.handleEvent, s.prototype.load = function () {
		this.img.addEventListener("load", this), this.img.addEventListener("error", this);var t = this.img.getAttribute("data-flickity-lazyload") || this.img.getAttribute("data-flickity-lazyload-src"),
		    e = this.img.getAttribute("data-flickity-lazyload-srcset");this.img.src = t, e && this.img.setAttribute("srcset", e), this.img.removeAttribute("data-flickity-lazyload"), this.img.removeAttribute("data-flickity-lazyload-src"), this.img.removeAttribute("data-flickity-lazyload-srcset");
	}, s.prototype.onload = function (t) {
		this.complete(t, "flickity-lazyloaded");
	}, s.prototype.onerror = function (t) {
		this.complete(t, "flickity-lazyerror");
	}, s.prototype.complete = function (t, e) {
		this.img.removeEventListener("load", this), this.img.removeEventListener("error", this);var i = this.flickity.getParentCell(this.img),
		    n = i && i.element;this.flickity.cellSizeChange(n), this.img.classList.add(e), this.flickity.dispatchEvent("lazyLoad", t, n);
	}, e.LazyLoader = s, e;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity/js/index", ["./flickity", "./drag", "./prev-next-button", "./page-dots", "./player", "./add-remove-cell", "./lazyload"], e) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports && (module.exports = e(require("./flickity"), require("./drag"), require("./prev-next-button"), require("./page-dots"), require("./player"), require("./add-remove-cell"), require("./lazyload")));
}(window, function (t) {
	return t;
}), function (t, e) {
	"function" == typeof define && define.amd ? define("flickity-as-nav-for/as-nav-for", ["flickity/js/index", "fizzy-ui-utils/utils"], e) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(require("flickity"), require("fizzy-ui-utils")) : t.Flickity = e(t.Flickity, t.fizzyUIUtils);
}(window, function (t, e) {
	function i(t, e, i) {
		return (e - t) * i + t;
	}t.createMethods.push("_createAsNavFor");var n = t.prototype;return n._createAsNavFor = function () {
		this.on("activate", this.activateAsNavFor), this.on("deactivate", this.deactivateAsNavFor), this.on("destroy", this.destroyAsNavFor);var t = this.options.asNavFor;if (t) {
			var e = this;setTimeout(function () {
				e.setNavCompanion(t);
			});
		}
	}, n.setNavCompanion = function (i) {
		i = e.getQueryElement(i);var n = t.data(i);if (n && n != this) {
			this.navCompanion = n;var s = this;this.onNavCompanionSelect = function () {
				s.navCompanionSelect();
			}, n.on("select", this.onNavCompanionSelect), this.on("staticClick", this.onNavStaticClick), this.navCompanionSelect(!0);
		}
	}, n.navCompanionSelect = function (t) {
		if (this.navCompanion) {
			var e = this.navCompanion.selectedCells[0],
			    n = this.navCompanion.cells.indexOf(e),
			    s = n + this.navCompanion.selectedCells.length - 1,
			    o = Math.floor(i(n, s, this.navCompanion.cellAlign));if (this.selectCell(o, !1, t), this.removeNavSelectedElements(), !(o >= this.cells.length)) {
				var r = this.cells.slice(n, s + 1);this.navSelectedElements = r.map(function (t) {
					return t.element;
				}), this.changeNavSelectedClass("add");
			}
		}
	}, n.changeNavSelectedClass = function (t) {
		this.navSelectedElements.forEach(function (e) {
			e.classList[t]("is-nav-selected");
		});
	}, n.activateAsNavFor = function () {
		this.navCompanionSelect(!0);
	}, n.removeNavSelectedElements = function () {
		this.navSelectedElements && (this.changeNavSelectedClass("remove"), delete this.navSelectedElements);
	}, n.onNavStaticClick = function (t, e, i, n) {
		"number" == typeof n && this.navCompanion.selectCell(n);
	}, n.deactivateAsNavFor = function () {
		this.removeNavSelectedElements();
	}, n.destroyAsNavFor = function () {
		this.navCompanion && (this.navCompanion.off("select", this.onNavCompanionSelect), this.off("staticClick", this.onNavStaticClick), delete this.navCompanion);
	}, t;
}), function (t, e) {
	"use strict";
	"function" == typeof define && define.amd ? define("imagesloaded/imagesloaded", ["ev-emitter/ev-emitter"], function (i) {
		return e(t, i);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("ev-emitter")) : t.imagesLoaded = e(t, t.EvEmitter);
}("undefined" != typeof window ? window : this, function (t, e) {
	function i(t, e) {
		for (var i in e) {
			t[i] = e[i];
		}return t;
	}function n(t) {
		if (Array.isArray(t)) return t;var e = "object" == (typeof t === 'undefined' ? 'undefined' : _typeof(t)) && "number" == typeof t.length;return e ? h.call(t) : [t];
	}function s(t, e, o) {
		if (!(this instanceof s)) return new s(t, e, o);var r = t;return "string" == typeof t && (r = document.querySelectorAll(t)), r ? (this.elements = n(r), this.options = i({}, this.options), "function" == typeof e ? o = e : i(this.options, e), o && this.on("always", o), this.getImages(), a && (this.jqDeferred = new a.Deferred()), void setTimeout(this.check.bind(this))) : void l.error("Bad element for imagesLoaded " + (r || t));
	}function o(t) {
		this.img = t;
	}function r(t, e) {
		this.url = t, this.element = e, this.img = new Image();
	}var a = t.jQuery,
	    l = t.console,
	    h = Array.prototype.slice;s.prototype = Object.create(e.prototype), s.prototype.options = {}, s.prototype.getImages = function () {
		this.images = [], this.elements.forEach(this.addElementImages, this);
	}, s.prototype.addElementImages = function (t) {
		"IMG" == t.nodeName && this.addImage(t), this.options.background === !0 && this.addElementBackgroundImages(t);var e = t.nodeType;if (e && c[e]) {
			for (var i = t.querySelectorAll("img"), n = 0; n < i.length; n++) {
				var s = i[n];this.addImage(s);
			}if ("string" == typeof this.options.background) {
				var o = t.querySelectorAll(this.options.background);for (n = 0; n < o.length; n++) {
					var r = o[n];this.addElementBackgroundImages(r);
				}
			}
		}
	};var c = { 1: !0, 9: !0, 11: !0 };return s.prototype.addElementBackgroundImages = function (t) {
		var e = getComputedStyle(t);if (e) for (var i = /url\((['"])?(.*?)\1\)/gi, n = i.exec(e.backgroundImage); null !== n;) {
			var s = n && n[2];s && this.addBackground(s, t), n = i.exec(e.backgroundImage);
		}
	}, s.prototype.addImage = function (t) {
		var e = new o(t);this.images.push(e);
	}, s.prototype.addBackground = function (t, e) {
		var i = new r(t, e);this.images.push(i);
	}, s.prototype.check = function () {
		function t(t, i, n) {
			setTimeout(function () {
				e.progress(t, i, n);
			});
		}var e = this;return this.progressedCount = 0, this.hasAnyBroken = !1, this.images.length ? void this.images.forEach(function (e) {
			e.once("progress", t), e.check();
		}) : void this.complete();
	}, s.prototype.progress = function (t, e, i) {
		this.progressedCount++, this.hasAnyBroken = this.hasAnyBroken || !t.isLoaded, this.emitEvent("progress", [this, t, e]), this.jqDeferred && this.jqDeferred.notify && this.jqDeferred.notify(this, t), this.progressedCount == this.images.length && this.complete(), this.options.debug && l && l.log("progress: " + i, t, e);
	}, s.prototype.complete = function () {
		var t = this.hasAnyBroken ? "fail" : "done";if (this.isComplete = !0, this.emitEvent(t, [this]), this.emitEvent("always", [this]), this.jqDeferred) {
			var e = this.hasAnyBroken ? "reject" : "resolve";this.jqDeferred[e](this);
		}
	}, o.prototype = Object.create(e.prototype), o.prototype.check = function () {
		var t = this.getIsImageComplete();return t ? void this.confirm(0 !== this.img.naturalWidth, "naturalWidth") : (this.proxyImage = new Image(), this.proxyImage.addEventListener("load", this), this.proxyImage.addEventListener("error", this), this.img.addEventListener("load", this), this.img.addEventListener("error", this), void (this.proxyImage.src = this.img.src));
	}, o.prototype.getIsImageComplete = function () {
		return this.img.complete && this.img.naturalWidth;
	}, o.prototype.confirm = function (t, e) {
		this.isLoaded = t, this.emitEvent("progress", [this, this.img, e]);
	}, o.prototype.handleEvent = function (t) {
		var e = "on" + t.type;this[e] && this[e](t);
	}, o.prototype.onload = function () {
		this.confirm(!0, "onload"), this.unbindEvents();
	}, o.prototype.onerror = function () {
		this.confirm(!1, "onerror"), this.unbindEvents();
	}, o.prototype.unbindEvents = function () {
		this.proxyImage.removeEventListener("load", this), this.proxyImage.removeEventListener("error", this), this.img.removeEventListener("load", this), this.img.removeEventListener("error", this);
	}, r.prototype = Object.create(o.prototype), r.prototype.check = function () {
		this.img.addEventListener("load", this), this.img.addEventListener("error", this), this.img.src = this.url;var t = this.getIsImageComplete();t && (this.confirm(0 !== this.img.naturalWidth, "naturalWidth"), this.unbindEvents());
	}, r.prototype.unbindEvents = function () {
		this.img.removeEventListener("load", this), this.img.removeEventListener("error", this);
	}, r.prototype.confirm = function (t, e) {
		this.isLoaded = t, this.emitEvent("progress", [this, this.element, e]);
	}, s.makeJQueryPlugin = function (e) {
		e = e || t.jQuery, e && (a = e, a.fn.imagesLoaded = function (t, e) {
			var i = new s(this, t, e);return i.jqDeferred.promise(a(this));
		});
	}, s.makeJQueryPlugin(), s;
}), function (t, e) {
	"function" == typeof define && define.amd ? define(["flickity/js/index", "imagesloaded/imagesloaded"], function (i, n) {
		return e(t, i, n);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = e(t, require("flickity"), require("imagesloaded")) : t.Flickity = e(t, t.Flickity, t.imagesLoaded);
}(window, function (t, e, i) {
	"use strict";
	e.createMethods.push("_createImagesLoaded");var n = e.prototype;return n._createImagesLoaded = function () {
		this.on("activate", this.imagesLoaded);
	}, n.imagesLoaded = function () {
		function t(t, i) {
			var n = e.getParentCell(i.img);e.cellSizeChange(n && n.element), e.options.freeScroll || e.positionSliderAtSelected();
		}if (this.options.imagesLoaded) {
			var e = this;i(this.slider).on("progress", t);
		}
	}, e;
});
/*! Copyright (c) 2013 Brandon Aaron (http://brandon.aaron.sh)
 * Licensed under the MIT License (LICENSE.txt).
 *
 * Version: 3.1.12
 *
 * Requires: jQuery 1.2.2+
 */
!function (a) {
	"function" == typeof define && define.amd ? define(["jquery"], a) : "object" == (typeof exports === 'undefined' ? 'undefined' : _typeof(exports)) ? module.exports = a : a(jQuery);
}(function (a) {
	function b(b) {
		var g = b || window.event,
		    h = i.call(arguments, 1),
		    j = 0,
		    l = 0,
		    m = 0,
		    n = 0,
		    o = 0,
		    p = 0;if (b = a.event.fix(g), b.type = "mousewheel", "detail" in g && (m = -1 * g.detail), "wheelDelta" in g && (m = g.wheelDelta), "wheelDeltaY" in g && (m = g.wheelDeltaY), "wheelDeltaX" in g && (l = -1 * g.wheelDeltaX), "axis" in g && g.axis === g.HORIZONTAL_AXIS && (l = -1 * m, m = 0), j = 0 === m ? l : m, "deltaY" in g && (m = -1 * g.deltaY, j = m), "deltaX" in g && (l = g.deltaX, 0 === m && (j = -1 * l)), 0 !== m || 0 !== l) {
			if (1 === g.deltaMode) {
				var q = a.data(this, "mousewheel-line-height");j *= q, m *= q, l *= q;
			} else if (2 === g.deltaMode) {
				var r = a.data(this, "mousewheel-page-height");j *= r, m *= r, l *= r;
			}if (n = Math.max(Math.abs(m), Math.abs(l)), (!f || f > n) && (f = n, d(g, n) && (f /= 40)), d(g, n) && (j /= 40, l /= 40, m /= 40), j = Math[j >= 1 ? "floor" : "ceil"](j / f), l = Math[l >= 1 ? "floor" : "ceil"](l / f), m = Math[m >= 1 ? "floor" : "ceil"](m / f), k.settings.normalizeOffset && this.getBoundingClientRect) {
				var s = this.getBoundingClientRect();o = b.clientX - s.left, p = b.clientY - s.top;
			}return b.deltaX = l, b.deltaY = m, b.deltaFactor = f, b.offsetX = o, b.offsetY = p, b.deltaMode = 0, h.unshift(b, j, l, m), e && clearTimeout(e), e = setTimeout(c, 200), (a.event.dispatch || a.event.handle).apply(this, h);
		}
	}function c() {
		f = null;
	}function d(a, b) {
		return k.settings.adjustOldDeltas && "mousewheel" === a.type && b % 120 === 0;
	}var e,
	    f,
	    g = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
	    h = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
	    i = Array.prototype.slice;if (a.event.fixHooks) for (var j = g.length; j;) {
		a.event.fixHooks[g[--j]] = a.event.mouseHooks;
	}var k = a.event.special.mousewheel = { version: "3.1.12", setup: function setup() {
			if (this.addEventListener) for (var c = h.length; c;) {
				this.addEventListener(h[--c], b, !1);
			} else this.onmousewheel = b;a.data(this, "mousewheel-line-height", k.getLineHeight(this)), a.data(this, "mousewheel-page-height", k.getPageHeight(this));
		}, teardown: function teardown() {
			if (this.removeEventListener) for (var c = h.length; c;) {
				this.removeEventListener(h[--c], b, !1);
			} else this.onmousewheel = null;a.removeData(this, "mousewheel-line-height"), a.removeData(this, "mousewheel-page-height");
		}, getLineHeight: function getLineHeight(b) {
			var c = a(b),
			    d = c["offsetParent" in a.fn ? "offsetParent" : "parent"]();return d.length || (d = a("body")), parseInt(d.css("fontSize"), 10) || parseInt(c.css("fontSize"), 10) || 16;
		}, getPageHeight: function getPageHeight(b) {
			return a(b).height();
		}, settings: { adjustOldDeltas: !0, normalizeOffset: !0 } };a.fn.extend({ mousewheel: function mousewheel(a) {
			return a ? this.bind("mousewheel", a) : this.trigger("mousewheel");
		}, unmousewheel: function unmousewheel(a) {
			return this.unbind("mousewheel", a);
		} });
});
/*! lazysizes - v4.0.1 */
!function (a, b) {
	var c = b(a, a.document);a.lazySizes = c, "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports && (module.exports = c);
}(window, function (a, b) {
	"use strict";
	if (b.getElementsByClassName) {
		var c,
		    d,
		    e = b.documentElement,
		    f = a.Date,
		    g = a.HTMLPictureElement,
		    h = "addEventListener",
		    i = "getAttribute",
		    j = a[h],
		    k = a.setTimeout,
		    l = a.requestAnimationFrame || k,
		    m = a.requestIdleCallback,
		    n = /^picture$/i,
		    o = ["load", "error", "lazyincluded", "_lazyloaded"],
		    p = {},
		    q = Array.prototype.forEach,
		    r = function r(a, b) {
			return p[b] || (p[b] = new RegExp("(\\s|^)" + b + "(\\s|$)")), p[b].test(a[i]("class") || "") && p[b];
		},
		    s = function s(a, b) {
			r(a, b) || a.setAttribute("class", (a[i]("class") || "").trim() + " " + b);
		},
		    t = function t(a, b) {
			var c;(c = r(a, b)) && a.setAttribute("class", (a[i]("class") || "").replace(c, " "));
		},
		    u = function u(a, b, c) {
			var d = c ? h : "removeEventListener";c && u(a, b), o.forEach(function (c) {
				a[d](c, b);
			});
		},
		    v = function v(a, d, e, f, g) {
			var h = b.createEvent("CustomEvent");return e || (e = {}), e.instance = c, h.initCustomEvent(d, !f, !g, e), a.dispatchEvent(h), h;
		},
		    w = function w(b, c) {
			var e;!g && (e = a.picturefill || d.pf) ? e({ reevaluate: !0, elements: [b] }) : c && c.src && (b.src = c.src);
		},
		    x = function x(a, b) {
			return (getComputedStyle(a, null) || {})[b];
		},
		    y = function y(a, b, c) {
			for (c = c || a.offsetWidth; c < d.minSize && b && !a._lazysizesWidth;) {
				c = b.offsetWidth, b = b.parentNode;
			}return c;
		},
		    z = function () {
			var a,
			    c,
			    d = [],
			    e = [],
			    f = d,
			    g = function g() {
				var b = f;for (f = d.length ? e : d, a = !0, c = !1; b.length;) {
					b.shift()();
				}a = !1;
			},
			    h = function h(d, e) {
				a && !e ? d.apply(this, arguments) : (f.push(d), c || (c = !0, (b.hidden ? k : l)(g)));
			};return h._lsFlush = g, h;
		}(),
		    A = function A(a, b) {
			return b ? function () {
				z(a);
			} : function () {
				var b = this,
				    c = arguments;z(function () {
					a.apply(b, c);
				});
			};
		},
		    B = function B(a) {
			var b,
			    c = 0,
			    e = 125,
			    g = d.ricTimeout,
			    h = function h() {
				b = !1, c = f.now(), a();
			},
			    i = m && d.ricTimeout ? function () {
				m(h, { timeout: g }), g !== d.ricTimeout && (g = d.ricTimeout);
			} : A(function () {
				k(h);
			}, !0);return function (a) {
				var d;(a = a === !0) && (g = 33), b || (b = !0, d = e - (f.now() - c), 0 > d && (d = 0), a || 9 > d && m ? i() : k(i, d));
			};
		},
		    C = function C(a) {
			var b,
			    c,
			    d = 99,
			    e = function e() {
				b = null, a();
			},
			    g = function g() {
				var a = f.now() - c;d > a ? k(g, d - a) : (m || e)(e);
			};return function () {
				c = f.now(), b || (b = k(g, d));
			};
		};!function () {
			var b,
			    c = { lazyClass: "lazyload", loadedClass: "lazyloaded", loadingClass: "lazyloading", preloadClass: "lazypreload", errorClass: "lazyerror", autosizesClass: "lazyautosizes", srcAttr: "data-src", srcsetAttr: "data-srcset", sizesAttr: "data-sizes", minSize: 40, customMedia: {}, init: !0, expFactor: 1.5, hFac: .8, loadMode: 2, loadHidden: !0, ricTimeout: 300 };d = a.lazySizesConfig || a.lazysizesConfig || {};for (b in c) {
				b in d || (d[b] = c[b]);
			}a.lazySizesConfig = d, k(function () {
				d.init && F();
			});
		}();var D = function () {
			var g,
			    l,
			    m,
			    o,
			    p,
			    y,
			    D,
			    F,
			    G,
			    H,
			    I,
			    J,
			    K,
			    L,
			    M = /^img$/i,
			    N = /^iframe$/i,
			    O = "onscroll" in a && !/glebot/.test(navigator.userAgent),
			    P = 0,
			    Q = 0,
			    R = 0,
			    S = -1,
			    T = function T(a) {
				R--, a && a.target && u(a.target, T), (!a || 0 > R || !a.target) && (R = 0);
			},
			    U = function U(a, c) {
				var d,
				    f = a,
				    g = "hidden" == x(b.body, "visibility") || "hidden" != x(a, "visibility");for (F -= c, I += c, G -= c, H += c; g && (f = f.offsetParent) && f != b.body && f != e;) {
					g = (x(f, "opacity") || 1) > 0, g && "visible" != x(f, "overflow") && (d = f.getBoundingClientRect(), g = H > d.left && G < d.right && I > d.top - 1 && F < d.bottom + 1);
				}return g;
			},
			    V = function V() {
				var a,
				    f,
				    h,
				    j,
				    k,
				    m,
				    n,
				    p,
				    q,
				    r = c.elements;if ((o = d.loadMode) && 8 > R && (a = r.length)) {
					f = 0, S++, null == K && ("expand" in d || (d.expand = e.clientHeight > 500 && e.clientWidth > 500 ? 500 : 370), J = d.expand, K = J * d.expFactor), K > Q && 1 > R && S > 2 && o > 2 && !b.hidden ? (Q = K, S = 0) : Q = o > 1 && S > 1 && 6 > R ? J : P;for (; a > f; f++) {
						if (r[f] && !r[f]._lazyRace) if (O) {
							if ((p = r[f][i]("data-expand")) && (m = 1 * p) || (m = Q), q !== m && (y = innerWidth + m * L, D = innerHeight + m, n = -1 * m, q = m), h = r[f].getBoundingClientRect(), (I = h.bottom) >= n && (F = h.top) <= D && (H = h.right) >= n * L && (G = h.left) <= y && (I || H || G || F) && (d.loadHidden || "hidden" != x(r[f], "visibility")) && (l && 3 > R && !p && (3 > o || 4 > S) || U(r[f], m))) {
								if (ba(r[f]), k = !0, R > 9) break;
							} else !k && l && !j && 4 > R && 4 > S && o > 2 && (g[0] || d.preloadAfterLoad) && (g[0] || !p && (I || H || G || F || "auto" != r[f][i](d.sizesAttr))) && (j = g[0] || r[f]);
						} else ba(r[f]);
					}j && !k && ba(j);
				}
			},
			    W = B(V),
			    X = function X(a) {
				s(a.target, d.loadedClass), t(a.target, d.loadingClass), u(a.target, Z), v(a.target, "lazyloaded");
			},
			    Y = A(X),
			    Z = function Z(a) {
				Y({ target: a.target });
			},
			    $ = function $(a, b) {
				try {
					a.contentWindow.location.replace(b);
				} catch (c) {
					a.src = b;
				}
			},
			    _ = function _(a) {
				var b,
				    c = a[i](d.srcsetAttr);(b = d.customMedia[a[i]("data-media") || a[i]("media")]) && a.setAttribute("media", b), c && a.setAttribute("srcset", c);
			},
			    aa = A(function (a, b, c, e, f) {
				var g, h, j, l, o, p;(o = v(a, "lazybeforeunveil", b)).defaultPrevented || (e && (c ? s(a, d.autosizesClass) : a.setAttribute("sizes", e)), h = a[i](d.srcsetAttr), g = a[i](d.srcAttr), f && (j = a.parentNode, l = j && n.test(j.nodeName || "")), p = b.firesLoad || "src" in a && (h || g || l), o = { target: a }, p && (u(a, T, !0), clearTimeout(m), m = k(T, 2500), s(a, d.loadingClass), u(a, Z, !0)), l && q.call(j.getElementsByTagName("source"), _), h ? a.setAttribute("srcset", h) : g && !l && (N.test(a.nodeName) ? $(a, g) : a.src = g), f && (h || l) && w(a, { src: g })), a._lazyRace && delete a._lazyRace, t(a, d.lazyClass), z(function () {
					(!p || a.complete && a.naturalWidth > 1) && (p ? T(o) : R--, X(o));
				}, !0);
			}),
			    ba = function ba(a) {
				var b,
				    c = M.test(a.nodeName),
				    e = c && (a[i](d.sizesAttr) || a[i]("sizes")),
				    f = "auto" == e;(!f && l || !c || !a[i]("src") && !a.srcset || a.complete || r(a, d.errorClass) || !r(a, d.lazyClass)) && (b = v(a, "lazyunveilread").detail, f && E.updateElem(a, !0, a.offsetWidth), a._lazyRace = !0, R++, aa(a, b, f, e, c));
			},
			    ca = function ca() {
				if (!l) {
					if (f.now() - p < 999) return void k(ca, 999);var a = C(function () {
						d.loadMode = 3, W();
					});l = !0, d.loadMode = 3, W(), j("scroll", function () {
						3 == d.loadMode && (d.loadMode = 2), a();
					}, !0);
				}
			};return { _: function _() {
					p = f.now(), c.elements = b.getElementsByClassName(d.lazyClass), g = b.getElementsByClassName(d.lazyClass + " " + d.preloadClass), L = d.hFac, j("scroll", W, !0), j("resize", W, !0), a.MutationObserver ? new MutationObserver(W).observe(e, { childList: !0, subtree: !0, attributes: !0 }) : (e[h]("DOMNodeInserted", W, !0), e[h]("DOMAttrModified", W, !0), setInterval(W, 999)), j("hashchange", W, !0), ["focus", "mouseover", "click", "load", "transitionend", "animationend", "webkitAnimationEnd"].forEach(function (a) {
						b[h](a, W, !0);
					}), /d$|^c/.test(b.readyState) ? ca() : (j("load", ca), b[h]("DOMContentLoaded", W), k(ca, 2e4)), c.elements.length ? (V(), z._lsFlush()) : W();
				}, checkElems: W, unveil: ba };
		}(),
		    E = function () {
			var a,
			    c = A(function (a, b, c, d) {
				var e, f, g;if (a._lazysizesWidth = d, d += "px", a.setAttribute("sizes", d), n.test(b.nodeName || "")) for (e = b.getElementsByTagName("source"), f = 0, g = e.length; g > f; f++) {
					e[f].setAttribute("sizes", d);
				}c.detail.dataAttr || w(a, c.detail);
			}),
			    e = function e(a, b, d) {
				var e,
				    f = a.parentNode;f && (d = y(a, f, d), e = v(a, "lazybeforesizes", { width: d, dataAttr: !!b }), e.defaultPrevented || (d = e.detail.width, d && d !== a._lazysizesWidth && c(a, f, e, d)));
			},
			    f = function f() {
				var b,
				    c = a.length;if (c) for (b = 0; c > b; b++) {
					e(a[b]);
				}
			},
			    g = C(f);return { _: function _() {
					a = b.getElementsByClassName(d.autosizesClass), j("resize", g);
				}, checkElems: g, updateElem: e };
		}(),
		    F = function F() {
			F.i || (F.i = !0, E._(), D._());
		};return c = { cfg: d, autoSizer: E, loader: D, init: F, uP: w, aC: s, rC: t, hC: r, fire: v, gW: y, rAF: z };
	}
});
/*!
 * Bootstrap-select v1.13.2 (https://developer.snapappointments.com/bootstrap-select)
 *
 * Copyright 2012-2018 SnapAppointments, LLC
 * Licensed under MIT (https://github.com/snapappointments/bootstrap-select/blob/master/LICENSE)
 */

!function (e, t) {
	void 0 === e && void 0 !== window && (e = window), "function" == typeof define && define.amd ? define(["jquery"], function (e) {
		return t(e);
	}) : "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && module.exports ? module.exports = t(require("jquery")) : t(e.jQuery);
}(this, function (e) {
	!function (F) {
		"use strict";
		var e,
		    a,
		    t,
		    i = document.createElement("_");if (i.classList.toggle("c3", !1), i.classList.contains("c3")) {
			var s = DOMTokenList.prototype.toggle;DOMTokenList.prototype.toggle = function (e, t) {
				return 1 in arguments && !this.contains(e) == !t ? t : s.call(this, e);
			};
		}function S(e) {
			var t,
			    i = [],
			    s = e && e.options;if (e.multiple) for (var n = 0, o = s.length; n < o; n++) {
				(t = s[n]).selected && i.push(t.value || t.text);
			} else i = e.value;return i;
		}String.prototype.startsWith || (e = function () {
			try {
				var e = {},
				    t = Object.defineProperty,
				    i = t(e, e, e) && t;
			} catch (e) {}return i;
		}(), a = {}.toString, t = function t(e) {
			if (null == this) throw new TypeError();var t = String(this);if (e && "[object RegExp]" == a.call(e)) throw new TypeError();var i = t.length,
			    s = String(e),
			    n = s.length,
			    o = 1 < arguments.length ? arguments[1] : void 0,
			    l = o ? Number(o) : 0;l != l && (l = 0);var r = Math.min(Math.max(l, 0), i);if (i < n + r) return !1;for (var c = -1; ++c < n;) {
				if (t.charCodeAt(r + c) != s.charCodeAt(c)) return !1;
			}return !0;
		}, e ? e(String.prototype, "startsWith", { value: t, configurable: !0, writable: !0 }) : String.prototype.startsWith = t), Object.keys || (Object.keys = function (e, t, i) {
			for (t in i = [], e) {
				i.hasOwnProperty.call(e, t) && i.push(t);
			}return i;
		});var n = { useDefault: !1, _set: F.valHooks.select.set };F.valHooks.select.set = function (e, t) {
			return t && !n.useDefault && F(e).data("selected", !0), n._set.apply(this, arguments);
		};var y = null,
		    o = function () {
			try {
				return new Event("change"), !0;
			} catch (e) {
				return !1;
			}
		}();function $(e, t, i, s) {
			for (var n = ["content", "subtext", "tokens"], o = !1, l = 0; l < n.length; l++) {
				var r = n[l],
				    c = e[r];if (c && (c = c.toString(), "content" === r && (c = c.replace(/<[^>]+>/g, "")), s && (c = d(c)), c = c.toUpperCase(), o = "contains" === i ? 0 <= c.indexOf(t) : c.startsWith(t))) break;
			}return o;
		}function O(e) {
			return parseInt(e, 10) || 0;
		}function d(e) {
			return F.each([{ re: /[\xC0-\xC6]/g, ch: "A" }, { re: /[\xE0-\xE6]/g, ch: "a" }, { re: /[\xC8-\xCB]/g, ch: "E" }, { re: /[\xE8-\xEB]/g, ch: "e" }, { re: /[\xCC-\xCF]/g, ch: "I" }, { re: /[\xEC-\xEF]/g, ch: "i" }, { re: /[\xD2-\xD6]/g, ch: "O" }, { re: /[\xF2-\xF6]/g, ch: "o" }, { re: /[\xD9-\xDC]/g, ch: "U" }, { re: /[\xF9-\xFC]/g, ch: "u" }, { re: /[\xC7-\xE7]/g, ch: "c" }, { re: /[\xD1]/g, ch: "N" }, { re: /[\xF1]/g, ch: "n" }], function () {
				e = e ? e.replace(this.re, this.ch) : "";
			}), e;
		}F.fn.triggerNative = function (e) {
			var t,
			    i = this[0];i.dispatchEvent ? (o ? t = new Event(e, { bubbles: !0 }) : (t = document.createEvent("Event")).initEvent(e, !0, !1), i.dispatchEvent(t)) : i.fireEvent ? ((t = document.createEventObject()).eventType = e, i.fireEvent("on" + e, t)) : this.trigger(e);
		};var l = function l(t) {
			var i = function i(e) {
				return t[e];
			},
			    e = "(?:" + Object.keys(t).join("|") + ")",
			    s = RegExp(e),
			    n = RegExp(e, "g");return function (e) {
				return e = null == e ? "" : "" + e, s.test(e) ? e.replace(n, i) : e;
			};
		},
		    G = l({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#x27;", "`": "&#x60;" }),
		    f = l({ "&amp;": "&", "&lt;": "<", "&gt;": ">", "&quot;": '"', "&#x27;": "'", "&#x60;": "`" }),
		    E = { 32: " ", 48: "0", 49: "1", 50: "2", 51: "3", 52: "4", 53: "5", 54: "6", 55: "7", 56: "8", 57: "9", 59: ";", 65: "A", 66: "B", 67: "C", 68: "D", 69: "E", 70: "F", 71: "G", 72: "H", 73: "I", 74: "J", 75: "K", 76: "L", 77: "M", 78: "N", 79: "O", 80: "P", 81: "Q", 82: "R", 83: "S", 84: "T", 85: "U", 86: "V", 87: "W", 88: "X", 89: "Y", 90: "Z", 96: "0", 97: "1", 98: "2", 99: "3", 100: "4", 101: "5", 102: "6", 103: "7", 104: "8", 105: "9" },
		    C = 27,
		    z = 13,
		    T = 32,
		    D = 9,
		    H = 38,
		    L = 40,
		    _ = { success: !1, major: "3" };try {
			_.full = (F.fn.dropdown.Constructor.VERSION || "").split(" ")[0].split("."), _.major = _.full[0], _.success = !0;
		} catch (e) {
			console.warn("There was an issue retrieving Bootstrap's version. Ensure Bootstrap is being loaded before bootstrap-select and there is no namespace collision. If loading Bootstrap asynchronously, the version may need to be manually specified via $.fn.selectpicker.Constructor.BootstrapVersion.", e);
		}var q = { DISABLED: "disabled", DIVIDER: "divider", SHOW: "open", DROPUP: "dropup", MENU: "dropdown-menu", MENURIGHT: "dropdown-menu-right", MENULEFT: "dropdown-menu-left", BUTTONCLASS: "btn-default", POPOVERHEADER: "popover-title" },
		    N = { MENU: "." + q.MENU };"4" === _.major && (q.DIVIDER = "dropdown-divider", q.SHOW = "show", q.BUTTONCLASS = "btn-light", q.POPOVERHEADER = "popover-header");var A = new RegExp(H + "|" + L),
		    P = new RegExp("^" + D + "$|" + C),
		    c = (new RegExp(z + "|" + T), function (e, t) {
			var i = this;n.useDefault || (F.valHooks.select.set = n._set, n.useDefault = !0), this.$element = F(e), this.$newElement = null, this.$button = null, this.$menu = null, this.options = t, this.selectpicker = { main: { map: { newIndex: {}, originalIndex: {} } }, current: { map: {} }, search: { map: {} }, view: {}, keydown: { keyHistory: "", resetKeyHistory: { start: function start() {
							return setTimeout(function () {
								i.selectpicker.keydown.keyHistory = "";
							}, 800);
						} } } }, null === this.options.title && (this.options.title = this.$element.attr("title"));var s = this.options.windowPadding;"number" == typeof s && (this.options.windowPadding = [s, s, s, s]), this.val = c.prototype.val, this.render = c.prototype.render, this.refresh = c.prototype.refresh, this.setStyle = c.prototype.setStyle, this.selectAll = c.prototype.selectAll, this.deselectAll = c.prototype.deselectAll, this.destroy = c.prototype.destroy, this.remove = c.prototype.remove, this.show = c.prototype.show, this.hide = c.prototype.hide, this.init();
		});function r(e) {
			var o,
			    l = arguments,
			    r = e;if ([].shift.apply(l), !_.success) {
				try {
					_.full = (F.fn.dropdown.Constructor.VERSION || "").split(" ")[0].split(".");
				} catch (e) {
					_.full = c.BootstrapVersion.split(" ")[0].split(".");
				}_.major = _.full[0], _.success = !0, "4" === _.major && (q.DIVIDER = "dropdown-divider", q.SHOW = "show", q.BUTTONCLASS = "btn-light", c.DEFAULTS.style = q.BUTTONCLASS = "btn-light", q.POPOVERHEADER = "popover-header");
			}var t = this.each(function () {
				var e = F(this);if (e.is("select")) {
					var t = e.data("selectpicker"),
					    i = "object" == (typeof r === 'undefined' ? 'undefined' : _typeof(r)) && r;if (t) {
						if (i) for (var s in i) {
							i.hasOwnProperty(s) && (t.options[s] = i[s]);
						}
					} else {
						var n = F.extend({}, c.DEFAULTS, F.fn.selectpicker.defaults || {}, e.data(), i);n.template = F.extend({}, c.DEFAULTS.template, F.fn.selectpicker.defaults ? F.fn.selectpicker.defaults.template : {}, e.data().template, i.template), e.data("selectpicker", t = new c(this, n));
					}"string" == typeof r && (o = t[r] instanceof Function ? t[r].apply(t, l) : t.options[r]);
				}
			});return void 0 !== o ? o : t;
		}c.VERSION = "1.13.2", c.BootstrapVersion = _.major, c.DEFAULTS = { noneSelectedText: "Nothing selected", noneResultsText: "No results matched {0}", countSelectedText: function countSelectedText(e, t) {
				return 1 == e ? "{0} item selected" : "{0} items selected";
			}, maxOptionsText: function maxOptionsText(e, t) {
				return [1 == e ? "Limit reached ({n} item max)" : "Limit reached ({n} items max)", 1 == t ? "Group limit reached ({n} item max)" : "Group limit reached ({n} items max)"];
			}, selectAllText: "Select All", deselectAllText: "Deselect All", doneButton: !1, doneButtonText: "Close", multipleSeparator: ", ", styleBase: "btn", style: q.BUTTONCLASS, size: "auto", title: null, selectedTextFormat: "values", width: !1, container: !1, hideDisabled: !1, showSubtext: !1, showIcon: !0, showContent: !0, dropupAuto: !0, header: !1, liveSearch: !1, liveSearchPlaceholder: null, liveSearchNormalize: !1, liveSearchStyle: "contains", actionsBox: !1, iconBase: "glyphicon", tickIcon: "glyphicon-ok", showTick: !1, template: { caret: '<span class="caret"></span>' }, maxOptions: !1, mobile: !1, selectOnTab: !1, dropdownAlignRight: !1, windowPadding: 0, virtualScroll: 600, display: !1 }, "4" === _.major && (c.DEFAULTS.style = "btn-light", c.DEFAULTS.iconBase = "", c.DEFAULTS.tickIcon = "bs-ok-default"), c.prototype = { constructor: c, init: function init() {
				var i = this,
				    e = this.$element.attr("id");this.$element.addClass("bs-select-hidden"), this.multiple = this.$element.prop("multiple"), this.autofocus = this.$element.prop("autofocus"), this.$newElement = this.createDropdown(), this.createLi(), this.$element.after(this.$newElement).prependTo(this.$newElement), this.$button = this.$newElement.children("button"), this.$menu = this.$newElement.children(N.MENU), this.$menuInner = this.$menu.children(".inner"), this.$searchbox = this.$menu.find("input"), this.$element.removeClass("bs-select-hidden"), !0 === this.options.dropdownAlignRight && this.$menu.addClass(q.MENURIGHT), void 0 !== e && this.$button.attr("data-id", e), this.checkDisabled(), this.clickListener(), this.options.liveSearch && this.liveSearchListener(), this.render(), this.setStyle(), this.setWidth(), this.options.container ? this.selectPosition() : this.$element.on("hide.bs.select", function () {
					if (i.isVirtual()) {
						var e = i.$menuInner[0],
						    t = e.firstChild.cloneNode(!1);e.replaceChild(t, e.firstChild), e.scrollTop = 0;
					}
				}), this.$menu.data("this", this), this.$newElement.data("this", this), this.options.mobile && this.mobile(), this.$newElement.on({ "hide.bs.dropdown": function hideBsDropdown(e) {
						i.$menuInner.attr("aria-expanded", !1), i.$element.trigger("hide.bs.select", e);
					}, "hidden.bs.dropdown": function hiddenBsDropdown(e) {
						i.$element.trigger("hidden.bs.select", e);
					}, "show.bs.dropdown": function showBsDropdown(e) {
						i.$menuInner.attr("aria-expanded", !0), i.$element.trigger("show.bs.select", e);
					}, "shown.bs.dropdown": function shownBsDropdown(e) {
						i.$element.trigger("shown.bs.select", e);
					} }), i.$element[0].hasAttribute("required") && this.$element.on("invalid", function () {
					i.$button.addClass("bs-invalid"), i.$element.on({ "shown.bs.select": function shownBsSelect() {
							i.$element.val(i.$element.val()).off("shown.bs.select");
						}, "rendered.bs.select": function renderedBsSelect() {
							this.validity.valid && i.$button.removeClass("bs-invalid"), i.$element.off("rendered.bs.select");
						} }), i.$button.on("blur.bs.select", function () {
						i.$element.focus().blur(), i.$button.off("blur.bs.select");
					});
				}), setTimeout(function () {
					i.$element.trigger("loaded.bs.select");
				});
			}, createDropdown: function createDropdown() {
				var e = this.multiple || this.options.showTick ? " show-tick" : "",
				    t = this.autofocus ? " autofocus" : "",
				    i = this.options.header ? '<div class="' + q.POPOVERHEADER + '"><button type="button" class="close" aria-hidden="true">&times;</button>' + this.options.header + "</div>" : "",
				    s = this.options.liveSearch ? '<div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off"' + (null === this.options.liveSearchPlaceholder ? "" : ' placeholder="' + G(this.options.liveSearchPlaceholder) + '"') + ' role="textbox" aria-label="Search"></div>' : "",
				    n = this.multiple && this.options.actionsBox ? '<div class="bs-actionsbox"><div class="btn-group btn-group-sm btn-block"><button type="button" class="actions-btn bs-select-all btn ' + q.BUTTONCLASS + '">' + this.options.selectAllText + '</button><button type="button" class="actions-btn bs-deselect-all btn ' + q.BUTTONCLASS + '">' + this.options.deselectAllText + "</button></div></div>" : "",
				    o = this.multiple && this.options.doneButton ? '<div class="bs-donebutton"><div class="btn-group btn-block"><button type="button" class="btn btn-sm ' + q.BUTTONCLASS + '">' + this.options.doneButtonText + "</button></div></div>" : "",
				    l = '<div class="dropdown bootstrap-select' + e + '"><button type="button" class="' + this.options.styleBase + ' dropdown-toggle" ' + ("static" === this.options.display ? 'data-display="static"' : "") + 'data-toggle="dropdown"' + t + ' role="button"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner"></div></div> </div>' + ("4" === _.major ? "" : '<span class="bs-caret">' + this.options.template.caret + "</span>") + '</button><div class="' + q.MENU + " " + ("4" === _.major ? "" : q.SHOW) + '" role="combobox">' + i + s + n + '<div class="inner ' + q.SHOW + '" role="listbox" aria-expanded="false" tabindex="-1"><ul class="' + q.MENU + " inner " + ("4" === _.major ? q.SHOW : "") + '"></ul></div>' + o + "</div></div>";return F(l);
			}, setPositionData: function setPositionData() {
				this.selectpicker.view.canHighlight = [];for (var e = 0; e < this.selectpicker.current.data.length; e++) {
					var t = this.selectpicker.current.data[e],
					    i = !0;"divider" === t.type ? (i = !1, t.height = this.sizeInfo.dividerHeight) : "optgroup-label" === t.type ? (i = !1, t.height = this.sizeInfo.dropdownHeaderHeight) : t.height = this.sizeInfo.liHeight, t.disabled && (i = !1), this.selectpicker.view.canHighlight.push(i), t.position = (0 === e ? 0 : this.selectpicker.current.data[e - 1].position) + t.height;
				}
			}, isVirtual: function isVirtual() {
				return !1 !== this.options.virtualScroll && this.selectpicker.main.elements.length >= this.options.virtualScroll || !0 === this.options.virtualScroll;
			}, createView: function createView(C, e) {
				e = e || 0;var O = this;this.selectpicker.current = C ? this.selectpicker.search : this.selectpicker.main;var z,
				    T,
				    D = [];function i(e, t) {
					var i,
					    s,
					    n,
					    o,
					    l,
					    r,
					    c,
					    a,
					    d,
					    h = O.selectpicker.current.elements.length,
					    p = [],
					    u = void 0,
					    f = !0,
					    m = O.isVirtual();O.selectpicker.view.scrollTop = e, !0 === m && O.sizeInfo.hasScrollBar && O.$menu[0].offsetWidth > O.sizeInfo.totalMenuWidth && (O.sizeInfo.menuWidth = O.$menu[0].offsetWidth, O.sizeInfo.totalMenuWidth = O.sizeInfo.menuWidth + O.sizeInfo.scrollBarWidth, O.$menu.css("min-width", O.sizeInfo.menuWidth)), i = Math.ceil(O.sizeInfo.menuInnerHeight / O.sizeInfo.liHeight * 1.5), s = Math.round(h / i) || 1;for (var v = 0; v < s; v++) {
						var g = (v + 1) * i;if (v === s - 1 && (g = h), p[v] = [v * i + (v ? 1 : 0), g], !h) break;void 0 === u && e <= O.selectpicker.current.data[g - 1].position - O.sizeInfo.menuInnerHeight && (u = v);
					}if (void 0 === u && (u = 0), l = [O.selectpicker.view.position0, O.selectpicker.view.position1], n = Math.max(0, u - 1), o = Math.min(s - 1, u + 1), O.selectpicker.view.position0 = Math.max(0, p[n][0]) || 0, O.selectpicker.view.position1 = Math.min(h, p[o][1]) || 0, r = l[0] !== O.selectpicker.view.position0 || l[1] !== O.selectpicker.view.position1, void 0 !== O.activeIndex && (T = O.selectpicker.current.elements[O.selectpicker.current.map.newIndex[O.prevActiveIndex]], D = O.selectpicker.current.elements[O.selectpicker.current.map.newIndex[O.activeIndex]], z = O.selectpicker.current.elements[O.selectpicker.current.map.newIndex[O.selectedIndex]], t && (O.activeIndex !== O.selectedIndex && (D.classList.remove("active"), D.firstChild && D.firstChild.classList.remove("active")), O.activeIndex = void 0), O.activeIndex && O.activeIndex !== O.selectedIndex && z && z.length && (z.classList.remove("active"), z.firstChild && z.firstChild.classList.remove("active"))), void 0 !== O.prevActiveIndex && O.prevActiveIndex !== O.activeIndex && O.prevActiveIndex !== O.selectedIndex && T && T.length && (T.classList.remove("active"), T.firstChild && T.firstChild.classList.remove("active")), (t || r) && (c = O.selectpicker.view.visibleElements ? O.selectpicker.view.visibleElements.slice() : [], O.selectpicker.view.visibleElements = O.selectpicker.current.elements.slice(O.selectpicker.view.position0, O.selectpicker.view.position1), O.setOptionStatus(), (C || !1 === m && t) && (a = c, d = O.selectpicker.view.visibleElements, f = !(a.length === d.length && a.every(function (e, t) {
						return e === d[t];
					}))), (t || !0 === m) && f)) {
						var b,
						    w,
						    x = O.$menuInner[0],
						    I = document.createDocumentFragment(),
						    k = x.firstChild.cloneNode(!1),
						    $ = !0 === m ? O.selectpicker.view.visibleElements : O.selectpicker.current.elements;x.replaceChild(k, x.firstChild);v = 0;for (var E = $.length; v < E; v++) {
							I.appendChild($[v]);
						}!0 === m && (b = 0 === O.selectpicker.view.position0 ? 0 : O.selectpicker.current.data[O.selectpicker.view.position0 - 1].position, w = O.selectpicker.view.position1 > h - 1 ? 0 : O.selectpicker.current.data[h - 1].position - O.selectpicker.current.data[O.selectpicker.view.position1 - 1].position, x.firstChild.style.marginTop = b + "px", x.firstChild.style.marginBottom = w + "px"), x.firstChild.appendChild(I);
					}if (O.prevActiveIndex = O.activeIndex, O.options.liveSearch) {
						if (C && t) {
							var S,
							    y = 0;O.selectpicker.view.canHighlight[y] || (y = 1 + O.selectpicker.view.canHighlight.slice(1).indexOf(!0)), S = O.selectpicker.view.visibleElements[y], O.selectpicker.view.currentActive && (O.selectpicker.view.currentActive.classList.remove("active"), O.selectpicker.view.currentActive.firstChild && O.selectpicker.view.currentActive.firstChild.classList.remove("active")), S && (S.classList.add("active"), S.firstChild && S.firstChild.classList.add("active")), O.activeIndex = O.selectpicker.current.map.originalIndex[y];
						}
					} else O.$menuInner.focus();
				}this.setPositionData(), i(e, !0), this.$menuInner.off("scroll.createView").on("scroll.createView", function (e, t) {
					O.noScroll || i(this.scrollTop, t), O.noScroll = !1;
				}), F(window).off("resize.createView").on("resize.createView", function () {
					i(O.$menuInner[0].scrollTop);
				});
			}, createLi: function createLi() {
				var z,
				    T = this,
				    D = [],
				    H = 0,
				    L = 0,
				    N = [],
				    A = 0,
				    P = 0,
				    R = -1;this.selectpicker.view.titleOption || (this.selectpicker.view.titleOption = document.createElement("option"));var W = { span: document.createElement("span"), subtext: document.createElement("small"), a: document.createElement("a"), li: document.createElement("li"), whitespace: document.createTextNode(" ") },
				    e = W.span.cloneNode(!1),
				    B = document.createDocumentFragment();e.className = T.options.iconBase + " " + T.options.tickIcon + " check-mark", W.a.appendChild(e), W.a.setAttribute("role", "option"), W.subtext.className = "text-muted", W.text = W.span.cloneNode(!1), W.text.className = "text";var M = function M(e, t, i, s) {
					var n = W.li.cloneNode(!1);return e && (1 === e.nodeType || 11 === e.nodeType ? n.appendChild(e) : n.innerHTML = e), void 0 !== i && "" !== i && (n.className = i), null != s && n.classList.add("optgroup-" + s), n;
				},
				    U = function U(e, t, i) {
					var s = W.a.cloneNode(!0);return e && (11 === e.nodeType ? s.appendChild(e) : s.insertAdjacentHTML("beforeend", e)), void 0 !== t & "" !== t && (s.className = t), "4" === _.major && s.classList.add("dropdown-item"), i && s.setAttribute("style", i), s;
				},
				    V = function V(e) {
					var t,
					    i,
					    s = W.text.cloneNode(!1);if (e.optionContent) s.innerHTML = e.optionContent;else {
						if (s.textContent = e.text, e.optionIcon) {
							var n = W.whitespace.cloneNode(!1);(i = W.span.cloneNode(!1)).className = T.options.iconBase + " " + e.optionIcon, B.appendChild(i), B.appendChild(n);
						}e.optionSubtext && ((t = W.subtext.cloneNode(!1)).innerHTML = e.optionSubtext, s.appendChild(t));
					}return B.appendChild(s), B;
				};if (this.options.title && !this.multiple) {
					R--;var t = this.$element[0],
					    i = !1,
					    s = !this.selectpicker.view.titleOption.parentNode;if (s) this.selectpicker.view.titleOption.className = "bs-title-option", this.selectpicker.view.titleOption.value = "", i = void 0 === F(t.options[t.selectedIndex]).attr("selected") && void 0 === this.$element.data("selected");(s || 0 !== this.selectpicker.view.titleOption.index) && t.insertBefore(this.selectpicker.view.titleOption, t.firstChild), i && (t.selectedIndex = 0);
				}var j = this.$element.find("option");j.each(function (e) {
					var t = F(this);if (R++, !t.hasClass("bs-title-option")) {
						var i,
						    s,
						    n = t.data(),
						    o = this.className || "",
						    l = G(this.style.cssText),
						    r = n.content,
						    c = this.textContent,
						    a = n.tokens,
						    d = n.subtext,
						    h = n.icon,
						    p = t.parent(),
						    u = p[0],
						    f = "OPTGROUP" === u.tagName,
						    m = f && u.disabled,
						    v = this.disabled || m,
						    g = this.previousElementSibling && "OPTGROUP" === this.previousElementSibling.tagName,
						    b = p.data();if (!0 === n.hidden || T.options.hideDisabled && (v && !f || m)) {
							i = n.prevHiddenIndex, t.next().data("prevHiddenIndex", void 0 !== i ? i : e), R--, g || void 0 !== i && (y = j[i].previousElementSibling) && "OPTGROUP" === y.tagName && !y.disabled && (g = !0), g && "divider" !== N[N.length - 1].type && (R++, D.push(M(!1, 0, q.DIVIDER, A + "div")), N.push({ type: "divider", optID: A }));
						} else {
							if (f && !0 !== n.divider) {
								if (T.options.hideDisabled && v) {
									if (void 0 === b.allOptionsDisabled) {
										var w = p.children();p.data("allOptionsDisabled", w.filter(":disabled").length === w.length);
									}if (p.data("allOptionsDisabled")) return void R--;
								}var x = " " + u.className || "";if (!this.previousElementSibling) {
									A += 1;var I = u.label,
									    k = G(I),
									    $ = b.subtext,
									    E = b.icon;0 !== e && 0 < D.length && (R++, D.push(M(!1, 0, q.DIVIDER, A + "div")), N.push({ type: "divider", optID: A })), R++;var S = function (e) {
										var t,
										    i,
										    s = W.text.cloneNode(!1);if (s.innerHTML = e.labelEscaped, e.labelIcon) {
											var n = W.whitespace.cloneNode(!1);(i = W.span.cloneNode(!1)).className = T.options.iconBase + " " + e.labelIcon, B.appendChild(i), B.appendChild(n);
										}return e.labelSubtext && ((t = W.subtext.cloneNode(!1)).textContent = e.labelSubtext, s.appendChild(t)), B.appendChild(s), B;
									}({ labelEscaped: k, labelSubtext: $, labelIcon: E });D.push(M(S, 0, "dropdown-header" + x, A)), N.push({ content: k, subtext: $, type: "optgroup-label", optID: A }), P = R - 1;
								}if (T.options.hideDisabled && v || !0 === n.hidden) return void R--;s = V({ text: c, optionContent: r, optionSubtext: d, optionIcon: h }), D.push(M(U(s, "opt " + o + x, l), 0, "", A)), N.push({ content: r || c, subtext: d, tokens: a, type: "option", optID: A, headerIndex: P, lastIndex: P + u.childElementCount, originalIndex: e, data: n }), H++;
							} else if (!0 === n.divider) D.push(M(!1, 0, q.DIVIDER)), N.push({ type: "divider", originalIndex: e, data: n });else {
								var y;if (!g && T.options.hideDisabled) if (void 0 !== (i = n.prevHiddenIndex)) (y = j[i].previousElementSibling) && "OPTGROUP" === y.tagName && !y.disabled && (g = !0);g && "divider" !== N[N.length - 1].type && (R++, D.push(M(!1, 0, q.DIVIDER, A + "div")), N.push({ type: "divider", optID: A })), s = V({ text: c, optionContent: r, optionSubtext: d, optionIcon: h }), D.push(M(U(s, o, l))), N.push({ content: r || c, subtext: d, tokens: a, type: "option", originalIndex: e, data: n }), H++;
							}T.selectpicker.main.map.newIndex[e] = R, T.selectpicker.main.map.originalIndex[R] = e;var C = N[N.length - 1];C.disabled = v;var O = 0;C.content && (O += C.content.length), C.subtext && (O += C.subtext.length), h && (O += 1), L < O && (L = O, z = D[D.length - 1]);
						}
					}
				}), this.selectpicker.main.elements = D, this.selectpicker.main.data = N, this.selectpicker.current = this.selectpicker.main, this.selectpicker.view.widestOption = z, this.selectpicker.view.availableOptionsCount = H;
			}, findLis: function findLis() {
				return this.$menuInner.find(".inner > li");
			}, render: function render() {
				var e = this,
				    t = this.$element.find("option"),
				    i = [],
				    s = [];this.togglePlaceholder(), this.tabIndex();for (var n = 0, o = this.selectpicker.main.elements.length; n < o; n++) {
					var l = t[this.selectpicker.main.map.originalIndex[n]];if (l && l.selected && (i.push(l), s.length < 100 && "count" !== e.options.selectedTextFormat || 1 === i.length)) {
						if (e.options.hideDisabled && (l.disabled || "OPTGROUP" === l.parentNode.tagName && l.parentNode.disabled)) return;var r,
						    c,
						    a = this.selectpicker.main.data[n].data,
						    d = a.icon && e.options.showIcon ? '<i class="' + e.options.iconBase + " " + a.icon + '"></i> ' : "";r = e.options.showSubtext && a.subtext && !e.multiple ? ' <small class="text-muted">' + a.subtext + "</small>" : "", c = l.title ? l.title : a.content && e.options.showContent ? a.content.toString() : d + l.innerHTML.trim() + r, s.push(c);
					}
				}var h = this.multiple ? s.join(this.options.multipleSeparator) : s[0];if (50 < i.length && (h += "..."), this.multiple && -1 !== this.options.selectedTextFormat.indexOf("count")) {
					var p = this.options.selectedTextFormat.split(">");if (1 < p.length && i.length > p[1] || 1 === p.length && 2 <= i.length) {
						var u = this.selectpicker.view.availableOptionsCount;h = ("function" == typeof this.options.countSelectedText ? this.options.countSelectedText(i.length, u) : this.options.countSelectedText).replace("{0}", i.length.toString()).replace("{1}", u.toString());
					}
				}null == this.options.title && (this.options.title = this.$element.attr("title")), "static" == this.options.selectedTextFormat && (h = this.options.title), h || (h = void 0 !== this.options.title ? this.options.title : this.options.noneSelectedText), this.$button[0].title = f(h.replace(/<[^>]*>?/g, "").trim()), this.$button.find(".filter-option-inner-inner")[0].innerHTML = h, this.$element.trigger("rendered.bs.select");
			}, setStyle: function setStyle(e, t) {
				this.$element.attr("class") && this.$newElement.addClass(this.$element.attr("class").replace(/selectpicker|mobile-device|bs-select-hidden|validate\[.*\]/gi, ""));var i = e || this.options.style;"add" == t ? this.$button.addClass(i) : "remove" == t ? this.$button.removeClass(i) : (this.$button.removeClass(this.options.style), this.$button.addClass(i));
			}, liHeight: function liHeight(e) {
				if (e || !1 !== this.options.size && !this.sizeInfo) {
					this.sizeInfo || (this.sizeInfo = {});var t = document.createElement("div"),
					    i = document.createElement("div"),
					    s = document.createElement("div"),
					    n = document.createElement("ul"),
					    o = document.createElement("li"),
					    l = document.createElement("li"),
					    r = document.createElement("li"),
					    c = document.createElement("a"),
					    a = document.createElement("span"),
					    d = this.options.header && 0 < this.$menu.find("." + q.POPOVERHEADER).length ? this.$menu.find("." + q.POPOVERHEADER)[0].cloneNode(!0) : null,
					    h = this.options.liveSearch ? document.createElement("div") : null,
					    p = this.options.actionsBox && this.multiple && 0 < this.$menu.find(".bs-actionsbox").length ? this.$menu.find(".bs-actionsbox")[0].cloneNode(!0) : null,
					    u = this.options.doneButton && this.multiple && 0 < this.$menu.find(".bs-donebutton").length ? this.$menu.find(".bs-donebutton")[0].cloneNode(!0) : null;if (this.sizeInfo.selectWidth = this.$newElement[0].offsetWidth, a.className = "text", c.className = "dropdown-item " + this.$element.find("option")[0].className, t.className = this.$menu[0].parentNode.className + " " + q.SHOW, t.style.width = this.sizeInfo.selectWidth + "px", "auto" === this.options.width && (i.style.minWidth = 0), i.className = q.MENU + " " + q.SHOW, s.className = "inner " + q.SHOW, n.className = q.MENU + " inner " + ("4" === _.major ? q.SHOW : ""), o.className = q.DIVIDER, l.className = "dropdown-header", a.appendChild(document.createTextNode("Inner text")), c.appendChild(a), r.appendChild(c), l.appendChild(a.cloneNode(!0)), this.selectpicker.view.widestOption && n.appendChild(this.selectpicker.view.widestOption.cloneNode(!0)), n.appendChild(r), n.appendChild(o), n.appendChild(l), d && i.appendChild(d), h) {
						var f = document.createElement("input");h.className = "bs-searchbox", f.className = "form-control", h.appendChild(f), i.appendChild(h);
					}p && i.appendChild(p), s.appendChild(n), i.appendChild(s), u && i.appendChild(u), t.appendChild(i), document.body.appendChild(t);var m,
					    v = c.offsetHeight,
					    g = l ? l.offsetHeight : 0,
					    b = d ? d.offsetHeight : 0,
					    w = h ? h.offsetHeight : 0,
					    x = p ? p.offsetHeight : 0,
					    I = u ? u.offsetHeight : 0,
					    k = F(o).outerHeight(!0),
					    $ = !!window.getComputedStyle && window.getComputedStyle(i),
					    E = i.offsetWidth,
					    S = $ ? null : F(i),
					    y = { vert: O($ ? $.paddingTop : S.css("paddingTop")) + O($ ? $.paddingBottom : S.css("paddingBottom")) + O($ ? $.borderTopWidth : S.css("borderTopWidth")) + O($ ? $.borderBottomWidth : S.css("borderBottomWidth")), horiz: O($ ? $.paddingLeft : S.css("paddingLeft")) + O($ ? $.paddingRight : S.css("paddingRight")) + O($ ? $.borderLeftWidth : S.css("borderLeftWidth")) + O($ ? $.borderRightWidth : S.css("borderRightWidth")) },
					    C = { vert: y.vert + O($ ? $.marginTop : S.css("marginTop")) + O($ ? $.marginBottom : S.css("marginBottom")) + 2, horiz: y.horiz + O($ ? $.marginLeft : S.css("marginLeft")) + O($ ? $.marginRight : S.css("marginRight")) + 2 };s.style.overflowY = "scroll", m = i.offsetWidth - E, document.body.removeChild(t), this.sizeInfo.liHeight = v, this.sizeInfo.dropdownHeaderHeight = g, this.sizeInfo.headerHeight = b, this.sizeInfo.searchHeight = w, this.sizeInfo.actionsHeight = x, this.sizeInfo.doneButtonHeight = I, this.sizeInfo.dividerHeight = k, this.sizeInfo.menuPadding = y, this.sizeInfo.menuExtras = C, this.sizeInfo.menuWidth = E, this.sizeInfo.totalMenuWidth = this.sizeInfo.menuWidth, this.sizeInfo.scrollBarWidth = m, this.sizeInfo.selectHeight = this.$newElement[0].offsetHeight, this.setPositionData();
				}
			}, getSelectPosition: function getSelectPosition() {
				var e,
				    t = F(window),
				    i = this.$newElement.offset(),
				    s = F(this.options.container);this.options.container && !s.is("body") ? ((e = s.offset()).top += parseInt(s.css("borderTopWidth")), e.left += parseInt(s.css("borderLeftWidth"))) : e = { top: 0, left: 0 };var n = this.options.windowPadding;this.sizeInfo.selectOffsetTop = i.top - e.top - t.scrollTop(), this.sizeInfo.selectOffsetBot = t.height() - this.sizeInfo.selectOffsetTop - this.sizeInfo.selectHeight - e.top - n[2], this.sizeInfo.selectOffsetLeft = i.left - e.left - t.scrollLeft(), this.sizeInfo.selectOffsetRight = t.width() - this.sizeInfo.selectOffsetLeft - this.sizeInfo.selectWidth - e.left - n[1], this.sizeInfo.selectOffsetTop -= n[0], this.sizeInfo.selectOffsetLeft -= n[3];
			}, setMenuSize: function setMenuSize(e) {
				this.getSelectPosition();var t,
				    i,
				    s,
				    n,
				    o,
				    l,
				    r,
				    c = this.sizeInfo.selectWidth,
				    a = this.sizeInfo.liHeight,
				    d = this.sizeInfo.headerHeight,
				    h = this.sizeInfo.searchHeight,
				    p = this.sizeInfo.actionsHeight,
				    u = this.sizeInfo.doneButtonHeight,
				    f = this.sizeInfo.dividerHeight,
				    m = this.sizeInfo.menuPadding,
				    v = 0;if (this.options.dropupAuto && (r = a * this.selectpicker.current.elements.length + m.vert, this.$newElement.toggleClass(q.DROPUP, this.sizeInfo.selectOffsetTop - this.sizeInfo.selectOffsetBot > this.sizeInfo.menuExtras.vert && r + this.sizeInfo.menuExtras.vert + 50 > this.sizeInfo.selectOffsetBot)), "auto" === this.options.size) n = 3 < this.selectpicker.current.elements.length ? 3 * this.sizeInfo.liHeight + this.sizeInfo.menuExtras.vert - 2 : 0, i = this.sizeInfo.selectOffsetBot - this.sizeInfo.menuExtras.vert, s = n + d + h + p + u, l = Math.max(n - m.vert, 0), this.$newElement.hasClass(q.DROPUP) && (i = this.sizeInfo.selectOffsetTop - this.sizeInfo.menuExtras.vert), t = (o = i) - d - h - p - u - m.vert;else if (this.options.size && "auto" != this.options.size && this.selectpicker.current.elements.length > this.options.size) {
					for (var g = 0; g < this.options.size; g++) {
						"divider" === this.selectpicker.current.data[g].type && v++;
					}t = (i = a * this.options.size + v * f + m.vert) - m.vert, o = i + d + h + p + u, s = l = "";
				}"auto" === this.options.dropdownAlignRight && this.$menu.toggleClass(q.MENURIGHT, this.sizeInfo.selectOffsetLeft > this.sizeInfo.selectOffsetRight && this.sizeInfo.selectOffsetRight < this.$menu[0].offsetWidth - c), this.$menu.css({ "max-height": o + "px", overflow: "hidden", "min-height": s + "px" }), this.$menuInner.css({ "max-height": t + "px", "overflow-y": "auto", "min-height": l + "px" }), this.sizeInfo.menuInnerHeight = t, this.selectpicker.current.data.length && this.selectpicker.current.data[this.selectpicker.current.data.length - 1].position > this.sizeInfo.menuInnerHeight && (this.sizeInfo.hasScrollBar = !0, this.sizeInfo.totalMenuWidth = this.sizeInfo.menuWidth + this.sizeInfo.scrollBarWidth, this.$menu.css("min-width", this.sizeInfo.totalMenuWidth)), this.dropdown && this.dropdown._popper && this.dropdown._popper.update();
			}, setSize: function setSize(e) {
				if (this.liHeight(e), this.options.header && this.$menu.css("padding-top", 0), !1 !== this.options.size) {
					var t,
					    i = this,
					    s = F(window),
					    n = 0;this.setMenuSize(), "auto" === this.options.size ? (this.$searchbox.off("input.setMenuSize propertychange.setMenuSize").on("input.setMenuSize propertychange.setMenuSize", function () {
						return i.setMenuSize();
					}), s.off("resize.setMenuSize scroll.setMenuSize").on("resize.setMenuSize scroll.setMenuSize", function () {
						return i.setMenuSize();
					})) : this.options.size && "auto" != this.options.size && this.selectpicker.current.elements.length > this.options.size && (this.$searchbox.off("input.setMenuSize propertychange.setMenuSize"), s.off("resize.setMenuSize scroll.setMenuSize")), e ? n = this.$menuInner[0].scrollTop : i.multiple || "number" == typeof (t = i.selectpicker.main.map.newIndex[i.$element[0].selectedIndex]) && !1 !== i.options.size && (n = (n = i.sizeInfo.liHeight * t) - i.sizeInfo.menuInnerHeight / 2 + i.sizeInfo.liHeight / 2), i.createView(!1, n);
				}
			}, setWidth: function setWidth() {
				var i = this;"auto" === this.options.width ? requestAnimationFrame(function () {
					i.$menu.css("min-width", "0"), i.liHeight(), i.setMenuSize();var e = i.$newElement.clone().appendTo("body"),
					    t = e.css("width", "auto").children("button").outerWidth();e.remove(), i.sizeInfo.selectWidth = Math.max(i.sizeInfo.totalMenuWidth, t), i.$newElement.css("width", i.sizeInfo.selectWidth + "px");
				}) : "fit" === this.options.width ? (this.$menu.css("min-width", ""), this.$newElement.css("width", "").addClass("fit-width")) : this.options.width ? (this.$menu.css("min-width", ""), this.$newElement.css("width", this.options.width)) : (this.$menu.css("min-width", ""), this.$newElement.css("width", "")), this.$newElement.hasClass("fit-width") && "fit" !== this.options.width && this.$newElement.removeClass("fit-width");
			}, selectPosition: function selectPosition() {
				this.$bsContainer = F('<div class="bs-container" />');var s,
				    n,
				    o,
				    l = this,
				    r = F(this.options.container),
				    e = function e(_e2) {
					var t = {},
					    i = l.options.display || F.fn.dropdown.Constructor.Default.display;l.$bsContainer.addClass(_e2.attr("class").replace(/form-control|fit-width/gi, "")).toggleClass(q.DROPUP, _e2.hasClass(q.DROPUP)), s = _e2.offset(), r.is("body") ? n = { top: 0, left: 0 } : ((n = r.offset()).top += parseInt(r.css("borderTopWidth")) - r.scrollTop(), n.left += parseInt(r.css("borderLeftWidth")) - r.scrollLeft()), o = _e2.hasClass(q.DROPUP) ? 0 : _e2[0].offsetHeight, (_.major < 4 || "static" === i) && (t.top = s.top - n.top + o, t.left = s.left - n.left), t.width = _e2[0].offsetWidth, l.$bsContainer.css(t);
				};this.$button.on("click.bs.dropdown.data-api", function () {
					l.isDisabled() || (e(l.$newElement), l.$bsContainer.appendTo(l.options.container).toggleClass(q.SHOW, !l.$button.hasClass(q.SHOW)).append(l.$menu));
				}), F(window).on("resize scroll", function () {
					e(l.$newElement);
				}), this.$element.on("hide.bs.select", function () {
					l.$menu.data("height", l.$menu.height()), l.$bsContainer.detach();
				});
			}, setOptionStatus: function setOptionStatus() {
				var e = this,
				    t = this.$element.find("option");if (e.noScroll = !1, e.selectpicker.view.visibleElements && e.selectpicker.view.visibleElements.length) for (var i = 0; i < e.selectpicker.view.visibleElements.length; i++) {
					var s = e.selectpicker.current.map.originalIndex[i + e.selectpicker.view.position0],
					    n = t[s];if (n) {
						var o = this.selectpicker.main.map.newIndex[s],
						    l = this.selectpicker.main.elements[o];e.setDisabled(s, n.disabled || "OPTGROUP" === n.parentNode.tagName && n.parentNode.disabled, o, l), e.setSelected(s, n.selected, o, l);
					}
				}
			}, setSelected: function setSelected(e, t, i, s) {
				var n,
				    o,
				    l,
				    r = void 0 !== this.activeIndex,
				    c = this.activeIndex === e || t && !this.multiple && !r;i || (i = this.selectpicker.main.map.newIndex[e]), s || (s = this.selectpicker.main.elements[i]), l = s.firstChild, t && (this.selectedIndex = e), s.classList.toggle("selected", t), s.classList.toggle("active", c), c && (this.selectpicker.view.currentActive = s, this.activeIndex = e), l && (l.classList.toggle("selected", t), l.classList.toggle("active", c), l.setAttribute("aria-selected", t)), c || !r && t && void 0 !== this.prevActiveIndex && (n = this.selectpicker.main.map.newIndex[this.prevActiveIndex], (o = this.selectpicker.main.elements[n]).classList.toggle("selected", t), o.classList.remove("active"), o.firstChild && (o.firstChild.classList.toggle("selected", t), o.firstChild.classList.remove("active")));
			}, setDisabled: function setDisabled(e, t, i, s) {
				var n;i || (i = this.selectpicker.main.map.newIndex[e]), s || (s = this.selectpicker.main.elements[i]), n = s.firstChild, s.classList.toggle(q.DISABLED, t), n && ("4" === _.major && n.classList.toggle(q.DISABLED, t), n.setAttribute("aria-disabled", t), t ? n.setAttribute("tabindex", -1) : n.setAttribute("tabindex", 0));
			}, isDisabled: function isDisabled() {
				return this.$element[0].disabled;
			}, checkDisabled: function checkDisabled() {
				var e = this;this.isDisabled() ? (this.$newElement.addClass(q.DISABLED), this.$button.addClass(q.DISABLED).attr("tabindex", -1).attr("aria-disabled", !0)) : (this.$button.hasClass(q.DISABLED) && (this.$newElement.removeClass(q.DISABLED), this.$button.removeClass(q.DISABLED).attr("aria-disabled", !1)), -1 != this.$button.attr("tabindex") || this.$element.data("tabindex") || this.$button.removeAttr("tabindex")), this.$button.click(function () {
					return !e.isDisabled();
				});
			}, togglePlaceholder: function togglePlaceholder() {
				var e = this.$element[0],
				    t = e.selectedIndex,
				    i = -1 === t;i || e.options[t].value || (i = !0), this.$button.toggleClass("bs-placeholder", i);
			}, tabIndex: function tabIndex() {
				this.$element.data("tabindex") !== this.$element.attr("tabindex") && -98 !== this.$element.attr("tabindex") && "-98" !== this.$element.attr("tabindex") && (this.$element.data("tabindex", this.$element.attr("tabindex")), this.$button.attr("tabindex", this.$element.data("tabindex"))), this.$element.attr("tabindex", -98);
			}, clickListener: function clickListener() {
				var E = this,
				    t = F(document);function e() {
					E.options.liveSearch ? E.$searchbox.focus() : E.$menuInner.focus();
				}function i() {
					E.dropdown && E.dropdown._popper && E.dropdown._popper.state.isCreated ? e() : requestAnimationFrame(i);
				}t.data("spaceSelect", !1), this.$button.on("keyup", function (e) {
					/(32)/.test(e.keyCode.toString(10)) && t.data("spaceSelect") && (e.preventDefault(), t.data("spaceSelect", !1));
				}), this.$newElement.on("show.bs.dropdown", function () {
					3 < _.major && !E.dropdown && (E.dropdown = E.$button.data("bs.dropdown"), E.dropdown._menu = E.$menu[0]);
				}), this.$button.on("click.bs.dropdown.data-api", function () {
					E.$newElement.hasClass(q.SHOW) || E.setSize();
				}), this.$element.on("shown.bs.select", function () {
					E.$menuInner[0].scrollTop !== E.selectpicker.view.scrollTop && (E.$menuInner[0].scrollTop = E.selectpicker.view.scrollTop), 3 < _.major ? requestAnimationFrame(i) : e();
				}), this.$menuInner.on("click", "li a", function (e, t) {
					var i = F(this),
					    s = E.isVirtual() ? E.selectpicker.view.position0 : 0,
					    n = E.selectpicker.current.map.originalIndex[i.parent().index() + s],
					    o = S(E.$element[0]),
					    l = E.$element.prop("selectedIndex"),
					    r = !0;if (E.multiple && 1 !== E.options.maxOptions && e.stopPropagation(), e.preventDefault(), !E.isDisabled() && !i.parent().hasClass(q.DISABLED)) {
						var c = E.$element.find("option"),
						    a = c.eq(n),
						    d = a.prop("selected"),
						    h = a.parent("optgroup"),
						    p = h.find("option"),
						    u = E.options.maxOptions,
						    f = h.data("maxOptions") || !1;if (n === E.activeIndex && (t = !0), t || (E.prevActiveIndex = E.activeIndex, E.activeIndex = void 0), E.multiple) {
							if (a.prop("selected", !d), E.setSelected(n, !d), i.blur(), !1 !== u || !1 !== f) {
								var m = u < c.filter(":selected").length,
								    v = f < h.find("option:selected").length;if (u && m || f && v) if (u && 1 == u) {
									c.prop("selected", !1), a.prop("selected", !0);for (var g = 0; g < c.length; g++) {
										E.setSelected(g, !1);
									}E.setSelected(n, !0);
								} else if (f && 1 == f) {
									h.find("option:selected").prop("selected", !1), a.prop("selected", !0);for (g = 0; g < p.length; g++) {
										var b = p[g];E.setSelected(c.index(b), !1);
									}E.setSelected(n, !0);
								} else {
									var w = "string" == typeof E.options.maxOptionsText ? [E.options.maxOptionsText, E.options.maxOptionsText] : E.options.maxOptionsText,
									    x = "function" == typeof w ? w(u, f) : w,
									    I = x[0].replace("{n}", u),
									    k = x[1].replace("{n}", f),
									    $ = F('<div class="notify"></div>');x[2] && (I = I.replace("{var}", x[2][1 < u ? 0 : 1]), k = k.replace("{var}", x[2][1 < f ? 0 : 1])), a.prop("selected", !1), E.$menu.append($), u && m && ($.append(F("<div>" + I + "</div>")), r = !1, E.$element.trigger("maxReached.bs.select")), f && v && ($.append(F("<div>" + k + "</div>")), r = !1, E.$element.trigger("maxReachedGrp.bs.select")), setTimeout(function () {
										E.setSelected(n, !1);
									}, 10), $.delay(750).fadeOut(300, function () {
										F(this).remove();
									});
								}
							}
						} else c.prop("selected", !1), a.prop("selected", !0), E.setSelected(n, !0);!E.multiple || E.multiple && 1 === E.options.maxOptions ? E.$button.focus() : E.options.liveSearch && E.$searchbox.focus(), r && (o != S(E.$element[0]) && E.multiple || l != E.$element.prop("selectedIndex") && !E.multiple) && (y = [n, a.prop("selected"), o], E.$element.triggerNative("change"));
					}
				}), this.$menu.on("click", "li." + q.DISABLED + " a, ." + q.POPOVERHEADER + ", ." + q.POPOVERHEADER + " :not(.close)", function (e) {
					e.currentTarget == this && (e.preventDefault(), e.stopPropagation(), E.options.liveSearch && !F(e.target).hasClass("close") ? E.$searchbox.focus() : E.$button.focus());
				}), this.$menuInner.on("click", ".divider, .dropdown-header", function (e) {
					e.preventDefault(), e.stopPropagation(), E.options.liveSearch ? E.$searchbox.focus() : E.$button.focus();
				}), this.$menu.on("click", "." + q.POPOVERHEADER + " .close", function () {
					E.$button.click();
				}), this.$searchbox.on("click", function (e) {
					e.stopPropagation();
				}), this.$menu.on("click", ".actions-btn", function (e) {
					E.options.liveSearch ? E.$searchbox.focus() : E.$button.focus(), e.preventDefault(), e.stopPropagation(), F(this).hasClass("bs-select-all") ? E.selectAll() : E.deselectAll();
				}), this.$element.on({ change: function change() {
						E.render(), E.$element.trigger("changed.bs.select", y), y = null;
					}, focus: function focus() {
						E.$button.focus();
					} });
			}, liveSearchListener: function liveSearchListener() {
				var u = this,
				    f = document.createElement("li");this.$button.on("click.bs.dropdown.data-api", function () {
					u.$searchbox.val() && u.$searchbox.val("");
				}), this.$searchbox.on("click.bs.dropdown.data-api focus.bs.dropdown.data-api touchend.bs.dropdown.data-api", function (e) {
					e.stopPropagation();
				}), this.$searchbox.on("input propertychange", function () {
					var e = u.$searchbox.val();if (u.selectpicker.search.map.newIndex = {}, u.selectpicker.search.map.originalIndex = {}, u.selectpicker.search.elements = [], u.selectpicker.search.data = [], e) {
						var t = [],
						    i = e.toUpperCase(),
						    s = {},
						    n = [],
						    o = u._searchStyle(),
						    l = u.options.liveSearchNormalize;u._$lisSelected = u.$menuInner.find(".selected");for (var r = 0; r < u.selectpicker.main.data.length; r++) {
							var c = u.selectpicker.main.data[r];s[r] || (s[r] = $(c, i, o, l)), s[r] && void 0 !== c.headerIndex && -1 === n.indexOf(c.headerIndex) && (0 < c.headerIndex && (s[c.headerIndex - 1] = !0, n.push(c.headerIndex - 1)), s[c.headerIndex] = !0, n.push(c.headerIndex), s[c.lastIndex + 1] = !0), s[r] && "optgroup-label" !== c.type && n.push(r);
						}r = 0;for (var a = n.length; r < a; r++) {
							var d = n[r],
							    h = n[r - 1],
							    p = (c = u.selectpicker.main.data[d], u.selectpicker.main.data[h]);("divider" !== c.type || "divider" === c.type && p && "divider" !== p.type && a - 1 !== r) && (u.selectpicker.search.data.push(c), t.push(u.selectpicker.main.elements[d]), c.hasOwnProperty("originalIndex") && (u.selectpicker.search.map.newIndex[c.originalIndex] = t.length - 1, u.selectpicker.search.map.originalIndex[t.length - 1] = c.originalIndex));
						}u.activeIndex = void 0, u.noScroll = !0, u.$menuInner.scrollTop(0), u.selectpicker.search.elements = t, u.createView(!0), t.length || (f.className = "no-results", f.innerHTML = u.options.noneResultsText.replace("{0}", '"' + G(e) + '"'), u.$menuInner[0].firstChild.appendChild(f));
					} else u.$menuInner.scrollTop(0), u.createView(!1);
				});
			}, _searchStyle: function _searchStyle() {
				return this.options.liveSearchStyle || "contains";
			}, val: function val(e) {
				return void 0 !== e ? (this.$element.val(e).triggerNative("change"), this.$element) : this.$element.val();
			}, changeAll: function changeAll(e) {
				if (this.multiple) {
					void 0 === e && (e = !0);var t = this.$element.find("option"),
					    i = 0,
					    s = 0,
					    n = S(this.$element[0]);this.$element.addClass("bs-select-hidden");for (var o = 0; o < this.selectpicker.current.elements.length; o++) {
						var l = this.selectpicker.current.data[o],
						    r = t[this.selectpicker.current.map.originalIndex[o]];r && !r.disabled && "divider" !== l.type && (r.selected && i++, r.selected = e, r.selected && s++);
					}this.$element.removeClass("bs-select-hidden"), i !== s && (this.setOptionStatus(), this.togglePlaceholder(), y = [null, null, n], this.$element.triggerNative("change"));
				}
			}, selectAll: function selectAll() {
				return this.changeAll(!0);
			}, deselectAll: function deselectAll() {
				return this.changeAll(!1);
			}, toggle: function toggle(e) {
				(e = e || window.event) && e.stopPropagation(), this.$button.trigger("click.bs.dropdown.data-api");
			}, keydown: function keydown(e) {
				var t,
				    i,
				    s,
				    n,
				    o,
				    l = F(this),
				    r = l.hasClass("dropdown-toggle"),
				    c = (r ? l.closest(".dropdown") : l.closest(N.MENU)).data("this"),
				    a = c.findLis(),
				    d = !1,
				    h = e.which === D && !r && !c.options.selectOnTab,
				    p = A.test(e.which) || h,
				    u = c.$menuInner[0].scrollTop,
				    f = c.isVirtual(),
				    m = !0 === f ? c.selectpicker.view.position0 : 0;if (!(i = c.$newElement.hasClass(q.SHOW)) && (p || 48 <= e.which && e.which <= 57 || 96 <= e.which && e.which <= 105 || 65 <= e.which && e.which <= 90) && c.$button.trigger("click.bs.dropdown.data-api"), e.which === C && i && (e.preventDefault(), c.$button.trigger("click.bs.dropdown.data-api").focus()), p) {
					if (!a.length) return;void 0 === (t = !0 === f ? a.index(a.filter(".active")) : c.selectpicker.current.map.newIndex[c.activeIndex]) && (t = -1), -1 !== t && ((s = c.selectpicker.current.elements[t + m]).classList.remove("active"), s.firstChild && s.firstChild.classList.remove("active")), e.which === H ? (-1 !== t && t--, t + m < 0 && (t += a.length), c.selectpicker.view.canHighlight[t + m] || -1 === (t = c.selectpicker.view.canHighlight.slice(0, t + m).lastIndexOf(!0) - m) && (t = a.length - 1)) : (e.which === L || h) && (++t + m >= c.selectpicker.view.canHighlight.length && (t = 0), c.selectpicker.view.canHighlight[t + m] || (t = t + 1 + c.selectpicker.view.canHighlight.slice(t + m + 1).indexOf(!0))), e.preventDefault();var v = m + t;e.which === H ? 0 === m && t === a.length - 1 ? (c.$menuInner[0].scrollTop = c.$menuInner[0].scrollHeight, v = c.selectpicker.current.elements.length - 1) : d = (o = (n = c.selectpicker.current.data[v]).position - n.height) < u : (e.which === L || h) && (0 === t ? v = c.$menuInner[0].scrollTop = 0 : d = u < (o = (n = c.selectpicker.current.data[v]).position - c.sizeInfo.menuInnerHeight)), (s = c.selectpicker.current.elements[v]) && (s.classList.add("active"), s.firstChild && s.firstChild.classList.add("active")), c.activeIndex = c.selectpicker.current.map.originalIndex[v], c.selectpicker.view.currentActive = s, d && (c.$menuInner[0].scrollTop = o), c.options.liveSearch ? c.$searchbox.focus() : l.focus();
				} else if (!l.is("input") && !P.test(e.which) || e.which === T && c.selectpicker.keydown.keyHistory) {
					var g,
					    b,
					    w = [];e.preventDefault(), c.selectpicker.keydown.keyHistory += E[e.which], c.selectpicker.keydown.resetKeyHistory.cancel && clearTimeout(c.selectpicker.keydown.resetKeyHistory.cancel), c.selectpicker.keydown.resetKeyHistory.cancel = c.selectpicker.keydown.resetKeyHistory.start(), b = c.selectpicker.keydown.keyHistory, /^(.)\1+$/.test(b) && (b = b.charAt(0));for (var x = 0; x < c.selectpicker.current.data.length; x++) {
						var I = c.selectpicker.current.data[x];$(I, b, "startsWith", !0) && c.selectpicker.view.canHighlight[x] && (I.index = x, w.push(I.originalIndex));
					}if (w.length) {
						var k = 0;a.removeClass("active").find("a").removeClass("active"), 1 === b.length && (-1 === (k = w.indexOf(c.activeIndex)) || k === w.length - 1 ? k = 0 : k++), g = c.selectpicker.current.map.newIndex[w[k]], 0 < u - (n = c.selectpicker.current.data[g]).position ? (o = n.position - n.height, d = !0) : (o = n.position - c.sizeInfo.menuInnerHeight, d = n.position > u + c.sizeInfo.menuInnerHeight), (s = c.selectpicker.current.elements[g]).classList.add("active"), s.firstChild && s.firstChild.classList.add("active"), c.activeIndex = w[k], s.firstChild.focus(), d && (c.$menuInner[0].scrollTop = o), l.focus();
					}
				}i && (e.which === T && !c.selectpicker.keydown.keyHistory || e.which === z || e.which === D && c.options.selectOnTab) && (e.which !== T && e.preventDefault(), c.options.liveSearch && e.which === T || (c.$menuInner.find(".active a").trigger("click", !0), l.focus(), c.options.liveSearch || (e.preventDefault(), F(document).data("spaceSelect", !0))));
			}, mobile: function mobile() {
				this.$element.addClass("mobile-device");
			}, refresh: function refresh() {
				var e = F.extend({}, this.options, this.$element.data());this.options = e, this.selectpicker.main.map.newIndex = {}, this.selectpicker.main.map.originalIndex = {}, this.createLi(), this.checkDisabled(), this.render(), this.setStyle(), this.setWidth(), this.setSize(!0), this.$element.trigger("refreshed.bs.select");
			}, hide: function hide() {
				this.$newElement.hide();
			}, show: function show() {
				this.$newElement.show();
			}, remove: function remove() {
				this.$newElement.remove(), this.$element.remove();
			}, destroy: function destroy() {
				this.$newElement.before(this.$element).remove(), this.$bsContainer ? this.$bsContainer.remove() : this.$menu.remove(), this.$element.off(".bs.select").removeData("selectpicker").removeClass("bs-select-hidden selectpicker");
			} };var h = F.fn.selectpicker;F.fn.selectpicker = r, F.fn.selectpicker.Constructor = c, F.fn.selectpicker.noConflict = function () {
			return F.fn.selectpicker = h, this;
		}, F(document).off("keydown.bs.dropdown.data-api").on("keydown.bs.select", '.bootstrap-select [data-toggle="dropdown"], .bootstrap-select [role="listbox"], .bs-searchbox input', c.prototype.keydown).on("focusin.modal", '.bootstrap-select [data-toggle="dropdown"], .bootstrap-select [role="listbox"], .bs-searchbox input', function (e) {
			e.stopPropagation();
		}), F(window).on("load.bs.select.data-api", function () {
			F(".selectpicker").each(function () {
				var e = F(this);r.call(e, e.data());
			});
		});
	}(e);
});
//# sourceMappingURL=bootstrap-select.js.map
/**
 * @preserve jQuery Autocomplete plugin v1.2.6
 * @homepage http://xdsoft.net/jqplugins/autocomplete/
 * @license MIT - MIT-LICENSE.txt
 * (c) 2014, Chupurnov Valeriy <chupurnov@gmail.com>
 */
(function ($) {
	'use strict';

	var ARROWLEFT = 37,
	    ARROWRIGHT = 39,
	    ARROWUP = 38,
	    ARROWDOWN = 40,
	    TAB = 9,
	    CTRLKEY = 17,
	    SHIFTKEY = 16,
	    DEL = 46,
	    ENTER = 13,
	    ESC = 27,
	    BACKSPACE = 8,
	    AKEY = 65,
	    CKEY = 67,
	    VKEY = 86,
	    ZKEY = 90,
	    YKEY = 89,
	    defaultSetting = {},

	//currentInput = false,
	ctrlDown = false,
	    shiftDown = false,
	    publics = {},
	    accent_map = {
		'ẚ': 'a', 'Á': 'a', 'á': 'a', 'À': 'a', 'à': 'a', 'Ă': 'a', 'ă': 'a', 'Ắ': 'a', 'ắ': 'a', 'Ằ': 'a', 'ằ': 'a', 'Ẵ': 'a', 'ẵ': 'a', 'Ẳ': 'a',
		'Ẫ': 'a', 'ẫ': 'a', 'Ẩ': 'a', 'ẩ': 'a', 'Ǎ': 'a', 'ǎ': 'a', 'Å': 'a', 'å': 'a', 'Ǻ': 'a', 'ǻ': 'a', 'Ä': 'a', 'ä': 'a', 'Ǟ': 'a', 'ǟ': 'a',
		'Ã': 'a', 'ã': 'a', 'Ȧ': 'a', 'ȧ': 'a', 'Ǡ': 'a', 'ǡ': 'a', 'Ą': 'a', 'ą': 'a', 'Ā': 'a', 'ā': 'a', 'Ả': 'a', 'ả': 'a', 'Ȁ': 'a', 'ȁ': 'a',
		'Ȃ': 'a', 'ȃ': 'a', 'Ạ': 'a', 'ạ': 'a', 'Ặ': 'a', 'ặ': 'a', 'Ậ': 'a', 'ậ': 'a', 'Ḁ': 'a', 'ḁ': 'a', 'Ⱥ': 'a', 'ⱥ': 'a', 'Ǽ': 'a', 'ǽ': 'a',
		'Ǣ': 'a', 'ǣ': 'a', 'Ḃ': 'b', 'ḃ': 'b', 'Ḅ': 'b', 'ḅ': 'b', 'Ḇ': 'b', 'ḇ': 'b', 'Ƀ': 'b', 'ƀ': 'b', 'ᵬ': 'b', 'Ɓ': 'b', 'ɓ': 'b', 'Ƃ': 'b',
		'ƃ': 'b', 'Ć': 'c', 'ć': 'c', 'Ĉ': 'c', 'ĉ': 'c', 'Č': 'c', 'č': 'c', 'Ċ': 'c', 'ċ': 'c', 'Ç': 'c', 'ç': 'c', 'Ḉ': 'c', 'ḉ': 'c', 'Ȼ': 'c',
		'ȼ': 'c', 'Ƈ': 'c', 'ƈ': 'c', 'ɕ': 'c', 'Ď': 'd', 'ď': 'd', 'Ḋ': 'd', 'ḋ': 'd', 'Ḑ': 'd', 'ḑ': 'd', 'Ḍ': 'd', 'ḍ': 'd', 'Ḓ': 'd', 'ḓ': 'd',
		'Ḏ': 'd', 'ḏ': 'd', 'Đ': 'd', 'đ': 'd', 'ᵭ': 'd', 'Ɖ': 'd', 'ɖ': 'd', 'Ɗ': 'd', 'ɗ': 'd', 'Ƌ': 'd', 'ƌ': 'd', 'ȡ': 'd', 'ð': 'd', 'É': 'e',
		'Ə': 'e', 'Ǝ': 'e', 'ǝ': 'e', 'é': 'e', 'È': 'e', 'è': 'e', 'Ĕ': 'e', 'ĕ': 'e', 'Ê': 'e', 'ê': 'e', 'Ế': 'e', 'ế': 'e', 'Ề': 'e', 'ề': 'e',
		'Ễ': 'e', 'ễ': 'e', 'Ể': 'e', 'ể': 'e', 'Ě': 'e', 'ě': 'e', 'Ë': 'e', 'ë': 'e', 'Ẽ': 'e', 'ẽ': 'e', 'Ė': 'e', 'ė': 'e', 'Ȩ': 'e', 'ȩ': 'e',
		'Ḝ': 'e', 'ḝ': 'e', 'Ę': 'e', 'ę': 'e', 'Ē': 'e', 'ē': 'e', 'Ḗ': 'e', 'ḗ': 'e', 'Ḕ': 'e', 'ḕ': 'e', 'Ẻ': 'e', 'ẻ': 'e', 'Ȅ': 'e', 'ȅ': 'e',
		'Ȇ': 'e', 'ȇ': 'e', 'Ẹ': 'e', 'ẹ': 'e', 'Ệ': 'e', 'ệ': 'e', 'Ḙ': 'e', 'ḙ': 'e', 'Ḛ': 'e', 'ḛ': 'e', 'Ɇ': 'e', 'ɇ': 'e', 'ɚ': 'e', 'ɝ': 'e',
		'Ḟ': 'f', 'ḟ': 'f', 'ᵮ': 'f', 'Ƒ': 'f', 'ƒ': 'f', 'Ǵ': 'g', 'ǵ': 'g', 'Ğ': 'g', 'ğ': 'g', 'Ĝ': 'g', 'ĝ': 'g', 'Ǧ': 'g', 'ǧ': 'g', 'Ġ': 'g',
		'ġ': 'g', 'Ģ': 'g', 'ģ': 'g', 'Ḡ': 'g', 'ḡ': 'g', 'Ǥ': 'g', 'ǥ': 'g', 'Ɠ': 'g', 'ɠ': 'g', 'Ĥ': 'h', 'ĥ': 'h', 'Ȟ': 'h', 'ȟ': 'h', 'Ḧ': 'h',
		'ḧ': 'h', 'Ḣ': 'h', 'ḣ': 'h', 'Ḩ': 'h', 'ḩ': 'h', 'Ḥ': 'h', 'ḥ': 'h', 'Ḫ': 'h', 'ḫ': 'h', 'H': 'h', '̱': 'h', 'ẖ': 'h', 'Ħ': 'h', 'ħ': 'h',
		'Ⱨ': 'h', 'ⱨ': 'h', 'Í': 'i', 'í': 'i', 'Ì': 'i', 'ì': 'i', 'Ĭ': 'i', 'ĭ': 'i', 'Î': 'i', 'î': 'i', 'Ǐ': 'i', 'ǐ': 'i', 'Ï': 'i', 'ï': 'i',
		'Ḯ': 'i', 'ḯ': 'i', 'Ĩ': 'i', 'ĩ': 'i', 'İ': 'i', 'i': 'i', 'Į': 'i', 'į': 'i', 'Ī': 'i', 'ī': 'i', 'Ỉ': 'i', 'ỉ': 'i', 'Ȉ': 'i', 'ȉ': 'i',
		'Ȋ': 'i', 'ȋ': 'i', 'Ị': 'i', 'ị': 'i', 'Ḭ': 'i', 'ḭ': 'i', 'I': 'i', 'ı': 'i', 'Ɨ': 'i', 'ɨ': 'i', 'Ĵ': 'j', 'ĵ': 'j', 'J': 'j', '̌': 'j',
		'ǰ': 'j', 'ȷ': 'j', 'Ɉ': 'j', 'ɉ': 'j', 'ʝ': 'j', 'ɟ': 'j', 'ʄ': 'j', 'Ḱ': 'k', 'ḱ': 'k', 'Ǩ': 'k', 'ǩ': 'k', 'Ķ': 'k', 'ķ': 'k', 'Ḳ': 'k',
		'ḳ': 'k', 'Ḵ': 'k', 'ḵ': 'k', 'Ƙ': 'k', 'ƙ': 'k', 'Ⱪ': 'k', 'ⱪ': 'k', 'Ĺ': 'a', 'ĺ': 'l', 'Ľ': 'l', 'ľ': 'l', 'Ļ': 'l', 'ļ': 'l', 'Ḷ': 'l',
		'ḷ': 'l', 'Ḹ': 'l', 'ḹ': 'l', 'Ḽ': 'l', 'ḽ': 'l', 'Ḻ': 'l', 'ḻ': 'l', 'Ł': 'l', 'ł': 'l', '̣': 'l', 'Ŀ': 'l',
		'ŀ': 'l', 'Ƚ': 'l', 'ƚ': 'l', 'Ⱡ': 'l', 'ⱡ': 'l', 'Ɫ': 'l', 'ɫ': 'l', 'ɬ': 'l', 'ɭ': 'l', 'ȴ': 'l', 'Ḿ': 'm', 'ḿ': 'm', 'Ṁ': 'm', 'ṁ': 'm',
		'Ṃ': 'm', 'ṃ': 'm', 'ɱ': 'm', 'Ń': 'n', 'ń': 'n', 'Ǹ': 'n', 'ǹ': 'n', 'Ň': 'n', 'ň': 'n', 'Ñ': 'n', 'ñ': 'n', 'Ṅ': 'n', 'ṅ': 'n', 'Ņ': 'n',
		'ņ': 'n', 'Ṇ': 'n', 'ṇ': 'n', 'Ṋ': 'n', 'ṋ': 'n', 'Ṉ': 'n', 'ṉ': 'n', 'Ɲ': 'n', 'ɲ': 'n', 'Ƞ': 'n', 'ƞ': 'n', 'ɳ': 'n', 'ȵ': 'n', 'N': 'n',
		'̈': 'n', 'n': 'n', 'Ó': 'o', 'ó': 'o', 'Ò': 'o', 'ò': 'o', 'Ŏ': 'o', 'ŏ': 'o', 'Ô': 'o', 'ô': 'o', 'Ố': 'o', 'ố': 'o', 'Ồ': 'o',
		'ồ': 'o', 'Ỗ': 'o', 'ỗ': 'o', 'Ổ': 'o', 'ổ': 'o', 'Ǒ': 'o', 'ǒ': 'o', 'Ö': 'o', 'ö': 'o', 'Ȫ': 'o', 'ȫ': 'o', 'Ő': 'o', 'ő': 'o', 'Õ': 'o',
		'õ': 'o', 'Ṍ': 'o', 'ṍ': 'o', 'Ṏ': 'o', 'ṏ': 'o', 'Ȭ': 'o', 'ȭ': 'o', 'Ȯ': 'o', 'ȯ': 'o', 'Ȱ': 'o', 'ȱ': 'o', 'Ø': 'o', 'ø': 'o', 'Ǿ': 'o',
		'ǿ': 'o', 'Ǫ': 'o', 'ǫ': 'o', 'Ǭ': 'o', 'ǭ': 'o', 'Ō': 'o', 'ō': 'o', 'Ṓ': 'o', 'ṓ': 'o', 'Ṑ': 'o', 'ṑ': 'o', 'Ỏ': 'o', 'ỏ': 'o', 'Ȍ': 'o',
		'ȍ': 'o', 'Ȏ': 'o', 'ȏ': 'o', 'Ơ': 'o', 'ơ': 'o', 'Ớ': 'o', 'ớ': 'o', 'Ờ': 'o', 'ờ': 'o', 'Ỡ': 'o', 'ỡ': 'o', 'Ở': 'o', 'ở': 'o', 'Ợ': 'o',
		'ợ': 'o', 'Ọ': 'o', 'ọ': 'o', 'Ộ': 'o', 'ộ': 'o', 'Ɵ': 'o', 'ɵ': 'o', 'Ṕ': 'p', 'ṕ': 'p', 'Ṗ': 'p', 'ṗ': 'p', 'Ᵽ': 'p', 'Ƥ': 'p', 'ƥ': 'p',
		'P': 'p', '̃': 'p', 'p': 'p', 'ʠ': 'q', 'Ɋ': 'q', 'ɋ': 'q', 'Ŕ': 'r', 'ŕ': 'r', 'Ř': 'r', 'ř': 'r', 'Ṙ': 'r', 'ṙ': 'r', 'Ŗ': 'r',
		'ŗ': 'r', 'Ȑ': 'r', 'ȑ': 'r', 'Ȓ': 'r', 'ȓ': 'r', 'Ṛ': 'r', 'ṛ': 'r', 'Ṝ': 'r', 'ṝ': 'r', 'Ṟ': 'r', 'ṟ': 'r', 'Ɍ': 'r', 'ɍ': 'r', 'ᵲ': 'r',
		'ɼ': 'r', 'Ɽ': 'r', 'ɽ': 'r', 'ɾ': 'r', 'ᵳ': 'r', 'ß': 's', 'Ś': 's', 'ś': 's', 'Ṥ': 's', 'ṥ': 's', 'Ŝ': 's', 'ŝ': 's', 'Š': 's', 'š': 's',
		'Ṧ': 's', 'ṧ': 's', 'Ṡ': 's', 'ṡ': 's', 'ẛ': 's', 'Ş': 's', 'ş': 's', 'Ṣ': 's', 'ṣ': 's', 'Ṩ': 's', 'ṩ': 's', 'Ș': 's', 'ș': 's', 'ʂ': 's',
		'S': 's', '̩': 's', 's': 's', 'Þ': 't', 'þ': 't', 'Ť': 't', 'ť': 't', 'T': 't', 'ẗ': 't', 'Ṫ': 't', 'ṫ': 't', 'Ţ': 't', 'ţ': 't', 'Ṭ': 't',
		'ṭ': 't', 'Ț': 't', 'ț': 't', 'Ṱ': 't', 'ṱ': 't', 'Ṯ': 't', 'ṯ': 't', 'Ŧ': 't', 'ŧ': 't', 'Ⱦ': 't', 'ⱦ': 't', 'ᵵ': 't',
		'ƫ': 't', 'Ƭ': 't', 'ƭ': 't', 'Ʈ': 't', 'ʈ': 't', 'ȶ': 't', 'Ú': 'u', 'ú': 'u', 'Ù': 'u', 'ù': 'u', 'Ŭ': 'u', 'ŭ': 'u', 'Û': 'u', 'û': 'u',
		'Ǔ': 'u', 'ǔ': 'u', 'Ů': 'u', 'ů': 'u', 'Ü': 'u', 'ü': 'u', 'Ǘ': 'u', 'ǘ': 'u', 'Ǜ': 'u', 'ǜ': 'u', 'Ǚ': 'u', 'ǚ': 'u', 'Ǖ': 'u', 'ǖ': 'u',
		'Ű': 'u', 'ű': 'u', 'Ũ': 'u', 'ũ': 'u', 'Ṹ': 'u', 'ṹ': 'u', 'Ų': 'u', 'ų': 'u', 'Ū': 'u', 'ū': 'u', 'Ṻ': 'u', 'ṻ': 'u', 'Ủ': 'u', 'ủ': 'u',
		'Ȕ': 'u', 'ȕ': 'u', 'Ȗ': 'u', 'ȗ': 'u', 'Ư': 'u', 'ư': 'u', 'Ứ': 'u', 'ứ': 'u', 'Ừ': 'u', 'ừ': 'u', 'Ữ': 'u', 'ữ': 'u', 'Ử': 'u', 'ử': 'u',
		'Ự': 'u', 'ự': 'u', 'Ụ': 'u', 'ụ': 'u', 'Ṳ': 'u', 'ṳ': 'u', 'Ṷ': 'u', 'ṷ': 'u', 'Ṵ': 'u', 'ṵ': 'u', 'Ʉ': 'u', 'ʉ': 'u', 'Ṽ': 'v', 'ṽ': 'v',
		'Ṿ': 'v', 'ṿ': 'v', 'Ʋ': 'v', 'ʋ': 'v', 'Ẃ': 'w', 'ẃ': 'w', 'Ẁ': 'w', 'ẁ': 'w', 'Ŵ': 'w', 'ŵ': 'w', 'W': 'w', '̊': 'w', 'ẘ': 'w', 'Ẅ': 'w',
		'ẅ': 'w', 'Ẇ': 'w', 'ẇ': 'w', 'Ẉ': 'w', 'ẉ': 'w', 'Ẍ': 'x', 'ẍ': 'x', 'Ẋ': 'x', 'ẋ': 'x', 'Ý': 'y', 'ý': 'y', 'Ỳ': 'y', 'ỳ': 'y', 'Ŷ': 'y',
		'ŷ': 'y', 'Y': 'y', 'ẙ': 'y', 'Ÿ': 'y', 'ÿ': 'y', 'Ỹ': 'y', 'ỹ': 'y', 'Ẏ': 'y', 'ẏ': 'y', 'Ȳ': 'y', 'ȳ': 'y', 'Ỷ': 'y', 'ỷ': 'y',
		'Ỵ': 'y', 'ỵ': 'y', 'ʏ': 'y', 'Ɏ': 'y', 'ɏ': 'y', 'Ƴ': 'y', 'ƴ': 'y', 'Ź': 'z', 'ź': 'z', 'Ẑ': 'z', 'ẑ': 'z', 'Ž': 'z', 'ž': 'z', 'Ż': 'z',
		'ż': 'z', 'Ẓ': 'z', 'ẓ': 'z', 'Ẕ': 'z', 'ẕ': 'z', 'Ƶ': 'z', 'ƶ': 'z', 'Ȥ': 'z', 'ȥ': 'z', 'ʐ': 'z', 'ʑ': 'z', 'Ⱬ': 'z', 'ⱬ': 'z', 'Ǯ': 'z',
		'ǯ': 'z', 'ƺ': 'z', '２': '2', '６': '6', 'Ｂ': 'B', 'Ｆ': 'F', 'Ｊ': 'J', 'Ｎ': 'N', 'Ｒ': 'R', 'Ｖ': 'V', 'Ｚ': 'Z', 'ｂ': 'b', 'ｆ': 'f', 'ｊ': 'j',
		'ｎ': 'n', 'ｒ': 'r', 'ｖ': 'v', 'ｚ': 'z', '１': '1', '５': '5', '９': '9', 'Ａ': 'A', 'Ｅ': 'E', 'Ｉ': 'I', 'Ｍ': 'M', 'Ｑ': 'Q', 'Ｕ': 'U', 'Ｙ': 'Y',
		'ａ': 'a', 'ｅ': 'e', 'ｉ': 'i', 'ｍ': 'm', 'ｑ': 'q', 'ｕ': 'u', 'ｙ': 'y', '０': '0', '４': '4', '８': '8', 'Ｄ': 'D', 'Ｈ': 'H', 'Ｌ': 'L', 'Ｐ': 'P',
		'Ｔ': 'T', 'Ｘ': 'X', 'ｄ': 'd', 'ｈ': 'h', 'ｌ': 'l', 'ｐ': 'p', 'ｔ': 't', 'ｘ': 'x', '３': '3', '７': '7', 'Ｃ': 'C', 'Ｇ': 'G', 'Ｋ': 'K', 'Ｏ': 'O',
		'Ｓ': 'S', 'Ｗ': 'W', 'ｃ': 'c', 'ｇ': 'g', 'ｋ': 'k', 'ｏ': 'o', 'ｓ': 's', 'ｗ': 'w', 'ẳ': 'a', 'Â': 'a', 'â': 'a', 'Ấ': 'a', 'ấ': 'a', 'Ầ': 'a', 'ầ': 'a'
	};

	if (window.getComputedStyle === undefined) {
		window.getComputedStyle = function () {
			function getPixelSize(element, style, property, fontSize) {
				var sizeWithSuffix = style[property],
				    size = parseFloat(sizeWithSuffix),
				    suffix = sizeWithSuffix.split(/\d/)[0],
				    rootSize;

				fontSize = fontSize !== null ? fontSize : /%|em/.test(suffix) && element.parentElement ? getPixelSize(element.parentElement, element.parentElement.currentStyle, 'fontSize', null) : 16;
				rootSize = property === 'fontSize' ? fontSize : /width/i.test(property) ? element.clientWidth : element.clientHeight;

				return suffix === 'em' ? size * fontSize : suffix === 'in' ? size * 96 : suffix === 'pt' ? size * 96 / 72 : suffix === '%' ? size / 100 * rootSize : size;
			}

			function setShortStyleProperty(style, property) {
				var borderSuffix = property === 'border' ? 'Width' : '',
				    t = property + 'Top' + borderSuffix,
				    r = property + 'Right' + borderSuffix,
				    b = property + 'Bottom' + borderSuffix,
				    l = property + 'Left' + borderSuffix;

				style[property] = (style[t] === style[r] === style[b] === style[l] ? [style[t]] : style[t] === style[b] && style[l] === style[r] ? [style[t], style[r]] : style[l] === style[r] ? [style[t], style[r], style[b]] : [style[t], style[r], style[b], style[l]]).join(' ');
			}

			function CSSStyleDeclaration(element) {
				var currentStyle = element.currentStyle,
				    style = this,
				    property,
				    fontSize = getPixelSize(element, currentStyle, 'fontSize', null);

				for (property in currentStyle) {
					if (Object.prototype.hasOwnProperty.call(currentStyle, property)) {
						if (/width|height|margin.|padding.|border.+W/.test(property) && style[property] !== 'auto') {
							style[property] = getPixelSize(element, currentStyle, property, fontSize) + 'px';
						} else if (property === 'styleFloat') {
							style.float = currentStyle[property];
						} else {
							style[property] = currentStyle[property];
						}
					}
				}

				setShortStyleProperty(style, 'margin');
				setShortStyleProperty(style, 'padding');
				setShortStyleProperty(style, 'border');

				style.fontSize = fontSize + 'px';

				return style;
			}

			CSSStyleDeclaration.prototype = {
				constructor: CSSStyleDeclaration,
				getPropertyPriority: function getPropertyPriority() {},
				getPropertyValue: function getPropertyValue(prop) {
					return this[prop] || '';
				},
				item: function item() {},
				removeProperty: function removeProperty() {},
				setProperty: function setProperty() {},
				getPropertyCSSValue: function getPropertyCSSValue() {}
			};

			function getComputedStyle(element) {
				return new CSSStyleDeclaration(element);
			}

			return getComputedStyle;
		}(this);
	}

	$(document).on('keydown.xdsoftctrl', function (e) {
		if (e.keyCode === CTRLKEY) {
			ctrlDown = true;
		}
		if (e.keyCode === SHIFTKEY) {
			ctrlDown = true;
		}
	}).on('keyup.xdsoftctrl', function (e) {
		if (e.keyCode === CTRLKEY) {
			ctrlDown = false;
		}
		if (e.keyCode === SHIFTKEY) {
			ctrlDown = false;
		}
	});

	function accentReplace(s) {
		if (!s) {
			return '';
		}
		var ret = '',
		    i;
		for (i = 0; i < s.length; i += 1) {
			ret += accent_map[s.charAt(i)] || s.charAt(i);
		}
		return ret;
	}

	function escapeRegExp(str) {
		return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
	}

	function getCaretPosition(input) {
		if (!input) {
			return;
		}
		if (input.selectionStart) {
			return input.selectionStart;
		}
		if (document.selection) {
			input.focus();
			var sel = document.selection.createRange(),
			    selLen = document.selection.createRange().text.length;
			sel.moveStart('character', -input.value.length);
			return sel.text.length - selLen;
		}
	}

	function setCaretPosition(input, pos) {
		if (input.setSelectionRange) {
			input.focus();
			input.setSelectionRange(pos, pos);
		} else if (input.createTextRange) {
			var range = input.createTextRange();
			range.collapse(true);
			range.moveEnd('character', pos);
			range.moveStart('character', pos);
			range.select();
		}
	}

	function isset(value) {
		return value !== undefined;
	}

	function safe_call(callback, args, callback2, defaultValue) {
		if (isset(callback) && !$.isArray(callback)) {
			return $.isFunction(callback) ? callback.apply(this, args) : defaultValue;
		}
		if (isset(callback2)) {
			return safe_call.call(this, callback2, args);
		}
		return defaultValue;
	};

	function __safe(callbackName, source, args, defaultValue) {
		var undefinedVar;
		return safe_call.call(this, isset(this.source[source]) && Object.prototype.hasOwnProperty.call(this.source[source], callbackName) ? this.source[source][callbackName] : undefinedVar, args, function () {
			return safe_call.call(this, isset(this[callbackName][source]) ? this[callbackName][source] : isset(this[callbackName][0]) ? this[callbackName][0] : Object.prototype.hasOwnProperty.call(this, callbackName) ? this[callbackName] : undefinedVar, args, defaultSetting[callbackName][source] || defaultSetting[callbackName][0] || defaultSetting[callbackName], defaultValue);
		}, defaultValue);
	};

	function __get(property, source) {
		if (!isset(source)) source = 0;

		if ($.isArray(this.source) && isset(this.source[source]) && isset(this.source[source][property])) return this.source[source][property];

		if (isset(this[property])) {
			if ($.isArray(this[property])) {
				if (isset(this[property][source])) return this[property][source];
				if (isset(this[property][0])) return this[property][0];
				return null;
			}
			return this[property];
		}

		return null;
	};

	function loadRemote(url, sourceObject, done, debug) {
		if (sourceObject.xhr) {
			sourceObject.xhr.abort();
		}
		sourceObject.xhr = $.ajax($.extend(true, {
			url: url,
			type: 'GET',
			async: true,
			cache: false,
			dataType: 'json'
		}, sourceObject.ajax)).done(function (data) {
			done && done.apply(this, $.makeArray(arguments));
		}).fail(function (jqXHR, textStatus) {
			if (debug) console.log("Request failed: " + textStatus);
		});
	}

	function findRight(data, query) {
		var right = false,
		    source;

		for (source = 0; source < data.length; source += 1) {
			if (right = __safe.call(this, "findRight", source, [data[source], query, source])) {
				return { right: right, source: source };
			}
		}

		return false;
	}

	function processData(data, query) {
		var source;
		preparseData.call(this, data, query);

		for (source = 0; source < data.length; source += 1) {
			data[source] = __safe.call(this, 'filter', source, [data[source], query, source], data[source]);
		}
	};

	function collectData(query, datasource, callback) {
		var options = this,
		    source;

		if ($.isFunction(options.source)) {
			options.source.apply(options, [query, function (items) {
				datasource = [items];
				safe_call.call(options, callback, [query]);
			}, datasource, 0]);
		} else {
			for (source = 0; source < options.source.length; source += 1) {
				if ($.isArray(options.source[source])) {
					datasource[source] = options.source[source];
				} else if ($.isFunction(options.source[source])) {
					(function (source) {
						options.source[source].apply(options, [query, function (items) {
							if (!datasource[source]) {
								datasource[source] = [];
							}

							if (items && $.isArray(items)) {
								switch (options.appendMethod) {
									case 'replace':
										datasource[source] = items;
										break;
									default:
										datasource[source] = datasource[source].concat(items);
								}
							}

							safe_call.call(options, callback, [query]);
						}, datasource, source]);
					})(source);
				} else {
					switch (options.source[source].type) {
						case 'remote':
							if (isset(options.source[source].url)) {
								if (!isset(options.source[source].minLength) || query.length >= options.source[source].minLength) {
									var url = __safe.call(options, 'replace', source, [options.source[source].url, query], '');
									if (!datasource[source]) {
										datasource[source] = [];
									}
									(function (source) {
										loadRemote(url, options.source[source], function (resp) {
											datasource[source] = resp;
											safe_call.call(options, callback, [query]);
										}, options.debug);
									})(source);
								}
							}
							break;
						default:
							if (isset(options.source[source]['data'])) {
								datasource[source] = options.source[source]['data'];
							} else {
								datasource[source] = options.source[source];
							}
					}
				}
			}
		}
		safe_call.call(options, callback, [query]);
	};

	function preparseData(data, query) {
		for (var source = 0; source < data.length; source++) {
			data[source] = __safe.call(this, 'preparse', source, [data[source], query], data[source]);
		}
	};

	function renderData(data, query) {
		var source,
		    i,
		    $div,
		    $divs = [];

		for (source = 0; source < data.length; source += 1) {
			for (i = 0; i < data[source].length; i += 1) {
				if ($divs.length >= this.limit) break;

				$div = $(__safe.call(this, 'render', source, [data[source][i], source, i, query], ''));

				$div.data('source', source);
				$div.data('pid', i);
				$div.data('item', data[source][i]);

				$divs.push($div);
			}
		}

		return $divs;
	};

	function getItem($div, dataset) {
		if (isset($div.data('source')) && isset($div.data('pid')) && isset(dataset[$div.data('source')]) && isset(dataset[$div.data('source')][$div.data('pid')])) {
			return dataset[$div.data('source')][$div.data('pid')];
		}
		return false;
	};

	function getValue($div, dataset) {
		var item = getItem($div, dataset);

		if (item) {
			return __safe.call(this, 'getValue', $div.data('source'), [item, $div.data('source')]);
		} else {
			if (isset($div.data('value'))) {
				return decodeURIComponent($div.data('value'));
			} else {
				return $div.html();
			}
		}
	};

	defaultSetting = {
		minLength: 0,
		valueKey: 'value',
		titleKey: 'title',
		highlight: true,

		showHint: true,

		dropdownWidth: '100%',
		dropdownStyle: {},
		itemStyle: {},
		hintStyle: false,
		style: false,

		debug: true,
		openOnFocus: false,
		closeOnBlur: true,

		autoselect: false,

		accents: true,
		replaceAccentsForRemote: true,

		limit: 20,
		visibleLimit: 20,
		visibleHeight: 0,
		defaultHeightItem: 30,

		timeoutUpdate: 10,

		get: function get(property, source) {
			return __get.call(this, property, source);
		},

		replace: [function (url, query) {
			if (this.replaceAccentsForRemote) {
				query = accentReplace(query);
			}
			return url.replace('%QUERY%', encodeURIComponent(query));
		}],

		equal: function equal(value, query) {
			return query.toLowerCase() == value.substr(0, query.length).toLowerCase();
		},

		findRight: [function (items, query, source) {
			var results = [],
			    value = '',
			    i;
			if (items) {
				for (i = 0; i < items.length; i += 1) {
					value = __safe.call(this, 'getValue', source, [items[i], source]);
					if (__safe.call(this, 'equal', source, [value, query, source], false)) {
						return items[i];
					}
				}
			}
			return false;
		}],

		valid: [function (value, query) {
			if (this.accents) {
				value = accentReplace(value);
				query = accentReplace(query);
			}
			return value.toLowerCase().indexOf(query.toLowerCase()) != -1;
		}],

		filter: [function (items, query, source) {
			var results = [],
			    value = '',
			    i;
			if (items) {
				for (i = 0; i < items.length; i += 1) {
					value = isset(items[i][this.get('valueKey', source)]) ? items[i][this.get('valueKey', source)] : items[i].toString();
					if (__safe.call(this, 'valid', source, [value, query])) {
						results.push(items[i]);
					}
				}
			}
			return results;
		}],

		preparse: function preparse(items) {
			return items;
		},

		getValue: [function (item, source) {
			return isset(item[this.get('valueKey', source)]) ? item[this.get('valueKey', source)] : item.toString();
		}],

		getTitle: [function (item, source) {
			return isset(item[this.get('titleKey', source)]) ? item[this.get('titleKey', source)] : item.toString();
		}],

		render: [function (item, source, pid, query) {
			var value = __safe.call(this, "getValue", source, [item, source], defaultSetting.getValue[0].call(this, item, source)),
			    title = __safe.call(this, "getTitle", source, [item, source], defaultSetting.getTitle[0].call(this, item, source)),
			    _value = '',
			    _query = '',
			    _title = '',
			    hilite_hints = '',
			    highlighted = '',
			    c,
			    h,
			    i,
			    spos = 0;

			if (this.highlight) {
				if (!this.accents) {
					title = title.replace(new RegExp('(' + escapeRegExp(query) + ')', 'i'), '<b>$1</b>');
				} else {
					_title = accentReplace(title).toLowerCase().replace(/[<>]+/g, ''), _query = accentReplace(query).toLowerCase().replace(/[<>]+/g, '');

					hilite_hints = _title.replace(new RegExp(escapeRegExp(_query), 'g'), '<' + _query + '>');
					for (i = 0; i < hilite_hints.length; i += 1) {
						c = title.charAt(spos);
						h = hilite_hints.charAt(i);
						if (h === '<') {
							highlighted += '<b>';
						} else if (h === '>') {
							highlighted += '</b>';
						} else {
							spos += 1;
							highlighted += c;
						}
					}
					title = highlighted;
				}
			}

			return '<div ' + (value == query ? 'class="active"' : '') + ' data-value="' + encodeURIComponent(value) + '">' + title + '</div>';
		}],
		appendMethod: 'concat', // supported merge and replace 
		source: [],
		afterSelected: function afterSelected() {}
	};
	function init(that, options) {
		if ($(that).hasClass('xdsoft_input')) return;

		var $box = $('<div class="xdsoft_autocomplete"></div>'),
		    $dropdown = $('<div class="xdsoft_autocomplete_dropdown"></div>'),
		    $hint = $('<input readonly class="xdsoft_autocomplete_hint"/>'),
		    $input = $(that),
		    timer1 = 0,
		    intervalForVisibility,
		    dataset = [],
		    iOpen = false,
		    value = '',
		    currentValue = '',
		    currentSelect = '',
		    active = null,
		    pos = 0;

		//it can be used to access settings
		$input.data('autocomplete_options', options);

		$dropdown.on('mousedown', function (e) {
			e.preventDefault();
			e.stopPropagation();
		}).on('updatescroll.xdsoft', function () {
			var _act = $dropdown.find('.active');
			if (!_act.length) {
				return;
			}

			var top = _act.position().top,
			    actHght = _act.outerHeight(true),
			    scrlTop = $dropdown.scrollTop(),
			    hght = $dropdown.height();

			if (top < 0) {
				$dropdown.scrollTop(scrlTop - Math.abs(top));
			} else if (top + actHght > hght) {
				$dropdown.scrollTop(scrlTop + top + actHght - hght);
			}
		});

		$box.css({
			'display': $input.css('display'),
			'width': $input.css('width')
		});

		if (options.style) $box.css(options.style);

		$input.addClass('xdsoft_input').attr('autocomplete', 'off');

		var xDown = null;
		var yDown = null;
		var isSwipe = false;
		$dropdown.on('mousemove', 'div', function () {
			if ($(this).hasClass('active')) return true;
			$dropdown.find('div').removeClass('active');
			$(this).addClass('active');
		}).on('mousedown', 'div', function (e) {
			$dropdown.find('div').removeClass('active');
			$(this).addClass('active');
			$input.trigger('pick.xdsoft');
		}).on('touchstart', 'div', function (e) {
			xDown = e.originalEvent.touches[0].clientX;
			yDown = e.originalEvent.touches[0].clientY;
		}).on('touchend', 'div', function (e) {
			if (isSwipe === false) {
				$dropdown.find('div').removeClass('active');
				$(this).addClass('active');
				$input.trigger('pick.xdsoft');
			}

			isSwipe = false;
		}).on('touchmove', 'div', function (e) {
			if (!xDown || !yDown) {
				return;
			}

			var xUp = e.originalEvent.touches[0].clientX;
			var yUp = e.originalEvent.touches[0].clientY;

			var xDiff = xDown - xUp;
			var yDiff = yDown - yUp;

			if (Math.abs(xDiff) > Math.abs(yDiff)) {
				if (xDiff > 0) {
					isSwipe = 'left';
				} else {
					isSwipe = 'right';
				}
			} else {
				if (yDiff > 0) {
					isSwipe = 'top';
				} else {
					isSwipe = 'bottm';
				}
			}

			xDown = null;
			yDown = null;
		});

		function manageData() {
			if ($input.val() != currentValue) {
				currentValue = $input.val();
			} else {
				return;
			}
			if (currentValue.length < options.minLength) {
				$input.trigger('close.xdsoft');
				return;
			}
			collectData.call(options, currentValue, dataset, function (query) {
				if (query != currentValue) {
					return;
				}
				var right;
				processData.call(options, dataset, query);

				$input.trigger('updateContent.xdsoft');

				if (options.showHint && currentValue.length && currentValue.length <= $input.prop('size') && (right = findRight.call(options, dataset, currentValue))) {
					var title = __safe.call(options, 'getTitle', right.source, [right.right, right.source]);
					title = query + title.substr(query.length);
					$hint.val(title);
				} else {
					$hint.val('');
				}
			});

			return;
		}

		function manageKey(event) {
			var key = event.keyCode,
			    right;

			switch (key) {
				case AKEY:case CKEY:case VKEY:case ZKEY:case YKEY:
					if (event.shiftKey || event.ctrlKey) {
						return true;
					}
					break;
				case SHIFTKEY:
				case CTRLKEY:
					return true;
					break;
				case ARROWRIGHT:
				case ARROWLEFT:
					if (ctrlDown || shiftDown || event.shiftKey || event.ctrlKey) {
						return true;
					}
					value = $input.val();
					pos = getCaretPosition($input[0]);
					if (key === ARROWRIGHT && pos === value.length) {
						if (right = findRight.call(options, dataset, value)) {
							$input.trigger('pick.xdsoft', [__safe.call(options, 'getValue', right.source, [right.right, right.source])]);
						} else {
							$input.trigger('pick.xdsoft');
						}
						event.preventDefault();
						return false;
					}
					return true;
				case TAB:
					return true;
				case ENTER:
					if (iOpen) {
						if (options.autoselect) {
							$input.trigger('pick.xdsoft');
						} else if (!options.autoselect && active) {
							$input.trigger('pick.xdsoft');
						} else {
							$input.trigger('close.xdsoft');
							return true;
						}
						event.preventDefault();
						return false;
					} else {
						return true;
					}
					break;
				case ESC:
					$input.val(currentValue).trigger('close.xdsoft');
					event.preventDefault();
					return false;
				case ARROWDOWN:
				case ARROWUP:
					if (!iOpen) {
						$input.trigger('open.xdsoft');
						$input.trigger('updateContent.xdsoft');
						event.preventDefault();
						return false;
					}

					active = $dropdown.find('div.active');

					var next = key == ARROWDOWN ? 'next' : 'prev',
					    timepick = true;

					if (active.length) {
						active.removeClass('active');
						if (active[next]().length) {
							active[next]().addClass('active');
						} else {
							$input.val(currentValue);
							timepick = false;
						}
					} else {
						$dropdown.children().eq(key == ARROWDOWN ? 0 : -1).addClass('active');
					}

					if (timepick) {
						$input.trigger('timepick.xdsoft');
					}

					$dropdown.trigger('updatescroll.xdsoft');

					event.preventDefault();
					return false;
			}
			return;
		}

		$input.data('xdsoft_autocomplete', dataset).after($box).on('pick.xdsoft', function (event, _value) {

			$input.trigger('timepick.xdsoft', _value);

			currentSelect = currentValue = $input.val();

			$input.trigger('close.xdsoft');

			//currentInput = false;

			active = $dropdown.find('div.active').eq(0);

			if (!active.length) active = $dropdown.children().first();

			$input.trigger('selected.xdsoft', [getItem(active, dataset)]);

			if (options.afterSelected) options.afterSelected();
		}).on('timepick.xdsoft', function (event, _value) {
			active = $dropdown.find('div.active');

			if (!active.length) active = $dropdown.children().first();

			if (active.length) {
				if (!isset(_value)) {
					$input.val(getValue.call(options, active, dataset));
				} else {
					$input.val(_value);
				}
				$input.trigger('autocompleted.xdsoft', [getItem(active, dataset)]);
				$hint.val('');
				setCaretPosition($input[0], $input.val().length);
			}
		}).on('keydown.xdsoft input.xdsoft cut.xdsoft paste.xdsoft', function (event) {
			var ret = manageKey(event);

			if (ret === false || ret === true) {
				return ret;
			}

			setTimeout(function () {
				manageData();
			}, 1);

			manageData();
		}).on('change.xdsoft', function (event) {
			currentValue = $input.val();
		});

		currentValue = $input.val();

		collectData.call(options, $input.val(), dataset, function (query) {
			processData.call(options, dataset, query);
		});

		if (options.openOnFocus) {
			$input.on('focusin.xdsoft', function () {
				$input.trigger('open.xdsoft');
				$input.trigger('updateContent.xdsoft');
			});
		}

		if (options.closeOnBlur) $input.on('focusout.xdsoft', function () {
			$input.trigger('close.xdsoft');
		});

		$box.append($input).append($dropdown);

		var olderBackground = false,
		    timerUpdate = 0;

		$input.on('updateHelperPosition.xdsoft', function () {
			clearTimeout(timerUpdate);
			timerUpdate = setTimeout(function () {
				$box.css({
					'display': $input.css('display'),
					'width': $input.css('width')
				});
				$dropdown.css($.extend(true, {
					left: $input.position().left,
					top: $input.position().top + parseInt($input.css('marginTop')) + parseInt($input[0].offsetHeight),
					marginLeft: $input.css('marginLeft'),
					marginRight: $input.css('marginRight'),
					width: options.dropdownWidth == '100%' ? $input[0].offsetWidth : options.dropdownWidth
				}, options.dropdownStyle));

				if (options.showHint) {
					var style = getComputedStyle($input[0], "");

					$hint[0].style.cssText = style.cssText;

					$hint.css({
						'box-sizing': style.boxSizing,
						borderStyle: 'solid',
						borderCollapse: style.borderCollapse,
						borderLeftWidth: style.borderLeftWidth,
						borderRightWidth: style.borderRightWidth,
						borderTopWidth: style.borderTopWidth,
						borderBottomWidth: style.borderBottomWidth,
						paddingBottom: style.paddingBottom,
						marginBottom: style.marginBottom,
						paddingTop: style.paddingTop,
						marginTop: style.marginTop,
						paddingLeft: style.paddingLeft,
						marginLeft: style.marginLeft,
						paddingRight: style.paddingRight,
						marginRight: style.marginRight,
						maxHeight: style.maxHeight,
						minHeight: style.minHeight,
						maxWidth: style.maxWidth,
						minWidth: style.minWidth,
						width: style.width,
						letterSpacing: style.letterSpacing,
						lineHeight: style.lineHeight,
						outlineWidth: style.outlineWidth,
						fontFamily: style.fontFamily,
						fontVariant: style.fontVariant,
						fontStyle: $input.css('fontStyle'),
						fontSize: $input.css('fontSize'),
						fontWeight: $input.css('fontWeight'),
						flex: style.flex,
						justifyContent: style.justifyContent,
						borderRadius: style.borderRadius,
						'-webkit-box-shadow': 'none',
						'box-shadow': 'none'
					});

					$input.css('font-size', $input.css('fontSize')); // fix bug with em font size

					$hint.innerHeight($input.innerHeight());

					$hint.css($.extend(true, {
						position: 'absolute',
						zIndex: '1',
						borderColor: 'transparent',
						outlineColor: 'transparent',
						left: $input.position().left,
						top: $input.position().top,
						background: $input.css('background')
					}, options.hintStyle));

					// This code is not needed because we are already setting $hint in upper line						
					// 						if( olderBackground !== false ){
					// 							$hint.css('background',olderBackground);
					// 						} else {
					// 							olderBackground = $input.css('background');
					// 						}

					try {
						$input[0].style.setProperty('background', 'transparent', 'important');
					} catch (e) {
						$input.css('background', 'transparent');
					}

					$box.append($hint);
				}
			}, options.timeoutUpdate || 1);
		});

		if ($input.is(':visible')) {
			$input.trigger('updateHelperPosition.xdsoft');
		} else {
			intervalForVisibility = setInterval(function () {
				if ($input.is(':visible')) {
					$input.trigger('updateHelperPosition.xdsoft');
					clearInterval(intervalForVisibility);
				}
			}, 100);
		}

		$(window).on('resize', function () {
			$box.css({
				'width': 'auto'
			});
			$input.trigger('updateHelperPosition.xdsoft');
		});

		$input.on('close.xdsoft', function () {
			if (!iOpen) {
				return;
			}

			$dropdown.hide();

			$hint.val('');

			if (!options.autoselect) {
				$input.val(currentValue);
			}

			iOpen = false;

			//currentInput = false;
		}).on('updateContent.xdsoft', function () {
			var out = renderData.call(options, dataset, $input.val()),
			    hght = 10;

			if (out.length) {
				$input.trigger('open.xdsoft');
			} else {
				$input.trigger('close.xdsoft');
				return;
			}

			$(out).each(function () {
				this.css($.extend(true, {
					paddingLeft: $input.css('paddingLeft'),
					paddingRight: $input.css('paddingRight')
				}, options.itemStyle));
			});

			$dropdown.html(out);

			if (options.visibleHeight) {
				hght = options.visibleHeight;
			} else {
				hght = options.visibleLimit * ((out[0] ? out[0].outerHeight(true) : 0) || options.defaultHeightItem) + 5;
			}

			$dropdown.css('maxHeight', hght + 'px');
		}).on('open.xdsoft', function () {
			if (iOpen) return;

			$dropdown.show();

			iOpen = true;

			//currentInput = $input;
		}).on('destroy.xdsoft', function () {
			$input.removeClass('xdsoft');
			$box.after($input);
			$box.remove();
			clearTimeout(timer1);
			clearTimeout(intervalForVisibility);
			//currentInput = false;
			$input.data('xdsoft_autocomplete', null);
			$input.off('.xdsoft');
		});
	};

	publics = {
		destroy: function destroy() {
			return this.trigger('destroy.xdsoft');
		},
		update: function update() {
			return this.trigger('updateHelperPosition.xdsoft');
		},
		options: function options(_options) {
			if (this.data('autocomplete_options') && $.isPlainObject(_options)) {
				this.data('autocomplete_options', $.extend(true, this.data('autocomplete_options'), _options));
			}
			return this;
		},
		setSource: function setSource(_newsource, id) {
			if (this.data('autocomplete_options') && ($.isPlainObject(_newsource) || $.isFunction(_newsource) || $.isArray(_newsource))) {
				var options = this.data('autocomplete_options'),
				    dataset = this.data('xdsoft_autocomplete'),
				    source = options.source;
				if (id !== undefined && !isNaN(id)) {
					if ($.isPlainObject(_newsource) || $.isArray(_newsource)) {
						source[id] = $.extend(true, $.isArray(_newsource) ? [] : {}, _newsource);
					} else {
						source[id] = _newsource;
					}
				} else {
					if ($.isFunction(_newsource)) {
						this.data('autocomplete_options').source = _newsource;
					} else {
						$.extend(true, source, _newsource);
					}
				}

				collectData.call(options, this.val(), dataset, function (query) {
					processData.call(options, dataset, query);
				});
			}
			return this;
		},
		getSource: function getSource(id) {
			if (this.data('autocomplete_options')) {
				var source = this.data('autocomplete_options').source;
				if (id !== undefined && !isNaN(id) && source[id]) {
					return source[id];
				} else {
					return source;
				}
			}
			return null;
		}
	};

	$.fn.autocomplete = function (_options, _second, _third) {
		if ($.type(_options) === 'string' && publics[_options]) {
			return publics[_options].call(this, _second, _third);
		}
		return this.each(function () {
			var options = $.extend(true, {}, defaultSetting, _options);
			init(this, options);
		});
	};
})(jQuery);

// Ion.RangeSlider | version 2.2.0 | https://github.com/IonDen/ion.rangeSlider
;(function (f) {
	"function" === typeof define && define.amd ? define(["jquery"], function (n) {
		return f(n, document, window, navigator);
	}) : "object" === (typeof exports === 'undefined' ? 'undefined' : _typeof(exports)) ? f(require("jquery"), document, window, navigator) : f(jQuery, document, window, navigator);
})(function (f, n, k, r, p) {
	var t = 0,
	    m = function () {
		var a = r.userAgent,
		    b = /msie\s\d+/i;return 0 < a.search(b) && (a = b.exec(a).toString(), a = a.split(" ")[1], 9 > a) ? (f("html").addClass("lt-ie9"), !0) : !1;
	}();Function.prototype.bind || (Function.prototype.bind = function (a) {
		var b = this,
		    d = [].slice;if ("function" != typeof b) throw new TypeError();var c = d.call(arguments, 1),
		    e = function e() {
			if (this instanceof e) {
				var g = function g() {};g.prototype = b.prototype;var g = new g(),
				    l = b.apply(g, c.concat(d.call(arguments)));return Object(l) === l ? l : g;
			}return b.apply(a, c.concat(d.call(arguments)));
		};return e;
	});Array.prototype.indexOf || (Array.prototype.indexOf = function (a, b) {
		if (null == this) throw new TypeError('"this" is null or not defined');var d = Object(this),
		    c = d.length >>> 0;if (0 === c) return -1;var e = +b || 0;Infinity === Math.abs(e) && (e = 0);if (e >= c) return -1;
		for (e = Math.max(0 <= e ? e : c - Math.abs(e), 0); e < c;) {
			if (e in d && d[e] === a) return e;e++;
		}return -1;
	});var q = function q(a, b, d) {
		this.VERSION = "2.2.0";this.input = a;this.plugin_count = d;this.old_to = this.old_from = this.update_tm = this.calc_count = this.current_plugin = 0;this.raf_id = this.old_min_interval = null;this.no_diapason = this.force_redraw = this.dragging = !1;this.has_tab_index = !0;this.is_update = this.is_key = !1;this.is_start = !0;this.is_click = this.is_resize = this.is_active = this.is_finish = !1;b = b || {};this.$cache = { win: f(k), body: f(n.body),
			input: f(a), cont: null, rs: null, min: null, max: null, from: null, to: null, single: null, bar: null, line: null, s_single: null, s_from: null, s_to: null, shad_single: null, shad_from: null, shad_to: null, edge: null, grid: null, grid_labels: [] };this.coords = { x_gap: 0, x_pointer: 0, w_rs: 0, w_rs_old: 0, w_handle: 0, p_gap: 0, p_gap_left: 0, p_gap_right: 0, p_step: 0, p_pointer: 0, p_handle: 0, p_single_fake: 0, p_single_real: 0, p_from_fake: 0, p_from_real: 0, p_to_fake: 0, p_to_real: 0, p_bar_x: 0, p_bar_w: 0, grid_gap: 0, big_num: 0, big: [], big_w: [], big_p: [], big_x: [] };
		this.labels = { w_min: 0, w_max: 0, w_from: 0, w_to: 0, w_single: 0, p_min: 0, p_max: 0, p_from_fake: 0, p_from_left: 0, p_to_fake: 0, p_to_left: 0, p_single_fake: 0, p_single_left: 0 };var c = this.$cache.input;a = c.prop("value");var e;d = { type: "single", min: 10, max: 100, from: null, to: null, step: 1, min_interval: 0, max_interval: 0, drag_interval: !1, values: [], p_values: [], from_fixed: !1, from_min: null, from_max: null, from_shadow: !1, to_fixed: !1, to_min: null, to_max: null, to_shadow: !1, prettify_enabled: !0, prettify_separator: " ", prettify: null, force_edges: !1,
			keyboard: !0, grid: !1, grid_margin: !0, grid_num: 4, grid_snap: !1, hide_min_max: !1, hide_from_to: !1, prefix: "", postfix: "", max_postfix: "", decorate_both: !0, values_separator: ' \u2014 ', input_values_separator: ";", disable: !1, block: !1, extra_classes: "", scope: null, onStart: null, onChange: null, onFinish: null, onUpdate: null };"INPUT" !== c[0].nodeName && console && console.warn && console.warn("Base element should be <input>!", c[0]);c = { type: c.data("type"), min: c.data("min"), max: c.data("max"), from: c.data("from"), to: c.data("to"), step: c.data("step"),
			min_interval: c.data("minInterval"), max_interval: c.data("maxInterval"), drag_interval: c.data("dragInterval"), values: c.data("values"), from_fixed: c.data("fromFixed"), from_min: c.data("fromMin"), from_max: c.data("fromMax"), from_shadow: c.data("fromShadow"), to_fixed: c.data("toFixed"), to_min: c.data("toMin"), to_max: c.data("toMax"), to_shadow: c.data("toShadow"), prettify_enabled: c.data("prettifyEnabled"), prettify_separator: c.data("prettifySeparator"), force_edges: c.data("forceEdges"), keyboard: c.data("keyboard"),
			grid: c.data("grid"), grid_margin: c.data("gridMargin"), grid_num: c.data("gridNum"), grid_snap: c.data("gridSnap"), hide_min_max: c.data("hideMinMax"), hide_from_to: c.data("hideFromTo"), prefix: c.data("prefix"), postfix: c.data("postfix"), max_postfix: c.data("maxPostfix"), decorate_both: c.data("decorateBoth"), values_separator: c.data("valuesSeparator"), input_values_separator: c.data("inputValuesSeparator"), disable: c.data("disable"), block: c.data("block"), extra_classes: c.data("extraClasses") };c.values = c.values && c.values.split(",");
		for (e in c) {
			c.hasOwnProperty(e) && (c[e] !== p && "" !== c[e] || delete c[e]);
		}a !== p && "" !== a && (a = a.split(c.input_values_separator || b.input_values_separator || ";"), a[0] && a[0] == +a[0] && (a[0] = +a[0]), a[1] && a[1] == +a[1] && (a[1] = +a[1]), b && b.values && b.values.length ? (d.from = a[0] && b.values.indexOf(a[0]), d.to = a[1] && b.values.indexOf(a[1])) : (d.from = a[0] && +a[0], d.to = a[1] && +a[1]));f.extend(d, b);f.extend(d, c);this.options = d;this.update_check = {};this.validate();this.result = { input: this.$cache.input, slider: null, min: this.options.min,
			max: this.options.max, from: this.options.from, from_percent: 0, from_value: null, to: this.options.to, to_percent: 0, to_value: null };this.init();
	};q.prototype = { init: function init(a) {
			this.no_diapason = !1;this.coords.p_step = this.convertToPercent(this.options.step, !0);this.target = "base";this.toggleInput();this.append();this.setMinMax();a ? (this.force_redraw = !0, this.calc(!0), this.callOnUpdate()) : (this.force_redraw = !0, this.calc(!0), this.callOnStart());this.updateScene();
		}, append: function append() {
			this.$cache.input.before('<span class="irs js-irs-' + this.plugin_count + " " + this.options.extra_classes + '"></span>');this.$cache.input.prop("readonly", !0);this.$cache.cont = this.$cache.input.prev();this.result.slider = this.$cache.cont;this.$cache.cont.html('<span class="irs"><span class="irs-line" tabindex="0"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-min">0</span><span class="irs-max">1</span><span class="irs-from">0</span><span class="irs-to">0</span><span class="irs-single">0</span></span><span class="irs-grid"></span><span class="irs-bar"></span>');
			this.$cache.rs = this.$cache.cont.find(".irs");this.$cache.min = this.$cache.cont.find(".irs-min");this.$cache.max = this.$cache.cont.find(".irs-max");this.$cache.from = this.$cache.cont.find(".irs-from");this.$cache.to = this.$cache.cont.find(".irs-to");this.$cache.single = this.$cache.cont.find(".irs-single");this.$cache.bar = this.$cache.cont.find(".irs-bar");this.$cache.line = this.$cache.cont.find(".irs-line");this.$cache.grid = this.$cache.cont.find(".irs-grid");"single" === this.options.type ? (this.$cache.cont.append('<span class="irs-bar-edge"></span><span class="irs-shadow shadow-single"></span><span class="irs-slider single"></span>'), this.$cache.edge = this.$cache.cont.find(".irs-bar-edge"), this.$cache.s_single = this.$cache.cont.find(".single"), this.$cache.from[0].style.visibility = "hidden", this.$cache.to[0].style.visibility = "hidden", this.$cache.shad_single = this.$cache.cont.find(".shadow-single")) : (this.$cache.cont.append('<span class="irs-shadow shadow-from"></span><span class="irs-shadow shadow-to"></span><span class="irs-slider from"></span><span class="irs-slider to"></span>'), this.$cache.s_from = this.$cache.cont.find(".from"), this.$cache.s_to = this.$cache.cont.find(".to"), this.$cache.shad_from = this.$cache.cont.find(".shadow-from"), this.$cache.shad_to = this.$cache.cont.find(".shadow-to"), this.setTopHandler());this.options.hide_from_to && (this.$cache.from[0].style.display = "none", this.$cache.to[0].style.display = "none", this.$cache.single[0].style.display = "none");this.appendGrid();this.options.disable ? (this.appendDisableMask(), this.$cache.input[0].disabled = !0) : (this.$cache.input[0].disabled = !1, this.removeDisableMask(), this.bindEvents());
			this.options.disable || (this.options.block ? this.appendDisableMask() : this.removeDisableMask());this.options.drag_interval && (this.$cache.bar[0].style.cursor = "ew-resize");
		}, setTopHandler: function setTopHandler() {
			var a = this.options.max,
			    b = this.options.to;this.options.from > this.options.min && b === a ? this.$cache.s_from.addClass("type_last") : b < a && this.$cache.s_to.addClass("type_last");
		}, changeLevel: function changeLevel(a) {
			switch (a) {case "single":
					this.coords.p_gap = this.toFixed(this.coords.p_pointer - this.coords.p_single_fake);this.$cache.s_single.addClass("state_hover");
					break;case "from":
					this.coords.p_gap = this.toFixed(this.coords.p_pointer - this.coords.p_from_fake);this.$cache.s_from.addClass("state_hover");this.$cache.s_from.addClass("type_last");this.$cache.s_to.removeClass("type_last");break;case "to":
					this.coords.p_gap = this.toFixed(this.coords.p_pointer - this.coords.p_to_fake);this.$cache.s_to.addClass("state_hover");this.$cache.s_to.addClass("type_last");this.$cache.s_from.removeClass("type_last");break;case "both":
					this.coords.p_gap_left = this.toFixed(this.coords.p_pointer - this.coords.p_from_fake), this.coords.p_gap_right = this.toFixed(this.coords.p_to_fake - this.coords.p_pointer), this.$cache.s_to.removeClass("type_last"), this.$cache.s_from.removeClass("type_last");}
		}, appendDisableMask: function appendDisableMask() {
			this.$cache.cont.append('<span class="irs-disable-mask"></span>');this.$cache.cont.addClass("irs-disabled");
		}, removeDisableMask: function removeDisableMask() {
			this.$cache.cont.remove(".irs-disable-mask");this.$cache.cont.removeClass("irs-disabled");
		}, remove: function remove() {
			this.$cache.cont.remove();this.$cache.cont = null;this.$cache.line.off("keydown.irs_" + this.plugin_count);this.$cache.body.off("touchmove.irs_" + this.plugin_count);this.$cache.body.off("mousemove.irs_" + this.plugin_count);this.$cache.win.off("touchend.irs_" + this.plugin_count);this.$cache.win.off("mouseup.irs_" + this.plugin_count);m && (this.$cache.body.off("mouseup.irs_" + this.plugin_count), this.$cache.body.off("mouseleave.irs_" + this.plugin_count));this.$cache.grid_labels = [];this.coords.big = [];this.coords.big_w = [];this.coords.big_p = [];this.coords.big_x = [];cancelAnimationFrame(this.raf_id);
		}, bindEvents: function bindEvents() {
			if (!this.no_diapason) {
				this.$cache.body.on("touchmove.irs_" + this.plugin_count, this.pointerMove.bind(this));this.$cache.body.on("mousemove.irs_" + this.plugin_count, this.pointerMove.bind(this));this.$cache.win.on("touchend.irs_" + this.plugin_count, this.pointerUp.bind(this));this.$cache.win.on("mouseup.irs_" + this.plugin_count, this.pointerUp.bind(this));this.$cache.line.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click"));
				this.$cache.line.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click"));this.$cache.line.on("focus.irs_" + this.plugin_count, this.pointerFocus.bind(this));this.options.drag_interval && "double" === this.options.type ? (this.$cache.bar.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "both")), this.$cache.bar.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "both"))) : (this.$cache.bar.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.bar.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")));"single" === this.options.type ? (this.$cache.single.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "single")), this.$cache.s_single.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "single")), this.$cache.shad_single.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.single.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "single")), this.$cache.s_single.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "single")), this.$cache.edge.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.shad_single.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click"))) : (this.$cache.single.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, null)), this.$cache.single.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, null)), this.$cache.from.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "from")), this.$cache.s_from.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "from")), this.$cache.to.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "to")), this.$cache.s_to.on("touchstart.irs_" + this.plugin_count, this.pointerDown.bind(this, "to")), this.$cache.shad_from.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.shad_to.on("touchstart.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.from.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "from")), this.$cache.s_from.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "from")), this.$cache.to.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "to")), this.$cache.s_to.on("mousedown.irs_" + this.plugin_count, this.pointerDown.bind(this, "to")), this.$cache.shad_from.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")), this.$cache.shad_to.on("mousedown.irs_" + this.plugin_count, this.pointerClick.bind(this, "click")));if (this.options.keyboard) this.$cache.line.on("keydown.irs_" + this.plugin_count, this.key.bind(this, "keyboard"));m && (this.$cache.body.on("mouseup.irs_" + this.plugin_count, this.pointerUp.bind(this)), this.$cache.body.on("mouseleave.irs_" + this.plugin_count, this.pointerUp.bind(this)));
			}
		}, pointerFocus: function pointerFocus(a) {
			if (!this.target) {
				var b = "single" === this.options.type ? this.$cache.single : this.$cache.from;a = b.offset().left;a += b.width() / 2 - 1;this.pointerClick("single", { preventDefault: function preventDefault() {}, pageX: a });
			}
		}, pointerMove: function pointerMove(a) {
			this.dragging && (this.coords.x_pointer = (a.pageX || a.originalEvent.touches && a.originalEvent.touches[0].pageX) - this.coords.x_gap, this.calc());
		}, pointerUp: function pointerUp(a) {
			this.current_plugin === this.plugin_count && this.is_active && (this.is_active = !1, this.$cache.cont.find(".state_hover").removeClass("state_hover"), this.force_redraw = !0, m && f("*").prop("unselectable", !1), this.updateScene(), this.restoreOriginalMinInterval(), (f.contains(this.$cache.cont[0], a.target) || this.dragging) && this.callOnFinish(), this.dragging = !1);
		}, pointerDown: function pointerDown(a, b) {
			b.preventDefault();var d = b.pageX || b.originalEvent.touches && b.originalEvent.touches[0].pageX;2 !== b.button && ("both" === a && this.setTempMinInterval(), a || (a = this.target || "from"), this.current_plugin = this.plugin_count, this.target = a, this.dragging = this.is_active = !0, this.coords.x_gap = this.$cache.rs.offset().left, this.coords.x_pointer = d - this.coords.x_gap, this.calcPointerPercent(), this.changeLevel(a), m && f("*").prop("unselectable", !0), this.$cache.line.trigger("focus"), this.updateScene());
		}, pointerClick: function pointerClick(a, b) {
			b.preventDefault();var d = b.pageX || b.originalEvent.touches && b.originalEvent.touches[0].pageX;2 !== b.button && (this.current_plugin = this.plugin_count, this.target = a, this.is_click = !0, this.coords.x_gap = this.$cache.rs.offset().left, this.coords.x_pointer = +(d - this.coords.x_gap).toFixed(), this.force_redraw = !0, this.calc(), this.$cache.line.trigger("focus"));
		}, key: function key(a, b) {
			if (!(this.current_plugin !== this.plugin_count || b.altKey || b.ctrlKey || b.shiftKey || b.metaKey)) {
				switch (b.which) {case 83:case 65:case 40:case 37:
						b.preventDefault();this.moveByKey(!1);break;case 87:case 68:case 38:case 39:
						b.preventDefault(), this.moveByKey(!0);}return !0;
			}
		}, moveByKey: function moveByKey(a) {
			var b = this.coords.p_pointer,
			    d = (this.options.max - this.options.min) / 100,
			    d = this.options.step / d;this.coords.x_pointer = this.toFixed(this.coords.w_rs / 100 * (a ? b + d : b - d));this.is_key = !0;this.calc();
		}, setMinMax: function setMinMax() {
			if (this.options) if (this.options.hide_min_max) this.$cache.min[0].style.display = "none", this.$cache.max[0].style.display = "none";else {
				if (this.options.values.length) this.$cache.min.html(this.decorate(this.options.p_values[this.options.min])), this.$cache.max.html(this.decorate(this.options.p_values[this.options.max]));else {
					var a = this._prettify(this.options.min),
					    b = this._prettify(this.options.max);this.result.min_pretty = a;this.result.max_pretty = b;this.$cache.min.html(this.decorate(a, this.options.min));this.$cache.max.html(this.decorate(b, this.options.max));
				}this.labels.w_min = this.$cache.min.outerWidth(!1);
				this.labels.w_max = this.$cache.max.outerWidth(!1);
			}
		}, setTempMinInterval: function setTempMinInterval() {
			var a = this.result.to - this.result.from;null === this.old_min_interval && (this.old_min_interval = this.options.min_interval);this.options.min_interval = a;
		}, restoreOriginalMinInterval: function restoreOriginalMinInterval() {
			null !== this.old_min_interval && (this.options.min_interval = this.old_min_interval, this.old_min_interval = null);
		}, calc: function calc(a) {
			if (this.options) {
				this.calc_count++;if (10 === this.calc_count || a) this.calc_count = 0, this.coords.w_rs = this.$cache.rs.outerWidth(!1), this.calcHandlePercent();if (this.coords.w_rs) {
					this.calcPointerPercent();a = this.getHandleX();"both" === this.target && (this.coords.p_gap = 0, a = this.getHandleX());"click" === this.target && (this.coords.p_gap = this.coords.p_handle / 2, a = this.getHandleX(), this.target = this.options.drag_interval ? "both_one" : this.chooseHandle(a));switch (this.target) {case "base":
							var b = (this.options.max - this.options.min) / 100;a = (this.result.from - this.options.min) / b;b = (this.result.to - this.options.min) / b;this.coords.p_single_real = this.toFixed(a);
							this.coords.p_from_real = this.toFixed(a);this.coords.p_to_real = this.toFixed(b);this.coords.p_single_real = this.checkDiapason(this.coords.p_single_real, this.options.from_min, this.options.from_max);this.coords.p_from_real = this.checkDiapason(this.coords.p_from_real, this.options.from_min, this.options.from_max);this.coords.p_to_real = this.checkDiapason(this.coords.p_to_real, this.options.to_min, this.options.to_max);this.coords.p_single_fake = this.convertToFakePercent(this.coords.p_single_real);this.coords.p_from_fake = this.convertToFakePercent(this.coords.p_from_real);this.coords.p_to_fake = this.convertToFakePercent(this.coords.p_to_real);this.target = null;break;case "single":
							if (this.options.from_fixed) break;this.coords.p_single_real = this.convertToRealPercent(a);this.coords.p_single_real = this.calcWithStep(this.coords.p_single_real);this.coords.p_single_real = this.checkDiapason(this.coords.p_single_real, this.options.from_min, this.options.from_max);this.coords.p_single_fake = this.convertToFakePercent(this.coords.p_single_real);
							break;case "from":
							if (this.options.from_fixed) break;this.coords.p_from_real = this.convertToRealPercent(a);this.coords.p_from_real = this.calcWithStep(this.coords.p_from_real);this.coords.p_from_real > this.coords.p_to_real && (this.coords.p_from_real = this.coords.p_to_real);this.coords.p_from_real = this.checkDiapason(this.coords.p_from_real, this.options.from_min, this.options.from_max);this.coords.p_from_real = this.checkMinInterval(this.coords.p_from_real, this.coords.p_to_real, "from");this.coords.p_from_real = this.checkMaxInterval(this.coords.p_from_real, this.coords.p_to_real, "from");this.coords.p_from_fake = this.convertToFakePercent(this.coords.p_from_real);break;case "to":
							if (this.options.to_fixed) break;this.coords.p_to_real = this.convertToRealPercent(a);this.coords.p_to_real = this.calcWithStep(this.coords.p_to_real);this.coords.p_to_real < this.coords.p_from_real && (this.coords.p_to_real = this.coords.p_from_real);this.coords.p_to_real = this.checkDiapason(this.coords.p_to_real, this.options.to_min, this.options.to_max);
							this.coords.p_to_real = this.checkMinInterval(this.coords.p_to_real, this.coords.p_from_real, "to");this.coords.p_to_real = this.checkMaxInterval(this.coords.p_to_real, this.coords.p_from_real, "to");this.coords.p_to_fake = this.convertToFakePercent(this.coords.p_to_real);break;case "both":
							if (this.options.from_fixed || this.options.to_fixed) break;a = this.toFixed(a + .001 * this.coords.p_handle);this.coords.p_from_real = this.convertToRealPercent(a) - this.coords.p_gap_left;this.coords.p_from_real = this.calcWithStep(this.coords.p_from_real);
							this.coords.p_from_real = this.checkDiapason(this.coords.p_from_real, this.options.from_min, this.options.from_max);this.coords.p_from_real = this.checkMinInterval(this.coords.p_from_real, this.coords.p_to_real, "from");this.coords.p_from_fake = this.convertToFakePercent(this.coords.p_from_real);this.coords.p_to_real = this.convertToRealPercent(a) + this.coords.p_gap_right;this.coords.p_to_real = this.calcWithStep(this.coords.p_to_real);this.coords.p_to_real = this.checkDiapason(this.coords.p_to_real, this.options.to_min, this.options.to_max);this.coords.p_to_real = this.checkMinInterval(this.coords.p_to_real, this.coords.p_from_real, "to");this.coords.p_to_fake = this.convertToFakePercent(this.coords.p_to_real);break;case "both_one":
							if (!this.options.from_fixed && !this.options.to_fixed) {
								var d = this.convertToRealPercent(a);a = this.result.to_percent - this.result.from_percent;var c = a / 2,
								    b = d - c,
								    d = d + c;0 > b && (b = 0, d = b + a);100 < d && (d = 100, b = d - a);this.coords.p_from_real = this.calcWithStep(b);this.coords.p_from_real = this.checkDiapason(this.coords.p_from_real, this.options.from_min, this.options.from_max);this.coords.p_from_fake = this.convertToFakePercent(this.coords.p_from_real);this.coords.p_to_real = this.calcWithStep(d);this.coords.p_to_real = this.checkDiapason(this.coords.p_to_real, this.options.to_min, this.options.to_max);this.coords.p_to_fake = this.convertToFakePercent(this.coords.p_to_real);
							}}"single" === this.options.type ? (this.coords.p_bar_x = this.coords.p_handle / 2, this.coords.p_bar_w = this.coords.p_single_fake, this.result.from_percent = this.coords.p_single_real, this.result.from = this.convertToValue(this.coords.p_single_real), this.result.from_pretty = this._prettify(this.result.from), this.options.values.length && (this.result.from_value = this.options.values[this.result.from])) : (this.coords.p_bar_x = this.toFixed(this.coords.p_from_fake + this.coords.p_handle / 2), this.coords.p_bar_w = this.toFixed(this.coords.p_to_fake - this.coords.p_from_fake), this.result.from_percent = this.coords.p_from_real, this.result.from = this.convertToValue(this.coords.p_from_real), this.result.from_pretty = this._prettify(this.result.from), this.result.to_percent = this.coords.p_to_real, this.result.to = this.convertToValue(this.coords.p_to_real), this.result.to_pretty = this._prettify(this.result.to), this.options.values.length && (this.result.from_value = this.options.values[this.result.from], this.result.to_value = this.options.values[this.result.to]));this.calcMinMax();this.calcLabels();
				}
			}
		}, calcPointerPercent: function calcPointerPercent() {
			this.coords.w_rs ? (0 > this.coords.x_pointer || isNaN(this.coords.x_pointer) ? this.coords.x_pointer = 0 : this.coords.x_pointer > this.coords.w_rs && (this.coords.x_pointer = this.coords.w_rs), this.coords.p_pointer = this.toFixed(this.coords.x_pointer / this.coords.w_rs * 100)) : this.coords.p_pointer = 0;
		}, convertToRealPercent: function convertToRealPercent(a) {
			return a / (100 - this.coords.p_handle) * 100;
		}, convertToFakePercent: function convertToFakePercent(a) {
			return a / 100 * (100 - this.coords.p_handle);
		}, getHandleX: function getHandleX() {
			var a = 100 - this.coords.p_handle,
			    b = this.toFixed(this.coords.p_pointer - this.coords.p_gap);0 > b ? b = 0 : b > a && (b = a);return b;
		}, calcHandlePercent: function calcHandlePercent() {
			this.coords.w_handle = "single" === this.options.type ? this.$cache.s_single.outerWidth(!1) : this.$cache.s_from.outerWidth(!1);this.coords.p_handle = this.toFixed(this.coords.w_handle / this.coords.w_rs * 100);
		}, chooseHandle: function chooseHandle(a) {
			return "single" === this.options.type ? "single" : a >= this.coords.p_from_real + (this.coords.p_to_real - this.coords.p_from_real) / 2 ? this.options.to_fixed ? "from" : "to" : this.options.from_fixed ? "to" : "from";
		}, calcMinMax: function calcMinMax() {
			this.coords.w_rs && (this.labels.p_min = this.labels.w_min / this.coords.w_rs * 100, this.labels.p_max = this.labels.w_max / this.coords.w_rs * 100);
		}, calcLabels: function calcLabels() {
			this.coords.w_rs && !this.options.hide_from_to && ("single" === this.options.type ? (this.labels.w_single = this.$cache.single.outerWidth(!1), this.labels.p_single_fake = this.labels.w_single / this.coords.w_rs * 100, this.labels.p_single_left = this.coords.p_single_fake + this.coords.p_handle / 2 - this.labels.p_single_fake / 2) : (this.labels.w_from = this.$cache.from.outerWidth(!1), this.labels.p_from_fake = this.labels.w_from / this.coords.w_rs * 100, this.labels.p_from_left = this.coords.p_from_fake + this.coords.p_handle / 2 - this.labels.p_from_fake / 2, this.labels.p_from_left = this.toFixed(this.labels.p_from_left), this.labels.p_from_left = this.checkEdges(this.labels.p_from_left, this.labels.p_from_fake), this.labels.w_to = this.$cache.to.outerWidth(!1), this.labels.p_to_fake = this.labels.w_to / this.coords.w_rs * 100, this.labels.p_to_left = this.coords.p_to_fake + this.coords.p_handle / 2 - this.labels.p_to_fake / 2, this.labels.p_to_left = this.toFixed(this.labels.p_to_left), this.labels.p_to_left = this.checkEdges(this.labels.p_to_left, this.labels.p_to_fake), this.labels.w_single = this.$cache.single.outerWidth(!1), this.labels.p_single_fake = this.labels.w_single / this.coords.w_rs * 100, this.labels.p_single_left = (this.labels.p_from_left + this.labels.p_to_left + this.labels.p_to_fake) / 2 - this.labels.p_single_fake / 2, this.labels.p_single_left = this.toFixed(this.labels.p_single_left)), this.labels.p_single_left = this.checkEdges(this.labels.p_single_left, this.labels.p_single_fake));
		}, updateScene: function updateScene() {
			this.raf_id && (cancelAnimationFrame(this.raf_id), this.raf_id = null);clearTimeout(this.update_tm);this.update_tm = null;this.options && (this.drawHandles(), this.is_active ? this.raf_id = requestAnimationFrame(this.updateScene.bind(this)) : this.update_tm = setTimeout(this.updateScene.bind(this), 300));
		}, drawHandles: function drawHandles() {
			this.coords.w_rs = this.$cache.rs.outerWidth(!1);if (this.coords.w_rs) {
				this.coords.w_rs !== this.coords.w_rs_old && (this.target = "base", this.is_resize = !0);if (this.coords.w_rs !== this.coords.w_rs_old || this.force_redraw) this.setMinMax(), this.calc(!0), this.drawLabels(), this.options.grid && (this.calcGridMargin(), this.calcGridLabels()), this.force_redraw = !0, this.coords.w_rs_old = this.coords.w_rs, this.drawShadow();if (this.coords.w_rs && (this.dragging || this.force_redraw || this.is_key)) {
					if (this.old_from !== this.result.from || this.old_to !== this.result.to || this.force_redraw || this.is_key) {
						this.drawLabels();this.$cache.bar[0].style.left = this.coords.p_bar_x + "%";this.$cache.bar[0].style.width = this.coords.p_bar_w + "%";if ("single" === this.options.type) this.$cache.s_single[0].style.left = this.coords.p_single_fake + "%";else {
							this.$cache.s_from[0].style.left = this.coords.p_from_fake + "%";this.$cache.s_to[0].style.left = this.coords.p_to_fake + "%";if (this.old_from !== this.result.from || this.force_redraw) this.$cache.from[0].style.left = this.labels.p_from_left + "%";if (this.old_to !== this.result.to || this.force_redraw) this.$cache.to[0].style.left = this.labels.p_to_left + "%";
						}this.$cache.single[0].style.left = this.labels.p_single_left + "%";this.writeToInput();this.old_from === this.result.from && this.old_to === this.result.to || this.is_start || (this.$cache.input.trigger("change"), this.$cache.input.trigger("input"));this.old_from = this.result.from;this.old_to = this.result.to;this.is_resize || this.is_update || this.is_start || this.is_finish || this.callOnChange();if (this.is_key || this.is_click) this.is_click = this.is_key = !1, this.callOnFinish();this.is_finish = this.is_resize = this.is_update = !1;
					}this.force_redraw = this.is_click = this.is_key = this.is_start = !1;
				}
			}
		}, drawLabels: function drawLabels() {
			if (this.options) {
				var a = this.options.values.length,
				    b = this.options.p_values;if (!this.options.hide_from_to) if ("single" === this.options.type) {
					if (a) a = this.decorate(b[this.result.from]);else {
						var d = this._prettify(this.result.from);a = this.decorate(d, this.result.from);
					}this.$cache.single.html(a);this.calcLabels();this.$cache.min[0].style.visibility = this.labels.p_single_left < this.labels.p_min + 1 ? "hidden" : "visible";this.$cache.max[0].style.visibility = this.labels.p_single_left + this.labels.p_single_fake > 100 - this.labels.p_max - 1 ? "hidden" : "visible";
				} else {
					a ? (this.options.decorate_both ? (a = this.decorate(b[this.result.from]), a += this.options.values_separator, a += this.decorate(b[this.result.to])) : a = this.decorate(b[this.result.from] + this.options.values_separator + b[this.result.to]), d = this.decorate(b[this.result.from]), b = this.decorate(b[this.result.to])) : (d = this._prettify(this.result.from), b = this._prettify(this.result.to), this.options.decorate_both ? (a = this.decorate(d, this.result.from), a += this.options.values_separator, a += this.decorate(b, this.result.to)) : a = this.decorate(d + this.options.values_separator + b, this.result.to), d = this.decorate(d, this.result.from), b = this.decorate(b, this.result.to));this.$cache.single.html(a);this.$cache.from.html(d);this.$cache.to.html(b);this.calcLabels();a = Math.min(this.labels.p_single_left, this.labels.p_from_left);d = this.labels.p_single_left + this.labels.p_single_fake;var b = this.labels.p_to_left + this.labels.p_to_fake,
					    c = Math.max(d, b);this.labels.p_from_left + this.labels.p_from_fake >= this.labels.p_to_left ? (this.$cache.from[0].style.visibility = "hidden", this.$cache.to[0].style.visibility = "hidden", this.$cache.single[0].style.visibility = "visible", this.result.from === this.result.to ? ("from" === this.target ? this.$cache.from[0].style.visibility = "visible" : "to" === this.target ? this.$cache.to[0].style.visibility = "visible" : this.target || (this.$cache.from[0].style.visibility = "visible"), this.$cache.single[0].style.visibility = "hidden", c = b) : (this.$cache.from[0].style.visibility = "hidden", this.$cache.to[0].style.visibility = "hidden", this.$cache.single[0].style.visibility = "visible", c = Math.max(d, b))) : (this.$cache.from[0].style.visibility = "visible", this.$cache.to[0].style.visibility = "visible", this.$cache.single[0].style.visibility = "hidden");this.$cache.min[0].style.visibility = a < this.labels.p_min + 1 ? "hidden" : "visible";this.$cache.max[0].style.visibility = c > 100 - this.labels.p_max - 1 ? "hidden" : "visible";
				}
			}
		}, drawShadow: function drawShadow() {
			var a = this.options,
			    b = this.$cache,
			    d = "number" === typeof a.from_min && !isNaN(a.from_min),
			    c = "number" === typeof a.from_max && !isNaN(a.from_max),
			    e = "number" === typeof a.to_min && !isNaN(a.to_min),
			    g = "number" === typeof a.to_max && !isNaN(a.to_max);
			"single" === a.type ? a.from_shadow && (d || c) ? (d = this.convertToPercent(d ? a.from_min : a.min), c = this.convertToPercent(c ? a.from_max : a.max) - d, d = this.toFixed(d - this.coords.p_handle / 100 * d), c = this.toFixed(c - this.coords.p_handle / 100 * c), d += this.coords.p_handle / 2, b.shad_single[0].style.display = "block", b.shad_single[0].style.left = d + "%", b.shad_single[0].style.width = c + "%") : b.shad_single[0].style.display = "none" : (a.from_shadow && (d || c) ? (d = this.convertToPercent(d ? a.from_min : a.min), c = this.convertToPercent(c ? a.from_max : a.max) - d, d = this.toFixed(d - this.coords.p_handle / 100 * d), c = this.toFixed(c - this.coords.p_handle / 100 * c), d += this.coords.p_handle / 2, b.shad_from[0].style.display = "block", b.shad_from[0].style.left = d + "%", b.shad_from[0].style.width = c + "%") : b.shad_from[0].style.display = "none", a.to_shadow && (e || g) ? (e = this.convertToPercent(e ? a.to_min : a.min), a = this.convertToPercent(g ? a.to_max : a.max) - e, e = this.toFixed(e - this.coords.p_handle / 100 * e), a = this.toFixed(a - this.coords.p_handle / 100 * a), e += this.coords.p_handle / 2, b.shad_to[0].style.display = "block", b.shad_to[0].style.left = e + "%", b.shad_to[0].style.width = a + "%") : b.shad_to[0].style.display = "none");
		}, writeToInput: function writeToInput() {
			"single" === this.options.type ? (this.options.values.length ? this.$cache.input.prop("value", this.result.from_value) : this.$cache.input.prop("value", this.result.from), this.$cache.input.data("from", this.result.from)) : (this.options.values.length ? this.$cache.input.prop("value", this.result.from_value + this.options.input_values_separator + this.result.to_value) : this.$cache.input.prop("value", this.result.from + this.options.input_values_separator + this.result.to), this.$cache.input.data("from", this.result.from), this.$cache.input.data("to", this.result.to));
		}, callOnStart: function callOnStart() {
			this.writeToInput();if (this.options.onStart && "function" === typeof this.options.onStart) if (this.options.scope) this.options.onStart.call(this.options.scope, this.result);else this.options.onStart(this.result);
		}, callOnChange: function callOnChange() {
			this.writeToInput();if (this.options.onChange && "function" === typeof this.options.onChange) if (this.options.scope) this.options.onChange.call(this.options.scope, this.result);else this.options.onChange(this.result);
		}, callOnFinish: function callOnFinish() {
			this.writeToInput();if (this.options.onFinish && "function" === typeof this.options.onFinish) if (this.options.scope) this.options.onFinish.call(this.options.scope, this.result);else this.options.onFinish(this.result);
		}, callOnUpdate: function callOnUpdate() {
			this.writeToInput();if (this.options.onUpdate && "function" === typeof this.options.onUpdate) if (this.options.scope) this.options.onUpdate.call(this.options.scope, this.result);else this.options.onUpdate(this.result);
		},
		toggleInput: function toggleInput() {
			this.$cache.input.toggleClass("irs-hidden-input");this.has_tab_index ? this.$cache.input.prop("tabindex", -1) : this.$cache.input.removeProp("tabindex");this.has_tab_index = !this.has_tab_index;
		}, convertToPercent: function convertToPercent(a, b) {
			var d = this.options.max - this.options.min;return d ? this.toFixed((b ? a : a - this.options.min) / (d / 100)) : (this.no_diapason = !0, 0);
		}, convertToValue: function convertToValue(a) {
			var b = this.options.min,
			    d = this.options.max,
			    c = b.toString().split(".")[1],
			    e = d.toString().split(".")[1],
			    g,
			    l,
			    f = 0,
			    h = 0;
			if (0 === a) return this.options.min;if (100 === a) return this.options.max;c && (f = g = c.length);e && (f = l = e.length);g && l && (f = g >= l ? g : l);0 > b && (h = Math.abs(b), b = +(b + h).toFixed(f), d = +(d + h).toFixed(f));a = (d - b) / 100 * a + b;(b = this.options.step.toString().split(".")[1]) ? a = +a.toFixed(b.length) : (a /= this.options.step, a *= this.options.step, a = +a.toFixed(0));h && (a -= h);h = b ? +a.toFixed(b.length) : this.toFixed(a);h < this.options.min ? h = this.options.min : h > this.options.max && (h = this.options.max);return h;
		}, calcWithStep: function calcWithStep(a) {
			var b = Math.round(a / this.coords.p_step) * this.coords.p_step;100 < b && (b = 100);100 === a && (b = 100);return this.toFixed(b);
		}, checkMinInterval: function checkMinInterval(a, b, d) {
			var c = this.options;if (!c.min_interval) return a;a = this.convertToValue(a);b = this.convertToValue(b);"from" === d ? b - a < c.min_interval && (a = b - c.min_interval) : a - b < c.min_interval && (a = b + c.min_interval);return this.convertToPercent(a);
		}, checkMaxInterval: function checkMaxInterval(a, b, d) {
			var c = this.options;if (!c.max_interval) return a;a = this.convertToValue(a);b = this.convertToValue(b);"from" === d ? b - a > c.max_interval && (a = b - c.max_interval) : a - b > c.max_interval && (a = b + c.max_interval);return this.convertToPercent(a);
		}, checkDiapason: function checkDiapason(a, b, d) {
			a = this.convertToValue(a);var c = this.options;"number" !== typeof b && (b = c.min);"number" !== typeof d && (d = c.max);a < b && (a = b);a > d && (a = d);return this.convertToPercent(a);
		}, toFixed: function toFixed(a) {
			a = a.toFixed(20);return +a;
		}, _prettify: function _prettify(a) {
			return this.options.prettify_enabled ? this.options.prettify && "function" === typeof this.options.prettify ? this.options.prettify(a) : this.prettify(a) : a;
		}, prettify: function prettify(a) {
			return a.toString().replace(/(\d{1,3}(?=(?:\d\d\d)+(?!\d)))/g, "$1" + this.options.prettify_separator);
		}, checkEdges: function checkEdges(a, b) {
			if (!this.options.force_edges) return this.toFixed(a);0 > a ? a = 0 : a > 100 - b && (a = 100 - b);return this.toFixed(a);
		}, validate: function validate() {
			var a = this.options,
			    b = this.result,
			    d = a.values,
			    c = d.length,
			    e;"string" === typeof a.min && (a.min = +a.min);"string" === typeof a.max && (a.max = +a.max);"string" === typeof a.from && (a.from = +a.from);"string" === typeof a.to && (a.to = +a.to);
			"string" === typeof a.step && (a.step = +a.step);"string" === typeof a.from_min && (a.from_min = +a.from_min);"string" === typeof a.from_max && (a.from_max = +a.from_max);"string" === typeof a.to_min && (a.to_min = +a.to_min);"string" === typeof a.to_max && (a.to_max = +a.to_max);"string" === typeof a.grid_num && (a.grid_num = +a.grid_num);a.max < a.min && (a.max = a.min);if (c) for (a.p_values = [], a.min = 0, a.max = c - 1, a.step = 1, a.grid_num = a.max, a.grid_snap = !0, e = 0; e < c; e++) {
				var g = +d[e];isNaN(g) ? g = d[e] : (d[e] = g, g = this._prettify(g));a.p_values.push(g);
			}if ("number" !== typeof a.from || isNaN(a.from)) a.from = a.min;if ("number" !== typeof a.to || isNaN(a.to)) a.to = a.max;"single" === a.type ? (a.from < a.min && (a.from = a.min), a.from > a.max && (a.from = a.max)) : (a.from < a.min && (a.from = a.min), a.from > a.max && (a.from = a.max), a.to < a.min && (a.to = a.min), a.to > a.max && (a.to = a.max), this.update_check.from && (this.update_check.from !== a.from && a.from > a.to && (a.from = a.to), this.update_check.to !== a.to && a.to < a.from && (a.to = a.from)), a.from > a.to && (a.from = a.to), a.to < a.from && (a.to = a.from));if ("number" !== typeof a.step || isNaN(a.step) || !a.step || 0 > a.step) a.step = 1;"number" === typeof a.from_min && a.from < a.from_min && (a.from = a.from_min);"number" === typeof a.from_max && a.from > a.from_max && (a.from = a.from_max);"number" === typeof a.to_min && a.to < a.to_min && (a.to = a.to_min);"number" === typeof a.to_max && a.from > a.to_max && (a.to = a.to_max);if (b) {
				b.min !== a.min && (b.min = a.min);b.max !== a.max && (b.max = a.max);if (b.from < b.min || b.from > b.max) b.from = a.from;if (b.to < b.min || b.to > b.max) b.to = a.to;
			}if ("number" !== typeof a.min_interval || isNaN(a.min_interval) || !a.min_interval || 0 > a.min_interval) a.min_interval = 0;if ("number" !== typeof a.max_interval || isNaN(a.max_interval) || !a.max_interval || 0 > a.max_interval) a.max_interval = 0;a.min_interval && a.min_interval > a.max - a.min && (a.min_interval = a.max - a.min);a.max_interval && a.max_interval > a.max - a.min && (a.max_interval = a.max - a.min);
		}, decorate: function decorate(a, b) {
			var d = "",
			    c = this.options;c.prefix && (d += c.prefix);d += a;c.max_postfix && (c.values.length && a === c.p_values[c.max] ? (d += c.max_postfix, c.postfix && (d += " ")) : b === c.max && (d += c.max_postfix, c.postfix && (d += " ")));c.postfix && (d += c.postfix);return d;
		}, updateFrom: function updateFrom() {
			this.result.from = this.options.from;this.result.from_percent = this.convertToPercent(this.result.from);this.result.from_pretty = this._prettify(this.result.from);this.options.values && (this.result.from_value = this.options.values[this.result.from]);
		}, updateTo: function updateTo() {
			this.result.to = this.options.to;this.result.to_percent = this.convertToPercent(this.result.to);this.result.to_pretty = this._prettify(this.result.to);this.options.values && (this.result.to_value = this.options.values[this.result.to]);
		}, updateResult: function updateResult() {
			this.result.min = this.options.min;this.result.max = this.options.max;this.updateFrom();this.updateTo();
		}, appendGrid: function appendGrid() {
			if (this.options.grid) {
				var a = this.options,
				    b;var d = a.max - a.min;var c = a.grid_num,
				    e = 4,
				    g = "";this.calcGridMargin();if (a.grid_snap) {
					if (50 < d) {
						c = 50 / a.step;var f = this.toFixed(a.step / .5);
					} else c = d / a.step, f = this.toFixed(a.step / (d / 100));
				} else f = this.toFixed(100 / c);4 < c && (e = 3);7 < c && (e = 2);14 < c && (e = 1);28 < c && (e = 0);
				for (d = 0; d < c + 1; d++) {
					var k = e;var h = this.toFixed(f * d);100 < h && (h = 100);this.coords.big[d] = h;var m = (h - f * (d - 1)) / (k + 1);for (b = 1; b <= k && 0 !== h; b++) {
						var n = this.toFixed(h - m * b);g += '<span class="irs-grid-pol small" style="left: ' + n + '%"></span>';
					}g += '<span class="irs-grid-pol" style="left: ' + h + '%"></span>';b = this.convertToValue(h);b = a.values.length ? a.p_values[b] : this._prettify(b);g += '<span class="irs-grid-text js-grid-text-' + d + '" style="left: ' + h + '%">' + b + "</span>";
				}this.coords.big_num = Math.ceil(c + 1);this.$cache.cont.addClass("irs-with-grid");
				this.$cache.grid.html(g);this.cacheGridLabels();
			}
		}, cacheGridLabels: function cacheGridLabels() {
			var a,
			    b = this.coords.big_num;for (a = 0; a < b; a++) {
				var d = this.$cache.grid.find(".js-grid-text-" + a);this.$cache.grid_labels.push(d);
			}this.calcGridLabels();
		}, calcGridLabels: function calcGridLabels() {
			var a;var b = [];var d = [],
			    c = this.coords.big_num;for (a = 0; a < c; a++) {
				this.coords.big_w[a] = this.$cache.grid_labels[a].outerWidth(!1), this.coords.big_p[a] = this.toFixed(this.coords.big_w[a] / this.coords.w_rs * 100), this.coords.big_x[a] = this.toFixed(this.coords.big_p[a] / 2), b[a] = this.toFixed(this.coords.big[a] - this.coords.big_x[a]), d[a] = this.toFixed(b[a] + this.coords.big_p[a]);
			}this.options.force_edges && (b[0] < -this.coords.grid_gap && (b[0] = -this.coords.grid_gap, d[0] = this.toFixed(b[0] + this.coords.big_p[0]), this.coords.big_x[0] = this.coords.grid_gap), d[c - 1] > 100 + this.coords.grid_gap && (d[c - 1] = 100 + this.coords.grid_gap, b[c - 1] = this.toFixed(d[c - 1] - this.coords.big_p[c - 1]), this.coords.big_x[c - 1] = this.toFixed(this.coords.big_p[c - 1] - this.coords.grid_gap)));this.calcGridCollision(2, b, d);this.calcGridCollision(4, b, d);for (a = 0; a < c; a++) {
				b = this.$cache.grid_labels[a][0], this.coords.big_x[a] !== Number.POSITIVE_INFINITY && (b.style.marginLeft = -this.coords.big_x[a] + "%");
			}
		}, calcGridCollision: function calcGridCollision(a, b, d) {
			var c,
			    e = this.coords.big_num;for (c = 0; c < e; c += a) {
				var g = c + a / 2;if (g >= e) break;var f = this.$cache.grid_labels[g][0];f.style.visibility = d[c] <= b[g] ? "visible" : "hidden";
			}
		}, calcGridMargin: function calcGridMargin() {
			this.options.grid_margin && (this.coords.w_rs = this.$cache.rs.outerWidth(!1), this.coords.w_rs && (this.coords.w_handle = "single" === this.options.type ? this.$cache.s_single.outerWidth(!1) : this.$cache.s_from.outerWidth(!1), this.coords.p_handle = this.toFixed(this.coords.w_handle / this.coords.w_rs * 100), this.coords.grid_gap = this.toFixed(this.coords.p_handle / 2 - .1), this.$cache.grid[0].style.width = this.toFixed(100 - this.coords.p_handle) + "%", this.$cache.grid[0].style.left = this.coords.grid_gap + "%"));
		}, update: function update(a) {
			this.input && (this.is_update = !0, this.options.from = this.result.from, this.options.to = this.result.to, this.update_check.from = this.result.from, this.update_check.to = this.result.to, this.options = f.extend(this.options, a), this.validate(), this.updateResult(a), this.toggleInput(), this.remove(), this.init(!0));
		}, reset: function reset() {
			this.input && (this.updateResult(), this.update());
		}, destroy: function destroy() {
			this.input && (this.toggleInput(), this.$cache.input.prop("readonly", !1), f.data(this.input, "ionRangeSlider", null), this.remove(), this.options = this.input = null);
		} };f.fn.ionRangeSlider = function (a) {
		return this.each(function () {
			f.data(this, "ionRangeSlider") || f.data(this, "ionRangeSlider", new q(this, a, t++));
		});
	};(function () {
		for (var a = 0, b = ["ms", "moz", "webkit", "o"], d = 0; d < b.length && !k.requestAnimationFrame; ++d) {
			k.requestAnimationFrame = k[b[d] + "RequestAnimationFrame"], k.cancelAnimationFrame = k[b[d] + "CancelAnimationFrame"] || k[b[d] + "CancelRequestAnimationFrame"];
		}k.requestAnimationFrame || (k.requestAnimationFrame = function (b, d) {
			var c = new Date().getTime(),
			    e = Math.max(0, 16 - (c - a)),
			    f = k.setTimeout(function () {
				b(c + e);
			}, e);a = c + e;return f;
		});k.cancelAnimationFrame || (k.cancelAnimationFrame = function (a) {
			clearTimeout(a);
		});
	})();
});

/*! picturefill - v3.0.2 - 2016-02-12
 * https://scottjehl.github.io/picturefill/
 * Copyright (c) 2016 https://github.com/scottjehl/picturefill/blob/master/Authors.txt; Licensed MIT
 */
!function (a) {
	var b = navigator.userAgent;a.HTMLPictureElement && /ecko/.test(b) && b.match(/rv\:(\d+)/) && RegExp.$1 < 45 && addEventListener("resize", function () {
		var b,
		    c = document.createElement("source"),
		    d = function d(a) {
			var b,
			    d,
			    e = a.parentNode;"PICTURE" === e.nodeName.toUpperCase() ? (b = c.cloneNode(), e.insertBefore(b, e.firstElementChild), setTimeout(function () {
				e.removeChild(b);
			})) : (!a._pfLastSize || a.offsetWidth > a._pfLastSize) && (a._pfLastSize = a.offsetWidth, d = a.sizes, a.sizes += ",100vw", setTimeout(function () {
				a.sizes = d;
			}));
		},
		    e = function e() {
			var a,
			    b = document.querySelectorAll("picture > img, img[srcset][sizes]");for (a = 0; a < b.length; a++) {
				d(b[a]);
			}
		},
		    f = function f() {
			clearTimeout(b), b = setTimeout(e, 99);
		},
		    g = a.matchMedia && matchMedia("(orientation: landscape)"),
		    h = function h() {
			f(), g && g.addListener && g.addListener(f);
		};return c.srcset = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==", /^[c|i]|d$/.test(document.readyState || "") ? h() : document.addEventListener("DOMContentLoaded", h), f;
	}());
}(window), function (a, b, c) {
	"use strict";
	function d(a) {
		return " " === a || "	" === a || "\n" === a || "\f" === a || "\r" === a;
	}function e(b, c) {
		var d = new a.Image();return d.onerror = function () {
			A[b] = !1, ba();
		}, d.onload = function () {
			A[b] = 1 === d.width, ba();
		}, d.src = c, "pending";
	}function f() {
		M = !1, P = a.devicePixelRatio, N = {}, O = {}, s.DPR = P || 1, Q.width = Math.max(a.innerWidth || 0, z.clientWidth), Q.height = Math.max(a.innerHeight || 0, z.clientHeight), Q.vw = Q.width / 100, Q.vh = Q.height / 100, r = [Q.height, Q.width, P].join("-"), Q.em = s.getEmValue(), Q.rem = Q.em;
	}function g(a, b, c, d) {
		var e, f, g, h;return "saveData" === B.algorithm ? a > 2.7 ? h = c + 1 : (f = b - c, e = Math.pow(a - .6, 1.5), g = f * e, d && (g += .1 * e), h = a + g) : h = c > 1 ? Math.sqrt(a * b) : a, h > c;
	}function h(a) {
		var b,
		    c = s.getSet(a),
		    d = !1;"pending" !== c && (d = r, c && (b = s.setRes(c), s.applySetCandidate(b, a))), a[s.ns].evaled = d;
	}function i(a, b) {
		return a.res - b.res;
	}function j(a, b, c) {
		var d;return !c && b && (c = a[s.ns].sets, c = c && c[c.length - 1]), d = k(b, c), d && (b = s.makeUrl(b), a[s.ns].curSrc = b, a[s.ns].curCan = d, d.res || aa(d, d.set.sizes)), d;
	}function k(a, b) {
		var c, d, e;if (a && b) for (e = s.parseSet(b), a = s.makeUrl(a), c = 0; c < e.length; c++) {
			if (a === s.makeUrl(e[c].url)) {
				d = e[c];break;
			}
		}return d;
	}function l(a, b) {
		var c,
		    d,
		    e,
		    f,
		    g = a.getElementsByTagName("source");for (c = 0, d = g.length; d > c; c++) {
			e = g[c], e[s.ns] = !0, f = e.getAttribute("srcset"), f && b.push({ srcset: f, media: e.getAttribute("media"), type: e.getAttribute("type"), sizes: e.getAttribute("sizes") });
		}
	}function m(a, b) {
		function c(b) {
			var c,
			    d = b.exec(a.substring(m));return d ? (c = d[0], m += c.length, c) : void 0;
		}function e() {
			var a,
			    c,
			    d,
			    e,
			    f,
			    i,
			    j,
			    k,
			    l,
			    m = !1,
			    o = {};for (e = 0; e < h.length; e++) {
				f = h[e], i = f[f.length - 1], j = f.substring(0, f.length - 1), k = parseInt(j, 10), l = parseFloat(j), X.test(j) && "w" === i ? ((a || c) && (m = !0), 0 === k ? m = !0 : a = k) : Y.test(j) && "x" === i ? ((a || c || d) && (m = !0), 0 > l ? m = !0 : c = l) : X.test(j) && "h" === i ? ((d || c) && (m = !0), 0 === k ? m = !0 : d = k) : m = !0;
			}m || (o.url = g, a && (o.w = a), c && (o.d = c), d && (o.h = d), d || c || a || (o.d = 1), 1 === o.d && (b.has1x = !0), o.set = b, n.push(o));
		}function f() {
			for (c(T), i = "", j = "in descriptor";;) {
				if (k = a.charAt(m), "in descriptor" === j) {
					if (d(k)) i && (h.push(i), i = "", j = "after descriptor");else {
						if ("," === k) return m += 1, i && h.push(i), void e();if ("(" === k) i += k, j = "in parens";else {
							if ("" === k) return i && h.push(i), void e();i += k;
						}
					}
				} else if ("in parens" === j) {
					if (")" === k) i += k, j = "in descriptor";else {
						if ("" === k) return h.push(i), void e();i += k;
					}
				} else if ("after descriptor" === j) if (d(k)) ;else {
					if ("" === k) return void e();j = "in descriptor", m -= 1;
				}m += 1;
			}
		}for (var g, h, i, j, k, l = a.length, m = 0, n = [];;) {
			if (c(U), m >= l) return n;g = c(V), h = [], "," === g.slice(-1) ? (g = g.replace(W, ""), e()) : f();
		}
	}function n(a) {
		function b(a) {
			function b() {
				f && (g.push(f), f = "");
			}function c() {
				g[0] && (h.push(g), g = []);
			}for (var e, f = "", g = [], h = [], i = 0, j = 0, k = !1;;) {
				if (e = a.charAt(j), "" === e) return b(), c(), h;if (k) {
					if ("*" === e && "/" === a[j + 1]) {
						k = !1, j += 2, b();continue;
					}j += 1;
				} else {
					if (d(e)) {
						if (a.charAt(j - 1) && d(a.charAt(j - 1)) || !f) {
							j += 1;continue;
						}if (0 === i) {
							b(), j += 1;continue;
						}e = " ";
					} else if ("(" === e) i += 1;else if (")" === e) i -= 1;else {
						if ("," === e) {
							b(), c(), j += 1;continue;
						}if ("/" === e && "*" === a.charAt(j + 1)) {
							k = !0, j += 2;continue;
						}
					}f += e, j += 1;
				}
			}
		}function c(a) {
			return k.test(a) && parseFloat(a) >= 0 ? !0 : l.test(a) ? !0 : "0" === a || "-0" === a || "+0" === a ? !0 : !1;
		}var e,
		    f,
		    g,
		    h,
		    i,
		    j,
		    k = /^(?:[+-]?[0-9]+|[0-9]*\.[0-9]+)(?:[eE][+-]?[0-9]+)?(?:ch|cm|em|ex|in|mm|pc|pt|px|rem|vh|vmin|vmax|vw)$/i,
		    l = /^calc\((?:[0-9a-z \.\+\-\*\/\(\)]+)\)$/i;for (f = b(a), g = f.length, e = 0; g > e; e++) {
			if (h = f[e], i = h[h.length - 1], c(i)) {
				if (j = i, h.pop(), 0 === h.length) return j;if (h = h.join(" "), s.matchesMedia(h)) return j;
			}
		}return "100vw";
	}b.createElement("picture");var o,
	    p,
	    q,
	    r,
	    s = {},
	    t = !1,
	    u = function u() {},
	    v = b.createElement("img"),
	    w = v.getAttribute,
	    x = v.setAttribute,
	    y = v.removeAttribute,
	    z = b.documentElement,
	    A = {},
	    B = { algorithm: "" },
	    C = "data-pfsrc",
	    D = C + "set",
	    E = navigator.userAgent,
	    F = /rident/.test(E) || /ecko/.test(E) && E.match(/rv\:(\d+)/) && RegExp.$1 > 35,
	    G = "currentSrc",
	    H = /\s+\+?\d+(e\d+)?w/,
	    I = /(\([^)]+\))?\s*(.+)/,
	    J = a.picturefillCFG,
	    K = "position:absolute;left:0;visibility:hidden;display:block;padding:0;border:none;font-size:1em;width:1em;overflow:hidden;clip:rect(0px, 0px, 0px, 0px)",
	    L = "font-size:100%!important;",
	    M = !0,
	    N = {},
	    O = {},
	    P = a.devicePixelRatio,
	    Q = { px: 1, "in": 96 },
	    R = b.createElement("a"),
	    S = !1,
	    T = /^[ \t\n\r\u000c]+/,
	    U = /^[, \t\n\r\u000c]+/,
	    V = /^[^ \t\n\r\u000c]+/,
	    W = /[,]+$/,
	    X = /^\d+$/,
	    Y = /^-?(?:[0-9]+|[0-9]*\.[0-9]+)(?:[eE][+-]?[0-9]+)?$/,
	    Z = function Z(a, b, c, d) {
		a.addEventListener ? a.addEventListener(b, c, d || !1) : a.attachEvent && a.attachEvent("on" + b, c);
	},
	    $ = function $(a) {
		var b = {};return function (c) {
			return c in b || (b[c] = a(c)), b[c];
		};
	},
	    _ = function () {
		var a = /^([\d\.]+)(em|vw|px)$/,
		    b = function b() {
			for (var a = arguments, b = 0, c = a[0]; ++b in a;) {
				c = c.replace(a[b], a[++b]);
			}return c;
		},
		    c = $(function (a) {
			return "return " + b((a || "").toLowerCase(), /\band\b/g, "&&", /,/g, "||", /min-([a-z-\s]+):/g, "e.$1>=", /max-([a-z-\s]+):/g, "e.$1<=", /calc([^)]+)/g, "($1)", /(\d+[\.]*[\d]*)([a-z]+)/g, "($1 * e.$2)", /^(?!(e.[a-z]|[0-9\.&=|><\+\-\*\(\)\/])).*/gi, "") + ";";
		});return function (b, d) {
			var e;if (!(b in N)) if (N[b] = !1, d && (e = b.match(a))) N[b] = e[1] * Q[e[2]];else try {
				N[b] = new Function("e", c(b))(Q);
			} catch (f) {}return N[b];
		};
	}(),
	    aa = function aa(a, b) {
		return a.w ? (a.cWidth = s.calcListLength(b || "100vw"), a.res = a.w / a.cWidth) : a.res = a.d, a;
	},
	    ba = function ba(a) {
		if (t) {
			var c,
			    d,
			    e,
			    f = a || {};if (f.elements && 1 === f.elements.nodeType && ("IMG" === f.elements.nodeName.toUpperCase() ? f.elements = [f.elements] : (f.context = f.elements, f.elements = null)), c = f.elements || s.qsa(f.context || b, f.reevaluate || f.reselect ? s.sel : s.selShort), e = c.length) {
				for (s.setupRun(f), S = !0, d = 0; e > d; d++) {
					s.fillImg(c[d], f);
				}s.teardownRun(f);
			}
		}
	};o = a.console && console.warn ? function (a) {
		console.warn(a);
	} : u, G in v || (G = "src"), A["image/jpeg"] = !0, A["image/gif"] = !0, A["image/png"] = !0, A["image/svg+xml"] = b.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1"), s.ns = ("pf" + new Date().getTime()).substr(0, 9), s.supSrcset = "srcset" in v, s.supSizes = "sizes" in v, s.supPicture = !!a.HTMLPictureElement, s.supSrcset && s.supPicture && !s.supSizes && !function (a) {
		v.srcset = "data:,a", a.src = "data:,a", s.supSrcset = v.complete === a.complete, s.supPicture = s.supSrcset && s.supPicture;
	}(b.createElement("img")), s.supSrcset && !s.supSizes ? !function () {
		var a = "data:image/gif;base64,R0lGODlhAgABAPAAAP///wAAACH5BAAAAAAALAAAAAACAAEAAAICBAoAOw==",
		    c = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",
		    d = b.createElement("img"),
		    e = function e() {
			var a = d.width;2 === a && (s.supSizes = !0), q = s.supSrcset && !s.supSizes, t = !0, setTimeout(ba);
		};d.onload = e, d.onerror = e, d.setAttribute("sizes", "9px"), d.srcset = c + " 1w," + a + " 9w", d.src = c;
	}() : t = !0, s.selShort = "picture>img,img[srcset]", s.sel = s.selShort, s.cfg = B, s.DPR = P || 1, s.u = Q, s.types = A, s.setSize = u, s.makeUrl = $(function (a) {
		return R.href = a, R.href;
	}), s.qsa = function (a, b) {
		return "querySelector" in a ? a.querySelectorAll(b) : [];
	}, s.matchesMedia = function () {
		return a.matchMedia && (matchMedia("(min-width: 0.1em)") || {}).matches ? s.matchesMedia = function (a) {
			return !a || matchMedia(a).matches;
		} : s.matchesMedia = s.mMQ, s.matchesMedia.apply(this, arguments);
	}, s.mMQ = function (a) {
		return a ? _(a) : !0;
	}, s.calcLength = function (a) {
		var b = _(a, !0) || !1;return 0 > b && (b = !1), b;
	}, s.supportsType = function (a) {
		return a ? A[a] : !0;
	}, s.parseSize = $(function (a) {
		var b = (a || "").match(I);return { media: b && b[1], length: b && b[2] };
	}), s.parseSet = function (a) {
		return a.cands || (a.cands = m(a.srcset, a)), a.cands;
	}, s.getEmValue = function () {
		var a;if (!p && (a = b.body)) {
			var c = b.createElement("div"),
			    d = z.style.cssText,
			    e = a.style.cssText;c.style.cssText = K, z.style.cssText = L, a.style.cssText = L, a.appendChild(c), p = c.offsetWidth, a.removeChild(c), p = parseFloat(p, 10), z.style.cssText = d, a.style.cssText = e;
		}return p || 16;
	}, s.calcListLength = function (a) {
		if (!(a in O) || B.uT) {
			var b = s.calcLength(n(a));O[a] = b ? b : Q.width;
		}return O[a];
	}, s.setRes = function (a) {
		var b;if (a) {
			b = s.parseSet(a);for (var c = 0, d = b.length; d > c; c++) {
				aa(b[c], a.sizes);
			}
		}return b;
	}, s.setRes.res = aa, s.applySetCandidate = function (a, b) {
		if (a.length) {
			var c,
			    d,
			    e,
			    f,
			    h,
			    k,
			    l,
			    m,
			    n,
			    o = b[s.ns],
			    p = s.DPR;if (k = o.curSrc || b[G], l = o.curCan || j(b, k, a[0].set), l && l.set === a[0].set && (n = F && !b.complete && l.res - .1 > p, n || (l.cached = !0, l.res >= p && (h = l))), !h) for (a.sort(i), f = a.length, h = a[f - 1], d = 0; f > d; d++) {
				if (c = a[d], c.res >= p) {
					e = d - 1, h = a[e] && (n || k !== s.makeUrl(c.url)) && g(a[e].res, c.res, p, a[e].cached) ? a[e] : c;break;
				}
			}h && (m = s.makeUrl(h.url), o.curSrc = m, o.curCan = h, m !== k && s.setSrc(b, h), s.setSize(b));
		}
	}, s.setSrc = function (a, b) {
		var c;a.src = b.url, "image/svg+xml" === b.set.type && (c = a.style.width, a.style.width = a.offsetWidth + 1 + "px", a.offsetWidth + 1 && (a.style.width = c));
	}, s.getSet = function (a) {
		var b,
		    c,
		    d,
		    e = !1,
		    f = a[s.ns].sets;for (b = 0; b < f.length && !e; b++) {
			if (c = f[b], c.srcset && s.matchesMedia(c.media) && (d = s.supportsType(c.type))) {
				"pending" === d && (c = d), e = c;break;
			}
		}return e;
	}, s.parseSets = function (a, b, d) {
		var e,
		    f,
		    g,
		    h,
		    i = b && "PICTURE" === b.nodeName.toUpperCase(),
		    j = a[s.ns];(j.src === c || d.src) && (j.src = w.call(a, "src"), j.src ? x.call(a, C, j.src) : y.call(a, C)), (j.srcset === c || d.srcset || !s.supSrcset || a.srcset) && (e = w.call(a, "srcset"), j.srcset = e, h = !0), j.sets = [], i && (j.pic = !0, l(b, j.sets)), j.srcset ? (f = { srcset: j.srcset, sizes: w.call(a, "sizes") }, j.sets.push(f), g = (q || j.src) && H.test(j.srcset || ""), g || !j.src || k(j.src, f) || f.has1x || (f.srcset += ", " + j.src, f.cands.push({ url: j.src, d: 1, set: f }))) : j.src && j.sets.push({ srcset: j.src, sizes: null }), j.curCan = null, j.curSrc = c, j.supported = !(i || f && !s.supSrcset || g && !s.supSizes), h && s.supSrcset && !j.supported && (e ? (x.call(a, D, e), a.srcset = "") : y.call(a, D)), j.supported && !j.srcset && (!j.src && a.src || a.src !== s.makeUrl(j.src)) && (null === j.src ? a.removeAttribute("src") : a.src = j.src), j.parsed = !0;
	}, s.fillImg = function (a, b) {
		var c,
		    d = b.reselect || b.reevaluate;a[s.ns] || (a[s.ns] = {}), c = a[s.ns], (d || c.evaled !== r) && ((!c.parsed || b.reevaluate) && s.parseSets(a, a.parentNode, b), c.supported ? c.evaled = r : h(a));
	}, s.setupRun = function () {
		(!S || M || P !== a.devicePixelRatio) && f();
	}, s.supPicture ? (ba = u, s.fillImg = u) : !function () {
		var c,
		    d = a.attachEvent ? /d$|^c/ : /d$|^c|^i/,
		    e = function e() {
			var a = b.readyState || "";f = setTimeout(e, "loading" === a ? 200 : 999), b.body && (s.fillImgs(), c = c || d.test(a), c && clearTimeout(f));
		},
		    f = setTimeout(e, b.body ? 9 : 99),
		    g = function g(a, b) {
			var c,
			    d,
			    e = function e() {
				var f = new Date() - d;b > f ? c = setTimeout(e, b - f) : (c = null, a());
			};return function () {
				d = new Date(), c || (c = setTimeout(e, b));
			};
		},
		    h = z.clientHeight,
		    i = function i() {
			M = Math.max(a.innerWidth || 0, z.clientWidth) !== Q.width || z.clientHeight !== h, h = z.clientHeight, M && s.fillImgs();
		};Z(a, "resize", g(i, 99)), Z(b, "readystatechange", e);
	}(), s.picturefill = ba, s.fillImgs = ba, s.teardownRun = u, ba._ = s, a.picturefillCFG = { pf: s, push: function push(a) {
			var b = a.shift();"function" == typeof s[b] ? s[b].apply(s, a) : (B[b] = a[0], S && s.fillImgs({ reselect: !0 }));
		} };for (; J && J.length;) {
		a.picturefillCFG.push(J.shift());
	}a.picturefill = ba, "object" == (typeof module === 'undefined' ? 'undefined' : _typeof(module)) && "object" == _typeof(module.exports) ? module.exports = ba : "function" == typeof define && define.amd && define("picturefill", function () {
		return ba;
	}), s.supPicture || (A["image/webp"] = e("image/webp", "data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA=="));
}(window, document);
/*! lightslider - v1.1.6 - 2016-10-25
* https://github.com/sachinchoolur/lightslider
* Copyright (c) 2016 Sachin N; Licensed MIT */
!function (a, b) {
	"use strict";
	var c = { item: 3, autoWidth: !1, slideMove: 1, slideMargin: 10, addClass: "", mode: "slide", useCSS: !0, cssEasing: "ease", easing: "linear", speed: 400, auto: !1, pauseOnHover: !1, loop: !1, slideEndAnimation: !0, pause: 2e3, keyPress: !1, controls: !0, prevHtml: "", nextHtml: "", rtl: !1, adaptiveHeight: !1, vertical: !1, verticalHeight: 500, vThumbWidth: 100, thumbItem: 10, pager: !0, gallery: !1, galleryMargin: 5, thumbMargin: 5, currentPagerPosition: "middle", enableTouch: !0, enableDrag: !0, freeMove: !0, swipeThreshold: 40, responsive: [], onBeforeStart: function onBeforeStart(a) {}, onSliderLoad: function onSliderLoad(a) {}, onBeforeSlide: function onBeforeSlide(a, b) {}, onAfterSlide: function onAfterSlide(a, b) {}, onBeforeNextSlide: function onBeforeNextSlide(a, b) {}, onBeforePrevSlide: function onBeforePrevSlide(a, b) {} };a.fn.lightSlider = function (b) {
		if (0 === this.length) return this;if (this.length > 1) return this.each(function () {
			a(this).lightSlider(b);
		}), this;var d = {},
		    e = a.extend(!0, {}, c, b),
		    f = {},
		    g = this;d.$el = this, "fade" === e.mode && (e.vertical = !1);var h = g.children(),
		    i = a(window).width(),
		    j = null,
		    k = null,
		    l = 0,
		    m = 0,
		    n = !1,
		    o = 0,
		    p = "",
		    q = 0,
		    r = e.vertical === !0 ? "height" : "width",
		    s = e.vertical === !0 ? "margin-bottom" : "margin-right",
		    t = 0,
		    u = 0,
		    v = 0,
		    w = 0,
		    x = null,
		    y = "ontouchstart" in document.documentElement,
		    z = {};return z.chbreakpoint = function () {
			if (i = a(window).width(), e.responsive.length) {
				var b;if (e.autoWidth === !1 && (b = e.item), i < e.responsive[0].breakpoint) for (var c = 0; c < e.responsive.length; c++) {
					i < e.responsive[c].breakpoint && (j = e.responsive[c].breakpoint, k = e.responsive[c]);
				}if ("undefined" != typeof k && null !== k) for (var d in k.settings) {
					k.settings.hasOwnProperty(d) && (("undefined" == typeof f[d] || null === f[d]) && (f[d] = e[d]), e[d] = k.settings[d]);
				}if (!a.isEmptyObject(f) && i > e.responsive[0].breakpoint) for (var g in f) {
					f.hasOwnProperty(g) && (e[g] = f[g]);
				}e.autoWidth === !1 && t > 0 && v > 0 && b !== e.item && (q = Math.round(t / ((v + e.slideMargin) * e.slideMove)));
			}
		}, z.calSW = function () {
			e.autoWidth === !1 && (v = (o - (e.item * e.slideMargin - e.slideMargin)) / e.item);
		}, z.calWidth = function (a) {
			var b = a === !0 ? p.find(".lslide").length : h.length;if (e.autoWidth === !1) m = b * (v + e.slideMargin);else {
				m = 0;for (var c = 0; b > c; c++) {
					m += parseInt(h.eq(c).width()) + e.slideMargin;
				}
			}return m;
		}, d = { doCss: function doCss() {
				var a = function a() {
					for (var a = ["transition", "MozTransition", "WebkitTransition", "OTransition", "msTransition", "KhtmlTransition"], b = document.documentElement, c = 0; c < a.length; c++) {
						if (a[c] in b.style) return !0;
					}
				};return e.useCSS && a() ? !0 : !1;
			}, keyPress: function keyPress() {
				e.keyPress && a(document).on("keyup.lightslider", function (b) {
					a(":focus").is("input, textarea") || (b.preventDefault ? b.preventDefault() : b.returnValue = !1, 37 === b.keyCode ? g.goToPrevSlide() : 39 === b.keyCode && g.goToNextSlide());
				});
			}, controls: function controls() {
				e.controls && (g.after('<div class="lSAction"><a class="lSPrev">' + e.prevHtml + '</a><a class="lSNext">' + e.nextHtml + "</a></div>"), e.autoWidth ? z.calWidth(!1) < o && p.find(".lSAction").hide() : l <= e.item && p.find(".lSAction").hide(), p.find(".lSAction a").on("click", function (b) {
					return b.preventDefault ? b.preventDefault() : b.returnValue = !1, "lSPrev" === a(this).attr("class") ? g.goToPrevSlide() : g.goToNextSlide(), !1;
				}));
			}, initialStyle: function initialStyle() {
				var a = this;"fade" === e.mode && (e.autoWidth = !1, e.slideEndAnimation = !1), e.auto && (e.slideEndAnimation = !1), e.autoWidth && (e.slideMove = 1, e.item = 1), e.loop && (e.slideMove = 1, e.freeMove = !1), e.onBeforeStart.call(this, g), z.chbreakpoint(), g.addClass("lightSlider").wrap('<div class="lSSlideOuter ' + e.addClass + '"><div class="lSSlideWrapper"></div></div>'), p = g.parent(".lSSlideWrapper"), e.rtl === !0 && p.parent().addClass("lSrtl"), e.vertical ? (p.parent().addClass("vertical"), o = e.verticalHeight, p.css("height", o + "px")) : o = g.outerWidth(), h.addClass("lslide"), e.loop === !0 && "slide" === e.mode && (z.calSW(), z.clone = function () {
					if (z.calWidth(!0) > o) {
						for (var b = 0, c = 0, d = 0; d < h.length && (b += parseInt(g.find(".lslide").eq(d).width()) + e.slideMargin, c++, !(b >= o + e.slideMargin)); d++) {}var f = e.autoWidth === !0 ? c : e.item;if (f < g.find(".clone.left").length) for (var i = 0; i < g.find(".clone.left").length - f; i++) {
							h.eq(i).remove();
						}if (f < g.find(".clone.right").length) for (var j = h.length - 1; j > h.length - 1 - g.find(".clone.right").length; j--) {
							q--, h.eq(j).remove();
						}for (var k = g.find(".clone.right").length; f > k; k++) {
							g.find(".lslide").eq(k).clone().removeClass("lslide").addClass("clone right").appendTo(g), q++;
						}for (var l = g.find(".lslide").length - g.find(".clone.left").length; l > g.find(".lslide").length - f; l--) {
							g.find(".lslide").eq(l - 1).clone().removeClass("lslide").addClass("clone left").prependTo(g);
						}h = g.children();
					} else h.hasClass("clone") && (g.find(".clone").remove(), a.move(g, 0));
				}, z.clone()), z.sSW = function () {
					l = h.length, e.rtl === !0 && e.vertical === !1 && (s = "margin-left"), e.autoWidth === !1 && h.css(r, v + "px"), h.css(s, e.slideMargin + "px"), m = z.calWidth(!1), g.css(r, m + "px"), e.loop === !0 && "slide" === e.mode && n === !1 && (q = g.find(".clone.left").length);
				}, z.calL = function () {
					h = g.children(), l = h.length;
				}, this.doCss() && p.addClass("usingCss"), z.calL(), "slide" === e.mode ? (z.calSW(), z.sSW(), e.loop === !0 && (t = a.slideValue(), this.move(g, t)), e.vertical === !1 && this.setHeight(g, !1)) : (this.setHeight(g, !0), g.addClass("lSFade"), this.doCss() || (h.fadeOut(0), h.eq(q).fadeIn(0))), e.loop === !0 && "slide" === e.mode ? h.eq(q).addClass("active") : h.first().addClass("active");
			}, pager: function pager() {
				var a = this;if (z.createPager = function () {
					w = (o - (e.thumbItem * e.thumbMargin - e.thumbMargin)) / e.thumbItem;var b = p.find(".lslide"),
					    c = p.find(".lslide").length,
					    d = 0,
					    f = "",
					    h = 0;for (d = 0; c > d; d++) {
						"slide" === e.mode && (e.autoWidth ? h += (parseInt(b.eq(d).width()) + e.slideMargin) * e.slideMove : h = d * (v + e.slideMargin) * e.slideMove);var i = b.eq(d * e.slideMove).attr("data-thumb");if (f += e.gallery === !0 ? '<li style="width:100%;' + r + ":" + w + "px;" + s + ":" + e.thumbMargin + 'px"><a href="#"><img src="' + i + '" /></a></li>' : '<li><a href="#">' + (d + 1) + "</a></li>", "slide" === e.mode && h >= m - o - e.slideMargin) {
							d += 1;var j = 2;e.autoWidth && (f += '<li><a href="#">' + (d + 1) + "</a></li>", j = 1), j > d ? (f = null, p.parent().addClass("noPager")) : p.parent().removeClass("noPager");break;
						}
					}var k = p.parent();k.find(".lSPager").html(f), e.gallery === !0 && (e.vertical === !0 && k.find(".lSPager").css("width", e.vThumbWidth + "px"), u = d * (e.thumbMargin + w) + .5, k.find(".lSPager").css({ property: u + "px", "transition-duration": e.speed + "ms" }), e.vertical === !0 && p.parent().css("padding-right", e.vThumbWidth + e.galleryMargin + "px"), k.find(".lSPager").css(r, u + "px"));var l = k.find(".lSPager").find("li");l.first().addClass("active"), l.on("click", function () {
						return e.loop === !0 && "slide" === e.mode ? q += l.index(this) - k.find(".lSPager").find("li.active").index() : q = l.index(this), g.mode(!1), e.gallery === !0 && a.slideThumb(), !1;
					});
				}, e.pager) {
					var b = "lSpg";e.gallery && (b = "lSGallery"), p.after('<ul class="lSPager ' + b + '"></ul>');var c = e.vertical ? "margin-left" : "margin-top";p.parent().find(".lSPager").css(c, e.galleryMargin + "px"), z.createPager();
				}setTimeout(function () {
					z.init();
				}, 0);
			}, setHeight: function setHeight(a, b) {
				var c = null,
				    d = this;c = e.loop ? a.children(".lslide ").first() : a.children().first();var f = function f() {
					var d = c.outerHeight(),
					    e = 0,
					    f = d;b && (d = 0, e = 100 * f / o), a.css({ height: d + "px", "padding-bottom": e + "%" });
				};f(), c.find("img").length ? c.find("img")[0].complete ? (f(), x || d.auto()) : c.find("img").on("load", function () {
					setTimeout(function () {
						f(), x || d.auto();
					}, 100);
				}) : x || d.auto();
			}, active: function active(a, b) {
				this.doCss() && "fade" === e.mode && p.addClass("on");var c = 0;if (q * e.slideMove < l) {
					a.removeClass("active"), this.doCss() || "fade" !== e.mode || b !== !1 || a.fadeOut(e.speed), c = b === !0 ? q : q * e.slideMove;var d, f;b === !0 && (d = a.length, f = d - 1, c + 1 >= d && (c = f)), e.loop === !0 && "slide" === e.mode && (c = b === !0 ? q - g.find(".clone.left").length : q * e.slideMove, b === !0 && (d = a.length, f = d - 1, c + 1 === d ? c = f : c + 1 > d && (c = 0))), this.doCss() || "fade" !== e.mode || b !== !1 || a.eq(c).fadeIn(e.speed), a.eq(c).addClass("active");
				} else a.removeClass("active"), a.eq(a.length - 1).addClass("active"), this.doCss() || "fade" !== e.mode || b !== !1 || (a.fadeOut(e.speed), a.eq(c).fadeIn(e.speed));
			}, move: function move(a, b) {
				e.rtl === !0 && (b = -b), this.doCss() ? a.css(e.vertical === !0 ? { transform: "translate3d(0px, " + -b + "px, 0px)", "-webkit-transform": "translate3d(0px, " + -b + "px, 0px)" } : { transform: "translate3d(" + -b + "px, 0px, 0px)", "-webkit-transform": "translate3d(" + -b + "px, 0px, 0px)" }) : e.vertical === !0 ? a.css("position", "relative").animate({ top: -b + "px" }, e.speed, e.easing) : a.css("position", "relative").animate({ left: -b + "px" }, e.speed, e.easing);var c = p.parent().find(".lSPager").find("li");this.active(c, !0);
			}, fade: function fade() {
				this.active(h, !1);var a = p.parent().find(".lSPager").find("li");this.active(a, !0);
			}, slide: function slide() {
				var a = this;z.calSlide = function () {
					m > o && (t = a.slideValue(), a.active(h, !1), t > m - o - e.slideMargin ? t = m - o - e.slideMargin : 0 > t && (t = 0), a.move(g, t), e.loop === !0 && "slide" === e.mode && (q >= l - g.find(".clone.left").length / e.slideMove && a.resetSlide(g.find(".clone.left").length), 0 === q && a.resetSlide(p.find(".lslide").length)));
				}, z.calSlide();
			}, resetSlide: function resetSlide(a) {
				var b = this;p.find(".lSAction a").addClass("disabled"), setTimeout(function () {
					q = a, p.css("transition-duration", "0ms"), t = b.slideValue(), b.active(h, !1), d.move(g, t), setTimeout(function () {
						p.css("transition-duration", e.speed + "ms"), p.find(".lSAction a").removeClass("disabled");
					}, 50);
				}, e.speed + 100);
			}, slideValue: function slideValue() {
				var a = 0;if (e.autoWidth === !1) a = q * (v + e.slideMargin) * e.slideMove;else {
					a = 0;for (var b = 0; q > b; b++) {
						a += parseInt(h.eq(b).width()) + e.slideMargin;
					}
				}return a;
			}, slideThumb: function slideThumb() {
				var a;switch (e.currentPagerPosition) {case "left":
						a = 0;break;case "middle":
						a = o / 2 - w / 2;break;case "right":
						a = o - w;}var b = q - g.find(".clone.left").length,
				    c = p.parent().find(".lSPager");"slide" === e.mode && e.loop === !0 && (b >= c.children().length ? b = 0 : 0 > b && (b = c.children().length));var d = b * (w + e.thumbMargin) - a;d + o > u && (d = u - o - e.thumbMargin), 0 > d && (d = 0), this.move(c, d);
			}, auto: function auto() {
				e.auto && (clearInterval(x), x = setInterval(function () {
					g.goToNextSlide();
				}, e.pause));
			}, pauseOnHover: function pauseOnHover() {
				var b = this;e.auto && e.pauseOnHover && (p.on("mouseenter", function () {
					a(this).addClass("ls-hover"), g.pause(), e.auto = !0;
				}), p.on("mouseleave", function () {
					a(this).removeClass("ls-hover"), p.find(".lightSlider").hasClass("lsGrabbing") || b.auto();
				}));
			}, touchMove: function touchMove(a, b) {
				if (p.css("transition-duration", "0ms"), "slide" === e.mode) {
					var c = a - b,
					    d = t - c;if (d >= m - o - e.slideMargin) {
						if (e.freeMove === !1) d = m - o - e.slideMargin;else {
							var f = m - o - e.slideMargin;d = f + (d - f) / 5;
						}
					} else 0 > d && (e.freeMove === !1 ? d = 0 : d /= 5);this.move(g, d);
				}
			}, touchEnd: function touchEnd(a) {
				if (p.css("transition-duration", e.speed + "ms"), "slide" === e.mode) {
					var b = !1,
					    c = !0;t -= a, t > m - o - e.slideMargin ? (t = m - o - e.slideMargin, e.autoWidth === !1 && (b = !0)) : 0 > t && (t = 0);var d = function d(a) {
						var c = 0;if (b || a && (c = 1), e.autoWidth) for (var d = 0, f = 0; f < h.length && (d += parseInt(h.eq(f).width()) + e.slideMargin, q = f + c, !(d >= t)); f++) {} else {
							var g = t / ((v + e.slideMargin) * e.slideMove);q = parseInt(g) + c, t >= m - o - e.slideMargin && g % 1 !== 0 && q++;
						}
					};a >= e.swipeThreshold ? (d(!1), c = !1) : a <= -e.swipeThreshold && (d(!0), c = !1), g.mode(c), this.slideThumb();
				} else a >= e.swipeThreshold ? g.goToPrevSlide() : a <= -e.swipeThreshold && g.goToNextSlide();
			}, enableDrag: function enableDrag() {
				var b = this;if (!y) {
					var c = 0,
					    d = 0,
					    f = !1;p.find(".lightSlider").addClass("lsGrab"), p.on("mousedown", function (b) {
						return o > m && 0 !== m ? !1 : void ("lSPrev" !== a(b.target).attr("class") && "lSNext" !== a(b.target).attr("class") && (c = e.vertical === !0 ? b.pageY : b.pageX, f = !0, b.preventDefault ? b.preventDefault() : b.returnValue = !1, p.scrollLeft += 1, p.scrollLeft -= 1, p.find(".lightSlider").removeClass("lsGrab").addClass("lsGrabbing"), clearInterval(x)));
					}), a(window).on("mousemove", function (a) {
						f && (d = e.vertical === !0 ? a.pageY : a.pageX, b.touchMove(d, c));
					}), a(window).on("mouseup", function (g) {
						if (f) {
							p.find(".lightSlider").removeClass("lsGrabbing").addClass("lsGrab"), f = !1, d = e.vertical === !0 ? g.pageY : g.pageX;var h = d - c;Math.abs(h) >= e.swipeThreshold && a(window).on("click.ls", function (b) {
								b.preventDefault ? b.preventDefault() : b.returnValue = !1, b.stopImmediatePropagation(), b.stopPropagation(), a(window).off("click.ls");
							}), b.touchEnd(h);
						}
					});
				}
			}, enableTouch: function enableTouch() {
				var a = this;if (y) {
					var b = {},
					    c = {};p.on("touchstart", function (a) {
						c = a.originalEvent.targetTouches[0], b.pageX = a.originalEvent.targetTouches[0].pageX, b.pageY = a.originalEvent.targetTouches[0].pageY, clearInterval(x);
					}), p.on("touchmove", function (d) {
						if (o > m && 0 !== m) return !1;var f = d.originalEvent;c = f.targetTouches[0];var g = Math.abs(c.pageX - b.pageX),
						    h = Math.abs(c.pageY - b.pageY);e.vertical === !0 ? (3 * h > g && d.preventDefault(), a.touchMove(c.pageY, b.pageY)) : (3 * g > h && d.preventDefault(), a.touchMove(c.pageX, b.pageX));
					}), p.on("touchend", function () {
						if (o > m && 0 !== m) return !1;var d;d = e.vertical === !0 ? c.pageY - b.pageY : c.pageX - b.pageX, a.touchEnd(d);
					});
				}
			}, build: function build() {
				var b = this;b.initialStyle(), this.doCss() && (e.enableTouch === !0 && b.enableTouch(), e.enableDrag === !0 && b.enableDrag()), a(window).on("focus", function () {
					b.auto();
				}), a(window).on("blur", function () {
					clearInterval(x);
				}), b.pager(), b.pauseOnHover(), b.controls(), b.keyPress();
			} }, d.build(), z.init = function () {
			z.chbreakpoint(), e.vertical === !0 ? (o = e.item > 1 ? e.verticalHeight : h.outerHeight(), p.css("height", o + "px")) : o = p.outerWidth(), e.loop === !0 && "slide" === e.mode && z.clone(), z.calL(), "slide" === e.mode && g.removeClass("lSSlide"), "slide" === e.mode && (z.calSW(), z.sSW()), setTimeout(function () {
				"slide" === e.mode && g.addClass("lSSlide");
			}, 1e3), e.pager && z.createPager(), e.adaptiveHeight === !0 && e.vertical === !1 && g.css("height", h.eq(q).outerHeight(!0)), e.adaptiveHeight === !1 && ("slide" === e.mode ? e.vertical === !1 ? d.setHeight(g, !1) : d.auto() : d.setHeight(g, !0)), e.gallery === !0 && d.slideThumb(), "slide" === e.mode && d.slide(), e.autoWidth === !1 ? h.length <= e.item ? p.find(".lSAction").hide() : p.find(".lSAction").show() : z.calWidth(!1) < o && 0 !== m ? p.find(".lSAction").hide() : p.find(".lSAction").show();
		}, g.goToPrevSlide = function () {
			if (q > 0) e.onBeforePrevSlide.call(this, g, q), q--, g.mode(!1), e.gallery === !0 && d.slideThumb();else if (e.loop === !0) {
				if (e.onBeforePrevSlide.call(this, g, q), "fade" === e.mode) {
					var a = l - 1;q = parseInt(a / e.slideMove);
				}g.mode(!1), e.gallery === !0 && d.slideThumb();
			} else e.slideEndAnimation === !0 && (g.addClass("leftEnd"), setTimeout(function () {
				g.removeClass("leftEnd");
			}, 400));
		}, g.goToNextSlide = function () {
			var a = !0;if ("slide" === e.mode) {
				var b = d.slideValue();a = b < m - o - e.slideMargin;
			}q * e.slideMove < l - e.slideMove && a ? (e.onBeforeNextSlide.call(this, g, q), q++, g.mode(!1), e.gallery === !0 && d.slideThumb()) : e.loop === !0 ? (e.onBeforeNextSlide.call(this, g, q), q = 0, g.mode(!1), e.gallery === !0 && d.slideThumb()) : e.slideEndAnimation === !0 && (g.addClass("rightEnd"), setTimeout(function () {
				g.removeClass("rightEnd");
			}, 400));
		}, g.mode = function (a) {
			e.adaptiveHeight === !0 && e.vertical === !1 && g.css("height", h.eq(q).outerHeight(!0)), n === !1 && ("slide" === e.mode ? d.doCss() && (g.addClass("lSSlide"), "" !== e.speed && p.css("transition-duration", e.speed + "ms"), "" !== e.cssEasing && p.css("transition-timing-function", e.cssEasing)) : d.doCss() && ("" !== e.speed && g.css("transition-duration", e.speed + "ms"), "" !== e.cssEasing && g.css("transition-timing-function", e.cssEasing))), a || e.onBeforeSlide.call(this, g, q), "slide" === e.mode ? d.slide() : d.fade(), p.hasClass("ls-hover") || d.auto(), setTimeout(function () {
				a || e.onAfterSlide.call(this, g, q);
			}, e.speed), n = !0;
		}, g.play = function () {
			g.goToNextSlide(), e.auto = !0, d.auto();
		}, g.pause = function () {
			e.auto = !1, clearInterval(x);
		}, g.refresh = function () {
			z.init();
		}, g.getCurrentSlideCount = function () {
			var a = q;if (e.loop) {
				var b = p.find(".lslide").length,
				    c = g.find(".clone.left").length;a = c - 1 >= q ? b + (q - c) : q >= b + c ? q - b - c : q - c;
			}return a + 1;
		}, g.getTotalSlideCount = function () {
			return p.find(".lslide").length;
		}, g.goToSlide = function (a) {
			q = e.loop ? a + g.find(".clone.left").length - 1 : a, g.mode(!1), e.gallery === !0 && d.slideThumb();
		}, g.destroy = function () {
			g.lightSlider && (g.goToPrevSlide = function () {}, g.goToNextSlide = function () {}, g.mode = function () {}, g.play = function () {}, g.pause = function () {}, g.refresh = function () {}, g.getCurrentSlideCount = function () {}, g.getTotalSlideCount = function () {}, g.goToSlide = function () {}, g.lightSlider = null, z = { init: function init() {} }, g.parent().parent().find(".lSAction, .lSPager").remove(), g.removeClass("lightSlider lSFade lSSlide lsGrab lsGrabbing leftEnd right").removeAttr("style").unwrap().unwrap(), g.children().removeAttr("style"), h.removeClass("lslide active"), g.find(".clone").remove(), h = null, x = null, n = !1, q = 0);
		}, setTimeout(function () {
			e.onSliderLoad.call(this, g);
		}, 10), a(window).on("resize orientationchange", function (a) {
			setTimeout(function () {
				a.preventDefault ? a.preventDefault() : a.returnValue = !1, z.init();
			}, 200);
		}), this;
	};
}(jQuery);
// ------------------ Start Close Cart Modal------------------//
$('.modal #cart_close').click(function () {
	$("#cd-cart").removeAttr("style");
});
// ------------------ End Close Cart Modal------------------//
$(function () {
	var $carousel = $('.prod-slides');
	$carousel.on('lazyLoad.flickity', function () {
		// Remove loader on Flickity init
		$(".loader").fadeOut(1000);
		// Hide navigation if length equals 1
		var flkty = new Flickity('.prod-slides');
		if (flkty.slides.length == 1) {
			$('.flickity-button').hide();
		}
	});
	$carousel.flickity({
		// options
		cellAlign: 'left',
		freeScroll: true,
		contain: true,
		lazyLoad: 2,
		pageDots: false
	});
	// initialize Flickity
	$carousel.flickity();
});
// ------------------ Start Image Load ------------------//
var lazy = function lazy() {
	document.addEventListener('lazyloaded', function (e) {
		e.target.parentNode.classList.add('image-loaded');
		e.target.parentNode.classList.remove('loading');
	});
};
lazy();
// ------------------ End Image Load ------------------//
// $('.stellarnav').stellarNav({
//     position: "left",
//     breakpoint: 992,
//     menuLabel: " ",
//     closingDelay: 150,
//     mobileMode: true
// });
// ------------------ Start Image Loader ------------------//
$(document).ready(function () {
	$(function () {
		// $(".loader").fadeOut(2000, function() {
		//     $(".prod-slides li img").fadeIn(1000);
		// });
		if ($('#aniimated-thumbnials').hasClass('slider-placeholder-img')) {
			$(".loader").fadeOut(2000);
		}
	});
	// ------------------ End Image Loader ------------------//
	// $('#aniimated-thumbnials').lightGallery({
	//         selector: '.custom-selector',
	//         preload: 0,
	//         download: false,
	//         fullScreen: false,
	//         autoplayControls: false,
	//         share: false
	//  });
	// ------------------ Start Filter For Mobile ------------------//

	jQuery(".clear-filter").click(function () {
		jQuery(".filter-selection").attr("style", "display: none !important");
	});

	// ------------------ End Filter For Mobile ------------------//
	// ------------------ Start Disable Arrow on single product ------------------//
	jQuery(".prod-slides img").click(function () {
		jQuery(".swipe-arrow").removeClass("swipe-arrow-visible");
	});
	// ------------------ Mobile View ------------------//
	jQuery("#cart_close").click(function () {
		jQuery("#kss_cart").removeClass("fixed-bottom");
	});
	// ------------------ Mobile View ------------------//
	if ($(window).width() < 760) {
		$('.similar-link').appendTo('.m-similar');
		$('.search-icon').click(function () {
			$('.search-icon').addClass("d-block");
		});
		/* ==========================================
  scrollTop() >= 300
  Should be equal the the height of the header
  ========================================== */
		$(window).scroll(function () {
			if ($(window).scrollTop() >= 300) {
				$('.top-navbar').addClass('sticky-menu');
			} else {
				$('.top-navbar').removeClass('sticky-menu');
			}
		});
	} else {
		$('.kss_zoom a').removeClass('js-smartphoto');
	}
	// ------------------ Swipe Animation ------------------//
	jQuery(function () {
		jQuery('.slick-slider').on('afterChange', function (event, slick, currentSlide, nextSlide) {
			jQuery(".swipe-arrow").removeClass("swipe-arrow-visible");
		});
	});
	// ------------------ Shortlist Icon ------------------//
	$('.kss_heart').on('click', function () {
		$(this).toggleClass('animated-heart');
	});
	// ------------------ Shortlist Icon ------------------//
	// if ($(window).width() < 992) {
	//     $(".navbar-collapse").mmenu({
	//         wrappers: ["bootstrap4"],
	//         "extensions": ["fx-menu-zoom", "fx-panels-zoom", "pagedim-black", "theme-dark"]
	//     }, {
	//         clone: true
	//     });
	//     api = $('#mm-0').data('mmenu');
	//     api.bind('open:finish', function() {
	//         return $('.navbar-toggler').addClass('is-active');
	//     });
	//     api.bind('close:finish', function() {
	//         return $('.navbar-toggler').removeClass('is-active');
	//     });
	// }
	//if you change this breakpoint in the style.css file (or _layout.scss if you use SASS), don't forget to update this value as well
	var $L = 1200,
	    $menu_navigation = $('#main-nav'),
	    $cancel_trigger = $('.cancel-trigger'),
	    $hamburger_icon = $('#cd-hamburger-menu'),
	    $lateral_cart = $('#cd-cart'),
	    $shadow_layer = $('#cd-shadow-layer');
	$cart_cancel = $('#cart_close');
	//open lateral menu on mobile
	$hamburger_icon.on('click', function (event) {
		event.preventDefault();
		//close cart panel (if it's open)
		$lateral_cart.removeClass('speed-in');
		toggle_panel_visibility($menu_navigation, $shadow_layer, $('body'));
	});
	$cancel_trigger.on('click', function (event) {
		event.preventDefault();
		//close lateral menu (if it's open)
		$menu_navigation.removeClass('speed-in');
		toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
		$("body").addClass("hide-scroll");
	});
	jQuery("#new-address").click(function () {
		event.preventDefault();
		//close lateral menu (if it's open)
		$(".kss_shipping").addClass("slide-show");
		$(".kss_shipping  .fixed-bottom").removeClass('d-none');
		$(".kss_shipping  .fixed-bottom").addClass('d-block');
		$menu_navigation.removeClass('speed-in');
		toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
		$("body").addClass("hide-scroll");
	});
	$cart_cancel.on('click', function () {
		$shadow_layer.removeClass('is-visible');
		// firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
		if ($lateral_cart.hasClass('speed-in')) {
			$lateral_cart.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
				$('body').removeClass('overflow-hidden');
			});
			$menu_navigation.removeClass('speed-in');
		} else {
			$menu_navigation.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
				$('body').removeClass('overflow-hidden');
			});
			$lateral_cart.removeClass('speed-in');
		}
		$("body").removeClass("hide-scroll");
	});
	//move #main-navigation inside header on laptop
	//insert #main-navigation after header on mobile
	move_navigation($menu_navigation, $L);
	$(window).on('resize', function () {
		move_navigation($menu_navigation, $L);
		if ($(window).width() >= $L && $menu_navigation.hasClass('speed-in')) {
			$menu_navigation.removeClass('speed-in');
			$shadow_layer.removeClass('is-visible');
			$('body').removeClass('overflow-hidden');
		}
	});
	$('body').on('click', '.view-signup', function () {
		$('.sign-in-box').addClass('d-none');
		$('.sign-up-box').removeClass('d-none');
	});
	$('body').on('click', '.view-signin', function () {
		$('.sign-up-box , .reset-box').addClass('d-none');
		$('.sign-in-box').removeClass('d-none');
	});
	$('body').on('click', '.view-reset', function () {
		$('.sign-in-box').addClass('d-none');
		$('.reset-box').removeClass('d-none');
	});
	// $('body').on('click', '.btn', function() {
	//     var clickedbutton = $(this);
	//     clickedbutton.addClass('loading');
	//     // replace timeout with success event
	//     setTimeout(function() {
	//         clickedbutton.removeClass('loading');
	//         clickedbutton.addClass('loaded');
	//     }, 1000);
	// })
});

function toggle_panel_visibility($lateral_panel, $background_layer, $body) {
	if ($lateral_panel.hasClass('speed-in')) {
		// firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
		$lateral_panel.removeClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
			$body.removeClass('overflow-hidden');
		});
		$background_layer.removeClass('is-visible');
	} else {
		$lateral_panel.addClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
			$body.addClass('overflow-hidden');
		});
		$background_layer.addClass('is-visible');
	}
}

function move_navigation($navigation, $MQ) {
	if ($(window).width() >= $MQ) {
		$navigation.detach();
		$navigation.appendTo('header');
	} else {
		$navigation.detach();
		$navigation.insertAfter('header');
	}
}
// ------------------ Image Load ------------------//
jQuery(window).on("load", function () {
	// jQuery.ready.then(function() {
	//     var imgDefer = document.getElementsByTagName('img');
	//     for (var i = 0; i < imgDefer.length; i++) {
	//         if (imgDefer[i].getAttribute('data-imgsrc')) {
	//             imgDefer[i].setAttribute('src', imgDefer[i].getAttribute('data-imgsrc'));
	//             imgDefer[i].removeAttribute('data-imgsrc');
	//         }
	//     }
	// });
	var lazy = function lazy() {
		document.addEventListener('lazyloaded', function (e) {
			e.target.parentNode.classList.add('image-loaded');
			e.target.parentNode.classList.remove('loading');
		});
	};
	lazy();
	jQuery(".swipe-arrow").addClass("swipe-arrow-visible");
	// $('.kss_shipping').appendTo('#cd-cart');
	// $('.kss_payment').appendTo('#cd-cart');
	$('#modal_pincode').appendTo('#cd-cart');
});
//getting click event to show modal
$('#delivery-pincode').click(function () {
	$('#modal_pincode').modal();
	//appending modal background inside the bigform-content
	$('.modal-backdrop').appendTo('#cd-cart');
	//removing body classes to able click events
	$('body').removeClass();
	$('body').addClass('hide-scroll');
});
$(document).ready(function () {
	// Show or hide the sticky footer button
	$("a.scrollLink").click(function (event) {
		event.preventDefault();
		$("html, body").animate({
			scrollTop: $($(this).attr("href")).offset().top
		}, 500);
	});
	$(window).scroll(function () {
		if ($(this).scrollTop() > 300) {
			$('.go-top').fadeIn(200);
		} else {
			$('.go-top').fadeOut(200);
		}
	});
	// Animate the scroll to top
	$('.go-top').click(function (event) {
		event.preventDefault();
		$('html, body').animate({
			scrollTop: 0
		}, 300);
	});
	// Input to accept numbers only
	function validateNumber(event) {
		var key = window.event ? event.keyCode : event.which;
		if (event.keyCode === 8 || event.keyCode === 46) {
			return true;
		} else if (key < 48 || key > 57) {
			return false;
		} else {
			return true;
		}
	};
	$(document).on('keypress', function (e) {
		$('.validate-number').keypress(validateNumber);
	});
});
$('.close').click(function () {
	$("body").removeClass("hide-scroll");
	$('#checkout-flow').modal('hide');
	$('.modal-backdrop').remove();
	$("#cd-cart").css("overflow", "visible");
});
$('.kss_payment .back-to-cart').click(function () {
	$(".kss_payment").removeClass("slide-show");
	$(".kss_payment .fixed-bottom").removeClass('d-block'), 100;
	$(".kss_payment .fixed-bottom").addClass('d-none'), 100;
});
$('.kss_shipping .back-to-cart').click(function () {
	$(".kss_shipping").removeClass("slide-show");
	$("#cd-cart").removeAttr("style");
	$(".kss_shipping .fixed-bottom").removeClass('d-block'), 100;
	$(".kss_shipping .fixed-bottom").addClass('d-none'), 100;
});
$('.kss_shipping_summary .back-to-cart').click(function () {
	$(".kss_shipping_summary").removeClass("slide-show");
	$(" .kss_shipping_summary .fixed-bottom").removeClass('d-block'), 100;
	$(".kss_shipping_summary .fixed-bottom").addClass('d-none'), 100;
	$(" .kss_shipping .fixed-bottom").removeClass('d-none'), 100;
	$(".kss_shipping .fixed-bottom").addClass('d-block'), 100;
});
$('.shipping-details-save').click(function () {
	$('.shipping-content').hide();
	$('.shipping-content-info').show();
	$('.shipping-state-1').hide();
	$('.shipping-state-2').show();
	// $(".kss_shipping .fixed-bottom").removeClass('d-block'), 100;
	// $(".kss_shipping .fixed-bottom").addClass('d-none'), 100;
	// $('.kss_shipping').removeClass('slide_to_show'), 100;
	// $('body').removeClass();
	// $('body').addClass('hide-scroll');
	// $(".kss_shipping").addClass("d-none");
	// $(".kss_shipping").removeClass("d-block");
});
$('#add-address').click(function () {
	$('.shipping-content').show();
	$('.shipping-content-info').hide();
	$('.shipping-state-1').show();
	$('.shipping-state-2').hide();
});
$('#kss_coupon').click(function () {
	$('#cd-coupon').addClass('slide-show');
});
$('.cd-coupon-apply').click(function () {
	$('#cd-coupon').removeClass('slide-show');
});
$('#customRadio1, #customRadio2 ').click(function () {
	$(".kss_payment .fixed-bottom").removeClass('d-block'), 100;
	$(".kss_payment .fixed-bottom").addClass('d-none'), 100;
	$('#checkout-flow2').modal();
	$('.kss_payment').removeClass('slide_to_show'), 100;
	$('#checkout-flow2').appendTo('#cd-cart');
	$('.modal-backdrop').appendTo('#cd-cart');
	$('body').removeClass();
	$('body').addClass('hide-scroll');
	$(".kss_payment").addClass("d-none");
	$(".kss_payment").removeClass("d-block");
});
$('#shipping-details').click(function () {
	$('#signin').modal('hide');
	$("body").removeClass("hide-scroll");
	$(".kss_shipping").addClass("slide-show");
	$(".kss_shipping  .fixed-bottom").removeClass('d-none'), 100;
	$(".kss_shipping  .fixed-bottom").addClass('d-block'), 100;
	$('body').removeClass();
	$('body').addClass('hide-scroll');
	// $("#cd-cart").removeAttr("style");
});
$('#shipping-summary').click(function () {
	$("body").removeClass("hide-scroll");
	$('#checkout-flow').modal('hide');
	$('.modal-backdrop').remove();
	// $(".kss_shipping").removeClass("slide-show");
	$(".kss_shipping_summary").addClass("slide-show");
	$(".kss_shipping  .fixed-bottom").addClass('d-none'), 100;
	$(".kss_shipping  .fixed-bottom").removeClass('d-block'), 100;
	$(".kss_shipping_summary  .fixed-bottom").removeClass('d-none'), 100;
	$(".kss_shipping_summary  .fixed-bottom").addClass('d-block'), 100;
	$('body').removeClass();
	$('body').addClass('hide-scroll');
});
$('#payment-details').click(function () {
	$("body").removeClass("hide-scroll");
	$('#checkout-flow').modal('hide');
	$('.modal-backdrop').remove();
	$(".kss_payment").addClass("slide-show");
	$('body').removeClass();
	$('body').addClass('hide-scroll');
});
$(document).ready(function () {
	// Function which checks window size and hide/shows logo/menu
	function search_menu_hide(state) {
		if (window.matchMedia("(min-width: 992px) and (max-width: 1024px)").matches) {
			if (state == 'hide') {
				$('.navbar-nav').hide();
			} else {
				$('.navbar-nav').show();
			}
		} else if (window.matchMedia("(min-width: 768px) and (max-width: 991px)").matches) {
			if (state == 'hide') {
				$('.kss-logo').hide();
			} else {
				$('.kss-logo').show();
			}
		} else {
			return;
		}
	}
	$('.search-icon').click(function () {
		$('.search-input').show();
		$('.search-icon').hide();
		$('.recent-search').removeClass("d-none");
		$('.overlay-fix').removeClass("d-none");
		$('.recent-search').addClass("d-block");
		$('.overlay-fix').addClass("d-block");
		$('body').addClass('hide-scroll');
		search_menu_hide('hide');
	});
	$('.hide-search').click(function () {
		$('.search-input').hide();
		$('.search-icon').show();
		$('.recent-search').removeClass("d-block");
		$('.overlay-fix').removeClass("d-block");
		$('.recent-search').addClass("d-none");
		$('.overlay-fix').addClass("d-none");
		$('body').removeClass('hide-scroll');
		search_menu_hide('show');
	});
	$('.recent-link').click(function () {
		$('.search-input').hide();
		$('.search-icon').show();
		$('.recent-search').removeClass("d-block");
		$('.overlay-fix').removeClass("d-block");
		$('.recent-search').addClass("d-none");
		$('.overlay-fix').addClass("d-none");
		$('body').removeClass('hide-scroll');
	});
	$('.login-btn').click(function () {
		$('.sign-div').addClass("d-none");
		$('.verify-div').removeClass("d-none");
		$('.verify-div').addClass("d-block");
	});
	$('#loginModal .close').click(function () {
		$('.verify-div').addClass("d-none");
		$('.verify-div').removeClass("d-block");
		$('.sign-div').removeClass("d-none");
	});
	$('.overlay-fix').click(function () {
		$('.search-input').hide();
		$('.search-icon').show();
		$('.recent-search').removeClass("d-block");
		$('.overlay-fix').removeClass("d-block");
		$('.recent-search').addClass("d-none");
		$('.overlay-fix').addClass("d-none");
		$('body').removeClass('hide-scroll');
		search_menu_hide('show');
	});
	$('#search').on('focusin focusout', function () {
		$('.recent-search').removeClass("d-block");
		$('.recent-search').addClass("d-none");
	});
});
$('.btn-pay').click(function () {
	$("body").removeClass("hide-scroll");
	$('#checkout-flow2').modal('hide');
	$('.modal-backdrop').remove();
	$("#cd-cart").removeClass("speed-in");
	$("#cd-shadow-layer").removeClass("is-visible");
	$(".kss_shipping .fixed-bottom, .kss_shipping_summary .fixed-bottom").removeClass('d-block'), 100;
	$(".kss_shipping .fixed-bottom, .kss_shipping_summary .fixed-bottom").addClass('d-none'), 100;
	$(".kss_shipping, .kss_shipping_summary, .kss_payment").removeClass("slide-show");
	$("#cd-cart").removeAttr("style");
	$("#kss_cart").removeClass("fixed-bottom");
});
$(function () {
	var x = 0;
	$('.form-control').focusout(function () {
		var inputValue = $(this).val();
		if (inputValue == "") {
			$(this).removeClass("has-value");
		} else {
			$(this).addClass("has-value");
		}
	});
});
var products = ['Cotton Rich Jeans', 'Boy Clothings', 'Boy party wear', 'Jeans', 'Casual Shirts', 'Ethnic wear', 'Pajamas', 'Jackets', 'Beach Wear', 'School Collection', 'Diwali Collection', 'Kurta', 'Dhoti Seta', 'Infants', 'Embroidered Kurta', 'Sherwani', 'Character Tshirt', 'Romper', 'Early Walker', 'Musical Walkers', 'Jute Boots', 'Shocks', 'Hair Accessories', 'Handbags', 'Jewellery', 'Sleeveless Tshirt', 'Slips', 'Innerwear', 'Woolen Cap', 'Baby hug', 'Towel', 'Infants Clothing', 'Barbie Tshirt', 'Frozen Tshirt', 'Round Tshirt', 'Swimwear', 'Girls Clothing', 'Outwear', 'Jumpsuit', 'Frocks', 'Princess Wear', 'Skirts', 'Lehenga', 'Dupatta', 'Chaniya Choli', 'Footwear', 'Gown Duppata', 'Patiala Salwar', 'Looks', 'Dresses'];
$('#search').autocomplete({
	source: [products]
});
// $('a[href^="#"]').on('click', function(event) {
//     var target = $(this.getAttribute('href'));
//     if( target.length ) {
//         event.preventDefault();
//         $('html, body').stop().animate({
//             scrollTop: target.offset().top
//         }, 1000);
//     }
// });
function replaceURLParameter(paramName, paramValue) {
	var url = window.location.href;
	var hash = location.hash;
	url = url.replace(hash, '');
	if (url.indexOf(paramName + "=") >= 0) {
		var prefix = url.substring(0, url.indexOf(paramName));
		var suffix = url.substring(url.indexOf(paramName));
		suffix = suffix.substring(suffix.indexOf("=") + 1);
		suffix = suffix.indexOf("&") >= 0 ? suffix.substring(suffix.indexOf("&")) : "";
		url = prefix + paramName + "=" + paramValue + suffix;
	} else {
		if (url.indexOf("?") < 0) url += "?" + paramName + "=" + paramValue;else url += "&" + paramName + "=" + paramValue;
	}
	var url = url.substring(url.indexOf(window.location.pathname));
	window.history.replaceState({}, 'Kidsuperstore.in', url + hash);
}
$('.home-slider').slick({
	autoplay: true
});
if ($('#storeSlider').length) {
	$('#storeSlider').lightSlider({
		loop: true,
		item: 1,
		thumbItem: 4,
		slideMargin: 0,
		gallery: true,
		galleryMargin: 20,
		thumbMargin: 20,
		currentPagerPosition: 'left',
		onSliderLoad: function onSliderLoad() {
			$('#storeSlider').removeClass('cs-hidden');
		}
	});
}

// Mega menu
$('.megamenu--left .nav-item').click(function () {
	var menuTab = $(this);
	menuTab.addClass('active').siblings().removeClass('active');
	var mobMenuName = menuTab.data('target');
	$('.megamenu-wrapper').addClass('d-none');
	$('.megamenu-wrapper[data-menu="' + mobMenuName + '"]').removeClass('d-none');
});
$('.megamenu-open').click(function () {
	$('.megamenu').addClass('active');
	$('.megamenu--left .nav-item:first-child').addClass('active');
	$('.megamenu--right li .megamenu-wrapper').addClass('d-none');
	$('.megamenu--right li:first-child .megamenu-wrapper').removeClass('d-none');
	$('body').addClass('overflow-h');
});

// Footer mobile more section

$(document).on('click', ".footer-more", function () {
	$('.footer-more__title').text(function (i, v) {
		return v === 'Fresh Fashion for your kids' ? 'Less' : 'Fresh Fashion for your kids';
	});
});

$('.megamenu-close').click(function () {
	$('.megamenu').removeClass('active');
	$('.megamenu--left .nav-item').removeClass('active');
	$('.megamenu-wrapper').addClass('d-none');
	$('body').removeClass('overflow-h');
});