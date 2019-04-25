var creativeCutPainter = {
  cuttingTypes: {
    typeOne: {name: 'Type One'},
    typeTwo: {name: 'Type Two'},
    typeThree: {name: 'Type Three'},
    typeFour: {name: 'Type Four'}
  },
  cuttingTypesValdues: {},
  colors: [
    'rgb(0, 0, 0)', 'rgb(255, 0, 0)', 'rgb(255, 255, 0)', 'rgb(0, 255, 0)', 'rgb(0, 255, 255)', 'rgb(0, 0, 255)',
    'rgb(255, 0, 255)', 'rgb(255, 255, 255)', 'rgb(65, 65, 65)', 'rgb(128, 128, 128)', 'rgb(255, 0, 0)', 'rgb(255, 170, 170)',
    'rgb(189, 0, 0)', 'rgb(189, 126, 126)', 'rgb(129, 0, 0)', 'rgb(129, 86, 86)', 'rgb(104, 0, 0)', 'rgb(104, 69, 69)',
    'rgb(79, 0, 0)', 'rgb(79, 53, 53)', 'rgb(255, 63, 0)', 'rgb(255, 191, 170)', 'rgb(189, 46, 0)', 'rgb(189, 141, 126)',
    'rgb(129, 31, 0)', 'rgb(129, 96, 86)', 'rgb(104, 25, 0)', 'rgb(104, 78, 69)', 'rgb(79, 19, 0)', 'rgb(79, 59, 53)',
    'rgb(255, 127, 0)', 'rgb(255, 212, 170)', 'rgb(189, 94, 0)', 'rgb(189, 157, 126)', 'rgb(129, 64, 0)', 'rgb(129, 107, 86)',
    'rgb(104, 52, 0)', 'rgb(104, 86, 69)', 'rgb(79, 39, 0)', 'rgb(79, 66, 53)', 'rgb(255, 191, 0)', 'rgb(255, 234, 170)',
    'rgb(189, 141, 0)', 'rgb(189, 173, 126)', 'rgb(129, 96, 0)', 'rgb(129, 118, 86)', 'rgb(104, 78, 0)', 'rgb(104, 95, 69)',
    'rgb(79, 59, 0)', 'rgb(79, 73, 53)', 'rgb(255, 255, 0)', 'rgb(255, 255, 170)', 'rgb(189, 189, 0)', 'rgb(189, 189, 126)',
    'rgb(129, 129, 0)', 'rgb(129, 129, 86)', 'rgb(104, 104, 0)', 'rgb(104, 104, 69)', 'rgb(79, 79, 0)', 'rgb(79, 79, 53)',
    'rgb(191, 255, 0)', 'rgb(234, 255, 170)', 'rgb(141, 189, 0)', 'rgb(173, 189, 126)', 'rgb(96, 129, 0)', 'rgb(118, 129, 86)',
    'rgb(78, 104, 0)', 'rgb(95, 104, 69)', 'rgb(59, 79, 0)', 'rgb(73, 79, 53)', 'rgb(127, 255, 0)', 'rgb(212, 255, 170)',
    'rgb(94, 189, 0)', 'rgb(157, 189, 126)', 'rgb(64, 129, 0)', 'rgb(107, 129, 86)', 'rgb(52, 104, 0)', 'rgb(86, 104, 69)',
    'rgb(39, 79, 0)', 'rgb(66, 79, 53)', 'rgb(63, 255, 0)', 'rgb(191, 255, 170)', 'rgb(46, 189, 0)', 'rgb(141, 189, 126)',
    'rgb(31, 129, 0)', 'rgb(96, 129, 86)', 'rgb(25, 104, 0)', 'rgb(78, 104, 69)', 'rgb(19, 79, 0)', 'rgb(59, 79, 53)',
    'rgb(0, 255, 0)', 'rgb(170, 255, 170)', 'rgb(0, 189, 0)', 'rgb(126, 189, 126)', 'rgb(0, 129, 0)', 'rgb(86, 129, 86)',
    'rgb(0, 104, 0)', 'rgb(69, 104, 69)', 'rgb(0, 79, 0)', 'rgb(53, 79, 53)', 'rgb(0, 255, 63)', 'rgb(170, 255, 191)',
    'rgb(0, 189, 46)', 'rgb(126, 189, 141)', 'rgb(0, 129, 31)', 'rgb(86, 129, 96)', 'rgb(0, 104, 25)', 'rgb(69, 104, 78)',
    'rgb(0, 79, 19)', 'rgb(53, 79, 59)', 'rgb(0, 255, 127)', 'rgb(170, 255, 212)', 'rgb(0, 189, 94)', 'rgb(126, 189, 157)',
    'rgb(0, 129, 64)', 'rgb(86, 129, 107)', 'rgb(0, 104, 52)', 'rgb(69, 104, 86)', 'rgb(0, 79, 39)', 'rgb(53, 79, 66)',
    'rgb(0, 255, 191)', 'rgb(170, 255, 234)', 'rgb(0, 189, 141)', 'rgb(126, 189, 173)', 'rgb(0, 129, 96)', 'rgb(86, 129, 118)',
    'rgb(0, 104, 78)', 'rgb(69, 104, 95)', 'rgb(0, 79, 59)', 'rgb(53, 79, 73)', 'rgb(0, 255, 255)', 'rgb(170, 255, 255)',
    'rgb(0, 189, 189)', 'rgb(126, 189, 189)', 'rgb(0, 129, 129)', 'rgb(86, 129, 129)', 'rgb(0, 104, 104)', 'rgb(69, 104, 104)',
    'rgb(0, 79, 79)', 'rgb(53, 79, 79)', 'rgb(0, 191, 255)', 'rgb(170, 234, 255)', 'rgb(0, 141, 189)', 'rgb(126, 173, 189)',
    'rgb(0, 96, 129)', 'rgb(86, 118, 129)', 'rgb(0, 78, 104)', 'rgb(69, 95, 104)', 'rgb(0, 59, 79)', 'rgb(53, 73, 79)',
    'rgb(0, 127, 255)', 'rgb(170, 212, 255)', 'rgb(0, 94, 189)', 'rgb(126, 157, 189)', 'rgb(0, 64, 129)', 'rgb(86, 107, 129)',
    'rgb(0, 52, 104)', 'rgb(69, 86, 104)', 'rgb(0, 39, 79)', 'rgb(53, 66, 79)', 'rgb(0, 63, 255)', 'rgb(170, 191, 255)',
    'rgb(0, 46, 189)', 'rgb(126, 141, 189)', 'rgb(0, 31, 129)', 'rgb(86, 96, 129)', 'rgb(0, 25, 104)', 'rgb(69, 78, 104)',
    'rgb(0, 19, 79)', 'rgb(53, 59, 79)', 'rgb(0, 0, 255)', 'rgb(170, 170, 255)', 'rgb(0, 0, 189)', 'rgb(126, 126, 189)', 'rgb(0, 0, 129)',
    'rgb(86, 86, 129)', 'rgb(0, 0, 104)', 'rgb(69, 69, 104)', 'rgb(0, 0, 79)', 'rgb(53, 53, 79)', 'rgb(63, 0, 255)', 'rgb(191, 170, 255)',
    'rgb(46, 0, 189)', 'rgb(141, 126, 189)', 'rgb(31, 0, 129)', 'rgb(96, 86, 129)', 'rgb(25, 0, 104)', 'rgb(78, 69, 104)', 'rgb(19, 0, 79)',
    'rgb(59, 53, 79)', 'rgb(127, 0, 255)', 'rgb(212, 170, 255)', 'rgb(94, 0, 189)', 'rgb(157, 126, 189)', 'rgb(64, 0, 129)',
    'rgb(107, 86, 129)', 'rgb(52, 0, 104)', 'rgb(86, 69, 104)', 'rgb(39, 0, 79)', 'rgb(66, 53, 79)', 'rgb(191, 0, 255)',
    'rgb(234, 170, 255)', 'rgb(141, 0, 189)', 'rgb(173, 126, 189)', 'rgb(96, 0, 129)', 'rgb(118, 86, 129)', 'rgb(78, 0, 104)',
    'rgb(95, 69, 104)', 'rgb(59, 0, 79)', 'rgb(73, 53, 79)', 'rgb(255, 0, 255)', 'rgb(255, 170, 255)', 'rgb(189, 0, 189)',
    'rgb(189, 126, 189)', 'rgb(129, 0, 129)', 'rgb(129, 86, 129)', 'rgb(104, 0, 104)', 'rgb(104, 69, 104)', 'rgb(79, 0, 79)',
    'rgb(79, 53, 79)', 'rgb(255, 0, 191)', 'rgb(255, 170, 234)', 'rgb(189, 0, 141)', 'rgb(189, 126, 173)', 'rgb(129, 0, 96)',
    'rgb(129, 86, 118)', 'rgb(104, 0, 78)', 'rgb(104, 69, 95)', 'rgb(79, 0, 59)', 'rgb(79, 53, 73)', 'rgb(255, 0, 127)',
    'rgb(255, 170, 212)', 'rgb(189, 0, 94)', 'rgb(189, 126, 157)', 'rgb(129, 0, 64)', 'rgb(129, 86, 107)', 'rgb(104, 0, 52)',
    'rgb(104, 69, 86)', 'rgb(79, 0, 39)', 'rgb(79, 53, 66)', 'rgb(255, 0, 63)', 'rgb(255, 170, 191)', 'rgb(189, 0, 46)', 'rgb(189, 126, 141)',
    'rgb(129, 0, 31)', 'rgb(129, 86, 96)', 'rgb(104, 0, 25)', 'rgb(104, 69, 78)', 'rgb(79, 0, 19)', 'rgb(79, 53, 59)', 'rgb(51, 51, 51)',
    'rgb(80, 80, 80)', 'rgb(105, 105, 105)', 'rgb(130, 130, 130)', 'rgb(190, 190, 190)', 'rgb(255, 255, 255)'
  ],
  drawLine: function (n) {
    if (typeof this.canvas != 'undefined') {
      var g = this.primitives[n].points, c = this.primitives[n].canvas, ct = this.primitives[n].ctx,
      left = this.primitives[n].sizes.minX * this.ratio - this.primitives[n].offsetLeft,
      top = this.primitives[n].sizes.minY * this.ratio - this.primitives[n].offsetTop, length = 0;

      ct.clearRect(0, 0, c.width, c.height);

      ct.beginPath();
      ct.moveTo(g[0].x * this.ratio - left, c.height - (g[0].y * this.ratio - top));
      for (var i = 1; i < g.length; i++) {
        ct.lineTo(g[i].x * this.ratio - left, c.height - (g[i].y * this.ratio - top));
        if (typeof this.primitives[n].lineLength == 'undefined') length += Math.sqrt(Math.pow(g[i].x - g[i - 1].x, 2) + Math.pow(g[i].y - g[i - 1].y, 2));
      }
      if (typeof this.primitives[n].lineLength == 'undefined') this.primitives[n].lineLength = parseFloat(length);
      if (typeof this.primitives[n].area == 'undefined') {
        ct.fill();
        var data = ct.getImageData(0, 0, this.primitives[n].canvas.width, this.primitives[n].canvas.height), area = 0;
        for (var i = 0; i < data.data.length; i = i + 4) {
          area += data.data[i + 3] / 255;
        }
        this.primitives[n].area = parseFloat(area / Math.pow(this.ratio, 2));
        ct.clearRect(0, 0, this.primitives[n].canvas.width, this.primitives[n].canvas.height);
      }

      if (typeof this.cuttingTypesValdues[this.primitives[n].color] == 'undefined') this.cuttingTypesValdues[this.primitives[n].color] = {type: 'notSet', lineLength: 0, area: 0};
      this.cuttingTypesValdues[this.primitives[n].color].lineLength += this.primitives[n].lineLength;
      this.cuttingTypesValdues[this.primitives[n].color].area += this.primitives[n].area;

      ct.strokeStyle = this.colors[this.primitives[n].color];
      ct.stroke();
    }
  },
  drawEllipse: function (n) {
    var p = this.primitives[n], c = this.primitives[n].canvas, ct = this.primitives[n].ctx,
    left = this.primitives[n].sizes.minX * this.ratio - this.primitives[n].offsetLeft,
    top = this.primitives[n].sizes.minY * this.ratio - this.primitives[n].offsetTop;

    ct.clearRect(0, 0, c.width, c.height);

    ct.beginPath();
    ct.ellipse(p.centerX * this.ratio - left, c.height - (p.centerY * this.ratio - top), p.radiusX * this.ratio, p.radiusY * this.ratio, p.rotation, p.startAngle, p.endAngle, p.anticlockwise);
    if (typeof this.primitives[n].lineLength == 'undefined') this.primitives[n].lineLength = parseFloat(Math.PI * (p.radiusX + p.radiusY));
    if (typeof this.primitives[n].area == 'undefined') this.primitives[n].area = parseFloat(Math.PI * p.radiusX * p.radiusY);

    if (typeof this.cuttingTypesValdues[this.primitives[n].color] == 'undefined') this.cuttingTypesValdues[this.primitives[n].color] = {type: 'notSet', lineLength: 0, area: 0};
    this.cuttingTypesValdues[this.primitives[n].color].lineLength += this.primitives[n].lineLength;
    this.cuttingTypesValdues[this.primitives[n].color].area += this.primitives[n].area;

    ct.strokeStyle = this.colors[this.primitives[n].color];
    ct.stroke();
  },
  drawText: function (n) {
    
  },
  setDraft: function (max, min) {
    this.primitives = [];
    this.cuttingTypesValdues = {};
    this.canvas = document.getElementById('creative-cut-canvas');
    this.ctx = this.canvas.getContext('2d');
    this.width = this.canvas.clientWidth;
    this.height = this.canvas.clientHeight;
  
    var width = max[0] - min[0], height = max[1] - min[1], padding = 10;
    if (width / this.width > height / this.height) {
      this.ratio = (this.width - width / height * padding * 2) / width;
      this.draftWidth = this.width;
      this.draftHeight = height * (this.width / width);
      this.x = 0; this.y = (this.height - this.draftHeight) / 2;
    }
    else {
      this.ratio = (this.height - height / width * padding * 2) / height;
      this.draftWidth = width * (this.height / height);
      this.draftHeight = this.height;
      this.x = (this.width - this.draftWidth) / 2; this.y = 0;
    }
  
    this.origin = [- min[0] * this.ratio + this.x + (this.x ? padding : width / height * padding), max[1] * this.ratio + this.y + (this.y ? padding : height / width * padding)];
  },
  putPixels: function () {
    this.ctx.clearRect(0, 0, this.width, this.height);

    this.ctx.beginPath();
    this.ctx.rect(this.x, this.y, this.draftWidth, this.draftHeight);
    this.ctx.stroke();

    var data = this.ctx.getImageData(0, 0, this.width, this.height), totalLineLength = 0, totalArea = 0;
    for (var i = 0; i < this.primitives.length; i++) {
      var left = Math.round(this.primitives[i].sizes.minX * this.ratio + this.origin[0] - this.primitives[i].offsetLeft),
      top = Math.round(this.origin[1] - this.primitives[i].sizes.maxY * this.ratio - this.primitives[i].offsetTop);
      var pd = this.primitives[i].ctx.getImageData(0, 0, this.primitives[i].canvas.width, this.primitives[i].canvas.height);
      for (var r = 0; r < pd.height; r++) {
        for (var c = 0; c < pd.width; c++) {
          var point = ((top + r) * this.width + left + c) * 4;
          if (pd.data[(r * pd.width + c) * 4 + 3] > data.data[point + 3]) {
            for (var p = 0; p <= 3; p++) {
              if (point >= 0 && point < data.data.length) {
                data.data[point] = pd.data[(r * pd.width + c) * 4 + p];
              }
              point++;
            }
          }
        }
      }

      totalLineLength += parseFloat(this.primitives[i].lineLength);
      totalArea += parseFloat(this.primitives[i].area);
    }
    $('#creative-cut-total-length-value').html(totalLineLength.toFixed(3));
    $('#creative-cut-total-area-value').html(totalArea.toFixed(3));
    this.ctx.putImageData(data, 0, 0);
  },
  setImages: function () {
    for (var i = 0; i < this.primitives.length; i++) {
      if (typeof this.primitives[i].canvas == 'undefined') {
        this.primitives[i].canvas = document.createElement('canvas');
        this.primitives[i].ctx = this.primitives[i].canvas.getContext('2d');

        var width = (this.primitives[i].sizes.maxX - this.primitives[i].sizes.minX) * this.ratio,
        height = (this.primitives[i].sizes.maxY - this.primitives[i].sizes.minY) * this.ratio;
        this.primitives[i].canvas.width = this.primitives[i].canvas.height = Math.round(width > height ? width : height) + 4;
        this.primitives[i].offsetTop = 2 + (width > height ? (width - height) / 2 : 0);
        this.primitives[i].offsetLeft = 2 + (height > width ? (height - width) / 2 : 0);
      }
      this['draw' + this.primitives[i].type](i);
    }
    this.putPixels();
  },
  setCuttingTypes: function () {
    var html = '', options = '<option value="notSet">Not set</option>';
    for (var k in this.cuttingTypes) {
      options += '<option value="' + k + '">' + this.cuttingTypes[k].name + '</option>';
    }
    for (var k in this.cuttingTypesValdues) {
      html += '<li><ul>';
      html += '<li><div class="img" style="background: ' + this.colors[k] + '">' + k + '</div></li>';
      html += '<li><select onchange="creativeCutPainter.changeCuttingType(' + k + ', this.value)">' + options + '</select></li>';
      html += '<li><div class="layer-length">Length: <span class="layer-length-value">' + this.cuttingTypesValdues[k].lineLength.toFixed(3) + '</span></div>';
      html += '<div class="layer-area">Area: <span class="layer-area-value">' + this.cuttingTypesValdues[k].area.toFixed(3) + '</span></div></li>';
      html += '</ul></li>';
    }
    $('#canvas-cutting-types').html(html);
  },
  changeCuttingType: function (n, v) {
    console.log(n + ' ' + v);
  }
};

