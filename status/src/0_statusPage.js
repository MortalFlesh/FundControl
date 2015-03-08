var StatusPage = React.createClass({
    getInitialState: function () {
        return {
            items: [],
            gains: [],
            gainsTotal: 0,
            itemsTotal: 0,
        };
    },
    loadDataFromServer: function () {
        this.ajaxLoad('gains', this.props.actions.getGains);
        this.ajaxLoad('items', this.props.actions.getItems);
    },
    ajaxLoad: function (type, actionUrl) {
        $.ajax({
            url: actionUrl,
            dataType: 'json',
        })
            .done(function (data) {
                var currentTotalValue = 0;
                $.each(data, function (key, value) {
                    currentTotalValue += parseFloat(value.amount);
                });

                var currentData = [];
                $.each(data, function (key, value) {
                    currentData.push(value);
                });

                var state = this.state;
                var stateChanged = false;

                var typeTotal = type + 'Total';

                if (state[typeTotal] !== currentTotalValue) {
                    state[typeTotal] = currentTotalValue;
                    stateChanged = true;
                }

                if (state[type] !== currentData) {
                    state[type] = currentData;
                    stateChanged = true;
                }

                if (stateChanged) {
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
                <h1>Items status</h1>
                <MoneyFlowBar gainTotal={this.state.gainsTotal} itemsTotal={this.state.itemsTotal} />
                <ItemsBox items={this.state.items} />
            </div>
        );
    }
});