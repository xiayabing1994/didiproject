define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'peace/index',
                    add_url: 'peace/add',
                    edit_url: 'peace/edit',
                    del_url: 'peace/del',
                    multi_url: 'peace/multi',
                    table: 'peace',
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
                        {field: 'peace_no', title: __('Peace_no')},
                        {field: 'order_no', title: __('Order_no')},
                        {field: 'piece_area', title: __('Piece_area')},
                        {field: 'completed_area', title: __('Completed_area'),formatter: Table.api.formatter.normal},
                        // {field: 'completed_area', title: __('Completed_area'),    table: table,
                        //     events: Table.api.events.operate,buttons: [
                        //         {
                        //             name: 'detail',
                        //             text: __('弹出窗口打开'),
                        //             title: __('弹出窗口打开'),
                        //             classname: 'btn btn-xs btn-primary btn-dialog',
                        //             icon: 'fa fa-list',
                        //             url: 'example/bootstraptable/detail',
                        //             callback: function (data) {
                        //                 Layer.alert("接收到回传数据：" + JSON.stringify(data), {title: "回传数据"});
                        //             },
                        //             visible: function (row) {
                        //                 //返回true时按钮显示,返回false隐藏
                        //                 return true;
                        //             }
                        //         },],formatter: Table.api.formatter.buttons
                        // },
                        {field: 'piece_land_no', title: __('Piece_land_no')},
                        {field: 'create_time', title: __('Create_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'statu', title: __('Statu'), searchList: {"0":__('Statu 0'),"1":__('Statu 1')}, formatter: Table.api.formatter.normal},
                        {field: 'user.nickname', title: __('User_id')},
                        {field: 'is_effect', title: __('Is_effect'), searchList: {"0":__('Is_effect 0'),"1":__('Is_effect 1')}, formatter: Table.api.formatter.normal},
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