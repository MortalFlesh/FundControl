var ItemsBox = React.createClass({
    getInitialState: function () {
        return {data: []};
    },
    loadItemsFromServer: function () {
        $.ajax({
            url: this.props.url,
            dataType: 'json',
        })
        .done(function (data) {
            var itemsData = [];
            $.each(data, function(key, value) {
                itemsData.push(value);
            });
            this.setState({data: itemsData});
        }.bind(this));
    },
    componentDidMount: function () {
        this.loadItemsFromServer();
        setInterval(this.loadItemsFromServer, this.props.interval);
    },

    render: function () {
        return (
            <div className="itemsBox">
                <ItemsList data={this.state.data} />
            </div>
        );
    }
});