var TimeFilter = React.createClass({
    render: function() {
        return (
            <div className="TimeFilter">
                <label>
                    {this.props.title + ':' + nbsp}
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