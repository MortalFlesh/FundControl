import React from 'react';
import {addons} from 'react/addons';

const InlineBlock = React.createClass({
    mixins: [addons.PureRenderMixin],

    propTypes: {
        noBorder: React.PropTypes.bool,
    },

    getDefaultProps() {
        return {
            noBorder: false,
        };
    },

    render() {
        const style = {
            display: 'inline-block',
            padding: 5,
            border: '1px solid black',
            borderRadius: 5,
        };

        if (this.props.noBorder === true) {
            style.border = '';
            style.borderRadius = 0;
        }

        return (
            <div className="InlineBlock" style={style}>
                {this.props.children}
            </div>
        );
    }
});

export default InlineBlock;