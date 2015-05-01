import React from 'react';
import {addons} from 'react/addons';

const Item = React.createClass({
    mixins: [addons.PureRenderMixin],

    render() {
        const item = this.props.item;
        const itemTime = JSON.stringify(item.time);

        const style = {
            Item: {
                padding: 10,
                border: '1px solid black',
                width: 400,
                height: 120,
                float: 'left',
                marginRight: 20,
                marginBottom: 20,
                borderRadius: 10,
            },
            itemTime: {
                fontSize: 10,
            },
            ItemRow: {
                paddingTop: 5,
            },
            ItemRowCol: {
                float: 'left',
                marginRight: 10,
            },
            clear: {
                clear: 'both',
            }
        };

        return (
            <div className="item" style={style.Item}>
                <h2 className="itemName">
                    {item.name}
                    <br/>
                    <em style={style.itemTime}>
                        {itemTime}
                    </em>
                </h2>

                <div style={style.ItemRow}>
                    <div style={style.ItemRowCol}>
                        Amount: {item.amount}
                    </div>

                    <div style={style.ItemRowCol}>|</div>

                    <div style={style.ItemRowCol}>
                        Type: {item.itemType.name}
                    </div>

                    <div style={style.clear} />
                </div>
            </div>
        );
    }
});

export default Item;
