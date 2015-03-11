var Filter = React.createClass({
    render: function() {
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
                    {this.props.title + ':' + nbsp}
                    <select onChange={this.props.filterOnChange} defaultValue={this.props.selectedValue}>
                        <option value=''>{'-- all --'}</option>
                        {options}
                    </select>
                </label>
            </div>
        );
    }
});