IdentifyX.window.CreateData = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'identifyx-likes-window-create';
	}
	Ext.applyIf(config, {
		title: _('identifyx_item_create'),
		width: 550,
		autoHeight: true,
		url: IdentifyX.config.connector_url,
		action: 'mgr/likes/create',
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
			xtype: 'hidden',
			name: 'id',
			id: config.id + '-id',
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'numberfield',
			fieldLabel: _('identifyx_item_user_id'),
			name: 'fprint_id',
			id: config.id + '-fprint-id',
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'textarea',
			fieldLabel: _('identifyx_item_fingerprint'),
			name: 'res_id',
			id: config.id + '-res-id',
			height: 150,
			anchor: '99%',
			allowBlank: false
		}, {
			xtype: 'numberfield',
			boxLabel: _('identifyx_item_votes'),
			name: 'createdby',
			id: config.id + '-createdby',
			anchor: '99%',
			allowBlank: false,
			defaultValue: 0
		}, {
			xtype: 'numberfield',
			boxLabel: _('identifyx_item_votes'),
			name: 'createdon',
			id: config.id + '-createdon',
			anchor: '99%',
			allowBlank: false,
			defaultValue: 0
		}];
	},

	loadDropZones: function() {
	}

});
Ext.reg('identifyx-likes-window-create', IdentifyX.window.CreateData);


IdentifyX.window.UpdateData = function (config) {
	config = config || {};
	if (!config.id) {
		config.id = 'identifyx-likes-window-update';
	}
	Ext.applyIf(config, {
		title: _('identifyx_item_update'),
		width: 550,
		autoHeight: true,
		url: IdentifyX.config.connector_url,
		action: 'mgr/likes/update',
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
Ext.reg('identifyx-likes-window-update', IdentifyX.window.UpdateData);
