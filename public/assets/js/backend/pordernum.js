define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'pordernum/index',
                    add_url: 'pordernum/add',
                    edit_url: 'pordernum/edit',
                    del_url: 'pordernum/del',
                    multi_url: 'pordernum/multi',
                    table: 'pordernum',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'userid', title: __('Userid')},
                        {field: 'landid', title: __('Landid')},
                        {field: 'pesticide', title: __('Pesticide')},
                        {field: 'pid', title: __('Pid')},
                        {field: 'area', title: __('Area'), operate:'BETWEEN'},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'pordernum', title: __('Pordernum')},
                        {field: 'state', title: __('State'), searchList: {"0":__('State 0'),"1":__('State 1'),"2":__('State 2'),"3":__('State 3'),"4":__('State 4')}, formatter: Table.api.formatter.normal},
                        {field: 'groupid', title: __('Groupid')},
                        {field: 'porderid', title: __('Porderid')},
                        {field: 'code', title: __('Code')},
                        {field: 'superior_code', title: __('Superior_code')},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
                        {field: 'type', title: __('Type'), searchList: {"direct":__('Type direct'),"crowd":__('Type crowd')}, formatter: Table.api.formatter.normal},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});