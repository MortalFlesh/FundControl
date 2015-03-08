var ItemsBox = React.createClass({
    parseItemTypes: function(items) {
        var types = [];
        for (var key in items) {
            var typeName = items[key].itemType.name;

            if(types.indexOf(typeName) >= 0) {
                continue;
            }

            types.push(typeName);
        }
        return types;
    },
    render: function () {
        var itemTypes = this.parseItemTypes(this.props.items);

        return (
            <div className="itemsBox">
                <Filter title="Item type" values={itemTypes} />
                <ItemsList data={this.props.items} />
            </div>
        );
    }
});