import {
	o as v,
	c as g,
	a as l,
	w as x,
	v as C,
	u as S,
	b,
	V as _,
	d as W
} from "./vendor.4572e0d8.js";
const p = function() {
	const a = document.createElement("link").relList;
	if (a && a.supports && a.supports("modulepreload")) return;
	for (const e of document.querySelectorAll('link[rel="modulepreload"]')) t(e);
	new MutationObserver(e => {
		for (const n of e)
			if (n.type === "childList")
				for (const i of n.addedNodes) i.tagName === "LINK" && i.rel === "modulepreload" && t(i)
	}).observe(document, {
		childList: !0,
		subtree: !0
	});

	function o(e) {
		const n = {};
		return e.integrity && (n.integrity = e.integrity), e.referrerpolicy && (n.referrerPolicy = e
			.referrerpolicy), e.crossorigin === "use-credentials" ? n.credentials = "include" : e.crossorigin ===
			"anonymous" ? n.credentials = "omit" : n.credentials = "same-origin", n
	}

	function t(e) {
		if (e.ep) return;
		e.ep = !0;
		const n = o(e);
		fetch(e.href, n)
	}
};
p();

function F(r, a) {
	if (!(r instanceof a)) throw new TypeError("Cannot call a class as a function")
}

function L(r, a) {
	for (var o = 0; o < a.length; o++) {
		var t = a[o];
		t.enumerable = t.enumerable || !1, t.configurable = !0, "value" in t && (t.writable = !0), Object
			.defineProperty(r, t.key, t)
	}
}

