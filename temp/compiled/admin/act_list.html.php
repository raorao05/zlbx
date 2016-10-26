<?php echo $this->fetch('pageheader.htm'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'../js/utils.js,listtable.js')); ?>
<div class="list-div" id="listDiv">
    <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
        <tr>
            <th>活动名称</th>
            <th>活动状态</th>
            <th>参与类型</th>
            <th>参与次数</th>
            <th>兑奖截止</th>
            <th>操作</th>
        </tr>
        <?php $_from = $this->_var['actList']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'act');if (count($_from)):
    foreach ($_from AS $this->_var['act']):
?>
        <tr align="center">
            <td><?php echo $this->_var['act']['title']; ?></td>
            <td><?php if ($this->_var['act']['isopen'] == 1): ?>进行中<?php else: ?>已停止<?php endif; ?></td>
            <td><?php if ($this->_var['act']['type'] == 1): ?>每日<?php else: ?>长期<?php endif; ?></td>
            <td><?php echo $this->_var['act']['num']; ?></td>
            <td><?php echo $this->_var['act']['overymd']; ?></td>
            <td><a href="weixin_egg.php?act=list&aid=<?php echo $this->_var['act']['aid']; ?>"><?php echo $this->_var['lang']['edit']; ?></a> | <a href="weixin_egg.php?act=listall&aid=<?php echo $this->_var['act']['aid']; ?>">查看奖项</a> | <a href="weixin_egg.php?act=add&aid=<?php echo $this->_var['act']['aid']; ?>">添加奖项</a></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
</div>
<?php echo $this->fetch('pagefooter.htm'); ?>