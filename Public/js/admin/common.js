//添加
$("#button-add").on('click',function()
{
    url = SCOPE.add_url;
    //console.log(url);return;
    window.location.href=url;
});
//编辑


//提交数据
$("#singcms-button-submit").on('click',function()
{
    data = {};
    var formData = $("#singcms-form").serializeArray();
    $(formData).each(function(i)
    {
        data[this.name] = this.value;
    });
    url = SCOPE.save_url;
    index = SCOPE.jump_url;
    $.post(url,data,function(msg)
    {
        if(msg.status == 1)
        {
            return dialog.success(msg.message,index);
        }
        if(msg.status == 0)
        {
            return dialog.error(msg.message,msg['data']['jump_url']);
        }
    },'JSON');
});
//修改状态
$(".singcms-table #singcms-on-off").on('click',function()
{
    url = SCOPE.set_status_url;
    id = $(this).attr('attr-id');
    status = $(this).attr('attr-status');
    data ={};
    data['id'] = id;
    data['status'] = status;
    layer.open({
        type : 0,
        title : '确定修改',
        btn: ['确定','取消'],
        icon:3,
        closeBtn:2,
        content: "是否确定修改",
        scrollbar:true,
        yes : function()
        {
            //执行跳转
            todelete(url,data);
        }
    })
})

//排序
$("#button-listorder").on('click',function()
{
    ///获取内容
    var data = $("#singcms-listorder").serializeArray();

    formData = {};
    $(data).each(function(i)
    {
        formData[this.name] = this.value;
    })
    console.log(formData);
    url = SCOPE.listorder_url;
    $.post(url,formData,function(msg)
    {
        if(msg.status == 1)
        {
            return dialog.success(msg.message,msg['data']['jump_url']);
        }
        if(msg.status == 0)
        {
            return dialog.error(msg.message,msg['data']['jump_url']);
        }
    },'JSON')
})
function todelete(url,data)
{
    $.post(
        url,
        data,
        function(s)
        {
            if(s.status == 1)
            {
             return dialog.success(s.message,'');
            }else{
             return dialog.error(s.message);
            }
        }
        ,'JSON'
    )
}

//全选反选
$("#singcms-checkbox-all").on('click',function()
{
    if(this.checked)
    {
       $("input[name='pushcheck']").prop('checked',true);
    }else{
       $("input[name='pushcheck']").prop('checked',false);
    }

})


//ajax分页
//需要获取当前页面的的页码
$(".page a").on('click',function()
{
    var pageObj = this;
    var pageUrl = pageObj.href;
    console.log(pageUrl);
    $.ajax({
        type:'get',
        url:pageUrl,
        success:function(res)
        {
//          console.log(res);return;
            $(".pagess").html('');
            $(".pagess").html(res);
        }
    })
    return false;
})


//**
$(".pages a").on('click',function()
{
    var pageObj = this;
    var pageUrl = pageObj.href;
    console.log(pageUrl);
    $.ajax({
        type:'get',
        url:pageUrl,
        success:function(res)
        {
            console.log(res['news']);
            var obj = res['news'];
            var str="";
               for(var i in obj)
               {

                   str+="<dl>";
                   str+="<dt>"+obj[i]['title']+"</dt>";
                   str+="<dd class='news-img'><a href='./index.php?c=detail&id="+obj[i]['news_id']+"'><img width='200' height='120' src='"+obj[i]['thumb']+"' alt="+obj[i]['title']+"></a></dd>";
                   str+="<dd class='news-intro'>"+obj[i]['description']+"</dd>";
                   str+="<dd class='news-info'>"+obj[i]['keywords']+"<span>"+obj[i]['create_time']+"</span> 阅读("+obj[i]['count']+")</dd>";
                   str+="</dl>";
               }
            console.log(str);
            $(".news-list").html('');
            $(".news-list").html(str);
            //$(".pages").html('');
            //$(".pages").html(res['show']);

        }
    })
    return false;
})
//推送功能
$("#singcms-push").on('click',function()
{
    var id = $("#select-push").val();

    if(id == 0)
    {
        return dialog.error('请选择推荐位');
    }
    pushu = {};
    dataPost ={};
    $("input[name='pushcheck']:checked").each(function(i)
    {
        pushu[i] = $(this).val();
    })

    dataPost['position_id'] = id;
    dataPost['pushu'] = pushu;
    var url = SCOPE.push_url;
    $.post(url,dataPost,function(res)
    {
        if(res.status == 1)
        {
            return dialog.success(res.message,res['data']['jump_url']);
        }else{
            return dialog.error(res.message);
        }
    },'JSON');

})

