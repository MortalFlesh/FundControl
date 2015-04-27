import React from 'react';
import Style from './style';

var MoneyFlowBar = React.createClass({
    getPercent(current, all) {
        var percent = (current / all) * 100;
        if (percent < 0) {
            return 0;
        } else if (percent > 100) {
            return 100;
        } else {
            return Math.round(percent * 100) / 100;
        }
    },
    render() {
        var totalItemsSpending = this.props.itemsTotal;
        var totalGain = this.props.gainTotal;

        var spendingPercent = this.getPercent(totalItemsSpending, totalGain);

        var gainLeft = totalGain - totalItemsSpending;
        var gainLeftPercent = this.getPercent(gainLeft, totalGain);

        var style = {
            container: {
                padding: '5px 0',
                margin: 'auto 20px',
                textAlign: 'center',
                width: '100%',
            },
            total: {
                fontSize: 25,
                padding: 5,
            },
            progress: {
                display: 'inline-block',
                fontSize: 20,
                lineHeight: '34px',

                width: '80%',
                height: 30,
                marginBottom: 20,
                overflow: 'hidden',
                backgroundColor: '#f5f5f5',
                borderRadius: 4,
                boxShadow: 'inset 0 1px 2px rgba(0,0,0,.1)',
            },
            progressBar: {
                width: spendingPercent + '%',

                float: 'left',
                height: '100%',
                color: '#fff',
                textAlign: 'center',
                backgroundColor: '#428bca',
                boxShadow: 'inset 0 -1px 0 rgba(0,0,0,.15)',
                transition: 'width .6s ease',
            },
        };

        return(
            <div className="moneyFlowBar" style={style.container}>
                <div className="total" style={style.total}>
                    {`${totalItemsSpending}${Style.nbsp}/${Style.nbsp}${totalGain}`}
                </div>

                <div className="progress" style={style.progress}>
                    {`${gainLeft}${Style.nbsp}(${gainLeftPercent}${Style.nbsp}%)`}

                    <div className="bar" style={style.progressBar}>
                        {`${totalItemsSpending}${Style.nbsp}(${spendingPercent}${Style.nbsp}%)`}
                    </div>
                </div>
            </div>
        );
    }
});

export default MoneyFlowBar;