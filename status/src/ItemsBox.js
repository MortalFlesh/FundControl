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
        }.bind(this))
        .error(function (xhr, status, err) {
            console.error(this.props.url, status, err.toString());
        }.bind(this));
    },
    componentDidMount: function () {
        this.loadItemsFromServer();
    },

    render: function () {
        return (
            <div className="itemsBox">
                <h1>Items status</h1>
                <ItemsList data={this.state.data} />
            </div>
        );
    }
});