$(document).ready(function () {
  $('#graphic-module-file').change(function () {
    var allowedExtensions = ['dxf'], extension = this.files[0].name.substr(this.files[0].name.lastIndexOf('.') + 1);
    if (inArray(extension, allowedExtensions)) {
      var formData = new FormData(), xhr = new XMLHttpRequest();
      formData.append('graphic_module_file', this.files[0]);
      xhr.open('POST', '/save_file.php', true);
      xhr.upload.onprogress = function (e) {
        var percents = Math.round(e.loaded / e.total * 100);
        $('.creative-cut-loaded-percents').text(percents < 100 ? percents + '%' : 'Please, wait');
        $('#creative-cut-loaded').css('width', percents + '%');
      };
      xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          try {
            var res = JSON.parse(this.responseText);
            if (res.status == 'success') {
              creativeCutPainter.setDraft([res.data.data.HEADER.$EXTMAX[10], res.data.data.HEADER.$EXTMAX[20]], [res.data.data.HEADER.$EXTMIN[10], res.data.data.HEADER.$EXTMIN[20]]);
              var entities = res.data.data.ENTITIES;
              for (var i = 0; i < entities.length; i++) {
                switch (entities[i].type) {
                  case 'SPLINE':
                    var controlPoints = [], knotValues = [];
                    for (var cp = 0; cp < entities[i].control_points.length; cp++) {
                      controlPoints.push([parseFloat(entities[i].control_points[cp][10]), parseFloat(entities[i].control_points[cp][20]), parseFloat(entities[i].control_points[cp][30]), 1.0]);
                    }
                    for (var k = 0; k < entities[i].knot_values.length; k++) {
                      knotValues.push(parseFloat(entities[i].knot_values[k]));
                    }
                    var spline = new NURBS(parseInt(entities[i][71]), controlPoints, knotValues, controlPoints.length * 10), points = spline.geometry(),
                    minX = '', minY = '', maxX = '', maxY = '';
                    for (var p = 0; p < points.length; p++) {
                      if (minX === '') {
                        minX = points[p].x; maxX = points[p].x; minY = points[p].y; maxY = points[p].y;
                      }
                      if (points[p].x < minX) minX = points[p].x;
                      if (points[p].x > maxX) maxX = points[p].x;
                      if (points[p].y < minY) minY = points[p].y;
                      if (points[p].y > maxY) maxY = points[p].y;
                    }
                    creativeCutPainter.primitives.push({type: 'Line', points: spline.geometry(), color: parseInt(entities[i][62] || 0), sizes: {minX: minX, maxX: maxX, minY: minY, maxY: maxY}});
                    break;

                  case 'LWPOLYLINE':
                    var controlPoints = [], minX = '', minY = '', maxX = '', maxY = '';
                    for (var p = 0; p < entities[i].control_points.length; p++) {
                      if (minX === '') {
                        minX = parseFloat(entities[i].control_points[p][10]); maxX = parseFloat(entities[i].control_points[p][10]);
                        minY = parseFloat(entities[i].control_points[p][20]); maxY = parseFloat(entities[i].control_points[p][20]);
                      }
                      if (parseFloat(entities[i].control_points[p][10]) < minX) minX = parseFloat(entities[i].control_points[p][10]);
                      if (parseFloat(entities[i].control_points[p][10]) > maxX) maxX = parseFloat(entities[i].control_points[p][10]);
                      if (parseFloat(entities[i].control_points[p][20]) < minY) minY = parseFloat(entities[i].control_points[p][20]);
                      if (parseFloat(entities[i].control_points[p][20]) > maxY) maxY = parseFloat(entities[i].control_points[p][20]);
                      controlPoints.push({x: parseFloat(entities[i].control_points[p][10]), y: parseFloat(entities[i].control_points[p][20])});
                    }
                    creativeCutPainter.primitives.push({type: 'Line', points: controlPoints, color: parseInt(entities[i][62] || 0), sizes: {minX: minX, maxX: maxX, minY: minY, maxY: maxY}});
                    break;

                  case 'ELLIPSE':
                    var endX = parseFloat(entities[i].endpoint_of_major_axis[11]), endY = parseFloat(entities[i].endpoint_of_major_axis[21]),
                    radiusX = Math.sqrt(Math.pow(endX, 2) + Math.pow(endY, 2)), radiusY = radiusX * parseFloat(entities[i][40]),
                    centerX = parseInt(entities[i].center[10]), centerY = parseInt(entities[i].center[20]),
                    largestRadius = Math.max(radiusX, radiusY);
                    creativeCutPainter.primitives.push({
                      type: 'Ellipse',
                      color: parseInt(entities[i][62] || 0),
                      centerX: centerX,
                      centerY: centerY,
                      radiusX: radiusX,
                      radiusY: radiusY,
                      rotation:  - Math.atan2(endY, endX),
                      startAngle: parseFloat(entities[i][41]),
                      endAngle: parseFloat(entities[i][42]),
                      anticlockwise: false,
                      sizes: {minX: centerX - largestRadius, maxX: centerX + largestRadius, minY: centerY - largestRadius, maxY: centerY + largestRadius}
                    });
                    break;

                  case 'MTEXT':
                    //http://www.autodesk.com/techpubs/autocad/acad2000/dxf/mtext_dxf_06.htm
                    //http://www.autodesk.com/techpubs/autocad/acad2000/dxf/group_codes_in_numerical_order_dxf_01.htm
                    console.log(entities[i]);
                    //creativeCutPainter.primitives.push({type: 'Text', color: parseInt(entities[i][62] || 0), sizes: {minX: minX, maxX: maxX, minY: minY, maxY: maxY}});
                    break;
                }
              }
              creativeCutPainter.setImages();
              creativeCutPainter.setCuttingTypes();
            }
            else {
              console.log(res.type);
            }
          }
          catch (e) {
            console.log(e);
          }
        }
      };
      xhr.send(formData);
    }
    else {
      alert('Supported only ' + allowedExtensions.join(', ') + ' extensions');
    }
  });
});

function inArray(val, arr) {
  if ((typeof val == 'string' || typeof val == 'integer' || typeof val == 'float') && (typeof arr == 'array' || typeof arr == 'object')) {
    for (var k in arr) {
      if (arr[k] == val) return true;
    }
  }
  return false;
}

function getTextHeight(si, st) {
  if (document.body !== null) {
    si = si || '10px';
    st = st || 'sans-serif';
    var div = document.createElement('div');
    div.textContent = 'Mg';
    div.style.fontSize = si;
    div.style.fontFamily = st;
    div.style.position = 'absolute';
    div.style.top = 0;
    div.style.visibility = 'hidden';
    document.body.appendChild(div);
    var height = div.offsetHeight;
    document.body.removeChild(div);
    return height;
  }
  return false;
}