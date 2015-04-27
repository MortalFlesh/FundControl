import React from 'react';
import $ from 'jquery-browserify';
import InlineBlock from './inlineBlock';
import Filter from './filter';
import TimeFilter from './timeFilter';
import ItemsList from './ItemsList';
import Style from './style';

var ItemsBox = React.createClass({
    getInitialState() {
        var now = new Date();

        var currentDay = {
            day: now.getDate(),
            month: now.getMonth() + 1,
            year: now.getFullYear(),
        };

        var extendsJson = function(json, extend) {
            return $.extend(true, {}, json, extend);
        };

        var dateFrom = extendsJson(currentDay, {day: 1, hour: 0, minute: 0});
        var dateTo = extendsJson(currentDay, {hour: now.getHours(), minute: now.getMinutes()});

        return {
            items: [],
            itemsByTime: [],
            selectedItemTypeId: '',
            selectedDate: {
                from: {
                    date: dateFrom,
                    dateString: this.parseTimeToString(dateFrom),
                },
                to: {
                    date: dateTo,
                    dateString: this.parseTimeToString(dateTo),
                },
            },
        }
    },
    componentDidUpdate: function() {
        var state = {};
        var stateChanged = false;
        var items = this.filterItemsByTime(this.props.items, this.state.selectedDate.from.date, this.state.selectedDate.to.date);
        console.log('props: ', this.props.items);
        console.log('itemsByTime: ', items);

        if (this.state.selectedItemTypeId === '' && this.state.items !== items) {
            state.items = items;
            state.itemsByTime = items;
            stateChanged = true;
        } else if (this.state.selectedItemTypeId !== '') {
            state.items = this.filterItemsByType(items,this.state.selectedItemTypeId);
            state.itemsByTime = items;
            stateChanged = true;
        }

        if (stateChanged) {
            this.setState(state);
        }
    },
    getTotalAmount: function(data) {
        var totalAmount = 0;
        $.each(data, function (key, value) {
            totalAmount += parseFloat(value.amount);
        });
        return totalAmount;
    },
    parseItemTypes(items) {
        var types = [];
        var typeIds = [];
        for (var key in items) {
            var type = items[key].itemType;

            if (typeIds.indexOf(type.id) >= 0) {
                continue;
            }

            types.push(type);
            typeIds.push(type.id);
        }
        return types;
    },
    filterItemTypes(event) {
        var selectedTypeId = event.target.value;

        if (this.state.selectedItemTypeId !== selectedTypeId) {
            var filteredItems = this.filterItemsByType(this.props.items, selectedTypeId);
            this.setState({
                selectedItemTypeId: selectedTypeId,
                items: filteredItems,
            });
        }
    },
    filterItemsByType: function(items, selectedTypeId) {
        var filteredItems = [];
        for (var key in items) {
            var item = items[key];

            if (item.itemType.id === selectedTypeId) {
                filteredItems.push(item);
            }
        }
        return filteredItems;
    },
    filterByTime: function(event) {
        var timeString = event.target.value;
        var time = this.parseTime(timeString);
        var timeType = event.target.name;

        if (this.state.selectedDate[timeType].dateString !== timeString) {
            var state = {
                selectedDate: this.state.selectedDate
            };

            state.selectedDate[timeType].date = time;
            state.selectedDate[timeType].dateString = timeString;

            this.setState(state);
        }
    },
    filterItemsByTime: function(items, timeFrom, timeTo) {
        var filteredItems = [];

        for (var key in items) {
            var item = items[key];
            var itemDate = this.parseTimeToDate(item.time);
            var timeFromDate = this.parseTimeToDate(timeFrom);
            var timeToDate = this.parseTimeToDate(timeTo);

            console.log('item: ', itemDate, '<=', timeToDate, ' && ', itemDate,' >= ',timeFromDate, ' = ', itemDate <= timeToDate && itemDate >= timeFromDate);

            if (itemDate <= timeToDate && itemDate >= timeFromDate) {
                filteredItems.push(item);
            }
        }

        return filteredItems;
    },
    parseTime: function(timeString) {
        var parts = timeString.replace(new RegExp(' ', 'g'), '').split('|');

        var date = parts[0].split('.');
        var time = parts[1].split(':');

        return {
            day: parseInt(date[0], 10),
            month: parseInt(date[1]),
            year: parseInt(date[2]),
            hour: parseInt(time[0]),
            min: parseInt(time[1]),
        };
    },
    parseTimeToString: function(timeJson) {
        var time = '';

        time += timeJson.day;
        time += '.';
        time += timeJson.month;
        time += '. ';
        time += timeJson.year;
        time += ' | ';
        time += timeJson.hour < 10 ? '0' + timeJson.hour : timeJson.hour ;
        time += ':';
        time += timeJson.minute < 10 ? '0' + timeJson.minute : timeJson.minute;

        return time;
    },
    parseTimeToDate: function(timeJson) {
        var date = new Date();

        date.setDate(parseInt(timeJson.day, 10));
        date.setMonth(parseInt(timeJson.month, 10) - 1);
        date.setFullYear(parseInt(timeJson.year, 10));
        date.setHours(parseInt(timeJson.hour, 10));
        date.setMinutes(parseInt(timeJson.minute, 10));
        date.setSeconds(0);

        return date;
    },
    render() {
        var itemTypes = this.parseItemTypes(this.state.itemsByTime);
        var itemsTotal = this.getTotalAmount(this.state.items);
        var separator = function(separator) {
            return Style.nbsp + separator + Style.nbsp
        };

        return (
            <div className="itemsBox">
                <div className="filters" style={{paddingBottom: 20}}>

                    <InlineBlock>
                        <Filter
                            title="Item type"
                            values={itemTypes}
                            filterOnChange={this.filterItemTypes}
                            selectedValue={this.state.selectedItemTypeId} />
                    </InlineBlock>

                    {separator('|')}

                    <InlineBlock>
                        <InlineBlock noBorder={true}>
                            <TimeFilter
                                title="Date from"
                                name="from"
                                time={this.state.selectedDate.from.dateString}
                                handleChange={this.filterByTime}
                            />
                        </InlineBlock>

                        <InlineBlock noBorder={true}>
                            <TimeFilter
                                title="to"
                                name="to"
                                time={this.state.selectedDate.to.dateString}
                                handleChange={this.filterByTime}
                            />
                        </InlineBlock>
                    </InlineBlock>
                </div>

                <div clasName="itemsTotal" style={{padding: '10px 0'}}>
                    Total amount: <strong>{itemsTotal}</strong>
                </div>

                <ItemsList data={this.state.items} />
            </div>
        );
    }
});

export default ItemsBox;