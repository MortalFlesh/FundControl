var ItemsBox = React.createClass({
    getInitialState: function () {
        return {
            items: [],
            selectedItemType: '',
        }
    },
    componentDidUpdate: function() {
        var state = {};
        var stateChanged = false;

        if (this.state.selectedItemType === '' && this.state.items !== this.props.items) {
            state.items = this.props.items;
            stateChanged = true;
        } else if (this.state.selectedItemType !== '') {
            state.items = this.filterItemsByType(this.props.items,this.state.selectedItemType);
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
        for (var key in items) {
            var typeName = items[key].itemType.name;

            if (types.indexOf(typeName) >= 0) {
                continue;
            }

            types.push(typeName);
        }
        return types;
    },
    filterItemTypes: function (event) {
        var selectedType = event.target.value;

        if (this.state.selectedItemType !== selectedType) {
            var filteredItems = this.filterItemsByType(this.props.items, selectedType);
            this.setState({
                selectedItemType: selectedType,
                items: filteredItems,
            });
        }
    },
    filterItemsByType: function(items, selectedType) {
        var filteredItems = [];
        for (var key in items) {
            var item = items[key];

            if (item.itemType.name === selectedType) {
                filteredItems.push(item);
            }
        }
        return filteredItems;
    },
    render: function () {
        var itemTypes = this.parseItemTypes(this.props.items);
        var itemsTotal = this.getTotalAmount(this.state.items);

        return (
            <div className="itemsBox">
                <div className="filters" style={{paddingBottom: 20}}>
                    <Filter
                        title="Item type"
                        values={itemTypes}
                        filterOnChange={this.filterItemTypes}
                        selectedValue={this.state.selectedItemType} />
                </div>

                <div clasName="itemsTotal" style={{padding: '10px 0'}}>
                    Total amount: <strong>{itemsTotal}</strong>
                </div>

                <ItemsList data={this.state.items} />
            </div>
        );
    }
});