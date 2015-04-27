import React from 'react';

var ItemsList = React.createClass({
    render() {
        var items = this.props.data.map(function (item) {
            return (
                <Item item={item} />
            );
        });

        return (
            <div className="itemsList">
                {items}
            </div>
        );
    }
});

export default ItemsList;