function N(r, a, o) {
	return a && L(r.prototype, a), o && L(r, o), r
}
var f = function() {
	function r(a, o) {
		var t = this;
		F(this, r), this.canvas = {}, this.ctx = {}, this.width = 320, this.height = 200, this.scale = window
			.devicePixelRatio || 1, this.color = "black", this.bgColor = "", this.canDraw = !1, this.openSmooth = !
			0, this.minWidth = 2, this.maxWidth = 6, this.minSpeed = 1.5, this.maxWidthDiffRate = 20, this
			.points = [], this.canAddHistory = !0, this.historyList = [], this.maxHistoryLength = 20, this.onStart =
			function() {}, this.onEnd = function() {}, this.addListener = function() {
				t.removeListener(), t.canvas.style.touchAction = "none", "ontouchstart" in window || navigator
					.maxTouchPoints ? (t.canvas.addEventListener("touchstart", t.onDrawStart), t.canvas
						.addEventListener("touchmove", t.onDrawMove), document.addEventListener("touchcancel", t
							.onDrawEnd), document.addEventListener("touchend", t.onDrawEnd)) : (t.canvas
						.addEventListener("mousedown", t.onDrawStart), t.canvas.addEventListener("mousemove", t
							.onDrawMove), document.addEventListener("mouseup", t.onDrawEnd))
			}, this.removeListener = function() {
				t.canvas.style.touchAction = "auto", t.canvas.removeEventListener("touchstart", t.onDrawStart), t
					.canvas.removeEventListener("touchmove", t.onDrawMove), document.removeEventListener("touchend",
						t.onDrawEnd), document.removeEventListener("touchcancel", t.onDrawEnd), t.canvas
					.removeEventListener("mousedown", t.onDrawStart), t.canvas.removeEventListener("mousemove", t
						.onDrawMove), document.removeEventListener("mouseup", t.onDrawEnd)
			}, this.onDrawStart = function(e) {
				e.preventDefault(), t.canDraw = !0, t.canAddHistory = !0, t.ctx.strokeStyle = t.color, t.initPoint(
					e), t.onStart && t.onStart(e)
			}, this.onDrawMove = function(e) {
				if (e.preventDefault(), !!t.canDraw && (t.initPoint(e), !(t.points.length < 2))) {
					t.addHistory();
					var n = t.points.slice(-1)[0],
						i = t.points.slice(-2, -1)[0];
					window.requestAnimationFrame ? window.requestAnimationFrame(function() {
						return t.onDraw(i, n)
					}) : t.onDraw(i, n)
				}
			}, this.onDraw = function(e, n) {
				t.openSmooth ? t.drawSmoothLine(e, n) : t.drawNoSmoothLine(e, n)
			}, this.onDrawEnd = function(e) {
				!t.canDraw || (t.canDraw = !1, t.canAddHistory = !0, t.points = [], t.onEnd && t.onEnd(e))
			}, this.getLineWidth = function(e) {
				var n = t.minSpeed > 10 ? 10 : t.minSpeed < 1 ? 1 : t.minSpeed,
					i = (t.maxWidth - t.minWidth) * e / n,
					s = Math.max(t.maxWidth - i, t.minWidth);
				return Math.min(s, t.maxWidth)
			}, this.getRadianData = function(e, n, i, s) {
				var h = i - e,
					d = s - n;
				if (h === 0) return {
					val: 0,
					pos: -1
				};
				if (d === 0) return {
					val: 0,
					pos: 1
				};
				var c = Math.abs(Math.atan(d / h));
				return i > e && s < n || i < e && s > n ? {
					val: c,
					pos: 1
				} : {
					val: c,
					pos: -1
				}
			}, this.getRadianPoints = function(e, n, i, s) {
				if (e.val === 0) return e.pos === 1 ? [{
					x: n,
					y: i + s
				}, {
					x: n,
					y: i - s
				}] : [{
					y: i,
					x: n + s
				}, {
					y: i,
					x: n - s
				}];
				var h = Math.sin(e.val) * s,
					d = Math.cos(e.val) * s;
				return e.pos === 1 ? [{
					x: n + h,
					y: i + d
				}, {
					x: n - h,
					y: i - d
				}] : [{
					x: n + h,
					y: i - d
				}, {
					x: n - h,
					y: i + d
				}]
			}, this.initPoint = function(e) {
				var n = Date.now(),
					i = t.points.slice(-1)[0];
				if (!(i && i.t === n)) {
					var s = t.canvas.getBoundingClientRect(),
						h = e.touches && e.touches[0] || e,
						d = h.clientX - s.left,
						c = h.clientY - s.top;
					if (!(i && i.x === d && i.y === c)) {
						var u = {
							x: d,
							y: c,
							t: n
						};
						if (t.openSmooth && i) {
							var w = t.points.slice(-2, -1)[0];
							if (u.distance = Math.sqrt(Math.pow(u.x - i.x, 2) + Math.pow(u.y - i.y, 2)), u.speed = u
								.distance / (u.t - i.t || .1), u.lineWidth = t.getLineWidth(u.speed), w && w
								.lineWidth && i.lineWidth) {
								var y = (u.lineWidth - i.lineWidth) / i.lineWidth,
									m = t.maxWidthDiffRate / 100;
								if (m = m > 1 ? 1 : m < .01 ? .01 : m, Math.abs(y) > m) {
									var E = y > 0 ? m : -m;
									u.lineWidth = i.lineWidth * (1 + E)
								}
							}
						}
						t.points.push(u), t.points = t.points.slice(-3)
					}
				}
			}, this.drawSmoothLine = function(e, n) {
				var i = n.x - e.x,
					s = n.y - e.y;
				if (Math.abs(i) + Math.abs(s) <= t.scale ? (n.lastX1 = n.lastX2 = e.x + i * .5, n.lastY1 = n
						.lastY2 = e.y + s * .5) : (n.lastX1 = e.x + i * .3, n.lastY1 = e.y + s * .3, n.lastX2 = e
						.x + i * .7, n.lastY2 = e.y + s * .7), n.perLineWidth = (e.lineWidth + n.lineWidth) / 2,
					typeof e.lastX1 == "number") {
					if (t.drawCurveLine(e.lastX2, e.lastY2, e.x, e.y, n.lastX1, n.lastY1, n.perLineWidth), e
						.isFirstPoint || e.lastX1 === e.lastX2 && e.lastY1 === e.lastY2) return;
					var h = t.getRadianData(e.lastX1, e.lastY1, e.lastX2, e.lastY2),
						d = t.getRadianPoints(h, e.lastX1, e.lastY1, e.perLineWidth / 2),
						c = t.getRadianPoints(h, e.lastX2, e.lastY2, n.perLineWidth / 2);
					t.drawTrapezoid(d[0], c[0], c[1], d[1])
				} else n.isFirstPoint = !0
			}, this.drawNoSmoothLine = function(e, n) {
				n.lastX = e.x + (n.x - e.x) * .5, n.lastY = e.y + (n.y - e.y) * .5, typeof e.lastX == "number" && t
					.drawCurveLine(e.lastX, e.lastY, e.x, e.y, n.lastX, n.lastY, t.maxWidth)
			}, this.drawCurveLine = function(e, n, i, s, h, d, c) {
				t.ctx.lineWidth = Number(c.toFixed(1)), t.ctx.beginPath(), t.ctx.moveTo(Number(e.toFixed(1)),
					Number(n.toFixed(1))), t.ctx.quadraticCurveTo(Number(i.toFixed(1)), Number(s.toFixed(1)),
					Number(h.toFixed(1)), Number(d.toFixed(1))), t.ctx.stroke()
			}, this.drawTrapezoid = function(e, n, i, s) {
				t.ctx.beginPath(), t.ctx.moveTo(Number(e.x.toFixed(1)), Number(e.y.toFixed(1))), t.ctx.lineTo(
						Number(n.x.toFixed(1)), Number(n.y.toFixed(1))), t.ctx.lineTo(Number(i.x.toFixed(1)),
						Number(i.y.toFixed(1))), t.ctx.lineTo(Number(s.x.toFixed(1)), Number(s.y.toFixed(1))), t.ctx
					.fillStyle = t.color, t.ctx.fill()
			}, this.drawBgColor = function() {
				!t.bgColor || (t.ctx.fillStyle = t.bgColor, t.ctx.fillRect(0, 0, t.width, t.height))
			}, this.drawByImageUrl = function(e) {
				var n = new Image;
				n.onload = function() {
					t.ctx.clearRect(0, 0, t.width, t.height), t.ctx.drawImage(n, 0, 0, t.width, t.height)
				}, n.crossOrigin = "anonymous", n.src = e
			}, this.addHistory = function() {
				!t.maxHistoryLength || !t.canAddHistory || (t.canAddHistory = !1, t.historyList.push(t.canvas
					.toDataURL()), t.historyList = t.historyList.slice(-t.maxHistoryLength))
			}, this.clear = function() {
				t.ctx.clearRect(0, 0, t.width, t.height), t.drawBgColor(), t.historyList.length = 0
			}, this.undo = function() {
				var e = t.historyList.splice(-1)[0];
				e && t.drawByImageUrl(e)
			}, this.toDataURL = function() {
				var e = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : "image/png",
					n = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : 1;
				if (t.canvas.width === t.width) return t.canvas.toDataURL(e, n);
				var i = document.createElement("canvas");
				i.width = t.width, i.height = t.height;
				var s = i.getContext("2d");
				return s.drawImage(t.canvas, 0, 0, i.width, i.height), i.toDataURL(e, n)
			}, this.getPNG = function() {
				return t.toDataURL()
			}, this.getJPG = function() {
				var e = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : .8;
				return t.toDataURL("image/jpeg", e)
			}, this.isEmpty = function() {
				var e = document.createElement("canvas");
				if (e.width = t.canvas.width, e.height = t.canvas.height, t.bgColor) {
					var n = e.getContext("2d");
					n.fillStyle = t.bgColor, n.fillRect(0, 0, e.width, e.height)
				}
				return e.toDataURL() === t.canvas.toDataURL()
			}, this.getRotateCanvas = function() {
				var e = arguments.length > 0 && arguments[0] !== void 0 ? arguments[0] : 90;
				e > 0 ? e = e > 90 ? 180 : 90 : e = e < -90 ? 180 : -90;
				var n = document.createElement("canvas"),
					i = t.width,
					s = t.height;
				e === 180 ? (n.width = i, n.height = s) : (n.width = s, n.height = i);
				var h = n.getContext("2d");
				return h.rotate(e * Math.PI / 180), e === 90 ? h.drawImage(t.canvas, 0, -s, i, s) : e === -90 ? h
					.drawImage(t.canvas, -i, 0, i, s) : e === 180 && h.drawImage(t.canvas, -i, -s, i, s), n
			}, this.init(a, o)
	}
	return N(r, [{
		key: "init",
		value: function(o) {
			var t = arguments.length > 1 && arguments[1] !== void 0 ? arguments[1] : {};
			!o || (this.canvas = o, this.ctx = o.getContext("2d"), this.width = t.width || o
				.clientWidth || this.width, this.height = t.height || o.clientHeight || this
				.height, this.scale = t.scale || this.scale, this.color = t.color || this.color,
				this.bgColor = t.bgColor || this.bgColor, this.openSmooth = t.openSmooth || this
				.openSmooth, this.minWidth = t.minWidth || this.minWidth, this.maxWidth = t
				.maxWidth || this.maxWidth, this.minSpeed = t.minSpeed || this.minSpeed, this
				.maxWidthDiffRate = t.maxWidthDiffRate || this.maxWidthDiffRate, this
				.maxHistoryLength = t.maxHistoryLength || this.maxHistoryLength, this.onStart =
				t.onStart, this.onEnd = t.onEnd, this.scale > 0 && (this.canvas.height = this
					.height * this.scale, this.canvas.width = this.width * this.scale, this
					.scale !== 1 && (this.canvas.style.width = this.width + "px", this.canvas
						.style.height = this.height + "px", this.ctx.scale(this.scale, this
							.scale))), this.ctx.lineCap = "round", this.drawBgColor(), this
				.addListener())
		}
	}]), r
}();
var D = (r, a) => {
	for (const [o, t] of a) r[o] = t;
	return r
};
const U = {
		name: "pcDemo",
		data() {
			return {
				openSmooth: !0
			}
		},
		mounted() {
			this.init()
		},
		methods: {
			init() {
				const r = document.querySelector("canvas"),
					a = {
						width: Math.min(window.innerWidth, 1e3),
						height: 600,
						minWidth: 4,
						maxWidth: 12,
						bgColor: "#f6f6f6"
					};
				this.signature = new f(r, a)
			},
			handleClear() {
				this.signature.clear()
			},
			handleUndo() {
				this.signature.undo()
			},
			handleColor() {
				this.signature.color = "#" + Math.random().toString(16).slice(-6)
			},
			handlePreview() {
				if (this.signature.isEmpty()) {
					alert("isEmpty");
					return
				}
				const a = this.signature.getPNG();
				window.previewImage(a)
			}
		}
	},
	k = {
		class: "pcDemo"
	},
	R = {
		class: "actions"
	},
	M = l("div", {
		class: "tip"
	}, "\u4F7F\u7528\u624B\u673A\u7AEF\u624B\u5199\u66F4\u65B9\u4FBF", -1),
	X = l("canvas", null, null, -1);

