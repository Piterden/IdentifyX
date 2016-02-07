var IdentifyX = function (config) {
	config = config || {};
	IdentifyX.superclass.constructor.call(this, config);
};
Ext.extend(IdentifyX, Ext.Component, {
	page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('identifyx', IdentifyX);

IdentifyX = new IdentifyX();
