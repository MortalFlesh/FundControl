import React from 'react';

var Item = React.createClass({
    render() {
        var item = this.props.item;

        var style = {
            Item: {
                padding: 10,
                border: '1px solid black',
                width: 400,
                height: 100,
                float: 'left',
                marginRight: 20,
                marginBottom: 20,
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
                </h2>
                <div style={style.ItemRow}>
                    <div style={style.ItemRowCol}>
                        Amount: {item.amount}
                    </div>
                    <div style={style.ItemRowCol}>
                        |
                    </div>
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