function I(r, a, o, t, e, n) {
	return v(), g("div", k, [l("div", R, [l("button", {
		onClick: a[0] || (a[0] = (...i) => n.handleClear && n.handleClear(...i))
	}, "Clear"), l("button", {
		onClick: a[1] || (a[1] = (...i) => n.handleUndo && n.handleUndo(...i))
	}, "Undo"), l("button", {
		onClick: a[2] || (a[2] = (...i) => n.handlePreview && n.handlePreview(...i))
	}, "View PNG"), l("button", {
		onClick: a[3] || (a[3] = (...i) => n.handleColor && n.handleColor(...i))
	}, "Change Color")]), M, X])
}
var H = D(U, [
	["render", I]
]);
const Y = {
		name: "mbDemo",
		data() {
			return {
				showFull: !0
			}
		},
		mounted() {
			this.initSignature1(), this.initSignture2()
		},
		methods: {
			initSignature1() {
				const r = document.getElementById("canvas1"),
					a = {
						width: window.innerWidth - 10,
						height: 200,
						minWidth: 2,
						maxWidth: 6,
						bgColor: "#f6f6f6"
					};
				this.signature1 = new f(r, a)
			},
			initSignture2() {
				const r = document.getElementById("canvas2"),
					a = {
						width: window.innerWidth - 100,
						height: window.innerHeight - 50,
						minWidth: 3,
						maxWidth: 10,
						bgColor: "#f6f6f6"
					};
				this.signature2 = new f(r, a)
			},
			handleClear1() {
				this.signature1.clear()
			},
			handleClear2() {
				this.signature2.clear()
			},
			handleUndo1() {
				this.signature1.undo()
			},
			handleUndo2() {
				this.signature2.undo()
			},
			handleFull() {
				this.showFull = !this.showFull
			},
			handlePreview1() {
				if (this.signature1.isEmpty()) {
					alert("isEmpty");
					return
				}
				const a = this.signature1.getPNG();
				window.previewImage(a)
			},
			handlePreview2() {
				if (this.signature2.isEmpty()) {
					alert("isEmpty");
					return
				}
				const o = this.signature2.getRotateCanvas(-90).toDataURL();
				window.previewImage(o, 90)
			},
			handleColor1() {
				this.signature1.color = this.getRandomColor()
			},
			handleColor2() {
				this.signature2.color = this.getRandomColor()
			},
			getRandomColor() {
				return "#" + Math.random().toString(16).slice(-6)
			}
		}
	},
	A = {
		class: "mbDemo"
	},
	T = {
		class: "wrap1"
	},
	B = l("canvas", {
		class: "canvas1",
		id: "canvas1"
	}, null, -1),
	q = {
		class: "actions"
	},
	O = {
		class: "wrap2"
	},
	G = {
		class: "actionsWrap"
	},
	V = {
		class: "actions"
	},
	z = l("canvas", {
		class: "canvas",
		id: "canvas2"
	}, null, -1);

