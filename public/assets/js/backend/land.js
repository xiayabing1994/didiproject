define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'land/index',
                    add_url: 'land/add',
                    edit_url: 'land/edit',
                    del_url: 'land/del',
                    multi_url: 'land/multi',
                    table: 'land',
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
                        {field: 'name', title: __('Name')},
                        // {field: 'point', title: __('Point')},
                        {field: 'area', title: __('Area')},
                        {field: 'userid', title: __('Userid')},
                        {field: 'centerX', title: __('Centerx'), operate:'BETWEEN'},
                        {field: 'centerY', title: __('Centery'), operate:'BETWEEN'},
                        {field: 'landarea', title: __('Landarea'), operate:'BETWEEN'},
                        {field: 'perimeter', title: __('Perimeter'), operate:'BETWEEN'},
                        {field: 'addtime', title: __('Addtime'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'state', title: __('State'), searchList: {"0":__('State 0'),"1":__('State 1')}, formatter: Table.api.formatter.normal},
                        {field: 'isdel', title: __('Isdel'), searchList: {"0":__('Isdel 0'),"1":__('Isdel 1')}, formatter: Table.api.formatter.normal},
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