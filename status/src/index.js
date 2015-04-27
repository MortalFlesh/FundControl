import React from 'react';
import StatusPage from './statusPage';

var apiUrl = 'http://localhost/FundControl/app/api.php';
var actions = {
    getItems: apiUrl + '?action=get-items',
    getGains: apiUrl + '?action=get-gains',
};

React.render(
    <StatusPage actions={actions} interval={50000} />,
    document.getElementById('content')
);