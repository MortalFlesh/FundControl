import React from 'react';
import {addons} from 'react/addons';
import Style from './style';

const TimeFilter = React.createClass({
    mixins: [addons.PureRenderMixin],

    propTypes: {
        title: React.PropTypes.string.isRequired,
        name: React.PropTypes.string.isRequired,
        time: React.PropTypes.string.isRequired,
        onChange: React.PropTypes.func.isRequired,
    },

    render() {
        return (
            <div className="TimeFilter">
                <label>
                    {this.props.title + ':' + Style.nbsp}

                    <input type="text"
                        name={this.props.name}
                        value={this.props.time}
                        onChange={this.props.onChange}
                    />
                </label>
            </div>
        );
    }
});

export default TimeFilter;