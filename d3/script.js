var chart = d3.parsets()
      .dimensions(["category","disease","workplace"]);

var vis = d3.select("#chart").append("svg")
    .attr("width", chart.width())
    .attr("height", chart.height());

d3.csv("d.csv", function(error, csv) {
  vis.datum(csv).call(chart);
});