import React from 'react';
import $ from 'jquery-browserify';
import * as actions from './actions';
import * as store from './store';
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

        const itemBox = {
            items: this.props.items,
            selectedDate: store.getSelectedDate(),
            selectedItemTypeId: store.getSelectedItemTypeId(),
            onFilterItemTypes(selectedType) {
                actions.setSelectedItemTypeId(selectedType);
            },
            onFilterTimeChange({timeType, time}) {
                switch(timeType) {
                    case 'from': actions.setSelectedTimeFrom(time); break;
                    case 'to': actions.setSelectedTimeTo(time); break;
                }
            },
        };

        return (
            <div className="statusPage">
                <h1>Items status</h1>

                <ItemsBox {...itemBox} />

                <MoneyFlowBar {...moneyFlow} />
            </div>
        );
    }
});

export default StatusPage;
