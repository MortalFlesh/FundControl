var Filter = React.createClass({
    render: function() {
        var options = this.props.values.map(function (value) {
            return (
                <option value={value}>
                    {value}
                </option>
            );
        });

        return (
            <div className="Filter">
                <label>
                    {this.props.title + ':' + nbsp}
                    <select onChange={this.props.filterOnChange} defaultValue={this.props.selectedValue}>
                        <option value=''>{'-- without filter --'}</option>
                        {options}
                    </select>
                </label>
            </div>
        );
    }
});