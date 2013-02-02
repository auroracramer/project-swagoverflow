var width = 1300,
    height = 1300;


var color = d3.scale.category20();

var force = d3.layout.force()
    .linkDistance(400)
    .linkStrength(1)
    .charge(-350)
    .gravity(.05)
    .size([width, height]);

var svg = d3.select("body").append("svg")
    .attr("viewBox", "0 0 " + width + " " + height)

d3.json("miserables.json", function(error, graph) {
  force
    .nodes(graph.nodes)
    .links(graph.links)
    .start();

  var link = svg.selectAll(".link")
      .data(graph.links)
    .enter().append("line")
      .attr("class", "link")
      .style("stroke-width", function(d) { return Math.sqrt(d.value); });

  var node = svg.selectAll(".node")
      .data(graph.nodes)
    .enter().append("circle")
      .attr("class", "node")
      .attr("cx", function(d, i) { return 20*i; })
      .attr("cy", function(d, i) { return 20*i; })
      .attr("r", 35)
      .style("fill", function(d) { return color(d.group); })
      .call(force.drag);

  var label = svg.selectAll(".label")
      .data(graph.nodes)
      .enter().append("text")
      .attr("class", "label")
      .text(function(d) { return d.name; });

  force.on("tick", function() {
    link.attr("x1", function(d) { return d.source.x; })
        .attr("y1", function(d) { return d.source.y; })
        .attr("x2", function(d) { return d.target.x; })
        .attr("y2", function(d) { return d.target.y; });
        /*
        .transition()
        .duration(100)
        .attr("r", function(d) { return d.r + 10; })
        .transition()
        .duration(100)
        .attr("r", function(d) { return d.r; });
        */

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

for(var i = 1, time = 5000, fric = 1.0; time >= 0 && fric >= 0; i++, fric-=0.01*i, time -= 500*i){
    window.setTimeout(function() {
        force.friction(fric);
    }, time);   
} 
