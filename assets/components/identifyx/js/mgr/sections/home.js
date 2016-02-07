IdentifyX.page.Home = function (config) {
	config = config || {};
	Ext.applyIf(config, {
		components: [{
			xtype: 'identifyx-panel-home', renderTo: 'identifyx-panel-home-div'
		}]
	});
	IdentifyX.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(IdentifyX.page.Home, MODx.Component);
Ext.reg('identifyx-page-home', IdentifyX.page.Home);
