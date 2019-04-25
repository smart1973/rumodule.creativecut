function NURBS(degree, controlPoints, knotsVector) {
  this.degree = degree; this.controlPoints = controlPoints; this.knotsVector = knotsVector; this.discretization = this.knotsVector.length * 10;
}
NURBS.prototype = {
  geometry: function () {
    var point, bf, s = (this.knotsVector[this.knotsVector.length - 1] - this.knotsVector[0]) / this.discretization, points = [];
    for (var d = 0; d <= this.discretization; d++) {
      point = {x: 0, y: 0};
      for (var p = 0; p < this.controlPoints.length; p++) {
        bf = this.getBasisFunction(p, this.degree, this.knotsVector[0] + d * s - (d == this.discretization ? 0.00000001 : 0));
        point.x += bf * this.controlPoints[p][0];
        point.y += bf * this.controlPoints[p][1];
      }
      points.push(point);
    }
    return points;
  },

  getBasisFunction: function (p, d, k) {
    var den1, den2;
    if (d) {
       return ((den1 = this.knotsVector[p + d] - this.knotsVector[p]) ? (k - this.knotsVector[p]) / den1 * this.getBasisFunction(p, d - 1, k) : 0) +
              ((den2 = this.knotsVector[p + d + 1] - this.knotsVector[p + 1]) ? (this.knotsVector[p + d + 1] - k) / den2 * this.getBasisFunction(p + 1, d - 1, k) : 0);
    }
    else {
      return k >= this.knotsVector[p] && k < this.knotsVector[p + 1] ? 1 : 0;
    }
  }
};