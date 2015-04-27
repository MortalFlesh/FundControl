import React from 'react';
import Style from './style';

var Filter = React.createClass({
    render() {
        var options = this.props.values.map(function (option) {
            return (
                <option value={option.id}>
                    {option.name}
                </option>
            );
        });

        return (
            <div className="Filter">
                <label>
                    {this.props.title + ':' + Style.nbsp}
                    <select onChange={this.props.filterOnChange} defaultValue={this.props.selectedValue}>
                        <option value=''>{'-- all --'}</option>
                        {options}
                    </select>
                </label>
            </div>
        );
    }
});

export default Filter;