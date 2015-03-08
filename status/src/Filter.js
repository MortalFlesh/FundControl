var Filter = React.createClass({
    render: function() {
        console.log(this.props.values);
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
                    <select>
                        {options}
                    </select>
                </label>
            </div>
        );
    }
});