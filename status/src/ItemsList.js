var ItemsList = React.createClass({
    render: function () {
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
