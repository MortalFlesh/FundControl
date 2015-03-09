var ItemsBox = React.createClass({
    getInitialState: function () {
        return {
            items: [],
            selectedItemType: '',
        }
    },
    componentDidUpdate: function() {
        if (this.state.selectedItemType === '' && this.state.items !== this.props.items) {
            this.setState({items: this.props.items});
        } else if (this.state.selectedItemType !== '') {
            this.setState({items: this.filterItemsByType(this.props.items,this.state.selectedItemType)});
        }
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

        return (
            <div className="itemsBox">
                <div className="filters" style={{paddingBottom: 20}}>
                    <Filter
                        title="Item type"
                        values={itemTypes}
                        filterOnChange={this.filterItemTypes}
                        selectedValue={this.state.selectedItemType} />
                </div>

                <ItemsList data={this.state.items} />
            </div>
        );
    }
});