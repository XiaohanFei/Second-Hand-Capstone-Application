var c = Math.min, h = Math.sign, m = Math.max, n = Math.abs, j = .85, k = 10, l = 4;
var opt = {};
opt.currentIndex = 0;
 
const calcAVGSpeed = function (a) {
  var b = (l * j * a + k * (1 - j) * a) / (k * l * 20);
  return b = m(n(b), 2.5) * h(b), b
}
const getCurSpeed = function (a, b) {
  var c = n(a) > n(j * b) ? l * opt.avgSpeed : k * opt.avgSpeed;
  return c
}


const _calCurve = function (a, b, c, d, e, f) {
  e.bezierCurveTo(a + f, b, c - f, d, c, d)
}

const _initCanvas = function (canvas, width, height) {
  var devicePixelRatio = window.devicePixelRatio, canvasObj = canvas.getContext("2d");
  canvas.width = width * devicePixelRatio
  canvas.height = height * devicePixelRatio
  canvas.style.width = width + "px"
  canvas.style.height = height + "px"
  canvasObj.scale(devicePixelRatio, devicePixelRatio)
}


var _calcTabs = function (marginL) {
  var a = document.querySelectorAll(".nav-main .nav-span"), b = [], c = marginL;
  document.querySelector(".nav-main .nav-span").style.marginLeft = marginL + "px"
  Array.prototype.forEach.call(a, function (a) {
    b.push(c)
    c += a.offsetWidth
  })
  b[0] = marginL
  b.push(c)
  opt.tabWidthList = b
  opt.animating = false
  opt.tabHeight = a[0].offsetHeight + 0
  opt.height = opt.tabHeight + 20
  opt.width = window.innerWidth
}


export function toggle(navindex) {

  "undefined" !== typeof navindex && navindex !== opt.currentIndex && opt.tabWidthList && opt.tabWidthList.length && (!opt.animating || navindex !== opt.nextIndex) && (opt.animating = true, opt.distance = opt.tabWidthList[navindex] - opt.tabWidthList[opt.currentIndex], opt.avgSpeed = calcAVGSpeed(opt.distance), opt.curDisX = 0, opt.nextIndex = navindex)
  return false;

}


const _createPattern = function (a) {
  var b = 140, c = 40, d = 1, e = document.createElement("canvas");
  e.width = b, e.height = c, e.style.width = b / d + "px", e.style.height = c / d + "px";
  var f = e.getContext("2d");
  //缩放 宽高 100%
  f.scale(d, d);
  f.lineWidth = .4;
  for (var g = 3, h = .8, j = 1; 30 > j; j++) {
    //设置或返回用于笔触的颜色、渐变或模式
    f.strokeStyle = "RGBA(22, 120, 160, " + h + ")";
    //开始一条路径
    f.beginPath();
    //把路径移动到画布中的指定点，不创建线条
    f.moveTo(0, j * g);
    //添加一个新点，然后在画布中创建从该点到最后指定点的线条
    f.lineTo(b, j * g);
    //绘制已定义的路径
    f.stroke();
    //创建从当前点回到起始点的路径
    f.closePath();
    10 < j && (h -= .1);
  }
  var i = a.getContext("2d").createPattern(e, "repeat-x");
  opt.pattern = i, e = null
}

const _drawHightlight = function (a) {
  //a = 0
  var b = opt.canvas.getContext("2d"), d = .4;
  //clearRect 在给定的矩形内清除指定的像素,这里清完了
  b.clearRect(0, 0, 2 * opt.width, 2 * opt.height);
  b.shadowColor = "rgba(0, 193, 220, 1)";
  b.shadowBlur = 1;
  b.strokeStyle = "#01AAED";
  b.lineWidth = 1.6;
  b.fillStyle = "none";
  _draw(b, false);
  //这里绘制了外围边框线条
  //return false;
  var e = b.createLinearGradient(0, 0, opt.width, opt.height), f = a - d;
  e.addColorStop(c(1, m(0, 0 + f)), "rgba(0,0,0,0)");
  e.addColorStop(c(1, m(0, 0 + f + .1)), "#8fffFF");
  e.addColorStop(c(1, 0 + f + d), "#8fffFF");
  e.addColorStop(c(1, 0 + f + d + .1), "rgba(0,0,0,0)");
  e.addColorStop(1, "rgba(0,0,0,0)");
  b.lineWidth = 1.5;
  b.strokeStyle = e;
  b.fillStyle = opt.pattern;
  _draw(b, true)

}


const draw = function (a) {
  _drawHightlight(a);
  opt.timer = requestAnimationFrame(function () {
    draw((a + .005) % 1.6)
  })


}

const _draw = function (canvasObj, trueorfalse) {
  var navindex = opt.currentIndex, tableHeight = opt.tabHeight, f = 0, g = 40, i = 20, j = .5, k = 2.5, l = 0;
  if (canvasObj.beginPath(), canvasObj.moveTo(-50, opt.height + 10), canvasObj.lineTo(-50, tableHeight + j), opt.animating) {
    var m = getCurSpeed(opt.curDisX, opt.distance);
    l = c(n(opt.distance), n(opt.curDisX + m)) * h(m)
  }
  if (canvasObj.lineTo(f + opt.tabWidthList[navindex] + l - g / 2, tableHeight + j), _calCurve(f + opt.tabWidthList[navindex] + l - g / 2, tableHeight + j, f + opt.tabWidthList[navindex] + l + g / 2, k + j, canvasObj, i), opt.animating) {
    var o = opt.tabWidthList[opt.nextIndex + 1] - opt.tabWidthList[opt.nextIndex];
    canvasObj.lineTo(f + opt.tabWidthList[navindex] + o + l - g / 2, k + j), _calCurve(f + opt.tabWidthList[navindex] + o + l - g / 2, k + j, f + opt.tabWidthList[navindex] + o + l + g / 2, tableHeight + j, canvasObj, i)
  } else {
    //lineTO添加一个新点 宽度长度
    canvasObj.lineTo(f + opt.tabWidthList[navindex + 1] + l - g / 2, k + j);
    _calCurve(f + opt.tabWidthList[navindex + 1] + l - g / 2, k + j, f + opt.tabWidthList[navindex + 1] + l + g / 2, tableHeight + j, canvasObj, i);
  }

  canvasObj.lineTo(opt.width + 10, tableHeight + j);
  canvasObj.lineTo(opt.width + 10, opt.height + 10);
  canvasObj.closePath();
  canvasObj.stroke();
  trueorfalse && canvasObj.fill();
  opt.animating && trueorfalse && (opt.curDisX = l, n(l) >= n(opt.distance) && (opt.animating = false, opt.currentIndex = opt.nextIndex))
}

export function init(canvas,marginL){
  marginL = marginL + 40
  opt.canvas = canvas
  toggle(1);
  _calcTabs(marginL);
  _initCanvas(opt.canvas, opt.width, opt.height);
  _createPattern(opt.canvas);
  draw(0);
}
