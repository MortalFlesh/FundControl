<h3 class="page-header">Month</h3>
<p>Monthly</p>

<fieldset>
	<legend>Balance</legend>

	<dl class="balance-status {{userTabData.month.balance.status}}">
		<dt>Total balance:</dt>
		<dd>{{userTabData.month.balance.totalBalance}}</dd>
	</dl>
	<dl>
		<dt>Total gained:</dt>
		<dd>{{userTabData.month.balance.totalGained}}</dd>
	</dl>
	<dl>
		<dt>Total spent:</dt>
		<dd>{{userTabData.month.balance.totalSpent}}</dd>
	</dl>
</fieldset>

<fieldset>
	<legend>Gains:</legend>
	<ul>
		<li ng-repeat="gain in userTabData.month.gains">
			{{gain.name}} | {{gain.amount}} | {{gain.type}}
		</li>
	</ul>
</fieldset>

<fieldset>
	<legend>Items</legend>
	<ul>
		<li ng-repeat="item in userTabData.month.items">
			{{item.name}} | {{item.amount}} | {{item.type}}
		</li>
	</ul>
</fieldset>
