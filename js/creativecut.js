var creativeCutPainter = creativeCutPainter || {};
creativeCutPainter.bidId = '';
creativeCutPainter.bid = bid;
creativeCutPainter.cuttingTypes = cuttingTypes;
creativeCutPainter.materialSizes = materialSizes;
creativeCutPainter.materials = materials;
creativeCutPainter.options = options;
creativeCutPainter.unitsOfMeasurement = unitsOfMeasurement;
creativeCutPainter.unitOfMeasurement = Object.keys(unitsOfMeasurement)[0];
creativeCutPainter.zoom = 1;
creativeCutPainter.scaleCount = 0;
creativeCutPainter.scale = 1;
creativeCutPainter.translate = [0, 0];
creativeCutPainter.mouseMoveCoords = [0, 0];
creativeCutPainter.mouseDownCoords = false;
creativeCutPainter.workWidth = 0;
creativeCutPainter.workHeight = 0;
creativeCutPainter.totalArea = 0;
creativeCutPainter.totalLineLength = 0;
creativeCutPainter.distanceBetweenObjects = 0;
creativeCutPainter.material = '';
creativeCutPainter.size = '';
creativeCutPainter.cuttingTypesValues = {};
creativeCutPainter.colors = [
  'rgb(0, 0, 0)', 'rgb(255, 0, 0)', 'rgb(255, 255, 0)', 'rgb(0, 255, 0)', 'rgb(0, 255, 255)', 'rgb(0, 0, 255)',
  'rgb(255, 0, 255)', 'rgb(255, 255, 255)', 'rgb(65, 65, 65)', 'rgb(128, 128, 128)', 'rgb(255, 0, 1)', 'rgb(255, 170, 170)',
  'rgb(189, 0, 0)', 'rgb(189, 126, 126)', 'rgb(129, 0, 0)', 'rgb(129, 86, 86)', 'rgb(104, 0, 0)', 'rgb(104, 69, 69)',
  'rgb(79, 0, 0)', 'rgb(79, 53, 53)', 'rgb(255, 63, 0)', 'rgb(255, 191, 170)', 'rgb(189, 46, 0)', 'rgb(189, 141, 126)',
  'rgb(129, 31, 0)', 'rgb(129, 96, 86)', 'rgb(104, 25, 0)', 'rgb(104, 78, 69)', 'rgb(79, 19, 0)', 'rgb(79, 59, 53)',
  'rgb(255, 127, 0)', 'rgb(255, 212, 170)', 'rgb(189, 94, 0)', 'rgb(189, 157, 126)', 'rgb(129, 64, 0)', 'rgb(129, 107, 86)',
  'rgb(104, 52, 0)', 'rgb(104, 86, 69)', 'rgb(79, 39, 0)', 'rgb(79, 66, 53)', 'rgb(255, 191, 0)', 'rgb(255, 234, 170)',
  'rgb(189, 141, 0)', 'rgb(189, 173, 126)', 'rgb(129, 96, 0)', 'rgb(129, 118, 86)', 'rgb(104, 78, 0)', 'rgb(104, 95, 69)',
  'rgb(79, 59, 0)', 'rgb(79, 73, 53)', 'rgb(255, 255, 1)', 'rgb(255, 255, 170)', 'rgb(189, 189, 0)', 'rgb(189, 189, 126)',
  'rgb(129, 129, 0)', 'rgb(129, 129, 86)', 'rgb(104, 104, 0)', 'rgb(104, 104, 69)', 'rgb(79, 79, 0)', 'rgb(79, 79, 53)',
  'rgb(191, 255, 0)', 'rgb(234, 255, 170)', 'rgb(141, 189, 0)', 'rgb(173, 189, 126)', 'rgb(96, 129, 0)', 'rgb(118, 129, 86)',
  'rgb(78, 104, 0)', 'rgb(95, 104, 69)', 'rgb(59, 79, 0)', 'rgb(73, 79, 53)', 'rgb(127, 255, 0)', 'rgb(212, 255, 170)',
  'rgb(94, 189, 0)', 'rgb(157, 189, 126)', 'rgb(64, 129, 0)', 'rgb(107, 129, 86)', 'rgb(52, 104, 0)', 'rgb(86, 104, 69)',
  'rgb(39, 79, 0)', 'rgb(66, 79, 53)', 'rgb(63, 255, 0)', 'rgb(191, 255, 170)', 'rgb(46, 189, 0)', 'rgb(141, 189, 126)',
  'rgb(31, 129, 0)', 'rgb(96, 129, 86)', 'rgb(25, 104, 0)', 'rgb(78, 104, 69)', 'rgb(19, 79, 0)', 'rgb(59, 79, 53)',
  'rgb(0, 255, 1)', 'rgb(170, 255, 170)', 'rgb(0, 189, 0)', 'rgb(126, 189, 126)', 'rgb(0, 129, 0)', 'rgb(86, 129, 86)',
  'rgb(0, 104, 0)', 'rgb(69, 104, 69)', 'rgb(0, 79, 0)', 'rgb(53, 79, 53)', 'rgb(0, 255, 63)', 'rgb(170, 255, 191)',
  'rgb(0, 189, 46)', 'rgb(126, 189, 141)', 'rgb(0, 129, 31)', 'rgb(86, 129, 96)', 'rgb(0, 104, 25)', 'rgb(69, 104, 78)',
  'rgb(0, 79, 19)', 'rgb(53, 79, 59)', 'rgb(0, 255, 127)', 'rgb(170, 255, 212)', 'rgb(0, 189, 94)', 'rgb(126, 189, 157)',
  'rgb(0, 129, 64)', 'rgb(86, 129, 107)', 'rgb(0, 104, 52)', 'rgb(69, 104, 86)', 'rgb(0, 79, 39)', 'rgb(53, 79, 66)',
  'rgb(0, 255, 191)', 'rgb(170, 255, 234)', 'rgb(0, 189, 141)', 'rgb(126, 189, 173)', 'rgb(0, 129, 96)', 'rgb(86, 129, 118)',
  'rgb(0, 104, 78)', 'rgb(69, 104, 95)', 'rgb(0, 79, 59)', 'rgb(53, 79, 73)', 'rgb(1, 255, 255)', 'rgb(170, 255, 255)',
  'rgb(0, 189, 189)', 'rgb(126, 189, 189)', 'rgb(0, 129, 129)', 'rgb(86, 129, 129)', 'rgb(0, 104, 104)', 'rgb(69, 104, 104)',
  'rgb(0, 79, 79)', 'rgb(53, 79, 79)', 'rgb(0, 191, 255)', 'rgb(170, 234, 255)', 'rgb(0, 141, 189)', 'rgb(126, 173, 189)',
  'rgb(0, 96, 129)', 'rgb(86, 118, 129)', 'rgb(0, 78, 104)', 'rgb(69, 95, 104)', 'rgb(0, 59, 79)', 'rgb(53, 73, 79)',
  'rgb(0, 127, 255)', 'rgb(170, 212, 255)', 'rgb(0, 94, 189)', 'rgb(126, 157, 189)', 'rgb(0, 64, 129)', 'rgb(86, 107, 129)',
  'rgb(0, 52, 104)', 'rgb(69, 86, 104)', 'rgb(0, 39, 79)', 'rgb(53, 66, 79)', 'rgb(0, 63, 255)', 'rgb(170, 191, 255)',
  'rgb(0, 46, 189)', 'rgb(126, 141, 189)', 'rgb(0, 31, 129)', 'rgb(86, 96, 129)', 'rgb(0, 25, 104)', 'rgb(69, 78, 104)',
  'rgb(0, 19, 79)', 'rgb(53, 59, 79)', 'rgb(1, 0, 255)', 'rgb(170, 170, 255)', 'rgb(0, 0, 189)', 'rgb(126, 126, 189)', 'rgb(0, 0, 129)',
  'rgb(86, 86, 129)', 'rgb(0, 0, 104)', 'rgb(69, 69, 104)', 'rgb(0, 0, 79)', 'rgb(53, 53, 79)', 'rgb(63, 0, 255)', 'rgb(191, 170, 255)',
  'rgb(46, 0, 189)', 'rgb(141, 126, 189)', 'rgb(31, 0, 129)', 'rgb(96, 86, 129)', 'rgb(25, 0, 104)', 'rgb(78, 69, 104)', 'rgb(19, 0, 79)',
  'rgb(59, 53, 79)', 'rgb(127, 0, 255)', 'rgb(212, 170, 255)', 'rgb(94, 0, 189)', 'rgb(157, 126, 189)', 'rgb(64, 0, 129)',
  'rgb(107, 86, 129)', 'rgb(52, 0, 104)', 'rgb(86, 69, 104)', 'rgb(39, 0, 79)', 'rgb(66, 53, 79)', 'rgb(191, 0, 255)',
  'rgb(234, 170, 255)', 'rgb(141, 0, 189)', 'rgb(173, 126, 189)', 'rgb(96, 0, 129)', 'rgb(118, 86, 129)', 'rgb(78, 0, 104)',
  'rgb(95, 69, 104)', 'rgb(59, 0, 79)', 'rgb(73, 53, 79)', 'rgb(255, 1, 255)', 'rgb(255, 170, 255)', 'rgb(189, 0, 189)',
  'rgb(189, 126, 189)', 'rgb(129, 0, 129)', 'rgb(129, 86, 129)', 'rgb(104, 0, 104)', 'rgb(104, 69, 104)', 'rgb(79, 0, 79)',
  'rgb(79, 53, 79)', 'rgb(255, 0, 191)', 'rgb(255, 170, 234)', 'rgb(189, 0, 141)', 'rgb(189, 126, 173)', 'rgb(129, 0, 96)',
  'rgb(129, 86, 118)', 'rgb(104, 0, 78)', 'rgb(104, 69, 95)', 'rgb(79, 0, 59)', 'rgb(79, 53, 73)', 'rgb(255, 0, 127)',
  'rgb(255, 170, 212)', 'rgb(189, 0, 94)', 'rgb(189, 126, 157)', 'rgb(129, 0, 64)', 'rgb(129, 86, 107)', 'rgb(104, 0, 52)',
  'rgb(104, 69, 86)', 'rgb(79, 0, 39)', 'rgb(79, 53, 66)', 'rgb(255, 0, 63)', 'rgb(255, 170, 191)', 'rgb(189, 0, 46)', 'rgb(189, 126, 141)',
  'rgb(129, 0, 31)', 'rgb(129, 86, 96)', 'rgb(104, 0, 25)', 'rgb(104, 69, 78)', 'rgb(79, 0, 19)', 'rgb(79, 53, 59)', 'rgb(51, 51, 51)',
  'rgb(80, 80, 80)', 'rgb(105, 105, 105)', 'rgb(130, 130, 130)', 'rgb(190, 190, 190)', 'rgb(255, 255, 254)'
];
creativeCutPainter.events = {};
creativeCutPainter.on = function (e, f) {
  if (!(e in this.events)) this.events[e] = [];
  this.events[e].push(f);
};
creativeCutPainter.off = function (e) {
  if (e in this.events) delete this.events[e];
};
creativeCutPainter.runEvent = function (event, args) {
  if (typeof this.events[event] == 'object') {
    for (var e = 0; e < this.events[event].length; e++) {
      this.events[event][e].apply(this, args);
    }
  }
};
creativeCutPainter.drawLine = function (n) {
  if (typeof this.canvas != 'undefined') {
    if (typeof this.primitives[n].lineLength == 'undefined' || typeof this.primitives[n].area == 'undefined') {
      this.calculateCanvas.width = this.primitives[n].sizes.maxX - this.primitives[n].sizes.minX + 4;
      this.calculateCanvas.height = this.primitives[n].sizes.maxY - this.primitives[n].sizes.minY + 4;

      var left = this.primitives[n].sizes.minX - 2, top = this.primitives[n].sizes.minY - 2, length = 0;

      this.calculateCtx.beginPath();
      this.calculateCtx.moveTo(this.primitives[n].points[0].x - left, this.calculateCanvas.height - (this.primitives[n].points[0].y - top));
      for (var i = 1; i < this.primitives[n].points.length; i++) {
        this.calculateCtx.lineTo(this.primitives[n].points[i].x - left, this.calculateCanvas.height - (this.primitives[n].points[i].y - top));
        length += Math.sqrt(Math.pow(this.primitives[n].points[i].x - this.primitives[n].points[i - 1].x, 2) + Math.pow(this.primitives[n].points[i].y - this.primitives[n].points[i - 1].y, 2));
      }
      if (this.primitives[n].isClosed) {
        this.calculateCtx.lineTo(this.primitives[n].points[0].x - left, this.calculateCanvas.height - (this.primitives[n].points[0].y - top));
        length += Math.sqrt(Math.pow(this.primitives[n].points[0].x - this.primitives[n].points[i - 1].x, 2) + Math.pow(this.primitives[n].points[0].y - this.primitives[n].points[i - 1].y, 2));
      }
      this.primitives[n].lineLength = parseFloat(length);
      this.calculateCtx.fill();
      var data = this.calculateCtx.getImageData(0, 0, this.calculateCanvas.width, this.calculateCanvas.height), area = 0;
      for (var i = 0; i < data.data.length; i = i + 4) {
        area += data.data[i + 3] / 255;
      }
      this.primitives[n].area = parseFloat(this.primitives[n].points.length > 2 && area > 0 ? area : length);
      this.calculateCtx.clearRect(0, 0, this.calculateCanvas.width, this.calculateCanvas.height);

      if (typeof this.cuttingTypesValues[this.primitives[n].color] == 'undefined') this.cuttingTypesValues[this.primitives[n].color] = {type: 'notSet', lineLength: 0, area: 0, price: 0};
      this.cuttingTypesValues[this.primitives[n].color].lineLength += this.primitives[n].lineLength;
      this.cuttingTypesValues[this.primitives[n].color].area += this.primitives[n].area;
    }

    this.ctx.beginPath();
    this.ctx.strokeStyle = this.colors[this.primitives[n].color];
    this.ctx.fillStyle = this.colors[this.primitives[n].color];
    this.ctx.moveTo(this.primitives[n].points[0].x * this.ratio + this.origin[0], this.origin[1] - this.primitives[n].points[0].y * this.ratio);
    for (var i = 1; i < this.primitives[n].points.length; i++) {
      if (typeof this.primitives[n].points[i - 1].bulge != 'undefined' && this.primitives[n].points[i - 1].bulge >= -1 && this.primitives[n].points[i - 1].bulge <= 1 && this.primitives[n].points[i - 1].bulge != 0) {
        var arc = this.calculateArc(
          this.primitives[n].points[i - 1].x * this.ratio + this.origin[0],
          this.origin[1] - this.primitives[n].points[i - 1].y * this.ratio,
          this.primitives[n].points[i].x * this.ratio + this.origin[0],
          this.origin[1] - this.primitives[n].points[i].y * this.ratio,
          this.primitives[n].points[i - 1].bulge
        );
        this.ctx.arc(arc.x, arc.y, arc.r, arc.a1, arc.a2, arc.c);
      }
      else this.ctx.lineTo(this.primitives[n].points[i].x * this.ratio + this.origin[0], this.origin[1] - this.primitives[n].points[i].y * this.ratio);
    }
    if (this.primitives[n].isClosed) {
      if (typeof this.primitives[n].points[i - 1].bulge != 'undefined' && this.primitives[n].points[i - 1].bulge >= -1 && this.primitives[n].points[i - 1].bulge <= 1 && this.primitives[n].points[i - 1].bulge != 0) {
        var arc = this.calculateArc(
          this.primitives[n].points[i - 1].x * this.ratio + this.origin[0],
          this.origin[1] - this.primitives[n].points[i - 1].y * this.ratio,
          this.primitives[n].points[0].x * this.ratio + this.origin[0],
          this.origin[1] - this.primitives[n].points[0].y * this.ratio,
          this.primitives[n].points[i - 1].bulge
        );
        this.ctx.arc(arc.x, arc.y, arc.r, arc.a1, arc.a2, arc.c);
      }
      else this.ctx.lineTo(this.primitives[n].points[0].x * this.ratio + this.origin[0], this.origin[1] - this.primitives[n].points[0].y * this.ratio);
    }
    if (this.cuttingTypesValues[this.primitives[n].color].type in this.cuttingTypes && this.cuttingTypes[this.cuttingTypesValues[this.primitives[n].color].type].size_type == 'area') this.ctx.fill();
    else this.ctx.stroke();
  }
};
creativeCutPainter.drawEllipse = function (n) {
  if (typeof this.primitives[n].lineLength == 'undefined' || typeof this.primitives[n].area == 'undefined') {
    this.primitives[n].lineLength = parseFloat(Math.PI * (this.primitives[n].radiusX + this.primitives[n].radiusY));
    this.primitives[n].area = parseFloat(Math.PI * this.primitives[n].radiusX * this.primitives[n].radiusY);

    if (typeof this.cuttingTypesValues[this.primitives[n].color] == 'undefined') this.cuttingTypesValues[this.primitives[n].color] = {type: 'notSet', lineLength: 0, area: 0, price: 0};
    this.cuttingTypesValues[this.primitives[n].color].lineLength += this.primitives[n].lineLength;
    this.cuttingTypesValues[this.primitives[n].color].area += this.primitives[n].area;
  }

  this.ctx.beginPath();
  this.ctx.strokeStyle = this.colors[this.primitives[n].color];
  this.ctx.fillStyle = this.colors[this.primitives[n].color];
  this.ctx.ellipse(this.primitives[n].centerX * this.ratio + this.origin[0], this.origin[1] - this.primitives[n].centerY * this.ratio, this.primitives[n].radiusX * this.ratio, this.primitives[n].radiusY * this.ratio, this.primitives[n].rotation, this.primitives[n].startAngle, this.primitives[n].endAngle, this.primitives[n].anticlockwise);
  if (this.cuttingTypesValues[this.primitives[n].color].type in this.cuttingTypes && this.cuttingTypes[this.cuttingTypesValues[this.primitives[n].color].type].size_type == 'area') this.ctx.fill();
  else this.ctx.stroke();
};
creativeCutPainter.drawText = function (n) {
  if (typeof this.primitives[n].lineLength == 'undefined' || typeof this.primitives[n].area == 'undefined') {
    var textSizes = this.getTextSizes(this.primitives[n].text, this.primitives[n].size + 'px');
    this.calculateCtx.save();
    this.calculateCanvas.width = textSizes.width > 0 ? Math.ceil(textSizes.width) : 1;
    this.calculateCanvas.height = textSizes.height > 0 ? Math.ceil(textSizes.height) : 1;
    this.calculateCtx.font = this.primitives[n].size + 'px sans-serif';
    this.calculateCtx.textAlign = 'left';
    this.calculateCtx.textBaseline = 'top';

    this.primitives[n].lineLength = 0;
    this.primitives[n].area = 0;

    this.calculateCtx.strokeText(this.primitives[n].text, 0, 0);
    var data = this.calculateCtx.getImageData(0, 0, this.calculateCanvas.width, this.calculateCanvas.height);
    for (var i = 0; i < data.data.length; i = i + 4) {
      this.primitives[n].lineLength += data.data[i + 3] / 255;
    }
    this.calculateCtx.clearRect(0, 0, this.calculateCanvas.width, this.calculateCanvas.height);

    this.calculateCtx.fillText(this.primitives[n].text, 0, 0);
    data = this.calculateCtx.getImageData(0, 0, this.calculateCanvas.width, this.calculateCanvas.height);
    for (var i = 0; i < data.data.length; i = i + 4) {
      this.primitives[n].area += data.data[i + 3] / 255;
    }
    this.calculateCtx.clearRect(0, 0, this.calculateCanvas.width, this.calculateCanvas.height);

    if (typeof this.cuttingTypesValues[this.primitives[n].color] == 'undefined') this.cuttingTypesValues[this.primitives[n].color] = {type: 'notSet', lineLength: 0, area: 0, price: 0};
    this.cuttingTypesValues[this.primitives[n].color].lineLength += this.primitives[n].lineLength;
    this.cuttingTypesValues[this.primitives[n].color].area += this.primitives[n].area;
  }

  this.ctx.save();
  this.ctx.fillStyle = this.colors[this.primitives[n].color];
  this.ctx.font = this.primitives[n].size * this.ratio + 'px sans-serif';
  this.ctx.textAlign = this.primitives[n].hor;
  this.ctx.textBaseline = this.primitives[n].ver;
  this.ctx.translate(this.primitives[n].x * this.ratio + this.origin[0], this.origin[1] - this.primitives[n].y * this.ratio);
  this.ctx.rotate( - this.primitives[n].rotate);
  this.ctx.translate(this.primitives[n].correctionX * this.ratio, this.primitives[n].correctionY * this.ratio);
  this.ctx.fillText(this.primitives[n].text, 0, 0);
  
  this.ctx.restore();
};
creativeCutPainter.drawArc = function (n) {
  if (typeof this.primitives[n].lineLength == 'undefined' || typeof this.primitives[n].area == 'undefined') {
    var angle = Math.PI / 180 * (parseFloat(this.primitives[n].endAngle) < parseFloat(this.primitives[n].startAngle) ? parseFloat(this.primitives[n].endAngle) + 360 - parseFloat(this.primitives[n].startAngle) : parseFloat(this.primitives[n].endAngle) - parseFloat(this.primitives[n].startAngle));
    this.primitives[n].lineLength = parseFloat(angle * this.primitives[n].radius);
    this.primitives[n].area = parseFloat(0.5 * (angle - Math.sin(angle)) * Math.pow(this.primitives[n].radius, 2));

    if (typeof this.cuttingTypesValues[this.primitives[n].color] == 'undefined') this.cuttingTypesValues[this.primitives[n].color] = {type: 'notSet', lineLength: 0, area: 0, price: 0};
    this.cuttingTypesValues[this.primitives[n].color].lineLength += this.primitives[n].lineLength;
    this.cuttingTypesValues[this.primitives[n].color].area += this.primitives[n].area;
  }

  this.ctx.beginPath();
  this.ctx.strokeStyle = this.colors[this.primitives[n].color];
  this.ctx.fillStyle = this.colors[this.primitives[n].color];

  this.ctx.arc(this.primitives[n].centerX * this.ratio + this.origin[0], this.origin[1] - this.primitives[n].centerY * this.ratio, this.primitives[n].radius * this.ratio, - Math.PI / 180 * this.primitives[n].startAngle, - Math.PI / 180 * this.primitives[n].endAngle, true);
  if (this.cuttingTypesValues[this.primitives[n].color].type in this.cuttingTypes && this.cuttingTypes[this.cuttingTypesValues[this.primitives[n].color].type].size_type == 'area') this.ctx.fill();
  else this.ctx.stroke();
};
creativeCutPainter.calculateArc = function(x1, y1, x2, y2, b, fp) {
  var w = Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2)),
  d = this.directionVectorsToRadians(x2 - (x1 + x2) / 2, y2 - (y1 + y2) / 2) + (b > 0 ? Math.PI / 2 : - Math.PI / 2);
  if (d > Math.PI * 2) d = d - Math.PI * 2;
  if (d < 0) d = 2 * Math.PI + d;
  p3d = this.getPointsByAngle(d, Math.abs(w / 2 * b)), x3 = (x1 + x2) / 2 + p3d.x, y3 = (y1 + y2) / 2 + p3d.y,
  c = {
    x: - 0.5 * (y1 * (Math.pow(x2, 2) - Math.pow(x3, 2) + Math.pow(y2, 2) - Math.pow(y3, 2)) + y2 * ( - Math.pow(x1, 2) + Math.pow(x3, 2) - Math.pow(y1, 2) + Math.pow(y3, 2)) + y3 * (Math.pow(x1, 2) - Math.pow(x2, 2) + Math.pow(y1, 2) - Math.pow(y2, 2))) / (x1 * (y2 - y3) + x2 * (y3 - y1) + x3 * (y1 - y2)),
    y: 0.5 * (x1 * (Math.pow(x2, 2) - Math.pow(x3, 2) + Math.pow(y2, 2) - Math.pow(y3, 2)) + x2 * (- Math.pow(x1, 2) + Math.pow(x3, 2) - Math.pow(y1, 2) + Math.pow(y3, 2)) + x3 * (Math.pow(x1, 2) - Math.pow(x2, 2) + Math.pow(y1, 2) - Math.pow(y2, 2))) / (x1 * (y2 - y3) + x2 * (y3 - y1) + x3 * (y1 - y2))
  };
  return fp ? [x3, y3] : {x: c.x, y: c.y, r: Math.sqrt(Math.pow(x1 - c.x, 2) + Math.pow(y1 - c.y, 2)), a1: this.directionVectorsToRadians(x1 - c.x, y1 - c.y), a2: this.directionVectorsToRadians(x2 - c.x, y2 - c.y), c: b < 0 ? false : true};
};
creativeCutPainter.resetData = function () {
  this.sent = false;
  this.primitives = [];
  this.cuttingTypesValues = {};
  this.material = typeof this.bid.material != 'undefined' && this.bid.material !== '0' ? this.bid.material : '';
  this.size = typeof this.bid.size != 'undefined' && this.bid.size !== '0' ? this.bid.size : '';
  this.canvas = document.getElementById('creative-cut-canvas');
  this.ctx = this.canvas.getContext('2d');
  this.calculateCanvas = document.createElement('canvas');
  this.calculateCtx = this.calculateCanvas.getContext('2d');
  this.width = this.canvas.width;
  this.height = this.canvas.height;
  this.zoom = 1;
  this.unitOfMeasurement = Object.keys(this.unitsOfMeasurement)[0];
  this.scale = 1;
  this.scaleCount = 0;
  this.translate = [0, 0];
  this.distanceBetweenObjects = 0;

  $('#creative-cut-unit-of-measurement select').val(this.unitOfMeasurement);
  $('#creative-cut-total-price-value').text(this.options.price_minimum);
};
creativeCutPainter.setDraft = function () {
  this.max = ['', ''];
  this.min = ['', ''];
  for (var i = 0; i < this.primitives.length; i++) {
    if (typeof this.cuttingTypesValues[this.primitives[i].color] == 'undefined' || this.cuttingTypesValues[this.primitives[i].color].type != 'notCut') {
      if (this.min[0] === '' || this.primitives[i].sizes.minX < this.min[0]) this.min[0] = this.primitives[i].sizes.minX;
      if (this.max[0] === '' || this.primitives[i].sizes.maxX > this.max[0]) this.max[0] = this.primitives[i].sizes.maxX;
      if (this.min[1] === '' || this.primitives[i].sizes.minY < this.min[1]) this.min[1] = this.primitives[i].sizes.minY;
      if (this.max[1] === '' || this.primitives[i].sizes.maxY > this.max[1]) this.max[1] = this.primitives[i].sizes.maxY;
    }
  }
  this.workWidth = this.max[0] - this.min[0];
  this.workHeight = this.max[1] - this.min[1];

  var padding = 10;
  if (this.workWidth / (this.width - padding * 2) > this.workHeight / (this.height - padding * 2)) {
    this.ratio = (this.width - padding * 2) / this.workWidth;
    this.draftWidth = this.width;
    this.draftHeight = this.workHeight * this.ratio + padding * 2;
    this.x = 0; this.y = (this.height - this.draftHeight) / 2;
  }
  else {
    this.ratio = (this.height - padding * 2) / this.workHeight;
    this.draftWidth = this.workWidth * this.ratio + padding * 2;
    this.draftHeight = this.height;
    this.x = (this.width - this.draftWidth) / 2; this.y = 0;
  }

  this.origin = [- this.min[0] * this.ratio + this.x + padding, this.max[1] * this.ratio + this.y + padding];

  this.getDistanceBetweenObjects();

  $('.creative-cut-work-width-value').val((this.workWidth * this.zoom).toFixed(2));
  $('.creative-cut-work-height-value').val((this.workHeight * this.zoom).toFixed(2));

  $('#creative-cut-canvas-draft-left-arrow').css({display: 'block', width: this.draftWidth - padding * 2 + 'px'});
  $('#creative-cut-canvas-draft-right-arrow').css({display: 'inline-block', height: this.draftHeight - padding * 2 + 'px'});
};
creativeCutPainter.draw = function () {
  this.ctx.clearRect(0, 0, this.width, this.height);

  this.ctx.save();
  this.ctx.lineWidth = 1 / this.scale;
  this.ctx.scale(this.scale, this.scale);
  this.ctx.translate(this.translate[0], this.translate[1]);
  this.ctx.beginPath();
  this.ctx.strokeStyle = '#000';
  //this.ctx.rect(this.x, this.y, this.draftWidth, this.draftHeight);
  this.ctx.stroke();

  this.totalLineLength = 0;
  this.totalArea = 0;

  for (var i = 0; i < this.primitives.length; i++) {
    if (typeof this.cuttingTypesValues[this.primitives[i].color] == 'undefined' || this.cuttingTypesValues[this.primitives[i].color].type != 'notCut') {
      this['draw' + this.primitives[i].type](i);
      this.totalLineLength += this.primitives[i].lineLength;
      this.totalArea += this.primitives[i].area;
    }
  }

  var totalPrice = this.calculateTotalPrice().toFixed(2);
  $('#creative-cut-total-length-value').html((this.totalLineLength * this.zoom).toFixed(2));
  $('#creative-cut-total-area-value').html((this.totalArea * this.zoom * this.zoom).toFixed(2));
  if (this.isCorrectSizes()) {
    $('#creative-cut-total-price-value').html(totalPrice);
    $('#creative-cut-tax-value').html((totalPrice / 100 * this.options.tax).toFixed(2));
  }
  else {
    $('#creative-cut-total-price-value').html('0.00');
    $('#creative-cut-tax-value').html('0.00');
  }
  this.ctx.restore();
};
creativeCutPainter.setCuttingTypes = function () {
  var html = '<h2 class="section-title">הגדרת קווים</h2><ul class="canvas-cutting-types' + (isAdmin ? ' admin' : '') + '">', options = '<option value="notSet">לא מוגדר</option><option value="notCut">לא לחתוך (מחק)</option>';
  for (var k in this.cuttingTypes) {
    options += '<option value="' + k + '">' + this.cuttingTypes[k].name + '</option>';
  }
  for (var k in this.cuttingTypesValues) {
    html += '<li id="layer-' + k + '">';
    html += '<div class="img" style="background: ' + this.colors[k] + '">' + k + '</div>';
    html += '<div class="select-wrapper"><select class="cutting-type" id="cutting-type-' + k + '" onchange="creativeCutPainter.changeCuttingType(' + k + ', this.value)">' + options + '</select></div>';
    if (isAdmin) {
      html += '<ul>';
      html += '<li>Length: <span class="layer-length-value">' + this.cuttingTypesValues[k].lineLength.toFixed(2) + '</span></li>';
      html += '<li>Area: <span class="layer-area-value">' + this.cuttingTypesValues[k].area.toFixed(2) + '</span></li>';
      html += '<li>Price: <span class="layer-price-value">' + this.cuttingTypesValues[k].price.toFixed(2) + '</span></li>';
      html += '</ul>';
    }
    html += '</li>';
  }
  html += '</ul>';

  var materialsList = '<ul class="item-wrapper">', sizesList = '<ul class="item-wrapper">', materialCategory = [0, '- בחר -'], materialName = sizeName = '- בחר -';
  if (this.material) {
    for (var mc in this.materials) {
      if (this.materials[mc].materials && this.material in this.materials[mc].materials) {
        materialCategory = [this.materials[mc].id, this.materials[mc].name];
        break;
      }
    }
  }
  html += '<h2 class="section-title" id="material-size-control-title">בחירת חומר</h2><ul id="material-size-control"><li><ul><li>חומרי גלם</li><li><a href="javascript:void(0)" onclick="creativeCutPainter.showRow(\'\', this)">' + materialCategory[1] + '</a><ul class="item-wrapper">';
  for (var mc in this.materials) {
    html += '<li class="item ' + (this.materials[mc].id == materialCategory[0] ? ' current' : '') + '" onclick="creativeCutPainter.showRow(\'materials-for-' + mc + '\', this)"><img src="' + this.materials[mc].image + '"><span>' + this.materials[mc].name + '</span></li>';
    materialsList += '<li target-for="materials-for-' + mc + '"' + (this.materials[mc].id == materialCategory[0] ? ' style="display: block;"' : '') + '><ul>';
    for (var m in this.materials[mc].materials) {
      materialsList += '<li class="item' + (m == this.material ? (materialName = this.materials[mc].materials[m].name, ' current') : '') + '" onclick="creativeCutPainter.showRow(\'sizes-for-' + m + '\', this)"><img src="' + this.materials[mc].materials[m].image + '"><span>' + this.materials[mc].materials[m].name + '</span></li>';
      sizesList += '<li target-for="sizes-for-' + m + '"' + (m == this.material ? 'style="display:block;"' : '') + '><ul>';
      for (var s in this.materialSizes) {
        if (s in this.materials[mc].materials[m].prices.prices && this.materials[mc].materials[m].prices.prices[s] !== '') {
          sizesList += '<li class="item size' + (m == this.material && s == this.size ? (sizeName = this.materialSizes[s].name, ' current') : '') + '"><label onclick="$(this).closest(\'.item-wrapper\').css(\'display\', \'none\');"><input onchange="creativeCutPainter.changeMaterial(this)" type="radio" name="material" value="' + this.escapeHtml(JSON.stringify({material: m, size: s})) + '"' + (m == this.material && s == this.size ? ' checked' : '') + '><span>' + this.materialSizes[s].name + '</span>' + (s in this.materials[mc].materials[m].prices.images ? '<img class="material-size-image" src="' + this.materials[mc].materials[m].prices.images[s] + '">' : '') + '</label></li>';
        }
      }
      sizesList += '</ul></li>';
    }
    materialsList += '</ul></li>';
  }
  materialsList += '</ul>';
  sizesList += '</ul>';
  html += '</ul></li></ul></li><li><ul><li>סוגים זמינים</li><li><a href="javascript:void(0)" onclick="creativeCutPainter.showRow(\'\', this)">' + materialName + '</a>' + materialsList + '</li></ul></li>';
  html += '<li><ul><li>עובי</li><li><a href="javascript:void(0)" onclick="creativeCutPainter.showRow(\'\', this)">' + sizeName + '</a>' + sizesList + '</li></ul></li>';
  html += '</ul>';

  $('#creative-cut-settings').html(html);

  var cuttingType;
  if (this.bid.data && this.bid.data.cutting_types_values) {
    for (var ct in this.bid.data.cutting_types_values) {
      $('.canvas-cutting-types #cutting-type-' + (cuttingType = this.arraySearch(this.bid.data.cutting_types_values[ct].color, this.colors))).val(this.bid.data.cutting_types_values[ct].type);
      this.cuttingTypesValues[cuttingType].type = this.bid.data.cutting_types_values[ct].type;
    }
  }
  if (this.material && this.size) this.changeMaterial($('#material-size-control [type="radio"][name="material"]:checked')[0]);

  this.runEvent('load file');
};
creativeCutPainter.changeCuttingType = function (n, v) {
  if (typeof this.cuttingTypesValues[n] == 'object') {
    var prevType = this.cuttingTypesValues[n].type;
    if (this.material !== '' && this.size !== '') {
      for (var k in this.materials) {
        if (this.material in this.materials[k].materials) {
          if (v == 'notCut' || (typeof this.cuttingTypes[v] == 'object' && (v in this.materials[k].materials[this.material].prices.speed[this.size]) && /^\d+$/.test(this.materials[k].materials[this.material].prices.speed[this.size][v]))) {
            this.cuttingTypesValues[n].type = v;
          }
          else {
            this.cuttingTypesValues[n].type = 'notSet';
            $('#layer-' + n + ' .cutting-type').val('notSet');
          }
          this.getDistanceBetweenObjects();
          this.cuttingTypesValues[n].price = this.calcualtePrice(n);
          break;
        }
      }
    }
    else {
      if (v == 'notCut' || typeof this.cuttingTypes[v] == 'object') {
        this.cuttingTypesValues[n].type = v;
      }
      else {
        this.cuttingTypesValues[n].type = 'notSet';
        $('#layer-' + n + ' .cutting-type').val('notSet');
      }
      this.getDistanceBetweenObjects();
    }
    if (prevType == 'notCut' || v == 'notCut') {
      this.scale = 1;
      this.scaleCount = 0;
      this.translate = [0, 0];
      this.setDraft();
    }
    this.draw();
  }
};
creativeCutPainter.changeMaterial = function (e) {
  $('#material-size-control [target-for^="sizes-for-"] .item').removeClass('current');
  $('#material-size-control > li:last-child > ul > li:last-child > a').text('- בחר -');
  try {
    var res = JSON.parse(e.value), notFound = true;
    if (typeof res.material != 'undefined' && res.size != 'undefined') {
      for (var k in this.materials) {
        if (this.materials[k].materials && res.material in this.materials[k].materials && this.materials[k].materials[res.material].prices && this.materials[k].materials[res.material].prices.prices && res.size in this.materials[k].materials[res.material].prices.prices && !isNaN(this.materials[k].materials[res.material].prices.prices[res.size])) {
          for (var ctv in this.cuttingTypesValues) {
            if (!this.inArray(this.cuttingTypesValues[ctv].type, ['notSet', 'notCut']) && (!(this.cuttingTypesValues[ctv].type in this.materials[k].materials[res.material].prices.speed[res.size]) || isNaN(this.materials[k].materials[res.material].prices.speed[res.size][this.cuttingTypesValues[ctv].type]))) {
              $('#layer-' + ctv + ' .cutting-type').val('notSet');
              this.cuttingTypesValues[ctv].type = 'notSet';
            }
          }
          $('.cutting-type option').removeAttr('disabled');
          for (var ct in this.cuttingTypes) {
            if (!(ct in this.materials[k].materials[res.material].prices.speed[res.size]) || isNaN(this.materials[k].materials[res.material].prices.speed[res.size][ct])) {
              $('.cutting-type option[value="' + ct + '"]').attr('disabled', 'disabled');
            }
          }
          this.material = res.material;
          this.size = res.size;
          if (!this.isCorrectSizes()) {
            creativecut_alert('גודל הקובץ עבור ' + this.materials[k].name + ' גדול מדי, אנא פצל את הקובץ לגודל מקסימלי של ' + this.materials[k].max_width + '/' + this.materials[k].max_height + ' מ"מ');
          }
          notFound = false;
          $(e).parent().parent().addClass('current');
          $('#material-size-control > li:last-child > ul > li:last-child > a').text($(e).parent().find('span').text());
          break;
        }
      }
    }
    if (notFound) throw 'Error';
  }
  catch (ex) {
    e.checked = false;
    this.material = '';
    this.size = '';
    $('.cutting-type option').removeAttr('disabled');
  }
  
  for (var k in this.cuttingTypesValues) {
    this.cuttingTypesValues[k].price = this.calcualtePrice(k);
  }
  this.draw();
};
creativeCutPainter.changeZoom = function (e, t) {
  switch (t) {
    case 'w':
    case 'h':
      if (!isNaN(e.value) && e.value > 0) {
        this.zoom = t == 'w' ? (this.workWidth > 0 ? e.value / this.workWidth : 1) : (this.workHeight > 0 ? e.value / this.workHeight : 1);
        var _this = this;
        $('.creative-cut-work-height-value').each(function () {
          if (this != e) {
            $(this).val((_this.workHeight * _this.zoom).toFixed(2));
          }
        });
        $('.creative-cut-work-width-value').each(function () {
          if (this != e) {
            $(this).val((_this.workWidth * _this.zoom).toFixed(2));
          }
        });
      }
      else {
        $('.creative-cut-work-height-value').val((this.workHeight * this.zoom).toFixed(2));
        $('.creative-cut-work-width-value').val((this.workWidth * this.zoom).toFixed(2));
      }
      break;

    case 'u':
      if (e.value in this.unitsOfMeasurement) {
        this.unitOfMeasurement = e.value;
      }
      else {
        $('#creative-cut-unit-of-measurement select').val(this.unitOfMeasurement);
      }
      break;
  }

  if (this.inArray(t, ['w', 'h'])) {
    $('#creative-cut-total-length-value').text((this.totalLineLength * this.zoom).toFixed(2));
    $('#creative-cut-total-area-value').text((this.totalArea * this.zoom * this.zoom).toFixed(2));
    this.getDistanceBetweenObjects();
  }
  for (var k in this.cuttingTypesValues) {
    if (this.inArray(t, ['w', 'h'])) {
      $('#layer-' + k + ' .layer-length-value').text((this.cuttingTypesValues[k].lineLength * this.zoom).toFixed(2));
      $('#layer-' + k + ' .layer-area-value').text((this.cuttingTypesValues[k].area * this.zoom * this.zoom).toFixed(2));
    }
    this.cuttingTypesValues[k].price = this.calcualtePrice(k);
  }

  var totalPrice = this.calculateTotalPrice().toFixed(2);
  if (this.isCorrectSizes()) {
    $('#creative-cut-total-price-value').text(totalPrice);
    $('#creative-cut-tax-value').html((totalPrice / 100 * this.options.tax).toFixed(2));
  }
  else {
    $('#creative-cut-total-price-value').text('0.00');
    $('#creative-cut-tax-value').html('0.00');
  }
};
creativeCutPainter.canvasScroll = function (e) {
  if (typeof creativeCutPainter.ctx == 'object') {
    var scaleFactor = 1.1, delta = e.deltaY || e.detail || e.wheelDelta, prevScale = [
      creativeCutPainter.width * creativeCutPainter.scale,
      creativeCutPainter.height * creativeCutPainter.scale
    ], prevTranslate = [creativeCutPainter.translate[0] * creativeCutPainter.scale, creativeCutPainter.translate[1] * creativeCutPainter.scale];

    delta < 0 ? creativeCutPainter.scaleCount++ : creativeCutPainter.scaleCount--;
    creativeCutPainter.scale = Math.pow(scaleFactor, creativeCutPainter.scaleCount);
    creativeCutPainter.translate = [
      (creativeCutPainter.mouseMoveCoords[0] - (creativeCutPainter.mouseMoveCoords[0] - prevTranslate[0]) / prevScale[0] * creativeCutPainter.width * creativeCutPainter.scale) / creativeCutPainter.scale,
      (creativeCutPainter.mouseMoveCoords[1] - (creativeCutPainter.mouseMoveCoords[1] - prevTranslate[1]) / prevScale[1] * creativeCutPainter.height * creativeCutPainter.scale) / creativeCutPainter.scale
    ];
    creativeCutPainter.draw();

    e.preventDefault ? e.preventDefault() : (e.returnValue = false);
  }
};
creativeCutPainter.canvasScale = function (t) {
  if (typeof creativeCutPainter.ctx == 'object') {
    var scaleFactor = 1.1, prevScale = [
      this.width * this.scale,
      this.height * this.scale
    ], prevTranslate = [this.translate[0] * this.scale, this.translate[1] * this.scale];

    t == '+' ? this.scaleCount++ : this.scaleCount--;
    this.scale = Math.pow(scaleFactor, this.scaleCount);
    this.translate = [
      (this.width / 2 - (this.width / 2 - prevTranslate[0]) / prevScale[0] * this.width * this.scale) / this.scale,
      (this.height / 2 - (this.height / 2 - prevTranslate[1]) / prevScale[1] * this.height * this.scale) / this.scale
    ];
    this.draw();
  }
};
creativeCutPainter.canvasMouseMove = function (e) {
  creativeCutPainter.mouseMoveCoords = [e.offsetX + 1, e.offsetY + 1];
  if (typeof creativeCutPainter.mouseDownCoords == 'object' && typeof creativeCutPainter.ctx == 'object') {
    creativeCutPainter.translate = [
      creativeCutPainter.translate[0] + (e.offsetX - creativeCutPainter.mouseDownCoords[0]) / creativeCutPainter.scale,
      creativeCutPainter.translate[1] + (e.offsetY - creativeCutPainter.mouseDownCoords[1]) / creativeCutPainter.scale
    ];
    creativeCutPainter.mouseDownCoords = [e.offsetX, e.offsetY];
    creativeCutPainter.draw();
  }
};
creativeCutPainter.calcualtePrice = function (n) {
  if (this.material !== '' && this.size !== '' && (this.cuttingTypesValues[n].type in this.cuttingTypes) && ('laser_price_per_minute' in this.options) && !isNaN(this.options.laser_price_per_minute)) {
    var speed = 0;
    for (var k in this.materials) {
      if (this.material in this.materials[k].materials) {
        try {
          speed = this.materials[k].materials[this.material].prices.speed[this.size][this.cuttingTypesValues[n].type];
        }
        catch (e) {}
        break;
      }
    }
    if (speed) {
      var size = this.cuttingTypesValues[n][this.cuttingTypes[this.cuttingTypesValues[n].type].size_type] * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom * (this.cuttingTypes[this.cuttingTypesValues[n].type].size_type == 'area' ? this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom : 1),
      price = size / speed / 60 * this.options.laser_price_per_minute;
      $('#layer-' + n + ' .layer-price-value').text(price.toFixed(2));
      return price;
    }
  }
  $('#layer-' + n + ' .layer-price-value').text(0);
  return 0;
};
creativeCutPainter.calculateTotalPrice = function () {
  var totalPrice = 0;
  if (this.material !== '' && this.size !== '') {
    for (var k in this.materials) {
      if (this.materials[k].materials && this.material in this.materials[k].materials) {
        try {
          var width = this.workWidth * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom + 20, height = this.workHeight * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom + 20;
          totalPrice += width * height / 1000000 * this.materials[k].materials[this.material].prices.prices[this.size] + parseFloat(this.options.price_minimum);
          if ('distance_between_objects_speed' in this.options && 'distance_between_objects_price' in this.options)
            totalPrice += this.distanceBetweenObjects / this.options.distance_between_objects_speed / 60 * this.options.distance_between_objects_price;
          for (var m in this.cuttingTypesValues) {
            totalPrice += this.cuttingTypesValues[m].price;
          }
        }
        catch (e) {}
        break;
      }
    }
  }
  return totalPrice;
};
creativeCutPainter.getDistanceBetweenObjects = function () {
  this.distanceBetweenObjects = 0;
  if (this.primitives.length > 1) {
    var _this = this, f1 = function (n) {
      switch (_this.primitives[n].type) {
        case 'Line': return _this.primitives[n].points[_this.primitives[n].points.length - 1];
        case 'Arc': case 'Ellipse': return {x: _this.primitives[n].centerX, y: _this.primitives[n].centerY};
        case 'Text': return {x: _this.primitives[n].sizes.maxX, y: _this.primitives[n].sizes.maxY};
      }
    }, f2 = function (n) {
      switch (_this.primitives[n].type) {
        case 'Line': return _this.primitives[n].points[0];
        case 'Arc': case 'Ellipse': return {x: _this.primitives[n].centerX, y: _this.primitives[n].centerY};
        case 'Text': return {x: _this.primitives[n].sizes.minX, y: _this.primitives[n].sizes.minY};
      }
    };
    for (var i = 1, p1, p2; i < this.primitives.length; i++) {
      if (!(this.primitives[i - 1].color in this.cuttingTypesValues) || this.cuttingTypesValues[this.primitives[i - 1].color].type != 'notCut') {
        p1 = f1(i - 1); p2 = false;
        do {
          if (!(this.primitives[i].color in this.cuttingTypesValues) || this.cuttingTypesValues[this.primitives[i].color].type != 'notCut') {
            p2 = f2(i);
            this.distanceBetweenObjects += Math.sqrt(Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2)) * this.zoom;
          }
          else i++;
        } while(!p2 && i < this.primitives.length);
      }
    }
  }
  $('#creative-cut-distance-between-objects').text(this.distanceBetweenObjects.toFixed(2) + ('distance_between_objects_speed' in this.options && 'distance_between_objects_price' in this.options ? '(' + (this.distanceBetweenObjects / this.options.distance_between_objects_speed / 60 * this.options.distance_between_objects_price).toFixed(2) + '₪)' : ''));
};
creativeCutPainter.showRow = function (id, e) {
  if (id) {
    $('#material-size-control [target-for^="' + id.replace(/\d/g, '') + '"]').css('display', 'none');
    $('#material-size-control [target-for="' + id + '"]').css('display', 'block');
    $(e).closest('.item-wrapper').css('display', 'none');
    $(e).closest('.item-wrapper').parent().find('> a').text($(e).find('span').text());
    $(e).parent().find('> li').removeClass('current');
    $(e).addClass('current');
    if (id.replace(/\d/g, '') == 'materials-for-') {
      $('#material-size-control [target-for^="sizes-for-"]').css('display', 'none');
      $('#material-size-control [target-for^="materials-for-"]').find('.item').removeClass('current');
      $('#material-size-control > li:nth-child(2) > ul > li:last-child > a').text('- בחר -');
    }
    $('#creative-cut-settings input[type="radio"][name="material"]').prop('checked', false);
    this.changeMaterial('');
  }
  else {
    var show = $(e).parent().find('> ul')[0].style.display != 'block' ? true : false;
		$(e).parent().parent().parent().parent().find('> li > ul > li:last-child > ul').css('display', 'none');
		if (show) $(e).parent().find('> ul').css('display', 'block');
  }
};
creativeCutPainter.submitDraftData = function (link) {
  if (!this.sent && this.bidId) {
    this.sent = true;
    var _this = this, selectedCuttingTypes = true, cuttingTypesValues = '', deliveryDate = 0, address = '', entitiesToDelete = '', totalPrice = this.calculateTotalPrice().toFixed(2),
    data = 'bidId=' + this.bidId +
    '&material=' + this.material +
    '&size=' + this.size +
    '&work_width=' + (this.workWidth * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom).toFixed(2) +
    '&work_height=' + (this.workHeight * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom).toFixed(2) +
    '&total_price=' + totalPrice +
    '&tax=' + (totalPrice / 100 * this.options.tax).toFixed(2) +
    '&zoom=' + this.zoom +
    '&preview=' + encodeURIComponent(this.canvas.toDataURL().replace('data:image/png;base64,', ''));
    $('.cutting-type').removeClass('select-error');
    try {
      if (this.material === '' || this.size === '') throw 'יש להגדיר חומר';
      else if (!this.isCorrectSizes()) {
        for (var m in this.materials) {
          if (this.material in this.materials[m].materials) {
            throw 'גודל הקובץ עבור ' + this.materials[m].name + ' גדול מדי, אנא פצל את הקובץ לגודל מקסימלי של ' + this.materials[m].max_width + '/' + this.materials[m].max_height + ' מ"מ';
          }
        }
      }
      for (var k in this.cuttingTypesValues) {
        if (this.cuttingTypesValues[k].type == 'notSet') {
          selectedCuttingTypes = false;
          $('#layer-' + k + ' .cutting-type').addClass('select-error');
        }
        else if (this.cuttingTypesValues[k].type == 'notCut') {
          entitiesToDelete += '&entities_to_delete[]=' + k;
        }
        else {
          cuttingTypesValues += '&cutting_types_values[' + k + '][line_length]=' + this.cuttingTypesValues[k].lineLength * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom;
          cuttingTypesValues += '&cutting_types_values[' + k + '][area]=' + this.cuttingTypesValues[k].area * Math.pow(this.unitsOfMeasurement[this.unitOfMeasurement], 2) * Math.pow(this.zoom, 2);
          cuttingTypesValues += '&cutting_types_values[' + k + '][price]=' + this.cuttingTypesValues[k].price;
          cuttingTypesValues += '&cutting_types_values[' + k + '][type]=' + this.cuttingTypesValues[k].type;
          cuttingTypesValues += '&cutting_types_values[' + k + '][color]=' + this.colors[k];
        }
      }
      if (!selectedCuttingTypes) throw 'יש להגדיר קווים';

      data += '&total_length=' + (this.totalLineLength * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom) + '&total_area=' + (this.totalArea * Math.pow(this.unitsOfMeasurement[this.unitOfMeasurement], 2) * Math.pow(this.zoom, 2)) + cuttingTypesValues + entitiesToDelete;

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          try {
            var res = JSON.parse(this.responseText);
            if (res.status == 'fail') throw res.message;
            if (res.status != 'success') throw 'Error';
            _this.bidId = '';
            _this.runEvent('file saved successfully');
            if (link) window.location.href = link;
            else creativecut_alert('Your bid has been sent');
          }
          catch (ex) {
            _this.sent = false;
            creativecut_alert(ex);
          }
        }
      };
      xhr.open('POST', '/save-bid', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send(data);
    }
    catch (e) {
      this.sent = false;
      creativecut_alert(e);
    }
  }
};
creativeCutPainter.resetDraft = function () {
  if ('primitives' in this && this.primitives.length > 0) {
    this.scale = 1;
    this.scaleCount = 0;
    this.translate = [0, 0];
    this.draw();
  }
};
creativeCutPainter.inArray = function (val, arr) {
  if ((typeof val == 'string' || typeof val == 'integer' || typeof val == 'float') && (typeof arr == 'array' || typeof arr == 'object')) {
    for (var k in arr) {
      if (arr[k] == val) return true;
    }
  }
  return false;
};
creativeCutPainter.arraySearch = function (val, arr) {
  if ((typeof val == 'string' || typeof val == 'integer' || typeof val == 'float') && (typeof arr == 'array' || typeof arr == 'object')) {
    for (var k in arr) {
      if (arr[k] == val) return k;
    }
  }
  return false;
};
creativeCutPainter.escapeHtml = function (text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) {return map[m];});
};
creativeCutPainter.getTextSizes = function (t, si, st) {
  if (document.body !== null) {
    si = si || '10px';
    st = st || 'sans-serif';
    var div = document.createElement('div');
    div.innerHTML = t;
    div.style.fontSize = si;
    div.style.fontFamily = st;
    div.style.position = 'absolute';
    div.style.whiteSpace = 'nowrap';
    div.style.top = 0;
    div.style.visibility = 'hidden';
    document.body.appendChild(div);
    var height = div.clientHeight, width = div.clientWidth;
    document.body.removeChild(div);
    return {width: width, height: height};
  }
  return false;
};
creativeCutPainter.getSizes = function (p) {
  switch (p.type) {
    case 'ellipse':
      var wh = Math.ceil(Math.max(p.rx, p.ry)) * 2 + 4;
      this.calculateCanvas.width = wh;
      this.calculateCanvas.height = wh;
      this.calculateCtx.ellipse(wh / 2, wh / 2, p.rx, p.ry, p.r, p.sa, p.ea, p.c);
      break;

    case 'arc':
      var wh = Math.ceil(p.r) * 2 + 4;
      this.calculateCanvas.width = wh;
      this.calculateCanvas.height = wh;
      this.calculateCtx.arc(wh / 2, wh / 2, p.r, p.sa, p.ea, true);
      break;
  }
  this.calculateCtx.fill();
  var data = this.calculateCtx.getImageData(0, 0, this.calculateCanvas.width, this.calculateCanvas.height), maxX, minX, maxY, minY, k, x, y;
  for (var r = 0; r < this.calculateCanvas.height; r++) {
    for (var c = 0; c < this.calculateCanvas.width; c++) {
      k = r * this.calculateCanvas.width * 4 + c * 4 + 3;
      if (data.data[k]) {
        x = c + (1 - 1 * data.data[k] / 255); y = r + (1 - 1 * data.data[k] / 255);
        if (typeof minX == 'undefined' || minX > x) minX = x;
        if (typeof maxX == 'undefined' || maxX < x) maxX = x;
        if (typeof minY == 'undefined') minY = y;
        if (typeof maxY == 'undefined' || maxY < y) maxY = y;
      }
    }
  }
  this.calculateCtx.clearRect(0, 0, this.calculateCanvas.width, this.calculateCanvas.height);
  return {
    minX: p.x - (this.calculateCanvas.width / 2 - minX),
    maxX: p.x + (maxX - this.calculateCanvas.width / 2 ),
    minY: p.y - (this.calculateCanvas.height / 2 - minY),
    maxY: p.y + (maxY - this.calculateCanvas.height / 2)
  };
};
creativeCutPainter.directionVectorsToRadians = function (x, y) {
  var h = Math.sqrt(Math.pow(x, 2) + Math.pow(y, 2)), d = Math.asin(Math.abs(y / h));
  switch (true) {
    case x < 0 && y >= 0 : d = Math.PI - d; break;
    case x <= 0 && y < 0: d = Math.PI + d; break;
    case x > 0 && y < 0: d = 2 * Math.PI - d;
  }
  return d;
};
creativeCutPainter.getPointsByAngle = function (a, r) {
  var ta = a, cx = 1, cy = 1;
  switch (true) {
    case a > 3 * Math.PI / 2 : ta = 2 * Math.PI - a; cx = 1; cy = -1;  break;
    case a > Math.PI : ta = a - Math.PI; cx = -1; cy = -1; break;
    case a > Math.PI / 2 : ta = Math.PI - a; cx = -1; cy = 1; break;
  }
  return {x: Math.cos(ta) * r * cx, y: Math.sin(ta) * r * cy};
};
creativeCutPainter.checkAngle = function (a) {
  while (a > Math.PI * 2) a -= Math.PI * 2;
  while (a < 0) a += Math.PI * 2;
  return a;
};
creativeCutPainter.getSizesByAngle = function (sizes, angle, center) {
  if (!angle) return sizes;
  var points = [[sizes.minX, sizes.minY], [sizes.maxX, sizes.minY], [sizes.minX, sizes.maxY], [sizes.maxX, sizes.maxY]], x, y, newPoints;
  for (var p = 0; p < points.length; p++) {
    if (points[p][0] != center[0] || points[p][1] != center[1]) {
      x = points[p][0] - center[0];
      y = points[p][1] - center[1];
      newPoints = this.getPointsByAngle(this.checkAngle(this.directionVectorsToRadians(x, y) + angle), Math.sqrt(Math.pow(x, 2) + Math.pow(y, 2)));
      points[p][0] = center[0] + newPoints.x;
      points[p][1] = center[1] + newPoints.y;
    }
  }
  sizes = {minX: points[0][0], maxX: points[0][0], minY: points[0][1], maxY: points[0][1]};
  for (var p = 1; p < points.length; p++) {
    if (points[p][0] < sizes.minX) sizes.minX = points[p][0];
    if (points[p][0] > sizes.maxX) sizes.maxX = points[p][0];
    if (points[p][1] < sizes.minY) sizes.minY = points[p][1];
    if (points[p][1] > sizes.maxY) sizes.maxY = points[p][1];
  }
  return sizes;
};
creativeCutPainter.isCorrectSizes = function () {
  if (this.material !== '' && this.size !== '') {
    for (var m in this.materials) {
      if (this.material in this.materials[m].materials) {
        var width = parseFloat((this.workWidth * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom).toFixed(2)), height = parseFloat((this.workHeight * this.unitsOfMeasurement[this.unitOfMeasurement] * this.zoom).toFixed(2));
        if ((parseFloat(this.materials[m].max_width) && width > this.materials[m].max_width) || (parseFloat(this.materials[m].max_height) && height > this.materials[m].max_height)) {
          if ((parseFloat(this.materials[m].max_width) && height > this.materials[m].max_width) || (parseFloat(this.materials[m].max_height) && width > this.materials[m].max_height)) {
            return false;
          }
        }
        return true;
      }
    }
  }
  return false;
};
if (typeof creativeCutPainter.init == 'function') creativeCutPainter.init();