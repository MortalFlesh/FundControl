import React from 'react';
import {addons} from 'react/addons';
import Style from './style';

const Filter = React.createClass({
    mixins: [addons.PureRenderMixin],
    render() {
        const options = this.props.values.map((option, i) =>
            <option key={i} value={option.id}>
                {option.name}
            </option>
        );

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