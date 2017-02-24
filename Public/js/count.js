/**
 * Created by Administrator on 2016/1/24.
 * 计数器
 */
var newsIds = {};
$(".news_count").each(function(i)
{
    newsIds[i] = $(this).attr('news-id');
    url = './index.php?c=index&a=getCount';
    $.post(url,newsIds,function(res)
    {
        if(res.status == 1)
        {
            counts =  res.data;
            $.each(counts,function(news_id,count)
            {
                $(".node-"+news_id).html(count);
            })
        }
    },'JSON')
})

