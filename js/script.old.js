var creativeCutPainter = {
  cuttingTypes: {
    full: {name: 'Full', type: 'stroke', color: 'rgb(0, 0, 0)'},
    half: {name: 'Half', type: 'stroke', color: 'rgb(255, 0, 0)'},
    fill: {name: 'Fill', type: 'fill', color: 'rgb(0, 0, 0)'},
    clear: {name: 'Clear', type: 'stroke', color: 'rgb(0, 0, 0)'}
  },
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
      if (typeof this.primitives[n].lineLength == 'undefined') this.primitives[n].lineLength = parseFloat(length.toFixed(3));
      this.drawPrimitive(n, left, top);
    }
  },
  drawEllipse: function (n) {
    var p = this.primitives[n], c = this.primitives[n].canvas, ct = this.primitives[n].ctx,
    left = this.primitives[n].sizes.minX * this.ratio - this.primitives[n].offsetLeft,
    top = this.primitives[n].sizes.minY * this.ratio - this.primitives[n].offsetTop;

    ct.clearRect(0, 0, c.width, c.height);

    ct.beginPath();
    ct.ellipse(p.centerX * this.ratio - left, c.height - (p.centerY * this.ratio - top), p.radiusX * this.ratio, p.radiusY * this.ratio, p.rotation, p.startAngle, p.endAngle, p.anticlockwise);
    if (typeof this.primitives[n].lineLength == 'undefined') this.primitives[n].lineLength = (Math.PI * (p.radiusX + p.radiusY)).toFixed(3);
    this.drawPrimitive(n, left, top);
  },
  drawPrimitive: function (n, left, top) {
    var c = this.primitives[n].canvas, ct = this.primitives[n].ctx;
    if (this.cuttingTypes[this.primitives[n].cuttingType].type == 'stroke') {
      ct.strokeStyle = this.cuttingTypes[this.primitives[n].cuttingType].color;
      ct.stroke();
    }
    else {
      ct.fillStyle = this.cuttingTypes[this.primitives[n].cuttingType].color;
      ct.fill();
      for (var a = n; a--;) {
        if (this.primitives[a].cuttingType == 'clear') {
          if (this.primitives[a].type == 'Line') {
            var ap = this.primitives[a].points;
            ct.beginPath();
            ct.moveTo(ap[0].x * this.ratio - left, c.height - (ap[0].y * this.ratio - top));
            for (var i = 1; i < ap.length; i++) {
              ct.lineTo(ap[i].x * this.ratio - left, c.height - (ap[i].y * this.ratio - top));
            }
          }
          else if (this.primitives[a].type == 'Ellipse') {
            var p = this.primitives[a];
            ct.beginPath();
            ct.ellipse(p.centerX * this.ratio - left, c.height - (p.centerY * this.ratio - top), p.radiusX * this.ratio, p.radiusY * this.ratio, p.rotation, p.startAngle, p.endAngle, p.anticlockwise);
          }
          ct.save();
          ct.globalCompositeOperation = 'destination-out';
          ct.stroke();
          ct.fill();
          ct.restore();
        }
      }
      var data = ct.getImageData(0, 0, this.primitives[n].canvas.width, this.primitives[n].canvas.height), area = 0;
      for (var i = 0; i < data.data.length; i = i + 4) {
        if (data.data[i + 3] == 255) {
          area++;
        }
        else if (data.data[i + 3] != 0) {
          area += 0.5;
        }
      }
      this.primitives[n].area = parseFloat((area / Math.pow(this.ratio, 2)).toFixed(3));
    }
  },
  setDraft: function (max, min) {
    this.primitives = [];
    this.canvas = document.getElementById('creative-cut-canvas');
    this.ctx = this.canvas.getContext('2d');
    this.width = this.canvas.clientWidth;
    this.height = this.canvas.clientHeight;
  
    var width = max[0] - min[0], height = max[1] - min[1], padding = 10;
    if (width / this.width > height / this.height) {
      this.ratio = (this.width - width / height * padding * 2) / width;
      this.draftWidth = this.width;
      this.draftHeight = height * (this.width / width);
      this.x = 0, this.y = (this.height - this.draftHeight) / 2;
    }
    else {
      this.ratio = (this.height - height / width * padding * 2) / height;
      this.draftWidth = width * (this.height / height);
      this.draftHeight = this.height;
      this.x = (this.width - this.draftWidth) / 2, this.y = 0;
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
      if (this.primitives[i].cuttingType != 'clear') {
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
  
        if (this.cuttingTypes[this.primitives[i].cuttingType].type == 'stroke' && typeof this.primitives[i].lineLength != 'undefined') totalLineLength += parseFloat(this.primitives[i].lineLength);
        if (this.cuttingTypes[this.primitives[i].cuttingType].type == 'fill' && typeof this.primitives[i].area != 'undefined') totalArea += parseFloat(this.primitives[i].area);
      }
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
  setLayers: function () {
    var html = '';
    for (var i = 0; i < this.primitives.length; i++) {
      var cuttingType = '<select onchange="creativeCutPainter.changeCuttingType(' + i + ', this.value)" id="cutting-type-' + i + '">';
      for (var k in this.cuttingTypes) {
        cuttingType += '<option value="' + k + '"' + (this.primitives[i].cuttingType == k ? ' selected' : '') + '>' + this.cuttingTypes[k].name + '</option>';
      }
      cuttingType += '</select>';

      html += '<li id="layer-' + i + '"><ul>';
      html += '<li><div class="img"><img src="' + this.primitives[i].canvas.toDataURL() + '"></div></li>';
      html += '<li><div class="cutting-type">' + cuttingType + '</div></li>';
      html += '<li><div class="layer-length">Length: <span class="layer-length-value">' + (this.primitives[i].lineLength || 'none') + '</span></div>';
      html += '<div class="layer-area">Area: <span class="layer-area-value">' + (this.primitives[i].area || 'none') + '</span></div></li>';
      html += '</ul></li>';
    }
    $('#canvas-layers').html(html);
  },
  changeCuttingType: function (n, v) {
    var oldType = this.primitives[n].cuttingType;
    this.primitives[n].cuttingType = v;
    if (v == 'clear' || oldType == 'clear') {
      for (var i = n + 1; i < this.primitives.length; i++) {
        if (this.cuttingTypes[this.primitives[i].cuttingType].type == 'fill') {
          this['draw' + this.primitives[i].type](i);
          $('#layer-' + i + ' img')[0].src = this.primitives[i].canvas.toDataURL();
          $('#layer-' + i + ' .layer-area .layer-area-value').html(this.primitives[i].area || 'none');
        }
      }
    }
    this['draw' + this.primitives[n].type](n);
    $('#layer-' + n + ' img')[0].src = this.primitives[n].canvas.toDataURL();
    $('#layer-' + n + ' .layer-area .layer-area-value').html(this.primitives[n].area || 'none');
    this.putPixels();
  }
};

$(document).ready(function () {
  $('#graphic-module-file').change(function () {
    var allowedExtensions = ['dxf'], extension = this.files[0].name.substr(this.files[0].name.lastIndexOf('.') + 1);
    if (inArray(extension, allowedExtensions)) {
      var formData = new FormData, xhr = new XMLHttpRequest;
      formData.append('graphic_module_file', this.files[0]);
      xhr.open('POST', '/save_file.php', true);
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
                    var spline = new NURBS(parseInt(entities[i][71]), controlPoints, knotValues, controlPoints.length * 10), points = spline.geometry()
                    minX = '', minY = '', maxX = '', maxY = '';
                    for (var p = 0; p < points.length; p++) {
                      if (minX === '') {
                        minX = points[p].x, maxX = points[p].x, minY = points[p].y, maxY = points[p].y;
                      }
                      if (points[p].x < minX) minX = points[p].x;
                      if (points[p].x > maxX) maxX = points[p].x;
                      if (points[p].y < minY) minY = points[p].y;
                      if (points[p].y > maxY) maxY = points[p].y;
                    }
                    creativeCutPainter.primitives.push({type: 'Line', points: spline.geometry(), cuttingType: Object.keys(creativeCutPainter.cuttingTypes)[0], sizes: {minX: minX, maxX: maxX, minY: minY, maxY: maxY}});
                    break;

                  case 'LWPOLYLINE':
                    var controlPoints = [], minX = '', minY = '', maxX = '', maxY = '';
                    for (var p = 0; p < entities[i].control_points.length; p++) {
                      if (minX === '') {
                        minX = parseFloat(entities[i].control_points[p][10]), maxX = parseFloat(entities[i].control_points[p][10]),
                        minY = parseFloat(entities[i].control_points[p][20]), maxY = parseFloat(entities[i].control_points[p][20]);
                      }
                      if (parseFloat(entities[i].control_points[p][10]) < minX) minX = parseFloat(entities[i].control_points[p][10]);
                      if (parseFloat(entities[i].control_points[p][10]) > maxX) maxX = parseFloat(entities[i].control_points[p][10]);
                      if (parseFloat(entities[i].control_points[p][20]) < minY) minY = parseFloat(entities[i].control_points[p][20]);
                      if (parseFloat(entities[i].control_points[p][20]) > maxY) maxY = parseFloat(entities[i].control_points[p][20]);
                      controlPoints.push({x: parseFloat(entities[i].control_points[p][10]), y: parseFloat(entities[i].control_points[p][20])});
                    }
                    creativeCutPainter.primitives.push({type: 'Line', points: controlPoints, cuttingType: Object.keys(creativeCutPainter.cuttingTypes)[0], sizes: {minX: minX, maxX: maxX, minY: minY, maxY: maxY}});
                    break;

                  case 'ELLIPSE':
                    var endX = parseFloat(entities[i].endpoint_of_major_axis[11]), endY = parseFloat(entities[i].endpoint_of_major_axis[21]),
                    radiusX = Math.sqrt(Math.pow(endX, 2) + Math.pow(endY, 2)), radiusY = radiusX * parseFloat(entities[i][40]),
                    centerX = parseInt(entities[i].center[10]), centerY = parseInt(entities[i].center[20]),
                    largestRadius = Math.max(radiusX, radiusY);
                    creativeCutPainter.primitives.push({
                      type: 'Ellipse',
                      cuttingType: Object.keys(creativeCutPainter.cuttingTypes)[0],
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
                }
              }
              creativeCutPainter.primitives.reverse();
              creativeCutPainter.setImages();
              creativeCutPainter.setLayers();
            }
            else {
              console.log(res.type);
            }
          }
          catch (e) {
            console.log(e);
          }
        }
      }
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
  return false
}