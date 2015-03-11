var ItemsBox = React.createClass({
    getInitialState: function () {
        return {
            items: [],
            selectedItemTypeId: '',
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
                        selectedValue={this.state.selectedItemTypeId} />
                </div>

                <div clasName="itemsTotal" style={{padding: '10px 0'}}>
                    Total amount: <strong>{itemsTotal}</strong>
                </div>

                <ItemsList data={this.state.items} />
            </div>
        );
    }
});