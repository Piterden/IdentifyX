IdentifyX.combo.User = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        name: 'user_id',
        hiddenName: 'user_id',
        displayField: 'fullname',
        valueField: 'id',
        fields: ['id', 'fullname'],
        pageSize: 20, // Количество результатов на странице
        url: IdentifyX.config.connector_url, // Используем родной процессор MODX
        editable: true, // Комбо можно редактировать, то есть - искать юзеров
        allowBlank: true, // Можно оставлять пустым
        emptyText: _('identifyx_user_select'), // Текст по умолчанию
        baseParams: { // Данные для отправки процессору
            action: 'mgr/user/getlist',
            user_filter: this
        }, // Шаблон оформления, похоже на Smarty
        tpl: new Ext.XTemplate('' + '<tpl for="."><div class="identifyx-list-item">' + '<span><small>({id})</small> <b>{username}</b> ({fullname})</span><br/>' + '</div></tpl>', {
            compiled: true
        }), // Какой элемент является селекторо. То есть, выбор будет при клике на этот элемент
        itemSelector: 'div.identifyx-list-item',
        //lazyRender: true,
    });
    IdentifyX.combo.User.superclass.constructor.call(this, config);
	console.log(this);
};
Ext.extend(IdentifyX.combo.User, MODx.combo.ComboBox);
Ext.reg('identifyx-combo-user', IdentifyX.combo.User);
