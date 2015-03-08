var ItemsBox = React.createClass({
    render: function () {
        return (
            <div className="itemsBox">
                <ItemsList data={this.props.items} />
            </div>
        );
    }
});