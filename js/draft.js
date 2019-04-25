$(document).ready(function () {
  (function () {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/load-file', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        try {
          var res = JSON.parse(this.responseText);
          if (res.status == 'success') {
            $('#draft-page-cart-link').attr('onclick', 'return false;');
            $('#file-upload').css('display', 'none');
            $('#draft-page').css('display', 'block');
            $('#draft-page h1').text(res.file_name);
            creativeCutPainter.bidId = res.id;
            creativeCutPainter.resetData();
            var entities = res.data.ENTITIES;
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
                  var spline = new NURBS(parseInt(entities[i][71]), controlPoints, knotValues), points = spline.geometry(),
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
                  creativeCutPainter.primitives.push({type: 'Line', isClosed: false, points: spline.geometry(), color: parseInt(entities[i][62] || 0), sizes: {minX: minX, maxX: maxX, minY: minY, maxY: maxY}});
                  break;
            
                case 'POLYLINE':
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
                    if (42 in entities[i].control_points[p]) {
                      var tp = creativeCutPainter.calculateArc(parseFloat(entities[i].control_points[p][10]), parseFloat(entities[i].control_points[p][20]), (p + 1) in entities[i].control_points ? parseFloat(entities[i].control_points[p + 1][10]) : parseFloat(entities[i].control_points[0][10]), (p + 1) in entities[i].control_points ? parseFloat(entities[i].control_points[p + 1][20]) : parseFloat(entities[i].control_points[0][20]), - entities[i].control_points[p][42], true);
                      if (tp[0] < minX) minX = tp[0];
                      if (tp[0] > maxX) maxX = tp[0];
                      if (tp[1] < minY) minY = tp[1];
                      if (tp[1] > maxY) maxY = tp[1];
                    }
                    controlPoints.push({x: parseFloat(entities[i].control_points[p][10]), y: parseFloat(entities[i].control_points[p][20]), bulge: entities[i].control_points[p][42]});
                  }
                  creativeCutPainter.primitives.push({type: 'Line', isClosed: parseInt(entities[i][70]) === 1 ? true : false, points: controlPoints, color: parseInt(entities[i][62] || 0), sizes: {minX: minX, maxX: maxX, minY: minY, maxY: maxY}});
                  break;
            
                case 'ELLIPSE':
                  var endX = parseFloat(entities[i].endpoint_of_major_axis[11]), endY = parseFloat(entities[i].endpoint_of_major_axis[21]),
                  radiusX = Math.sqrt(Math.pow(endX, 2) + Math.pow(endY, 2)), radiusY = radiusX * parseFloat(entities[i][40]),
                  centerX = parseFloat(entities[i].center[10]), centerY = parseFloat(entities[i].center[20]);
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
                    sizes: creativeCutPainter.getSizes({
                      type: 'ellipse',
                      x: centerX,
                      y: centerY,
                      rx: radiusX,
                      ry: radiusY,
                      r: - Math.atan2(endY, endX),
                      sa: parseFloat(entities[i][41]),
                      ea: parseFloat(entities[i][42]),
                      c: false,
                    })
                  });
                  break;
            
                case 'TEXT':
                case 'MTEXT':
                  //http://www.autodesk.com/techpubs/autocad/acad2000/dxf/mtext_dxf_06.htm
                  //http://www.autodesk.com/techpubs/autocad/acad2000/dxf/group_codes_in_numerical_order_dxf_01.htm
                  //http://www.cadforum.cz/cadforum_en/text-formatting-codes-in-mtext-objects-tip8640
                  
                  //https://gallery.proficad.eu/tools/autocad-viewer.aspx
                  if (entities[i][1]) {
                    var text = (('additional_texts' in entities[i] ? entities[i].additional_texts.join('') : '') + entities[i][1]).replace(/[\{\}]/g, ''),
                    texts = [], textNum = 0, params = {}, corrections = {x: 0, y: 0}, maxHeight = 0;
                    funcNextNum = function () {
                      if (typeof texts[textNum] == 'object') {
                        var textSizes = creativeCutPainter.getTextSizes(texts[textNum].text.replace(' ', '&nbsp;'), entities[i][40] + 'px');
                        texts[textNum].size = {w: textSizes.width, h: textSizes.height};
                        texts[textNum].corrections = {x: corrections.x, y: corrections.y - Math.max(textSizes.height, parseFloat(entities[i][40])) + Math.min(textSizes.height, parseFloat(entities[i][40]))};
                        corrections.x += textSizes.width;
                        if (textSizes.height > maxHeight) maxHeight = textSizes.height;
                        textNum++;
                      }
                    },
                    markers = [
                      [
                        /^\\f([\w ]+)\|b(\d+)\|i(\d+)\|c(\d+)\|p(\d+);/i,
                        function (s, f, b, i, c, p) {
                          funcNextNum();
                          params.font = f;
                          params.bold = b;
                          params.italic = i;
                          params.codepage = c;
                          params.pitch = p;
                          return '';
                        }
                      ],
                      [
                        /^\\w(\d+);/i,
                        function (s, w) {
                          funcNextNum();
                          params.textWidth = w;
                          return '';
                        }
                      ],
                      [
                        /^\\p/i,
                        function () {
                          funcNextNum();
                          corrections.x = 0;
                          corrections.y += parseFloat(maxHeight);
                          maxHeight = 0;
                          return '';
                        }
                      ]
                    ];
                    while (text) {
                      try {
                        for (var m = 0; m < markers.length; m++) {
                          if (markers[m][0].test(text)) throw m;
                        }
                        if (typeof texts[textNum] == 'undefined') texts[textNum] = {params: Object.assign({}, params), text: ''};
                        texts[textNum].text += text.substr(0, 1);
                        text = text.substr(1);
                      }
                      catch (ex) {
                        if (!isNaN(ex)) text = text.replace(markers[ex][0], markers[ex][1]);
                      }
                    }
                    funcNextNum();

                    var sizes, rotate = entities[i].type == 'MTEXT' ? (typeof entities[i][11] != 'undefined' && typeof entities[i][21] != 'undefined' ? creativeCutPainter.directionVectorsToRadians(entities[i][11], entities[i][21]) : 0) : 0;
                    for (var t = 0; t < texts.length; t++) {
                      sizes = creativeCutPainter.getSizesByAngle({
                        minX: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 4, 7]) ? parseFloat(entities[i][10]) : (creativeCutPainter.inArray(entities[i][71], [2, 5, 8]) ? parseFloat(entities[i][10]) - texts[t].size.w / 2 : parseFloat(entities[i][10]) - texts[t].size.w))  : parseFloat(entities[i][10]),
                        maxX: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 4, 7]) ? parseFloat(entities[i][10]) + texts[t].size.w : (creativeCutPainter.inArray(entities[i][71], [2, 5, 8]) ? parseFloat(entities[i][10]) + texts[t].size.w / 2 : parseFloat(entities[i][10]))) : parseFloat(entities[i][10]) + texts[t].size.w,
                        minY: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 2, 3]) ? parseFloat(entities[i][20]) - texts[t].corrections.y - parseFloat(entities[i][40]) : (creativeCutPainter.inArray(entities[i][71], [4, 5, 6]) ? parseFloat(entities[i][20]) - texts[t].corrections.y - parseFloat(entities[i][40]) / 2 : parseFloat(entities[i][20]) - texts[t].corrections.y)) : parseFloat(entities[i][20]) - texts[t].corrections.y - parseFloat(entities[i][40]),
                        maxY: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 2, 3]) ? parseFloat(entities[i][20]) - texts[t].corrections.y : (creativeCutPainter.inArray(entities[i][71], [4, 5, 6]) ? parseFloat(entities[i][20]) - texts[t].corrections.y + parseFloat(entities[i][40]) / 2 : parseFloat(entities[i][20]) - texts[t].corrections.y + parseFloat(entities[i][40]))) : parseFloat(entities[i][20]) - texts[t].corrections.y
                      }, rotate, [parseFloat(entities[i][10]), parseFloat(entities[i][20])]);
                      creativeCutPainter.primitives.push({
                        type: 'Text',
                        color: parseInt(entities[i][62] || 0),
                        text: texts[t].text,
                        x: parseFloat(entities[i][10]),
                        y: parseFloat(entities[i][20]),
                        correctionX: texts[t].corrections.x,
                        correctionY: texts[t].corrections.y,
                        size: parseFloat(entities[i][40]),
                        ver: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 2, 3]) ? 'top' : (creativeCutPainter.inArray(entities[i][71], [4, 5, 6]) ? 'middle' : 'bottom')) : 'top',
                        hor: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 4, 7]) ? 'left' : (creativeCutPainter.inArray(entities[i][71], [2, 5, 8]) ? 'center' : 'right')) : 'left',
                        dir: entities[i].type == 'MTEXT' ? (entities[i][72] == 1 ? 'ltr' : (entities[i][72] == 3 ? 'ttb' : 'inherit')) : 'ltr',
                        sizes: sizes,
                        rotate: rotate
                      });
                    }
                  }
                  //if (entities[i][1]) {
                  //  var texts = (('additional_texts' in entities[i] ? entities[i].additional_texts.join('') : '') + entities[i][1]).replace(/\{|\}/g, '').replace(/\\f[\w ]+\|b\d+\|i\d+\|c\d+\|p\d+;(?:\\W\d+;)?/g, '').split(/(?:\\p|\\n)/i), dh = 0, textSizes, sizes,
                  //  rotate = entities[i].type == 'MTEXT' ? (typeof entities[i][11] != 'undefined' && typeof entities[i][21] != 'undefined' ? creativeCutPainter.directionVectorsToRadians(entities[i][11], entities[i][21]) : 0) : 0;
                  //  for (var t = 0; t < texts.length; t++) {
                  //    if (texts[t]) {
                  //      textSizes = creativeCutPainter.getTextSizes(texts[t], entities[i][40] + 'px');
                  //      sizes = creativeCutPainter.getSizesByAngle({
                  //        minX: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 4, 7]) ? parseFloat(entities[i][10]) : (creativeCutPainter.inArray(entities[i][71], [2, 5, 8]) ? parseFloat(entities[i][10]) - textSizes.width / 2 : parseFloat(entities[i][10]) - textSizes.width))  : parseFloat(entities[i][10]),
                  //        maxX: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 4, 7]) ? parseFloat(entities[i][10]) + textSizes.width : (creativeCutPainter.inArray(entities[i][71], [2, 5, 8]) ? parseFloat(entities[i][10]) + textSizes.width / 2 : parseFloat(entities[i][10]))) : parseFloat(entities[i][10]) + textSizes.width,
                  //        minY: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 2, 3]) ? parseFloat(entities[i][20]) - dh - parseFloat(entities[i][40]) : (creativeCutPainter.inArray(entities[i][71], [4, 5, 6]) ? parseFloat(entities[i][20]) - dh - parseFloat(entities[i][40]) / 2 : parseFloat(entities[i][20]) - dh)) : parseFloat(entities[i][20]) - dh - parseFloat(entities[i][40]),
                  //        maxY: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 2, 3]) ? parseFloat(entities[i][20]) - dh : (creativeCutPainter.inArray(entities[i][71], [4, 5, 6]) ? parseFloat(entities[i][20]) - dh + parseFloat(entities[i][40]) / 2 : parseFloat(entities[i][20]) - dh + parseFloat(entities[i][40]))) : parseFloat(entities[i][20]) - dh
                  //      }, rotate, [parseFloat(entities[i][10]), parseFloat(entities[i][20])]);
                  //      creativeCutPainter.primitives.push({
                  //        type: 'Text',
                  //        color: parseInt(entities[i][62] || 0),
                  //        text: texts[t],
                  //        x: parseFloat(entities[i][10]),
                  //        y: parseFloat(entities[i][20]),
                  //        size: parseFloat(entities[i][40]),
                  //        ver: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 2, 3]) ? 'top' : (creativeCutPainter.inArray(entities[i][71], [4, 5, 6]) ? 'middle' : 'bottom')) : 'top',
                  //        hor: entities[i].type == 'MTEXT' ? (creativeCutPainter.inArray(entities[i][71], [1, 4, 7]) ? 'left' : (creativeCutPainter.inArray(entities[i][71], [2, 5, 8]) ? 'center' : 'right')) : 'left',
                  //        dir: entities[i].type == 'MTEXT' ? (entities[i][72] == 1 ? 'ltr' : (entities[i][72] == 3 ? 'ttb' : 'inherit')) : 'ltr',
                  //        sizes: sizes,
                  //        rotate: rotate,
                  //        corectionY: dh + (textSizes.height ? parseFloat(entities[i][40]) - textSizes.height : - parseFloat(entities[i][40]) * 0.28)
                  //      });
                  //      dh += parseFloat(entities[i][40]);
                  //    }
                  //  }
                  //}
                  break;
            
                case 'LINE':
                  creativeCutPainter.primitives.push({
                    type: 'Line',
                    isClosed: false,
                    points: [{x: entities[i][10], y: entities[i][20]}, {x: entities[i][11], y: entities[i][21]}],
                    color: parseInt(entities[i][62] || 0),
                    sizes: {minX: Math.min(entities[i][10], entities[i][11]), maxX: Math.max(entities[i][10], entities[i][11]), minY: Math.min(entities[i][20], entities[i][21]), maxY: Math.max(entities[i][20], entities[i][21])}
                  });
                  break;
            
                case 'ARC':
                  creativeCutPainter.primitives.push({
                    type: 'Arc',
                    centerX: parseFloat(entities[i][10]),
                    centerY: parseFloat(entities[i][20]),
                    radius: parseFloat(entities[i][40]),
                    startAngle: parseFloat(entities[i][50]),
                    endAngle: parseFloat(entities[i][51]),
                    color: parseInt(entities[i][62] || 0),
                    sizes: creativeCutPainter.getSizes({
                      type: 'arc',
                      x: parseFloat(entities[i][10]),
                      y: parseFloat(entities[i][20]),
                      r: parseFloat(entities[i][40]),
                      sa: parseFloat(entities[i][50]),
                      ea: parseFloat(entities[i][51]),
                    })
                  });
                  break;
            
                case 'CIRCLE':
                  creativeCutPainter.primitives.push({
                    type: 'Arc',
                    centerX: parseFloat(entities[i][10]),
                    centerY: parseFloat(entities[i][20]),
                    radius: parseFloat(entities[i][40]),
                    startAngle: 0,
                    endAngle: 360,
                    color: parseInt(entities[i][62] || 0),
                    sizes: {
                      minX: parseFloat(entities[i][10]) - parseFloat(entities[i][40]),
                      maxX: parseFloat(entities[i][10]) + parseFloat(entities[i][40]),
                      minY: parseFloat(entities[i][20]) - parseFloat(entities[i][40]),
                      maxY: parseFloat(entities[i][20]) + parseFloat(entities[i][40])
                    }
                  });
                  break;
              }
            }
            creativeCutPainter.setDraft();
            creativeCutPainter.draw();
            creativeCutPainter.setCuttingTypes();
          }
          else if (res.status == 'error' && res.type) {
            creativecut_alert(res.type);
          }
          else throw 1;
        }
        catch (e) {
          creativecut_alert('Error');
        }
      }
    };
    xhr.send('file_id=' + window.location.pathname.match(/^\/file\/(\d+)/)[1]);
  })();

  if ('onwheel' in document) {
    document.getElementById('creative-cut-canvas').addEventListener('wheel', creativeCutPainter.canvasScroll);
  }
  else if ('onmousewheel' in document) {
    document.getElementById('creative-cut-canvas').addEventListener('mousewheel', creativeCutPainter.canvasScroll);
  }
  else if ('DOMMouseScroll' in document) {
    document.getElementById('creative-cut-canvas').addEventListener('DOMMouseScroll', creativeCutPainter.canvasScroll);
  }
  document.getElementById('creative-cut-canvas').onmousemove = creativeCutPainter.canvasMouseMove;
  document.getElementById('creative-cut-canvas').onmousedown = function (e) {creativeCutPainter.mouseDownCoords = [e.offsetX, e.offsetY];this.style.cursor = 'move';};
  document.getElementById('creative-cut-canvas').onmouseup = function () {creativeCutPainter.mouseDownCoords = false;this.style.cursor = 'default';};
});