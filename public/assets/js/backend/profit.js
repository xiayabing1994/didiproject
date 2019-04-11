define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'profit/index',
                    add_url: 'profit/add',
                    edit_url: 'profit/edit',
                    del_url: 'profit/del',
                    multi_url: 'profit/multi',
                    table: 'profit',
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
                        {field: 'pid', title: __('Pid')},
                        {field: 'childpid', title: __('Childpid')},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'iseffect', title: __('Iseffect'), searchList: {"1":__('Iseffect 1'),"0":__('Iseffect 0')}, formatter: Table.api.formatter.normal},
                        {field: 'type', title: __('Type'), searchList: {"earn":__('Type earn'),"other":__('Type other')}, formatter: Table.api.formatter.normal},
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