import React from 'react';
import {addons} from 'react/addons';
import $ from 'jquery-browserify';
import InlineBlock from './inlineBlock';
import Filter from './filter';
import TimeFilter from './timeFilter';
import ItemsList from './ItemsList';
import Style from './style';
import {List} from 'immutable';

const ItemsBox = React.createClass({
    mixins: [addons.PureRenderMixin],

    propTypes: {
        items: React.PropTypes.instanceOf(List).isRequired,
        selectedDate: React.PropTypes.object.isRequired,
        selectedItemTypeId: React.PropTypes.number.isRequired,
        onFilterItemTypes: React.PropTypes.func.isRequired,
        onFilterTimeChange: React.PropTypes.func.isRequired,
    },

    getTotalAmount(items) {
        return items
                .map((item) => parseFloat(item.get('amount')))
                .reduce((prev, curr) => prev + curr, 0) || 0;
    },

    parseItemTypes(items) {
        const typeIds = [];
        let types = new List();

        items.forEach((item) => {
            const type = item.get('itemType');
            const typeId = type.id;

            if (typeIds.indexOf(typeId) < 0) {
                typeIds.push(typeId);
                types = types.push(type);
            }
        });

        return types;
    },

    handleFilterItemTypes(event) {
        const selectedTypeId = event.target.value;
        this.props.onFilterItemTypes(selectedTypeId);
    },

    filterItemsByType(items) {
        const selectedTypeId = parseInt(this.props.selectedItemTypeId, 10);

        return items.filter((item) => {
            const itemType = parseInt(item.toJS().itemType.id, 10);

            return selectedTypeId <= 0 || itemType === selectedTypeId;
        });
    },

    handleFilterByTime(event) {
        const timeString = event.target.value;
        const timeType = event.target.name;

        const time = this.parseTime(timeString);

        this.props.onFilterTimeChange({timeType, time});
    },

    filterItemsByTime(items, {timeFrom, timeTo}) {
        const timeFromDate = this.parseTimeToDate(timeFrom);
        const timeToDate = this.parseTimeToDate(timeTo);

        return items.filter((item) => {
            const itemDate = this.parseTimeToDate(item.get('time'));

            return (itemDate <= timeToDate && itemDate >= timeFromDate);
        });
    },

    parseTime(timeString) {
        const parts = timeString.replace(new RegExp(' ', 'g'), '').split('|');

        const date = parts[0].split('.');
        const time = parts[1].split(':');

        return {
            day: parseInt(date[0], 10),
            month: parseInt(date[1], 10),
            year: parseInt(date[2], 10),
            hour: parseInt(time[0], 10),
            min: parseInt(time[1], 10),
        };
    },

    parseTimeToString(timeJson) {
        let time = '';

        time += timeJson.day;
        time += '.';
        time += timeJson.month;
        time += '. ';
        time += timeJson.year;
        time += ' | ';
        time += timeJson.hour < 10 ? '0' + timeJson.hour : timeJson.hour;
        time += ':';
        time += timeJson.minute < 10 ? '0' + timeJson.minute : timeJson.minute;

        return time;
    },

    parseTimeToDate(timeJson) {
        const date = new Date();

        date.setDate(parseInt(timeJson.day, 10));
        date.setMonth(parseInt(timeJson.month, 10) - 1);
        date.setFullYear(parseInt(timeJson.year, 10));
        date.setHours(parseInt(timeJson.hour, 10));
        date.setMinutes(parseInt(timeJson.minute, 10));
        date.setSeconds(0);

        return date;
    },

    render() {
        const itemsByTime = this.filterItemsByTime(this.props.items, this.props.selectedDate);
        const itemTypes = this.parseItemTypes(itemsByTime);

        const filteredItems = this.filterItemsByType(itemsByTime);
        const itemsTotal = this.getTotalAmount(filteredItems);

        const timeFrom = this.parseTimeToString(this.props.selectedDate.timeFrom);
        const timeTo = this.parseTimeToString(this.props.selectedDate.timeTo);

        function separator(separator) {
            return Style.nbsp + separator + Style.nbsp
        }

        return (
            <div className="itemsBox">
                <div className="filters" style={{paddingBottom: 20}}>

                    <InlineBlock>
                        <Filter
                            title="Item type"
                            values={itemTypes}
                            filterOnChange={this.handleFilterItemTypes}
                            selectedValue={this.props.selectedItemTypeId} />
                    </InlineBlock>

                    {separator('|')}

                    <InlineBlock>
                        <InlineBlock noBorder={true}>
                            <TimeFilter
                                title="Date from"
                                name="from"
                                time={timeFrom}
                                onChange={this.handleFilterByTime}
                            />
                        </InlineBlock>

                        <InlineBlock noBorder={true}>
                            <TimeFilter
                                title="to"
                                name="to"
                                time={timeTo}
                                onChange={this.handleFilterByTime}
                            />
                        </InlineBlock>
                    </InlineBlock>
                </div>

                <div clasName="itemsTotal" style={{padding: '10px 0'}}>
                    Total amount:
                    <strong>{itemsTotal}</strong>
                </div>

                <ItemsList items={filteredItems.toJS()} />
            </div>
        );
    }
});

export default ItemsBox;