function j(r, a, o, t, e, n) {
	return v(), g("div", A, [x(l("div", T, [B, l("div", q, [l("button", {
		onClick: a[0] || (a[0] = (...i) => n.handleClear1 && n.handleClear1(...i))
	}, "Clear"), l("button", {
		onClick: a[1] || (a[1] = (...i) => n.handleUndo1 && n.handleUndo1(...i))
	}, "Undo"), l("button", {
		onClick: a[2] || (a[2] = (...i) => n.handlePreview1 && n.handlePreview1(...
			i))
	}, "View PNG"), l("button", {
		onClick: a[3] || (a[3] = (...i) => n.handleColor1 && n.handleColor1(...i))
	}, "Change Color"), l("button", {
		onClick: a[4] || (a[4] = (...i) => n.handleFull && n.handleFull(...i))
	}, "Full Screen")])], 512), [
		[C, !e.showFull]
	]), x(l("div", O, [l("div", G, [l("div", V, [l("button", {
		onClick: a[5] || (a[5] = (...i) => n.handleClear2 && n.handleClear2(
			...i))
	}, "Clear"), l("button", {
		onClick: a[6] || (a[6] = (...i) => n.handleUndo2 && n.handleUndo2(
			...i))
	}, "Undo"), l("button", {
		onClick: a[7] || (a[7] = (...i) => n.handlePreview2 && n
			.handlePreview2(...i))
	}, "View PNG"), l("button", {
		onClick: a[8] || (a[8] = (...i) => n.handleColor2 && n.handleColor2(
			...i))
	}, "Change Color"), l("button", {
		onClick: a[9] || (a[9] = (...i) => n.handleFull && n.handleFull(...
			i))
	}, "Close Full Screen")])]), z], 512), [
		[C, e.showFull]
	])])
}
var J = D(Y, [
	["render", j]
]);
const K = {
	setup(r) {
		const a = /Android|iPhone|iPad|Mobile/i.test(window.navigator.userAgent);
		return (o, t) => (v(), g("div", null, [S(a) ? (v(), b(J, {
			key: 0
		})) : (v(), b(H, {
			key: 1
		}))]))
	}
};
window.previewImage = function(r, a) {
	const o = document.createElement("img");
	o.src = r;
	const t = new _(o, {
		title: 0,
		navbar: 0,
		toolbar: {
			zoomIn: 1,
			zoomOut: 1,
			oneToOne: 1,
			reset: 1,
			rotateLeft: 1,
			rotateRight: 1,
			flipHorizontal: 1,
			flipVertical: 1
		},
		viewed() {
			a && this.viewer.zoomTo(.8).rotateTo(a)
		}
	});
	o.onload = function() {
		t.show()
	}
};
W(K).mount("#app");
