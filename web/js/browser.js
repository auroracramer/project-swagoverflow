$(function ()
{

var width = parseInt($("#calnotes-viewport").width()) * 2,
    height = parseInt($("#calnotes-viewport").height()) * 2;


var color = d3.scale.category20();

var force = d3.layout.force()
    .linkDistance(200)
    .linkStrength(1)
    .charge(-500)
    .gravity(.05)
    .size([width, height]);

var svg = d3.select("div#calnotes-viewport").append("svg")
    .attr("viewBox", "0 0 " + width + " " + height);

$.getJSON("api/?cmd=generate_tree", function(graph) {
  force
    .nodes(graph.nodes)
    .links(graph.links)
    .start();

  var link = svg.selectAll(".calnotes-link")
      .data(graph.links)
    .enter().append("line")
      .attr("class", "calnotes-link")
      .style("stroke-width", function(d) { return Math.sqrt(d.value); });

  var node = svg.selectAll(".calnotes-node")
      .data(graph.nodes)
    .enter().append("circle")
      .attr("class", "calnotes-node")
      .attr("cx", function(d, i) { return width/2; })
      .attr("cy", function(d, i) { return height/2; })
      .attr("r", 30)
      .style("fill", function(d) { return color(d.group); })
      .call(force.drag);

  var label = svg.selectAll(".calnotes-label")
      .data(graph.nodes)
      .enter().append("text")
      .attr("class", "calnotes-label")
      .text(function(d) { return d.name; });

  force.on("tick", function() {
    link.attr("x1", function(d) { return d.source.x; })
        .attr("y1", function(d) { return d.source.y; })
        .attr("x2", function(d) { return d.target.x; })
        .attr("y2", function(d) { return d.target.y; });

    node.attr("cx", function(d) { return d.x; })
        .attr("cy", function(d) { return d.y; });

    label.attr("x", function(d) { return d.x - 20; })
         .attr("y", function(d) { return d.y + 18; });
    
    var k = .01;
    var nodes = force.nodes();
    nodes[0].y += (height/2 - nodes[0].y) * k;
    nodes[0].x += (width/2 - nodes[0].x) * k;
    
   });

});

for(var i = 1, time = 100000, fric = 1.0; time >= 0 && fric >= 0; i++, fric-=0.0005*i, time -= 25*i){
    window.setTimeout(function() {
        force.friction(fric);
    }, time);   
}
});
