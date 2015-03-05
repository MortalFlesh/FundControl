var StatusPage = React.createClass({
    getInitialState: function () {
        return {
            gainTotal: 0,
            itemsTotal: 0,
        };
    },
    loadDataFromServer: function () {
        this.ajaxLoad('gainTotal', this.props.actions.getGains);
        this.ajaxLoad('itemsTotal', this.props.actions.getItems);
    },
    ajaxLoad: function (type, actionUrl) {
        $.ajax({
            url: actionUrl,
            dataType: 'json',
        })
            .done(function (data) {
                var totalValue = 0;
                $.each(data, function (key, value) {
                    totalValue += parseFloat(value.amount);
                });

                var state = this.state;
                if (state[type] !== totalValue) {
                    state[type] = totalValue;
                    this.setState(state);
                }
            }.bind(this));
    },
    componentDidMount: function () {
        this.loadDataFromServer();
        setInterval(this.loadDataFromServer, this.props.interval);
    },

    render: function () {
        return (
            <div className="statusPage">
                <MoneyFlowBar gainTotal={this.state.gainTotal} itemsTotal={this.state.itemsTotal} />
                <ItemsBox url={this.props.actions.getItems} interval={this.props.interval} />
            </div>
        );
    }
});