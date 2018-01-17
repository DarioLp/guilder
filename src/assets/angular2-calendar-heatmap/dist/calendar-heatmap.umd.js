(function (global, factory) {
	typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('@angular/core'), require('moment'), require('d3/index')) :
	typeof define === 'function' && define.amd ? define(['exports', '@angular/core', 'moment', 'd3/index'], factory) :
	(factory((global.CalendarHeatmap = global.CalendarHeatmap || {}),global._angular_core,global.moment,global.d3));
}(this, (function (exports,_angular_core,moment,d3) { 'use strict';

moment = 'default' in moment ? moment['default'] : moment;

// Import dependencies
var CalendarHeatmap = /** @class */ (function () {
    function CalendarHeatmap() {
        this.color = '#ff4500';
        this.overview = 'global';
        this.handler = new _angular_core.EventEmitter();
        this.onChange = new _angular_core.EventEmitter();
        this.gutter = 5;
        this.item_gutter = 1;
        this.width = 1000;
        this.height = 200;
        this.item_size = 10;
        this.label_padding = 40;
        this.max_block_height = 20;
        this.transition_duration = 500;
        this.in_transition = false;
        this.tooltip_width = 250;
        this.tooltip_padding = 15;
        this.history = ['global'];
        this.selected = {};
    }
    /**
     * Check if data is available
     * @return {?}
     */
    CalendarHeatmap.prototype.ngOnChanges = function () {
        if (!this.data) {
            return;
        }
        // Update data summaries
        this.updateDataSummary();
        // Draw the chart
        this.drawChart();
    };
    
    /**
     * Get hold of the root element and append our svg
     * @return {?}
     */
    CalendarHeatmap.prototype.ngAfterViewInit = function () {
        var /** @type {?} */ element = this.element.nativeElement;
        // Initialize svg element
        this.svg = d3.select(element)
            .append('svg')
            .attr('class', 'svg');
        // Initialize main svg elements
        this.items = this.svg.append('g');
        this.labels = this.svg.append('g');
        // Add tooltip to the same element as main svg
        this.tooltip = d3.select(element).append('div')
            .attr('class', 'heatmap-tooltip')
            .style('opacity', 0);
        // Calculate chart dimensions
        this.calculateDimensions();
        // Draw the chart
        this.drawChart();
    };
    
    /**
     * Utility function to get number of complete weeks in a year
     * @return {?}
     */
    CalendarHeatmap.prototype.getNumberOfWeeks = function () {
        var /** @type {?} */ dayIndex = Math.round((+moment() - +moment().subtract(1, 'year').startOf('week')) / 86400000);
        var /** @type {?} */ colIndex = Math.trunc(dayIndex / 7);
        var /** @type {?} */ numWeeks = colIndex + 1;
        return numWeeks;
    };
    
    /**
     * Utility funciton to calculate chart dimensions
     * @return {?}
     */
    CalendarHeatmap.prototype.calculateDimensions = function () {
        var /** @type {?} */ element = this.element.nativeElement;
        this.width = element.clientWidth < 1000 ? 1000 : element.clientWidth;
        this.item_size = ((this.width - this.label_padding) / this.getNumberOfWeeks() - this.gutter);
        this.height = this.label_padding + 7 * (this.item_size + this.gutter);
        this.svg.attr('width', this.width).attr('height', this.height);
    };
    
    /**
     * Recalculate dimensions on window resize events
     * @param {?} event
     * @return {?}
     */
    CalendarHeatmap.prototype.onResize = function (event$$1) {
        this.calculateDimensions();
        if (!!this.data && !!this.data[0]['summary']) {
            this.drawChart();
        }
    };
    
    /**
     * Helper function to check for data summary
     * @return {?}
     */
    CalendarHeatmap.prototype.updateDataSummary = function () {
        // Get daily summary if that was not provided
        if (!this.data[0]['summary']) {
            this.data.map(function (d) {
                var /** @type {?} */ summary = d['details'].reduce(function (uniques, project) {
                    if (!uniques[project.name]) {
                        uniques[project.name] = {
                            'value': project.value
                        };
                    }
                    else {
                        uniques[project.name].value += project.value;
                    }
                    return uniques;
                }, {});
                var /** @type {?} */ unsorted_summary = Object.keys(summary).map(function (key) {
                    return {
                        'name': key,
                        'value': summary[key].value
                    };
                });
                d['summary'] = unsorted_summary.sort(function (a, b) {
                    return b.value - a.value;
                });
                return d;
            });
        }
    };
    /**
     * Draw the chart based on the current overview type
     * @return {?}
     */
    CalendarHeatmap.prototype.drawChart = function () {
        if (!this.svg || !this.data) {
            return;
        }
        if (this.overview === 'global') {
            this.drawGlobalOverview();
        }
        else if (this.overview === 'year') {
            this.drawYearOverview();
            this.onChange.emit({
                overview: this.overview,
                start: moment(this.selected['date']).startOf('year'),
                end: moment(this.selected['date']).endOf('year'),
            });
        }
        else if (this.overview === 'month') {
            this.drawMonthOverview();
            this.onChange.emit({
                overview: this.overview,
                start: moment(this.selected['date']).startOf('month'),
                end: moment(this.selected['date']).endOf('month'),
            });
        }
        else if (this.overview === 'week') {
            this.drawWeekOverview();
            this.onChange.emit({
                overview: this.overview,
                start: moment(this.selected['date']).startOf('week'),
                end: moment(this.selected['date']).endOf('week'),
            });
        }
        else if (this.overview === 'day') {
            this.drawDayOverview();
            this.onChange.emit({
                overview: this.overview,
                start: moment(this.selected['date']).startOf('day'),
                end: moment(this.selected['date']).endOf('day'),
            });
        }
    };
    
    /**
     * Draw global overview (multiple years)
     * @return {?}
     */
    CalendarHeatmap.prototype.drawGlobalOverview = function () {
        var _this = this;
        // Add current overview to the history
        if (this.history[this.history.length - 1] !== this.overview) {
            this.history.push(this.overview);
        }
        // Define start and end of the dataset
        var /** @type {?} */ start = moment(this.data[0]['date']).startOf('year');
        var /** @type {?} */ end = moment(this.data[this.data.length - 1]['date']).endOf('year');
        // Define array of years and total values
        var /** @type {?} */ data = this.data;
        var /** @type {?} */ year_data = d3.timeYears(start, end).map(function (d) {
            var /** @type {?} */ date = moment(d);
            return {
                'date': date,
                'total': data.reduce(function (prev, current) {
                    if (moment(current.date).year() === date.year()) {
                        prev += current.total;
                    }
                    return prev;
                }, 0),
                'summary': function () {
                    var /** @type {?} */ summary = data.reduce(function (summary, d) {
                        if (moment(d.date).year() === date.year()) {
                            for (var /** @type {?} */ i = 0; i < d.summary.length; i++) {
                                if (!summary[d.summary[i].name]) {
                                    summary[d.summary[i].name] = {
                                        'value': d.summary[i].value,
                                    };
                                }
                                else {
                                    summary[d.summary[i].name].value += d.summary[i].value;
                                }
                            }
                        }
                        return summary;
                    }, {});
                    var /** @type {?} */ unsorted_summary = Object.keys(summary).map(function (key) {
                        return {
                            'name': key,
                            'value': summary[key].value
                        };
                    });
                    return unsorted_summary.sort(function (a, b) {
                        return b.value - a.value;
                    });
                }(),
            };
        });
        // Calculate max value of all the years in the dataset
        var /** @type {?} */ max_value = d3.max(year_data, function (d) {
            return d.total;
        });
        // Define year labels and axis
        var /** @type {?} */ year_labels = d3.timeYears(start, end).map(function (d) {
            return moment(d);
        });
        var /** @type {?} */ yearScale = d3.scaleBand()
            .rangeRound([0, this.width])
            .padding(0.05)
            .domain(year_labels.map(function (d) {
            return d.year();
        }));
        // Add global data items to the overview
        this.items.selectAll('.item-block-year').remove();
        var /** @type {?} */ item_block = this.items.selectAll('.item-block-year')
            .data(year_data)
            .enter()
            .append('rect')
            .attr('class', 'item item-block-year')
            .attr('width', function () {
            return (_this.width - _this.label_padding) / year_labels.length - _this.gutter * 5;
        })
            .attr('height', function () {
            return _this.height - _this.label_padding;
        })
            .attr('transform', function (d) {
            return 'translate(' + yearScale(d.date.year()) + ',' + _this.tooltip_padding * 2 + ')';
        })
            .attr('fill', function (d) {
            var /** @type {?} */ color = d3.scaleLinear()
                .range(['#ffffff', _this.color || '#ff4500'])
                .domain([-0.15 * max_value, max_value]);
            return color(d.total) || '#ff4500';
        })
            .on('click', function (d) {
            if (_this.in_transition) {
                return;
            }
            // Set in_transition flag
            _this.in_transition = true;
            // Set selected date to the one clicked on
            _this.selected = d;
            // Hide tooltip
            _this.hideTooltip();
            // Remove all global overview related items and labels
            _this.removeGlobalOverview();
            // Redraw the chart
            _this.overview = 'year';
            _this.drawChart();
        })
            .style('opacity', 0)
            .on('mouseover', function (d) {
            if (_this.in_transition) {
                return;
            }
            // Construct tooltip
            var /** @type {?} */ tooltip_html = '';
            tooltip_html += '<div><span><strong>Total time tracked:</strong></span>';
            var /** @type {?} */ sec = parseInt(d.total, 10);
            var /** @type {?} */ days = Math.floor(sec / 86400);
            if (days > 0) {
                tooltip_html += '<span>' + (days === 1 ? '1 day' : days + ' days') + '</span></div>';
            }
            var /** @type {?} */ hours = Math.floor((sec - (days * 86400)) / 3600);
            if (hours > 0) {
                if (days > 0) {
                    tooltip_html += '<div><span></span><span>' + (hours === 1 ? '1 hour' : hours + ' hours') + '</span></div>';
                }
                else {
                    tooltip_html += '<span>' + (hours === 1 ? '1 hour' : hours + ' hours') + '</span></div>';
                }
            }
            var /** @type {?} */ minutes = Math.floor((sec - (days * 86400) - (hours * 3600)) / 60);
            if (minutes > 0) {
                if (days > 0 || hours > 0) {
                    tooltip_html += '<div><span></span><span>' + (minutes === 1 ? '1 minute' : minutes + ' minutes') + '</span></div>';
                }
                else {
                    tooltip_html += '<span>' + (minutes === 1 ? '1 minute' : minutes + ' minutes') + '</span></div>';
                }
            }
            tooltip_html += '<br />';
            // Add summary to the tooltip
            if (d.summary.length <= 5) {
                for (var /** @type {?} */ i = 0; i < d.summary.length; i++) {
                    tooltip_html += '<div><span><strong>' + d.summary[i].name + '</strong></span>';
                    tooltip_html += '<span>' + _this.formatTime(d.summary[i].value) + '</span></div>';
                }
                
            }
            else {
                for (var /** @type {?} */ i = 0; i < 5; i++) {
                    tooltip_html += '<div><span><strong>' + d.summary[i].name + '</strong></span>';
                    tooltip_html += '<span>' + _this.formatTime(d.summary[i].value) + '</span></div>';
                }
                
                tooltip_html += '<br />';
                var /** @type {?} */ other_projects_sum = 0;
                for (var /** @type {?} */ i = 5; i < d.summary.length; i++) {
                    other_projects_sum = +d.summary[i].value;
                }
                
                tooltip_html += '<div><span><strong>Other:</strong></span>';
                tooltip_html += '<span>' + _this.formatTime(other_projects_sum) + '</span></div>';
            }
            // Calculate tooltip position
            var /** @type {?} */ x = yearScale(d.date.year()) + _this.tooltip_padding * 2;
            while (_this.width - x < (_this.tooltip_width + _this.tooltip_padding * 5)) {
                x -= 10;
            }
            var /** @type {?} */ y = _this.tooltip_padding * 3;
            // Show tooltip
            _this.tooltip.html(tooltip_html)
                .style('left', x + 'px')
                .style('top', y + 'px')
                .transition()
                .duration(_this.transition_duration / 2)
                .ease(d3.easeLinear)
                .style('opacity', 1);
        })
            .on('mouseout', function () {
            if (_this.in_transition) {
                return;
            }
            _this.hideTooltip();
        })
            .transition()
            .delay(function (d, i) {
            return _this.transition_duration * (i + 1) / 10;
        })
            .duration(function () {
            return _this.transition_duration;
        })
            .ease(d3.easeLinear)
            .style('opacity', 1)
            .call(function (transition, callback) {
            if (transition.empty()) {
                callback();
            }
            var /** @type {?} */ n = 0;
            transition
                .each(function () { ++n; })
                .on('end', function () {
                if (!--n) {
                    callback.apply(this, arguments);
                }
            });
        }, function () {
            _this.in_transition = false;
        });
        // Add year labels
        this.labels.selectAll('.label-year').remove();
        this.labels.selectAll('.label-year')
            .data(year_labels)
            .enter()
            .append('text')
            .attr('class', 'label label-year')
            .attr('font-size', function () {
            return Math.floor(_this.label_padding / 3) + 'px';
        })
            .text(function (d) {
            return d.year();
        })
            .attr('x', function (d) {
            return yearScale(d.year());
        })
            .attr('y', this.label_padding / 2)
            .on('mouseenter', function (year_label) {
            if (_this.in_transition) {
                return;
            }
            _this.items.selectAll('.item-block-year')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', function (d) {
                return (moment(d.date).year() === year_label.year()) ? 1 : 0.1;
            });
        })
            .on('mouseout', function () {
            if (_this.in_transition) {
                return;
            }
            _this.items.selectAll('.item-block-year')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', 1);
        })
            .on('click', function (d) {
            if (_this.in_transition) {
                return;
            }
            // Set in_transition flag
            _this.in_transition = true;
            // Set selected year to the one clicked on
            _this.selected = { date: d };
            // Hide tooltip
            _this.hideTooltip();
            // Remove all global overview related items and labels
            _this.removeGlobalOverview();
            // Redraw the chart
            _this.overview = 'year';
            _this.drawChart();
        });
    };
    
    /**
     * Draw year overview
     * @return {?}
     */
    CalendarHeatmap.prototype.drawYearOverview = function () {
        var _this = this;
        // Add current overview to the history
        if (this.history[this.history.length - 1] !== this.overview) {
            this.history.push(this.overview);
        }
        // Define start and end date of the selected year
        var /** @type {?} */ start_of_year = moment(this.selected['date']).startOf('year');
        var /** @type {?} */ end_of_year = moment(this.selected['date']).endOf('year');
        // Filter data down to the selected year
        var /** @type {?} */ year_data = this.data.filter(function (d) {
            return start_of_year <= moment(d.date) && moment(d.date) < end_of_year;
        });
        // Calculate max value of the year data
        var /** @type {?} */ max_value = d3.max(year_data, function (d) {
            return d.total;
        });
        var /** @type {?} */ color = d3.scaleLinear()
            .range(['#ffffff', this.color])
            .domain([-0.15 * max_value, max_value]);
        this.items.selectAll('.item-circle').remove();
        this.items.selectAll('.item-circle')
            .data(year_data)
            .enter()
            .append('rect')
            .attr('class', 'item item-circle')
            .style('opacity', 0)
            .attr('x', function (d) {
            return _this.calcItemX(d, start_of_year) + (_this.item_size - _this.calcItemSize(d, max_value)) / 2;
        })
            .attr('y', function (d) {
            return _this.calcItemY(d) + (_this.item_size - _this.calcItemSize(d, max_value)) / 2;
        })
            .attr('rx', function (d) {
            return _this.calcItemSize(d, max_value);
        })
            .attr('ry', function (d) {
            return _this.calcItemSize(d, max_value);
        })
            .attr('width', function (d) {
            return _this.calcItemSize(d, max_value);
        })
            .attr('height', function (d) {
            return _this.calcItemSize(d, max_value);
        })
            .attr('fill', function (d) {
            return (d.total > 0) ? color(d.total) : 'transparent';
        })
            .on('click', function (d) {
            if (_this.in_transition) {
                return;
            }
            // Don't transition if there is no data to show
            if (d.total === 0) {
                return;
            }
            _this.in_transition = true;
            // Set selected date to the one clicked on
            _this.selected = d;
            // Hide tooltip
            _this.hideTooltip();
            // Remove all year overview related items and labels
            _this.removeYearOverview();
            // Redraw the chart
            _this.overview = 'day';
            _this.drawChart();
        })
            .on('mouseover', function (d) {
            if (_this.in_transition) {
                return;
            }
            // Pulsating animation
            var /** @type {?} */ circle = d3.select(d3.event.currentTarget);
            var /** @type {?} */ repeat = function () {
                circle.transition()
                    .duration(_this.transition_duration)
                    .ease(d3.easeLinear)
                    .attr('x', function (d) {
                    return _this.calcItemX(d, start_of_year) - (_this.item_size * 1.1 - _this.item_size) / 2;
                })
                    .attr('y', function (d) {
                    return _this.calcItemY(d) - (_this.item_size * 1.1 - _this.item_size) / 2;
                })
                    .attr('width', _this.item_size * 1.1)
                    .attr('height', _this.item_size * 1.1)
                    .transition()
                    .duration(_this.transition_duration)
                    .ease(d3.easeLinear)
                    .attr('x', function (d) {
                    return _this.calcItemX(d, start_of_year) + (_this.item_size - _this.calcItemSize(d, max_value)) / 2;
                })
                    .attr('y', function (d) {
                    return _this.calcItemY(d) + (_this.item_size - _this.calcItemSize(d, max_value)) / 2;
                })
                    .attr('width', function (d) {
                    return _this.calcItemSize(d, max_value);
                })
                    .attr('height', function (d) {
                    return _this.calcItemSize(d, max_value);
                })
                    .on('end', repeat);
            };
            repeat();
            // Construct tooltip
            var /** @type {?} */ tooltip_html = '';
            tooltip_html += '<div class="header"><strong>' + (d.total ? _this.formatTime(d.total) : 'No time') + ' tracked</strong></div>';
            tooltip_html += '<div>on ' + moment(d.date).format('dddd, MMM Do YYYY') + '</div><br>';
            // Add summary to the tooltip
            d.summary.map(function (d) {
                tooltip_html += '<div><span><strong>' + d.name + '</strong></span>';
                tooltip_html += '<span>' + _this.formatTime(d.value) + '</span></div>';
            });
            // Calculate tooltip position
            var /** @type {?} */ x = _this.calcItemX(d, start_of_year) + _this.item_size;
            if (_this.width - x < (_this.tooltip_width + _this.tooltip_padding * 3)) {
                x -= _this.tooltip_width + _this.tooltip_padding * 2;
            }
            var /** @type {?} */ y = _this.calcItemY(d) + _this.item_size;
            // Show tooltip
            _this.tooltip.html(tooltip_html)
                .style('left', x + 'px')
                .style('top', y + 'px')
                .transition()
                .duration(_this.transition_duration / 2)
                .ease(d3.easeLinear)
                .style('opacity', 1);
        })
            .on('mouseout', function () {
            if (_this.in_transition) {
                return;
            }
            // Set circle radius back to what it's supposed to be
            d3.select(d3.event.currentTarget).transition()
                .duration(_this.transition_duration / 2)
                .ease(d3.easeLinear)
                .attr('x', function (d) {
                return _this.calcItemX(d, start_of_year) + (_this.item_size - _this.calcItemSize(d, max_value)) / 2;
            })
                .attr('y', function (d) {
                return _this.calcItemY(d) + (_this.item_size - _this.calcItemSize(d, max_value)) / 2;
            })
                .attr('width', function (d) {
                return _this.calcItemSize(d, max_value);
            })
                .attr('height', function (d) {
                return _this.calcItemSize(d, max_value);
            });
            // Hide tooltip
            _this.hideTooltip();
        })
            .transition()
            .delay(function () {
            return (Math.cos(Math.PI * Math.random()) + 1) * _this.transition_duration;
        })
            .duration(function () {
            return _this.transition_duration;
        })
            .ease(d3.easeLinear)
            .style('opacity', 1)
            .call(function (transition, callback) {
            if (transition.empty()) {
                callback();
            }
            var /** @type {?} */ n = 0;
            transition
                .each(function () { ++n; })
                .on('end', function () {
                if (!--n) {
                    callback.apply(this, arguments);
                }
            });
        }, function () {
            _this.in_transition = false;
        });
        // Add month labels
        var /** @type {?} */ month_labels = d3.timeMonths(start_of_year.toDate(), end_of_year.toDate());
        var /** @type {?} */ monthScale = d3.scaleLinear()
            .range([0, this.width])
            .domain([0, month_labels.length]);
        this.labels.selectAll('.label-month').remove();
        this.labels.selectAll('.label-month')
            .data(month_labels)
            .enter()
            .append('text')
            .attr('class', 'label label-month')
            .attr('font-size', function () {
            return Math.floor(_this.label_padding / 3) + 'px';
        })
            .text(function (d) {
            return d.toLocaleDateString('en-us', { month: 'short' });
        })
            .attr('x', function (d, i) {
            return monthScale(i) + (monthScale(i) - monthScale(i - 1)) / 2;
        })
            .attr('y', this.label_padding / 2)
            .on('mouseenter', function (d) {
            if (_this.in_transition) {
                return;
            }
            var /** @type {?} */ selected_month = moment(d);
            _this.items.selectAll('.item-circle')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', function (d) {
                return moment(d.date).isSame(selected_month, 'month') ? 1 : 0.1;
            });
        })
            .on('mouseout', function () {
            if (_this.in_transition) {
                return;
            }
            _this.items.selectAll('.item-circle')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', 1);
        })
            .on('click', function (d) {
            if (_this.in_transition) {
                return;
            }
            // Check month data
            var /** @type {?} */ month_data = _this.data.filter(function (e) {
                return moment(d).startOf('month') <= moment(e.date) && moment(e.date) < moment(d).endOf('month');
            });
            // Don't transition if there is no data to show
            if (!month_data.length) {
                return;
            }
            // Set selected month to the one clicked on
            _this.selected = { date: d };
            _this.in_transition = true;
            // Hide tooltip
            _this.hideTooltip();
            // Remove all year overview related items and labels
            _this.removeYearOverview();
            // Redraw the chart
            _this.overview = 'month';
            _this.drawChart();
        });
        // Add day labels
        var /** @type {?} */ day_labels = d3.timeDays(moment().startOf('week').toDate(), moment().endOf('week').toDate());
        var /** @type {?} */ dayScale = d3.scaleBand()
            .rangeRound([this.label_padding, this.height])
            .domain(day_labels.map(function (d) {
            return moment(d).weekday().toString();
        }));
        this.labels.selectAll('.label-day').remove();
        this.labels.selectAll('.label-day')
            .data(day_labels)
            .enter()
            .append('text')
            .attr('class', 'label label-day')
            .attr('x', this.label_padding / 3)
            .attr('y', function (d, i) {
            return dayScale((i).toString()) + dayScale.bandwidth() / 1.75;
        })
            .style('text-anchor', 'left')
            .attr('font-size', function () {
            return Math.floor(_this.label_padding / 3) + 'px';
        })
            .text(function (d) {
            return moment(d).format('dddd')[0];
        })
            .on('mouseenter', function (d) {
            if (_this.in_transition) {
                return;
            }
            var /** @type {?} */ selected_day = moment(d);
            _this.items.selectAll('.item-circle')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', function (d) {
                return (moment(d.date).day() === selected_day.day()) ? 1 : 0.1;
            });
        })
            .on('mouseout', function () {
            if (_this.in_transition) {
                return;
            }
            _this.items.selectAll('.item-circle')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', 1);
        });

    };
    

    CalendarHeatmap.prototype.drawDayOverview = function () {
        var _this = this;
        // Add current overview to the history
        if (this.history[this.history.length - 1] !== this.overview) {
            this.history.push(this.overview);
        }
        // Initialize selected date to today if it was not set
        if (!Object.keys(this.selected).length) {
            this.selected = this.data[this.data.length - 1];
        }
        var /** @type {?} */ project_labels = this.selected['summary'].map(function (project) {
            return project.name;
        });
        var /** @type {?} */ projectScale = d3.scaleBand()
            .rangeRound([this.label_padding, this.height])
            .domain(project_labels);
        var /** @type {?} */ itemScale = d3.scaleTime()
            .range([this.label_padding * 2, this.width])
            .domain([moment(this.selected['date']).startOf('day'), moment(this.selected['date']).endOf('day')]);
        this.items.selectAll('.item-block').remove();
        this.items.selectAll('.item-block')
            .data(this.selected['details'])
            .enter()
            .append('rect')
            .attr('class', 'item item-block')
            .attr('x', function (d) {
            return itemScale(moment(d.date));
        })
            .attr('y', function (d) {
            return (projectScale(d.name) + projectScale.bandwidth() / 2) - 15;
        })
            .attr('width', function (d) {
            var /** @type {?} */ end = itemScale(d3.timeSecond.offset(moment(d.date).toDate(), d.value));
            return Math.max((end - itemScale(moment(d.date))), 1);
        })
            .attr('height', function () {
            return Math.min(projectScale.bandwidth(), _this.max_block_height);
        })
            .attr('fill', function () {
            return _this.color;
        })
            .style('opacity', 0)
            .on('mouseover', function (d) {
            if (_this.in_transition) {
                return;
            }
            // Construct tooltip
            var /** @type {?} */ tooltip_html = '';
            tooltip_html += '<div class="header"><strong>' + d.name + '</strong><div><br>';
            tooltip_html += '<div><strong>' + (d.value ? _this.formatTime(d.value) : 'No time') + ' tracked</strong></div>';
            tooltip_html += '<div>on ' + moment(d.date).format('dddd, MMM Do YYYY HH:mm') + '</div>';
            // Calculate tooltip position
            var /** @type {?} */ x = d.value * 100 / (60 * 60 * 24) + itemScale(moment(d.date));
            while (_this.width - x < (_this.tooltip_width + _this.tooltip_padding * 3)) {
                x -= 10;
            }
            var /** @type {?} */ y = projectScale(d.name) + projectScale.bandwidth() / 2 + _this.tooltip_padding / 2;
            // Show tooltip
            _this.tooltip.html(tooltip_html)
                .style('left', x + 'px')
                .style('top', y + 'px')
                .transition()
                .duration(_this.transition_duration / 2)
                .ease(d3.easeLinear)
                .style('opacity', 1);
        })
            .on('mouseout', function () {
            if (_this.in_transition) {
                return;
            }
            _this.hideTooltip();
        })
            .on('click', function (d) {
            if (_this.handler) {
                _this.handler.emit(d);
            }
        })
            .transition()
            .delay(function () {
            return (Math.cos(Math.PI * Math.random()) + 1) * _this.transition_duration;
        })
            .duration(function () {
            return _this.transition_duration;
        })
            .ease(d3.easeLinear)
            .style('opacity', 0.5)
            .call(function (transition, callback) {
            if (transition.empty()) {
                callback();
            }
            var /** @type {?} */ n = 0;
            transition
                .each(function () { ++n; })
                .on('end', function () {
                if (!--n) {
                    callback.apply(this, arguments);
                }
            });
        }, function () {
            _this.in_transition = false;
        });
        // Add time labels
        var /** @type {?} */ timeLabels = d3.timeHours(moment(this.selected['date']).startOf('day').toDate(), moment(this.selected['date']).endOf('day').toDate());
        var /** @type {?} */ timeScale = d3.scaleTime()
            .range([this.label_padding * 2, this.width])
            .domain([0, timeLabels.length]);
        this.labels.selectAll('.label-time').remove();
        this.labels.selectAll('.label-time')
            .data(timeLabels)
            .enter()
            .append('text')
            .attr('class', 'label label-time')
            .attr('font-size', function () {
            return Math.floor(_this.label_padding / 3) + 'px';
        })
            .text(function (d) {
            return moment(d).format('HH:mm');
        })
            .attr('x', function (d, i) {
            return timeScale(i);
        })
            .attr('y', this.label_padding / 2)
            .on('mouseenter', function (d) {
            if (_this.in_transition) {
                return;
            }
            var /** @type {?} */ selected = itemScale(moment(d));
            _this.items.selectAll('.item-block')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', function (d) {
                var /** @type {?} */ start = itemScale(moment(d.date));
                var /** @type {?} */ end = itemScale(moment(d.date).add(d.value, 'seconds'));
                return (selected >= start && selected <= end) ? 1 : 0.1;
            });
        })
            .on('mouseout', function () {
            if (_this.in_transition) {
                return;
            }
            _this.items.selectAll('.item-block')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', 0.5);
        });
        // Add project labels
        var /** @type {?} */ label_padding = this.label_padding;
        this.labels.selectAll('.label-project').remove();
        this.labels.selectAll('.label-project')
            .data(project_labels)
            .enter()
            .append('text')
            .attr('class', 'label label-project')
            .attr('x', this.gutter)
            .attr('y', function (d) {
            return projectScale(d) + projectScale.bandwidth() / 2;
        })
            .attr('min-height', function () {
            return projectScale.bandwidth();
        })
            .style('text-anchor', 'left')
            .attr('font-size', function () {
            return Math.floor(_this.label_padding / 3) + 'px';
        })
            .text(function (d) {
            return d;
        })
            .each(function (d, i) {
            var /** @type {?} */ obj = d3.select(this), /** @type {?} */ text_length = obj.node().getComputedTextLength(), /** @type {?} */ text = obj.text();
            while (text_length > (label_padding * 1.5) && text.length > 0) {
                text = text.slice(0, -1);
                obj.text(text + '...');
                text_length = obj.node().getComputedTextLength();
            }
        })
            .on('mouseenter', function (project) {
            if (_this.in_transition) {
                return;
            }
            _this.items.selectAll('.item-block')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', function (d) {
                return (d.name === project) ? 1 : 0.1;
            });
        })
            .on('mouseout', function () {
            if (_this.in_transition) {
                return;
            }
            _this.items.selectAll('.item-block')
                .transition()
                .duration(_this.transition_duration)
                .ease(d3.easeLinear)
                .style('opacity', 0.5);
        });

    };
    
    /**
     * Helper function to calculate item position on the x-axis
     * @param {?} d object
     * @param {?} start_of_year
     * @return {?}
     */
    CalendarHeatmap.prototype.calcItemX = function (d, start_of_year) {
        var /** @type {?} */ date = moment(d.date);
        var /** @type {?} */ dayIndex = Math.round((+date - +moment(start_of_year).startOf('week')) / 86400000);
        var /** @type {?} */ colIndex = Math.trunc(dayIndex / 7);
        return colIndex * (this.item_size + this.gutter) + this.label_padding;
    };
    
    /**
     * Helper function to calculate item position on the y-axis
     * @param {?} d object
     * @return {?}
     */
    CalendarHeatmap.prototype.calcItemY = function (d) {
        return this.label_padding + moment(d.date).weekday() * (this.item_size + this.gutter);
    };
    
    /**
     * Helper function to calculate item size
     * @param {?} d object
     * @param {?} max number
     * @return {?}
     */
    CalendarHeatmap.prototype.calcItemSize = function (d, max$$1) {
        if (max$$1 <= 0) {
            return this.item_size;
        }
        return this.item_size * 0.75 + (this.item_size * d.total / max$$1) * 0.25;
    };
    

    /**
     * Helper function to hide the tooltip
     * @return {?}
     */
    CalendarHeatmap.prototype.hideTooltip = function () {
        this.tooltip.transition()
            .duration(this.transition_duration / 2)
            .ease(d3.easeLinear)
            .style('opacity', 0);
    };
    
    /**
     * Helper function to convert seconds to a human readable format
     * @param {?} seconds Integer
     * @return {?}
     */
    CalendarHeatmap.prototype.formatTime = function (seconds) {
        var /** @type {?} */ hours = Math.floor(seconds / 3600);
        var /** @type {?} */ minutes = Math.floor((seconds - (hours * 3600)) / 60);
        var /** @type {?} */ time = '';
        if (hours > 0) {
            time += hours === 1 ? '1 hour ' : hours + ' hours ';
        }
        if (minutes > 0) {
            time += minutes === 1 ? '1 minute' : minutes + ' minutes';
        }
        if (hours === 0 && minutes === 0) {
            time = Math.round(seconds) + ' seconds';
        }
        return time;
    };
    
    CalendarHeatmap.decorators = [
        { type: _angular_core.Component, args: [{
                    selector: 'calendar-heatmap',
                    template: "<div #root></div>",
                    styles: ["\n    :host {\n      user-select: none;\n      -ms-user-select: none;\n      -moz-user-select: none;\n      -webkit-user-select: none;\n    }\n    :host >>> .item {\n      cursor: pointer;\n    }\n    :host >>> .label {\n      cursor: pointer;\n      fill: rgb(170, 170, 170);\n      font-family: Helvetica, arial, 'Open Sans', sans-serif;\n    }\n    :host >>> .button {\n      cursor: pointer;\n      fill: transparent;\n      stroke-width: 2;\n      stroke: rgb(170, 170, 170);\n    }\n    :host >>> .button text {\n      stroke-width: 1;\n      text-anchor: middle;\n      fill: rgb(170, 170, 170);\n    }\n    :host >>> .heatmap-tooltip {\n      pointer-events: none;\n      position: absolute;\n      z-index: 9999;\n      width: 250px;\n      max-width: 250px;\n      overflow: hidden;\n      padding: 15px;\n      font-size: 12px;\n      line-height: 14px;\n      color: rgb(51, 51, 51);\n      font-family: Helvetica, arial, 'Open Sans', sans-serif;\n      background: rgba(255, 255, 255, 0.75);\n    }\n    :host >>> .heatmap-tooltip .header strong {\n      display: inline-block;\n      width: 250px;\n    }\n    :host >>> .heatmap-tooltip span {\n      display: inline-block;\n      width: 50%;\n      padding-right: 10px;\n      box-sizing: border-box;\n    }\n    :host >>> .heatmap-tooltip span,\n    :host >>> .heatmap-tooltip .header strong {\n      white-space: nowrap;\n      overflow: hidden;\n      text-overflow: ellipsis;\n    }\n  "],
                },] },
    ];
    /**
     * @nocollapse
     */
    CalendarHeatmap.ctorParameters = function () { return []; };
    CalendarHeatmap.propDecorators = {
        'element': [{ type: _angular_core.ViewChild, args: ['root',] },],
        'data': [{ type: _angular_core.Input },],
        'color': [{ type: _angular_core.Input },],
        'overview': [{ type: _angular_core.Input },],
        'handler': [{ type: _angular_core.Output },],
        'onChange': [{ type: _angular_core.Output },],
        'onResize': [{ type: _angular_core.HostListener, args: ['window:resize', ['$event'],] },],
    };
    return CalendarHeatmap;
}());

exports.CalendarHeatmap = CalendarHeatmap;

Object.defineProperty(exports, '__esModule', { value: true });

})));