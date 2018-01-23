'use strict';

/* globals d3 */

var calendarHeatmap = {

    settings: {
        gutter: 5,
        item_gutter: 1,
        width: 1000,
        height: 200,
        item_size: 10,
        label_padding: 40,
        max_block_height: 20,
        transition_duration: 500,
    },

    /**
     * Initialize
     */
    init: function (data, color, overview, handler, int1, int2) {
        
        // Set calendar data
        calendarHeatmap.data = data;

        // Set calendar color
        calendarHeatmap.color = color || '#ff4500';

        // Initialize current overview type and history
        calendarHeatmap.overview = overview || 'global';
        calendarHeatmap.history = ['global'];
        calendarHeatmap.selected = {};

        // Set handler function
        calendarHeatmap.handler = handler;

        // No transition to start with
        calendarHeatmap.in_transition = false;

        // Create html elementsfor the calendar
        calendarHeatmap.createElements();

        // Parse data for summary details
        calendarHeatmap.parseData();

        // Draw the chart
        calendarHeatmap.drawChart();
    },

    /**
     * Create html elements for the calendar
     */
    createElements: function () {
        // Create main html container for the calendar
        var container = document.createElement('div');
        container.className = 'calendar-heatmap';
        document.body.appendChild(container);
        d3.select(container).attr('id', 'idheatmap');

        // Create svg element
        var svg = d3.select(container).append('svg')
                .attr('class', 'svg').attr('id', 'idsv');

        // Create other svg elements
        calendarHeatmap.items = svg.append('g');
        calendarHeatmap.labels = svg.append('g').attr('width',container.clientWidth-400);



        // Calculate dimensions based on available width
        var calcDimensions = function () {

            var dayIndex = Math.round((moment() - moment().subtract(1, 'year').startOf('week')) / 86400000);
            var colIndex = Math.trunc(dayIndex / 7);
            var numWeeks = colIndex + 1;

            calendarHeatmap.settings.width = container.clientWidth;
            calendarHeatmap.settings.item_size = ((calendarHeatmap.settings.width - calendarHeatmap.settings.label_padding) / numWeeks - calendarHeatmap.settings.gutter);
            calendarHeatmap.settings.height = calendarHeatmap.settings.label_padding + 7 * (calendarHeatmap.settings.item_size + calendarHeatmap.settings.gutter);
            svg.attr('width', container.clientWidth)
                    .attr('height', calendarHeatmap.settings.height);

            if (!!calendarHeatmap.data && !!calendarHeatmap.data[0].summary) {
                calendarHeatmap.drawChart();
            }
        };
        calcDimensions();
        
        window.onload = function (event) {
            calcDimensions();
        };
        window.onresize = function (event) {
            calcDimensions();
        };
    },

    /**
     * Parse data for summary in case it was not provided
     */
    parseData: function () {
        if (!calendarHeatmap.data) {
            return;
        }

        // Get daily summary if that was not provided
        if (!calendarHeatmap.data[0].summary) {
            calendarHeatmap.data.map(function (d) {
                var summary = d.details.reduce(function (uniques, project) {
                    if (!uniques[project.name]) {
                        uniques[project.name] = {
                            'value': project.value
                        };
                    } else {
                        uniques[project.name].value += project.value;
                    }
                    return uniques;
                }, {});
                var unsorted_summary = Object.keys(summary).map(function (key) {
                    return {
                        'name': key,
                        'value': summary[key].value
                    };
                });
                d.summary = unsorted_summary.sort(function (a, b) {
                    return b.value - a.value;
                });
                return d;
            });
        }
    },

    /**
     * Draw the chart based on the current overview type
     */
    drawChart: function () {
        calendarHeatmap.drawDayOverview();

    }
    , drawChart: function () {
        "global" === calendarHeatmap.overview ? calendarHeatmap.drawGlobalOverview() : "year" === calendarHeatmap.overview ? calendarHeatmap.drawYearOverview() : "month" === calendarHeatmap.overview ? calendarHeatmap.drawMonthOverview() : "week" === calendarHeatmap.overview ? calendarHeatmap.drawWeekOverview() : "day" === calendarHeatmap.overview && calendarHeatmap.drawDayOverview()
    }, drawGlobalOverview: function () {

    }, drawYearOverview: function () {

    }, drawMonthOverview: function () {

    }, drawWeekOverview: function () {

    }, drawDayOverview: function () {
        calendarHeatmap.history[calendarHeatmap.history.length - 1] !== calendarHeatmap.overview && calendarHeatmap.history.push(calendarHeatmap.overview), Object.keys(calendarHeatmap.selected).length || (calendarHeatmap.selected = calendarHeatmap.data[calendarHeatmap.data.length - 1]);
        var a = calendarHeatmap.selected.summary.map(function (a) {
            return a.name
        }),// e = d3.scaleBand().rangeRound([calendarHeatmap.settings.label_padding, calendarHeatmap.settings.height]).domain(a), t = d3.scaleTime().range([2 * calendarHeatmap.settings.label_padding, calendarHeatmap.settings.width]).domain([moment(calendarHeatmap.selected.date).startOf("day"), moment(calendarHeatmap.selected.date).endOf("day")]);
        e = d3.scaleBand().rangeRound([calendarHeatmap.settings.label_padding, calendarHeatmap.settings.height]).domain(a), t = d3.scaleTime().range([2 * calendarHeatmap.settings.label_padding, calendarHeatmap.settings.width]).domain([moment(calendarHeatmap.selected.date).setHours(int1), moment(calendarHeatmap.selected.date).setHours(int2+1)]);
        calendarHeatmap.items.selectAll(".item-block").remove(), calendarHeatmap.items.selectAll(".item-block").data(calendarHeatmap.selected.details).enter().append("rect").attr("class", "item item-block").attr("x", function (a) {
            return t(moment(a.date))
        }).attr("y", function (a) {
            return e(a.name) + e.bandwidth() / 2 - 15
        }).attr("width", function (a) {
            var e = t(d3.timeSecond.offset(moment(a.date), a.value));
            return Math.max(e - t(moment(a.date)), 1)
        }).attr("height", function () {
            return Math.min(e.bandwidth(), calendarHeatmap.settings.max_block_height)
        }).attr("fill", function () {
            return calendarHeatmap.color || "#ff4500"
        }).style("opacity", 0).on("click", function (a) {
            calendarHeatmap.handler && "function" == typeof calendarHeatmap.handler && calendarHeatmap.handler(a)
        }).transition().delay(function () {
            return(Math.cos(Math.PI * Math.random()) + 1) * calendarHeatmap.settings.transition_duration
        }).duration(function () {
            return calendarHeatmap.settings.transition_duration
        }).ease(d3.easeLinear).style("opacity", .5).call(function (a, e) {
            a.empty() && e();
            var t = 0;
            a.each(function () {
                ++t
            }).on("end", function () {
                --t || e.apply(this, arguments)
            })
        }, function () {
            calendarHeatmap.in_transition = !1
        });
        //var n = d3.timeHours(moment(calendarHeatmap.selected.date).startOf("day"), moment(calendarHeatmap.selected.date).endOf("day")),
        var n = d3.timeHours(moment(calendarHeatmap.selected.date).setHours(int1), moment(calendarHeatmap.selected.date).setHours(int2+1)),
                r = d3.scaleTime().range([2 * calendarHeatmap.settings.label_padding, calendarHeatmap.settings.width]).domain([0, n.length]);
        calendarHeatmap.labels.selectAll(".label-time").remove(), calendarHeatmap.labels.selectAll(".label-time").data(n).enter().append("text").attr("class", "label label-time").attr("font-size", function () {
            return Math.floor(calendarHeatmap.settings.label_padding / 3) + "px"
        }).text(function (a) {
            return moment(a).format("HH:mm")
        }).attr("x", function (a, e) {
            return r(e)
        }).attr("y", calendarHeatmap.settings.label_padding / 2).on("mouseenter", function (a) {
            if (!calendarHeatmap.in_transition) {
                var e = t(moment(a));
                calendarHeatmap.items.selectAll(".item-block").transition().duration(calendarHeatmap.settings.transition_duration).ease(d3.easeLinear).style("opacity", function (a) {
                    var n = t(moment(a.date)), r = t(moment(a.date).add(a.value, "seconds"));
                    return e >= n && e <= r ? 1 : .1
                })
            }
        }).on("mouseout", function () {
            calendarHeatmap.in_transition || calendarHeatmap.items.selectAll(".item-block").transition().duration(calendarHeatmap.settings.transition_duration).ease(d3.easeLinear).style("opacity", .5)
        }), calendarHeatmap.labels.selectAll(".label-project").remove(), calendarHeatmap.labels.selectAll(".label-project").data(a).enter().append("text").attr("class", "label label-project").attr("x", calendarHeatmap.settings.gutter).attr("y", function (a) {
            return e(a) + e.bandwidth() / 2
        }).attr("min-height", function () {
            return e.bandwidth()
        }).style("text-anchor", "left").attr("font-size", function () {
            return Math.floor(calendarHeatmap.settings.label_padding / 3) + "px"
        }).text(function (a) {
            return a
        }).each(function () {
            for (var a = d3.select(this), e = a.node().getComputedTextLength(), t = a.text(); e > 1.5 * calendarHeatmap.settings.label_padding && t.length > 0; )
                t = t.slice(0, -1), a.text(t + "..."), e = a.node().getComputedTextLength()
        }).on("mouseenter", function (a) {
            calendarHeatmap.in_transition || calendarHeatmap.items.selectAll(".item-block").transition().duration(calendarHeatmap.settings.transition_duration).ease(d3.easeLinear).style("opacity", function (e) {
                return e.name === a ? 1 : .1
            })
        }).on("mouseout", function () {
            calendarHeatmap.in_transition || calendarHeatmap.items.selectAll(".item-block").transition().duration(calendarHeatmap.settings.transition_duration).ease(d3.easeLinear).style("opacity", .5)
        }), calendarHeatmap.drawButton()
    }, drawButton: function () {

    }, removeGlobalOverview: function () {

    }, removeYearOverview: function () {

    }, removeMonthOverview: function () {

    }, removeWeekOverview: function () {

    }, removeDayOverview: function () {

    }, hideBackButton: function () {
        calendarHeatmap.buttons.selectAll(".button").transition().duration(calendarHeatmap.settings.transition_duration).ease(d3.easeLinear).style("opacity", 0).remove()
    }, formatTime: function (a) {
        var e = Math.floor(a / 3600), t = Math.floor((a - 3600 * e) / 60), n = "";
        return e > 0 && (n += 1 === e ? "1 hour " : e + " hours "), t > 0 && (n += 1 === t ? "1 minute" : t + " minutes"), 0 === e && 0 === t && (n = Math.round(a) + " seconds"), n
    }};