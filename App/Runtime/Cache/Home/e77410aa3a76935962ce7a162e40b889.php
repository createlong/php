<?php if (!defined('THINK_PATH')) exit(); if(is_array($result['listNews'])): $i = 0; $__LIST__ = $result['listNews'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dl>
        <dt><?php echo ($vo["title"]); ?></dt>
        <dd class="news-img">
            <a href="./index.php?c=detail&id=<?php echo ($vo["news_id"]); ?>"><img width="200" height="120" src="<?php echo ($vo["thumb"]); ?>" alt="<?php echo ($vo["title"]); ?>"></a>
        </dd>
        <dd class="news-intro">
            <?php echo ($vo["description"]); ?>
        </dd>
        <dd class="news-info">
            <?php echo ($vo["keywords"]); ?> <span><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></span> 阅读(<?php echo ($vo["count"]); ?>)
        </dd>
    </dl><?php endforeach; endif; else: echo "" ;endif; ?>
<div class="page">
    <?php echo ($result['newsShow']); ?>
</div>