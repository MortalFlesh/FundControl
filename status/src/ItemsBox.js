var ItemsBox = React.createClass({
    getInitialState: function () {
        var now = new Date();

        var currentDay = {
            day: now.getDay(),
            month: now.getMonth(),
            year: now.getFullYear(),
        };

        var extendsJson = function(json, extend) {
            return $.extend(true, {}, json, extend);
        };

        var dateFrom = extendsJson(currentDay, {hour: 0, min: 0});
        var dateTo = extendsJson(currentDay, {hour: now.getHours(), min: now.getMinutes()});

        return {
            items: [],
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

        if (this.state.selectedItemTypeId === '' && this.state.items !== this.props.items) {
            state.items = this.props.items;
            stateChanged = true;
        } else if (this.state.selectedItemTypeId !== '') {
            state.items = this.filterItemsByType(this.props.items,this.state.selectedItemTypeId);
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
    parseItemTypes: function (items) {
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
    filterItemTypes: function (event) {
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
        time += timeJson.min < 10 ? '0' + timeJson.min : timeJson.min;

        return time;
    },
    render: function () {
        var itemTypes = this.parseItemTypes(this.props.items);
        var itemsTotal = this.getTotalAmount(this.state.items);
        var separator = function(separator) {
            return nbsp + separator + nbsp
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