import React from 'react';
import Style from './style';

var TimeFilter = React.createClass({
    render() {
        return (
            <div className="TimeFilter">
                <label>
                    {this.props.title + ':' + Style.nbsp}
                    <input type="text"
                        name={this.props.name}
                        value={this.props.time}
                        onChange={this.props.handleChange}
                    />
                </label>
            </div>
        );
    }
});

export default TimeFilter;