IdentifyX.window.CreateData = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'identifyx-ips-window-create';
	}
	Ext.applyIf(config, {
		title: _('identifyx_item_create'),
		width: 550,
		autoHeight: true,
		url: IdentifyX.config.connector_url,
		action: 'mgr/ip/create',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit();
			}, scope: this
		}]
	});
	IdentifyX.window.CreateData.superclass.constructor.call(this, config);
};
Ext.extend(IdentifyX.window.CreateData, MODx.Window, {

	getFields: function (config) {
		return [{
			xtype: 'numberfield',
			fieldLabel: _('identifyx_item_user_id'),
			name: 'id',
			id: config.id + '-id',
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: _('identifyx_item_fingerprint'),
			name: 'fprint_id',
			id: config.id + '-fprint-id',
			height: 150,
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'numberfield',
			boxLabel: _('identifyx_item_votes'),
			name: 'ip',
			id: config.id + '-ip',
			anchor: '99%',
			allowBlank: true,
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('identifyx-ips-window-create', IdentifyX.window.CreateData);


IdentifyX.window.UpdateData = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'identifyx-ips-window-update';
	}
	Ext.applyIf(config, {
		title: _('identifyx_item_update'),
		width: 550,
		autoHeight: true,
		url: IdentifyX.config.connector_url,
		action: 'mgr/ip/update',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit();
			}, scope: this
		}]
	});
	IdentifyX.window.UpdateData.superclass.constructor.call(this, config);
};
Ext.extend(IdentifyX.window.UpdateData, MODx.Window, {

	getFields: function (config) {
		return [{
			xtype: 'numberfield',
			fieldLabel: _('identifyx_item_user_id'),
			name: 'id',
			id: config.id + '-id',
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: _('identifyx_item_fingerprint'),
			name: 'fprint_id',
			id: config.id + '-fprint-id',
			height: 150,
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'numberfield',
			boxLabel: _('identifyx_item_votes'),
			name: 'ip',
			id: config.id + '-ip',
			anchor: '99%',
			allowBlank: true,
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('identifyx-ips-window-update', IdentifyX.window.UpdateData);
