/*global $, jQuery, d3, mPHeart, graph */

(function ($) {
	"use strict";

	var d3Data = {
			'color': {
				'links': '#666',
				'osoba': "#00983e",
				'podmiot': "#7f76A9",
				'osobaDisabled': "#EEE",
				'podmiotDisabled': "#EEE"
			},
			size: {
				'distance': 900,
				'linksLength': 40,
				'linksWidth': 1,
				'linkText': '8px',
				'nodesSize': 15,
				'rootSize': 45,
				'nodeText': '12px',
				'nodeTextBox': 10,
				'nodeTextSeparate': 3,
				'nodesMarkerSize': 10,
				'nodesMarkerSpace': 2
			},
			zoomConst: {
				min: 0.5,
				max: 4
			}
		},
		connectionGraph = jQuery('#connectionGraph'),
		powiazania = connectionGraph.parents('.powiazania'),
		detailInfoWrapper = powiazania.find('.detailInfoWrapper'),
		margin = {top: -5, right: -5, bottom: -5, left: -5},
		width = connectionGraph.outerWidth() + 60 - margin.left - margin.right,
		height = connectionGraph.outerHeight() - margin.top - margin.bottom,
		dataContentWidth = ((width / 2) > 550 ? 550 : (width / 2));

	if (connectionGraph.length > 0) {
		detailInfoWrapper.css({
			top: -500,
			height: detailInfoWrapper.height() + 500
		});

		d3.json("/dane/" + connectionGraph.data('url') + "/" + connectionGraph.data('id') + "/graph.json", function (error, graph) {
			var nodes = graph.nodes,
				links = [],
				root;

			connectionGraph.find('.spinner').remove();

			if (nodes.length === 0) {
				connectionGraph.remove();
				$('.powiazania').remove();
				return;
			}

			d3Data.size.distance = Math.min(Math.max(130, 8 * nodes.length), 400);

			root = $.grep(nodes, function (e) {
				return e.id === graph.root;
			})[0];
			if (root) {

				root.fixed = true;
				root.x = (width / 2);
				root.y = d3Data.size.rootSize;
			}

			graph.relationships.forEach(function (link) {
				var s = $.grep(nodes, function (e) {
						return e.id === link.start;
					})[0],
					t = $.grep(nodes, function (e) {
						return e.id === link.end;
					})[0];
				links.push({source: s, target: t, label: link.type, id: link.id});
			});

			links.sort(function (a, b) {
				var sort;

				if (a.source.id > b.source.id) {
					sort = 1;
				} else if (a.source.id < b.source.id) {
					sort = -1;
				} else {
					if (a.target.id > b.target.id) {
						sort = 1;
					} else if (a.target.id < b.target.id) {
						sort = -1;
					} else {
						sort = 0;
					}
				}
				return sort;
			});

			var i;
			for (i = 0; i < links.length; i++) {
				if (i !== 0 &&
					links[i].source.id === links[i - 1].source.id &&
					links[i].target.id === links[i - 1].target.id) {
					links[i].linknum = links[i - 1].linknum + 1;
				}
				else {
					links[i].linknum = 1;
				}
			}

			d3Data.zoom = d3.behavior.zoom()
				.scaleExtent([d3Data.zoomConst.min, d3Data.zoomConst.max])
				.on("zoom", zoomed);

			d3Data.drag = d3.behavior.drag()
				.origin(function (d) {
					return d;
				})
				.on("dragstart", dragstarted)
				.on("drag", dragged)
				.on("dragend", dragended);

			d3Data.svg = d3.select("#connectionGraph").append("svg:svg")
				.attr("width", width + margin.left + margin.right)
				.attr("height", height + margin.top + margin.bottom)
				.append("g")
				.attr("transform", "translate(" + margin.left + "," + margin.right + ")")
				.call(d3Data.zoom)
				.on("dblclick.zoom", null)
				.on("touchstart.zoom", null)
				.on("wheel.zoom", null)
				.on("mousewheel.zoom", null);

			d3Data.borderLine = d3Data.svg.append("rect")
				.attr("width", width)
				.attr("height", height)
				.style("fill", "none")
				.style("pointer-events", "all");

			d3Data.innerContainer = d3Data.svg.append("g");

			d3Data.force = d3.layout.force()
				.gravity(0)
				.linkDistance(Math.floor((d3Data.size.linksLength + d3Data.size.distance + Math.floor(Math.random() * 20) - 10)))
				.charge(function (d, i) {
					return i ? 0 : -2000;
				})
				.nodes(d3.values(nodes))
				.links(links)
				.on("tick", tick)
				.on("start", init)
				.start();

			// Per-type markers, as they don't inherit styles.
			d3Data.innerContainer.append("svg:defs").selectAll("marker")
				.data(['arrowB'])
				.enter().append("svg:marker")
				.attr("id", function (d) {
					return d;
				})
				.attr("refX", 0)
				.attr("refY", d3Data.size.nodesMarkerSize * 0.5)
				.attr("markerWidth", d3Data.size.nodesMarkerSize)
				.attr("markerHeight", d3Data.size.nodesMarkerSize)
				.attr("orient", "auto")
				.append("svg:path")
				.attr("d", "M 0,0 0," + d3Data.size.nodesMarkerSize + " L" + d3Data.size.nodesMarkerSize * 0.5 + "," + d3Data.size.nodesMarkerSize * 0.5 + " Z");

			d3Data.innerContainer.append("svg:defs").selectAll("marker")
				.data(['arrowE'])
				.enter().append("svg:marker")
				.attr("id", function (d) {
					return d;
				})
				.attr("refX", d3Data.size.nodesMarkerSize * 0.5)
				.attr("refY", d3Data.size.nodesMarkerSize * 0.5)
				.attr("markerWidth", d3Data.size.nodesMarkerSize)
				.attr("markerHeight", d3Data.size.nodesMarkerSize)
				.attr("orient", "auto")
				.append("svg:path")
				.attr("d", "M" + d3Data.size.nodesMarkerSize * 0.75 + ",0 0," + d3Data.size.nodesMarkerSize * 0.75 + " L" + d3Data.size.nodesMarkerSize * 0.75 + "," + d3Data.size.nodesMarkerSize * 0.75 + " Z");

			/*CREATE LINE*/
			var path = d3Data.innerContainer.append("svg:g").selectAll("path")
				.data(d3Data.force.links())
				.enter().append("svg:path")
				.attr('id', function (d) {
					return 'path-' + d.source.id + '-' + d.target.id + '-' + d.label.replace(/[^a-zA-Z0-9]+/g, "");
				})
				.attr('class', 'link')
				.style({"fill": "none", "stroke-width": d3Data.size.linksWidth, 'stroke': d3Data.color.links});

			var arrowLine = d3Data.innerContainer.append("svg:g").selectAll("path")
				.data(d3Data.force.links())
				.enter().append("svg:path")
				.attr('id', function (d) {
					return 'arrowLine-' + d.source.id + '-' + d.target.id + '-' + d.label.replace(" ", "_");
				})
				.attr('class', 'arrowLine')
				.attr('marker-start', function (d) {
					return (Math.floor(d.target.x) < Math.floor(d.source.x)) ? null : "url(#arrowB)";
				})
				.attr('marker-end', function (d) {
					return (Math.floor(d.target.x) < Math.floor(d.source.x)) ? "url(#arrowE)" : null;
				})
				.style({"fill": "none", "stroke-width": 1});

			/*CREATE LINE TEXT*/
			var pathText = d3Data.innerContainer.append("svg:g")
				.selectAll("text")
				.data(links)
				.enter()
				.append('svg:text')
				.attr('dy', -2)
				.attr('text-anchor', 'middle')
				.style("font-size", d3Data.size.linkText)
				.append("svg:textPath")
				.attr('startOffset', '50%')
				.attr('xlink:href', function (d) {
					return '#path-' + d.source.id + '-' + d.target.id + '-' + d.label.replace(/[^a-zA-Z0-9]+/g, "");
				})
				.attr('class', 'pathText')
				.style("fill", "rgba(0,0,0,1")
				.text(function (d) {
					return d.label;
				});

			/*CREATE CIRCLE*/
			var circle = d3Data.innerContainer.append("svg:g").selectAll("circle")
				.data(d3Data.force.nodes())
				.enter().append("svg:circle")
				.attr('class', function (d) {
					return 'circleBottom ' + d.id;
				})
				.attr("r", function (d) {
					return (d.id === root.id) ? d3Data.size.nodesSize * 2 : d3Data.size.nodesSize;
				})
				.style("stroke-width", "2px")
				.style("stroke", function (d) {
					return d3Data.color[d.label];
				})
				.style("fill", function (d) {
					return d3Data.color[d.label];
				});

			/*CREATE CIRCLE TEXT*/
			var circleText = d3Data.innerContainer.append("svg:g")
				.selectAll("text")
				.data(nodes)
				.enter().append("svg:text")
				.attr('class', 'circleText')
				.style("text-anchor", "middle")
				.style("font-size", d3Data.size.nodeText)
				.style("fill", "#000000")
				.each(function (d) {
					var name, nameBegin, nameEnd, lines,
						limit = Math.floor(d3Data.size.nodesSize * 1.5),
						width = Math.floor(d3Data.size.nodesSize * 2),
						regex = '.{1,' + width + '}(\\s|$)' + ('|\\S+?(\\s|$)');

					name = (d.label === 'podmiot') ? d.data.nazwa : ((d.label === 'osoba') ? d.data.imiona + ' ' + d.data.nazwisko : '');

					if (d.id === root.id) {
						name = name.toUpperCase();
					}

					if (name !== '') {
						nameBegin = name.substring(0, limit);
						nameEnd = name.substring(limit);
						name = nameBegin + nameEnd.substring(0, nameEnd.indexOf(' '));
						lines = name.match(new RegExp(regex, 'g')).join('\n').split('\n');

						d3.select(this)
							.append("tspan")
							.attr('x', 0)
							.attr('y', function (d) {
								return ((d.id === root.id) ? d3Data.size.nodesSize : d3Data.size.nodesSize - 6);
							})
							.attr('font-family', 'datasets')
							.attr('font-size', function (d) {
								return (d.id === root.id) ? '3em' : '1.8em';
							})
							.attr('fill', function (d) {
								return (d.label === 'osoba') ? '#FFFFFF' : '#ffffff';
							})
							.text(function (d) {
								return (d.label === 'osoba') ? '\ue627' : '\ue62a';
							});

						for (var i = 0; i < lines.length; i++) {
							var yLine = ( (lines.length % 2 === 0) ? ((d3Data.size.nodeTextSeparate / 2) + d3Data.size.nodeTextBox) : (d3Data.size.nodeTextBox / 2)) - ( (Math.floor(lines.length / 2)) * (d3Data.size.nodeTextBox + d3Data.size.nodeTextSeparate) ) + ( i * (d3Data.size.nodeTextBox + d3Data.size.nodeTextSeparate) );
							d3.select(this)
								.append("tspan")
								.attr('x', 0)
								.attr('y', function (d) {
									return yLine + 8 + ((d.id === root.id) ? d3Data.size.nodesSize * 2 : d3Data.size.nodesSize);
								})
								.style("stroke", "rgb(255,255,255)")
								.style("stroke-width", "4px")
								.text(lines[i]);
							d3.select(this)
								.append("tspan")
								.attr('x', 0)
								.attr('y', function (d) {
									return yLine + 8 + ((d.id === root.id) ? d3Data.size.nodesSize * 2 : d3Data.size.nodesSize);
								})
								.text(lines[i]);
						}
					}
				});

			/*CREATE CIRCLE*/
			var circleDump = d3Data.innerContainer.append("svg:g").selectAll("circle")
				.data(nodes)
				.enter().append("svg:circle")
				.attr('class', 'circle')
				.attr("r", d3Data.size.nodesSize * 1.2)
				.style('fill-opacity', 0)
				.call(d3Data.drag)
				.on("mouseover", function (d) {
					var opacity = 0.2,
						arrayUnique;

					circle.classed("node-active", function (o) {
						var color = (isConnected(d, o) || (o === root)) ? d3Data.color[o.label] : d3Data.color[o.label + 'Disabled'];
						$(this).addClass('node-active').css({'fill': color, 'stroke': color});

						return false;
					});
					circleText.classed("text-active", function (o) {
						(isConnected(d, o) || (o === d) || (root === o)) ? $(this).addClass('text-active').css('opacity', 1) : $(this).addClass('text-active').css('opacity', opacity);
						return false;
					});

					arrayUnique = function (a) {
						return a.reduce(function (p, c) {
							if (p.indexOf(c) < 0) {
								p.push(c);
							}
							return p;
						}, []);
					};

					var arrowLink = [];
					arrowLine.classed("link-active", function (o) {
						(o.source === d) ? arrowLink.push(o.target.id) : ((o.target === d) ? arrowLink.push(o.source.id) : false);
						arrowLink = arrayUnique(arrowLink);
						this.setAttribute('opacity', !!(o.source === d || o.target === d) ? 1 : opacity);
						for (var j = 0; j < arrowLink.length; j++) {
							$('[id^="arrowLine-' + root.id + '-' + arrowLink[j] + '"],[id^="arrowLine-' + arrowLink[j] + '-' + root.id + '"]').addClass('link-active').attr('opacity', 1);
						}

						return false;
					});

					var pathLink = [];
					path.classed("link-active", function (o) {
						(o.source === d) ? pathLink.push(o.target.id) : ((o.target === d) ? pathLink.push(o.source.id) : false);

						pathLink = arrayUnique(pathLink);

						this.setAttribute('stroke-opacity', !!(o.source === d || o.target === d) ? 1 : opacity);
						for (var j = 0; j < pathLink.length; j++) {
							$('[id^="path-' + root.id + '-' + pathLink[j] + '"],[id^="path-' + pathLink[j] + '-' + root.id + '"]').addClass('link-active').attr('stroke-opacity', 1);
						}

						pathText.classed("text-active", function (o) {
							$(this).css('fill', 'rgba(0,0,0,' + (isConnected(d, o) || !!(o.source === d || o.target === d) ? 1 : opacity) + ')');
							for (var l = 0; l < pathLink.length; l++) {
								if (!!(o.source === root && o.target.id === pathLink[l]) || !!(o.source.id === pathLink[l] && o.target === root)) {
									$(this).addClass('text-active').css('fill', 'rgba(0,0,0,1)');
								}
							}
						});

						return false;
					});

					d3.select(this).classed("node-active", function (o) {
						d3.select('.' + d.id).classed('node-active', function () {
							$(this).css({'fill': d3Data.color[o.label], 'stroke': d3Data.color[o.label]});
							return false;
						});
						return false;
					});
				})
				.on("mouseout", function () {
					circle.classed('node-active', function (o) {
						$(this).css({'fill': d3Data.color[o.label], 'stroke': d3Data.color[o.label]});
						circleText.classed("text-active", function () {
							$(this).css('opacity', 1);
						});
						return false;
					});
					arrowLine.classed('link-active', function () {
						this.setAttribute('opacity', 1);
						return false;
					});
					path.classed('link-active', function () {
						this.setAttribute('stroke-opacity', 1);
						pathText.classed("text-active", function () {
							$(this).css('fill', 'rgba(0,0,0,1)');
						});
						return false;
					});
				})
				.on("mousedown", function (d) {
					d.mousePos = {x: Math.floor(d3.event.clientX), y: Math.floor(d3.event.clientY)};
				})
				.on("mouseup", function (d) {
					if (d.mousePos !== null && (Math.floor(d3.event.clientX) === d.mousePos.x) && (Math.floor(d3.event.clientY) === d.mousePos.y)) {
						detailInfo(d);
					}
					d.mousePos = null;
				});

			d3.select("#panControlFullscreen").on('click', function () {
				var pan = $(this),
					trans = connectionGraph.find('svg > g > g').attr('transform'),
					transStart,
					transEnd,
					transX;

				if (pan.hasClass('on')) {
					pan.removeClass('on glyphicon-resize-small').addClass('glyphicon-resize-full');
					powiazania.removeClass('fullscreen');

					transStart = (trans.indexOf('translate(')) + 10;
					transEnd = trans.indexOf(',', transStart);
					transX = Number(trans.substr(transStart, transEnd - transStart));

					connectionGraph.find('svg > g > g').attr('transform', trans.substr(0, transStart) + Number(transX - screen.width / 4) + trans.substr(transEnd));

				} else {
					pan.addClass('on glyphicon-resize-small').removeClass('glyphicon-resize-full');
					powiazania.addClass('fullscreen');

					if (trans) {
						transStart = (trans.indexOf('translate(')) + 10;
						transEnd = trans.indexOf(',', transStart);
						transX = Number(trans.substr(transStart, transEnd - transStart));

						connectionGraph.find('svg > g > g').attr('transform', trans.substr(0, transStart) + Number(transX + screen.width / 4) + trans.substr(transEnd));
					} else {
						connectionGraph.find('svg > g > g').attr('transform', 'translate(' + screen.width / 4 + ',0)scale(1)');
					}
				}

				width = connectionGraph.outerWidth() + 60 - margin.left - margin.right;
				height = connectionGraph.outerHeight() - margin.top - margin.bottom;

				d3Data.svg.attr("width", width + margin.left + margin.right).attr("height", height + margin.top + margin.bottom);
				d3Data.borderLine.attr("width", width).attr("height", height);
			});

			d3.select("#panControlCenter").on('click', function () {
				(powiazania.hasClass('fullscreen')) ? d3Data.zoom.translate([Math.floor(width / 4), 0]).scale(1) : d3Data.zoom.translate([0, 0]).scale(1);
				d3Data.zoom.event(d3Data.innerContainer.transition().duration(0));
			});

			d3.select("#panControlZoomIn").on('click', function () {
				var scale = Number(d3Data.zoom.scale() + 0.1),
					scaleSet = (scale < d3Data.zoomConst.max) ? scale : d3Data.zoomConst.max;
				d3Data.zoom.scale(scaleSet);
				d3Data.zoom.event(d3Data.innerContainer.transition().duration(0));
			});

			d3.select("#panControlZoomOut").on('click', function () {
				var scale = Number(d3Data.zoom.scale() - 0.1),
					scaleSet = (scale > d3Data.zoomConst.min) ? scale : d3Data.zoomConst.min;
				d3Data.zoom.scale(scaleSet);
				d3Data.zoom.event(d3Data.innerContainer.transition().duration(0));
			});

			var linkedByIndex = {};

			links.forEach(function (d) {
				linkedByIndex[d.source.index + "," + d.target.index] = 1;
			});

			function isConnected(a, b) {
				return linkedByIndex[a.index + "," + b.index] || linkedByIndex[b.index + "," + a.index];
			}

			function tick() {
				circle.attr("transform", transform);
				circleText.attr("transform", transform);
				circleDump.attr("transform", transform);

				path.attr("d", linkArc);
				arrowLine
					.attr("d", arrowArc)
					.attr('marker-start', function (d) {
						return (Math.floor(d.target.x) < Math.floor(d.source.x)) ? null : "url(#arrowB)";
					})
					.attr('marker-end', function (d) {
						return (Math.floor(d.target.x) < Math.floor(d.source.x)) ? "url(#arrowE)" : null;
					});

				var q = d3.geom.quadtree(nodes),
					i = 0,
					n = nodes.length;

				while (i < n) {
					q.visit(collide(nodes[i]));
					i++;
				}
			}

			function linkArc(d) {
				var sourceX = Math.floor(d.source.x),
					sourceY = Math.floor(d.source.y),
					targetX = Math.floor(d.target.x),
					targetY = Math.floor(d.target.y),
					dx = targetX - sourceX,
					dy = targetY - sourceY,
					dr = Math.floor(Math.sqrt(dx * dx + dy * dy) - (40 * d.linknum)),
					path;

				if (targetX < sourceX) {
					path = "M" + targetX + "," + targetY + "A" + dr + "," + dr + " 0 0,0 " + sourceX + "," + sourceY;
				} else {
					path = "M" + sourceX + "," + sourceY + "A" + dr + "," + dr + " 0 0,1 " + targetX + "," + targetY;
				}

				return path;
			}

			function arrowArc(d) {
				var path = d3Data.svg.select('path#path-' + d.source.id + '-' + d.target.id + '-' + d.label.replace(/[^a-zA-Z0-9]+/g, "")),
					pathEl = path.node(),
					pathSize;

				if (d.target.id === root.id) {
					pathSize = (d3Data.size.rootSize - d3Data.size.nodesMarkerSize * 0.5) - d3Data.size.nodesMarkerSpace;
				} else {
					pathSize = (d3Data.size.nodesSize + d3Data.size.nodesMarkerSize * 0.5) + d3Data.size.nodesMarkerSpace;
				}

				var pathLength = parseFloat(pathEl.getTotalLength()) || pathSize * 2,
					pathPoint,
					sourceX = Math.floor(d.source.x),
					sourceY = Math.floor(d.source.y),
					targetX = Math.floor(d.target.x),
					targetY = Math.floor(d.target.y);

				if (targetX < sourceX) {
					pathPoint = pathEl.getPointAtLength(pathSize);
					return "M" + sourceX + "," + sourceY + " L" + Math.floor(pathPoint.x) + "," + Math.floor(pathPoint.y);
				} else {
					pathPoint = pathEl.getPointAtLength(pathLength - pathSize);
					return "M" + Math.floor(pathPoint.x) + "," + Math.floor(pathPoint.y) + " L" + targetX + "," + targetY;
				}
			}

			function transform(d) {
				return "translate(" + d.x + "," + d.y + ")";
			}

			function collide(node) {
				if (node.y < d3Data.size.nodesSize) {
					node.y -= node.y - d3Data.size.nodesSize;
				}

				var radius = d3Data.size.nodesSize,
					space = 30,
					r = radius + space,
					nx1 = node.x - r,
					nx2 = node.x + r,
					ny1 = node.y - r,
					ny2 = node.y + r;

				return function (quad, x1, y1, x2, y2) {
					if (quad.point && (quad.point !== node)) {
						var x = node.x - quad.point.x,
							y = node.y - quad.point.y,
							l = Math.sqrt(x * x + y * y),
							r = (radius * 2) + space;

						if (l < r) {
							l = (l - r) / l * 0.5;
							node.x -= x *= l;
							node.y -= y *= l;
							quad.point.x += x;
							quad.point.y += y;
						}

						if (root.y > node.y) {
							node.y = root.y + d3Data.size.nodesSize / 2;
						}

						if (root.y > quad.point.y) {
							quad.point.y = root.y + d3Data.size.nodesSize / 2;
						}
					}

					if (typeof node.detailWindow !== 'undefined' && node.detailWindow === true) {
						detailInfoPosition(node);
					}

					return x1 > nx2 || x2 < nx1 || y1 > ny2 || y2 < ny1;
				};
			}

			function zoomed() {
				d3Data.innerContainer.attr("transform", "translate(" + d3.event.translate + ")scale(" + d3.event.scale + ")");
				if (detailInfoWrapper.find('.dataContent').length) {
					if ((detailInfoWrapper.find('.dataContent').data('node').y + d3.event.translate[1]) <= 0) {
						detailInfoRemove();
					} else {
						detailInfoPosition(detailInfoWrapper.find('.dataContent').data('node'));
					}
				}
			}

			function dragstarted() {
				d3.event.sourceEvent.stopPropagation();
				d3.select(this).classed("dragging", true);
			}

			function dragged(d) {
				if (d.id !== root.id) {
					d.x = d3.event.x;
					d.y = d3.event.y;
				}
				tick(d);
			}

			function dragended() {
				d3.select(this).classed("dragging", false);
			}

			function detailInfo(node) {
				var birthdayPrivacy = false;

				detailInfoRemove();

				var dataContent = $('<div></div>').addClass('dataContent').css('width', dataContentWidth).append(
					$('<div></div>').addClass('arrow')
				).append(
					$('<button></button>').addClass('btn btn-xs pull-right').text('x')
				).append(
					$('<ul></ul>').addClass('wskazniki')
				);

				var linkEl = $('<a></a>').attr({
					'href': '#',
					'target': '_self'
				}).text(mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_LINK);

				$.each(node.data, function (label, value) {
					if (label === 'mp_id') {
						if (node.label === "podmiot") {
							linkEl.attr('href', '/dane/krs_podmioty/' + value);
						} else if (node.label === "osoba") {
							linkEl.attr('href', '/dane/krs_osoby/' + value);
						}
					} else {
						var tr = $('<li></li>').append(
							$('<div></div>').addClass('row')
						);

						if (label === 'privacy_level' && Number(value) === 1) {
							birthdayPrivacy = true;
						}

						if (label === 'data_urodzenia') {
							if (birthdayPrivacy) {
								return;
							}
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_DATA_URODZENIA;
							value = ((value) ? value.split("-")[0] : ' - ');
						} else if (label === 'plec') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_PLEC;
							if (value === 'K') {
								value = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_KOBIETA;
							} else if (value === 'M') {
								value = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_MEZCZYZNA;
							}
						}
						else if (label === 'nazwisko') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_NAZWISKO;
						} else if (label === 'imiona') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_IMIONA;
						} else if (label === 'krs') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_KRS;
						} else if (label === 'kapital_zakladowy') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_KAPITAL_ZAKLADOWY;
						} else if (label === 'miejscowosc') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_MIEJSCOWOSC;
						} else if (label === 'data_rejestracji') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_REJESTRACJI;
						} else if (label === 'forma') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_FORMA_PRAWNA;
						} else if (label === 'nazwa') {
							label = mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_NAZWA;
						} else {
							return;
						}
						tr.find('.row').append($('<div></div>').addClass('col-xs-5').text(label));
						tr.find('.row').append($('<div></div>').addClass('col-xs-7').text((value) ? value : ' - '));
						dataContent.find('.wskazniki').append(tr);
					}
				});

				if (linkEl.attr('href') === "#") {
					if (node.label === "podmiot") {
						linkEl.attr('href', '/dane/krs_podmioty/' + node.id.replace(/\D/g, ''));
					} else if (node.label === "osoba") {
						linkEl.attr('href', '/dane/krs_osoby/' + node.id.replace(/\D/g, ''));
					}
				}

				var link = $('<tr></tr>').append(
					$('<td></td>').attr('colspan', 2).append(linkEl)
				);
				dataContent.find('table').append(link);

				detailInfoWrapper.append(dataContent);

				node.detailWindow = true;
				dataContent.data('node', node);

				detailInfoPosition(node);

				detailInfoWrapper.find('.dataContent .btn').click(function () {
					detailInfoRemove();
				});
			}

			function detailInfoPosition(node) {
				var windowX = 0,
					windowY = 0,
					gMain = connectionGraph.find('>svg > g'),
					gInside = gMain.find('>g'),
					detailInfo = detailInfoWrapper.find('.dataContent'),
					nodeSize = (node.id === root.id) ? d3Data.size.nodesSize * 2 : d3Data.size.nodesSize;

				var reg = /translate\(\s*([^\s,)]+)[ ,]([^\s,)]+)/,
					svgMain = reg.exec(gMain.attr('transform')),
					svgInside = reg.exec(gInside.attr('transform'));

				if (svgMain !== null) {
					windowX += parseInt(svgMain[1]);
					windowY += parseInt(svgMain[2]);
				}

				if (svgInside !== null) {
					windowX += parseInt(svgInside[1]);
					windowY += parseInt(svgInside[2]);
				}

				var nodeX = node.x + nodeSize + windowX,
					nodeY = node.y + nodeSize + windowY;

				detailInfo.css({
					top: nodeY - ((node.fixed) ? d3Data.size.nodesSize * 5.5 : d3Data.size.nodesSize * 3.5) + 500,
					left: nodeX - ((node.fixed) ? d3Data.size.nodesSize * 2 : d3Data.size.nodesSize)
				});
			}

			function detailInfoRemove() {
				var detailInfo = detailInfoWrapper.find('.dataContent');

				if (detailInfo.length > 0) {
					detailInfo.data('node').detailWindow = null;
					detailInfo.remove();
				}
			}

			function grabIcon() {
				connectionGraph.find('>svg').mousedown(function () {
					$(this).addClass('grabbing');
				}).mouseup(function () {
					$(this).removeClass('grabbing');
				});
			}

			function panIcon() {
				var powiazaniaHeader = powiazania.find('.block-header');

				if (powiazaniaHeader.find('.panControl').length === 0) {
					powiazaniaHeader.append(
						$('<div></div>').addClass('panControl btn-group').append(
							$('<div></div>').attr('id', 'panControlFullscreen').addClass('btn btn-default glyphicon glyphicon-resize-full')
						).append(
							$('<div></div>').attr('id', 'panControlCenter').addClass('btn btn-default glyphicon glyphicon-home')
						).append(
							$('<div></div>').attr('id', 'panControlZoomIn').addClass('btn btn-default glyphicon glyphicon-zoom-in')
							)
							.append(
								$('<div></div>').attr('id', 'panControlZoomOut').addClass('btn btn-default glyphicon glyphicon-zoom-out')
							)
					);
				}
			}

			/*ADDITIONAL FUNCTIONS*/
			function init() {
				grabIcon();
				panIcon();
			}
		});
	}
}(jQuery));
