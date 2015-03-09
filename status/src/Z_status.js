var apiUrl = 'http://localhost/FundControl/app/api.php';
var actions = {
    getItems: apiUrl + '?action=get-items',
    getGains: apiUrl + '?action=get-gains',
};
var nbsp = "\u00a0";

React.render(
    <StatusPage actions={actions} interval={5000} />,
    document.getElementById('content')
);