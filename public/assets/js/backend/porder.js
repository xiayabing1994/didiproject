define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'porder/index',
                    add_url: 'porder/add',
                    edit_url: 'porder/edit',
                    del_url: 'porder/del',
                    multi_url: 'porder/multi',
                    table: 'porder',
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
                        {field: 'pordernum', title: __('Pordernum')},
                        {field: 'sumarea', title: __('Sumarea'), operate:'BETWEEN'},
                        {field: 'isleader', title: __('Isleader'), searchList: {"0":__('Isleader 0'),"1":__('Isleader 1')}, formatter: Table.api.formatter.normal},
                        {field: 'state', title: __('State'), searchList: {"0":__('State 0'),"1":__('State 1'),"2":__('State 2'),"3":__('State 3')}, formatter: Table.api.formatter.normal},
                        {field: 'pname', title: __('Pname')},
                        {field: 'starttime', title: __('Starttime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'endtime', title: __('Endtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'hasland', title: __('Hasland'), operate:'BETWEEN'},
                        {field: 'price', title: __('Price'), operate:'BETWEEN'},
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