import React from 'react';
import * as state from './state';
import * as store from './store';
import StatusPage from './statusPage';

const App = React.createClass({
    componentDidMount() {
        state.state.on('change', () => {
            this.forceUpdate()
        });

        this.loadDataFromServer();
        setInterval(this.loadDataFromServer, this.props.interval);
    },
    loadDataFromServer() {
        state.reload('gains', this.props.actions.getGains);
        state.reload('items', this.props.actions.getItems);
        state.reload('gainTypes', this.props.actions.getGainTypes);
        state.reload('itemTypes', this.props.actions.getItemTypes);
    },
    render() {
        const items = store.getItems().toJS();
        const itemTypes = store.getItemTypes().toJS();
        const gains = store.getGains().toJS();
        const gainTypes = store.getGainTypes().toJS();

        const status = {
            items,
            itemTypes,
            gains,
            gainTypes,
        };
        
        return (
            <StatusPage {...status} />
        );
    }
});

export default App;
