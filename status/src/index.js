import React from 'react';
import App from './app';

var apiUrl = 'http://localhost/FundControl/app/api.php';
var actions = {
    getItems: apiUrl + '?action=get-items',
    getGains: apiUrl + '?action=get-gains',
    getGainTypes: apiUrl + '?action=get-gain-types',
    getItemTypes: apiUrl + '?action=get-item-types',
};

React.render(
    <App actions={actions} interval={50000} />,
    document.getElementById('content')
);