IdentifyX.window.CreateData = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'identifyx-data-window-create';
	}
	Ext.applyIf(config, {
		title: _('identifyx_item_create'),
		width: 550,
		autoHeight: true,
		url: IdentifyX.config.connector_url,
		action: 'mgr/data/create',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
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
			name: 'user_id',
			id: config.id + '-user-id',
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'textarea',
			fieldLabel: _('identifyx_item_fingerprint'),
			name: 'fingerprint',
			id: config.id + '-fingerprint',
			height: 150,
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'numberfield',
			boxLabel: _('identifyx_item_votes'),
			name: 'votes',
			id: config.id + '-votes',
			anchor: '99%',
			allowBlank: false,
			defaultValue: 0
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('identifyx-data-window-create', IdentifyX.window.CreateData);


IdentifyX.window.UpdateData = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'identifyx-data-window-update';
	}
	Ext.applyIf(config, {
		title: _('identifyx_item_update'),
		width: 550,
		autoHeight: true,
		url: IdentifyX.config.connector_url,
		action: 'mgr/data/update',
		fields: this.getFields(config),
		keys: [{
			key: Ext.EventObject.ENTER, shift: true, fn: function () {
				this.submit()
			}, scope: this
		}]
	});
	IdentifyX.window.UpdateData.superclass.constructor.call(this, config);
};
Ext.extend(IdentifyX.window.UpdateData, MODx.Window, {

	getFields: function (config) {
		return [{
			xtype: 'hidden',
			name: 'id',
			id: config.id + '-id',
		}, {
			xtype: 'numberfield',
			fieldLabel: _('identifyx_item_user_id'),
			name: 'user_id',
			id: config.id + '-user-id',
			anchor: '99%',
			allowBlank: false,
		}, {
			xtype: 'textarea',
			fieldLabel: _('identifyx_item_fingerprint'),
			name: 'fingerprint',
			id: config.id + '-fingerprint',
			anchor: '99%',
			height: 150,
			allowBlank: false,
		}, {
			xtype: 'numberfield',
			boxLabel: _('identifyx_item_votes'),
			name: 'votes',
			id: config.id + '-votes',
			anchor: '99%',
			allowBlank: false,
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('identifyx-data-window-update', IdentifyX.window.UpdateData);
