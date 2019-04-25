function NURBS(degree, controlPoints, knotsVector) {
  this.degree = degree; this.controlPoints = controlPoints; this.knotsVector = knotsVector; this.discretization = this.knotsVector.length * 10;
}
NURBS.prototype = {
  geometry: function () {
    var points = [];
    if (this.isValidCurve()) {
      var plusKnots = 1, minusKnots = 1;
      for (var i = 0; i < this.degree; i++) {
        if (this.knotsVector[i] == this.knotsVector[i + 1]) {
          plusKnots++;
        }
      }
      for (var i = this.knotsVector.length - 1; i > this.knotsVector.length - this.degree - 1; i--) {
        if (this.knotsVector[i] == this.knotsVector[i - 1]) {
          minusKnots++;
        }
      }
      var lastKnot = this.knotsVector[this.knotsVector.length - 1], firstKnot = this.knotsVector[0], step = (lastKnot - firstKnot) / this.discretization;
      if(plusKnots != this.degree + 1) {
        firstKnot = this.knotsVector[this.degree];
      }
      if(minusKnots != this.degree + 1){
        lastKnot= this.knotsVector[this.knotsVector.length - 1 - this.degree];
      }
      for(var i = 0; i <= this.discretization; i++) {
        var time = firstKnot + i * step;
        if (time < lastKnot) {
          points.push(this.getPoint(time));
          if (this.getKnotKey(time) != this.getKnotKey(time + step)) points.push(this.getPoint(this.knotsVector[this.getKnotKey(time + step)]));
        }
      }
      points.push(this.getPoint(lastKnot));
    }
    return points;
  },

  getKnotKey: function (t) {
    for (var i = this.knotsVector.length; i--;) {
      if (t >= this.knotsVector[i]) return i;
    }
    return false;
  },

  getPoint: function (time) {
    var knot = this.getKnot(time), correctioins = this.getCorrections(knot, time), point = {x: 0, y: 0, z: 0, w: 0};
    for(var i = 0; i <= this.degree; i++) {
      var controlPoint = this.controlPoints[knot - this.degree + i], weight = controlPoint[3] * correctioins[i];
      point.x += controlPoint[0] * weight;
      point.y += controlPoint[1] * weight;
      point.z += controlPoint[2] * weight;
      point.w += controlPoint[3] * correctioins[i];
    }
    return point;
  },

  getKnot: function (time) {
    var degree = this.degree, knot = this.knotsVector.length - degree - 1;
    if(time >= this.knotsVector[knot]) {
      return knot - 1;
    }
    if(time <= this.knotsVector[degree]) {
      return degree;
    }
    var knot2 = Math.floor((degree + knot) / 2);
    while(time < this.knotsVector[knot2] || time >= this.knotsVector[knot2 + 1]) {
      if(time < this.knotsVector[knot2]) {
        knot= knot2;
      }
      else {
        degree = knot2;
      }
      knot2 = Math.floor((degree + knot) / 2);
    }
    return knot2;
  },

  getCorrections: function (knot, time) {
    var cor1 = [1.0], cor2 = [], cor3 = [];
    for(var i = 1; i <= this.degree; i++) {
      cor2[i]= time - this.knotsVector[knot + 1 - i];
      cor3[i]= this.knotsVector[knot + i] - time;
      var val = 0.0;
      for(var n = 0; n < i; n++) {
        var val1 = cor3[n + 1], val2 = cor2[i - n], val3 = cor1[n] / (val1 + val2);
        cor1[n] = val + val1 * val3;
        val = val2 * val3;
      }
      cor1[i]= val;
    }
    return cor1;
  },

  isValidCurve: function() {
    return this.controlPoints.length >= this.degree + 1 ? true : false;
  }
};