var InlineBlock = React.createClass({
    render: function() {
        var style = {
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