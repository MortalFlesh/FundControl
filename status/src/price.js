import React from 'react';
import {addons} from 'react/addons';

const Price = React.createClass({
    mixins: [addons.PureRenderMixin],

    propTypes: {
        price: React.PropTypes.number.isRequired,
        currency: React.PropTypes.string,
    },

    getDefaultProps() {
        return {
            currency: 'Kč',
        };
    },

    formatPrice(price) {
        // 1 000 000, 24 Kč

        const priceString = String(price);
        const parts = priceString.split('.');
        const integer = String(parseInt(parts[0], 10));
        const decimal = parseInt(parts[1], 10);

        const charsBackwards = [];
        let j = 0;
        for (let i = integer.length - 1; i >= 0; i--) {
            if (j > 0 && j % 3 === 0) {
                charsBackwards.push(' ');
            }

            j++;
            charsBackwards.push(integer.charAt(i));
        }

        const priceInteger = charsBackwards.reverse().join('');
        const decimalPart = decimal > 0 ? ', ' + String(decimal).substr(0, 2) : '';

        return `${priceInteger}${decimalPart} ${this.props.currency}`;
    },

    render() {
        const price = this.formatPrice(this.props.price);

        return (
            <span className="Price">{price}</span>
        );
    }
});

export default Price;
