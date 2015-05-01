import React from 'react';

var ItemsList = React.createClass({
    render() {
        const items = this.props.items.map((item) => <Item item={item} />);

        return (
            <div className="itemsList">
                {items}
            </div>
        );
    }
});

export default ItemsList;