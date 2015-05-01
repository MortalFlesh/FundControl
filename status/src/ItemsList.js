import React from 'react';
import {addons} from 'react/addons';
import Item from './item';

const ItemsList = React.createClass({
    mixins: [addons.PureRenderMixin],
    render() {
        const items = this.props.items.map((item, i) => <Item key={i} item={item} />);

        return (
            <div className="itemsList">
                {items}
            </div>
        );
    }
});

export default ItemsList;