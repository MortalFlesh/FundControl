import React from 'react';
import $ from 'jquery-browserify';
import MoneyFlowBar from './moneyFlowBar';
import ItemsBox from './ItemsBox';

var StatusPage = React.createClass({
    getAmount(item) {
        return parseFloat(item.amount);
    },
    total(values) {
        return values
            .map((item) => this.getAmount(item))
            .reduce((previous, current) => previous + current, 0);
    },
    render() {
        const moneyFlow = {
            gainTotal: this.total(this.props.gains),
            itemsTotal: this.total(this.props.items),
        };

        ////<ItemsBox items={this.props.items} />

        return (
            <div className="statusPage">
                <h1>Items status</h1>

                <MoneyFlowBar {...moneyFlow} />
            </div>
        );
    }
});

export default StatusPage;